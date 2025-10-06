<?php

use App\Domain\Admin\Models\Admin;
use App\Domain\User\Models\User;

// config/auth.php
return [
    'defaults' => [
        'guard' => 'admin',         // default guard jadi admin
        'passwords' => 'admins',
    ],
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => User::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model'  => Admin::class,
        ],
    ],
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table' => 'admin_password_reset_tokens',
            'expire' => 60,
        ],
    ],
];
