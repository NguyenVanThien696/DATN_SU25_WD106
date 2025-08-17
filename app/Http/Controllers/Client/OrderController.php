<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusLog;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
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
            'orderItems.productVariant.color',
            'refundRequest'
        ])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        $reviewedOrderItemIds = ProductReview::where('user_id', $user->id)->pluck('order_item_id')->toArray();

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
            $order = Order::with(['coupons', 'orderItems.productVariant'])
                ->where('id', $id)
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

                DB::table('user_coupons')
                    ->where('user_id', $order->user_id)
                    ->where('coupon_id', $order->coupons->id)
                    ->delete();
            }
            // Hoàn ví nếu thanh toán VNPay và đã trả tiền
            if ($order->payment_method === 'vnpay' && $order->payment_status === 'paid') {
                // Lấy admin thật (role = 1)
                $admin = User::where('role', 1)->lockForUpdate()->firstOrFail();
                $user  = User::with('wallet')->lockForUpdate()->findOrFail($order->user_id);

                // Lấy ví admin & user (nếu chưa có thì tạo)
                $adminWallet = Wallet::where('user_id', $admin->id)
                    ->lockForUpdate()
                    ->firstOrCreate(['user_id' => $admin->id], ['balance' => 0]);

                $userWallet = Wallet::where('user_id', $user->id)
                    ->lockForUpdate()
                    ->firstOrCreate(['user_id' => $user->id], ['balance' => 0]);

                // Lấy số tiền chính xác
                $amount = (float) $order->total_price;
                $amount = round($amount, 0);

                if ($amount <= 0) {
                    // Không cần hoàn tiền
                    $order->status = 'cancelled';
                } elseif ($adminWallet->balance >= $amount) {
                    // Trừ ví admin
                    $adminWallet->balance = (float)$adminWallet->balance - $amount;
                    $adminWallet->save();

                    // Cộng ví user
                    $userWallet->balance = (float)$userWallet->balance + $amount;
                    $userWallet->save();

                    // Ghi log giao dịch cho admin
                    WalletTransaction::create([
                        'wallet_id'   => $adminWallet->id,
                        'user_id'     => $admin->id,
                        'amount'      => -$amount,
                        'type'        => 'refund_out',
                        'description' => 'Hoàn tiền đơn hàng #' . $order->id . ' cho user ID ' . $user->id,
                    ]);

                    // Ghi log giao dịch cho user
                    WalletTransaction::create([
                        'wallet_id'   => $userWallet->id,
                        'user_id'     => $user->id,
                        'amount'      => $amount,
                        'type'        => 'refund_in',
                        'description' => 'Được hoàn tiền khi hủy đơn hàng #' . $order->id,
                    ]);

                    $order->status = 'cancelled_paid';
                } else {
                    // Admin chưa đủ tiền → chờ hoàn
                    $order->status = 'refund_pending';
                }
            } else {
                // Chưa thanh toán online → chỉ hủy
                $order->status = 'cancelled';
            }
            $order->save();

            return redirect()->route('client.order.index')
                ->with('success', 'Đơn hàng đã được hủy' . ($order->status === 'refund_pending' ? ' và đang chờ hoàn tiền.' : '.'));
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

            $order->status = 'completed';

            $order->save();

            return back()->with('success', 'Cảm ơn bạn đã xác nhận! Đơn hàng đã được hoàn tất.');
        });
    }
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $newStatus = $request->input('status');

        $order->status = $newStatus;
        $order->save();

        OrderStatusLog::create([
            'order_id' => $order->id,
            'status' => $newStatus,
            'note' => $request->input('note', null),
        ]);

        return back()->with('success', 'Cập nhật trạng thái thành công');
    }

    public function getStatus($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['status' => 'Không tìm thấy']);
        }

        return response()->json(['status' => $order->status]);
    }
}
