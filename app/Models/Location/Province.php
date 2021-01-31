<?php

namespace App\Models\Location;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'indonesia_provinces';

    public function Transaction()
    {
        return $this->hasMany(Transaction::class, 'province_id');
    }

    public function City()
    {
        return $this->hasMany(City::class, 'province_id');
    }
}
