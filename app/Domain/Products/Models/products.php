<?php

/**
 * Created by Reliese Model.
 */

namespace App\Domain\Products\Models;

use App\Domain\Category\Models\Category;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Game
 * 
 * @property int $id
 * @property string $games
 * @property string $category
 * @property string $image
 * @property string $slug
 * @property string $target
 * @property int $sort
 * @property string $content
 * @property string $status
 * @property string $check_status
 * @property string $check_code
 * @property string $code
 * @property string $provider
 *
 * @package App\Models
 */
class products extends Model
{
	protected $table = 'ms_products';
	public $timestamps = false;


	protected $fillable = [
		'name',
		'category_id',
		'image',
		'slug',
		'title',
		'description',
		'status',
		'check_code',
		'code',
		'provider',
		'publisher',
	];

	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id');
	}
}
