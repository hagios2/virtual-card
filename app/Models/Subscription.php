<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(mixed $subscription_id)
 */
class Subscription extends Model
{
    use HasFactory;

    public const PENDING_STATUS = 'pending';
    public const PAID_STATUS = 'paid';
    public const EXPIRED_STATUS = 'expired';

    protected $guarded = ['id'];


}
