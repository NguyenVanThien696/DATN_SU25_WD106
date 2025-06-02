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
                        <div class="overflow-x-auto">
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
										<td>{{ $products->price }}</td>
										<td>{{ $products->image }}</td>
										<td>{{ $products->quantity }}</td>
									</tr>
									
									@endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Content end -->
</body>

@endsection