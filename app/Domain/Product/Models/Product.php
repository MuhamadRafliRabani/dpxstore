<?php

/**
 * Created by Reliese Model.
 */

namespace App\Domain\Product\Models;

use App\Domain\Category\Models\Category;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 
 */
class Product extends Model
{
	protected $table = 'ms_products';
	public $timestamps = false;

	// protected $casts = [
	// ];

	protected $guarded = [];

	public function product_item()
	{
		return $this->hasMany(Product_dt::class, 'brand', 'code');
	}

	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id');
	}
}
