@extends('client.master')
@push('styles')
    <style>
        .hero-section {
            margin: 0;
            padding: 0;
            position: relative;
            top: 0;
            z-index: 0;
        }

        #heroCarousel {
            width: 100vw%;
            margin: 0 auto;
            overflow: hidden;
        }

        #heroCarousel .carousel-inner {
            width: 100vw%;
        }

        #heroCarousel .carousel-item {
            width: 100vw%;
            text-align: center;
        }

        #heroCarousel .carousel-item img {
            width: 100%;
            height: auto;
            /* max-height: 715px; */
            /* object-fit: cover; */
            object-fit: contain;
            object-position: center;
            display: block;
            margin: 0 auto;
        }

        .custom-carousel-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.25);
            border: none;
            padding: 0.5rem;
            z-index: 10;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .carousel-control-prev.custom-carousel-control {
            left: 1rem;
        }

        .carousel-control-next.custom-carousel-control {
            right: 1rem;
        }

        .custom-carousel-control:hover {
            background: rgba(0, 0, 0, 0.5);
            transform: translateY(-50%) scale(1.05);
        }

        .custom-carousel-control i {
            font-size: 20px;
            color: #fff;
            pointer-events: none;
        }

        .carousel-indicators {
            bottom: 20px;
        }

        .carousel-indicators [data-bs-target] {
            width: 10px;
            height: 10px;
            background-color: #fff;
            opacity: 0.6;
            transition: opacity 0.3s ease;
            border-radius: 50%;
            margin: 0 4px;
        }

        .carousel-indicators .active {
            opacity: 1;
            background-color: #fff;
        }
    </style>
