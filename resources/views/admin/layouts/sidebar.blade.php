<div class="side-nav side-nav-transparent side-nav-expand">
    <div class="side-nav-header">

    </div>
    <div class="side-nav-content relative side-nav-scroll">
        <nav class="menu menu-transparent px-4 pb-4">
            <div class="menu-group">
                <span class="nav-link mt-5">Xin chào, </span>
                <div class="menu-title"><a href="">Menu</a></div>
                <ul>
                    <li class="menu-collapse">
                        <div class="menu-collapse-item">
                            <svg class="menu-item-icon" stroke="currentColor" fill="none" stroke-width="0"
                                viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <a href="{{ route('admin.index') }}"><span class="menu-item-text">Trang Chủ</span></a>
                        </div>
                        <ul>
                            <li data-menu-item="modern-project-dashboard" class="menu-item">
                                <i class="fa-regular fa-bell fa-sm"></i>
                                <a class="h-full w-full flex items-center" href="">
                                    <span>Thống kê</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="menu-collapse">
                        <div class="menu-collapse-item">
                            <svg class="menu-item-icon" stroke="currentColor" fill="none" stroke-width="0"
                                viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            <span class="menu-item-text">Quản Lý Tài Khoản</span>
                        </div>
                        <ul>
                            <li data-menu-item="modern-customers" class="menu-item">
                                <i class="fa-solid fa-list-ul fa-sm"></i>
                                <a class="h-full w-full flex items-center" href="{{ route('admin.users') }}">
                                    <span>Danh sách tài khoản</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-collapse">
                        <div class="menu-collapse-item">
                            <i class="fa-brands fa-pagelines fa-lg"></i>
                            <span class="menu-item-text">Quản Lý Sản Phẩm</span>
                        </div>
                        <ul>
                            <li data-menu-item="modern-product-list" class="menu-item">
                                <i class="fa-solid fa-list-ul fa-sm"></i>
                                <a class="h-full w-full flex items-center" href="{{ route('admin.products.index') }}">
                                    <span>Danh Sách Sản Phẩm</span>
                                </a>
                            </li>

                            <li data-menu-item="modern-new-product" class="menu-item">
                                <i class="fa-solid fa-square-plus fa-sm"></i>
                                <a class="h-full w-full flex items-center" href="">
                                    <span>Thêm Sản Phẩm</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="menu-collapse">
                        <div class="menu-collapse-item">
                            <i class="fa-regular fa-folder fa-lg"></i>
                            <span class="menu-item-text">Quản Lý Danh Mục</span>
                        </div>
                        <ul>
                            <li data-menu-item="modern-folder-list" class="menu-item">
                                <i class="fa-solid fa-list-ul fa-sm"></i>
                                <a class="h-full w-full flex items-center" href="">
                                    <span>Danh Sách Danh Mục</span>
                                </a>
                            </li>

                            <li data-menu-item="modern-new-folder" class="menu-item">
                                <i class="fa-solid fa-square-plus fa-sm"></i>
                                <a class="h-full w-full flex items-center" href="">
                                    <span>Thêm Danh Mục</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </div>
            <div class="menu-group">

                <ul>

                    <li class="menu-collapse">
                        <div class="menu-collapse-item">
                            <svg class="menu-item-icon" stroke="currentColor" fill="none" stroke-width="0"
                                viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                            <span class="menu-item-text">Quản Lý Bình Luận</span>
                        </div>
                        <ul>
                            <li data-menu-item="modern-dialog" class="menu-item">
                                <i class="fa-solid fa-comment"></i>
                                <a class="h-full w-full flex items-center" href="">
                                    <span>Danh Sách Bình Luận</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-collapse">
                        <div class="menu-collapse-item">
                            <i class="fa-solid fa-cart-shopping fa-lg"></i>
                            <span class="menu-item-text">Quản Lý Đơn Hàng</span>
                        </div>
                        <ul>
                            <li data-menu-item="modern-order-list" class="menu-item">
                                <i class="fa-solid fa-wallet fa-sm"></i>
                                <a class="h-full w-full flex items-center" href="">
                                    <span>Danh Sách Đơn Hàng</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- <ul class="navbar-nav ms-auto">
                        @guest
                        <li class="nav-item"><a class="nav-link" href="">Đăng nhập</a></li>
                        @else
                        <li class="nav-item">
                            <form method="POST" action="">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Đăng xuất</button>
                            </form>
                        </li>
                        @endguest
                    </ul> -->
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>