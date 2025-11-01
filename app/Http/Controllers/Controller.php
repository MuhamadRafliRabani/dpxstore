<?php

namespace App\Http\Controllers;

use App\Domain\Api\Model\Api;
use App\Domain\Category\Models\Category;
use App\Domain\Configuration\Model\Configuration;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Models\Product_dt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use function Pest\Laravel\json;

abstract class Controller
{

    protected $ttl;
    protected $configuration;

    public function __construct()
    {
        $this->ttl = config('constants.TTL');
    }

    public function generateCode($prefix = 'DPX', $length = 8)
    {
        $randomString = Str::upper(Str::random($length - strlen($prefix)));
        return $prefix . $randomString;
    }

    public function getProducts($categoryId, $page)
    {
        $products = Cache::remember(
            "category_{$categoryId}_page_{$page}",
            $this->ttl,
            fn() => Product::select(['id', 'name', 'slug', 'publisher', 'image', 'category_id', 'status'])
                ->where('status', '1')
                ->where('category_id', $categoryId)
                ->with('category:id,name')
                ->simplePaginate(15)
                ->withQueryString()
        );

        return $products;
    }

    public function getCategories()
    {
        $categories = Cache::remember('categories', $this->ttl, fn() => Category::all());

        return $categories;
    }

    public function getConfiguration()
    {
        // Jika sudah pernah diambil di request ini, langsung pakai ulang
        if ($this->configuration) {
            return $this->configuration;
        }

        // Kalau belum, ambil dari cache
        $this->configuration = Cache::remember(
            'configuration',
            $this->ttl,
            fn() => Configuration::select('website', 'logo', 'logo_header')->first()
        );

        return $this->configuration;
    }
}
