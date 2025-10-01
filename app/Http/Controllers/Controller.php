<?php

namespace App\Http\Controllers;

use App\Domain\Configuration\Model\Configuration;
use Illuminate\Support\Facades\Cache;
use Str;

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
}
