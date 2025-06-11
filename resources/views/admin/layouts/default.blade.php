<!DOCTYPE html>
<html lang="en" dir="ltr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <link rel="shortcut icon" href="{{ asset('build.img/favicon/ico') }}">
    <link rel="stylesheet" href="{{ asset('build/css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('build/css/style.css') }}">
    @yield('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <!-- App Start-->
    <div id="root">
        <!-- App Layout-->
        <div class="app-layout-modern flex flex-auto flex-col">
            <div class="flex flex-auto min-w-0">
                <!-- Side Nav start-->
                @include('admin.layouts.sidebar')
                <!-- Side Nav end-->

                <!-- Header Nav start-->
                <div
                    class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">
                    @include('admin.layouts.header')

                    <!-- Popup end -->
                    <div class="h-full flex flex-auto flex-col justify-between">
                        <!-- Core Vendors JS -->
                        @yield('content')

                        <!-- Footer start -->
                        @include('admin.layouts.footer')

                        <!-- Footer end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('build/js/vendors.min.js') }}"></script>

    <!-- Other Vendors JS -->
    <script src="{{ asset('build/vendors/apexcharts/apexcharts.js') }}"></script>

    <!-- Page js -->
    <script src="{{ asset('build/js/pages/project-dashboard.js') }}"></script>

    <!-- Core JS -->
    <script src="{{ asset('build/js/app.min.js') }}"></script>
</body>

</html>