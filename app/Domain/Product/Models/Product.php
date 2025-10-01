<?php

/**
 * Created by Reliese Model.
 */

namespace App\Domain\Product\Models;

use App\Domain\Category\Models\Category;
use App\Domain\Products\Models\products;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * 
 * @property int $id
 * @property int $games_id
 * @property int $category_id
 * @property string $product
 * @property int $price
 * @property string $provider
 * @property string $sku
 * @property string $status
 * @property int $sort
 * @property string $check_status
 * @property string $check_code
 * @property int $price_silver
 * @property int $price_gold
 * @property string $image
 * @property int $min
 * @property int $max
 * @property int $raw_price
 *
 * @package App\Models
 */
class Product extends Model
{
	protected $table = 'product';
	public $timestamps = false;

	protected $casts = [
		'games_id' => 'int',
		'category_id' => 'int',
		'price' => 'int',
		'price_gold' => 'int',
		'raw_price' => 'int'
	];

	protected $guarded = [];

	public function games()
	{
		return $this->belongsTo(products::class, 'game_id');
	}

	public function categories()
	{
		return $this->belongsTo(Category::class, 'category_id');
	}
}
