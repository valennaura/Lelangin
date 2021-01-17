<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{

    private $category;

    public function __construct(CategoryProduct $category)
    {
        $this->category = $category;
    }

    public function index(Request $request)
    {
        if($request->get('page')) {
            $category = $this->category->paginate($request->get('page'));
        } else {
            $category = $this->category->all();
        }
        return $this->onSuccess('Kategori Produk', $category, 'Ditemukan');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $category = $this->category->create($request->all());
            return $this->onSuccess('Kategori Produk', $category, 'Ditambahkan');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function show($id)
    {
        $category = $this->category->find($id);
        return $this->onSuccess('Kategori Produk', $category, 'Ditemukan');
    }

    public function edit(CategoryProduct $categoryProduct)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $category = $this->category->where('id', $id)->update($request->all());
            $category_data = $this->category->find($id);
            return $this->onSuccess('Kategori Produk', $category_data, 'Diupdate');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        $category_data = $this->category->find($id);
        $category = $this->category->delete($id);
        return $this->onSuccess('Kategori Produk', $category_data, 'Dihapus');
    }
}
