		<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

		    <div class="container">
		        <a class="navbar-brand" href="{{ route('client.index') }}">ModaVie<span>.</span></a>

		        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni"
		            aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
		            <span class="navbar-toggler-icon"></span>
		        </button>

		        <div class="collapse navbar-collapse" id="navbarsFurni">
		            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
		                <li class="nav-item {{ request()->routeIs('client.index') ? 'active' : '' }}">
		                    <a class="nav-link" href="{{ route('client.index') }}">Home</a>
		                </li>
		                <li class="nav-item {{ request()->routeIs('client.products.index') ? 'active' : '' }}">
		                    <a class="nav-link" href="{{ route('client.products.index') }}">Shop</a>
		                </li>
		                <li class="nav-item {{ request()->routeIs('client.about.index') ? 'active' : '' }}">
		                    <a class="nav-link" href="{{ route('client.about.index') }}">About us</a>
		                </li>
		                <li class="nav-item">
		                    <a class="nav-link" href="#">Services</a>
		                </li>
		                <li class="nav-item {{ request()->routeIs('client.blog.index') ? 'active' : '' }}">
		                    <a class="nav-link" href="{{ route('client.blog.index') }}">Blog</a>
		                </li>
		                <li class="nav-item {{ request()->routeIs('client.contact.index') ? 'active' : '' }}">
		                    <a class="nav-link" href="{{ route('client.contact.index') }}">Contact us</a>
		                </li>
		                <li class="nav-item">
		                    <a class="nav-link"><i class="fas fa-search" id="search" style="cursor: pointer;"></i></a>
		                </li>
		            </ul>

		            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
		                <li><a class="nav-link" href="#"><img src="{{ asset('assets/images/user.svg')}}"></a></li>
		                <li><a class="nav-link" href="{{ route('client.cart.index') }}"><img src="{{ asset('assets/images/cart.svg')}}"></a></li>
		            </ul>
		        </div>
		    </div>

		</nav>
		<div class="search_input" id="search_input_box">
		    <div class="container">
		        <form class="d-flex justify-content-between">
		            <input type="text" class="form-control" id="search_input" placeholder="Search Here">
		            <button type="button" class="btn" id="close_search">
		                <i class="fas fa-times"><span class="lnr lnr-cross" id="close_search" title="Close Search"></span></i>
		            </button>

		        </form>
		    </div>
		</div>