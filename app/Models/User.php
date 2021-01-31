<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password', 'phone', 'level', 'avatar'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Client()
    {
        return $this->belongsTo(Client::class);
    }

    public function Product()
    {
        return $this->hasMany(Product::class);
    }

    public function History()
    {
        return $this->hasMany(History::class);
    }

    public function Auction()
    {
        return $this->hasMany(Auction::class);
    }
}
