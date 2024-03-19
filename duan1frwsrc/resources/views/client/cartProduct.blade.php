@include('client/headerClient')

@php
    $i = 0;
    $totalPrices = 0;
@endphp
<section class="main-cart">
    <form action="handle_insert_orders" method="post">

        <section class="title">
            <h2 style="margin:10px; ">Có {{ sizeOf($CartItems)  }} sản phẩm trong giỏ hàng</h2>
        </section>
        @foreach ($CartItems as $index => $C)
            @if (isset($C['tenSp']))
                <section class="product">
                    <div class="product_main">
                        <img width="90" src='storage/upload/{{ $C['img'] }}'>
                        <p> {{ $C['tenSp'] }}</p>
                        <p>{{ $C['tenLoaiSp'] }}</p>
                        <div id="giaSp">{{ $C['giaSp'] }}</div>
                        <div class="group_button">
                            <button type="button" class="Tdsoluong">-</button>
                            <input  type="text" name="soLuongMua{{$i}}" value="{{ $C['soLuong'] }}" id="soLuong">
                            <button type="button" class="Tdsoluong">+</button>
                        </div>
                        <div class="suli_product_main">
                            <p class="all-price-oitem" id="total-price"> {{ $C['soLuong'] * $C['giaSp'] }} </p>
                            <input name="idLoaiSp{{$i}}" type="hidden" value="{{ $C['idLoaiSp'] }}">
                            <input name="soLuongCart" type="hidden" value="{{ $i }}">

                        </div>
                        
                        <a href="{{ route('client.delete.cart', ['idLoaiSp' => $C['idLoaiSp']  ]) }}" style="color: #ff4646">Xóa sản phẩm</a>
                    </div>
                </section>
                @php
                    $totalPrices += $C['giaSp'];
                    $i++;
                @endphp
            @endif
        @endforeach
        <section class="khuyenmai">
            <div class="title_product">
                <p>Khuyến mãi theo sản phẩm</p>
                <div class="title_product_list">
                    <P><i class='bx bxs-check-circle'></i>Giảm 800,000đ</P>
                    <h3>Tặng máy ép chậm Kalite trị giá 3.000.000đ<span>Xem chi tiết</span></h3>
                    <p>Không áp dụng đồng thời với các khuyến mãi sau:</p>
                    <P>- Giảm ngay 800,000đ</P>
                </div>
            </div>
            <div class="tilte_pay">
                <div class="pay">
                    <p>Khuyến mãi theo đơn hàng</p>
                </div>

                <div class="deltail_pay">
                    <h3>Khuyến mãi tặng kèm</h3>
                    <P><i class='bx bxs-coupon'></i>Trả góp 0% trả trước từ 0đ qua Samsung Finance+ áp dụng tại 67 cửa
                        hàng.</P>
                    <P><i class='bx bxs-coupon'></i>Thu cũ đổi mới trợ giá ngay 15% đến 2 triệu (MintPro)</P>
                    <p><i class='bx bxs-coupon'></i>Dịch vụ - Sim - Mã ưu đãi 100,000đ mua Sim MobiFone Chất Chơi 1T</p>
                </div>

            </div>
        </section>
        <section class="form_main">
            <h3>Thông tin người đặt</h3>
            <input type="text" name="ten" placeholder="Họ Và Tên" id="hoten" required>
            <input type="text" name="sdt" placeholder="Số điện thoại" id="dienthoai" required>
            <input type="text" name="email" placeholder="Email" id="email"><br>
            <input type="text" name="diaChi" placeholder="Địa chỉ nhận hàng" id="diachi" required>
        </section>
        <section class="thanhtoan">
            <div class="xacnhangia">
                @csrf
                <p>Cần thanh toán ( {{ sizeOf($CartItems)}} sản phẩm):<span id="all-prices"> {{ $totalPrices }} </span></p>
                <button>Hoàn tất đặt hàng</button>
            </div>
        </section>
    </form>
</section>
{{-- xử lí tổng tiền giỏ hàng --}}
<script>
    const TdsoLuong = document.querySelectorAll('.Tdsoluong');
    const elmTotalPrice = document.querySelector('#all-prices');

    function updateAllPrice() {
        elmTotalPrice.innerText = Array.from(document.querySelectorAll('.all-price-oitem')
        ).reduce((sum, elm)=> {
            return sum + Number(elm.innerText);
        },0);
    }

    TdsoLuong.forEach((elm) => {
        elm.addEventListener('click', () => {
            const inputQtt = elm.parentNode.querySelector('#soLuong');

            const giaSp = elm.parentNode.parentNode.querySelector('#giaSp').innerText;
            const totalPrice = elm.parentNode.parentNode.querySelector('#total-price');

            const Opr = elm.innerText;

            if (Opr == '+') {
                inputQtt.value = Number(inputQtt.value) + 1;
            } else {
                if (Number(inputQtt.value) > 1) {
                    inputQtt.value = Number(inputQtt.value) - 1;
                }
            }
            totalPrice.innerText = Number(inputQtt.value) * Number(giaSp);

            updateAllPrice();
        });
    });
</script>
@include('client/footerClient')
