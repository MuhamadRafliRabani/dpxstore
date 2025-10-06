<?php

/**
 * Created by Reliese Model.
 */

namespace App\Domain\Root\Models;

use App\Domain\Order\Models\OrderDtDB;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 
 */
class Voucher extends Model
{
  protected $table = 'ms_vouchers';
  public $timestamps = false;

  protected $guarded = [];

  // public function orderDt()
  // {
  //     return $this->hasMany(OrderDtDB::class, 'foreign_key', 'local_key');
  // }
}
