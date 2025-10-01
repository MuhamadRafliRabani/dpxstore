<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Mutasi
 * 
 * @property int $id
 * @property string $bank
 * @property string $keterangan
 * @property string $status
 * @property int $jumlah
 * @property int $saldo
 * @property Carbon $date_create
 *
 * @package App\Models
 */
class Mutasi extends Model
{
	protected $table = 'mutasi';
	public $timestamps = false;

	protected $casts = [
		'jumlah' => 'int',
		'saldo' => 'int',
		'date_create' => 'datetime'
	];

	protected $fillable = [
		'bank',
		'keterangan',
		'status',
		'jumlah',
		'saldo',
		'date_create'
	];
}
