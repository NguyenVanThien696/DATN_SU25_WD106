@extends('admin.layouts.default')

@section('content')

<body>
    <!-- Content start -->
    <main class="h-full">
        <div class="page-container relative h-full flex flex-auto flex-col px-4 sm:px-6 md:px-8 py-4 sm:py-6">
            <div class="container mx-auto">
                <div class="card adaptable-card">
                    <div class="card-body">
                        <div class="lg:flex items-center justify-between mb-4">
                            <h3 class="mb-4 lg:mb-0">PRODUCT</h3>
                        </div>
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
                        <a href="{{ route('admin.products.create') }}" class="btn btn-success">Thêm mới </a>
                        <div class="overflow-x-auto mt-5">
                            <table id="product-list-data-table" class="table-default table-hover data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name Product</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Image</th>
                                        <th>Quantity</th>
                                        <th>#</th>
                                    </tr>
                                <tbody>
                                    @foreach ($listProducts as $products)
                                    <tr>
                                        <td>{{ $products->id }}</td>
                                        <td>{{ $products->name }}</td>
                                        <td>{{ $products->description }}</td>
                                        <td>{{ number_format($products->price, 0, ',', '.') }} ₫</td>
                                        <td>
                                            @if ($products->image != null)
                                            <img src="{{ asset('storage/' . $products->image) }}" alt="Ảnh sản phẩm"
                                                width="150px">
                                            @endif
                                        </td>
                                        <td>{{ $products->quantity }}</td>
                                        <td>
                                            <a href="{{ route('admin.products.show', $products->id) }}"
                                                class="btn btn-secondary">Detail </a>
                                            <!-- <a href="{{ route('admin.products.edit', $products->id) }}"
                                                class="btn btn-warning">Edit</a> -->
                                            <form action="{{ route('admin.products.delete', $products->id) }} " class="d-inline"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn xóa không? ')">Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-5">
                                {{ $listProducts ->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Content end -->
</body>

@endsection