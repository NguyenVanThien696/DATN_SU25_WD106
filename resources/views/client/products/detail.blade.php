@extends('client.master')

@section('content')

<div class="product-section">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <img src="{{ asset('storage/'. $product->image) }}" alt="Product Image" class="img-fluid">
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
        <p class="mb-4">{{$product->stock}}</p>
        <p class="mb-4">{{$product->color}}</p>
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


@endsection
