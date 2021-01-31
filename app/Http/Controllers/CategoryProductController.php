<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{

    public $category;

    public function __construct(CategoryProduct $ctr)
    {
        $this->category = $ctr;
    }

    public function index(Request $request)
    {
        $query = $this->category->query();
        if($request->get('sort') && $request->get('sort') != null) {
            $category = $query->orderBy('id', $request->get('sort'));
        }
        if($request->get('name') && $request->get('name') != null) {
            $category = $query->where('name', 'LIKE', '%'.$request->get('name').'%');
        }

        if($request->get('pagination') && $request->get('pagination') != null) {
            $category = $query->paginate($request->get('pagination'));
        }
        else {
            $category = $query->get();
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
        $category = $this->category->with('Product')->where('id', $id)->first();
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
        $category = $this->category->destroy($id);
        return $this->onSuccess('Kategori Produk', $category_data, 'Dihapus');
    }
}
