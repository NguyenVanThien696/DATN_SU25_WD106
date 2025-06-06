@extends('client.master')

@section('content')
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Cửa hàng <span clsas="d-block">Design Studio</span></h1>
                    <p class="mb-4">Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
                        vulputate velit imperdiet dolor tempor tristique.</p>
                    <p><a href="" class="btn btn-secondary me-2">Shop Now</a><a href="#"
                            class="btn btn-white-outline">Explore</a></p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero-img-wrap">
                    <img src="{{ asset('assets/images/couch.png')}}" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">
            @foreach ($listProducts as $product)
            <div class="col-12 col-md-4 col-lg-3 mb-5">
                <a class="product-item" href="{{ route('client.products.detail', $product->id) }}">
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
        <div class="mt-5">
            {{ $listProducts ->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection