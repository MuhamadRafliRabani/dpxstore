<?php

namespace App\Console\Commands;

use App\Domain\Api\Model\Api;
use App\Domain\Product_Digiflazz\models\ProductDigiflazz;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncDigiflazzProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-digiflazz-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil kredensial dari DB
        $api = Api::select('digiflazz_username', 'digiflazz_api_key')->first();
        if (!$api) return response()->json(['success' => false, 'message' => 'API data tidak ditemukan'], 404);


        $username   = $api['digiflazz_username'];
        $apiKey   = $api['digiflazz_api_key'];

        $cmd = 'prepaid';
        $sign = md5($username . $apiKey . 'pricelist');

        $response = Http::post('https://api.digiflazz.com/v1/price-list', [
            'cmd' => $cmd,
            'username' => $username,
            'sign' => $sign,
        ]);

        if ($response->failed()) {
            $this->error('Gagal koneksi ke Digiflazz: ' . $response->status());
            return;
        }

        $data = $response->json('data');
        if (!is_array($data)) {
            $this->error('Format response tidak valid');
            return;
        }

        foreach ($data as $item) {
            ProductDigiflazz::updateOrCreate(
                ['buyer_sku_code' => $item['buyer_sku_code']],
                [
                    'product_name'            => $item['product_name'],
                    'category'                => $item['category'],
                    'brand'                   => $item['brand'],
                    'type'                    => $item['type'],
                    'seller_name'             => $item['seller_name'] ?? null,
                    'price'                   => $item['price'],
                    'buyer_product_status'    => $item['buyer_product_status'],
                    'seller_product_status'   => $item['seller_product_status'],
                    'unlimited_stock'         => $item['unlimited_stock'],
                    'stock'                   => $item['stock'],
                    'multi'                   => $item['multi'],
                    'start_cut_off'           => $item['start_cut_off'],
                    'end_cut_off'             => $item['end_cut_off'],
                    'desc'                    => $item['desc'],
                ]
            );
        }

        $this->info('Sinkron produk Digiflazz selesai! Total: ' . count($data));
    }
}
