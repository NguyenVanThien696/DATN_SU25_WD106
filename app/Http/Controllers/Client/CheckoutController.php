<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\UserCoupon;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\PendingOrder;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
public function index(Request $request)
{
    $user = Auth::user();

    //Danh sách id sản phẩm được chọn từ giỏ hàng
        $selectedIdsString = $request->query('selected_items');

        if(!$selectedIdsString){
            return redirect()->route('client.cart.index')->with('error', 'Vui lòng chọn sản phẩm để thanh toán');
        }

        $selectedIds = explode(',', $selectedIdsString);

    $cart = Cart::with([
        'items.variant.product',
        'items.variant.size',
        'items.variant.color'
    ])->where('user_id', $user->id)->first();

    if (!$cart || $cart->items->isEmpty()) {
        return back()->with('error', 'Giỏ hàng của bạn đang trống.');
    }

    $products = $cart->items->whereIn('id', $selectedIds);

    foreach ($products as $item) {
        $availableStock = $item->variant->stock ?? 0;
        if($item->quantity > $availableStock){
            return redirect()->route('client.cart.index')->with('error', 'Sản phẩm "' . $item->variant->product->name .'" không còn đủ số lượng tồn kho!');
        }
    }

    // Tính tổng tiền hàng
    $total = 0;
    foreach ($products as $item) {
        $product = $item->variant->product;  
        $total += $product->price * $item->quantity;
    }

    // Áp dụng mã giảm giá (nếu có)
    $discount = session('coupon.discount_amount', 0);
    $couponCode = session('coupon.code', null);

    $finalTotal = $total - $discount;

    // Tính phí ship
    $shippingFee = $total >= 500000 ? 0 : 30000;

    // Tổng cần thanh toán sau khi cộng phí ship
    $finalWithShipping = $finalTotal + $shippingFee;

    session([
        'cart_total' => $total,
        'shipping_fee' => $shippingFee,
        'final_total' => $finalTotal,
        'final_with_shipping' => $finalWithShipping,
    ]);

    return view('client.checkout.index', compact(
        'user',
        'products',
        'total',
        'discount',
        'couponCode',
        'shippingFee',
        'finalTotal',
        'finalWithShipping'
    ));
}


public function thankyou(){
        return view('client.checkout.thankyou');
    }

