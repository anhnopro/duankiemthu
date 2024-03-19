<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client</title>


    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset('temp/libs/slick/slick.css') }}" type="text/css">

    <!-- Main style file -->


    <link rel="stylesheet" href="{{ asset('css/usercss/cssproductdetail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/usercss/csscartproduct.css') }}">
    <link rel="stylesheet" href="{{ asset('css/usercss/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/usercss/reponsive.css') }}">



    <!-- Link thư viện ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.28.0/dist/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.28.0/dist/apexcharts.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.28.0/dist/apexcharts.min.css" />


    <!-- Thêm thư viện Slick Carousel -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
</head>

<body>
    <div id="backgr-login" style="display: none;" class="backgr-form">
        <form action="{{ route('client.login') }}" method="post">
            <h2>LOGIN</h2>
            <input name="email" type ="text" placeholder="Enter email">
            <input name="password" type="password" placeholder="Enter password">
            <p><a href="">Forgot password?</a></p>
            @csrf
            <input class="smform" type="submit" value="LOGIN">
            <p>Don't have an accout?<a href="">Sigup</a></p>
        </form>

    </div>
    <div id="backgr-sigup" style="display: none;" class="backgr-form">
        <form action=" {{ route('client.register') }} " method="post">
            <h2>SIGUP</h2>
            <input name="nickName" type="text" placeholder="Enter name">
            <input name="Email" type="text" placeholder="Enter email">
            <input name="password" type="password" placeholder="Enter password">
            <input type="password" placeholder="Confirm password">
            <input class="smform" type="submit" value="Sigup">
            @csrf
            <p>Already have an accout?<a href="">Login</a></p>
        </form>

    </div>
    <!-- header -->
    <header>
        <a href=" {{ route('home') }}" style="padding: 20px" class="logo"><img width="130" src="{{ asset('storage/upload/logo.png') }}"
                alt=""></a>
        <form action="" method="" class="search">
            <input type="text" placeholder="Bạn cần tìm gì?">
            <button><i class='bx bx-search'></i></button>
        </form>
        <nav class="nav-header">
            <ul>
                <li class="nav-hotline">
                    <i class='bx bx-phone-call'></i>
                    <a href="">Hotline: 0354179060</a>
                </li>
                <li class="info-cart">
                    <i class='bx bx-notepad'></i>
                    <a href="">Tra cứu đơn hàng</a>
                </li>
                <li class="cart">
                    @if (Session::has('cart'))
                        <div class="sl-cart">{{ sizeOf(Session::get('cart')) }}</div>
                    @endif
                    <i class='bx bx-cart-alt'></i>
                    <a href="{{ route('sanpham.cart') }}">Giỏ hàng</a>
                </li>
            </ul>
        </nav>
        <a href="{{ route('sanpham.cart') }}" class="cart-phone">
            @if (Session::has('cart'))
                <div class="sl-cart">{{ sizeOf(Session::get('cart')) }}</div>
            @endif
            <i class='bx bx-cart-alt'></i>
        </a>
        <div class="form-login">

            <i class='bx bxs-user'></i>
            @if (Cookie::has('infoLog'))

                @php
                    $dataLog = json_decode(Cookie::get('infoLog'), true);

                @endphp
                @if ($dataLog['vaiTro'] == 'Admin')
                    <a href="{{ route('home.admin') }}" style="color: white">Page quản trị</a>
                @else
                    <a href="">
                        <div
                            style="max-width: 50px;
                        color: white;
                        word-wrap: break-word;">
                            {{ $dataLog['nickName'] }}</div>
                    </a>
                @endif
                <a href="{{ route('client.logout') }}" style="color: white">Đăng xuất</a>
            @else
                <div class="btn-login">Đăng nhập</div>
                <div class="btn-sigup">Đăng ký</div>
            @endif
        </div>
    </header>
    <!-- end header -->

    <!-- navigation -->
    <nav class="nav-main">
        <div class="menu-phone" valueStyle="flex">
            <i style="font-size: 40px;" class='bx bx-menu'></i>
        </div>
        <ul class="nav-m-list">
            <div class="close-menu" valueStyle="none">
                <i class='bx bx-x'></i>
            </div>
            <li><i class='bx bxs-user'></i><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="father-li-sp">
                <i class='bx bxs-box'></i>
                <a href="">Sản phẩm</a>
                <i class='bx bxs-down-arrow'></i>
                <ul style="height: 500px; overflow: auto" class="ch-li-sp">
                    @foreach ($CateFt as $Ct)
                        <li><a
                                href="{{ route('client.productCategories', ['idDm' => $Ct['idDm']]) }}">{{ $Ct['tenDm'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li><i class='bx bx-news'></i><a href="">Tin tức công nghệ</a></li>
            <li><i class='bx bxs-user-rectangle'></i><a href="">Giới thiệu</a></li>
            <li><i class='bx bxs-phone-call'></i><a href="">Liên hệ</a></li>
            <li><i class='bx bxs-videos'></i><a href="">Video</a></li>
        </ul>
    </nav>
    <!-- end nav -->

    <!-- main -->
    @if (request()->path() !== '/')
        <div class="content">
            <div class="breadcrumb-main">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @php
                            $urlSegments = explode('/', request()->path());
                            $url = '';
                        @endphp

                        @foreach ($urlSegments as $segment)
                            @php
                                $url .= '/' . $segment;
                            @endphp

                            @if ($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($segment) }}</li>
                            @else
                                <li class="breadcrumb-item">
                                    <a href="{{ $url }}">{{ ucfirst($segment) }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
    @endif


    <main>
