<?php

namespace App\Domain\Order\Controllers;

use App\Domain\Api\Model\Api;
use App\Domain\Order\Models\Order;
use App\Domain\Order\Models\OrderDB;
use App\Domain\Order\Models\OrderDtDB;
use App\Domain\Order\Models\OrderDtModel;
use App\Domain\Product\Models\Product_dt;
use App\Domain\Products\Models\products;
use App\Domain\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Midtrans\Snap;
use Midtrans\Config;

class OrderController extends Controller
{
    private string $order_code;

    public function __construct()
    {
        // middleware auth for createTransaction and handleNotification
        $this->order_code = 'ORDER-' . Str::uuid();
    }
    // constractor


    public function createTokenMidtrans(Request $request)
    {
        $creby   = null;
        $snapToken = null;
        $errorResponse = null;

        $request->validate([
            'product_id'   => 'required|exists:ms_product_dt,id',
            'no_handphone' => Rule::requiredIf($request->category == 'Pulsa & Data'),
            'username'     => Rule::requiredIf($request->category === 'Games'),
        ]);

        DB::transaction(function () use ($request, &$snapToken, &$creby, &$errorResponse) {
            $product = Product_dt::where("id", $request->input('product_id'))->lockForUpdate()->first();

            if (!$product) {
                $errorResponse = response()->json(['error' => 'Product not found'], 404);
                return;
            }

            if ($product->start_cut_off != '00:00:00' && strtotime($product->end_cut_off) < strtotime(date('H:i:s'))) {
                $errorResponse = response()->json(['error' => 'Product is not available'], 400);
                return;
            }

            if ($product->stock <= 0 && $product->unlimited_stock != 1) {
                $errorResponse = response()->json(['error' => 'Product is out of stock'], 400);
                return;
            }

            if ($product->buyer_product_status != 1 && $product->seller_product_status != 1) {
                $errorResponse = response()->json(['error' => 'Product is not active'], 400);
                return;
            }

            if ($product->start_cut_off != '00:00:00' && strtotime($product->start_cut_off) > strtotime(date('H:i:s'))) {
                $errorResponse = response()->json(['error' => 'Product is not available yet'], 400);
                return;
            }

            if ($product->buyer_product_status != 1 || $product->seller_product_status != 1) {
                $errorResponse = response()->json(['error' => 'Product is temporarily unavailable'], 400);
                return;
            }

            switch ($product->category) {
                case 'Games':
                    $creby = $request->input('user_id') . '-' . $request->input('zone_id') . '-' . $request->input('username');
                    break;
                case 'Pulsa & Data':
                    $creby = $request->input('no_handphone');
                    break;
                case 'Voucher':
                    $creby = $request->input('whatsapp');
                    break;
                case 'Tagihan':
                    $creby = $request->input('no_akun');
                    break;
                default:
                    $creby = $request->input('user_id') ?? 'guest';
                    break;
            };

            $api = Api::select('midtrans_server_key', 'midtrans_client_key')->first();
            if (!$api) {
                $errorResponse = response()->json(['error' => 'Midtrans API keys not configured'], 500);
                return;
            }

            Config::$serverKey = $api->midtrans_server_key;
            Config::$clientKey = $api->midtrans_client_key;
            Config::$isProduction = false;
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => 'DPX-' . Str::uuid(),
                    'gross_amount' => (int) $product->price,
                ],
                'customer_details' => [
                    'first_name' => $creby,
                    'email' => $request->input('email') ?? 'guest@dpxstore.com',
                ]
            ];

            $snapToken = Snap::getSnapToken($params);

            if (!$snapToken) {
                $errorResponse = response()->json(['error' => 'Failed to generate Snap token'], 500);
                return;
            }
        });

        if ($errorResponse) {
            return $errorResponse;
        }

        return response()->json(['snapToken' => $snapToken]);
    }

    // public function createTransaction(Request $request)
    // {

    //     $creby   = null;
    //     $insert  = null;

    //     $request->validate([
    //         'product_id'   => 'required|exists:ms_product_dt,id',
    //         'no_handphone' => Rule::requiredIf(in_array($request->category, ['Pulsa', 'Data'])),
    //         'username'     => Rule::requiredIf($request->category === 'Games'),
    //     ]);


    //     $user_id           = $request->input('user_id');
    //     $zone_id           = $request->input('zone_id');
    //     $no_handphone      = $request->input('no_handphone');
    //     $no_akun           = $request->input('no_akun');
    //     $username          = $request->input('username');
    //     $voucher_code      = $request->input('voucher_code');
    //     $whatsapp          = $request->input('whatsapp');
    //     $product_id        = $request->input('product_id');



    //     DB::transaction(
    //         function () use ($request, &$price, &$creby, &$insert) {
    //             $product = Product_dt::where("id", $request->input('product_id'))->lockForUpdate()->first();


    //             if (!$product) {
    //                 return response()->json(['error' => 'Product not found'], 404);
    //             }

    //             if (strtotime($product->end_cut_off) < strtotime(date('H:i:s'))) {
    //                 return response()->json(['error' => 'Product is not available'], 400);
    //             }

    //             if ($product->stock <= 0) {
    //                 return response()->json(['error' => 'Product is out of stock'], 400);
    //             }

    //             if ($product->status !== 'active') {
    //                 return response()->json(['error' => 'Product is not active'], 400);
    //             }

    //             if (strtotime($product->start_cut_off) > strtotime(date('H:i:s'))) {
    //                 return response()->json(['error' => 'Product is not available yet'], 400);
    //             }

    //             if ($product->buyer_product_status != 1) {
    //                 return response()->json(['error' => 'Product is temporarily unavailable'], 400);
    //             }

    //             if ($product->seller_product_status != 1) {
    //                 return response()->json(['error' => 'Product is temporarily unavailable'], 400);
    //             }

    //             $creby = '';
    //             switch ($product->category) {
    //                 case 'Games':
    //                     $creby = $request->input('user_id') . '-' . $request->input('zone_id') . '-' . $request->input('username');
    //                     break;
    //                 case 'Pulsa & Data':
    //                     $creby = $request->input('no_handphone');
    //                     break;
    //                 case 'Voucher':
    //                     $creby = $request->input('whatsapp');
    //                     break;
    //                 case 'Tagihan':
    //                     $creby = $request->input('no_akun');
    //                     break;
    //                 default:
    //                     $creby = $request->input('user_id') . '-';
    //                     break;
    //             };



    //             $insert = OrderDB::create([
    //                 'order_code' => $this->order_code,
    //                 'price' => $product->price,
    //                 'status' => 'pending',
    //                 'start_process' => date('Y-m-d H:i:s'),
    //                 'isvoucher' => $request->input('username') ? 1 : 0,
    //                 'creby' => $creby,
    //                 'cretime' => date('Y-m-d H:i:s')
    //             ]);

    //             if (!$insert) {
    //                 return response()->json(['error' => 'Failed to create order'], 500);
    //             }

    //             OrderDtDB::create([
    //                 'order_id' => $insert->id,
    //                 'category_id' => $product->category_id,
    //                 'product_id' => $product->product_id,
    //                 'user_id' => $request->input('user_id'),
    //                 'zone_id' => $request->input('zone_id'),
    //                 'username' => $request->input('username'),
    //                 'no_handphone' => $request->input('no_handphone'),
    //                 'no_akun' => $request->input('no_akun'),
    //                 'kode_voucher' => $request->input('username'),
    //                 'whatsapp' => $request->input('whatsapp'),
    //                 'creby' => $creby,
    //                 'cretime' => date('Y-m-d H:i:s')
    //             ]);
    //         }
    //     );
    //     $product = Product_dt::where("id", $request->input('product_id'))->select("price")->first();
    //     $api = Api::select('midtrans_server_key', 'midtrans_client_key')->first();

    //     Config::$serverKey = $api->midtrans_server_key;
    //     Config::$clientKey = $api->midtrans_client_key;
    //     Config::$isProduction = false;
    //     Config::$isSanitized = true;
    //     Config::$is3ds = true;

    //     $params = [
    //         'transaction_details' => [
    //             'order_id' => $this->order_code,
    //             'gross_amount' => $product->price,
    //         ],
    //         'customer_details' => [
    //             'first_name' => $creby,
    //             'email' => 'dpxstore@gmail.com',
    //         ]
    //     ];

    //     $snapToken = Snap::getSnapToken($params);

    //     return response()->json(['snapToken' => $snapToken]);
    // }

    public function handleNotification(Request $request)
    {
        $notif = new \Midtrans\Notification();

        dd($notif);

        $order = OrderDB::where('order_id', $notif->order_id)->first();

        if (!$order) {
            Log::warning("Order not found: " . $notif->order_id);
            return response()->json(['message' => 'Order not found'], 404);
        }


        if ($notif->transaction_status == 'settlement') {
            // Order dibayar, kirim ke Digiflazz
            $this->orderToDigiflazz($order);

            $order->update(['status' => 'paid']);
        } elseif ($notif->transaction_status == 'expire') {
            $order->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'OK']);
    }

    public function orderToDigiflazz($order)
    {
        $apis = Api::select('digiflazz_username', 'digiflazz_api_key')->first();

        $sign = md5($apis->digiflazz_username . $apis->digiflazz_api_key . $order->customer_number);

        $response = Http::post('https://api.digiflazz.com/v1/transaction', [
            'username' => $apis->digiflazz_username,
            'buyer_sku_code' => $order->product_code,
            'customer_no' => $order->customer_number,
            'ref_id' => $order->order_id,
            'sign' => $sign,
        ]);

        $data = $response->json();

        if ($data['data']['status'] != 'Pending') {
            // gagal kirim order
            $order->update(['status' => 'digiflazz_failed']);
            Log::error('Digiflazz error', $data);
        }
        // bisa simpan response-nya di DB kalau mau
    }
}
