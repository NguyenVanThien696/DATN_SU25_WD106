@extends('client.master')

@section('content')

<div class="product-section">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <img id="main-image" src="{{ asset('storage/'. $product->image) }}" alt="Product Image" class="img-fluid" width="500">
        <div class="col-md-6">
    <div class="d-flex gap-2">
        @php
          $uniqueColorVariants = collect();
        @endphp

      @foreach ($product->variants as $variant)
        @if (!$uniqueColorVariants->contains('color_id', $variant->color_id))
          @php $uniqueColorVariants->push(['color_id' => $variant->color_id, 'image' => $variant->image, 'color_name' => $variant->color->name]); @endphp
          <img src="{{ asset('storage/'.$variant->image)}}" 
                alt="Ảnh màu {{$variant->color->name}}"
                class="img-thumbnail thumbnail-variant"
                data-color="{{$variant->color->id}}"
                data-image="{{ asset('storage/'.$variant->image)}}"
                width="80">
        @endif
      @endforeach
    </div>
</div>

      </div>
      <div class="col-md-6">
        <h2 class="text-black">{{$product->name}}</h2>
        <p class="mb-4">{{$product->description}}</p>
      <p>{{$stock}} sản phẩm</p>
      <form action="{{route('client.cart.add')}}" method="POST">
          @csrf
        {{-- <table class="table mt-2">
          <thead>
            <tr>
              <th>size</th>
              <th>color</th>
              <th>số lượng</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($product->variants as $variant)
              <tr>
                <td>{{$variant->size->name}}</td>
                <td>{{$variant->color->name}}</td>
                <td>{{$variant->stock}}</td>
            </tr>
            @endforeach
          </tbody>
        </table> --}}
        @php
          $sizes = $product->variants->pluck('size')->filter()->unique('id');
        @endphp
        <h4>Size</h4>
        <div class="d-flex gap-2" id="size-options">
        @foreach ($sizes as $size)
          <label style="cursor: pointer;">
            <input type="radio" name="size_id" value="{{$size->id}}" style="display: none;">
            <span style="
              padding: 5px 10px;
              border: 1px solid;
              border-radius: 4px;
              display: inline-block;
            ">
            {{$size->name}}
            </span>
          </label>
        @endforeach
        </div>
        @php
          $colors = $product->variants->pluck('color')->filter()->unique('id');
        @endphp
        <h4>Color</h4>
        <div style="display: flex; gap: 10px;">
          @foreach ($colors as $color)
            @php
              $variant = $product->variants->where('color_id', $color->id)->first();
            @endphp
            <label title="{{$color->name}}">
              <input type="radio" name="color_id" value="{{$color->id}}" class="color-radio" style="display: none;">
              <div style="
                width:30px;
                height:30px;
                border-radius:50%;
                background-color:{{$color->code}};
                border: 1px solid;
                cursor: pointer;
                display: inline-block;
                ">
              </div>
              
            </label>
          @endforeach
        </div>
        <p class="mb-4">{{$product->category->name}}</p>
        <p class="mb-4">{{$product->brand->name}}</p>
        <p><strong class="text-primary h4">{{number_format($product->price)}}</strong></p>
        <div class="mb-1 d-flex">
          <label for="quantity" class="form-label">Số lượng</label>
          <input type="number" name="quantity" id="quantity" class="form-control text-center mx-2" value="1" min="1" style="width: 100px;">
        </div>
        
          <input type="hidden" name="product_id" value="{{$product->id}}">
        <button type="submit" class="btn btn-primary mt-3">Thêm vào giỏ hàng</button>
      </div>
      </form>
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


<style>
  input[type="radio"]:checked + span{
    background-color: black;
    color: white;
    border-color: black;
  }
</style>

@endsection
