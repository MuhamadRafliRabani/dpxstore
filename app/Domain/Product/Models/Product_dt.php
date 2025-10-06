<?php

namespace App\Domain\Product\Models;

use App\Domain\Category\Models\Category;
use App\Domain\Products\Models\products;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_dt extends Model
{

  use HasFactory;
  public $timestamps = false;
  protected $table = 'ms_product_dt';

  protected $guarded = [];

  // ProductDigiflazz.php
  public function product()
  {
    return $this->belongsTo(ProductsModel::class, 'brand', 'name');
  }


  public function categories()
  {
    return $this->belongsTo(Category::class, 'category_id');
  }
}
