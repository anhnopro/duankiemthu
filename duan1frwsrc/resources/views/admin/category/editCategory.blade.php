@include('admin/headerAdmin')


<div class="breadcrumb-main">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            @php
                $urlSegments = explode('/', request()->path());
                $url = '';
            @endphp

            @foreach($urlSegments as $segment)
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
<div id="section-category">
    <div class="relationship-category">
        <h5>Mối quan hệ bảng</h5>
        <div class="category-grid">
            <div style=" max-height: 350px;" class='list-category'>
                <h5>Bảng 1</h5>
    
                @if ($categories)
                    <?= "<div class='menu-item' idDm='0'>Chuyển ra cấp cha</div>" ?>
                    {!!$categories!!}
                @else
                    <p>Danh sách trống</p>
                @endif
    
            </div>
            <div style=" max-height: 350px;" class='list-category2'>
                <h5>Bảng 2</h5>
                @if ($categories)
                    {!!$categories!!}
                @else
                    <p>Danh sách trống</p>
                @endif
            </div>
            <form method="post" action="handle_Up_categoryLevel" class="btns-edit">
    
                <input type="hidden" name="idDm" id="idDm" value="">
                <input type="hidden" name="idDmcha" id="idDmcha" value="0">
    
                <input type="hidden" name="_token" value=<?= csrf_token() ?>>
                <button type="button" id="save-ctgr">Lưu</button>
            </form>
        </div>
    </div>
</div>


<div class="section-edt-df">
    <div class="rename">
        <form action="handle_rename_category" method="post">
            <h5>Sửa tên danh mục</h5>
            Chọn danh mục:
            <select name="idDm" id="">

                @foreach ($categoriesAll as $ctgr)
                    <option value="{{ $ctgr['idDm'] }}">{{ $ctgr['tenDm'] }}</option>
                @endforeach

            </select>
            <p><label for="">icon danh mục: <a href="https://boxicons.com/?query=">icon</a></label></p>
            <p><input name="iconDm" type="text"></p>
            <p><label for="">Tên danh mục mới:</label></p>
            <p><input name="newname" type="text"></p>
            <input type="hidden" name="_token" value=<?= csrf_token() ?>>
            <button name="btn-rename">Lưu</button>
        </form>
    </div>
    <div class="function-dif">
        <h5>Công cụ khác</h5>
        <button id="show-hiden-quickly"><i class='bx bx-hide'></i>Hiện/ẩn nhanh</button>
        <a href="{{route('admin.category.add')}}"><button><i class='bx bx-add-to-queue'></i>Thêm danh mục </button></a>
        <a href="{{route('admin.category.trash')}}"><button><i class='bx bx-trash'></i>Thùng rác </button></a>


    </div>
</div>


<!-- xử lí hiện thị danh mục con -->
<script>
    var menuItems = document.querySelectorAll('.menu-item');
    document.addEventListener('DOMContentLoaded', function() {

        menuItems.forEach(function(menuItem) {
            menuItem.addEventListener('click', function() {
                var submenu = this.nextElementSibling;
                if (submenu.className === 'submenu') {

                    if (submenu.style.display === 'block') {
                        submenu.style.display = 'none';
                    } else {
                        submenu.style.display = 'block';
                    }
                }
            });
        });
    });
</script>
<!-- script xử lí click -->
<script>
    
    const removeBackgroundColor = (menuItem) => {
        menuItem.forEach((elm) => {
            elm.classList.remove('clicked');
        })
    }
    let menuItem = document.querySelector('.list-category').querySelectorAll('.menu-item');
    let menuItem2 = document.querySelector('.list-category2').querySelectorAll('.menu-item');

    const resetDisplayCtgr = () => {
        menuItem2.forEach((elm) => {
            elm.style.display = 'block';
        });
    }

    menuItem.forEach((elm, index) => {
        elm.addEventListener("click", () => {
            resetDisplayCtgr();
            removeBackgroundColor(menuItem);

            document.querySelector('#idDmcha').value = elm.getAttribute('idDm');
            elm.classList.toggle('clicked');
            menuItem2[index - 1].style.display = "none";
            if (menuItem2[index - 1].className === 'submenu') {
                menuItem2[index - 1].nextElementSibling.style.display = "none";
            }

        })
    });
    menuItem2.forEach((elm) => {
        elm.addEventListener("click", () => {
            removeBackgroundColor(menuItem2);
            document.querySelector('#save-ctgr').type= "submit";
            document.querySelector('#idDm').value = elm.getAttribute('idDm');
            elm.classList.toggle('clicked');

        })
    });
</script>

<script>
    const handleShowHidenQuickly = () => {

        subMenu = document.querySelectorAll('.submenu');
        subMenu.forEach(function(menuItem) {
            if (menuItem.style.display === "block") {
                menuItem.style.display = "none";
            } else {
                menuItem.style.display = "block";
            }
        });
    }
    document.querySelector('#show-hiden-quickly').addEventListener("click", () => {
        handleShowHidenQuickly();
    })
</script>

<script>
    document.querySelector('#save-ctgr').addEventListener('click', ()=> {
        if(document.querySelector('#idDm').value == 0) {
            alert('vui lòng chọn cấp.');
        }
    })
</script>


@include('admin/footerAdmin')
