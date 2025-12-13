<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
     protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'google_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
     /**
     * Quan hệ: 1 user có nhiều đơn hàng
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Quan hệ: 1 user có 1 giỏ hàng
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * Quan hệ: 1 user có nhiều cartItems
     */
    public function cartItems()
    {
        return $this->hasManyThrough(CartItem::class, Cart::class);
    }
}
