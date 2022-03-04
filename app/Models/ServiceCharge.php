<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class ServiceCharge extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function activeCharge($type): Model|null
    {
        return self::query()
            ->where('type', $type)
            ->latest()->first('amount');
    }


}
