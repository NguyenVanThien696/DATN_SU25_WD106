@extends('client.products.master')

@section('content1')

    <div class="untree_co-section product-section before-footer-section">
        <div class="container">
            <div class="row">
                @foreach ($listProducts as $product)
                    <div class="col-12 col-md-4 col-lg-3 mb-5">
                        <a class="product-item d-block position-relative text-decoration-none"
                            href="{{ route('client.products.detail', $product->id) }}">
                            @if ($product->tag)
                                <span
                                    class="product-tag badge bg-danger text-uppercase position-absolute tag-{{Str::slug($product->tag->name)}}"
                                    style="">
                                    <i class="fas fa-fire me-1"></i>{{ $product->tag->name }}
                                </span>
                            @endif
                            {{--
                            <pre>{{json_encode($product->tags)}}</pre> --}}
                            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid product-thumbnail">

                            <h3 class="product-title mt-2">{{ $product->name }}</h3>
                            <strong class="product-price">{{ number_format($product->price) }} VNĐ</strong>

                            <span class="icon-cross">
                                <img src="{{ asset('assets/images/cross.svg') }}" class="img-fluid">
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="mt-5">
                {{ $listProducts->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection