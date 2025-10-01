<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Topup
 * 
 * @property int $id
 * @property string $topup_id
 * @property string $username
 * @property int $method_id
 * @property string $method
 * @property int $amount
 * @property string $status
 * @property string $payment_code
 * @property Carbon $date_create
 * @property string|null $payment_type
 * @property string $method_code
 * @property string $payment_gateway
 *
 * @package App\Models
 */
class Topup extends Model
{
	protected $table = 'topup';
	public $timestamps = false;

	protected $casts = [
		'method_id' => 'int',
		'amount' => 'int',
		'date_create' => 'datetime'
	];

	protected $fillable = [
		'topup_id',
		'username',
		'method_id',
		'method',
		'amount',
		'status',
		'payment_code',
		'date_create',
		'payment_type',
		'method_code',
		'payment_gateway'
	];
}
