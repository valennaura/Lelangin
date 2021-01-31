<?php

namespace App\Models\Location;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'indonesia_cities';

    public function Transaction()
    {
        return $this->hasMany(Transaction::class, 'city_id');
    }

    public function Province()
    {
        return $this->belongsTo(Province::class);
    }

    public function District()
    {
        return $this->hasMany(District::class, 'city_id');
    }
}
