<?php

namespace App\Domain\Root\Controllers;

use App\Domain\Banner\Models\Banner;
use App\Domain\Category\Models\Category;
use App\Domain\Product\Models\Product_dt;
use App\Domain\Product\Models\ProductFavorite;
use App\Domain\Product\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RootController extends Controller
{
    public function index(Request $request)
    {
        // handle categories
        $categoryId = $request->query('category', 1);
        $page = $request->query('page', 1);
        $ttl = 900;

        $categories = Cache::remember('categories', $ttl, fn() => Category::all());

        // handle games
        $products = Cache::remember(
            "games_cat_{$categoryId}_page_{$page}",
            $ttl,
            fn() => Product::select(['id', 'name', 'slug', 'publisher', 'image', 'category_id', 'status'])
                ->where('status', '1')
                ->where('category_id', $categoryId)
                ->with('category:id,name')
                ->simplePaginate(15)
                ->withQueryString()
        );

        // handle product populer
        $product_populer = ProductFavorite::with('product:id,name,slug,image,publisher')->get();

        $banners = Cache::remember('banners', $ttl, fn() => Banner::select(['id', 'image', 'status'])->get());

        if ($request->wantsJson()) {
            return $products;
        };

        return inertia('Page', [
            'configuration' => $this->configuration,
            'product_populer' => $product_populer,
            'banners' => $banners,
            'games' => $products,
            'categories' => $categories,
        ]);
    }


    public function listHarga()
    {
        // handle product
        $product =
            Product_dt::select([
                'product_name',
                'buyer_sku_code',
                'brand',
                'category',
                'price'
            ])->with(['product:id,name,image'])->get();


        // handle configuration

        return inertia('information/list-harga', [
            'title' => 'Daftar Harga TopUp Diamond, Pulsa & Kuota Termurah',
            'description' => 'Lihat daftar harga terbaru untuk diamond game, pulsa, kuota internet, dan voucher di ' . $this->configuration['website'] . '.' . ' Dapatkan top up cepat, aman, dan harga terbaik sekarang juga!',
            'products' => $product,
            'configuration' => $this->configuration
        ]);
    }


    public function cekPesanan()
    {

        Cache::put('configuration', $this->configuration, 3600);

        return inertia('information/cek-pesanan', [
            'title' => 'Cek Status Pesanan Kamu',
            'description' => 'Masukkan nomor pesanan untuk cek status pengiriman dan detail transaksi kamu di ' . $this->configuration['website'] . ' Proses cepat, aman, dan akurat.',
            'configuration' => $this->configuration
        ]);
    }

    public function search(Request $request)
    {
        $q = $request->query('q');

        return Product::where('name', 'like', "%$q%")
            ->select('id', 'name', 'slug', 'image', 'publisher', 'category_id')
            ->with('category:id,name')
            ->get();
    }
};
