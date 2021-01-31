<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{

    public $history;

    public function __construct(History $history)
    {
        $this->history = $history;
    }

    public function index(Request $request)
    {
        try {
            $query = $this->history->query();
            $history = $query->with('User', 'Product', 'Auction')->orderBy('id', 'DESC');
            if($request->get('pagination') && $request->get('pagination') != null) {
                $history = $query->paginate($request->get('paginate'));
            } else {
                $history = $query->get();
            }
            return $this->onSuccess('Histori', $history, 'Ditemukan');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $history = $this->history->create($request->all());
            return $this->onSuccess('Histori', $history, 'Ditambahkan');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function show($id)
    {
        $history = $this->history->with('User', 'Product', 'Auction')->where('id', $id)->first();
        return $this->onSuccess('Histori', $history, 'Ditemukan');
    }

    public function edit(History $history)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $update = $this->history->where('id', $id)->update($request->all());
            $history = $this->history->find($id);
            return $this->onSuccess('Histori', $history, 'Diupdate');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $history = $this->history->find($id);
            $update = $this->history->destroy($id);
            return $this->onSuccess('Histori', $history, 'Dihapus');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }
}
