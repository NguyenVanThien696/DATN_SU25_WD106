@extends('client.master')

@section('content')
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<!-- Banner đây -->
<div class="hero">
    <div class="container">
        @if ($banners->count())
        <div id="homepageCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach ($banners->take(5) as $index => $banner)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-5">
                            <div class="intro-excerpt">
                                <h1>{{ $banner->title }}</h1>
                                <p class="mb-4">
                                    {{ $banner->description ?? 'Khám phá các thiết kế mới nhất từ bộ sưu tập của chúng tôi.' }}
                                </p>
                                <p>
                                    <a href="{{ route('client.products.index') }}" class="btn btn-secondary me-2">Mua ngay</a>
                                    <a href="{{ $banner->link ?? '#' }}" class="btn btn-white-outline">Khám phá</a>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="hero-img-wrap">
                                <img src="{{ asset('storage/' . $banner->image) }}" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Phong Cách <span class="d-block">Hiện Đại</span></h1>
                    <p class="mb-4">
                        Lấy cảm hứng từ những cảm xúc trong tâm hồn người phụ nữ – lúc dịu dàng như nốt trầm,
                        khi rực rỡ như nốt cao – Charming Notes là bản hòa tấu, nơi mỗi thiết kế là một thanh âm riêng,
                        khắc họa vẻ đẹp của từng cung bậc xúc cảm khác nhau.
                    </p>
                    <p><a href="" class="btn btn-secondary me-2">Mua ngay</a>
                        <a href="#" class="btn btn-white-outline">Khám phá</a>
                    </p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero-img-wrap text-center">
                    <img src="{{ asset('assets/images/6250afbe6b178631d4baf39ce681c79f.jpg') }}" class="img-fluid">
                </div>
            </div>
        </div>
        @endif
    </div>
</div>





<!-- Start Product Section -->
<div class="product-section" id="hot">
    <div class="container">
        <div class="row">

            <!-- Start Column 1 -->
            <div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
                <h2 class="mb-4 section-title">SẢN PHẨM HOT</h2>
                <p class="mb-4">Hãy sống tránh xa sự thù ghét, mà hãy chọn lối sống nhẹ nhàng và linh hoạt. Đừng để tâm trí bị chi phối bởi những lo âu, mà hãy tập trung vào những điều tích cực. </p>
                <p><a href="{{ route('client.products.index') }}" class="btn">Mua ngay</a></p>
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
<div class="why-choose-section" id="about-us">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6">
                <h2 class="section-title">TẠI SAO LỰA CHỌN CHÚNG TÔI</h2>
                <p>Modavie là thương hiệu thời trang hàng đầu Việt Nam thành lập vào năm 2025 bởi WD106 Fpoly, hướng tới sự phóng khoáng, lịch lãm và trẻ trung.</p>

                <div class="row my-5">
                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="{{asset('assets/images/truck.svg')}}" alt="Image" class="imf-fluid">
                            </div>
                            <h3>Miễn phí giao hàng</h3>
                            <p>Áp dụng cho mọi đơn hàng từ 500k
                            </p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="{{asset('assets/images/bag.svg')}}" alt="Image" class="imf-fluid">
                            </div>
                            <h3>Mua hàng dễ dàng</h3>
                            <p>Giao diện thân thiện với khách hàng
                            </p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="{{asset('assets/images/support.svg')}}" alt="Image" class="imf-fluid">
                            </div>
                            <h3>Hỗ trợ 24/7</h3>
                            <p>HOTLINE 24/7 : 0388728681
                            </p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="{{asset('assets/images/return.svg')}}" alt="Image" class="imf-fluid">
                            </div>
                            <h3>Đổi hàng dễ dàng</h3>
                            <p>7 ngày đổi hàng vì bất kì lí do gì
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-5">
                <div class="img-wrap">
                    <img src="{{asset('assets/images/taisaochon.jpg')}}" alt="Image" class="img-fluid">
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
                    <div class="grid grid-1"><img src="{{asset('assets/images/shakeit.png')}}" alt="Untree.co"></div>
                    <div class="grid grid-2"><img src="{{asset('assets/images/shakeit2.png')}}" alt="Untree.co"></div>
                    <div class="grid grid-3"><img src="{{asset('assets/images/shakeit1.png')}}" alt="Untree.co"></div>
                </div>
            </div>
            <div class="col-lg-5 ps-lg-5">
                <h2 class="section-title mb-4">SHAKE IT UP</h2>
                <p>Nguồn cảm hứng rực rỡ, sống động từ Bữa tiệc được tái hiện hoàn hảo trên từng chi tiết trang phục thời trang dành cho nữ giới tới từ Modavie! Cổ vũ cho mỗi cô gái hãy khuấy động giai điệu thời trang của chính mình mỗi ngày. Shake It Up!</p>
{{-- 
                <ul class="list-unstyled custom-list my-4">
                    <li>Donec vitae odio quis nisl dapibus malesuada</li>
                    <li>Donec vitae odio quis nisl dapibus malesuada</li>
                    <li>Donec vitae odio quis nisl dapibus malesuada</li>
                    <li>Donec vitae odio quis nisl dapibus malesuada</li>
                </ul> --}}
                <p><a href="{{ route('client.products.categories', 3) }}" class="btn">Khám phá ngay</a></p>
            </div>
        </div>
    </div>