public function process(Request $request)
{
    // dd($request->all());
    if ($request->has('apply_coupon')) {
        return $this->apply($request);
    }

    if ($request->has('ship_to_different')) {
        $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_email'   => 'required|email|max:255',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
        ], [
            'shipping_name.required'    => 'Tên người nhận không được để trống.',
            'shipping_name.string'      => 'Tên người nhận phải là chuỗi.',
            'shipping_name.max'         => 'Tên người nhận không được vượt quá 255 ký tự.',

            'shipping_email.required'   => 'Email người nhận không được để trống.',
            'shipping_email.email'      => 'Email người nhận không đúng định dạng.',
            'shipping_email.max'        => 'Email người nhận không được vượt quá 255 ký tự.',

            'shipping_phone.required'   => 'Số điện thoại người nhận không được để trống.',
            'shipping_phone.string'     => 'Số điện thoại người nhận phải là chuỗi.',
            'shipping_phone.max'        => 'Số điện thoại người nhận không được vượt quá 20 ký tự.',

            'shipping_address.required' => 'Địa chỉ người nhận không được để trống.',
            'shipping_address.string'   => 'Địa chỉ người nhận phải là chuỗi.',
            'shipping_address.max'      => 'Địa chỉ người nhận không được vượt quá 255 ký tự.',
        ]);
    } else {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ], [
            'name.required'    => 'Tên người dùng không được để trống.',
            'name.string'      => 'Tên người dùng phải là chuỗi.',
            'name.max'         => 'Tên người dùng không được vượt quá 255 ký tự.',

            'email.required'   => 'Email không được để trống.',
            'email.email'      => 'Email không đúng định dạng.',
            'email.max'        => 'Email không được vượt quá 255 ký tự.',

            'phone.required'   => 'Số điện thoại không được để trống.',
            'phone.string'     => 'Số điện thoại phải là chuỗi.',
            'phone.max'        => 'Số điện thoại không được vượt quá 20 ký tự.',

            'address.required' => 'Địa chỉ không được để trống.',
            'address.string'   => 'Địa chỉ phải là chuỗi.',
            'address.max'      => 'Địa chỉ không được vượt quá 255 ký tự.',
        ]);
    }

    DB::beginTransaction();

    try {
        $userId = Auth::id();
        $user = Auth::user();

        $cart = Cart::with('items.variant.product')->where('user_id', $userId)->first();
        // dd(Auth::id());
        // dd($cart);
        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $selectedIdsString = $request->input('selected_items');
            if(!$selectedIdsString){
            return redirect()->route('client.cart.index')->with('error', 'Vui lòng chọn sản phẩm để thanh toán');
            }
            $selectedIds = explode(',', $selectedIdsString);
            $cartItems = $cart->items->whereIn('id', $selectedIds);

        $total = $cartItems->sum(function ($item) {
            return $item->variant->product->price * $item->quantity;
        });

        $discount = session('coupon.discount_amount', 0);
        $shippingFee = $total >= 500000 ? 0 : 30000;
        $finalTotalWithShipping = $total - $discount + $shippingFee;

        $paymentMethod = $request->input('payment_method', 'cod');

        // Lấy thông tin người nhận
        $name    = $request->input($request->has('ship_to_different') ? 'shipping_name' : 'name');
        $email   = $request->input($request->has('ship_to_different') ? 'shipping_email' : 'email');
        $phone   = $request->input($request->has('ship_to_different') ? 'shipping_phone' : 'phone');
        $address = $request->input($request->has('ship_to_different') ? 'shipping_address' : 'address');
        $note    = $request->input($request->has('ship_to_different') ? 'shipping_note' : 'c_order_notes');

        if ($paymentMethod === 'vnpay') {
            $txnRef = uniqid($userId . '_');
            $orderCode = 'DH' . now()->format('HidmY') . strtoupper(Str::random(4));

            PendingOrder::create([
                'txn_ref'         => $txnRef,
                'order_code'      => $orderCode,
                'user_id'         => $userId,
                'total_price'     => $finalTotalWithShipping,
                'discount'        => $discount,
                'coupon_id'       => optional(Coupon::where('code', session('coupon.code'))->first())->id,
                'shipping_fee'    => $shippingFee,
                'note'            => $note,
                'customer_name'   => $name,
                'customer_email'  => $email,
                'customer_phone'  => $phone,
                'customer_address'=> $address,
                'user_info'       => [
                    'name'    => $name,
                    'email'   => $email,
                    'phone'   => $phone,
                    'address' => $address,
                ],
                'cart_items'  => $cart->items->map(function ($item) {
                    return [
                        'product_variant_id' => $item->product_variant_id,
                        'quantity'           => $item->quantity,
                        'price'              => $item->variant->product->price,
                    ];
                })->toArray(),
            ]);

            // Gọi tới VNPay
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = route('client.checkout.vnpayReturn');
            $vnp_TmnCode = '1615H65S';
            $vnp_HashSecret = config('services.vnpay.hash_secret');
            $vnp_OrderInfo = 'payment';
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = (int)round($finalTotalWithShipping * 100);
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = [
                "vnp_Version"    => "2.1.0",
                "vnp_TmnCode"    => $vnp_TmnCode,
                "vnp_Amount"     => $vnp_Amount,
                "vnp_Command"    => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode"   => "VND",
                "vnp_IpAddr"     => $vnp_IpAddr,
                "vnp_Locale"     => $vnp_Locale,
                "vnp_OrderInfo"  => $vnp_OrderInfo,
                "vnp_OrderType"  => $vnp_OrderType,
                "vnp_ReturnUrl"  => $vnp_Returnurl,
                "vnp_TxnRef"     => $txnRef,
            ];

            if (!empty($vnp_BankCode)) {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);
            $query = "";
            $hashdata = "";
            $i = 0;
            foreach ($inputData as $key => $value) {
                $hashdata .= ($i ? '&' : '') . urlencode($key) . "=" . urlencode($value);
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
                $i++;
            }

            $vnp_Url .= "?" . $query;
            if ($vnp_HashSecret) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }

            DB::commit();
            return redirect()->to($vnp_Url);
        }


        $orderCode = 'DH' . now()->format('HidmY') . strtoupper(Str::random(4));
        $order = Order::create([
            'user_id'         => $userId,
            'order_code'      => $orderCode,
            'total_price'     => $finalTotalWithShipping,
            'shipping_fee'    => $shippingFee,
            'discount'        => $discount,
            'coupon_id'       => optional(Coupon::where('code', session('coupon.code'))->first())->id,
            'status'          => 'pending',
            'note'            => $note,
            'payment_method'  => 'cod',
            'payment_status'  => 'unpaid',
            'customer_name'   => $name,
            'customer_email'  => $email,
            'customer_phone'  => $phone,
            'customer_address'=> $address,
        ]);

        if ($request->has('ship_to_different')) {
            ShippingAddress::create([
                'order_id' => $order->id,
                'name'     => $name,
                'email'    => $email,
                'phone'    => $phone,
                'address'  => $address,
                'note'     => $note,
            ]);
        }

        foreach ($cartItems as $item) {
            $variant = $item->variant;

            OrderItem::create([
                'order_id'           => $order->id,
                'product_variant_id' => $item->product_variant_id,
                'product_name'       => $variant->product->name ?? '',
                'variant_name'       => ($variant->color->name ?? '-') . ' / ' . ($variant->size->name ?? '-'),
                'quantity'           => $item->quantity,
                'price'              => $variant->product->price,
            ]);

            $variant->stock -= $item->quantity;
            if ($variant->stock < 0) {
                throw new \Exception('Sản phẩm "' . $variant->product->name . '" không đủ hàng trong kho.');
            }
            $variant->save();
        }

        $this->saveUsedCoupon($userId);
        CartItem::whereIn('id', $selectedIds)->delete();
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

    $coupon = Coupon::where('code', $request->coupon_code)->first();

    if (!$coupon) {
        return back()->withInput()->with('error', 'Mã giảm giá không hợp lệ.');
    }

    if ($coupon->status !== 'active') {
        return back()->withInput()->with('error', 'Mã giảm giá không còn hoạt động.');
    }

    $now = now();
    if (($coupon->start_at && $now->lt($coupon->start_at)) || ($coupon->end_at && $now->gt($coupon->end_at))) {
        return back()->withInput()->with('error', 'Mã giảm giá hiện không còn hiệu lực.');
    }

    if (!is_null($coupon->usage_limit) && $coupon->used >= $coupon->usage_limit) {
        return back()->withInput()->with('error', 'Mã giảm giá đã được sử dụng hết.');
    }

    $user = Auth::user();
    $used = UserCoupon::where('user_id', $user->id)
                      ->where('coupon_id', $coupon->id)
                      ->exists();

    if ($used) {
        return back()->withInput()->with('error', 'Bạn đã sử dụng mã giảm giá này rồi.');
    }

    $cart = Cart::with('items.variant.product')->where('user_id', $user->id)->first();

    if (!$cart || $cart->items->isEmpty()) {
        return back()->with('error', 'Giỏ hàng của bạn đang trống.');
    }

    $cartTotal = $cart->items->sum(function ($item) {
        return $item->variant->product->price * $item->quantity;
    });

    if (!is_null($coupon->min_order_amount) && $cartTotal < $coupon->min_order_amount) {
        return back()->withInput()->with('error', 'Đơn hàng cần tối thiểu ' . number_format($coupon->min_order_amount) . 'đ để áp dụng mã giảm giá này.');
    }

    if ($coupon->discount_type === 'percent') {
        $discount = round($cartTotal * ($coupon->discount_percent / 100));

        if (!is_null($coupon->max_discount_amount)) {
            $discount = min($discount, $coupon->max_discount_amount);
        }
    } else {
        $discount = $coupon->discount_amount;
    }

    $discount = min($discount, $cartTotal);

    session()->forget('coupon');
    session()->put('coupon', [
        'code' => $coupon->code,
        'type' => $coupon->discount_type,
        'discount_value' => $coupon->discount_type === 'percent' ? $coupon->discount_percent : $coupon->discount_amount,
        'discount_amount' => $discount,
    ]);

    return back()->withInput()->with('success', 'Áp dụng mã giảm giá thành công!');
}




