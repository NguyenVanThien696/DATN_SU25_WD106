@extends('client.products.master')

@section('content1')
<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">
            @foreach ($listhot as $hot)
            <div class="col-12 col-md-4 col-lg-3 mb-5">
                <a class="product-item d-block position-relative text-decoration-none"
                    href="{{ route('client.products.detail', $hot->id) }}">
                    @if ($hot->tag)
                    <span
                        class="product-tag badge bg-danger text-uppercase position-absolute tag-{{Str::slug($hot->tag->name)}}">
                        <i class="fas fa-fire me-1"></i>{{ $hot->tag->name }}
                    </span>
                    @endif
                    <img src="{{ asset('storage/' . $hot->image) }}" class="img-fluid product-thumbnail">

                    <h3 class="product-title mt-2">{{ $hot->name }}</h3>
                    <strong class="product-price">{{ number_format($hot->price) }} VNĐ</strong>

                    <span class="icon-cross">
                        <img src="{{ asset('assets/images/cross.svg') }}" class="img-fluid">
                    </span>
                </a>
            </div>
            @endforeach
        </div>
        <div class="mt-5">
            {{ $listhot ->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection