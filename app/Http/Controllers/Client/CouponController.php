<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\UserCoupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
public function apply(Request $request)
    {
        $code = $request->input('coupon_code');

        $coupon = Coupon::where('code', $code)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
            })
            ->first();

        if (!$coupon) {
            return response()->json(['error' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.']);
        }

        $cart = auth()->user()->cart()->with('items.productVariant.product')->first();
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Giỏ hàng trống.']);
        }

        $total = 0;
        foreach ($cart->items as $item) {
            $total += $item->productVariant->product->price * $item->quantity;
        }

        $discount = ($total * $coupon->discount_percent) / 100;
        $final = max(0, $total - $discount);

        return response()->json([
            'message' => 'Áp dụng mã giảm giá thành công!',
            'discount_amount' => round($discount),
            'final_total' => round($final),
        ]);
    }



}