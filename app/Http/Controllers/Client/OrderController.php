<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductReview;
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
        $reviewedOrderItemIds = ProductReview::where('user_id', $user->id)->pluck('order_item_id')->toArray();
        if ($orders->isEmpty()) {
            return back()->with('error', 'Bạn chưa có đơn hàng nào.');
        }

        return view('client.orders.index', compact('user', 'orders', 'reviewedOrderItemIds'));
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

public function cancel($id)
{
    return DB::transaction(function () use ($id) {
        $order = Order::with('coupons')->where('id', $id)
            ->where('user_id', Auth::id())
            ->lockForUpdate()
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->route('client.order.index')
                ->with('error', 'Đơn hàng không thể hủy vì đã được xử lý.');
        }

        // Hoàn lại kho hàng
        foreach ($order->orderItems as $item) {
            $variant = $item->productVariant;
            $variant->stock += $item->quantity;
            $variant->save();
        }

        // Nếu có dùng mã giảm giá thì hoàn lại lượt
        if ($order->coupons) {
            $order->coupons->used = max(0, $order->coupons->used - 1);
            $order->coupons->save();

            // Xóa record người dùng đã dùng mã giảm giá
            DB::table('user_coupons')
                ->where('user_id', $order->user_id)
                ->where('coupon_id', $order->coupons->id)
                ->delete();
        }

        // Cập nhật trạng thái
        $order->status = $order->payment_status === 'paid' ? 'cancelled_paid' : 'cancelled';
        $order->save();

        return redirect()->route('client.order.index')->with('success', 'Đơn hàng đã được hủy.');
    });
}

public function confirmReceived($id)
{
    return DB::transaction(function () use ($id) {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->lockForUpdate()
            ->firstOrFail();

        if ($order->status !== 'delivered') {
            return back()->with('error', 'Chỉ xác nhận được các đơn hàng đã giao.');
        }

        if ($order->payment_status !== 'paid') {
            $order->payment_status = 'paid';
        }
        $order->save();

        return back()->with('success', 'Cảm ơn bạn đã xác nhận! Đơn hàng đã được hoàn tất.');
    });
}



}