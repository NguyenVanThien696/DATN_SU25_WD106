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

    {{-- @if (!empty($stockErrors))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($stockErrors as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
    
    @php $hasStockError = !empty($stockErrors); @endphp

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
                    <input type="checkbox" id="select-all" class="me-1"> Chọn tất cả
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
                                        <div class="d-flex border-bottom py-3 cart-item-row" data-quantity = "{{$item->quantity}}" data-stock="{{$variant->stock}}">
                                            <input type="checkbox" name="selected_items[]" value="{{$item->id}}" class="me-3 product-checkbox" data-price="{{$product->price}}" data-quantity="{{$item->quantity}}">
                                            <img src="{{asset('storage/' . $variant->image)}}" width="200px" class="me-3" alt="">
                                            <div class="flex-grow-1">
                                                <div class="error-msg" style="color: red; display:none;"></div>
                                                <h6>{{$product->name}}</h6>
                                                <p class="mb-1">Kích cỡ: {{$variant->size->name ?? '_'}}</p>
                                                <p class="mb-1">Màu: {{$variant->color->name ?? '_'}}</p>
                                                <p class="mb-1">Số lượng: {{$variant->stock ?? '_'}}</p>
                                                <p class="mb-1">Giá: {{number_format($product->price)}} VNĐ</p>
                                                <div class="d-flex align-items-center gap-2 mt-1">
                                                    <input type="number" name="quantity[{{$variant->id}}]" value="{{$item->quantity}}" data-item-id="{{$item->id}}" min="1" class="form-control me-2 quantity-input" style="width: 80px;">
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
                                {{-- <button type="submit" class="btn btn-primary btn-update-cart">Cập nhật giỏ hàng</button> --}}
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
                                    
                                    <form id="checkout-form" action="{{route('client.checkout.index')}}" method="get">
                                        @csrf
                                        <button type="button" id="checkout-btn" class="btn btn-black btn-checkout-cart w-100 py-2">Đặt hàng -></button>
                                    </form>



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
    const selectAll = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.product-checkbox');
    const cartTotalElement = document.getElementById('cart-total');

    function formatCurrency(number) {
        return number.toLocaleString('vi-VN') + ' VNĐ';
    }

    function updateCartTotal() {
        let total = 0;

        itemCheckboxes.forEach(cb => {
            if (cb.checked) {
                const price = parseInt(cb.dataset.price);
                const quantity = parseInt(cb.closest('.cart-item-row').querySelector('.quantity-input').value);
                total += price * quantity;
            }
        });

        if (cartTotalElement) {
            cartTotalElement.textContent = formatCurrency(total);
        }
    }

    // Khi chọn từng checkbox
    itemCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
            selectAll.checked = allChecked;
            updateCartTotal();
        });
    });

    // Chọn tất cả
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            itemCheckboxes.forEach(cb => cb.checked = this.checked);
            updateCartTotal();
        });
    }

    // Cập nhật số lượng bằng Ajax
    document.querySelectorAll(".quantity-input").forEach(input => {
        input.addEventListener("input", function () {
            if (parseInt(this.value) < 1) this.value = 1;

            const cartItemId = this.dataset.itemId;
            const quantity = this.value;

            fetch("{{ route('client.cart.updateQuantity') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart_item_id: cartItemId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartTotal();
                } else {
                    alert(data.message || 'Lỗi cập nhật.');
                }
            })
            .catch(() => {
                alert('Có lỗi xảy ra khi cập nhật số lượng.');
            });
        });
    });

    // Nút checkout
    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function (e) {
            const checkedItems = document.querySelectorAll('.product-checkbox:checked');
            if (checkedItems.length === 0) {
                alert('Vui lòng chọn ít nhất một sản phẩm để đặt hàng.');
                e.preventDefault();
                return;
            }

            let hasError = false;
            checkedItems.forEach(function (cb) {
                const item = cb.closest('.cart-item-row');
                const quantity = parseInt(item.getAttribute('data-quantity')) || 0;
                const inventory = parseInt(item.getAttribute('data-stock')) || 0;
                const errorBox = item.querySelector('.error-msg');

                if (errorBox) errorBox.style.display = 'none';

                if (quantity > inventory) {
                    hasError = true;
                    if (errorBox) {
                        errorBox.textContent = 'Sản phẩm không đủ tồn kho!';
                        errorBox.style.display = 'block';
                    }
                }
            });

            if (hasError) {
                e.preventDefault(); // chặn chuyển trang
                return;
            }

            const selectedIds = Array.from(checkedItems).map(cb => cb.value);
            const url = new URL('{{ route("client.checkout.index") }}', window.location.origin);
            url.searchParams.set('selected_items', selectedIds.join(','));

            window.location.href = url.toString();
        });
    }

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