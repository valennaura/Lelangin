<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(Request $request)
    {
        if($request->get('page')) {
            $product = $this->product->paginate($request->get('page'));
        } else {
            $product = $this->product->all();
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
        $product = $this->product->find($id);
        return $this->onSuccess('Produk', $product, 'Ditemukan');
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $product = $this->product->where('id', $id)->update($request->all());
            $product_data = $this->product->find($id);
            return $this->onSuccess('Produk', $product_data, 'Diupdate');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        $product_data = $this->product->find($id);
        $product = $this->product->destroy($id);
        return $this->onSuccess('Produk', $product_data, 'Dihapus');
    }
}
