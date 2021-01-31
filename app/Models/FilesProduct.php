<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilesProduct extends Model
{
    use HasFactory;

    protected $table = 'files_products';

    protected $fillable = ['product_id', 'name', 'type'];

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
}
