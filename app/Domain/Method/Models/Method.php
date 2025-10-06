<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Method
 * 
 * @property int $id
 * @property string $method
 * @property string $image
 * @property string $uniq
 * @property string $provider
 * @property string $code
 * @property string $rek
 * @property string $instruksi
 * @property string $status
 * @property string $type
 *
 * @package App\Models
 */
class Method extends Model
{
	protected $table = 'method';
	public $timestamps = false;

	protected $fillable = [
		'method',
		'image',
		'uniq',
		'provider',
		'code',
		'rek',
		'instruksi',
		'status',
		'type'
	];
}
