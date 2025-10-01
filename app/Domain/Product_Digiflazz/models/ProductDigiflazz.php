<?php

namespace App\Domain\Product_Digiflazz\models;

use App\Domain\Category\Models\Category;
use App\Domain\Products\Models\products;
use Illuminate\Database\Eloquent\Model;

class ProductDigiflazz extends Model
{

    protected $table = 'product_digiflazz';

    protected $guarded = [];

    // ProductDigiflazz.php
    public function game()
    {
        return $this->belongsTo(products::class, 'brand', 'name');
    }


    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
