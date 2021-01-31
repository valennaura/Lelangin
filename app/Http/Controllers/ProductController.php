<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(Request $request)
    {
        $query = $this->product->query();
        $product = $query->with('User', 'Category');
        if($request->get('name') && $request->get('name') != null) {
            $product = $query->where('name', 'LIKE', '%'.$request->get('name').'%');
        }
        if($request->get('min') && $request->get('min') != null) {
            $product = $query->where('price', '>=', $request->get('min'));
        }
        if($request->get('max') && $request->get('max') != null) {
            $product = $query->where('price', '<=', $request->get('max'));
        }
        if($request->get('status') && $request->get('status') != null) {
            $query->where('status', $request->get('status'));
        }
        if($request->get('pagination')) {
            $product = $query->paginate($request->get('pagination'));
        } else {
            $product = $query->get();
        }
        return $this->onSuccess('Produk', $product, 'Ditemukan');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $product = $this->product->create($request->all());
            return $this->onSuccess('Produk', $product, 'Ditambahkan');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function show($id)
    {
        $product = $this->product->with('User', 'Category')->where('id', $id)->first();
        return $this->onSuccess('Produk', $product, 'Ditemukan');
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $update = $this->product->where('id', $id)->update($request->all());
            $product = $this->product->find($id);
            return $this->onSuccess('Produk', $product, 'Diupdate');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        $product = $this->product->find($id);
        $delete = $this->product->destroy($id);
        return $this->onSuccess('Produk', $product, 'Dihapus');
    }
}
