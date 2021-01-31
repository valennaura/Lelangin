<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Models\Location\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public $prov;

    public function __construct(Province $province)
    {
        $this->prov = $province;
    }

    public function index(Request $request)
    {
        $query = $this->prov->query();
        $prov = $query->with('City');
        if($request->get('sort') && $request->get('sort') != null) {
            $prov = $query->orderBy('id', $request->get('sort'));
        } else {
            $prov = $query->get();
        }
        return $this->onSuccess('Province', $prov, 'Ditemukan');
    }

    public function show($id)
    {
        $query = $this->prov->query();
        $prov = $query->with('City')->where('id', $id)->first();
        return $this->onSuccess('Province', $prov, 'Ditemukan');
    }
}
