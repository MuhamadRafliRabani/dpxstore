<?php

namespace App\Http\Controllers;

use App\Domain\Api\Model\Api;
use App\Domain\Configuration\Model\Configuration;
use App\Domain\Product\Models\Product_dt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use function Pest\Laravel\json;

abstract class Controller
{

    protected $configuration;

    public function __construct()
    {
        $this->configuration = Cache::remember(
            'configuration',
            3600,
            fn() =>
            Configuration::select('website', 'logo', 'logo_header')->first()
        );
    }

    public function generateCode($prefix = 'DPX', $length = 8)
    {
        $randomString = Str::upper(Str::random($length - strlen($prefix)));
        return $prefix . $randomString;
    }
}
