<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @method static create(array $adminData)
 * @method static where(string $string, mixed $email)
 * @method static find(mixed $id)
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function accountsComment(): HasMany
    {
        return $this->hasMany(UserAccountComment::class);
    }

    public function addAccountComment($comment): Model|BelongsTo
    {
        return $this->accountsComment()->create($comment);
    }

    public function subscription(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function addSubscription($subscription): Model
    {
        return $this->subscription()->create($subscription);
    }

    public function serviceRequest(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function requestForService($request): Model
    {
        return $this->subscription()->create($request);
    }
}
