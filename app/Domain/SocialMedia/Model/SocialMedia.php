<?php

namespace App\Domain\SocialMedia\Model;

use App\Domain\Configuration\Model\Configuration;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{

    protected $table = 'social_media';
    public $timestamps = false;

    protected $guarded = [];

    /**
     * Get the configuration that owns the social media.
     */
    public function configuration()
    {
        return $this->belongsTo(Configuration::class, 'configuration_id');
    }
}
