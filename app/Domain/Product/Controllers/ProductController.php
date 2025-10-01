<?php

namespace App\Domain\Product\Controllers;

use App\Domain\Configuration\Model\Configuration;
use App\Domain\Product\Models\Product_dt;
use App\Domain\Products\Models\products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{

    public function GetProductByGame(string $category, string $gamesSlug)
    {

        $product = products::select('id', 'name', 'image', 'publisher')->where('slug', $gamesSlug)->firstOrFail();

        $product_dt = Cache::remember(
            "products_for_game_{$gamesSlug}",
            3600,
            fn() =>
            Product_dt::select(['id', 'product_name', 'price'])
                ->where('brand', $product['name'])
                ->get()
        );

        $configuration = Cache::remember('configuration', 3600, function () {
            return Configuration::select('website', 'logo', 'logo_header')->first();
        });

        return inertia('product/Show', [
            'title' => "Top Up {$product['name']} Murah & Resmi",
            'description' => "Top up diamond {$product['name']} murah, cepat & aman di {$configuration['website']}. Harga kompetitif & langsung masuk—beli sekarang dan dominasi pertandingan!",
            'category' => $category,
            'product_dt' => $product_dt,
            'product' => $product,
            'configuration' => $configuration,
        ]);
    }
}
