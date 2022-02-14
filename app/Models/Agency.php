<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $agencyData)
 * @method static where(string $string, mixed $email)
 * @method static find(mixed $id)
 */
class Agency extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function agent(): HasMany
    {
        return $this->hasMany(Agent::class);
    }
}
