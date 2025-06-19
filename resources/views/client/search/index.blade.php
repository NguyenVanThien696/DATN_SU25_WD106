@extends('client.master');

@section('content')
<div class="container my-5">
    <h2>Kết quả tìm kiếm cho <strong>{{request('s')}}</strong></h2>

    @if ($products->count() > 0)
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{asset('storage/'.$product['image'])}}" class="card-img-top" alt="{{$product->name}}">
                        <div class="card-body">
                            <h5 class="card-title">{{$product->name}}</h5>
                            <p class="card-text">{{number_format($product->price)}}</p>
                            <a href="{{route('client.products.detail', ['id' => $product->id])}}" class="btn btn-primary btn-sm">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Không tìm thấy sản phẩm nào phù hợp</p>
    @endif
</div>
@endsection