<?php

namespace App\Models;

use App\Models\Contracts\IOwner;
use App\Models\Traits\Owner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Users
 * @package App\Models
 *
 * @property-read int $id
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $surname
 * @property string $last_name
 * @property Company|null $first_company
 */
final class User extends Authenticatable implements JWTSubject, IOwner
{
    use HasApiTokens, HasFactory, Notifiable, Owner;

    /**
     * Guarded arguments list
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Users roles relation
     *
     * @return BelongsToMany
     */
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(
            Company::class,
            'company_users',
            'user_id',
            'company_id'
        );
    }

    /**
     * Get first company attribute accessor
     *
     * @return Company|null
     */
    public function getFirstCompanyAttribute(): ?Company
    {
        return $this->companies()->first();
    }

    /**
     * Users roles relation
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
