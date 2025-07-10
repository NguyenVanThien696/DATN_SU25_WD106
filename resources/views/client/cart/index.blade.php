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
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ảnh</th>
                                <th>Tên</th>
                                <th>Size</th>
                                <th>Màu</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                    <tr>
                                        <td><img src="{{ asset('storage/' . $variant->image) }}" width="80"></td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $variant->size->name ?? '—' }}</td>
                                        <td>{{ $variant->color->name ?? '—' }}</td>
                                        <td>{{ number_format($product->price) }}</td>
                                        <td>
                                            <input type="number" name="quantity[{{ $variant->id }}]" value="{{ $item->quantity }}"
                                                min="1" class="form-control quantity-input" style="width: 70px;">
                                        </td>
                                        <td class="item-subtotal">{{ number_format($subtotal) }}</td>
                                        <td>
                                            <a href="{{ route('client.cart.delete', $variant->id) }}"
                                                class="btn btn-sm btn-danger">X</a>
                                        </td>
                                    </tr>
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
                                    <tr>
                                        <td><img src="{{ asset('storage/' . $variant->image) }}" width="80"></td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $variant->size->name ?? '—' }}</td>
                                        <td>{{ $variant->color->name ?? '—' }}</td>
                                        <td>{{ number_format($product->price) }}</td>
                                        <td>
                                            <input type="number" name="quantity[{{ $variant->id }}]" value="{{ $item['quantity'] }}"
                                                min="1" class="form-control quantity-input" style="width: 70px;">
                                        </td>
                                        <td class="item-subtotal">{{ number_format($subtotal) }}</td>
                                        <td>
                                            <a href="{{ route('client.cart.delete', $variant->id) }}"
                                                class="btn btn-sm btn-danger">X</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <h4>Tổng tiền: <strong id="cart-total">{{ number_format($total) }} VNĐ</strong></h4>
                        <div>
                            <button type="submit" class="btn btn-primary me-2">Cập nhật giỏ hàng</button>
                            <a href="{{ route('client.cart.clear') }}" class="btn btn-danger">Xoá toàn bộ</a>
                        </div>
                    </div>
                </form>

                <div class="mt-5">
                    @auth
                        <a href="{{ route('client.checkout.index') }}" class="btn btn-black btn-lg py-3 btn-block">
                            Tiến hành thanh toán
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-danger btn-lg py-3 btn-block">
                            Đăng nhập để thanh toán
                        </a>
                    @endauth
                </div>
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

            const updateCartTotal = () => {
                let total = 0;
                document.querySelectorAll("tbody tr").forEach(row => {
                    total += updateRowSubtotal(row);
                });

                const totalDisplay = document.getElementById("cart-total");
                if (totalDisplay) {
                    totalDisplay.textContent = formatCurrency(total);
                }
            };

            document.querySelectorAll(".quantity-input").forEach(input => {
                input.addEventListener("change", () => {
                    if (parseInt(input.value) < 1) input.value = 1;
                    updateCartTotal();
                });
            });

            updateCartTotal();
        });
    </script>
@endsection