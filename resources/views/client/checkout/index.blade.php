@extends('client.master')

@section('content')

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif


<form action="{{ route('client.checkout.process', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="untree_co-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="border p-4 rounded" role="alert">
                        Returning customer? <a href="#">Click here</a> to login
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-5 mb-md-0">
                    <h2 class="h3 mb-3 text-black">Chi tiết thanh toán</h2>
                    <div class="p-3 p-lg-5 border bg-white">

                        {{-- Các input --}}
                        <div class="form-group row mt-3">
                            <div class="col-md-12">
                                <label for="c_fname" class="text-black">Tên người dùng <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', Auth::user()->name ?? '') }}">
                            </div>
                        </div>

                        <div class="form-group row mt-3">
                            <div class="col-md-12">
                                <label for="c_address" class="text-black">Địa chỉ nhận hàng <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Street address"
                                    value="{{ old('address', Auth::user()->address ?? '') }}">
                            </div>
                        </div>

                        <div class="form-group row mt-3">
                            <div class="col-md-12">
                                <label for="c_email_address" class="text-black">Địa chỉ Email <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="email" name="email"
                                    value="{{ old('email', Auth::user()->email ?? '') }}">
                            </div>
                        </div>

                        <div class="form-group row mt-3">
                            <div class="col-md-12">
                                <label for="c_phone" class="text-black">Số điện thoại <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Phone Number" value="{{ old('phone', Auth::user()->phone ?? '') }}">
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="c_order_notes" class="text-black">Ghi chú đơn hàng</label>
                            <textarea name="c_order_notes" id="c_order_notes" cols="30" rows="5" class="form-control"
                                placeholder="Viết ghi chú của bạn ở đây..."></textarea>
                        </div>

                        {{-- Giao đến địa chỉ khác --}}
                        <div class="form-group mt-3">
                            <label for="c_ship_different_address" class="text-black" data-bs-toggle="collapse"
                                href="#ship_different_address" role="button" aria-expanded="false"
                                aria-controls="ship_different_address">
                                <input type="checkbox" value="1" name="ship_to_different" id="c_ship_different_address">
                                Giao đến một địa chỉ khác?
                            </label>

                            <div class="collapse" id="ship_different_address">
                                <div class="py-2">
                                    <div class="form-group row mt-3">
                                        <div class="col-md-12">
                                            <label class="text-black">Tên người nhận <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="shipping_name">
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
                                        <div class="col-md-12">
                                            <label class="text-black">Địa chỉ nhận hàng <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="shipping_address"
                                                placeholder="Street address">
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
                                        <div class="col-md-12">
                                            <label class="text-black">Địa chỉ Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="shipping_email">
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
                                        <div class="col-md-12">
                                            <label class="text-black">Số điện thoại <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="shipping_phone"
                                                placeholder="Phone Number">
                                        </div>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label class="text-black">Ghi chú đơn hàng</label>
                                        <textarea name="shipping_note" cols="30" rows="5" class="form-control"
                                            placeholder="Viết ghi chú của bạn ở đây..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cột bên phải --}}
                <div class="col-md-6">
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <input type="hidden" name="coupon" id="hidden-coupon">
                            <h2 class="h3 mb-3 text-black">Mã giảm giá</h2>
                            <div class="p-3 p-lg-5 border bg-white">
                                <label for="c_code" class="text-black mb-3">Nhập mã phiếu giảm giá</label>
                                <div class="input-group w-75 couponcode-wrap">
                                    <input type="text" class="form-control me-2" name="coupon" id="c_code"
                                        placeholder="Coupon Code">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-black btn-sm" id="apply-coupon-btn">Áp
                                            dụng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Danh sách sản phẩm --}}
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h2 class="h3 mb-3 text-black">Đơn hàng của bạn</h2>
                            <div class="p-3 p-lg-5 border bg-white">
                                <table class="table site-block-order-table mb-5">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Kích cỡ</th>
                                            <th>Màu</th>
                                            <th>Tổng cộng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0; @endphp
                                        @foreach ($products as $item)
                                        @php
                                        $variant = $item->variant;
                                        $product = $variant->product;
                                        $quantity = $item->quantity;
                                        $price = $product->price;
                                        $subtotal = $price * $quantity;
                                        $total += $subtotal;
                                        @endphp
                                        <tr>
                                            <td>{{ $product->name }} <strong class="mx-2">x</strong> {{ $quantity }}
                                            </td>
                                            <td>{{ $variant->size->name ?? '---' }}</td>
                                            <td>{{ $variant->color->name ?? '---' }}</td>
                                            <td>{{ number_format($subtotal) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-black font-weight-bold"><strong>Tạm tính</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-black font-weight-bold">{{ number_format($total) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-black font-weight-bold">Giảm giá</td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-black" id="discount-amount">0</td>
                                        </tr>
                                        <tr>
                                            <td class="text-black font-weight-bold"><strong>Tổng đơn hàng</strong>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-black font-weight-bold" id="final-total">
                                                <strong>{{ number_format($total) }}</strong>
                                            </td>
                                            <input type="hidden" name="coupon" id="hidden-coupon">
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="form-group mt-3">
                                    <label><strong>Phương thức thanh toán</strong></label><br>
                                    <div class="border p-3 mb-3 mt-3">
                                        <input class="form-check-input" type="radio" name="payment_method" value="cod"
                                            checked>
                                        <label class="form-check-label">Thanh toán khi nhận hàng</label>
                                    </div>
                                    <div class="border p-3 mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method" value="momo">
                                        <label class="form-check-label">Thanh toán qua MoMo</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-black btn-lg py-3 btn-block">Đặt
                                        hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col-md-6 -->
            </div> <!-- end row -->
        </div>
    </div> <!-- end container -->
</form>

@endsection