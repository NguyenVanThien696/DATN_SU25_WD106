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
        'items.productVariant.product',
        'items.productVariant.size',
        'items.productVariant.color'
    ])->where('user_id', $user->id)->first();

    if (!$cart || $cart->items->isEmpty()) {
        return back()->with('error', 'Giỏ hàng của bạn đang trống.');
    }

    $products = $cart->items;

    $total = 0;
    foreach ($products as $item) {
        $product = $item->productVariant->product;  
        $total += $product->price * $item->quantity;
    }

    session(['cart_total' => $total]); 

    return view('client.checkout.index', compact('user', 'products'));
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
        $cart = Cart::with('items.productVariant.product')->where('user_id', $userId)->first();
        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Tính tổng tiền
        $total = $cart->items->sum(function ($item) {
            return $item->productVariant->product->price * $item->quantity;
        });

        // Mã giảm giá
    $coupon = null;
    $discount = 0;

    if (session()->has('coupon')) {
    $couponData = session('coupon');

    $coupon = Coupon::where('code', $couponData['code'])
        ->where(function ($q) {
            $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
        })
        ->first();

    if ($coupon) {
        $used = UserCoupon::where('user_id', $userId)
            ->where('coupon_id', $coupon->id)
            ->exists();

        if (!$used) {
            $discount = ($total * $coupon->discount_percent) / 100;

            // lưu vào bảng user_coupons
            UserCoupon::create([
                'user_id'   => $userId,
                'coupon_id' => $coupon->id,
                'used_at'   => now(),
            ]);
            }
        }

        // Xoá sau khi áp dụng
        session()->forget('coupon');
    }
        $finalTotal = max(0, $total - $discount);

        // Tạo đơn hàng
        $order = Order::create([
            'user_id'     => $userId,
            'total_price' => $finalTotal,
            'status'      => 'pending',
            'note'        => $request->input('c_order_notes'),
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
                'price'              => $item->productVariant->product->price,
            ]);
        }

        // Đánh dấu mã giảm giá đã dùng
        if ($coupon) {
            UserCoupon::create([
                'user_id'   => $userId,
                'coupon_id' => $coupon->id,
                'used_at'   => now(),
            ]);
        }

        // Thanh toán MoMo
        if ($request->payment_method === 'momo') {
            $endpoint    = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = 'MOMOBKUN20180529';
            $accessKey   = 'klm05TvNBzhg7h7j';
            $secretKey   = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

            $orderId     = $order->id . '_' . time();
            $requestId   = time() . '';
            $orderInfo   = "Thanh toán đơn hàng #" . $order->id;
            $redirectUrl = route('client.checkout.momoReturn');
            $ipnUrl      = route('client.checkout.momoIPN');
            $extraData   = '';

            $rawHash = "accessKey={$accessKey}&amount={$finalTotal}&extraData={$extraData}&ipnUrl={$ipnUrl}&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$partnerCode}&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType=captureWallet";
            $signature = hash_hmac('sha256', $rawHash, $secretKey);

            $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId'     => "MomoTestStore",
            'requestId'   => $requestId,
            'amount'      => $finalTotal,
            'orderId'     => $orderId,
            'orderInfo'   => $orderInfo,
            'returnUrl'   => $redirectUrl,
            'notifyUrl'   => $ipnUrl,
            'lang'        => 'vi',
            'extraData'   => $extraData,
            'requestType' => "captureWallet",
            'signature'   => $signature
        ];

            $response = Http::post($endpoint, $data);

            if ($response->successful() && isset($response['payUrl'])) {
                DB::commit();
                return redirect($response['payUrl']);
            }

            DB::rollBack();
            return back()->with('error', 'Không thể tạo thanh toán MoMo. Vui lòng thử lại.');
        }

        // Nếu thanh toán COD thì xóa giỏ hàng
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