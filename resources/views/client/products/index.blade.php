@extends('client.master')

@section('content')
<div class="hero">
    <div class="container">
        <div class="intro-excerpt">
            <h1>BỘ SƯU TẬP SENORA MỚI</h1>
            <p class="mb-4">
                Lấy cảm hứng từ những cảm xúc trong tâm hồn người phụ nữ – lúc dịu dàng như nốt trầm, khi rực rỡ
                như
                nốt cao – Charming Notes là bản hòa tấu, nơi mỗi thiết kế là một thanh âm riêng, khắc họa vẻ đẹp
                của
                từng cung bậc xúc cảm khác nhau. Tựa như một bản nhạc cổ điển được chơi bằng tất cả sự nâng niu
                và
                tinh tế, bộ sưu tập mới nhất của dòng Senora cao cấp cất lên những thanh âm thanh lịch, sâu lắng
                và
                đầy mê hoặc.
            </p>
            <p>
                <a href="{{ route('client.products.index') }}" class="btn btn-secondary">Mua ngay</a>
                <a href="#" class="btn btn-white-outline">Khám phá</a>
            </p>
        </div>
    </div>
</div>
<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">
            @foreach ($listProducts as $product)
            <div class="col-12 col-md-4 col-lg-3 mb-5">
                <span class="badge rounded-pill text-bg-danger">Danger</span>
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