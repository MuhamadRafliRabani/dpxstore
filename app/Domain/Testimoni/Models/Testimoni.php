<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Testimoni
 * 
 * @property int $id
 * @property string $testimoni
 * @property string $image
 *
 * @package App\Models
 */
class Testimoni extends Model
{
	protected $table = 'testimoni';
	public $timestamps = false;

	protected $fillable = [
		'testimoni',
		'image'
	];
}
