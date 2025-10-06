<?php

namespace App\Domain\Admin\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class Admin extends Authenticatable implements FilamentUser
{
    protected $table = 'admin';
    public $timestamps = false;

    protected $casts = [
        'date_create' => 'datetime',
        'password'    => 'hashed',
    ];

    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        'name',
        'password',
        'email',
        'status',
        'date_create',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        // Contoh: semua admin bisa akses
        return true;
    }
}
