<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/tiny-slider.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    


    <!-- <link rel="stylesheet" href="{{ asset('assets/css1/linearicons.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css1/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css1/themify-icons.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css1/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css1/owl.carousel.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css1/nice-select.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css1/nouislider.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css1/ion.rangeSlider.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/css1/ion.rangeSlider.skinFlat.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/css1/magnific-popup.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css1/main.css') }}"> -->
    <title>ModaVie - Trang chu</title>
</head>

<body>

    <!-- Start Header/Navigation -->
    @include('client.layouts.header_navigation')
    <!-- End Header/Navigation -->

    <!-- Start Hero Section -->
    <!-- @include('client.layouts.banner') -->
    <!-- End Hero Section -->

    @yield('content')

    <!-- Start Footer Section -->
    @include('client.layouts.footer')
    <!-- End Footer Section -->


    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script src="{{ asset('assets/js1/vendor/jquery-2.2.4.min.js') }}"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script> -->
	<!-- <script src="{{ asset('assets/js1/vendor/bootstrap.min.js') }}"></script> -->
	<!-- <script src="{{ asset('assets/js1/jquery.ajaxchimp.min.js') }}"></script> -->
	<script src="{{ asset('assets/js1/jquery.nice-select.min.js') }}"></script>
	<!-- <script src="{{ asset('assets/js1/jquery.sticky.js') }}"></script> -->
	<!-- <script src="{{ asset('assets/js1/nouislider.min.js') }}"></script> -->
	<!-- <script src="{{ asset('assets/js1/countdown.js') }}"></script> -->
	<script src="{{ asset('assets/js1/jquery.magnific-popup.min.js') }}"></script>
	<!-- <script src="{{ asset('assets/js1/owl.carousel.min.js') }}"></script> -->

	<script src="{{ asset('assets/js1/main.js') }}"></script>
    <script src="{{ asset('assets/js/products.js')}}"></script>
</body>

</html>