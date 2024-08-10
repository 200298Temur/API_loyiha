<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Database\Seeders\OrderSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone'
    ];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public  function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Product::class);
    }

    public function hasFavorite($favoriteId)
    {
        return $this->favorites()->where('product_id', $favoriteId)->exists();
    }

    public function addresses(){
        return $this->hasMany(UserAddress::class);
    }

    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews():HasMany
    {
        return $this->hasMany(Review::class);
    }
}
