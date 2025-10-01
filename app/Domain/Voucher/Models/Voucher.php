<?php

/**
 * Created by Reliese Model.
 */

namespace App\Domain\Voucher\Models;

use App\Domain\Products\Models\products;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Voucher
 * 
 * @property int $id
 * @property string $voucher
 * @property int $diskon
 * @property int $min
 * @property int $max_diskon
 * @property int $max_use
 * @property string $type_produk
 * @property string $produk
 * @property string $status
 * @property Carbon $date_create
 *
 * @package App\Models
 */
class Voucher extends Model
{
	protected $table = 'vouchers';
	public $timestamps = false;

	protected $casts = [
		'discount_value' => 'int',
		'max_discount' => 'int',
		'usage_limit' => 'int',
		'date_create' => 'datetime'
	];

	protected $guarded = [];

	public function games()
	{
		return $this->belongsTo(products::class, 'game_id');
	}
}
