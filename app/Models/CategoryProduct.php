<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $table = 'categories_products';

    protected $fillable = ['name'];

    public function Product()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
