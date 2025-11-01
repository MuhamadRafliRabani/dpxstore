<?php

namespace App\Domain\Order\Controllers;

use App\Domain\Api\Model\Api;
use App\Domain\Category\Models\Category;
use App\Domain\Configuration\Model\Configuration;
use App\Domain\Order\Models\OrderDB;
use App\Domain\Order\Models\OrderDtDB;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Models\Product_dt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        $code = '';
        do {
            $code = 'ORD' . strtoupper(Str::random(2)) . mt_rand(1000, 9999);
        } while (OrderDB::where('order_code', $code)->exists());

        $this->order_code = $code;
    }
    // constractor

    public function createTokenMidtrans($creby, $price, $order_code)
    {
        $snapToken = null;
        $errorResponse = null;

        // $product = Product_dt::where("id", $request->input('product_id'))->lockForUpdate()->first();

        // if (!$product) {
        //     $errorResponse = response()->json(['error' => 'Product not found'], 404);
        //     return;
        // }

        // if ($product->start_cut_off != '00:00:00' && strtotime($product->start_cut_off) < strtotime(date('H:i:s'))) {
        //     $errorResponse = response()->json(['error' => 'Product under maintenence '], 400);
        //     return;
        // }

        // if ($product->start_cut_off != '00:00:00' && strtotime($product->end_cut_off) > strtotime(date('H:i:s'))) {
        //     $errorResponse = response()->json(['error' => 'Product under maintenence '], 400);
        //     return;
        // }

        // if ($product->stock <= 0 && $product->unlimited_stock != 1) {
        //     $errorResponse = response()->json(['error' => 'Product is out of stock'], 400);
        //     return;
        // }

        // if ($product->buyer_product_status != 1 && $product->seller_product_status != 1) {
        //     $errorResponse = response()->json(['error' => 'Product is not active'], 400);
        //     return;
        // }

        // if ($product->buyer_product_status != 1 || $product->seller_product_status != 1) {
        //     $errorResponse = response()->json(['error' => 'Product is temporarily unavailable'], 400);
        //     return;
        // }

        // switch ($product->category) {
        //     case 'Games':
        //         $creby = $request->input('user_id') . '-' . $request->input('zone_id') . '-' . $request->input('username');
        //         break;
        //     case 'Pulsa & Data':
        //         $creby = $request->input('no_handphone');
        //         break;
        //     case 'Voucher':
        //         $creby = $request->input('whatsapp');
        //         break;
        //     case 'Tagihan':
        //         $creby = $request->input('no_akun');
        //         break;
        //     default:
        //         $creby = $request->input('user_id') ?? 'guest';
        //         break;
        // };

        $api = Api::select('midtrans_server_key', 'midtrans_client_key')->first();
        if (!$api) {
            $errorResponse = response()->json(['error' => 'Midtrans API keys not configured'], 500);
            return;
        }

        Config::$serverKey = $api->midtrans_server_key;
        Config::$clientKey = $api->midtrans_client_key;
        Config::$isProduction = true;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order_code,
                'gross_amount' => (int) $price,
            ],
            'customer_details' => [
                'first_name' => $creby,
                'email' => 'dpxstore@gmail.com',
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        if (!$snapToken) {
            $errorResponse = response()->json(['error' => 'Failed to generate Snap token'], 500);
            return;
        }

        if ($errorResponse) {
            return $errorResponse;
        }

        return response()->json(['snapToken' => $snapToken]);
    }

    public function checkout(Request $request)
    {

        $creby   = null;
        $insert  = null;
        $errorResponse = '';

        $request->validate([
            'product_id'   => 'required|exists:ms_product_dt,id',
            'no_handphone' => Rule::requiredIf($request->category == 'Pulsa & Data'),
            'username'     => Rule::requiredIf($request->category === 'Games'),
        ]);

        $product_dt = Product_dt::where("id", $request->input('product_id'))->lockForUpdate()->first();


        if (!$product_dt) {
            $errorResponse = response()->json(['error' => 'Product not found'], 404);
            return;
        }

        if ($product_dt->start_cut_off != '00:00:00' && strtotime($product_dt->start_cut_off) < strtotime(date('H:i:s'))) {
            $errorResponse = response()->json(['error' => 'Product under maintenence '], 400);
            return;
        }

        if ($product_dt->start_cut_off != '00:00:00' && strtotime($product_dt->end_cut_off) > strtotime(date('H:i:s'))) {
            $errorResponse = response()->json(['error' => 'Product under maintenence '], 400);
            return;
        }

        if ($product_dt->stock <= 0 && $product_dt->unlimited_stock != 1) {
            $errorResponse = response()->json(['error' => 'Product is out of stock'], 400);
            return;
        }

        if ($product_dt->buyer_product_status != 1 && $product_dt->seller_product_status != 1) {
            $errorResponse = response()->json(['error' => 'Product is not active'], 400);
            return;
        }

        if ($product_dt->buyer_product_status != 1 || $product_dt->seller_product_status != 1) {
            $errorResponse = response()->json(['error' => 'Product is temporarily unavailable'], 400);
            return;
        }

        $creby = '';
        switch ($product_dt->category) {
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
                $creby = $request->input('user_id') . '-';
                break;
        };

        $category_id = Product::where('code', $product_dt->brand)->value('category_id');

        if (!$category_id) {
            $errorResponse = response()->json(['error' => 'Product Category Not Found'], 400);
            return;
        }

        $insert = OrderDB::create([
            'order_code' => $this->order_code,
            'price' => $product_dt->price,
            'status' => 'pending',
            'start_process' => date('Y-m-d H:i:s'),
            'isvoucher' => $request->input('username') ? 1 : 0,
            'creby' => $creby,
            'cretime' => date('Y-m-d H:i:s')
        ]);

        if (!$insert) {
            return response()->json(['error' => 'Failed to create order'], 500);
        }

        OrderDtDB::create([
            'order_id' => $insert->id,
            'category_id' => $category_id,
            'product_id' => $product_dt->id,
            'voucher_id' => 0,
            'user_id' => $request->input('zone_id') ? $request->input('user_id') . '_' . $request->input('zone_id') : $request->input('user_id'),
            'username' => $request->input('username'),
            'no_handphone' => $request->input('no_handphone'),
            'no_akun' => $request->input('no_akun'),
            'whatsapp' => $request->input('whatsapp'),
            'creby' => $creby,
            'cretime' => date('Y-m-d H:i:s')
        ]);

        if ($errorResponse) {
            return $errorResponse;
        }


        return  $this->createTokenMidtrans($creby, $product_dt->price, $this->order_code);
    }

    public function handleNotification(Request $request)
    {
        if ($request->transaction_status != 'pending') {
            $buildPaymentType = $request->payment_type;
            switch ($request->payment_type) {
                case 'bank_transfer':
                    $buildPaymentType = $request->payment_type . '_' . isset($request->va_numbers[0]) ? $request->va_numbers[0]->bank : '';
                    break;
                case 'cstore':
                    $buildPaymentType = $request->store;
                    break;

                default:
                    $buildPaymentType = $request->payment_type;
                    break;
            }

            $order = OrderDB::where('order_code', $request->order_id)->firstOrFail();

            // harusnya kalo ga ada ordernya uangnya harus dibalikin || featurnya soon
            if (!$order) {
                return response()->json(['error' => 'order not found'], 404);
            }

            if ($order->status !== 'Paid') {
                $order->update([
                    'status' => 'Paid',
                    'end_process' => date('Y-m-d H:i:s'),
                    'payment_type' => $buildPaymentType,
                ]);
            }

            $orderDt = OrderDtDB::where('order_id', $order->id)->first();

            // harusnya kalo ga ada ordernya uangnya harus dibalikin || featurnya soon
            if (!$orderDt) {
                return response()->json(['error' => 'detail order not found'], 404);
            }

            return $this->orderToDigiflazz($orderDt);
        }
    }

    public function orderToDigiflazz($orderDt)
    {
        $apis = Api::select('digiflazz_username', 'digiflazz_api_key')->first();
        $product_item = Product_dt::where('id', $orderDt->product_id)->firstOrFail();

        // harusnya kalo ga ada ordernya uangnya harus dibalikin || featurnya soon
        if (!$orderDt) {
            return response()->json(['error' => 'detail order not found'], 404);
        }

        $sign = md5($apis->digiflazz_username . $apis->digiflazz_api_key . $this->order_code);

        $response = Http::post('https://api.digiflazz.com/v1/transaction', [
            'username' => $apis->digiflazz_username,
            'buyer_sku_code' => $product_item->buyer_sku_code,
            'customer_no' => $orderDt->whatsapp,
            'ref_id' => $this->order_code,
            'sign' => $sign,
        ]);

        $data = $response->json();

        $order = OrderDB::where('id', $orderDt->order_id)->firstOrFail();

        // harusnya kalo ga ada ordernya uangnya harus dibalikin || featurnya soon
        if (!$order) {
            return response()->json(['error' => 'order not found'], 404);
        }

        if ($data->status == 'Sukses') {
            $order->update(['status' => 'Success']);
            return response()->json(['error' => 'Buy product digiflazz success', $data], 200);
        }

        if ($data->status == 'Gagal') {
            // ksaih tau kalo gagal dan balikin uangnya
            $order->update(['status' => 'Fail']);
            return response()->json(['error' => 'Buy product digiflazz failde', $data], 500);
        }

        if ($data['data']['status'] != 'Pending') {
            // gagal kirim order
            $order->update(['status' => 'digiflazz_failed']);
            Log::error('Digiflazz error', $data);
            return response()->json(['error' => 'Buy product digiflazz error', $data], 500);
        }
        // bisa simpan response-nya di DB kalau mau
    }


    public function cekPesanan()
    {
        return inertia('information/cek-pesanan', [
            'title' => 'Cek Status Pesanan Kamu',
            'description' => 'Masukkan nomor pesanan untuk cek status pengiriman dan detail transaksi kamu di ' . 'dpxstore' . ' Proses cepat, aman, dan akurat.',
            'configuration' => $this->getConfiguration(),
            'categories' => $this->getCategories()
        ]);
    }

    public function getOrder(Request $request)
    {
        $product = '';

        $order_code = $request->order_code;

        $orders = OrderDB::where('order_code', $order_code)->with('order_detail')->get();

        if (isset($orders[0]->order_detail->product_id)) {
            $product = Product_dt::where('id', $orders[0]->order_detail->product_id)->select('product_name')->first();

            if ($product) {
                $orders[0]->order_detail->product_name = $product->product_name;
            }
        }

        if (!empty($orders)) {
            if (count($orders) != 0) {
                return $orders;
            } else {
                return null;
            }
        }
    }
}
