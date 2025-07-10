@extends('staff.layouts.default')

@section('content')
    <main class="h-full">
        <div class="page-container px-4 sm:px-6 md:px-8 py-6">
            <div class="container mx-auto">
                <h2 class="text-2xl font-bold mb-6">Trang Quản Trị Nhân Viên</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Đơn hàng -->
                    <div class="bg-white p-6 rounded-lg shadow text-center">
                        <h3 class="text-xl font-semibold mb-2">Đơn hàng</h3>
                        <a href="{{ route('staff.orders.index') }}" class="text-blue-600 hover:underline">Xem đơn hàng</a>
                    </div>

                    <!-- Sản phẩm -->
                    <div class="bg-white p-6 rounded-lg shadow text-center">
                        <h3 class="text-xl font-semibold mb-2">Tồn kho</h3>
                        <a href="{{ route('staff.products.index') }}" class="text-green-600 hover:underline">Cập nhật tồn
                            kho</a>
                    </div>

                    <!-- Đánh giá -->
                    <div class="bg-white p-6 rounded-lg shadow text-center">
                        <h3 class="text-xl font-semibold mb-2">Đánh giá</h3>
                        <a href="{{ route('staff.reviews.index') }}" class="text-yellow-600 hover:underline">Xem đánh
                            giá</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection