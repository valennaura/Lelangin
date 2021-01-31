<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Models\Location\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    public $vill;

    public function __construct(Village $village)
    {
        $this->vill = $village;
    }

    public function index(Request $request)
    {
        $query = $this->vill->query();
        $vill = $query->with('District');
        if($request->get('sort') && $request->get('sort') != null) {
            $vill = $query->orderBy('id', $request->get('sort'));
        } else {
            $vill = $query->get();
        }
        return $this->onSuccess('Village', $vill, 'Ditemukan');
    }

    public function show($id)
    {
        $query = $this->vill->query();
        $vill = $query->with('District')->where('id', $id)->first();
        return $this->onSuccess('Village', $vill, 'Ditemukan');
    }
}
