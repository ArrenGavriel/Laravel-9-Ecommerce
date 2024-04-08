<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    //

    // ini untuk menghandle middleware
    // jadi semua function yang ada di controller ini mensyaratkan adanya user authentication terlebih dahulu
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add_to_cart(Product $product, Request $request) {

        $user_id = Auth::id();
        $product_id = $product->id;

        // pertama2 kita cek dulu apakah product sudah ditambahkan ke cart atau belum
        // buat variabel yang menampung hasil pengecekan
        $existing_cart = Cart::where('product_id', $product_id)
        ->where('user_id', $user_id)
        ->first();

        // kalau belum, maka kita bisa melanjutkan proses method add to cart
        if($existing_cart == null) {
            $request->validate([
                'amount' => 'required|gte:1|lte:' . $product->stock
            ]);
    
    
            Cart::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'amount' => $request->amount
            ]);
        }
        else {
            // jadi kalau misal product stocknya ada 5, dan yang ada di cart sudah ada 3
            // maka yang bisa diambil maksimal adalah 2
            $request->validate([
                'amount' => 'required|gte:1|lte:' . ($product->stock - $existing_cart->amount)
            ]);

            $existing_cart->update([
                'amount' => $existing_cart->amount + $request->amount
            ]);
        }

        return Redirect::route('show_cart');
    }

    public function show_cart() {
        $user_id = Auth::id();
        $carts = Cart::where('user_id', $user_id)->get();
        return view('show_cart', compact('carts'));
    }

    public function update_cart(Request $request, Cart $cart) {
        $request->validate([
            'amount' => 'required|gte:1|lte:' . $cart->product->stock
        ]); 

        $cart->update([
            'amount' => $request->amount
        ]);

        return Redirect::route('show_cart');
    }

    public function delete_cart(Cart $cart) {
        $cart->delete();
        return Redirect::back();
    }
}
