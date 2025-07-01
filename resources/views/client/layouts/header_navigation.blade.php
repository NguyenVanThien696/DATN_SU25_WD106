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
		                    <a class="nav-link" href="{{ route('client.index') }}">Trang chủ </a>
		                </li>
		                <li class="nav-item {{ request()->routeIs('client.products.index') ? 'active' : '' }}">
		                    <a class="nav-link" href="{{ route('client.products.index') }}">Cửa hàng </a>
		                </li>
		                <li class="nav-item {{ request()->routeIs('client.contact.index') ? 'active' : '' }}">
		                    <a class="nav-link" href="{{ route('client.contact.index') }}">Về chúng tôi </a>
		                </li>
		                <li class="nav-item {{ request()->routeIs('client.blog.index') ? 'active' : '' }}">
		                    <a class="nav-link" href="{{ route('client.blog.index') }}">Blog</a>
		                </li>
		                <li class="nav-item {{ request()->routeIs('client.about.index') ? 'active' : '' }}">
		                    <a class="nav-link" href="{{ route('client.about.index') }}">Liên hệ với chúng tôi </a>
		                </li>
		                <li class="nav-item position-relative">
		                    <a class="nav-link" id="searchToggle"><i class="fas fa-search" style="cursor: pointer;"></i></a>
		                    <div id="searchBox" class="d-none position-absolute bg-white p-2 shadow"
		                        style="top: 100%; right: 0; z-index: 1000; min-width: 600px;">
		                        <form action="{{route('client.search.index')}}" method="get" class="d-flex">
		                            <input type="text" name="s" class="form-control me-2" placeholder="Tìm kiếm sản phẩm..."
		                                value="{{ request('s') }}">
		                            <button class="btn btn-outline-primary" type="submit">
		                                <i class="fas fa-search"></i>
		                            </button>
		                        </form>
		                    </div>
		                </li>
		            </ul>

		            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">

		                <li><a class="nav-link" href="{{ route('client.cart.index') }}"><img
		                            src="{{ asset('assets/images/cart.svg')}}"></a></li>
		                {{-- <li><a class="nav-link" href="{{ route('login.form') }}"><img
		                    src="{{ asset('assets/images/user.svg')}}"></a></li> --}}
		            </ul>
		            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-3">
		                @if(Auth::check())
		                <li class="nav-item dropdown">
		                    <a class="nav-link dropdown-toggle text-white fw-bold" href="#" id="navbarDropdown" role="button"
		                        data-bs-toggle="dropdown" aria-expanded="false">
		                        <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
		                    </a>
		                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
		                        <li>
		                            <a class="dropdown-item d-flex align-items-center gap-2"
		                                href="{{ route('dashboard.form') }}">
		                                <i class="fas fa-id-badge text-primary"></i> Hồ sơ
		                            </a>
		                        </li>
		                        <li>
		                            <a class="dropdown-item d-flex align-items-center gap-2"
		                                href="{{ route('client.order.index') }}">
		                                <i class="fas fa-receipt"></i> Đơn hàng
		                            </a>
		                        </li>
		                        <li>
		                            <form method="POST" action="{{ route('logout') }}">
		                                @csrf
		                                <button class="dropdown-item d-flex align-items-center gap-2" type="submit">
		                                    <i class="fas fa-sign-out-alt text-danger"></i> Đăng xuất
		                                </button>
		                            </form>
		                        </li>
		                    </ul>
		                </li>
		                @else
		                <li class="nav-item">
		                    <a class="nav-link" href="{{ route('login') }}">
		                        <img src="{{ asset('assets/images/user.svg') }}" alt="Login"
		                            style="width: 24px; height: 24px;">
		                    </a>
		                </li>
		                @endif
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