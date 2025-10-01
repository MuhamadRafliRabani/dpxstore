<?php

/**
 * Created by Reliese Model.
 */

namespace App\Domain\Order\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 *
 * @package App\Models
 */
class OrderDtDB extends Model
{
  protected $table = 'tr_order_dt';

  public $timestamps = false;


  protected $guarded = [];
}
