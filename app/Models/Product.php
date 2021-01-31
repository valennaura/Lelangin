<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['user_id', 'name', 'close', 'price', 'status', 'description', 'category_id'];

    public function File()
    {
        return $this->hasMany(File::class);
    }

    public function Auction()
    {
        return $this->hasMany(Auction::class);
    }

    public function Category()
    {
        return $this->belongsTo(CategoryProduct::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
