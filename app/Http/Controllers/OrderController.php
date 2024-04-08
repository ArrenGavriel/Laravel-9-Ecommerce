<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    //
    public function checkout() {
        $user_id = Auth::id();
        $carts = Cart::where('user_id', $user_id)->get();
        
        if($carts == null) {
            return Redirect::back();
        }

        $order = Order::create([
            'user_id' => $user_id
        ]);
        
        foreach($carts as $cart) {

            // pertama kita kurangi stok yang ada di product
            $product = Product::find($cart->product_id);
            $product->update([
                'stock' => ($product->stock - $cart->amount)
            ]);

            Transaction::create([
                'amount' => $cart->amount,
                'order_id' => $order->id,
                'product_id' => $cart->product_id
            ]);

            // kemudian kita delete product yang ada di cart
            $cart->delete();
        }

        return Redirect::route('show_order', $order);
    }

    public function index_order() {
        // jadi disini kita perbaiki lagu bagaimana caranya supaya ketika satu member user login
        // dia tidak dapat lihat order dari member user yang lain
        // kecuali admin, dia bisa lihat semua order dari semua user
        $user = Auth::user();
        $is_admin = $user->is_admin;
        
        if($is_admin) {
            $orders = Order::all();
        }
        else {
            $orders = Order::where('user_id', $user->id)->get();
        }
        
        return view('index_order', compact('orders') );
    }

    public function show_order(Order $order) {

        $user = Auth::user();
        $is_admin = $user->is_admin;
        if($is_admin || $order->user_id == $user->id) {
            return view('show_order', compact('order'));
        }

        return Redirect::route('index_order');
    }

    public function submit_payment_receipt(Request $request, Order $order) {
        //  WARNING: path tidak muncul di database
        $file = $request->file('payment_receipt');
        $path = time() . '_' . $order->id . '.' . $file->getClientOriginalExtension();
        // Storage::disk('local')->put('public/', $path, file_get_contents($file) );
        $file->storeAs('public', $path, 'local');

        // ini untuk debugging
        // dd($path);

        $order->update([
            'payment_receipt' => $path
        ]);

        return Redirect::back();
    }

    public function confirm_payment(Order $order) {
        $order->update([
            'is_paid' => true
        ]);

        return Redirect::back();
    }
}
