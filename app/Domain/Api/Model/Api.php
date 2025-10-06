<?php

namespace App\Domain\Api\Model;

use App\Domain\Configuration\Model\Configuration;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    protected $table = 'st_api';

    public $timestamps = false;

    protected $fillable = [
        'midtrans_server_key',
        'midtrans_client_key',
        'digiflazz_username',
        'digiflazz_api_key',
        'apigames_secret',
        'apigames_merchant_id'
    ];

    public function configuration()
    {
        return $this->belongsTo(Configuration::class, 'configuration_id');
    }
}
