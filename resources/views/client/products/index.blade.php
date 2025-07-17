@extends('client.products.master')

@section('content1')

    <div class="untree_co-section product-section before-footer-section">
        <div class="container">
            <div class="row1">
                @include('client.products.menu.breadcrumbs')
            </div>
        </div>
        <hr>       
        <div class="container py-5">         
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

    <style>
        .product-section{
            padding-top: 0 !important;
            margin-top: 0 !important;
        }
        .row1{
            /* font-size: 14px;
            color: gray;
            margin-bottom: 20px;
            border-bottom: 1px solid #e1e1e1;
            padding-bottom: 10px;
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw; */
            height: 40px;
            display: flex;
            align-items: center;
            padding-left: 20px;
            
        }
        .breadcrumb{
            margin: 0;
            padding: 0;
        }
        .container{

    }
    </style>
@endsection