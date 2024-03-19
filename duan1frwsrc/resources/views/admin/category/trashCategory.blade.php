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
    <div class="section-trash">
        <div class="category-grid">
            <div class='list-category'>
                <h5>Bảng 1</h5>
    
                @if ($categoriesRemove)
                    {!! $categoriesRemove !!}
                @else
                    <p>Thùng rác trống!</p>
                @endif
            </div>
            <div class="btn-handle-dlt">
                <h5>Chức năng</h5>
                <form style="display: inline" action="handle_restore_category" method="post">
                    <input type="hidden" id="idDm" name="idDm" value="#">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button id="btn-restore">Khôi phục</button>
                </form>
                <button id="btn-delete">Xóa</button>
                <a href="{{ route('admin.category.edit') }}"><button><i class='bx bxs-edit'></i>Sửa danh
                    mục</button></a>
                <a href="{{route('admin.category.add')}}"><button><i class='bx bx-add-to-queue'></i>Thêm danh mục </button></a>  
            </div>
        </div>
    </div>
</div>


<!-- script xử lí click -->
<script>
    var idDm = 0;

    const removeBackgroundColor = (menuItem) => {
        menuItem.forEach((elm) => {
            elm.classList.remove('clicked');
        })
    }
    let menuItem = document.querySelector('.list-category').querySelectorAll('.menu-item');

    menuItem.forEach((elm) => {
        elm.addEventListener("click", () => {
            removeBackgroundColor(menuItem);

            document.querySelector("#idDm").value = elm.getAttribute('idDm');
            idDm = elm.getAttribute('idDm');
            elm.classList.toggle('clicked');
            console.log(idDm);
        })
    });
</script>



@include('admin/footerAdmin')

