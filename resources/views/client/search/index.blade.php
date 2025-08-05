@extends('client.master');

@section('content')

<h2 class="mt-5">Kết quả tìm kiếm cho <strong>{{request('s')}}</strong></h2>
<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        @if ($products->count() > 0)
        <div class="row">
            @foreach ($products as $product)
            <div class="col-12 col-md-4 col-lg-3 mb-5">
                {{-- <pre>{{dd($product->tag)}}</pre> --}}
               
                <a class="product-item" href="{{ route('client.products.detail', $product->id) }}">
                @if ($product->tag)
                    <span
                        class="product-tag badge bg-danger text-uppercase position-absolute tag-{{Str::slug($product->tag->name)}}"
                        style="">
                        <i class="fas fa-fire me-1"></i>{{ $product->tag->name }}
                    </span>
                @endif
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid product-thumbnail">

                    <h3 class="product-title">{{ $product->name }}</h3>
                    <strong class="product-price">{{ number_format($product->price) }} VNĐ</strong>

                    <span class="icon-cross">
                        <img src="{{ asset('assets/images/cross.svg') }}" class="img-fluid">
                    </span>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <p>Không tìm thấy sản phẩm nào phù hợp</p>
        @endif
    </div>
</div>
@endsection
