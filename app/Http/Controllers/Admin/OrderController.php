<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function listOrder() {
        $orders = Order::with(['user', 'shippingAddress'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
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

        return view('admin.orders.detail', compact('order'));
    }

public function updateStatus(Request $request, $id){
    $request->validate([
        'status' => 'required|in:pending,processing,completed,cancelled'
    ]);

    return DB::transaction(function () use ($request, $id) {
        $order = Order::lockForUpdate()->findOrFail($id);

        if (in_array($order->status, ['cancelled', 'completed'])) {
            return back()->with('error', 'Không thể thay đổi trạng thái đơn hàng đã hoàn tất hoặc đã bị hủy.');
        }

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    });
}




}