public function vnpayReturn(Request $request)
{
    $vnp_HashSecret = config('services.vnpay.hash_secret');
    $inputData = $request->all();
    $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';

    unset($inputData['vnp_SecureHash']);
    unset($inputData['vnp_SecureHashType']);
    ksort($inputData);

    $hashDataArr = [];
    foreach ($inputData as $key => $value) {
        $hashDataArr[] = $key . '=' . $value;
    }
    $hashData = implode('&', $hashDataArr);
    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

    // Kiểm tra chữ ký + mã phản hồi thành công
    if ($secureHash === $vnp_SecureHash && $request->vnp_ResponseCode == '00') {
        $txnRef = $request->vnp_TxnRef ?? null;
        $pendingOrder = PendingOrder::where('txn_ref', $txnRef)->first();

        if (!$pendingOrder) {
            return redirect()->route('client.checkout.index')->with('error', 'Không tìm thấy thông tin đơn hàng.');
        }

        DB::beginTransaction();
        try {
            // ✅ Sửa lỗi: thiếu thông tin khách hàng
            // Kiểm tra lại các giá trị
            if (
                !$pendingOrder->customer_name ||
                !$pendingOrder->customer_email ||
                !$pendingOrder->customer_phone ||
                !$pendingOrder->customer_address
            ) {
                throw new \Exception('Thông tin khách hàng trong pending order bị thiếu.');
            }

            $order = Order::create([
                'user_id'         => $pendingOrder->user_id,
                'order_code'      => $pendingOrder->order_code,
                'total_price'     => $pendingOrder->total_price,
                'discount'        => $pendingOrder->discount ?? 0,
                'shipping_fee'    => $pendingOrder->shipping_fee ?? 0,
                'status'          => 'pending',
                'note'            => $pendingOrder->note,
                'payment_method'  => 'vnpay',
                'payment_status'  => 'paid',
                'customer_name'   => $pendingOrder->customer_name,
                'customer_email'  => $pendingOrder->customer_email,
                'customer_phone'  => $pendingOrder->customer_phone,
                'customer_address'=> $pendingOrder->customer_address,
            ]);

            // ✅ Cập nhật user info nếu có
            $user = User::find($pendingOrder->user_id);
            if ($user && $pendingOrder->user_info) {
                $user->update($pendingOrder->user_info);
            }

            // ✅ Sửa lỗi: dùng $variant trước khi gọi find
            foreach ($pendingOrder->cart_items as $item) {
                $variant = \App\Models\ProductVariant::with('product', 'color', 'size')->find($item['product_variant_id']);

                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_variant_id' => $item['product_variant_id'],
                    'product_name'       => $variant->product->name ?? '',
                    'variant_name'       => ($variant->color->name ?? '-') . ' / ' . ($variant->size->name ?? '-'),
                    'quantity'           => $item['quantity'],
                    'price'              => $item['price'],
                ]);

                $variant->stock -= $item['quantity'];
                if ($variant->stock < 0) {
                    throw new \Exception('Sản phẩm "' . $variant->product->name . '" không đủ hàng trong kho.');
                }
                $variant->save();
            }

            // ✅ Áp dụng coupon và xóa giỏ hàng
            $this->saveUsedCoupon($pendingOrder->user_id);
            $cart = Cart::where('user_id', $pendingOrder->user_id)->first();
            if ($cart) {
                $cart->items()->delete();
                $cart->delete();
            }

            session()->forget('coupon');
            $pendingOrder->delete();

            DB::commit();
            return redirect()->route('client.checkout.thankyou')->with('success', 'Thanh toán VNPAY thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('client.checkout.index')->with('error', 'Đã xảy ra lỗi khi tạo đơn hàng: ' . $e->getMessage());
        }
    } else {
        return redirect()->route('client.checkout.index')->with('error', 'Thanh toán thất bại hoặc bị hủy.');
    }
}

private function saveUsedCoupon($userId)
{
    if (!session()->has('coupon')) {
        return;
    }

    $couponCode = session('coupon.code');

    $coupon = Coupon::where('code', $couponCode)->first();

    if (!$coupon) {
        return;
    }

    $coupon->increment('used');

    UserCoupon::updateOrInsert(
        [
            'user_id'   => $userId,
            'coupon_id' => $coupon->id,
        ],
        [
            'used_at'    => now(),
            'updated_at' => now(),
            'created_at' => now(),
        ]
    );
}

}