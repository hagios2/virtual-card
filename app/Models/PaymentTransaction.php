<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create($paymentData)
 */
class PaymentTransaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeUserTransactions($query)
    {
        $query->where('user_id', auth()->id());
    }
}
