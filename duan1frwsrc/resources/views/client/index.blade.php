@include('client/headerClient')

<!-- banner va danh muc -->

<div class="banner-category">
    {{-- categories --}}
    <div class="section-category">
        <button value="pre" id="prevButton"><i class='bx bx-chevron-left'></i></button>
        <div id="categories">
            <ul id="categoryList">
                @foreach ($getLevelCate as $ct)
                    <li class="category">
                        <span style="color: #4070f4">{!! html_entity_decode($ct['iconDm']) !!}</span>
                        <a
                            href=" {{ route('client.productCategories', ['idDm' => $ct['idDm']]) }} ">{{ $ct['tenDm'] }}</a>
                        <i class='bx bx-chevron-right arrow-ctgr'></i>

                        <ul class="child-category">
                            @foreach ($ct['children'] as $ct2)
                                <li>

                                    <a href=" {{ route('client.productCategories', ['idDm' => $ct2['idDm']]) }} ">
                                        <h4 style="color: #4070f4">{{ $ct2['tenDm'] }}</h4>
                                    </a>
                                    <div>
                                        @foreach ($ct2['children'] as $ct3)
                                            <a href=" {{ route('client.productCategories', ['idDm' => $ct3['idDm']]) }} ">
                                                <div>{{ $ct3['tenDm'] }}</div>
                                            </a>
                                        @endforeach
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach

            </ul>
        </div>

        <button value="next" id="nextButton"><i class='bx bx-chevron-right'></i></button>

    </div>

    {{-- banner --}}
    <div class="section-banner">
        <div class="banner-left">
            <div class="banner-main-left carousel">
                <img src=  "{{ asset('storage/upload/bannermain.png') }}" alt="">
                <img src=  "{{ asset('storage/upload/mainbanner1.webp') }}" alt="">
                <img src=  "{{ asset('storage/upload/mainbanner2.webp') }}" alt="">
            </div>
            <button class="slick-prev">Previous</button>
            <button class="slick-next">Next</button>

            <div class="sub-banner-left">
                <div style="width: 99%;">
                    <img src=  "{{ asset('storage/upload/subbanner1.webp') }}" alt="">
                </div>
                <div>
                    <img src=  "{{ asset('storage/upload/subbanner5.webp') }}" alt="">

                </div>

            </div>
        </div>
        <div class="banner-right">
            <div>
                <img src=  "{{ asset('storage/upload/subbanner2.webp') }}" alt="">

            </div>
            <div>
                <img src=  "{{ asset('storage/upload/subbanner3.webp') }}" alt="">
            </div>
            <div>
                <img src=  "{{ asset('storage/upload/subbanner4.webp') }}" alt="">

            </div>
        </div>
    </div>
</div>
<!-- end banner-category -->

<!-- tin tuc khuyen main -->
{{-- <div class="section-gifts">
    <div class="section-left">
        <h4>
            <div class="clock">
                <div class="cls clock-day"></div> :
                <div class="cls clock-house"></div> :
                <div class="cls clock-minute"></div> :
                <div class="cls clock-second"></div>
            </div>
            <h5>SẢN PHẨM BÁN CHẠY</h5>
        </h4>
        <div class="banner-left">
            <img src=  "{{ asset('storage/upload/banner-km.png') }}" alt="">
        </div>
    </div>
    <div class="section-right">
        <h4>
            <h2>Xem thêm khuyến mãi</h2>
        </h4>
        <div class="list-products">
            <div class="product">
                <img src=  "{{ asset('storage/upload/prodcutkm1.png') }}" alt="">
                <div class="name-pr">Sản phẩm 1</div>
                <div class="price-pr">120.000.000VND</div>
                <div class="gift-price">80.000.000VND</div>
            </div>
            <div class="product">
                <img src=  "{{ asset('storage/upload/prodcutkm1.png') }}" alt="">
                <div class="name-pr">Sản phẩm 1</div>
                <div class="price-pr">120.000.000VND</div>
                <div class="gift-price">80.000.000VND</div>
            </div>
            <div class="product">
                <img src=  "{{ asset('storage/upload/prodcutkm1.png') }}" alt="">
                <div class="name-pr">Sản phẩm 1</div>
                <div class="price-pr">120.000.000VND</div>
                <div class="gift-price">80.000.000VND</div>
            </div>
        </div>
    </div>
</div> --}}
<!-- end tin tuc khuyen mai -->

