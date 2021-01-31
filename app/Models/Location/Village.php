<?php

namespace App\Models\Location;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    protected $table = 'indonesia_villages';

    public function Transaction()
    {
        return $this->hasMany(Transaction::class, 'village_id');
    }

    public function District()
    {
        return $this->belongsTo(District::class);
    }
}
