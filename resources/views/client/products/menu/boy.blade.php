@extends('client.products.master')

@section('content1')
<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">
            @foreach ($listboy as $boy)
            <div class="col-12 col-md-4 col-lg-3 mb-5">
                <a class="product-item d-block position-relative text-decoration-none"
                    href="{{ route('client.products.detail', $boy->id) }}">
                    @if ($boy->tag)
                    <span
                        class="product-tag badge bg-danger text-uppercase position-absolute tag-{{Str::slug($boy->tag->name)}}"
                        style="">
                        <i class="fas fa-fire me-1"></i>{{ $boy->tag->name }}
                    </span>
                    @endif
                    <img src="{{ asset('storage/' . $boy->image) }}" class="img-fluid product-thumbnail">

                    <h3 class="product-title mt-2">{{ $boy->name }}</h3>
                    <strong class="product-price">{{ number_format($boy->price) }} VNĐ</strong>

                    <span class="icon-cross">
                        <img src="{{ asset('assets/images/cross.svg') }}" class="img-fluid">
                    </span>
                </a>
            </div>
            @endforeach
        </div>
        <div class="mt-5">
            {{ $listboy ->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection