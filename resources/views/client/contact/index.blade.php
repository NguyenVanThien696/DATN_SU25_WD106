@extends('client.master')

@section('content')
<!-- <div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>BỘ SƯU TẬP SENORA MỚI</h1>
                    <p class="mb-4">Tựa như một bản nhạc cổ điển
                        được chơi bằng tất cả sự nâng niu và tinh tế, bộ sưu tập mới nhất của dòng Senora cao cấp cất
                        lên những thanh âm thanh lịch, sâu lắng và đầy mê hoặc.</p>
                    <p><a href="{{ route('client.products.index') }}" class="btn btn-secondary me-2">Mua ngay </a><a
                            href="{{ route('client.about.index') }}" class="btn btn-white-outline">Khám phá </a></p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero-img-wrap">
                    <img src="{{ asset('assets/images/couch.png')}}" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="why-choose-section">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title">Vì Sao Chọn Chúng Tôi?</h2>
                <p>Thiết kế thời thượng, chất liệu cao cấp – Từng sản phẩm đều được chăm chút tỉ mỉ để mang lại sự thoải
                    mái và đẳng cấp cho bạn.</p>

                <div class="row my-5">
                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="{{ asset('assets/images/truck.svg') }}" alt="Image" class="imf-fluid">
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
                                <img src="{{ asset('assets/images/bag.svg') }}" alt="Image" class="imf-fluid">
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
                                <img src="{{ asset('assets/images/support.svg') }}" alt="Image" class="imf-fluid">
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
                                <img src="{{ asset('assets/images/return.svg') }}" alt="Image" class="imf-fluid">
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
                    <img src="{{asset('assets/images/8c7b81636f1de2272713b5a1bc260ce6.jpg')}}" alt="Image" class="img-fluid">
                </div>
            </div>

        </div>
    </div>
</div>
@endsection