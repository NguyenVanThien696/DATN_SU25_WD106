<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
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
            'orderItems.productVariant.product',
            'coupons'
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

    public function cancel($id){
    return DB::transaction(function () use ($id) {
        $order = Order::where('id', $id)
                      ->where('user_id', Auth::id())
                      ->lockForUpdate()
                      ->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->route('client.order.index')
                ->with('error', 'Đơn hàng không thể hủy vì đã được xử lý.');
        }

        foreach ($order->orderItems as $item) {
            $variant = $item->productVariant;
            $variant->stock += $item->quantity;
            $variant->save();
        }

        // Phân biệt xử lý theo trạng thái thanh toán
        if ($order->payment_status === 'paid') {
        // Đã thanh toán vnpay trạng thái chờ hoàn tiền
            $order->status = 'cancelled_paid';
        } else {
            // Chưa thanh toán cod hủy bình thường
            $order->status = 'cancelled';
        }

        $order->save();

        return redirect()->route('client.order.index')->with('success', 'Đơn hàng đã được hủy.');
    });
    }
}