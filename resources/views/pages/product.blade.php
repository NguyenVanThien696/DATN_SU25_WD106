@extends('client.master')

@section('content')


<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('images/product-1.png') }}" alt="Tên sản phẩm" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h2 class="mb-3">Ghế Sofa Sang Trọng</h2>
            <p class="text-muted fs-4 fw-bold">$120.00</p>
            <p class="mb-4">Sản phẩm ghế sofa hiện đại với chất liệu cao cấp, mang lại sự thoải mái và đẳng cấp cho không gian sống của bạn.</p>

            <div class="d-flex align-items-center mb-3">
                <input type="number" class="form-control me-3" value="1" min="1" style="width: 100px;">
                <button class="btn btn-primary px-4">Thêm vào giỏ hàng</button>
            </div>

            <p><strong>Danh mục:</strong> Nội thất</p>
            <p><strong>Trạng thái:</strong> Còn hàng</p>
        </div>
    </div>
</div>
@endsection


