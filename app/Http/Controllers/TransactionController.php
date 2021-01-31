<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public $tf;

    public function __construct(Transaction $transaction)
    {
        $this->tf = $transaction;
    }

    public function index(Request $request)
    {
        $query = $this->tf->query();
        $transaction = $query->with('Province', 'City', 'District', 'Village', 'User', 'Product');
        if($request->get('user') && $request->get('user') != null) {
            $transaction = $query->where('user_id', $request->get('user'));
        }
        if($request->get('product') && $request->get('product') != null) {
            $transaction = $query->where('product_id', $request->get('product'));
        }
        if($request->get('sort') && $request->get('sort') != null) {
            $transaction = $query->orderBy('id', 'DESC');
        }
        if($request->get('pagination') && $request->get('pagination') != null) {
            $transaction = $query->paginate($request->get('pagination'));
        } else {
            $transaction = $query->get();
        }
        return $this->onSuccess('Transaksi', $transaction, 'Ditemukan');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $transaction = $this->tf->create($request->all());
            return $this->onSuccess('Transaksi', $transaction, 'Berhasil');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function show($id)
    {
        $query = $this->tf->query();
        $transaction = $query->with('Province', 'City', 'District', 'Village', 'User', 'Product')->where('id', $id)->first();
        return $this->onSuccess('Transaksi', $transaction, 'Ditemukan');
    }

    public function edit(Transaction $transaction)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $update = $this->tf->where('id', $id)->update($request->all());
            $transaction = $this->tf->find($id);
            return $this->onSuccess('Transaksi', $transaction, 'Berhasil');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $transaction = $this->tf->find($id);
            $delete = $this->tf->destroy($id);
            return $this->onSuccess('Transaksi', $transaction, 'Dihapus');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }
}
