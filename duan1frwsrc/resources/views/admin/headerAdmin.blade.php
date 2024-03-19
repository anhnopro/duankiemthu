<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Admin</title>

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset('temp/libs/slick/slick.css') }}" type="text/css">

    <!-- Main style file -->
    <link rel="stylesheet" href="{{ asset('temp/css/app.css') }}" type="text/css">

    <link rel="stylesheet" href="{{ asset('css/admincss/csshomee.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admincss/csscategory.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admincss/cssproduct.css') }}">


     <!-- Link thư viện ApexCharts -->
     <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
     <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.28.0/dist/apexcharts.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.28.0/dist/apexcharts.min.js"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.28.0/dist/apexcharts.min.css" />

</head>

<body>
    <div class="section-nav-side-bar">

        <nav class="hd-admin-navbar">
            <div class="hd-admin-logo_item">
                <i class="bx bx-menu" id="hd-admin-sidebarOpen"></i>
                <img src="images/logo.png" alt=""></i>ADMIN
            </div>
        
            <div class="hd-admin-search_bar">
                <input type="text" placeholder="Search" />
            </div>
        
            <div class="hd-admin-navbar_content">
                <i class="bi bi-grid"></i>
                <i class='bx bx-sun' id="hd-admin-darkLight"></i>
                <i class='bx bx-bell'></i>
                <img src="images/profile.jpg" alt="" class="hd-admin-profile" />
            </div>
        </nav>
        
        <!-- sidebar -->
        <nav class="hd-admin-sidebar">
            <div class="hd-admin-menu_content">
        
                <!-- dashboard -->
                <ul class="hd-admin-menu_items">
                    <div class="hd-admin-menu_title hd-admin-dashboard">
                        Dashboard
                    </div>
                    <li class="hd-admin-item">
                        <a href="{{ route('home.admin') }}" class="hd-admin-nav_link hd-admin-submenu-header_item">
                            <span class="hd-admin-navlink_icon">
                                <i class="bx bx-home-alt"></i>
                            </span>
                            <span class="hd-admin-navlink">Trang chủ</span>
                        </a>
                    </li>
                    <!-- end -->

                <!-- product nav -->
                <ul class="hd-admin-menu_items">
                    <div class="hd-admin-menu_title hd-admin-dashboard">
                        Products
                    </div>
                    <li class="hd-admin-item">
                        <div href="#" class="hd-admin-nav_link hd-admin-submenu-header_item">
                            <span class="hd-admin-navlink_icon">
                                <i class='bx bx-category'></i>
                            </span>
                            <span class="hd-admin-navlink">Quản lí danh mục</span>
                            <i class="bx bx-chevron-right hd-admin-arrow-left"></i>
                        </div>
                        <ul class="hd-admin-menu_items hd-admin-submenu-header">
                            <a href="{{ route('admin.category.add') }}"
                                class="hd-admin-nav_link hd-admin-sublink">Tạo danh mục</a>
                            <a href="{{ route('admin.category.edit') }}"
                                class="hd-admin-nav_link hd-admin-sublink">Sửa danh mục</a>
                            <a href="{{ route('admin.category.trash') }}"
                                class="hd-admin-nav_link hd-admin-sublink">Thùng rác</a>
                        </ul>
                    </li>
                    <!-- end -->
        
                    <!-- start -->
                    <li class="hd-admin-item">
                        <div href="#" class="hd-admin-nav_link hd-admin-submenu-header_item">
        
                            <span class="hd-admin-navlink_icon">
                                <i class='bx bx-box'></i>
                            </span>
                            <span class="hd-admin-navlink">Sản phẩm</span>
                            <i class="bx bx-chevron-right hd-admin-arrow-left"></i>
                        </div>
        
                        <ul class="hd-admin-menu_items hd-admin-submenu-header">
                            <a href="{{route('admin.product.list')}}" class="hd-admin-nav_link hd-admin-sublink">Danh sách</a>
                            <a href="{{route('admin.product.add')}}" class="hd-admin-nav_link hd-admin-sublink">Thêm sản phẩm</a>
                            <a href="{{route('admin.product.trash')}}" class="hd-admin-nav_link hd-admin-sublink">Thùng rác</a>
                        </ul>
                    </li>
                    <!-- end -->

                     <!-- start -->
                     <li class="hd-admin-item">
                        <div href="#" class="hd-admin-nav_link hd-admin-submenu-header_item">
        
                            <span class="hd-admin-navlink_icon">
                                <i class='bx bxs-truck'></i>
                            </span>
                            <span class="hd-admin-navlink">Đặt hàng</span>
                            <i class="bx bx-chevron-right hd-admin-arrow-left"></i>
                        </div>
        
                        <ul class="hd-admin-menu_items hd-admin-submenu-header">
                            <a href="{{route('admin.order.list')}}" class="hd-admin-nav_link hd-admin-sublink">Danh sách đơn hàng</a>
                        </ul>
                    </li>
                    <!-- end -->
                </ul>


                <ul class="hd-admin-menu_items">
                    <div class="hd-admin-menu_title hd-admin-dashboard">
                        User
                    </div>
                    <li class="hd-admin-item">
                        <div href="#" class="hd-admin-nav_link hd-admin-submenu-header_item">
                            <span class="hd-admin-navlink_icon">
                                <i class='bx bxs-user-detail'></i>
                            </span>
                            <span class="hd-admin-navlink">Quản lí người dùng</span>
                            <i class="bx bx-chevron-right hd-admin-arrow-left"></i>
                        </div>
                        <ul class="hd-admin-menu_items hd-admin-submenu-header">
                            <a href="{{ route('admin.category.add') }}"
                                class="hd-admin-nav_link hd-admin-sublink">Tài khoản</a>
                        </ul>
                    </li>
                    <!-- end -->
                </ul>

                
    
                <ul class="hd-admin-menu_items">
                    <div class="hd-admin-menu_title hd-admin-setting"></div>
                    <li class="hd-admin-item">
                        <a href="#" class="hd-admin-nav_link">
                            <span class="hd-admin-navlink_icon">
                                <i class="bx bx-flag"></i>
                            </span>
                            <span class="hd-admin-navlink">Notice board</span>
                        </a>
                    </li>
                    <li class="hd-admin-item">
                        <a href="#" class="hd-admin-nav_link">
                            <span class="hd-admin-navlink_icon">
                                <i class="bx bx-medal"></i>
                            </span>
                            <span class="hd-admin-navlink">Award</span>
                        </a>
                    </li>
                    <li class="hd-admin-item">
                        <a href="#" class="hd-admin-nav_link">
                            <span class="hd-admin-navlink_icon">
                                <i class="bx bx-cog"></i>
                            </span>
                            <span class="hd-admin-navlink">Setting</span>
                        </a>
                    </li>
                    <li class="hd-admin-item">
                        <a href="#" class="hd-admin-nav_link">
                            <span class="hd-admin-navlink_icon">
                                <i class="bx bx-layer"></i>
                            </span>
                            <span class="hd-admin-navlink">Features</span>
                        </a>
                    </li>
                </ul>
        
                <!-- Sidebar Open / Close -->
                <div class="hd-admin-bottom_content">
                    <div class="hd-admin-bottom hd-admin-expand_sidebar">
                        <span> Expand</span>
                        <i class='bx bx-log-in'></i>
                    </div>
                    <div class="hd-admin-bottom hd-admin-collapse_sidebar">
                        <span> Collapse</span>
                        <a href="{{ route('home') }}"><i class='bx bx-log-out'></i></a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="content-main">
