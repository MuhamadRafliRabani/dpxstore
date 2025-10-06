<?php

namespace App\Domain\Configuration\Model;

use App\Domain\Banner\Models\Banner;
use App\Domain\SocialMedia\Model\SocialMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Configuration extends Model
{
    protected $table = 'st_configurations';
    public $timestamps = false;

    protected $fillable = [
        'website',
        'logo',
        'logo_header',
        'keywords',
        'description',
    ];

    /**
     * Relasi ke tabel banners.
     */
    public function banners()
    {
        return $this->hasMany(Banner::class);
    }

    /**
     * Relasi ke tabel social_media_links.
     */
    public function socialMedia()
    {
        return $this->hasMany(SocialMedia::class);
    }
}
