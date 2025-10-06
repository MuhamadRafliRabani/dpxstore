<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 * 
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string $category
 * @property string $content
 * @property Carbon $date_create
 *
 * @package App\Models
 */
class Post extends Model
{
	protected $table = 'post';
	public $timestamps = false;

	protected $casts = [
		'date_create' => 'datetime'
	];

	protected $fillable = [
		'title',
		'image',
		'category',
		'content',
		'date_create'
	];
}