</div>
<!-- End We Help Section -->

<!-- Start Popular Product -->
{{-- <div class="popular-product">
    <div class="container">
        <div class="row">

            <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                <div class="product-item-sm d-flex">
                    <div class="thumbnail">
                        <img src="{{asset('assets/images/product-1.png')}}" alt="Image" class="img-fluid">
                    </div>
                    <div class="pt-3">
                        <h3>Nordic Chair</h3>
                        <p>Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio </p>
                        <p><a href="#">Read More</a></p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                <div class="product-item-sm d-flex">
                    <div class="thumbnail">
                        <img src="{{asset('assets/images/product-2.png')}}" alt="Image" class="img-fluid">
                    </div>
                    <div class="pt-3">
                        <h3>Kruzo Aero Chair</h3>
                        <p>Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio </p>
                        <p><a href="#">Read More</a></p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                <div class="product-item-sm d-flex">
                    <div class="thumbnail">
                        <img src="{{asset('assets/images/product-3.png')}}" alt="Image" class="img-fluid">
                    </div>
                    <div class="pt-3">
                        <h3>Ergonomic Chair</h3>
                        <p>Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio </p>
                        <p><a href="#">Read More</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div> --}}
<!-- End Popular Product -->

<!-- Start Testimonial Slider -->
{{-- <div class="testimonial-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto text-center">
                <h2 class="section-title">Testimonials</h2>
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
                                            <p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio
                                                quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate
                                                velit imperdiet dolor tempor tristique. Pellentesque habitant morbi
                                                tristique senectus et netus et malesuada fames ac turpis egestas.
                                                Integer convallis volutpat dui quis scelerisque.&rdquo;</p>
                                        </blockquote>

                                        <div class="author-info">
                                            <div class="author-pic">
                                                <img src="{{ asset('assets/images/person-1.png')}}" alt="Maria Jones"
                                                    class="img-fluid">
                                            </div>
                                            <h3 class="font-weight-bold">Maria Jones</h3>
                                            <span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
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
                                            <p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio
                                                quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate
                                                velit imperdiet dolor tempor tristique. Pellentesque habitant morbi
                                                tristique senectus et netus et malesuada fames ac turpis egestas.
                                                Integer convallis volutpat dui quis scelerisque.&rdquo;</p>
                                        </blockquote>

                                        <div class="author-info">
                                            <div class="author-pic">
                                                <img src="{{ asset('assets/images/person-1.png')}}" alt="Maria Jones"
                                                    class="img-fluid">
                                            </div>
                                            <h3 class="font-weight-bold">Maria Jones</h3>
                                            <span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
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
                                            <p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio
                                                quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate
                                                velit imperdiet dolor tempor tristique. Pellentesque habitant morbi
                                                tristique senectus et netus et malesuada fames ac turpis egestas.
                                                Integer convallis volutpat dui quis scelerisque.&rdquo;</p>
                                        </blockquote>

                                        <div class="author-info">
                                            <div class="author-pic">
                                                <img src="{{asset('assets/images/person-1.png')}}" alt="Maria Jones"
                                                    class="img-fluid">
                                            </div>
                                            <h3 class="font-weight-bold">Maria Jones</h3>
                                            <span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
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
</div> --}}
<!-- End Testimonial Slider -->

<!-- Start Blog Section -->
{{-- <div class="blog-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-6">
                <h2 class="section-title">Recent Blog</h2>
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
</div> --}}
<!-- End Blog Section -->


@endsection