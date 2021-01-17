<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilesProduct extends Model
{
    use HasFactory;

    protected $table = 'file_product';

    protected $fillable = ['product_id', 'name', 'type'];
}
