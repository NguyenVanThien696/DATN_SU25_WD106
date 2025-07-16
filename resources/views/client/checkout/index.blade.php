@extends('client.master')

@section('content')

@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger mt-2">{{ session('error') }}</div>
@endif

<form action="{{ route('client.checkout.process', $user->id) }}" method="POST">
    @csrf
    <div class="untree_co-section">
        <div class="container">
            <div class="row">
                {{-- Cột thông tin người nhận --}}
                <div class="col-md-6">
                    <h2 class="h3 mb-3 text-black">Chi tiết thanh toán</h2>
                    <div class="p-3 p-lg-5 border bg-white">
                        <div class="form-group">
                            <label class="text-black">Tên người dùng <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label class="text-black">Địa chỉ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="address"
                                value="{{ old('address', $user->address) }}">
                            @error('address')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label class="text-black">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email"
                                value="{{ old('email', $user->email) }}">
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label class="text-black">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone"
                                value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label class="text-black">Ghi chú</label>
                            <textarea class="form-control" name="c_order_notes"
                                rows="4">{{ old('c_order_notes') }}</textarea>
                            @error('c_order_notes')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="c_ship_different_address" class="text-black" data-bs-toggle="collapse"
                                href="#ship_different_address" role="button" aria-expanded="false"
                                aria-controls="ship_different_address">
                                <input type="checkbox" value="1" name="ship_to_different" id="c_ship_different_address"
                                    {{ old('ship_to_different') ? 'checked' : '' }}>
                                Giao đến một địa chỉ khác?
                            </label>

                            <div class="collapse" id="ship_different_address">
                                <div class="py-2">
                                    <div class="form-group row mt-3">
                                        <div class="col-md-12">
                                            <label class="text-black">Tên người nhận <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="shipping_name"
                                                value="{{ old('shipping_name') }}">
                                            @error('shipping_name')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
                                        <div class="col-md-12">
                                            <label class="text-black">Địa chỉ nhận hàng <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="shipping_address"
                                                value="{{ old('shipping_address') }}" placeholder="Street address">
                                            @error('shipping_address')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
                                        <div class="col-md-12">
                                            <label class="text-black">Địa chỉ Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="shipping_email"
                                                value="{{ old('shipping_email') }}" placeholder="Email">
                                            @error('shipping_email')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
                                        <div class="col-md-12">
                                            <label class="text-black">Số điện thoại <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="shipping_phone"
                                                value="{{ old('shipping_phone') }}" placeholder="Phone Number">
                                            @error('shipping_phone')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label class="text-black">Ghi chú đơn hàng</label>
                                        <textarea class="form-control" name="shipping_note"
                                            rows="4">{{ old('shipping_note') }}</textarea>
                                        @error('shipping_note')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cột đơn hàng --}}
                <div class="col-md-6">
                    <h2 class="h3 mb-3 text-black">Đơn hàng của bạn</h2>
                    <div class="p-3 p-lg-5 border bg-white">
                        <table class="table site-block-order-table mb-5 mt-5">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Kích cỡ</th>
                                    <th>Màu</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach ($products as $item)
                                @php
                                $variant = $item->variant;
                                $product = $variant->product;
                                $quantity = $item->quantity;
                                $subtotal = $product->price * $quantity;
                                $total += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $product->name }} x{{ $quantity }}</td>
                                    <td>{{ $variant->size->name ?? '---' }}</td>
                                    <td>{{ $variant->color->name ?? '---' }}</td>
                                    <td>{{ number_format($subtotal) }} đ</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3">Tạm tính</td>
                                    <td>{{ number_format($total) }} đ</td>
                                </tr>
                                <tr>
                                    <td colspan="3">Giảm giá</td>
                                    <td>- {{ number_format($discount) }} đ</td>
                                </tr>
                                <tr>
                                    <td colspan="3">Phí vận chuyển</td>
                                    <td>
                                        @if($shippingFee == 0)
                                        Miễn phí
                                        @else
                                        {{ number_format($shippingFee) }} đ
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Tổng cộng</strong></td>
                                    <td><strong>{{ number_format($finalTotal + $shippingFee) }} đ</strong></td>
                                </tr>

                            </tbody>
                            <div class="form-group mt-4">
                                <label class="text-black">Mã giảm giá</label>
                                <div class="input-group">
                                    <input type="text" name="coupon_code" class="form-control"
                                        placeholder="Nhập mã giảm giá"
                                        value="{{ old('coupon_code', session('coupon.code')) }}">
                                    <div class="input-group-append ms-2">
                                        <button type="submit" name="apply_coupon" value="1"
                                            class="btn btn-outline-dark">Áp dụng</button>
                                    </div>
                                </div>
                            </div>
                        </table>
                        <div class="form-group">
                            <label><strong>Phương thức thanh toán</strong></label><br>
                            <div class="border p-2">
                                <input type="radio" name="payment_method" value="cod"
                                    {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}>
                                Thanh toán khi nhận hàng
                            </div>
                            <div class="border p-2 mt-2">
                                <input type="radio" name="payment_method" value="vnpay"
                                    {{ old('payment_method') === 'vnpay' ? 'checked' : '' }}>
                                Thanh toán qua VNPay
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-black btn-lg btn-block">Đặt hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection