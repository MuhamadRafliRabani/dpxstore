<?php

/**
 * Created by Reliese Model.
 */

namespace App\Domain\Order\Models;

use App\Domain\Category\Models\Category;
use App\Domain\Product\Models\Product;
use App\Domain\Root\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 *
 * @package App\Models
 */
class OrderDtDB extends Model
{
  use HasFactory;

  protected $table = 'tr_order_dt';

  public $timestamps = false;


  protected $guarded = [];

  public function order()
  {
    return $this->belongsTo(OrderDB::class, 'order_id');
  }

  public function voucher()
  {
    return $this->belongsTo(Voucher::class, 'voucher_id');
  }

  public function category()
  {
    return $this->belongsTo(Category::class, 'category_id');
  }

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }
}
