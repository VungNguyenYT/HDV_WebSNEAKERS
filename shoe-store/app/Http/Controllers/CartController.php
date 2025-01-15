<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Shoe;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('shoe')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'shoe_id' => 'required|exists:shoes,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::updateOrCreate(
            ['user_id' => auth()->id(), 'shoe_id' => $request->shoe_id],
            ['quantity' => $request->quantity]
        );

        return redirect()->route('cart')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:cart,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::findOrFail($request->cart_id);
        $cart->update(['quantity' => $request->quantity]);

        return redirect()->route('cart')->with('success', 'Giỏ hàng đã được cập nhật!');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:cart,id',
        ]);

        Cart::destroy($request->cart_id);

        return redirect()->route('cart')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }
}
