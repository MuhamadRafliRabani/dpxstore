<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Price
 * 
 * @property int $id
 * @property int $product_id
 * @property int $method_id
 * @property int $price
 * @property string $level
 *
 * @package App\Models
 */
class Price extends Model
{
	protected $table = 'price';
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'method_id' => 'int',
		'price' => 'int'
	];

	protected $fillable = [
		'product_id',
		'method_id',
		'price',
		'level'
	];
}
