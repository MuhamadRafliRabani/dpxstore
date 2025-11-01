<?php

namespace App\Filament\Resources\ProductItemsResource\Pages;

use App\Domain\Api\Model\Api;
use App\Domain\Product\Models\Product_dt;
use App\Filament\Resources\ProductItemsResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\SyncAction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ListProductItems extends ListRecords
{
    protected static string $resource = ProductItemsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Action::make('sync')
                ->label('Sync')
                ->icon('heroicon-m-cloud-arrow-down')
                ->requiresConfirmation()
                ->modalHeading('Sinkronisasi Produk')
                ->modalDescription('Proses ini akan memperbarui data produk dari Digiflazz.')
                ->action(function () {
                    $api = Api::select('digiflazz_username', 'digiflazz_api_key')->first();

                    if (!$api) {
                        $error = response()->json([
                            'success' => false,
                            'message' => 'API data tidak ditemukan',
                        ], 404);
                        return;
                    }

                    $username   = $api['digiflazz_username'];
                    $apiKey   = $api['digiflazz_api_key'];

                    $cmd = 'prepaid';
                    $sign = md5($username . $apiKey . 'pricelist');

                    $response = Http::post(
                        'https://api.digiflazz.com/v1/price-list',
                        [
                            'cmd' => $cmd,
                            'username' => $username,
                            'sign' => $sign,
                        ]
                    );


                    if ($response->failed()) {
                        Notification::make()
                            ->title('Gagal Koneksi')
                            ->body('Tidak dapat terhubung ke server Digiflazz. Status: ' . $response->status())
                            ->danger()
                            ->send();
                        return back();
                    }

                    $data = $response->json('data');
                    if (!is_array($data)) {
                        Notification::make()
                            ->title('Format Tidak Valid')
                            ->body('Response dari Digiflazz tidak sesuai format.')
                            ->danger()
                            ->send();
                        return back();
                    }

                    if (!empty($error)) {
                        return $error;
                    }

                    foreach ($data as $item) {
                        if (empty($item['brand'])) {
                            Log::warning('Item skipped: missing Brand', $item);
                            continue;
                        }

                        Product_dt::updateOrCreate(
                            ['brand' => $item['brand']],
                            [
                                'product_name'            => $item['product_name'],
                                'category'                => $item['category'],
                                'brand'                   => $item['brand'],
                                'type'                    => $item['type'],
                                'seller_name'             => $item['seller_name'] ?? null,
                                'price'                   => $item['price'],
                                'buyer_sku_code'          => $item['buyer_sku_code'],
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

                    Notification::make()
                        ->title('Sinkronisasi Berhasil')
                        ->body('Produk Digiflazz berhasil disinkronkan.')
                        ->success()
                        ->send();
                })
        ];
    }
}