@endpush

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Banner -->
    <div class="hero-section">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">
            <!-- Indicators -->
            <div class="carousel-indicators">
                @foreach ($banners as $key => $banner)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}"
                        class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $key + 1 }}"></button>
                @endforeach
            </div>

            <!-- Slide Items -->
            <div class="carousel-inner">
                @foreach ($banners as $key => $banner)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $banner->image) }}" class="d-block w-100" alt="Banner {{ $key + 1 }}">
                    </div>
                @endforeach
            </div>

            <!-- Custom Prev/Next Controls -->
            <button class="carousel-control-prev custom-carousel-control" type="button" data-bs-target="#heroCarousel"
                data-bs-slide="prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-control-next custom-carousel-control" type="button" data-bs-target="#heroCarousel"
                data-bs-slide="next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <!-- Start Product Section -->
    <div class="product-section">
        <div class="container">
            <div class="row">

                <!-- Start Column 1 -->
                <div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
                    <h2 class="mb-4 section-title">Vững vàng phong cách – Không ngại thay đổi.</h2>
                    <p class="mb-4">Tự tin bước đi với phong cách riêng – Thiết kế tinh tế, chất liệu cao cấp, tôn vinh từng
                        chuyển động. </p>
                    <p><a href="{{ route('client.products.index') }}" class="btn">Khám phá </a></p>
                </div>
                <!-- End Column 1 -->

                <!-- Start Column 2 -->
                @foreach ($listProducts as $product)
                    <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                        <a class="product-item" href="{{ route('client.products.detail', $product->id) }}">
                            @if ($product->tag)
                                <span
                                    class="product-tag badge bg-danger text-uppercase position-absolute tag-{{Str::slug($product->tag->name)}}">
                                    <i class="fas fa-fire me-1"></i>{{ $product->tag->name }}
                                </span>
                            @endif
                            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid product-thumbnail">
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <strong class="product-price">{{ number_format($product->price) }} VNĐ</strong>

                            <span class="icon-cross">
                                <img src="{{asset('assets/images/cross.svg')}}" class="img-fluid">
                            </span>
                        </a>
                    </div>
                @endforeach

                <!-- End Column 2 -->

            </div>
        </div>
    </div>
    <!-- End Product Section -->

    <!-- Start Why Choose Us Section -->
    <div class="why-choose-section">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6">
                    <h2 class="section-title">Vì Sao Chọn Chúng Tôi?</h2>
                    <p>Thiết kế thời thượng, chất liệu cao cấp – Từng sản phẩm đều được chăm chút tỉ mỉ để mang lại sự thoải
                        mái và đẳng cấp cho bạn.</p>

                    <div class="row my-5">
                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{asset('assets/images/truck.svg')}}" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Giao Hàng Nhanh &amp; Miễn Phí</h3>
                                <p>Chúng tôi giao hàng siêu tốc toàn quốc, hoàn toàn miễn phí – Đảm bảo sản phẩm đến tay bạn
                                    một cách nhanh chóng, an toàn và nguyên vẹn.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{asset('assets/images/bag.svg')}}" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Mua Sắm Dễ Dàng</h3>
                                <p>Từ chọn sản phẩm đến thanh toán – Tất cả được tối ưu để bạn mua sắm dễ dàng và thoải mái
                                    nhất.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{asset('assets/images/support.svg')}}" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Luôn sẵn sàng – Mọi lúc, mọi nơi.</h3>
                                <p>Chúng tôi luôn đồng hành cùng bạn – Hỗ trợ nhanh, tận tâm 24/7 để bạn an tâm mua sắm mọi
                                    lúc.
                                </p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{asset('assets/images/return.svg')}}" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Đổi Trả Dễ Dàng</h3>
                                <p>Mua sắm không lo rủi ro – Đổi trả dễ dàng trong thời gian quy định, không cần giải thích
                                    phức tạp.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="img-wrap">
                        <img src="{{asset('assets/images/8c7b81636f1de2272713b5a1bc260ce6.jpg')}}" alt="Image"
                            class="img-fluid">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Why Choose Us Section -->

    <!-- Start We Help Section -->
    <div class="we-help-section">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-7 mb-5 mb-lg-0">
                    <div class="imgs-grid">
                        <div class="grid grid-1"><img src="{{asset('assets/images/f93127109a0bc034758a74c7c167cae2.jpg')}}"
                                alt="Untree.co"></div>
                        <div class="grid grid-2"><img src="{{asset('assets/images/13c3ce1e479832518aac5939f8e72202.jpg')}}"
                                alt="Untree.co"></div>
                        <div class="grid grid-3"><img src="{{asset('assets/images/cdd198c0e21ee06416b59566e5191221.jpg')}}"
                                alt="Untree.co"></div>
                    </div>
                </div>
                <div class="col-lg-5 ps-lg-5">
                    <h2 class="section-title mb-4">Tối giản nhưng tinh tế – Cá tính nhưng vẫn thanh lịch.</h2>
                    <p>Chúng tôi không chỉ bán quần áo, mà mang đến cho bạn phong cách sống.
                        Từng thiết kế đều được chọn lọc kỹ lưỡng về chất liệu, phom dáng và cảm hứng thời trang – để bạn
                        luôn tự tin trong mọi khoảnh khắc.</p>

                    <ul class="list-unstyled custom-list my-4">
                        <li>Thiết kế thời thượng</li>
                        <li>Chất liệu cao cấp</li>
                        <li>Form dáng chuẩn đẹp</li>
                        <li>Thoải mái vận động</li>
                    </ul>
                    <p><a herf="#" class="btn">Khám phá </a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End We Help Section -->

    <!-- Start Popular Product -->
    <div class="popular-product">
        <div class="container">
            <div class="row">

                <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="product-item-sm d-flex">
                        <div class="thumbnail">
                            <img src="{{asset('assets/images/2cd29cb091d387c93b51e76efba9cb5a.jpg')}}" alt="Image"
                                class="img-fluid">
                        </div>
                        <div class="pt-3">
                            <h3>Bộ sưu tập mới</h3>
                            <p>Thiết kế tối giản, tinh tế – Đậm chất thời trang hiện đại.</p>
                            <p><a href="{{ route('client.products.index') }}">Xem thêm </a></p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="product-item-sm d-flex">
                        <div class="thumbnail">
                            <img src="{{asset('assets/images/BGVTMixTw1r5Cohm1Nseo42fBmHm1cvMrjujixKr.png')}}" alt="Image"
                                class="img-fluid">
                        </div>
                        <div class="pt-3">
                            <h3>Áo Khoác Gió Cao Cấp</h3>
                            <p>Chất liệu nhẹ – Dễ mặc – Sang trọng từng chi tiết.</p>
                            <p><a href="{{ route('client.products.index') }}">Xem thêm </a></p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="product-item-sm d-flex">
                        <div class="thumbnail">
                            <img src="{{asset('assets/images/DGykQVFekuX3ZHYqPFooKK7RtdGusVAxUagEegZo.png')}}" alt="Image"
                                class="img-fluid">
                        </div>
                        <div class="pt-3">
                            <h3>Thiết Kế Tối Ưu Dáng Vóc </h3>
                            <p>Phom dáng chuẩn – Thoải mái vận động – Tôn lên nét riêng trong từng chuyển động.</p>
                            <p><a href="{{ route('client.products.index') }}">Xem thêm </a></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Popular Product -->

    <!-- Start Testimonial Slider -->
    <div class="testimonial-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto text-center">
                    <h2 class="section-title">Khách Hàng Nói Gì Về Chúng Tôi </h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="testimonial-slider-wrap text-center">

                        <div id="testimonial-nav">
                            <span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
                            <span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
                        </div>

                        <div class="testimonial-slider">

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;Tôi thực sự ấn tượng với chất lượng vải và phom dáng tại đây.
                                                    Không chỉ đẹp về kiểu dáng mà còn cực kỳ thoải mái – một sự kết hợp hiếm
                                                    có trong thời trang hiện đại.&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="{{ asset('assets/images/person-1.png')}}" alt="Maria Jones"
                                                        class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Nguyễn Văn Thiện</h3>
                                                <span class="position d-block mb-3">Sinh viên</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;Trang phục không chỉ tôn dáng mà còn thể hiện gu thẩm mỹ rõ nét.
                                                    Tôi cảm nhận được sự đầu tư chỉn chu trong từng chi tiết nhỏ. Mỗi lần
                                                    mặc là một lần tự tin hơn.&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="{{ asset('assets/images/person-1.png')}}" alt="Maria Jones"
                                                        class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Triệu Đặng Chiến</h3>
                                                <span class="position d-block mb-3">Sinh viên</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;Tôi đã thử rất nhiều thương hiệu, nhưng ở đây thì khác biệt. Dịch
                                                    vụ nhanh, nhân viên nhiệt tình và sản phẩm thì không có điểm chê. Đúng
                                                    chuẩn ‘mặc là mê’!&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="{{asset('assets/images/person-1.png')}}" alt="Maria Jones"
                                                        class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Dương</h3>
                                                <span class="position d-block mb-3">Sinh viên</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonial Slider -->

    <!-- Start Blog Section -->
    <!-- <div class="blog-section">
                                                <div class="container">
                                                    <div class="row mb-5">
                                                        <div class="col-md-6">
                                                            <h2 class="section-title">Bài Viết Mới Nhất</h2>
                                                        </div>
                                                        <div class="col-md-6 text-start text-md-end">
                                                            <a href="#" class="more">View All Posts</a>
                                                        </div>
                                                    </div>

                                                    <div class="row">

                                                        <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
                                                            <div class="post-entry">
                                                                <a href="#" class="post-thumbnail"><img src="{{ asset('assets/images/post-1.jpg')}}" alt="Image"
                                                                        class="img-fluid"></a>
                                                                <div class="post-content-entry">
                                                                    <h3><a href="#">First Time Home Owner Ideas</a></h3>
                                                                    <div class="meta">
                                                                        <span>by <a href="#">Kristin Watson</a></span> <span>on <a href="#">Dec 19, 2021</a></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
                                                            <div class="post-entry">
                                                                <a href="#" class="post-thumbnail"><img src="{{ asset('assets/images/post-2.jpg')}}" alt="Image"
                                                                        class="img-fluid"></a>
                                                                <div class="post-content-entry">
                                                                    <h3><a href="#">How To Keep Your Furniture Clean</a></h3>
                                                                    <div class="meta">
                                                                        <span>by <a href="#">Robert Fox</a></span> <span>on <a href="#">Dec 15, 2021</a></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
                                                            <div class="post-entry">
                                                                <a href="#" class="post-thumbnail"><img src="{{ asset('assets/images/post-3.jpg')}}" alt="Image"
                                                                        class="img-fluid"></a>
                                                                <div class="post-content-entry">
                                                                    <h3><a href="#">Small Space Furniture Apartment Ideas</a></h3>
                                                                    <div class="meta">
                                                                        <span>by <a href="#">Kristin Watson</a></span> <span>on <a href="#">Dec 12, 2021</a></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div> -->
    <!-- End Blog Section -->


@endsection