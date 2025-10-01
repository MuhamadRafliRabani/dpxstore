<?php

/**
 * Created by Reliese Model.
 */

namespace App\Domain\ProductPopuler\Models;

use App\Domain\Category\Models\Category;
use App\Domain\Products\Models\products;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProductPopuler
 * 
 * @property int $id
 * @property string $image
 * @property string $games_id
 * @property string $provider
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ProductPopuler extends Model
{
	protected $table = 'ms_product_populer';

	protected $fillable = [
		'game_id',
	];

	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	public function games(): BelongsTo
	{
		return $this->belongsTo(products::class, 'game_id');
	}
}
