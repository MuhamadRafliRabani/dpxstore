<?php

/**
 * Created by Reliese Model.
 */

namespace App\Domain\Order\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
