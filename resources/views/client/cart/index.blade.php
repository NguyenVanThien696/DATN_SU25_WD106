@extends('client.master')

@section('content')
    @php
        $isLoggedIn = Auth::check();
        $hasCartItems = false;

        if ($isLoggedIn && $cart && $cart->items && $cart->items->count() > 0) {
            $hasCartItems = true;
        }

        if (!$isLoggedIn && is_array($cart) && count($cart) > 0) {
            $hasCartItems = true;
        }
        
    @endphp


    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($hasCartItems)
        <section class="cart-section py-5" style="min-height: 70vh">
            <div class="container">
                <h2 class="mb-4">Giỏ hàng</h2>
                <form method="POST" action="{{ route('client.cart.update') }}">
                    @csrf
                    <div class="row">

                        <div class="col-lg-8">
                            <div class="card p-3">
                            
                            @php $total = 0; @endphp
                            @if ($isLoggedIn)
                                @foreach ($cart->items as $item)
                                    @php
                                        $variant = $item->variant;
                                        if (!$variant || !$variant->product)
                                            continue;
                                        $product = $variant->product;
                                        $subtotal = $product->price * $item->quantity;
                                        $total += $subtotal;
                                    @endphp
                                        <div class="d-flex border-bottom py-3">
                                            <img src="{{asset('storage/' . $variant->image)}}" width="200px" class="me-3" alt="">
                                            <div class="flex-grow-1">
                                                <h6>{{$product->name}}</h6>
                                                <p class="mb-1">Kích cỡ: {{$variant->size->name ?? '_'}}</p>
                                                <p class="mb-1">Màu: {{$variant->color->name ?? '_'}}</p>
                                                <p class="mb-1">Giá: {{number_format($product->price)}} VNĐ</p>
                                                <div class="d-flex align-items-center gap-2 mt-1">
                                                    <input type="number" name="quantity[{{$variant->id}}]" value="{{$item->quantity}}" min="1" class="form-control me-2" style="width: 80px;">
                                                    <span class="me-2"><Strong>{{number_format($subtotal)}} VNĐ</Strong></span>
                                                    <a href="{{ route('client.cart.delete', $variant->id) }}"
                                                class="btn btn-sm btn-danger">X</a>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                            @else
                                @foreach ($cart as $item)
                                    @php
                                        $variant = App\Models\ProductVariant::with(['product', 'size', 'color'])->find($item['variant_id']);
                                        if (!$variant || !$variant->product)
                                            continue;
                                        $product = $variant->product;
                                        $subtotal = $product->price * $item['quantity'];
                                        $total += $subtotal;
                                    @endphp
                                        <div class="d-flex border-bottom py-3">
                                            <img src="{{asset('storage/' . $variant->image)}}" width="200px" class="me-3" alt="">
                                            <div class="flex-grow-1">
                                                <h6>{{$product->name}}</h6>
                                                <p class="mb-1">Kích cỡ: {{$variant->size->name ?? '_'}}</p>
                                                <p class="mb-1">Màu: {{$variant->color->name ?? '_'}}</p>
                                                <p class="mb-1">Giá: {{number_format($product->price)}} VNĐ</p>
                                                <div class="d-flex align-items-center gap-2 mt-1">
                                                    <input type="number" name="quantity[{{$variant->id}}]" value="{{$item->quantity}}" min="1" class="form-control me-2" style="width: 80px;">
                                                    <span class="me-2"><Strong>{{number_format($subtotal)}} VNĐ</Strong></span>
                                                    <a href="{{ route('client.cart.delete', $variant->id) }}"
                                                class="btn btn-sm btn-danger">X</a>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                            @endif
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-update-cart">Cập nhật giỏ hàng</button>
                                <a href="{{ route('client.cart.clear') }}" class="btn btn-danger btn-delete-all">Xoá toàn bộ</a>
                            </div>

                            </div>
                        </div>
                        
                    {{-- Cột đơn hàng --}}
                    <div class="col-lg-4">
                        <div class="card p-4 shadow-sm border-0">
                            {{-- <div class="d-flex justify-content-between mb-2">
                                <span>Tổng tiền</span>
                                <strong id="cart-total">{{ number_format($total) }} VNĐ</strong>
                            </div> --}}
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tổng tiền</span>
                                <strong id="cart-total">{{ number_format($total) }} VNĐ</strong>
                            </div>
                            <div class="d-grip gap-2">
                                @auth
                                    <a href="{{ route('client.checkout.index') }}" class="btn btn-black btn-checkout-cart w-100 py-2" style="font-size: 16px;">
                                        Đặt hàng ->
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-danger btn-lg py-3 btn-block">
                                        Đăng nhập để thanh toán
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </section>
    @else
        <div class="container py-5" style="min-height: 70vh">
            <h4 class="text-center">Giỏ hàng của bạn đang trống.</h4>
        </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const formatCurrency = (num) => {
                return num.toLocaleString('vi-VN') + ' VNĐ';
            };

            const updateRowSubtotal = (row) => {
                const priceCell = row.querySelector("td:nth-child(5)");
                const quantityInput = row.querySelector(".quantity-input");
                const subtotalCell = row.querySelector(".item-subtotal");

                if (!priceCell || !quantityInput || !subtotalCell) return 0;

                const price = parseInt(priceCell.textContent.replace(/[^\d]/g, '')) || 0;
                const quantity = parseInt(quantityInput.value) || 1;
                const subtotal = price * quantity;

                subtotalCell.textContent = formatCurrency(subtotal);
                return subtotal;
            };

            // const updateCartTotal = () => {
            //     let total = 0;
            //     document.querySelectorAll("tbody tr").forEach(row => {
            //         total += updateRowSubtotal(row);
            //     });

            //     const totalDisplay = document.getElementById("cart-total");
            //     if (totalDisplay) {
            //         totalDisplay.textContent = formatCurrency(total);
            //     }
            // };

            document.querySelectorAll(".quantity-input").forEach(input => {
                input.addEventListener("change", () => {
                    if (parseInt(input.value) < 1) input.value = 1;
                    updateCartTotal();
                });
            });

            updateCartTotal();
        });
    </script>

    <style>
        .btn-update-cart{
            padding: 6px 16px;
            font-size: 14px;
            height: 38px;
            width: auto;
        }
        .btn-delete-all{
            padding: 6px 16px;
            font-size: 14px;
            height: 38px;
            width: auto;
        }
        .btn-checkout-cart{
            background-color: #3b5d50;
        }
        .btn-checkout-cart:hover{
            background-color: #324f45;
        }
    </style>
@endsection