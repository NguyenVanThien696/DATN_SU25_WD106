<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    // Lọc đơn hàng theo trạng thái
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.productVariant.product', 'shippingAddress']);

        // Lọc theo trạng thái nếu có
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo ngày nếu có
        if ($request->filled('date')) {
            try {
                // Hỗ trợ cả 'd/m/Y' và 'Y-m-d'
                $inputDate = $request->date;

                if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $inputDate)) {
                    $date = Carbon::createFromFormat('d/m/Y', $inputDate)->toDateString();
                } else {
                    $date = Carbon::parse($inputDate)->toDateString();
                }

                $query->whereDate('created_at', $date);
            } catch (\Exception $e) {
                return back()->with('error', 'Ngày không hợp lệ!');
            }
        }

        $orders = $query->latest()->paginate(10);

        return view('admin.orders.index', [
            'orders' => $orders,
            'filteredDate' => $request->date,
        ]);
    }



    public function listOrder()
    {
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

    public function updateStatus(Request $request, $id)
    {
        $allStatuses = [
            'pending',
            'confirmed',
            'processing',
            'shipping',
            'delivered',
            'completed',
            'cancelled',
            'cancelled_paid',
            'refunded',
            'delivery_failed'
        ];

        $request->validate([
            'status' => 'required|in:' . implode(',', $allStatuses),
        ]);

        return DB::transaction(function () use ($request, $id) {
            $order = Order::with('orderItems')->lockForUpdate()->findOrFail($id);

            $currentStatus = $order->status;
            $newStatus = $request->status;

            if (in_array($currentStatus, ['cancelled', 'completed', 'refunded'])) {
                return back()->with('error', 'Không thể thay đổi trạng thái đơn hàng đã hoàn tất hoặc bị hủy.');
            }

            $validTransitions = [
                'pending' => ['confirmed', 'cancelled'],
                'confirmed' => ['processing', 'cancelled'],
                'processing' => ['shipping', 'cancelled'],
                'shipping' => ['delivered', 'delivery_failed'],
                'delivered' => ['completed'],
            ];

            if (!in_array($newStatus, $validTransitions[$currentStatus] ?? [])) {
                return back()->with('error', 'Chuyển trạng thái không hợp lệ.');
            }

            if (in_array($newStatus, ['cancelled', 'cancelled_paid'])) {
                foreach ($order->orderItems as $item) {
                    if ($item->product_variant_id && $item->quantity > 0) {
                        DB::table('product_variants')
                            ->where('id', $item->product_variant_id)
                            ->increment('stock', $item->quantity);
                    }
                }
            }

            $order->status = $newStatus;
            $order->save();

            return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
        });
    }


    public function refund($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status !== 'cancelled_paid' || $order->payment_status !== 'paid') {
            return back()->with('error', 'Đơn hàng không hợp lệ để hoàn tiền.');
        }
        foreach ($order->orderItems as $item) {
            $variant = $item->productVariant;
            $variant->stock += $item->quantity;
            $variant->save();
        }

        $order->update([
            'status' => 'refunded',
            'payment_status' => 'refunded',
        ]);



        return back()->with('success', 'Đã hoàn tiền cho đơn hàng #' . $order->id);
    }

    public function getStatuses($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['error' => 'Không tìm thấy đơn hàng'], 404);
        }

        return response()->json([
            'status' => $order->status,
        ]);
    }
}
