@extends('client.master')

@section('content')

<div class="product-section">

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="container mt-5">
    <div class="row">
        <!-- Cột trái: Ảnh sản phẩm -->
        <div class="col-md-6 d-flex">
            
            

            <div class="d-flex me-3 flex-column">
                @php $uniqueColorVariants = collect(); @endphp
                @foreach ($product->variants as $variant)
                    @if (!$uniqueColorVariants->contains('color_id', $variant->color_id))
                        @php
                            $uniqueColorVariants->push(['color_id' => $variant->color_id]);
                        @endphp
                        <img src="{{ asset('storage/uploads'.$variant->image) }}" alt="Ảnh màu {{ $variant->color->name }}"
                            class="img-thumbnail thumbnail-variant" data-color="{{ $variant->color->id }}"
                            data-image="{{ asset('storage/'.$variant->image)}}" style="width: 80px; height: 80px; object-fit: cover;">
                    @endif
                @endforeach
            </div>
            <div class="" style="position: relative">
                <img id="main-image" src="{{ asset('storage/'. $product->image) }}" class="img-fluid mb-3" width="400px" alt="Ảnh chính">
            </div>
        </div>

        <!-- Cột phải: Thông tin sản phẩm -->
        <div class="col-md-6">
            <h3 class="fw-bold mb-3">{{ $product->name }}</h3>
            <p class="text-muted">{{ $product->description }}</p>
            <hr>
            <div class="d-flex gap-5 mb-4">
                <p><strong>Tồn kho:</strong> {{ $stock }} sản phẩm</p>|

                <p><strong>Danh mục:</strong> {{ $product->category->name }}</p>|
                <p><strong>Thương hiệu:</strong> {{ $product->brand->name }}</p>
            </div>
            

            <form action="{{ route('client.cart.add') }}" method="POST">
                @csrf
                <div class="d-flex gap-5 mb-4">
                <!-- Chọn size -->
                @php $sizes = $product->variants->pluck('size')->filter()->unique('id'); @endphp
                <div class="mb-3">
                    <label class="form-label fw-bold">Chọn kích cỡ:</label>
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach ($sizes as $size)
                            <label style="cursor: pointer;">
                                <input type="radio" name="size_id" value="{{ $size->id }}" style="display: none;">
                                <span class="border px-3 py-1 rounded">{{ $size->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Chọn màu -->
                @php $colors = $product->variants->pluck('color')->filter()->unique('id'); @endphp
                <div class="mb-3">
                    <label class="form-label fw-bold">Chọn màu:</label>
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach ($colors as $color)
                            <label style="cursor: pointer;">
                                <input type="radio" name="color_id" value="{{ $color->id }}" class="color-radio" style="display: none;">
                                <span class="border px-3 py-1 rounded">{{ $color->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                </div>

                <div class="price-line mb-3">
                    <span class="label">Giá:</span>
                    <span class="price">{{number_format($product->price)}} VNĐ</span>
                </div>

                <!-- Số lượng -->
                <div class="mb-3 d-flex align-items-center">
                    <label for="quantity" class="me-2 mb-0 fw-bold">Số lượng:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control w-auto text-center" style="width: 100px;">
                </div>

                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-success mt-2 px-4">Thêm vào giỏ hàng</button>
            </form>
            <hr>
        </div>
        
            <div class="related-products mt-5">
                <h4>Sản phẩm liên quan</h4>
                <div class="row mt-5">
                    @foreach ($relatedProducts as $related)
                    <div class="col-12 col-md-4 col-lg-3 mb-5">
                        <a class="product-item d-block position-relative text-decoration-none"
                            href="{{route('client.products.detail', $related->id) }}">
                            <img src="{{ asset('storage/' . $related->image) }}" class="img-fluid product-thumbnail">
                            <h3 class="product-title mt-2">{{ $related->name }}</h3>
                            <strong class="product-price">{{ number_format($product->price) }} VNĐ</strong>
                            <span class="icon-cross">
<img src="{{ asset('assets/images/cross.svg') }}" class="img-fluid">
                            </span>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="review-section mt-5">
    <h4 class="text-xl font-semibold mb-4">Đánh giá sản phẩm</h4>

    @forelse ($product->reviews as $review)
        <div class="border p-3 rounded-lg mb-3 bg-gray-50">
            <div class="flex items-center justify-between mb-2">
                <strong class="text-green-700">{{ $review->user->name }}</strong>
                <div class="text-yellow-500">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $review->rating)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
            </div>
            <p class="text-gray-700">{{ $review->comment }}</p>
        </div>
    @empty
        <p class="text-gray-500">Chưa có đánh giá nào.</p>
    @endforelse
</div>

                @auth
                @if ($hasPurchased)
                    <form action="{{route('client.reviews.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">

                     <div class="form-group text-center">
                        <label for="rating" class="d-block mb-2">Đánh giá:</label>
                        <div class="star-rating">
                            @for ($i=5; $i>=1; $i--)
                                <input type="radio" name="rating" id="star{{$i}}" value="{{$i}}" required>
                                <label for="star{{$i}}">★</label>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">Nhận xét:</label>
                        <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                </form>
                @else
                    <p class="text-muted">Bạn cần mua sản phầm này trước khi đánh giá</p>
                @endif
                @else
                    <p><a href="{{route('login')}}">Đăng nhập</a> để gửi đánh giá</p>
                @endauth    
            </div>
        </div>
    </div>
</div>

<style>
/* Nút radio được chọn */
input[type="radio"]:checked + span {
    background-color: #3b5d50; /* Màu xanh */
    color: white;
    border-color: #3b5d50;
}

/* Hover size/màu */
label:hover span {
    border-color: #3b5d50;
}

/* Nút thêm vào giỏ hàng */
.btn-success {
    background-color: #3b5d50;
    border-color: #3b5d50;
}

.btn-success:hover {
    background-color: #3b5d50;
    border-color: #3b5d50;
}

/* Tên sản phẩm */
.product-section h3,
.product-section h2 {
    color: #3b5d50;
}

/* Giá sản phẩm */
.product-section .text-danger {
    color: #3b5d50 !important;
}

.price-line{
    display: flex;
    align-items: center;
    gap: 5px;
}

.price-line .label{
    font-weight: normal;
    font-size: 16px;
    color: #333;
}

.price-line .price{
    font-weight: bold;
    font-size: 20px;
    color: #3b5d50;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="{{route(
            'client.cart.add')
    }
}
"]');
form.addEventListener('submit', function(e) {
const sizeChecked = document.querySelector('input[name="size_id"]:checked');
const colorChecked = document.querySelector('input[name="color_id"]:checked');

if (!sizeChecked || !colorChecked) {
    e.preventDefault();
    alert('Vui lòng chọn size và màu sắc trước khi thêm vào giỏ hàng.');
}
});
});
</script>


@endsection