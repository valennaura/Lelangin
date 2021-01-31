<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Models\Location\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public $dist;

    public function __construct(District $dist)
    {
        $this->dist = $dist;
    }

    public function index(Request $request)
    {
        $query = $this->dist->query();
        $dist = $query->with('City', 'Village');
        if($request->get('sort') && $request->get('sort') != null) {
            $dist = $query->orderBy('id', $request->get('sort'));
        } else {
            $dist = $query->get();
        }
        return $this->onSuccess('District', $dist, 'Ditemukan');
    }

    public function show($id)
    {
        $query = $this->dist->query();
        $dist = $query->with('City', 'Village')->where('id', $id)->first();
        return $this->onSuccess('District', $dist, 'Ditemukan');
    }
}
