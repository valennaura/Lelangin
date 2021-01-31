<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index(Request $request)
    {
        $query = $this->client->query();
        $client = $query->with('User');
        if($request->get('name') && $request->get('name') != null) {
            $client = $query->where('name', 'LIKE', '%'.$request->name.'%');
        }
        if($request->get('sort') && $request->get('sort') != null) {
            $client = $query->orderBy('id', $request->get('sort'));
        }
        if($request->get('pagination') && $request->get('pagination') != null) {
            $client = $query->paginate($request->get('pagination'));
        } else {
            $client = $query->get();
        }
        return $this->onSuccess('Client', $client, 'Ditemukan');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $client = $this->client->create($request->all());
            return $this->onSuccess('Client', $client, 'Ditambahkan');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function show($id)
    {
        $client = $this->client->with('User')->where('id', $id)->first();
        return $this->onSuccess('Client', $client, 'Ditemukan');
    }

    public function edit(Client $client)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $update = $this->client->where('id', $id)->update($request->all());
            $client = $this->client->find($id);
            return $this->onSuccess('Client', $client, 'Diupdate');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $client = $this->client->find($id);
            $delete = $this->client->destroy($id);
            return $this->onSuccess('Client', $client, 'Dihapus');
        } catch (\Exception $e) {
            //throw $th;
        }
    }
}
