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
    $errors = [];

    foreach ($products as $item) {
        $variant = $item->variant;
        $product = $variant->product;

        // Kiểm tra tồn kho
        // if ($item->quantity > $variant->stock) {
        //     $errors[] = "Sản phẩm '{$product->name}' vượt quá số lượng tồn kho. Vui lòng chọn lại.";
        // }

        $total += $product->price * $item->quantity;
    }

    // Có lỗi chuyển về trang giỏ hàng
    if (!empty($errors)) {
        return redirect()->route('client.cart.index')->with('error', implode("\n", $errors));
    }

    session(['cart_total' => $total]);

    return view('client.checkout.index', compact('user', 'products'));
}


public function thankyou(){
        return view('client.checkout.thankyou');
    }

public function process(Request $request)
{
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

        foreach ($cart->items as $item) {
            if ($item->quantity > $item->variant->stock) {
            return back()->with('error', "Sản phẩm '{$item->variant->product->name}' không đủ số lượng trong kho.");
            }
        }

        // Tính tổng tiền
        $finalTotal = $cart->items->sum(function ($item) {
            return $item->variant->product->price * $item->quantity;
        });

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

            // Trừ tồn kho
            $variant = $item->variant;
            $variant->stock -= $item->quantity;
            if ($variant->stock < 0) {
                throw new \Exception('Sản phẩm "' . $variant->product->name . '" không đủ hàng trong kho.');
            }
            $variant->save();
        }

        // Xóa giỏ hàng
        $cart->items()->delete();
        $cart->delete();

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
    $coupon = Coupon::where('code', $request->coupon_code)
        ->where(function ($q) {
            $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
        })
        ->first();

    if (!$coupon) {
        return response()->json([
            'status' => 'error',
            'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.',
        ]);
    }

    session()->put('coupon', [
        'code' => $coupon->code,
        'discount_percent' => $coupon->discount_percent,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Áp dụng mã giảm giá thành công!',
        'discount_percent' => $coupon->discount_percent,
    ]);
}

}