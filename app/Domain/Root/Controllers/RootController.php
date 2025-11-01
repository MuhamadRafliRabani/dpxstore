<?php

namespace App\Domain\Root\Controllers;

use App\Domain\Banner\Models\Banner;
use App\Domain\Category\Models\Category;
use App\Domain\Product\Models\ProductFavorite;
use App\Domain\Product\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RootController extends Controller
{
    public function index()
    {

        $product_populer = ProductFavorite::with('product:id,name,slug,image,publisher,category_id')->get();

        $banners = Cache::remember('banners', $this->ttl, fn() => Banner::select(['id', 'image', 'status'])->get());

        return inertia('Page', [
            'configuration' => $this->getConfiguration(),
            'product_populer' => $product_populer,
            'banners' => $banners,
            'categories' => $this->getCategories(),
            'show' => true
        ]);
    }

    public function getDataProducts(Request  $request)
    {
        $categoryId = $request->query('category', 1);
        $page = $request->query('page', 1);

        if ($categoryId == 0) {
            $categoryId = 1;
        };

        return $this->getProducts($categoryId, $page);
    }

    public function listHarga(Request $request)
    {
        $page = $request->query('page', 1);

        // handle product
        $product = Cache::remember(
            "list_harga_page_{$page}",
            $this->ttl, // 15 menit
            fn() => Product::where('status', 1)
                ->whereHas('product_item')
                ->select('id', 'name', 'code', 'image')
                ->with('product_item:brand,product_name,buyer_sku_code,category,price,start_cut_off,end_cut_off,desc')
                ->simplePaginate(10)
                ->withQueryString()
        );

        $config = $this->getConfiguration();

        return inertia('information/list-harga', [
            'title' => 'Daftar Harga TopUp Diamond, Pulsa & Kuota Termurah',
            'description' => 'Lihat daftar harga terbaru untuk diamond game, pulsa, kuota internet, dan voucher di ' . $config['website'] . '.' . ' Dapatkan top up cepat, aman, dan harga terbaik sekarang juga!',
            'products' => $product,
            'configuration' => $config,
            'categories' => $this->getCategories()
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
