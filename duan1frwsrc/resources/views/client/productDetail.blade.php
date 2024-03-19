@include('client/headerClient')

<section class="main-productdetails">

    {{ var_dump($view) }}

    {{-- thông tin main sp --}}
    <section class="row">

        {{-- ảnh sản phẩm --}}

        <section class="rol1">
            <div class="product">
                <img class="img-responsive" src="{{ asset('storage/upload') . '/' . $getIdSp[0]['img'] }}" id="main_img">
            </div>
            <p>
                @php
                    $subImgs = explode(',', $getIdSp[0]['subImgTongHop']);
                @endphp
                <img src="{{ asset('storage/upload') . '/' . $getIdSp[0]['img'] }}" width="90">
                @foreach ($subImgs as $subImg)
                    <img src="{{ asset('storage/upload') . '/' . $subImg }}" width="90">
                @endforeach

            </p>
        </section>
        {{-- thông tin sản phẩm --}}
        <section class="rol2">
            <form action="{{ route('client.add.cart',[
                'plug' => $plug,
                'idSp' => $getIdSp[0]['idSp'],
                'idLoaiSp' => $idLoaiSp,

              ]) }}" method="post" id="form-add-cart">
                <h2 class="product_name"> {{ $getIdSp[0]['tenSp'] }} </h2>

                <a href=""><i>Xem đánh giá</i></a>
                <p name="price"> Giá sản phẩm: {{ number_format($getIdSp[0]['giaSp'], 0, ',', '.') }} VND</p>
                <div class="group-button">
                    <button type="button" class="soluong" onclick="thaydoisoluong('-')">-</button>
                    <input name="soLuong" type="text" class="soluong1" value="1" id="soluong">
                    <button type="button" class="soluong" onclick="thaydoisoluong('+')">+</button>
                </div>

                {{-- chọn type --}}

                <div class="chose-type">
                    <div idLoaiSp= "{{ $getIdSp[0]['idLoaiSp'] }}" class="typied">{{ $getIdSp[0]['tenLoaiSp'] }}</div>
                    @foreach ($typeProduct as $type)
                        @if ($getIdSp[0]['tenLoaiSp'] != $type['tenLoaiSp'])
                            <div idLoaiSp= "{{ $type['idLoaiSp'] }}" class="typied">{{ $type['tenLoaiSp'] }}</div>
                        @endif
                    @endforeach
                </div>
                <div class="buy_here">
                    <input type="hidden" id="idLoaiSp" name="idLoaiSp" value="{{ $getIdSp[0]['idLoaiSp'] }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button href=""><i style="font-size: 20px;" class='bx bx-cart-download'></i>Thêm giỏ
                        hàng</button>
                </div>
            </form>
            <div class="content">
                <h3>Ưu Đãi lên đến 30 % Khi mua kèm PC <a>xem tại đây</a></h3>
                <div class="khuyenmai">
                    <h3>Khuyến mãi</h3>

                </div>
                <div class="box_content">
                    <p><i class='bx bxs-check-circle'></i>Giảm ngay 300.000đ khi mua thêm RAM kèm với PC.</p>
                    <p><i class='bx bxs-check-circle'></i>Giảm ngay 200.000đ khi mua thêm SSD kèm với PC</p>
                    <p><i class='bx bxs-check-circle'></i>Giảm ngay 200.000đ khi mua thêm SSD kèm với PC</p>
                </div>

            </div>

        </section>

    </section>

    {{-- mô tả --}}
    <section class="row2">
        <section class="mota">
            <h3>Mô tả sản phẩm</h3>
            @php
                $resultMota = explode('.',$getIdSp[0]['moTa']);
            @endphp
            <div>
                @foreach ($resultMota as $mt)
                    {{$mt}}
                    <br>
                    <br>
                @endforeach
            </div>
        </section>
        <section class="tintuc">
            <div class="title">
                <h3>Tin tức</h3>
            </div>
            <div class="list_tintuc">
                <img src="img/anh1.png">
                <p>
                    Mô tả tin tức sản phẩm
                </p>
            </div>
            <div class="list_tintuc">
                <img src="img/anh1.png">
                <p>
                    Mô tả tin tức sản phẩm
                </p>
            </div>
            <div class="list_tintuc">
                <img src="img/anh1.png">
                <p>
                    Mô tả tin tức sản phẩm
                </p>
            </div>
        </section>

    </section>

    {{-- bình luận --}}
    <section class="binhluan">
        <form action="{{ route('client.insert.comment',
        [
            'plug' => $plug,
            'idSp' => $idSp,
            'idLoaiSp' => $idLoaiSp
        ]
        ) }}" method="post">
            @csrf
            <input name="ndComment" type="text" placeholder="Thảo luận">
            <input name="idLoaiSp" type="hidden" value="{{ $idLoaiSp }}">
            <a href=""><button>Gửi</button></a>
            <div class="list_binhluan">
                @foreach ($infoComment as $cmt)
        
                <div>
                    <a href=""><img width="20" src="{{ asset('storage/upload').'/'.$cmt['Avatar'] }}" alt="">{{ $cmt['nickName'] }}</a>
                </div>
                    <span>{{ $cmt['ndComment'] }}</span>
                    <div style="margin-bottom: 20px; font-size: 10px"><i>{{ $cmt['ngayComment'] }}</i></div>
                @endforeach
            </div>
        </form>
    </section>

</section>

<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
{{-- xử lí chọn ảnh con --}}
<script>
    function thaydoisoluong(toantu) {
        let luong = $('#soluong');
        let soluong = luong.val();

        if (toantu === '-') {
            if (parseInt(soluong) > 1) {
                luong.val(parseInt(soluong) - 1);
            }
        } else if (toantu === '+') {
            luong.val(parseInt(soluong) + 1);
        } else {
            alert('cảnh báo nguy hiểm');
        }
    }

    $(() => {
        $('p img').click(function() {
            let imgPath = $(this).attr('src');
            $('#main_img').attr('src', imgPath);
        })
    })
</script>

<script>
    const createElement = (name, atb, text = '') => {
        const element = document.createElement(name);
        for (const key in atb) {
            if (atb.hasOwnProperty(key)) {
                element.setAttribute(key, atb[key]);
            }
        }
        element.innerText = text;
        return element;
    };

    const formAc = document.querySelector('#form-add-cart');

    document.querySelectorAll('.typied').forEach((elm) => {
        elm.addEventListener('click', () => {

            const idLoaiSp = elm.getAttribute('idLoaiSp');
            const fatherElm = elm.parentNode.parentNode;
            
            fatherElm.querySelector('#idLoaiSp').value = idLoaiSp;
            
            elm.classList.toggle('selected');
        });
    });
</script>

@include('client/footerClient')
