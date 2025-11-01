<?php

/**
 * Created by Reliese Model.
 */

namespace App\Domain\Order\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Order
 * 
 *
 * @package App\Models
 */
class OrderDB extends Model
{
	use HasFactory;

	protected $table = 'tr_orders';

	public $timestamps = false;


	protected $guarded = [];

	public function order_detail()
	{
		return $this->hasOne(OrderDtDB::class, 'order_id');
	}
}
