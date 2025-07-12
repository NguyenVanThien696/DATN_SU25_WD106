@extends('client.master')

@section('content')


<div class="product-section  py-2">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container mt-5">
    <div class="row">
        <!-- Cột trái: Ảnh sản phẩm -->
        <div class="col-md-6 d-flex">
            <div class="d-flex me-3 flex-column">
                @php $uniqueColorVariants = collect(); @endphp
                @foreach ($product->variants as $variant)
                    @if (!$uniqueColorVariants->contains('color_id', $variant->color_id))
    <div class="product-section py-5">
        <div class="container" style="max-width: 1300px;">
            <div class="row">
                <!-- Ảnh chính -->
                <div class="col-md-6 mb-4" style="border-right: 1px solid #ddd;">
                    <div class="d-flex align-items-center">
                        @php
                            $variantImages = $product->variants->whereNotNull('image')->take(3);
                        @endphp
                        <img src="{{ asset('storage/uploads'.$variant->image) }}" alt="Ảnh màu {{ $variant->color->name }}"
                            class="img-thumbnail thumbnail-variant" data-color="{{ $variant->color->id }}"
                            data-image="{{ asset('storage/'.$variant->image)}}" style="width: 100px; height: 150px; object-fit: cover;">
                    @endif
                @endforeach
            </div>
            <div class="" style="position: relative">
                <img id="main-image" src="{{ asset('storage/'. $product->image) }}" class="img-fluid mb-3" width="500   px" alt="Ảnh chính">
            </div>
        </div>

        <!-- Cột phải: Thông tin sản phẩm -->
        <div class="col-md-6">
            <h1 class="fw-bold mb-3">{{ $product->name }}</h1>
            <h7 class="text-muted">{{ $product->description }}</h7>
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

                        <div class="d-flex flex-column align-items-center me-3" style="gap: 10px;">
                            @foreach ($variantImages as $variant)
                                <img src="{{ asset('storage/' . $variant->image) }}" alt="Biến thể" class="variant-thumb"
                                    style="width: 150px; height: 192px; object-fit: cover; border: 1px solid #ccc; border-radius: 8px; cursor: pointer;"
                                    onclick="document.getElementById('main-preview-image').src = this.src">
                            @endforeach
                        </div>

                        <div class="flex-grow-1 text-center">
                            <img id="main-preview-image" src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}" class="product-main-img img-fluid">
                        </div>
                    </div>
                </div>


                <!-- Thông tin sản phẩm -->
                <div class="col-md-6 mb-4" style="border-right: 1px solid #ddd;">
                    <h2 class="fw-bold text-success mb-3">{{ $product->name }}</h2>
                    <div class="product-info-line d-block">
                        <strong class="d-block mb-1">Mô tả sản phẩm:</strong>
                        <span class="text-muted">{{ $product->description }}</span>
                    </div>
                </div>
                </div>

                    <div class="product-info-group mb-3">
                        <div class="product-info-line">
                            <strong class="info-label">Tồn kho:</strong>
                            <span class="info-value">{{ $stock }} sản phẩm</span>
                        </div>
                        <div class="product-info-line">
                            <strong class="info-label">Danh mục:</strong>
                            <span class="info-value">{{ $product->category->name }}</span>
                        </div>
                        <div class="product-info-line">
                            <strong class="info-label">Thương hiệu:</strong>
                            <span class="info-value">{{ $product->brand->name }}</span>
                        </div>
                    </div>

                    <form action="{{ route('client.cart.add') }}" method="POST" data-cart-form>
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <!-- Kích cỡ -->
                        @php $sizes = $product->variants->pluck('size')->filter()->unique('id'); @endphp
                        <div class="product-info-line flex-column align-items-start">
                            <label class="form-label fw-bold mb-2">Kích cỡ:</label>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach ($sizes as $size)
                                    <label style="cursor: pointer;">
                                        <input type="radio" name="size_id" value="{{ $size->id }}" style="display: none;">
                                        {{-- {{ dump($size->id) }} --}}
                                        <span class="border px-3 py-1 rounded">{{ $size->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Màu sắc -->
                        @php
                            $uniqueColors = collect();
                            $colorVariants = $product->variants->filter(function ($v) use (&$uniqueColors) {
                                if (!$uniqueColors->contains($v->color_id)) {
                                    $uniqueColors->push($v->color_id);
                                    return true;
                                }
                                return false;
                            });
                        @endphp
                        <div class="mb-3">
                            <label class="form-label fw-bold">Màu sắc:</label>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach ($colorVariants as $variant)
                                    <label style="cursor: pointer;">
                                        <input type="radio" name="color_id" value="{{ $variant->color->id }}" {{-- {{
                                            dump($variant->color->id) }} --}}
                                        data-image="{{ asset('storage/' . $variant->image) }}" style="display: none;">
                                        <span class="border px-3 py-1 rounded">{{ $variant->color->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="price-line mb-3 mt-3">
                            <span class="label">Giá:</span>
                            <span class="price ">{{ number_format($product->price) }} VNĐ</span>
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

                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-success mt-2 px-4 w-100">Thêm vào giỏ hàng</button>
            </form>
            <hr>
        </div>
        
            <!-- Sản phẩm liên quan -->
            <hr class="my-5" style="border-top: 2px dashed #ccc;">
            <div class="related-products mt-5">
                <h4 class="mb-4">Sản phẩm liên quan</h4>
                <div class="row">
                    @foreach ($relatedProducts as $related)
                        <div class="col-6 col-md-4 col-lg-3 mb-4">
                            <a href="{{ route('client.products.detail', $related->id) }}"
                                class="text-decoration-none text-dark">
                                <div class="related-item">
                                    <!-- Ảnh -->
                                    <div class="image-wrapper">
                                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}">
                                    </div>

                                    <!-- Tên + Giá -->
                                    <div class="text-center mt-2">
                                        <p class="hover-name mb-1">{{ $related->name }}</p>
                                        <strong class="hover-price">{{ number_format($related->price) }} VNĐ</strong>
                                    </div>

                                    <!-- Nút + -->
                                    <div class="hover-plus">+</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Đánh giá -->
            <div id="review" class="review-section mt-5">
                <h4 class="mb-4">Đánh giá sản phẩm</h4>
                <div id="reviews-wrapper">
                    @foreach ($product->reviews->take(2) as $review)
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
                    @endforeach

                    <div id="more-reviews" class="d-none">
                        @foreach ($product->reviews->skip(2) as $review)
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
                        @endforeach
                    </div>

                    @if ($product->reviews->count() > 2)
                        <div class="text-center mt-3">
                            <button id="toggle-reviews" class="btn btn-outline-primary btn-sm">Xem thêm</button>
                        </div>
                    @endif
                </div>

                @auth
                    @if (count($canReviewItems))
                        <form id="review-form" action="{{ route('client.reviews.store') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="order_item_id" value="{{ $canReviewItems[0]->id }}">

                            <!-- Đánh giá sao -->
                            <div class="mb-3 star-rating d-flex flex-row-reverse justify-content-end">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}">
                                    <label for="star{{ $i }}" title="{{ $i }} sao">
                                        <i class="fas fa-star"></i>
                                    </label>
                                @endfor
                            </div>

                            <!-- Nội dung đánh giá -->
                            <div class="mb-3">
                                <label for="comment" class="form-label fw-bold">Nhận xét của bạn:</label>
                                <textarea class="form-control" name="comment" id="comment" rows="3" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                        </form>
                    @else
                        <p class="text-muted"></p>
                    @endif
                @else
                    <p><a href="{{ route('login') }}">Đăng nhập</a> để đánh giá sản phẩm</p>
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
    border-radius: 12px;
}

.btn-success:hover {
    background-color: #3b5d50;
    border-color: #3b5d50;
}

/* Tên sản phẩm */
.product-section h1,
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

    <!-- CSS -->
    <style>
        @media (min-width: 992px) {
            .col-lg-2-4 {
                flex: 0 0 auto;
                width: 20%;
            }
        }

        .product-main-img {
            max-width: 100%;
            max-height: 600px;
            border-radius: 16px;
            border: 2px solid #eee;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            object-fit: contain;
        }

        .product-info-line {
            padding: 4px 0;
            margin-bottom: 6px;
            border-bottom: 1px solid #dfdcdc;
            font-size: 15px;
            color: #333;
        }

        .info-label {
            min-width: 110px;
            color: #333;
        }

        .price-line .label {
            font-size: 16px;
            color: #333;
            font-weight: bold;
            /* thêm dòng này */
        }

        .info-value {
            color: #555;
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

        input[type="radio"]:checked+span {
            background-color: #3b5d50;
            color: white;
            border-color: #3b5d50;
        }

        label:hover span {
            border-color: #3b5d50;
        }

        .btn-success {
            background-color: #3b5d50;
            border-color: #3b5d50;
        }

        .star-rating input {
            display: none;
        }

        h5 {
            font-size: 17px;
        }

        .star-rating label {
            font-size: 24px;
            color: #ccc;
            cursor: pointer;
        }

        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #ffc107;
        }

        /* Related product styles */
        .related-item {
            border-radius: 16px;
            position: relative;
            transition: all 0.3s ease;
            cursor: pointer;
            padding-bottom: 12px;
        }

        .image-wrapper {
            height: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-wrapper img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
            border: 1px solid #ddd;
            border-radius: 12px;
        }

        .hover-plus {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            width: 36px;
            height: 36px;
            background: #000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .hover-name,
        .hover-price {
            transition: color 0.3s ease;
        }

        .related-item:hover .hover-plus {
            opacity: 1;
        }

        .related-item:hover img {
            transform: scale(1.05);
        }

        .related-item:hover .hover-name,
        .related-item:hover .hover-price {
            color: #3b5d50;
        }

        .variant-thumb:hover {
            transform: scale(1.08);
            border-color: #3b5d50;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>

    <!-- JS đổi ảnh theo màu -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form[data-cart-form]');
            if (form) {
                form.addEventListener('submit', function (e) {
                    const sizeChecked = document.querySelector('input[name="size_id"]:checked');
                    const colorChecked = document.querySelector('input[name="color_id"]:checked');

                    if (!sizeChecked || !colorChecked) {
                        e.preventDefault();
                        alert('Vui lòng chọn kích cỡ và màu sắc trước khi thêm vào giỏ hàng.');
                    }
                });
            }

            // JS đổi ảnh theo màu
            document.querySelectorAll('input[name="color_id"]').forEach(function (radio) {
                radio.addEventListener('change', function () {
                    const newImage = this.dataset.image;
                    if (newImage) {
                        document.getElementById('main-preview-image').src = newImage;
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Nếu URL có #review thì hiện form và cuộn tới đó
            if (window.location.hash === '#review') {
                const reviewForm = document.getElementById('review-form');
                const reviewSection = document.getElementById('review');

                if (reviewForm) {
                    reviewForm.style.display = 'block';
                }

                if (reviewSection) {
                    setTimeout(() => {
                        reviewSection.scrollIntoView({ behavior: 'smooth' });
                    }, 200);
                }
            }
        });
        //xem thêm đánh giá
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('toggle-reviews');
            const more = document.getElementById('more-reviews');

            if (btn && more) {
                btn.addEventListener('click', function () {
                    more.classList.toggle('d-none');
                    btn.textContent = more.classList.contains('d-none') ? 'Xem thêm' : 'Ẩn bớt';
                });
            }
        });
    </script>
@endsection