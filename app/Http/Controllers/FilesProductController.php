<?php

namespace App\Http\Controllers;

use App\Models\FilesProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class FilesProductController extends Controller
{

    public $path;
    public $dimen;

    public function __construct()
    {
        $this->path = public_path().'/img/product/';
        $this->dimen = 750;
    }

    public function index(Request $request)
    {
        $query = FilesProduct::query();
        $file = $query->with('Product');
        if($request->get('sort') && $request->get('sort') != null) {
            $file = $query->orderBy('id', $request->get('sort'));
        }
        if($request->get('pagination') && $request->get('pagination') != null) {
            $file = $query->paginate($request->get('pagination'));
        } else {
            $file = $query->get();
        }
        return $this->onSuccess('File', $file, 'Ditemukan');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $product = Product::find($request->product_id);
            $files = $request->file('files');
            $returnFiles = [];
            if(!is_array($request->file('files'))) {
                $file = new FilesProduct();
                $file->product_id = $request->product_id;
                $file->type = $request->type;
                $fileName = 'FileImage_'.str_replace(' ', '-', $product->name).'_'.time().'.'.$files->extension();
                $img = Image::make($files->path());
                if(!File::isDirectory($this->path)) {
                    File::makeDirectory($this->path, 0777, false);
                }
                $img->resize($this->dimen, $this->dimen, function($constraint) {
                    $constraint->aspectRatio();
                })->save($this->path.$fileName);
                $file->name = $fileName;
                $file->save();
            }
            foreach($files as $item) {
                $file = new FilesProduct();
                $file->product_id = $request->product_id;
                $file->type = $request->type;
                $fileName = 'FileImage_'.str_replace(' ', '-', $product->name).'_'.uniqid().'_'.time().'.'.$item->extension();
                $img = Image::make($item->path());
                if(!File::isDirectory($this->path)) {
                    File::makeDirectory($this->path, 0777, false);
                }
                $img->resize($this->dimen, $this->dimen, function($constraint) {
                    $constraint->aspectRatio();
                })->save($this->path.$fileName);
                $file->name = $fileName;
                $file->save();
                $returnFiles[] = $file;
            }
            return $this->onSuccess('File', $returnFiles, 'Ditambahkan');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function show($id)
    {
        $file = FilesProduct::with('Product')->where('id', $id)->first();
        return $this->onSuccess('File', $file, 'Ditemukan');
    }

    public function edit(FilesProduct $filesProduct)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $file = FilesProduct::find($id);
            $product = Product::where('id', $file->product_id)->first();
            if($request->file('files') != null) {
                $item = $request->file('files');
                $fileName = 'FileImage_'.str_replace(' ', '-', $product->name).'_'.uniqid().'_'.time().'.'.$item->extension();
                $img = Image::make($item->path());
                $img->resize($this->dimen, $this->dimen, function($constraint) {
                    $constraint->aspectRatio();
                })->save($this->path.$fileName);
                unlink($this->path.$file->name);
                $file->name = $fileName;
            }
            $file->product_id = $request->product_id;
            $file->type = $request->type;
            $file->save();
            return $this->onSuccess('File', $file, 'Diupdate');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $file = FilesProduct::find($id);
            unlink($this->path.$file->name);
            $file->delete();
            return $this->onSuccess('File', $file, 'Dihapus');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }
}
