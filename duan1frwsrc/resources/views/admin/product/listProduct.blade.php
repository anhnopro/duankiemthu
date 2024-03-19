@include('admin/headerAdmin')

<div class="content ">
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



<div style="margin-top: 20px" class="row">
    <div style="width: 70%" class="col-md-8">

        {{-- bảng fillter --}}
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex gap-4 align-items-center">
                    <div class="d-none d-md-flex">All Products</div>
                    <div class="d-md-flex gap-4 align-items-center">
                        <div class="mb-3 mb-md-0">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <select id="form-sort" class="form-select">
                                        <option value="desc">desc</option>
                                        <option value="asc">asc</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select id="form-take" class="form-select">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown ms-auto">
                        <a href="#" data-bs-toggle="dropdown" class="btn btn-primary dropdown-toggle"
                            aria-haspopup="true" aria-expanded="false">Hành động</a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a id="sua" href="{{ route('admin.product.edit') }}" class="dropdown-item">Sửa</a>
                            <a id="xoaSp" href="{{ route('admin.handle_remove') }}" class="dropdown-item">Xóa</a>
                            <div class="dropdown-item" id="apply-filters">Apply Filters</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">


            {{-- form add type --}}
            <div id="form-add-typePr" class="container-form-add-typePr">
                <h4 class="text-center mb-4">Thêm Loại Sản Phẩm</h4>
                <form id="form-handle-add-type" action="handle_add_typePro" method="post"
                    enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="tenLoai">Tên Loại:</label>
                        <input type="text" class="form-control" id="tenLoai" name="tenLoaiSp" required>
                    </div>
                    <div class="form-group">
                        <label for="img">img:</label>
                        <input type="file" class="form-control" id="img" name="img" required>
                    </div>
                    <div class="form-group">
                        <label for="moTa">Mô tả:</label>
                        <input type="text" class="form-control" id="moTa" name="moTa" required>
                    </div>
                    <div class="form-group">
                        <label for="gia">Giá:</label>
                        <input type="number" class="form-control" id="gia" name="giaSp" required>
                    </div>
                    <div class="form-group">
                        <label for="soLuong">Số Lượng:</label>
                        <input type="number" class="form-control" id="soLuong" name="soLuong"required>
                    </div>
                    <input type="hidden" name="_token" value=" {{ csrf_token() }} ">
                    <button id="add-type-pro" type="submit" class="btn btn-primary btn-block">Thêm Loại Sản
                        Phẩm</button>
                    <button id="btn-close" style="border: none; background-color: rgb(223, 55, 55)"
                        class="btn btn-primary btn-block">Close</button>
                </form>
            </div>
            {{-- bảng --}}
            <table class="table table-custom table-lg mb-0" id="products">
                <i style="padding: 10px; font-size: 10px">
                    Cùng id là cùng 1 sản phẩm nhưng biến thể khác nhau
                </i>
                <thead>
                    <tr>
                        <td>
                            <input class="form-check-input select-all" type="checkbox"
                                data-select-all-target="#products" id="defaultCheck1">
                        </td>
                        <td>Id</td>
                        <td>Mục</td>
                        <td>Ảnh</td>
                        <td>Tên</td>
                        <td>Mô tả</td>
                        <td>Tình trạng</td>
                        <td>Loại</td>
                        <td>Giá</td>
                        <td class="text-end">Actions</td>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($allPro as $pr)
                        <tr idLoaiSp = "{{ $pr['idLoaiSp'] }}" idSp= "{{ $pr['idSp'] }}">
                            <td>
                                <input class="form-check-input" type="checkbox">
                            </td>
                            <td class="truncate">
                                <p>{{ $pr['idSp'] }}</p>
                            </td>
                            <td>
                                <a href="#" class="truncate">{{ $pr['danhMucTongHop'] }}</a>
                            </td>
                            <td>
                                <a href="#">
                                    <img src="{{ asset('storage/upload/' . $pr['img']) }}" class="rounded"
                                        width="40" alt="...">
                                </a>
                            </td>
                            <td class="truncate tenSp">{{ $pr['tenSp'] }}</td>
                            <td>
                                <span class="truncate">{{ $pr['moTa'] }}</span>
                            </td>
                            <td style="width: 200px">
                                @if ($pr['soLuong'] > 0)
                                    <span class="text-success">Còn hàng</span>
                                @else
                                    <span class="text-danger">Hết hàng</span>
                                @endif

                            </td>
                            <td><span class="truncate">{{ $pr['tenLoaiSp'] }}</span></td>
                            <td> <span class="truncate">{{ $pr['giaSp'] }}</span></td>

                            <td class="text-end">
                                <div class="d-flex">
                                    <div class="dropdown ms-auto">
                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-floating"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('admin.handle_remove', [
                                                'list_idSp' => implode(',', [$pr['idSp']]),
                                                'idLoaiSp' => implode(',', [$pr['idLoaiSp']]),
                                            ]) }}"
                                                class="dropdown-item">Xóa</a>

                                            <a href="{{ route('admin.product.edit', [
                                                'list_idSp' => implode(',', [$pr['idSp']]),
                                                'idLoaiSp' => implode(',', [$pr['idLoaiSp']]),
                                            ]) }}"
                                                class="dropdown-item">Sửa</a>
                                            <input id="idSp" type="hidden" name="idSp"
                                                value=" {{ $pr['idSp'] }} ">
                                            <button class="open-form-add-type dropdown-item">Thêm loại</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>



        {{-- page trang --}}
        @php
            // Lấy giá trị sort từ URL hoặc sử dụng 'desc' nếu không tồn tại
            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'desc';

            // Lấy giá trị take từ URL hoặc sử dụng 10 nếu không tồn tại
            $take = isset($_GET['take']) ? $_GET['take'] : 5;
        @endphp
        <nav class="mt-4" aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    @php
                        // Giả sử bạn đang sử dụng Laravel để kiểm tra tồn tại tham số 'page'
                        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                    @endphp
                    <a class="page-link"
                        href="{{ route('admin.product.list', [
                            'page' => max($currentPage - 1, 1),
                            'sort' => $sort,
                            'take' => $take,
                        ]) }}"
                        aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                @php

                    $qttPage = ceil($qttPrd / $take);

                @endphp
                @for ($i = 0; $i < $qttPage; $i++)
                    <li class="page-item {{ isset($_GET['page']) && $i + 1 == $_GET['page'] ? 'active' : '' }}">
                        <a class="page-link"
                            href="{{ route('admin.product.list', [
                                'page' => $i + 1,
                                'sort' => $sort,
                                'take' => $take,
                            ]) }}">{{ $i + 1 }}</a>
                    </li>
                @endfor

                <li class="page-item">
                    <a class="page-link"
                        href="{{ route('admin.product.list', [
                            'page' => isset($_GET['page']) ? $_GET['page'] + 1 : 1,
                            'sort' => $sort,
                            'take' => $take,
                        ]) }}"
                        aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    {{-- từ khóa --}}
    <div style="width: 30%" class="col-md-4">

        {{-- search --}}
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    aria-expanded="true" data-bs-target="#keywordsCollapseExample" role="button">
                    <div>Từ khóa</div>
                    <div class="bi bi-chevron-down"></div>
                </div>
                <div class="collapse show mt-4" id="keywordsCollapseExample">
                    <div class="input-group">
                        <input id="input-search" type="text" class="form-control"
                            placeholder="Laptop, CPU-RAM, PC ...">
                        <button id="btn-search" class="btn btn-outline-light" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- filter danh mục --}}
        <div class="card mb-3">
            <div class="card-body" style="height: 360px; overflow: auto;">
                <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    aria-expanded="true" data-bs-target="#categoriesCollapseExample" role="button">
                    <div>Danh mục</div>
                    <div class="bi bi-chevron-down"></div>
                </div>
                <div class="collapse show mt-4" id="categoriesCollapseExample">
                    <div class="d-flex flex-column gap-3">
                        <div class="form-check">
                            <input name="idDm" value="" class="form-check-input checkboxDm" type="checkbox"
                                id="categoryCheck1">
                            <label class="form-check-label" for="categoryCheck1">Tất cả</label>
                        </div>
                        @foreach ($allCtgr as $ctgr)
                            <div class="form-check">
                                <input name="idDm" value="{{ $ctgr['idDm'] }}"
                                    class="form-check-input checkboxDm" type="checkbox" id="categoryCheck1">
                                <label class="form-check-label" for="categoryCheck1">
                                    {{ $ctgr['tenDm'] }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <button id="btnFlCtgr" style="background-color: var(--bs-btn-bg:)" class="btn btn-primary">Lọc</button>
        </div>

    </div>
</div>

</div>

{{-- xủ lí lấy ra idSp va idLoaiSp khi click vào checkbox --}}
<script>
    $(document).ready(function() {
        // Chức năng chọn tất cả các checkbox
        $('.select-all').change(function() {
            var checkboxes = $(this).closest('table').find('tbody :checkbox');
            checkboxes.prop('checked', $(this).prop('checked'));
            updateCheckedData();
        });

        // Mảng để chứa giá trị idSp của các checkbox được chọn
        var checkedIdSpArray = [];
        var checkedIdLoaiSpArray = [];


        // Cập nhật số lượng checkbox được chọn và href của thẻ <a>
        function updateCheckedData() {
            var checkedCount = checkedIdSpArray.length;
            $('#checked-count').text(checkedCount);

            var editLink = "{{ route('admin.product.edit') }}?list_idSp=" + JSON.stringify(checkedIdSpArray) +
                "&idLoaiSp=" + JSON.stringify(checkedIdLoaiSpArray);
            $('#sua').attr('href', editLink);

            var removeLink = "{{ route('admin.handle_remove') }}?list_idSp=" + JSON.stringify(
                    checkedIdSpArray) +
                "&idLoaiSp=" + JSON.stringify(checkedIdLoaiSpArray);;
            $('#xoaSp').attr('href', removeLink);
        }

        // Chức năng của từng checkbox
        $('tbody').on('change', ':checkbox', function() {
            var idSp = $(this).closest('tr').attr('idSp');
            var idLoaiSp = $(this).closest('tr').attr('idLoaiSp');


            if ($(this).prop('checked')) {
                // Thêm idSp vào mảng nếu checkbox được chọn
                checkedIdSpArray.push(Number(idSp));
                checkedIdLoaiSpArray.push(Number(idLoaiSp));
            } else {
                // Xóa idSp khỏi mảng nếu checkbox không được chọn
                checkedIdSpArray = checkedIdSpArray.filter(function(value) {
                    return value !== Number(idSp);
                });

                checkedIdLoaiSpArray = checkedIdLoaiSpArray.filter(function(value) {
                    return value !== Number(idLoaiSp);
                });
            }

            // Cập nhật số lượng checkbox được chọn và href của thẻ <a>
            updateCheckedData();
        });

        // Khi trang tải lần đầu, cập nhật số lượng checkbox được chọn và href của thẻ <a>
        updateCheckedData();

        // Thêm sự kiện khi bấm vào "Check All"
        $('#check-all-button').click(function() {
            var isChecked = $(this).prop('checked');
            $('.select-all').prop('checked', isChecked);

            // Nếu "Check All" được chọn, thêm tất cả idSp vào mảng
            if (isChecked) {
                checkedIdSpArray = [];
                $('tbody :checkbox').each(function() {
                    var idSp = $(this).closest('tr').attr('idSp');
                    checkedIdSpArray.push(Number(idSp));
                });
            } else {
                // Ngược lại, xóa tất cả idSp khỏi mảng
                checkedIdSpArray = [];
                checkedIdLoaiSpArray = [];
            }

            // Cập nhật số lượng checkbox được chọn và href của thẻ <a>
            updateCheckedData();
        });

        function removeSelected() {
            // Do something with the remove link if needed
        }
    });
</script>

{{-- xử lí thay đổi fillter khi bấm vào apply fillter --}}
<script>
    document.getElementById('apply-filters').addEventListener('click', function() {
        // Lấy URL hiện tại
        let currentURL = new URL(window.location.href);

        // Lấy giá trị của tham số 'sort' và 'take' từ các ô input
        var sortValue = document.getElementById('form-sort').value;
        var takeValue = document.getElementById('form-take').value;

        // Đặt giá trị mới cho tham số 'sort' và 'take'
        currentURL.searchParams.set('sort', sortValue);
        currentURL.searchParams.set('take', takeValue);

        // Chuyển hướng trang đến URL mới
        window.location.href = currentURL.href;
    });
</script>

{{-- xử lí tìm kiếm js --}}
{{-- <script>
    const btnSearch = document.querySelector('#btn-search');
    const inputSearch = document.querySelector('#input-search');
    const elmTenSp = document.querySelectorAll('.tenSp');

    const searchTextElement = (listElm, text) => {
        const result = Array.from(listElm).filter((elm) => {
            return elm.textContent.includes(text); // Sử dụng textContent để lấy nội dung văn bản
        });

        return result;
    }

    btnSearch.addEventListener('click', () => {
        console.log('cehk');
        const searchedList = searchTextElement(elmTenSp, inputSearch.value);
        console.log(searchedList);
        
        elmTenSp.forEach((elm) => {
            if (!searchedList.includes(elm)) {
                elm.parentNode.style.display = 'none';
            }
        });
    });
</script> --}}

{{-- xử lí tìm kiếm dtb --}}
<script>
    const btnSearch = document.querySelector('#btn-search');

    btnSearch.addEventListener('click', () => {
        let URLCr = new URL(window.location.href);
        let valueSearch = document.querySelector('#input-search').value;
        URLCr.searchParams.set('search', valueSearch);
        window.location.href = URLCr.href;
    });
</script>

{{-- xử lí lọc sản danh mục --}}

{{-- xử lí lọc sản danh mục --}}
<script>
    const checkBoxDm = document.querySelectorAll('.checkboxDm');

    const btnFlCtgr = document.querySelector('#btnFlCtgr');
    let arrayCategoriesId = [];

    btnFlCtgr.addEventListener('click', () => {

        let URLFct = new URL(window.location.href);

        checkBoxDm.forEach((elm) => {
            if (elm.checked) {
                arrayCategoriesId.push(elm.value);
            }

        });

        URLFct.searchParams.set('searchCategory', arrayCategoriesId);

        window.location.href = URLFct.href;

    });
</script>


{{-- xử lí đóng mở form thêm loại --}}

<script>
    document.querySelectorAll('.open-form-add-type').forEach((elm) => {
        elm.addEventListener('click', () => {
            const idSp = elm.parentNode.querySelector('#idSp');
            const formHandleAddType = document.querySelector('#form-handle-add-type');

            if (elm.parentNode.contains(idSp)) {
                formHandleAddType.appendChild(idSp);
            }

            document.querySelector('#form-add-typePr').classList.add('inline-block');
        });
    });

    document.querySelector('#btn-close').addEventListener('click', () => {
        document.querySelector('#form-add-typePr').classList.remove('inline-block');
    });
</script>


@include('admin/footerAdmin')
