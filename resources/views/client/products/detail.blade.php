@extends('client.master')

@section('content')
<div class="product-section py-5">
    <div class="container-fluid px-4" style="max-width: 1400px;">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <!-- Ảnh sản phẩm -->
            <div class="col-md-6 mb-4">
                <div class="h-100 bg-white d-flex flex-column justify-content-between">
                    <img id="main-image" src="{{ asset('storage/'. $product->image) }}" class="img-fluid mb-3" alt="Ảnh chính">
                    <div class="d-flex gap-2 flex-wrap">
                        @php $uniqueColorVariants = collect(); @endphp
                        @foreach ($product->variants as $variant)
                            @if (!$uniqueColorVariants->contains('color_id', $variant->color_id))
                                @php $uniqueColorVariants->push(['color_id' => $variant->color_id]); @endphp
                                <img src="{{ asset('storage/'.$variant->image) }}"
                                    alt="{{ $variant->color->name }}"
                                    class="thumbnail-variant"
                                    data-color="{{ $variant->color->id }}"
                                    data-image="{{ asset('storage/'.$variant->image) }}"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cột phải: Thông tin -->
            <div class="col-md-6 mb-4">
                <div class="border p-4 rounded h-100 bg-white">
                    <h3 class="fw-bold mb-3 text-success">{{ $product->name }}</h3>
                    <p class="text-muted">{{ $product->description }}</p>
                    <p><strong>Tồn kho:</strong> {{ $stock }} sản phẩm</p>
                    <p><strong>Danh mục:</strong> {{ $product->category->name }}</p>
                    <p><strong>Thương hiệu:</strong> {{ $product->brand->name }}</p>

                    <form action="{{ route('client.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <!-- Chọn size -->
                        @php $sizes = $product->variants->pluck('size')->filter()->unique('id'); @endphp
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kích cỡ:</label>
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
                            <label class="form-label fw-bold">Màu sắc:</label>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach ($colors as $color)
                                    <label style="cursor: pointer;">
                                        <input type="radio" name="color_id" value="{{ $color->id }}" class="color-radio" style="display: none;">
                                        <span class="border px-3 py-1 rounded">{{ $color->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Giá -->
                        <div class="price-line mb-3">
                            <span class="label">Giá:</span>
                            <span class="price">{{ number_format($product->price) }} VNĐ</span>
                        </div>

                        <!-- Số lượng -->
                        <div class="mb-3 d-flex align-items-center">
                            <label for="quantity" class="me-2 mb-0 fw-bold">Số lượng:</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1"
                                class="form-control w-auto text-center" style="width: 100px;">
                        </div>

                        <button type="submit" class="btn btn-success mt-2 px-4">Thêm vào giỏ hàng</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sản phẩm liên quan -->
        <div class="related-products mt-5">
            <h4 class="mb-4">Sản phẩm liên quan</h4>
            <div class="row">
                @foreach ($relatedProducts as $related)
                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                        <a href="{{ route('client.products.detail', $related->id) }}" class="text-decoration-none text-dark">
                            <div class="border p-2 rounded h-100">
                                <img src="{{ asset('storage/' . $related->image) }}" class="img-fluid rounded" style="object-fit: cover; height: 200px; width: 100%;">
                                <h6 class="mt-2 text-truncate">{{ $related->name }}</h6>
                                <strong class="text-success">{{ number_format($related->price) }} VNĐ</strong>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Đánh giá -->
        <div class="review-section mt-5">
            <h4 class="mb-4">Đánh giá sản phẩm</h4>
            @forelse ($product->reviews as $review)
                <div class="border p-3 rounded mb-3 bg-light">
                    <div class="d-flex justify-content-between mb-2">
                        <strong class="text-success">{{ $review->user->name }}</strong>
                        <div class="text-warning">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                    <p>{{ $review->comment }}</p>
                </div>
            @empty
                <p class="text-muted">Chưa có đánh giá nào.</p>
            @endforelse

            @auth
                @if ($hasPurchased)
                    <form action="{{ route('client.reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-3 text-center">
                            <label class="form-label d-block">Đánh giá:</label>
                            <div class="star-rating">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" required>
                                    <label for="star{{ $i }}">★</label>
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
                    <p class="text-muted">Bạn cần mua sản phẩm này để đánh giá.</p>
                @endif
            @else
                <p><a href="{{ route('login') }}">Đăng nhập</a> để đánh giá</p>
            @endauth
        </div>
    </div>
</div>
<style>
/* Style cho input radio */
input[type="radio"]:checked + span {
    background-color: #3b5d50;
    color: white;
    border-color: #3b5d50;
}
label:hover span {
    border-color: #3b5d50;
}

/* Nút */
.btn-success {
    background-color: #3b5d50;
    border-color: #3b5d50;
}

/* Giá */
.price-line {
    display: flex;
    gap: 5px;
    align-items: center;
    border-bottom: 1px solid #eee;
    padding-bottom: 8px;
    margin-bottom: 12px;
}
.price-line .label {
    font-size: 16px;
    color: #333;
}
.price-line .price {
    font-size: 20px;
    font-weight: bold;
    color: #3b5d50;
}

/* Các dòng thông tin sản phẩm */
.product-info-line {
    border-bottom: 1px solid #eee;
    padding-bottom: 8px;
    margin-bottom: 12px;
}

/* Ảnh chính và ảnh nhỏ */
#main-image {
    border-radius: 8px;
    object-fit: contain;
    max-height: 400px;
    width: 100%;
    box-shadow: none;
}

.thumbnail-variant {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 2px;
    transition: all 0.2s ease;
}
.thumbnail-variant:hover {
    border-color: #3b5d50;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Đổi ảnh theo màu
    document.querySelectorAll('input[name="color_id"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            const selectedColor = this.value;
            const thumbnail = document.querySelector(`.thumbnail-variant[data-color="${selectedColor}"]`);
            if (thumbnail) {
                document.getElementById('main-image').src = thumbnail.dataset.image;
            }
        });
    });

    // Bắt buộc chọn trước khi thêm giỏ
    const form = document.querySelector('form[action="{{ route('client.cart.add') }}"]');
    form.addEventListener('submit', function (e) {
        const size = document.querySelector('input[name="size_id"]:checked');
        const color = document.querySelector('input[name="color_id"]:checked');
        if (!size || !color) {
            e.preventDefault();
            alert('Vui lòng chọn kích cỡ và màu sắc trước khi thêm vào giỏ hàng.');
        }
    });
});
</script>
@endsection
