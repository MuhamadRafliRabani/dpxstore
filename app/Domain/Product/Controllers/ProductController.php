<?php

namespace App\Domain\Product\Controllers;

use App\Domain\Api\Model\Api;
use App\Domain\Product\Models\Product_dt;
use App\Domain\Product\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{

    public function index(string $category, string $gamesSlug)
    {

        $product = Product::select('id', 'name', 'image', 'publisher', 'full_input')->where('slug', $gamesSlug)->firstOrFail();

        $product_dt = Product_dt::select(['id', 'product_name', 'price'])
            ->where('brand', strtoupper($product['name']))
            ->get();

        return inertia('product/Show', [
            'category' => $category,
            'categories' => $this->getCategories(),
            'product_dt' => $product_dt,
            'product' => $product,
            'configuration' => $this->getConfiguration(),
        ]);
    }

    // public function syncProductDigiflazz()
    // {
    //     $error = '';
    //     try {
    //         $api = Api::select('digiflazz_username', 'digiflazz_api_key')->first();

    //         if (!$api) {
    //             $error = response()->json([
    //                 'success' => false,
    //                 'message' => 'API data tidak ditemukan',
    //             ], 404);
    //             return;
    //         }

    //         $username   = $api['digiflazz_username'];
    //         $apiKey   = $api['digiflazz_api_key'];

    //         $cmd = 'prepaid';
    //         $sign = md5($username . $apiKey . 'pricelist');

    //         $response = Http::post(
    //             'https://api.digiflazz.com/v1/price-list',
    //             [
    //                 'cmd' => $cmd,
    //                 'username' => $username,
    //                 'sign' => $sign,
    //             ]
    //         );


    //         if ($response->failed()) {
    //             Notification::make()
    //                 ->title('Gagal Koneksi')
    //                 ->body('Tidak dapat terhubung ke server Digiflazz. Status: ' . $response->status())
    //                 ->danger()
    //                 ->send();
    //             return back();
    //         }

    //         $data = $response->json('data');
    //         if (!is_array($data)) {
    //             Notification::make()
    //                 ->title('Format Tidak Valid')
    //                 ->body('Response dari Digiflazz tidak sesuai format.')
    //                 ->danger()
    //                 ->send();
    //             return back();
    //         }

    //         if (!empty($error)) {
    //             return $error;
    //         }

    //         foreach ($data as $item) {
    //             if (empty($item['brand'])) {
    //                 Log::warning('Item skipped: missing Brand', $item);
    //                 continue;
    //             }

    //             Product_dt::updateOrCreate(
    //                 ['brand' => $item['brand']],
    //                 [
    //                     'product_name'            => $item['product_name'],
    //                     'category'                => $item['category'],
    //                     'brand'                   => $item['brand'],
    //                     'type'                    => $item['type'],
    //                     'seller_name'             => $item['seller_name'] ?? null,
    //                     'price'                   => $item['price'],
    //                     'buyer_sku_code'          => $item['buyer_sku_code'],
    //                     'buyer_product_status'    => $item['buyer_product_status'],
    //                     'seller_product_status'   => $item['seller_product_status'],
    //                     'unlimited_stock'         => $item['unlimited_stock'],
    //                     'stock'                   => $item['stock'],
    //                     'multi'                   => $item['multi'],
    //                     'start_cut_off'           => $item['start_cut_off'],
    //                     'end_cut_off'             => $item['end_cut_off'],
    //                     'desc'                    => $item['desc'],
    //                 ]
    //             );
    //         }

    //         Notification::make()
    //             ->title('Sinkronisasi Berhasil')
    //             ->body('Produk Digiflazz berhasil disinkronkan.')
    //             ->success()
    //             ->send();
    //     } catch (\Throwable $th) {
    //         Log::error('Error sync Digiflazz: ' . $th->getMessage());

    //         Notification::make()
    //             ->title('Terjadi Kesalahan')
    //             ->body('Error: ' . $th->getMessage())
    //             ->danger()
    //             ->send();
    //     }
    //     return back();
    // }

    // public function checkUsername(Request $request)
    // {
    //     $request->validate([
    //         'user_id'   => 'required|string|max:255',
    //         'zone_id'   => 'required|string|max:255',

    //     ]);

    //     $api = Api::select('apigames_secret', 'apigames_merchant_id')->first();
    //     if (!$api) return response()->json(['success' => false, 'message' => 'API data tidak ditemukan'], 404);


    //     $merchant   = $api['apigames_merchant_id'];
    //     $secret     = $api['apigames_secret'];
    //     $gameCode   = $request->game_code;
    //     $sig = md5($merchant . $secret);
    //     $userIdFormatted = $request->user_id . '(' . $request->zone_id . ')';

    //     $url = "https://v1.apigames.id/merchant/M250706VICX9741YY/cek-username/mobilelegend?user_id={$userIdFormatted}&signature=69612f60828c50c4e1827d4b8e6fec64";

    //     try {
    //         $response = Http::get($url);

    //         if ($response->successful()) {
    //             return response()->json([
    //                 'success'  => true,
    //                 'message'  => 'Username valid.',
    //                 'response' => $response->json(),
    //                 'url'      => $url
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Gagal memverifikasi username.',
    //                 'error'   => $response->json(),
    //                 'url' => $url
    //             ], $response->status());
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error saat request ke API.',
    //             'error'   => $e->getMessage(),
    //         ], 500);
    //     }
    // }
}
