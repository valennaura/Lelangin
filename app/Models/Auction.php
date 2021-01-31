<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $table = 'auctions';

    protected $fillable = ['user_id', 'product_id', 'price', 'status'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function History()
    {
        return $this->hasMany(History::class);
    }

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
}