<!-- trang chu sản phẩm hot -->
<div class="home-products">
    <h2>Sản phẩm hót</h2>
    <div class="list-home-prds">

        @foreach ($allHotPr as $Pr)
            @php
                $ts = explode(' ', $Pr['tenLoaiSp']);
                $plug = implode('_', explode(' ', $Pr['tenSp']));

            @endphp
            <a href="{{ route('sanpham.productdetail', [
                'plug' => $plug,
                'idSp' => $Pr['idSp'],
                'idLoaiSp' => $Pr['idLoaiSp'],
            ]) }}"
                class="product">
                <img src=  "{{ asset('storage/upload/' . $Pr['img']) }}" alt="">

                <div class="name-pr">{{ $Pr['tenSp'] }}</div>

                <div class="ifPro">
                    @foreach ($ts as $t)
                        <div style="padding: 5px">{{ $t }}</div>
                    @endforeach
                </div>
                <div class="price-Pr">{{ number_format($Pr['giaSp'], 0, ',', '.') }}</div>
            </a>
        @endforeach
    </div>
</div>

<!-- trang chu sanr  pham -->
<div class="home-products">
    <h2>Sản phẩm mới</h2>
    <div class="list-home-prds">

        @foreach ($allHomePr as $Pr)
            @php
                $ts = explode(' ', $Pr['tenLoaiSp']);
                $plug = implode('_', explode(' ', $Pr['tenSp']));

            @endphp
            <a href="{{ route('sanpham.productdetail', [
                'plug' => $plug,
                'idSp' => $Pr['idSp'],
                'idLoaiSp' => $Pr['idLoaiSp'],
            ]) }}"
                class="product">
                <img src=  "{{ asset('storage/upload/' . $Pr['img']) }}" alt="">

                <div class="name-pr">{{ $Pr['tenSp'] }}</div>

                <div class="ifPro">
                    @foreach ($ts as $t)
                        <div style="padding: 5px">{{ $t }}</div>
                    @endforeach
                </div>
                <div class="price-Pr">{{ number_format($Pr['giaSp'], 0, ',', '.') }}</div>
            </a>
        @endforeach
    </div>
</div>
<!-- end trang chu san pham -->

<!-- danh muc san pham -->
<div class="dif-category">
    <h4>
        <h5>Danh mục sản phẩm</h5>
    </h4>
    <div class="fat-ctgr">
        @foreach ($allCate as $Ct)
            <a href="{{ route('client.productCategories', ['idDm' => $Ct['idDm']]) }}" class="child-ctgr">
                <span style="font-size: 30px; color: #4070f4">{!! html_entity_decode($Ct['iconDm']) !!}</span>
                <div class="name-ctgr">{{ $Ct['tenDm'] }}</div>
            </a>
        @endforeach
    </div>
</div>
<!-- end danh muc san pham -->

<!-- tin tuc -->
<div class="news-page">
    <h4>
        <h5>Trang tin tức</h5>
    </h4>
    <div class="list-news">
        <div class="img">
            <img src=  "{{ asset('storage/upload/news1.png') }}" alt="">
        </div>
        <div class="img">
            <img src=  "{{ asset('storage/upload/news1.png') }}" alt="">
        </div>
        <div class="img">
            <img src=  "{{ asset('storage/upload/news1.png') }}" alt="">
        </div>
        <div class="img">
            <img src=  "{{ asset('storage/upload/news1.png') }}" alt="">
        </div>
    </div>
</div>
<!-- end tin tuc -->

<!-- khuyen mai -->
<div class="gift-news-page">
    <h4>
        <h5>Trang khuyến mãi</h5>
    </h4>
    <div class="list-gift-news">
        <div class="img">
            <img src=  "{{ asset('storage/upload/listgiftnews1.png') }}" alt="">
        </div>
        <div class="img">
            <img src=  "{{ asset('storage/upload/listgiftnews1.png') }}" alt="">
        </div>
        <div class="img">
            <img src=  "{{ asset('storage/upload/listgiftnews1.png') }}" alt="">
        </div>
        <div class="img">
            <img src=  "{{ asset('storage/upload/listgiftnews1.png') }}" alt="">
        </div>
    </div>
</div>
<!-- end khuyen mai -->
{{-- slide --}}
<script>
    $(document).ready(function() {
        $('.carousel').slick({
            autoplay: true,
            autoplaySpeed: 1000,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow: $('.slick-prev'),
            nextArrow: $('.slick-next'),
        });
    });
</script>

<script>
    const pre = document.querySelector("#prevButton");
    const nex = document.querySelector("#nextButton");
    const categoriesList = document.querySelector("#categoryList");
    const categories = document.querySelector("#categories");

    const controlCategories = (e) => {
        const tagValue = e.target.parentNode.value;
        const ftcategories = categories.offsetWidth + 200;
        const categoryWidth = 300;
        let marginLeft = parseInt(categoriesList.style.marginLeft) || 0;


        switch (tagValue) {
            case "next":
                marginLeft -= categoryWidth;

                break;
            case "pre":
                marginLeft += categoryWidth;
                break;
        }
        if (marginLeft > 0) {
            marginLeft = 0;

        } else if (marginLeft < -ftcategories) {
            marginLeft = -ftcategories;
        }

        categoriesList.style.marginLeft = marginLeft + "px";
    };

    pre.addEventListener("click", controlCategories);
    nex.addEventListener("click", controlCategories);
</script>

@include('client/footerClient');
