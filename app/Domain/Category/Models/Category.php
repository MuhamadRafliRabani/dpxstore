<?php

/**
 * Created by Reliese Model.
 */

namespace App\Domain\Category\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $category
 * @property int $sort
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'ms_categories';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'title',
		'description'
	];
}
