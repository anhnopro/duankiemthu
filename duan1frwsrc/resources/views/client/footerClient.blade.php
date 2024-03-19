</main>
<footer class="footer">

    <div class="footer1">
        <div class="conttens">
            <div class="contten1">
                <h6>VỀ GEARVN</h6>
                <a href="#">Giới thiệu</a> <br>
                <br>
                <a href="#">Tuyển dụng</a>
            </div>

        </div>

        <div class="conttens">
            <div class="contten1">
                <h6>CHÍNH SÁCH </h6>
                <a href="#">Chính sách bảo hành</a> <br>
                <br>
                <a href="#">Chính sách thanh toán</a> <br>
                <br>
                <a href="#">Chính sách giao hàng</a> <br>
                <br>
                <a href="#">Chính sách bảo mật</a> <br>

            </div>

        </div>

        <div class="conttens">
            <div class="contten1">
                <h6>THÔNG TIN</h6>
                <a href="#">Hệ thống cửa hàng</a> <br>
                <br>
                <a href="#">Trung tâm bảo hành</a>
            </div>

        </div>

        <div class="conttens">
            <div class="contten1">
                <h6>TỔNG ĐÀI HỖ TRỢ</h6>
                <a href="#">Gọi mua: 0123456789 (8:00-21:00)</a> <br>
                <br>
                <a href="#">CSKH: 0987654321 (8:00-21:00)</a> <br>
                <br>
                <a href="#">Email: shoplaptop@gmail.com</a>
            </div>

        </div>

        <div class="conttens">
            <div class="contten1">
                <h6>ĐƠN VỊ VẬN CHUYỂN</h6>
                <div class="payment-methods">
                    <ul>
                        <li><a href="#"><img src="img/ship_1.webp" alt="ZaloPay"></a></li>
                        <li><a href="#"><img src="img/ship_2.webp" alt="MoMo"></a></li>
                        <li><a href="#"><img src="img/ship_3.webp" alt="Visa"></a></li>
                        <li><a href="#"><img src="img/ship_4.webp" alt="MasterCard"></a></li>
                    </ul>
                </div>
            </div>
            <div class="contten1">
                <h6>CÁC PHƯƠNG THỨC THANH TOÁN</h6>
                <div class="payment-methods">
                    <ul>
                        <li><a href="#"><img src="img/pay_1.webp" alt="ZaloPay"></a></li>
                        <li><a href="#"><img src="img/pay_2.webp" alt="MoMo"></a></li>
                        <li><a href="#"><img src="img/pay_3.webp" alt="Visa"></a></li>
                        <li><a href="#"><img src="img/pay_4.webp" alt="MasterCard"></a></li> <br>
                        <br>
                        <li><a href="#"><img src="img/pay_5.webp" alt="ZaloPay"></a></li>
                        <li><a href="#"><img src="img/pay_6.webp" alt="MoMo"></a></li>
                        <li><a href="#"><img src="img/pay_7.webp" alt="Visa"></a></li>
                        <li><a href="#"><img src="img/pay_8.webp" alt="MasterCard"></a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="footer-content">

        <p>Kết nối với chúng tôi</p>
        <div class="payment-methods1">
            <ul>
                <li><a href="#"><img src="img/facebook_1_0e31d70174824ea184c759534430deec.webp"
                            alt="ZaloPay"></a>
                </li>
                <li><a href="#"><img src="img/tiktok-logo_fe1e020f470a4d679064cec31bc676e4.webp"
                            alt="MoMo"></a>
                </li>
                <li><a href="#"><img src="img/youtube_1_d8de1f41ca614424aca55aa0c2791684.webp" alt="Visa"></a>
                </li>
                <li><a href="#"><img src="img/group_1_54d23abd89b74ead806840aa9458661d.webp" alt="MasterCard"></a>
                </li>
            </ul>
        </div>
    </div>
</footer>


{{-- // xử lí thanh danh mục khi reponsive website --}}
<script>
    
    // xử lí thanh nav trên điện thoại
    const menuPhone = document.querySelector(".menu-phone");
    const listNavMain = document.querySelector(".nav-m-list");
    const closeMenu = document.querySelector(".close-menu");

    const handleMenu = (e) => {
        displayStyle = e.target.parentNode.getAttribute("valueStyle");
        listNavMain.style.display = displayStyle;
    }
    menuPhone.addEventListener('click', handleMenu);
    closeMenu.addEventListener("click", handleMenu);

    // xử lí login

    const handleForm = (displayStyle, id) => {
        const tag = document.querySelector(id);
        tag.style.display = displayStyle;
    }
    const btnLogin = document.querySelector(".btn-login");
    const btnSigup = document.querySelector(".btn-sigup");
    btnLogin.addEventListener('click', () => {
        handleForm('flex', '#backgr-login');
    });
    btnSigup.addEventListener('click', () => {
        handleForm('flex', '#backgr-sigup');
    });


    const backgrForm = document.querySelectorAll('.backgr-form');
    backgrForm.forEach((elm) => {
        elm.addEventListener('click', (e) => {
            if (e.target === elm) { // Kiểm tra xem sự kiện click có xảy ra trên backgr-form chính
                elm.style.display = "none";
            }
        });
    });
</script>
</body>

</html>
