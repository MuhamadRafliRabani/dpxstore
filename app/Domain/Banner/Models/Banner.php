<?php

/**
 * Created by Reliese Model.
 */

namespace App\Domain\Banner\Models;

use App\Domain\Configuration\Model\Configuration;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 * 
 * @property int $id
 * @property string $image
 *
 * @package App\Models
 */
class Banner extends Model
{
	protected $table = 'ms_banners';
	public $timestamps = false;

	protected $fillable = [
		'image',
		'configuration_id',
		'title',
		'url',
		'status',
		'type',
		'sort_order'
	];

	public function configuration()
	{
		return $this->belongsTo(Configuration::class, 'configuration_id');
	}
}
