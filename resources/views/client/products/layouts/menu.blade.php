   <style>
.nav1 {
    display: flex;
    justify-content: center;
    gap: 20px;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgb(191, 188, 188);
}

.nav-link1 {
    color:rgb(36, 85, 63);
    text-decoration: none;
    font-size: 16px;
    padding: 8px 16px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.nav-link1:hover {
    background-color:rgb(36, 85, 63);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgb(161, 162, 164);
}

.nav-link1.active {
    background-color:rgb(36, 85, 63);
    color: white;
}

.nav-link1.disabled {
    color: #ccc;
    pointer-events: none;
    cursor: default;
}
   </style>
   <nav class="nav1 mt-5">
       <a class="nav-link1 {{ request()->routeIs('client.products.index') ? 'active' : '' }}" aria-current="page"
           href="{{ route('client.products.index') }}">Tất cả</a>
       <a class="nav-link1 {{ request()->routeIs('client.products.boy') ? 'active' : '' }}"
           href="{{ route('client.products.boy') }}">Nam </a>
       <a class="nav-link1 {{ request()->routeIs('client.products.girl') ? 'active' : '' }}"
           href="{{ route('client.products.girl') }}">Nữ</a>
       <a class="nav-link1 {{ request()->routeIs('client.products.hot') ? 'active' : '' }}"
           href="{{ route('client.products.hot') }}">Hot</a>
       <a class="nav-link1 {{ request()->routeIs('client.products.new') ? 'active' : '' }}"
           href="{{ route('client.products.new') }}">Mới</a>
   </nav>