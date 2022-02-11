<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(string[] $array)
 */
class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function admin(): HasMany
    {
        return $this->hasMany(Admin::class);
    }
}
