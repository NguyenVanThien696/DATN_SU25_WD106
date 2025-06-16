@extends('client.master')

@section('content')
@php
$isLoggedIn = Auth::check();
@endphp
@if (session('success'))
<div class="alert alert-success">{{session('success')}}</div>
@endif

@if($isLoggedIn ? $cart && $cart->items->count() > 0 : count($cart) > 0)

<section class="cart-section py-5" style="min-height: 70vh">
    <div class="container">
        <h2 class="mb-4">Giỏ hàng</h2>
        <table class="table">
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

                        @if ($isLoggedIn && $cart && $cart->items)
                        {{-- <pre>
    {{ dd($cart) }}
                        </pre> --}}
                        @foreach ($cart->items as $item)
                        @php
                        $variant = $item->variant;
                        if(!$variant || !$variant->product){
                        continue;
                        }
                        $product = $variant->product;
                        $subtotal = $variant->price * $item->quantity;
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
                            <td class="item-subtotal">{{ number_format(($product->price) * $item->quantity) }}</td>
                            <td>
                                <a href="{{ route('client.cart.delete', $variant->id) }}"
                                    class="btn btn-sm btn-danger">X</a>
                            </td>
                        </tr>
                        @endforeach
                        <h4>Tổng tiền: <strong id="cart-total">{{ number_format($total) }} VNĐ</strong></h4>

                        @elseif(!$isLoggedIn && !empty($cart))
                        @php
                        $total = 0;
                        @endphp
                        @foreach ($cart as $item)
                        @php
                        $variant = App\Models\ProductVariant::with(['product', 'size',
                        'color'])->find($item['variant_id']);
                        $product = $variant->product;
                        $subtotal = $variant->price * $item['quantity'];
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
                            <td class="item-subtotal">{{ number_format(($product->price) * $item['quantity']) }}</td>
                            <td>
                                <a href="{{ route('client.cart.delete', $variant->id) }}"
                                    class="btn btn-sm btn-danger">X</a>
                            </td>
                        </tr>
                        @endforeach
                        <h4>Tổng tiền: <strong id="cart-total">{{ number_format($total) }} VNĐ</strong></h4>

                        @else
                        <tr>
                            <td colspan="8" class="text-center">Giỏ hàng trống</td>
                        </tr>
                        @endif
                    </tbody>
                </table>


            </form>


            @else
            <p>Giỏ hàng trống</p>
            @endif
        </table>
        @php
        $total = 0;
        @endphp
        @if ($total > 0)
        <div class="text-end">
            <h4>Tổng tiền: <strong>{{ number_format($total) }} VNĐ</strong></h4>
            <button type="submit" class="btn btn-primary">Cập nhật số lượng</button>
            <a href="{{ route('client.cart.clear') }}" class="btn btn-danger">Xoá toàn bộ</a>
        </div>
        @endif
        <div class="col-md-12">
            <a href="{{ route('client.checkout.index') }}" class="btn btn-black btn-lg py-3 btn-block">Tiến hành thanh
                toán</a>
        </div>
        <!-- 
        <div class="col-md-12">
            <a href="{{ route('client.checkout.index') }}"class="btn btn-black btn-lg py-3 btn-block">Tiến hành
                thanh
                toán</a>
        </div> -->
    </div>

</section>


<script>
document.addEventListener("DOMContentLoaded", function() {
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