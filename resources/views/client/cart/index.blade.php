@extends('client.master')

@section('content')
@if (session('success'))
  <div class="alert alert-success">{{session('success')}}</div>
@endif

@if(count($cart) > 0)
@php
  $total = 0;
@endphp
<div class="untree_co-section before-footer-section">
            <div class="container">
              <div class="row mb-5">
                <form class="col-md-12" method="post" action="{{route('client.cart.update')}}">
                  @csrf
                  <div class="site-blocks-table">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="product-thumbnail">Image</th>
                          <th class="product-name">Product</th>
                          <th class="product-price">Price</th>
                          <th class="product-quantity">Quantity</th>
                          <th class="product-total">Total</th>
                          <th class="product-remove">Remove</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($cart as $id => $item)
                        @php
                          $subtotal = $item['price'] * $item['quantity'];
                          $total += $subtotal;
                        @endphp
                        {{-- @dd($item); --}}
                          <tr>
                          <td class="product-thumbnail">

                            <img src="{{asset('storage/'.$item['options']['image'])}}" alt="Image" class="img-fluid">
                          </td>
                          <td class="product-name">
                            <h2 class="h5 text-black">{{$item['name']}}</h2>
                          </td>
                          <td>{{number_format($item['price'])}}</td>
                          <td>
                            <div class="input-group mb-3 d-flex align-items-center quantity-container" style="max-width: 120px;">
                              <input type="number" name="quantity[{{$id}}]" class="form-control text-center quantity-amount" value="{{$item['quantity']}}" min="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                            </div>
        
                          </td>
                          <td class="item-total">{{number_format($subtotal)}}</td>
                          <td><a href="{{route('client.cart.delete', $id)}}" class="btn btn-black btn-sm">X</a></td>
                        </tr>
                        @endforeach
                        <button type="submit">Cập nhật giỏ hàng</button>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="4" class="text-right"><strong>Tổng cộng:</strong></td>
                          <td colspan="2" id="cart-total" class="font-weight-bold"></td>
                        </tr>
                      </tfoot>

                    </table>
                  </div>
                </form>
                      <div class="row">
                        <div class="col-md-12">
                          <a href="{{ route('client.checkout.index') }}" class="btn btn-black btn-lg py-3 btn-block" onclick="submitCartAndGoToCheckout()">Proceed To Checkout</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          @else
            <p>Giỏ hàng trống</p>
          @endif
<script>
document.addEventListener('DOMContentLoaded', () => {
  const quantityContainers = document.querySelectorAll('.quantity-container');
  const totalDisplay = document.getElementById('cart-total');

  const formatCurrency = (num) => {
    return num.toLocaleString('vi-VN') + '₫';
  };

  const updateRowSubtotal = (row) => {
    const priceText = row.querySelector('td:nth-child(3)').textContent;
    const price = parseInt(priceText.replace(/[^\d]/g, '')) || 0;
    const quantity = parseInt(row.querySelector('.quantity-amount').value) || 1;
    const subtotal = price * quantity;
    const subtotalCell = row.querySelector('.item-subtotal');
    if (subtotalCell) {
      subtotalCell.textContent = formatCurrency(subtotal);
    }
    return subtotal;
  };

  const updateCartTotal = () => {
    let total = 0;
    document.querySelectorAll('tbody tr').forEach(row => {
      total += updateRowSubtotal(row);
    });
    if (totalDisplay) {
      totalDisplay.textContent = formatCurrency(total);
    }
  };

  quantityContainers.forEach(container => {
    const input = container.querySelector('.quantity-amount');
    const btnIncrease = container.querySelector('.increase');
    const btnDecrease = container.querySelector('.decrease');

    if (btnIncrease) {
      btnIncrease.addEventListener('click', (e) => {
        e.preventDefault();
        let value = parseInt(input.value) || 1;
        input.value = value + 1;
        updateCartTotal();
      });
    }

    if (btnDecrease) {
      btnDecrease.addEventListener('click', (e) => {
        e.preventDefault();
        let value = parseInt(input.value) || 1;
        input.value = Math.max(1, value - 1);
        updateCartTotal();
      });
    }

    input.addEventListener('change', () => {
      let value = parseInt(input.value);
      if (!value || value < 1) input.value = 1;
      updateCartTotal();
    });
  });

  updateCartTotal();
});

</script>


@endsection