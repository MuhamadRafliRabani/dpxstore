<?php

/**
 * Created by Reliese Model.
 */

namespace App\Domain\User\Models;

use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * 
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int $balance
 * @property string $wa
 * @property string $status
 * @property Carbon $date_create
 * @property string $ref
 * @property string $ref_by
 * @property string $level
 *
 * @package App\Models
 */
class User extends Authenticatable implements FilamentUser
{
	use HasApiTokens, Notifiable;
	protected $table = 'users';
	public $timestamps = false;

	protected $casts = [
		'balance' => 'int',
		'date_create' => 'datetime'
	];

	protected $hidden = [
		'password'
	];

	protected $guarded = [];

	public function canAccessPanel(\Filament\Panel $panel): bool
	{
		// Sesuaikan logika akses sesuai kebutuhan Anda
		return true;
	}
}
