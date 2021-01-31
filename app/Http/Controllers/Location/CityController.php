<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Models\Location\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function index(Request $request)
    {
        $query = $this->city->query();
        $city = $query->with('Province', 'District');
        if($request->get('sort') && $request->get('sort') != null) {
            $city = $query->orderBy('id', $request->get('sort'));
        } else {
            $city = $query->get();
        }
        return $this->onSuccess('City', $city, 'Ditemukan');
    }

    public function show($id)
    {
        $query = $this->city->query();
        $city = $query->with('Province', 'District')->where('id', $id)->first();
        return $this->onSuccess('City', $city, 'Ditemukan');
    }
}
