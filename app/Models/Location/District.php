<?php

namespace App\Models\Location;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'indonesia_districts';

    public function Transaction()
    {
        return $this->hasMany(Transaction::class, 'district_id');
    }

    public function City()
    {
        return $this->belongsTo(City::class);
    }

    public function Village()
    {
        return $this->hasMany(Village::class, 'district_id');
    }
}
