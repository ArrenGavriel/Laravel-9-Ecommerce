<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    // ini akan mengatur semua function yang akan dilakukan model product ini
    // return view itu artinya kita return view yang ada di blade.php

    // create and store product
    public function create_product() {
        return view('create_product');
    }

    public function store_product(Request $request) {
        // validasi 
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        $file = $request->file('image');
        $name = $request->name;
        $path = time() . '_' . $name . '.' . $file->getClientOriginalExtension();
        // Storage::disk('local')->put('public/', $path, file_get_contents($file) );
        $file->storeAs('public', $path, 'local');

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $path
        ]);

        return Redirect::route('create_product');
    }

    // show all product
    public function index_product() {
        $products = Product::all();
        return view('index_product', compact('products') );
    }

    // show product details
    public function show_product(Product $product) {
        return view('show_product', compact('product'));
    }

    // edit and update product
    public function edit_product(Product $product) {
        return view('edit_product', compact('product'));
    }

    public function update_product(Product $product, Request $request) {

         // validasi 
         $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        $file = $request->file('image');
        $name = $request->name;
        $path = time() . '_' . $name . '.' . $file->getClientOriginalExtension();
        // Storage::disk('local')->put('public/', $path, file_get_contents($file) );
        $file->storeAs('public', $path, 'local');

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $path
        ]);

        return Redirect::route('show_product', $product);

    }

    public function delete_product(Product $product) {
        $product->delete();
        return Redirect::route('index_product');
    }

}
