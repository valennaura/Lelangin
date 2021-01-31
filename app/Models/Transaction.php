<?php

namespace App\Models;

use App\Models\Location\City;
use App\Models\Location\District;
use App\Models\Location\Province;
use App\Models\Location\Village;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = ['user_id', 'product_id', 'method', 'account', 'total', 'province_id', 'city_id', 'district_id', 'village_id'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Province()
    {
        return $this->belongsTo(Province::class);
    }

    public function City()
    {
        return $this->belongsTo(City::class);
    }

    public function District()
    {
        return $this->belongsTo(District::class);
    }

    public function Village()
    {
        return $this->belongsTo(Village::class);
    }
}
