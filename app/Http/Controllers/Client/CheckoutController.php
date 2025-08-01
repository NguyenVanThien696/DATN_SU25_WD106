<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\UserCoupon;

use App\Http\Controllers\Controller;
use App\Models\PendingOrder;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
        $shippingFee = $finalTotal >= 500000 ? 0 : 30000;

        // Tổng cần thanh toán sau khi cộng phí ship
        $finalWithShipping = $finalTotal + $shippingFee;

        session([
            'cart_total' => $total,
            'shipping_fee' => $shippingFee,
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


    public function thankyou()
    {
        return view('client.checkout.thankyou');
    }

    public function process(Request $request)
    {
        // dd($request->all());
        if ($request->has('apply_coupon')) {
            return $this->apply($request);  // Gọi hàm apply khi bấm "Áp dụng"
        }
        if ($request->has('ship_to_different')) {
            $request->validate([
                'shipping_name'    => 'required|string|max:255',
                'shipping_email'   => 'required|email|max:255',
                'shipping_phone'   => 'required|string|max:20',
                'shipping_address' => 'required|string|max:255',
            ]);
        } else {
            $request->validate([
                'name'    => 'required|string|max:255',
                'email'   => 'required|email|max:255',
                'phone'   => 'required|string|max:20',
                'address' => 'required|string|max:255',
            ]);
        }
        DB::beginTransaction();

        try {
            $userId = Auth::id();
            $user = Auth::user();

            $cart = Cart::with('items.variant.product')->where('user_id', $userId)->first();
            if (!$cart || $cart->items->isEmpty()) {
                return back()->with('error', 'Giỏ hàng của bạn đang trống.');
            }


            $total = $cart->items->sum(function ($item) {
                return $item->variant->product->price * $item->quantity;
            });

            // dd(session('coupon'));
            $discount = session('coupon.discount_amount', 0);
            $finalTotal = $total - $discount;

            $shippingFee = $finalTotal >= 500000 ? 0 : 30000;

            $finalTotalWithShipping = $finalTotal + $shippingFee;
            $paymentMethod = $request->input('payment_method', 'cod');
            $note = $request->input('c_order_notes');
            if ($request->has('ship_to_different')) {
                $note = $request->input('shipping_note');
            }
            if ($paymentMethod === 'vnpay') {
                $txnRef = uniqid($userId . '_');
                $orderCode = 'DH' . now()->format('HidmY') . strtoupper(Str::random(4));
                $pending = PendingOrder::create([
                    'txn_ref'     => $txnRef,
                    'order_code'  => $orderCode,
                    'user_id'     => $userId,
                    'total_price' => $finalTotalWithShipping,
                    'discount'    => $discount,
                    'coupon_id'      => optional(Coupon::where('code', session('coupon.code'))->first())->id,
                    'total_price' => $finalTotal + $shippingFee,
                    'discount' => $discount,
                    'shipping_fee' => $shippingFee,
                    'note'        => $note,
                    'user_info'   => [
                        'name'    => $request->input('name'),
                        'email'   => $request->input('email'),
                        'phone'   => $request->input('phone'),
                        'address' => $request->input('address'),
                    ],
                    'cart_items'  => $cart->items->map(function ($item) {
                        return [
                            'product_variant_id' => $item->product_variant_id,
                            'quantity'           => $item->quantity,
                            'price'              => $item->variant->product->price,
                        ];
                    })->toArray()
                ]);

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
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $txnRef,
                ];

                if (!empty($vnp_BankCode)) {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }

                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
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

            //         dd([
            //     '$shippingFee' => $shippingFee,
            //     '$finalTotal' => $finalTotal,
            //     '$finalTotalWithShipping' => $finalTotalWithShipping

            // ]);

            // Lấy thông tin người nhận từ form
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $address = $request->input('address');
            $note = $request->input('c_order_notes');

            if ($request->has('ship_to_different')) {
                $name = $request->input('shipping_name');
                $email = $request->input('shipping_email');
                $phone = $request->input('shipping_phone');
                $address = $request->input('shipping_address');
                $note = $request->input('shipping_note');
            }
            $orderCode = 'DH' . now()->format('HidmY') . strtoupper(Str::random(4));
            $order = Order::create([
                'user_id'        => $userId,
                'order_code'     => $orderCode,
                'total_price'    => $finalTotalWithShipping,
                'shipping_fee'   => $shippingFee,
                'discount'       => $discount,
                'coupon_id'      => optional(Coupon::where('code', session('coupon.code'))->first())->id,
                'status'         => 'pending',
                'note' => $note,
                'payment_method' => 'cod',
                'payment_status' => 'unpaid'
            ]);

            if (!$request->has('ship_to_different')) {
                $user->update([
                    'name'    => $request->input('name'),
                    'email'   => $request->input('email'),
                    'phone'   => $request->input('phone'),
                    'address' => $request->input('address'),
                ]);
            }

            if ($request->has('ship_to_different')) {
                ShippingAddress::create([
                    'order_id' => $order->id,
                    'name'     => $request->input('shipping_name'),
                    'phone'    => $request->input('shipping_phone'),
                    'email'    => $request->input('shipping_email'),
                    'address'  => $request->input('shipping_address'),
                    'note'     => $request->input('shipping_note'),
                ]);
                // dd($shipping);
            }

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


            $this->saveUsedCoupon($userId);
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

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        // Kiểm tra tồn tại
        if (!$coupon) {
            return back()->withInput()->with('error', 'Mã giảm giá không hợp lệ.');
        }

        // Kiểm tra trạng thái
        if ($coupon->status !== 'active') {
            return back()->withInput()->with('error', 'Mã giảm giá không còn hoạt động.');
        }

        // Kiểm tra thời gian hiệu lực
        $now = now();
        if (($coupon->start_at && $now->lt($coupon->start_at)) || ($coupon->end_at && $now->gt($coupon->end_at))) {
            return back()->withInput()->with('error', 'Mã giảm giá hiện không còn hiệu lực.');
        }

        // Kiểm tra số lượt sử dụng tối đa
        if (!is_null($coupon->usage_limit) && $coupon->used >= $coupon->usage_limit) {
            return back()->withInput()->with('error', 'Mã giảm giá đã được sử dụng hết.');
        }

        // Kiểm tra người dùng đã dùng mã này chưa
        $user = Auth::user();
        $used = UserCoupon::where('user_id', $user->id)
            ->where('coupon_id', $coupon->id)
            ->exists();

        if ($used) {
            return back()->withInput()->with('error', 'Bạn đã sử dụng mã giảm giá này rồi.');
        }

        // Lấy giỏ hàng
        $cart = Cart::with('items.variant.product')->where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Tính tổng tiền giỏ hàng
        $cartTotal = $cart->items->sum(function ($item) {
            return $item->variant->product->price * $item->quantity;
        });

        // Tính giá trị giảm
        if ($coupon->discount_type === 'percent') {
            $discount = round($cartTotal * ($coupon->discount_percent / 100));

            // Áp dụng giới hạn giảm tối đa nếu có
            if (!is_null($coupon->max_discount_amount)) {
                $discount = min($discount, $coupon->max_discount_amount);
            }
        } else {
            $discount = $coupon->discount_amount;
        }

        // Không để giảm quá tổng tiền
        $discount = min($discount, $cartTotal);

        // Lưu vào session
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
        //     \Log::info('VNPay SecureHash DEBUG', [
        //     'inputData' => $inputData,
        //     'hashData' => $hashData,
        //     'generatedHash' => $secureHash,
        //     'receivedHash' => $vnp_SecureHash,
        //     'match' => $secureHash === $vnp_SecureHash,
        //     'responseCode' => $request->vnp_ResponseCode,
        // ]);
        // \Log::info(' VNPay Hash Check:', [
        //     'expected' => $secureHash,
        //     'actual' => $vnp_SecureHash,
        //     'match' => $secureHash === $vnp_SecureHash,
        //     'hashData' => $hashData,
        // ]);

        if ($secureHash === $vnp_SecureHash && $request->vnp_ResponseCode == '00') {
            $txnRef = $request->vnp_TxnRef ?? null;
            // \Log::info(' tìm pending order với txn_ref: ' . $txnRef);
            $pendingOrder = PendingOrder::where('txn_ref', $txnRef)->first();
            if (!$pendingOrder) {
                return redirect()->route('client.checkout.index')->with('error', 'Không tìm thấy thông tin đơn hàng.');
            }
            \Log::info('🔗 Redirect đến VNPay với txn_ref: ' . $txnRef);

            DB::beginTransaction();
            try {
                $order = Order::create([
                    'user_id'        => $pendingOrder['user_id'],
                    'order_code'     => $pendingOrder->order_code,
                    'total_price'    => $pendingOrder['total_price'],
                    'discount'       => $pendingOrder['discount'] ?? 0,
                    'shipping_fee'   => $pendingOrder['shipping_fee'] ?? 0,
                    'status'         => 'pending',
                    'note'           => $pendingOrder['note'],
                    'payment_method' => 'vnpay',
                    'payment_status' => 'paid'
                ]);

                $user = User::find($pendingOrder['user_id']);
                $user->update($pendingOrder['user_info']);

                foreach ($pendingOrder['cart_items'] as $item) {
                    OrderItem::create([
                        'order_id'           => $order->id,
                        'product_variant_id' => $item['product_variant_id'],
                        'quantity'           => $item['quantity'],
                        'price'              => $item['price'],
                    ]);

                    $variant = \App\Models\ProductVariant::find($item['product_variant_id']);
                    $variant->stock -= $item['quantity'];
                    if ($variant->stock < 0) {
                        throw new \Exception('Sản phẩm không đủ hàng trong kho.');
                    }
                    $variant->save();
                }
                $this->saveUsedCoupon($pendingOrder['user_id']);
                $cart = Cart::where('user_id', $pendingOrder['user_id'])->first();
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
            // \Log::warning('VNPay: Sai chữ ký hoặc thất bại.', [
            //     'expected' => $secureHash,
            //     'actual' => $vnp_SecureHash,
            //     'hashData' => $hashData,
            //     'responseCode' => $request->vnp_ResponseCode
            // ]);
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
