@extends('client.master')

@section('content')

<div class="product-section">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <img src="{{ asset('storage/'. $product->image) }}" alt="Product Image" class="img-fluid" width="450" height="280">
        <div class="col-md-6">
          <div class="d-flex gap-2">
            <img src="{{ asset('storage/'. $product->image) }}" alt="Ảnh phụ 1" class="img-thumbnail" width="80">
            <img src="{{ asset('storage/'. $product->image) }}" alt="Ảnh phụ 2" class="img-thumbnail" width="80">
            <img src="{{ asset('storage/'. $product->image) }}" alt="Ảnh phụ 3" class="img-thumbnail" width="80">
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <h2 class="text-black">{{$product->name}}</h2>
        <!-- Chọn size -->
        <div class="mb-3">
          <label class="form-label fw-bold">Chọn size:</label><br>
          @php
              $sizes = $product->variants->pluck('size')->unique('id')->values();
          @endphp
          @foreach ($sizes as $size)
              <label class="me-2">
                  <input type="radio" name="size_id" value="{{ $size->id }}" class="size-option"> {{ $size->name }}
              </label>
          @endforeach
        </div>

        <!-- Chọn màu (ẩn/hiện tùy theo size) -->
        <div class="mb-3">
          <label class="form-label fw-bold">Chọn màu:</label><br>
          @foreach ($product->variants as $variant)
              <span class="color-option size-{{ $variant->size_id }}" style="display: none;">
                  <label class="me-2">
                      <input type="radio" name="color_id" value="{{ $variant->color_id }}">
                      {{ $variant->color->name }}
                  </label>
              </span>
          @endforeach
        </div>

        <p><strong class="text-primary h4">{{number_format($product->price)}}</strong></p>

        <div class="mb-1 d-flex">
          <label for="quantity" class="form-label">Số lượng</label>
          <input type="number" id="quantity" class="form-control text-center mx-2" value="1" min="1" style="width: 100px;">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Thêm vào giỏ hàng</button>
      </div>

      <div class="mt-5">
        <h4>Đánh giá sản phẩm</h4>
        <form>
            <div class="mb-3">
                <label for="comment" class="form-label">Nhận xét:</label>
                <textarea id="comment" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Thêm script xử lý ẩn/hiện màu theo size -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const sizeRadios = document.querySelectorAll('.size-option');
    const colorOptions = document.querySelectorAll('.color-option');

    function hideAllColors() {
      colorOptions.forEach(option => {
        option.style.display = 'none';
        // Uncheck color radio khi ẩn
        const input = option.querySelector('input[type="radio"]');
        if(input) input.checked = false;
      });
    }

    sizeRadios.forEach(radio => {
      radio.addEventListener('change', function() {
        hideAllColors();

        const selectedSize = this.value;
        document.querySelectorAll('.color-option.size-' + selectedSize).forEach(option => {
          option.style.display = 'inline-block';
        });
      });
    });

    // Nếu muốn mặc định chọn size đầu tiên và hiện màu tương ứng
    if(sizeRadios.length > 0) {
      sizeRadios[0].checked = true;
      sizeRadios[0].dispatchEvent(new Event('change'));
    }
  });
</script>

@endsection
