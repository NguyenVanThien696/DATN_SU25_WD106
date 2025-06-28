<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\UserCoupon;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
public function index()
{
    // dd(session('coupon'));
    $user = Auth::user();

    $cart = Cart::with([
        'items.variant.product',
        'items.variant.size',
        'items.variant.color'
    ])->where('user_id', $user->id)->first();

    if (!$cart || $cart->items->isEmpty()) {
        return back()->with('error', 'Giỏ hàng của bạn đang trống.');
    }

    $products = $cart->items;

    $total = 0;
    foreach ($products as $item) {
        $product = $item->variant->product;  
        $total += $product->price * $item->quantity;
    }

       // Áp dụng coupon nếu có
    $discount = session('coupon.discount_amount', 0);
    $couponCode = session('coupon.code', null);

    $finalTotal = $total - $discount;

    session(['cart_total' => $total]); 

    return view('client.checkout.index', compact('user', 'products', 'total', 'finalTotal', 'couponCode', 'discount'));
}



public function thankyou(){
        return view('client.checkout.thankyou');
    }

public function process(Request $request)
{
    // dd($request->all());
    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'phone'   => 'required|string|max:20',
        'address' => 'required|string|max:255',
    ]);

    DB::beginTransaction();

    try {
        $userId = Auth::id();
        $user = Auth::user();

        // Lấy giỏ hàng
        $cart = Cart::with('items.variant.product')->where('user_id', $userId)->first();
        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Tính tổng tiền
        $total = $cart->items->sum(function ($item) {
            return $item->variant->product->price * $item->quantity;
        });

        // Áp dụng giảm giá nếu có
        $discount = session('coupon.discount_amount', 0);
        $finalTotal = $total - $discount;

        // Tạo đơn hàng
        $order = Order::create([
            'user_id'        => $userId,
            'total_price'    => $finalTotal,
            'status'         => 'pending',
            'note'           => $request->input('c_order_notes'),
            'payment_method' => $request->input('payment_method') ?? 'cod',
            'payment_status' => 'unpaid'
        ]);

        // Cập nhật thông tin user
        $user->update([
            'name'    => $request->input('name'),
            'email'   => $request->input('email'),
            'phone'   => $request->input('phone'),
            'address' => $request->input('address'),
        ]);

        // Địa chỉ giao hàng khác
        if ($request->has('ship_to_different')) {
            ShippingAddress::create([
                'order_id' => $order->id,
                'name'     => $request->input('shipping_name'),
                'phone'    => $request->input('shipping_phone'),
                'email'    => $request->input('shipping_email'),
                'address'  => $request->input('shipping_address'),
                'note'     => $request->input('shipping_note'),
            ]);
        }
        

        // Thêm các item vào bảng order_items
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id'           => $order->id,
                'product_variant_id' => $item->product_variant_id,
                'quantity'           => $item->quantity,
                'price'              => $item->variant->product->price,
            ]);
        }

        // Xóa giỏ hàng
        $cart->items()->delete();
        $cart->delete();
        session()->forget('coupon');

        DB::commit();
        return redirect()->route('client.checkout.thankyou')->with('success', 'Đặt hàng thành công!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
    }
}


public function momoReturn(Request $request)
{
    if ($request->resultCode == 0) {
        // Thành công
        return redirect()->route('client.checkout.thankyou')->with('success', 'Thanh toán thành công!');
    } else {
        return redirect()->route('client.checkout.index')->with('error', 'Thanh toán thất bại hoặc bị hủy.');
    }
}

public function apply(Request $request)
{
    $request->validate([
        'coupon_code' => 'required|string'
    ]);

    $coupon = \App\Models\Coupon::where('code', $request->coupon_code)->first();

    // Kiểm tra mã có tồn tại không
    if (!$coupon) {
        return back()->with('error', 'Mã giảm giá không hợp lệ.');
    }

    // Kiểm tra hạn sử dụng
    if ($coupon->expires_at && now()->greaterThan($coupon->expires_at)) {
        return back()->with('error', 'Mã giảm giá đã hết hạn.');
    }

    // Lấy người dùng và giỏ hàng
    $user = Auth::user();
    $cart = \App\Models\Cart::with('items.variant.product')->where('user_id', $user->id)->first();

    if (!$cart || $cart->items->isEmpty()) {
        return back()->with('error', 'Giỏ hàng của bạn đang trống.');
    }

    // Tính tổng tiền
    $cartTotal = 0;
    foreach ($cart->items as $item) {
        $cartTotal += $item->variant->product->price * $item->quantity;
    }

    // Tính giảm giá
    $discount = round($cartTotal * ($coupon->discount_percent / 100));
    $discount = min($discount, $cartTotal); // Không vượt quá tổng tiền

    // Lưu session
    session()->forget('coupon');
    session()->put('coupon', [
        'code' => $coupon->code,
        'discount_percent' => $coupon->discount_percent,
        'discount_amount' => $discount
    ]);

    return back()->with('success', 'Áp dụng mã giảm giá thành công!');
}

}