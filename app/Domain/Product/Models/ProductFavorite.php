<?php

namespace App\Domain\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFavorite extends Model
{
  protected $table = 'ms_product_populer';
  public $timestamps = false;

  protected $guarded = [];

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }
}
