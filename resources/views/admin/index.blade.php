@extends('admin.layouts.default')

@section('content')
<main class="h-full">
    <div class="page-container relative h-full flex flex-auto flex-col px-4 sm:px-6 md:px-8 py-4 sm:py-6">
        <div class="container mx-auto h-full">
            <div class="h-full flex flex-col items-center justify-center">

                @if($totalNotifications > 0)
                <img src="{{ asset('assets/images/pending-approval.png') }}" alt="Có thông báo mới!">
                @else
                <img src="{{ asset('assets/images/img-2.png') }}" alt="Không có thông báo">
                @endif

                <div class="mt-6 text-center">
                    <h3 class="mb-2">Thông báo !</h3>

                    @if($totalNotifications > 0)
                    <a href="{{ route('admin.order.index') }}">
                        <p class="text-base text-green-600 hover:underline">
                            Bạn có {{ $totalNotifications }} đơn hàng mới đang chờ xử lý.
                        </p>
                    </a>
                    <ul class="mt-4 text-left text-sm text-gray-800">
                        @foreach($newOrders as $order)
                        <li class="mb-2">
                            Đơn hàng #{{ $order->id }} - {{ $order->created_at->format('d/m/Y H:i') }}
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-base">Không có thông báo mới</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</main>
@endsection