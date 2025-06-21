<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
public function listOrder()
{
    $user = Auth::user();

    $orders = Order::with([
        'shippingAddress',
        'orderItems.productVariant.product',
        'orderItems.productVariant.size',
        'orderItems.productVariant.color'
    ])
    ->where('user_id', $user->id)
    ->orderByDesc('created_at')
    ->get();

    if ($orders->isEmpty()) {
        return back()->with('error', 'Bạn chưa có đơn hàng nào.');
    }

    return view('client.orders.index', compact('user', 'orders'));
}

    public function detail($id)
    {
        $order = Order::with([
            'user',
            'shippingAddress',
            'orderItems.productVariant.product'
        ])->findOrFail($id);

        if (
            ($order->status === 'completed' || $order->payment_method === 'momo') 
            && $order->payment_status !== 'paid'
        ) {
            $order->payment_status = 'paid';
            $order->save();
        }

        return view('client.orders.detail', compact('order'));
    }

}