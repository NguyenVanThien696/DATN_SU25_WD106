<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\UserCoupon;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
public function index($id) {
    $user = User::findOrFail($id);

    $cart = Cart::with([
        'items.productVariant.product',
        'items.productVariant.size',
        'items.productVariant.color'
    ])->where('user_id', $id)->first();

    if (!$cart || $cart->items->isEmpty()) {
        return redirect()->route('client.cart.index')
            ->with('error', 'Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm trước khi thanh toán.');
    }

    $products = $cart->items;

    return view('client.checkout.index', compact('user', 'products'));
}


    public function thankyou(){
        return view('client.checkout.thankyou');
    }


public function process(Request $request, $id)
{
    DB::beginTransaction();

    try {
        $cart = Cart::with('items.productVariant.product')->where('user_id', $id)->firstOrFail();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $total = 0;
        foreach ($cart->items as $item) {
            $total += $item->productVariant->product->price * $item->quantity;
        }

        // Mã giảm giá
        $couponCode = $request->input('coupon');
        $discount = 0;
        $coupon = null;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)
                ->where(function ($q) {
                    $q->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
                })->first();

            if (!$coupon) {
                return back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn.');
            }

            $used = UserCoupon::where('user_id', $id)
                ->where('coupon_id', $coupon->id)
                ->exists();

            if ($used) {
                return back()->with('error', 'Bạn đã sử dụng mã giảm giá này.');
            }

            // Áp dụng giảm giá
            $discount = ($total * $coupon->discount_percent) / 100;
        }

        $finalTotal = max(0, $total - $discount);

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => $id,
            'total_price' => $finalTotal,
            'status' => 'pending',
        ]);

        // Tạo chi tiết đơn hàng
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $item->product_variant_id,
                'quantity' => $item->quantity,
                'price' => $item->productVariant->product->price,
            ]);
        }

        // Lưu lại việc user đã dùng mã
        if ($coupon) {
            UserCoupon::create([
                'user_id' => $id,
                'coupon_id' => $coupon->id,
                'used_at' => now(),
            ]);
        }

        // Xóa giỏ hàng
        $cart->items()->delete();
        $cart->delete();

        DB::commit();
        return redirect()->route('client.checkout.thankyou')->with('success', 'Đặt hàng thành công!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
    }
}
    

}