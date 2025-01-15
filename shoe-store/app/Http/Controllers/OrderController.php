<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('shoe')->get();
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->shoe->price * $item->quantity;
        });

        return view('checkout.index', compact('cartItems', 'totalPrice'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:500',
        ]);

        $cartItems = Cart::where('user_id', auth()->id())->with('shoe')->get();
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->shoe->price * $item->quantity;
        });

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $totalPrice,
            'order_status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'shoe_id' => $item->shoe->id,
                'quantity' => $item->quantity,
                'price' => $item->shoe->price,
            ]);
        }

        Cart::where('user_id', auth()->id())->delete();

        return redirect('/')->with('success', 'Đơn hàng của bạn đã được đặt thành công!');
    }
}
