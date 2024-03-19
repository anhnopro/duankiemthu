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


<div class="main-add row">
    <div class="form-add w-50">
        {{-- char thông kế lượt thêm xóa trong tuần --}}
        <div style="padding: 6px" class="chart-add row">
            <div class="col-lg-4 col-md-12 w-50 pt-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="display-7">
                                <i class="bi bi-basket"></i>
                            </div>
                        </div>
                        <h4 class="mb-3">Deletes This Week</h4>
                        <div class="d-flex mb-3" style="position: relative;">
                            <div class="display-7">30</div>
                            <div class="ms-auto" id="deletes-chart" style="min-height: 35px;">
                                <div id="deletes-chart-apex" class="apexcharts-canvas"></div>
                                <!-- Chú ý: Giữ nguyên div để biểu đồ hiển thị -->
                            </div>
                        </div>
                        <div class="text-success">
                            Over the last month 1.4% <i class="small bi bi-arrow-up"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 w-50 pt-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="display-7">
                                <i class="bi bi-basket"></i>
                            </div>
                        </div>
                        <h4 class="mb-3">Adds This Week</h4>
                        <div class="d-flex mb-3" style="position: relative;">
                            <div class="display-7">15</div>
                            <div class="ms-auto" id="adds-chart" style="min-height: 35px;">
                                <div id="adds-chart-apex" class="apexcharts-canvas"></div>
                                <!-- Chú ý: Giữ nguyên div để biểu đồ hiển thị -->
                            </div>
                        </div>
                        <div class="text-danger">
                            Over the last month -0.5% <i class="small bi bi-arrow-down"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- form thêm sản phẩm --}}
        <div class="form-add-product bg-white p-4 mt-2 rounded">
            <h4 class="pt-5">Form Thêm Sản Phẩm</h4>
            <form id="form-add" class=" row pt-5" action="handle_add_product" method="post"
                enctype="multipart/form-data">
                <div class="form-section col-12">
                    <label for="category">Danh Mục(chọn nhiều):</label>
                    <select class="form-control custom-select" id="select-Dm">

                        @foreach ($allCtgr as $ctgr)
                            <option value="{{ $ctgr['idDm'] }}">{{ $ctgr['tenDm'] }}</option>
                        @endforeach

                    </select>
                    <div id="category-added" style="display: grid; grid-template-columns: repeat(3, 1fr)">

                    </div>
                </div>


                <div class="form-section col-12">
                    <label for="productName">Tên Sản Phẩm:</label>
                    <input name="tenSp" type="text" class="form-control" id="productName">
                </div>

                <div class="form-section col-12">
                    <label for="description">Mô Tả:</label>
                    <textarea name="moTa" class="form-control" id="description"></textarea>
                </div>

                <div class="form-section col-12">
                    <label for="mainImage">Ảnh Chính:</label>
                    <input name="main-img" type="file" class="form-control" id="mainImage" required>
                    <div id="mainImagePreview" class="mt-2 w-20"></div>
                </div>

                <div class="form-section col-12">
                    <label for="additionalImages">Ảnh Phụ (Chọn Nhiều):</label>
                    <input name="sub-img[]" type="file" class="form-control" id="additionalImages" multiple required>
                    <div id="additionalImagesPreview" class="mt-2"
                        style="display: grid; grid-template-columns: repeat(4, 1fr)"></div>
                </div>

                <div class="form-section col-12">
                    <label for="quantity">Số Lượng:</label>
                    <input name="soLuong" type="number" class="form-control" id="quantity">
                </div>

                <div class="form-section col-12">
                    <label for="productType">Loại Sản Phẩm:</label>
                    <input name="tenLoaiSp" type="text" class="form-control" id="productType">
                </div>

                <div class="form-section col-12">
                    <label for="price">Giá:</label>
                    <input name="giaSp" type="number" class="form-control" id="price">
                </div>

                <div class="form-section col-12">

                    <input id="slDm" type="hidden" name="slDm">
                    <input id="slAnh" type="hidden" name="slAnh">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
                </div>
            </form>
        </div>
    </div>

    {{-- bảng thêm mới trong ngày --}}

    <div class="table-add-today w-50">
        <div class="table-responsive">
            <table class="table table-custom table-lg mb-0" id="products">
                <h4 class="pt-2">Thêm mới trong ngày</h4>
                <thead>
                    <tr>
                        <th>
                            <input class="form-check-input select-all" type="checkbox"
                                data-select-all-target="#products" id="defaultCheck1">
                        </th>
                        <th>Ảnh</th>
                        <th>Tên</th>
                        <th>Tình trạng</th>
                        <th>Ngày tạo</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($newProInDay as $pr)
                        <tr>
                            <td>
                                <input class="form-check-input" type="checkbox">
                            </td>
                            <td>
                                <a href="#">
                                    <img src="{{ asset('storage/upload/' . $pr['img']) }}" class="rounded"
                                        width="40" alt="...">
                                </a>
                            </td>
                            <td><span class="truncate tenSp" >{{ $pr['tenSp'] }}</span></td>
                            <td>
                                @if ($pr['soLuong'] > 0)
                                    <span class="text-success">Còn hàng</span>
                                @else
                                    <span class="text-danger">Hết hàng</span>
                                @endif
                            </td>
                            <td><span class="truncate" >{{ $pr['ngayTao'] }}</span></td>
                            <td class="text-end">
                                <div class="d-flex">
                                    <div class="dropdown ms-auto">
                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-floating"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('admin.handle_remove', ['list_idSp' => implode(',', [$pr['idSp']])]) }}"
                                                class="dropdown-item">Xóa</a>

                                            <a href="{{ route('admin.product.edit', ['list_idSp' => implode(',', [$pr['idSp']])]) }}"
                                                class="dropdown-item">Sửa</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

<script>
    // Khai báo dữ liệu biểu đồ Deletes (thay đổi theo dữ liệu thực của bạn)
    var deletesChartData = {
        series: [{
            name: "Deletes",
            data: [30, 20, 10, 25, 15, 30] // Dữ liệu lượt xóa (thay đổi theo dữ liệu thực của bạn)
        }],
        chart: {
            type: 'line',
            height: 35,
            width: 100,
            sparkline: {
                enabled: true
            },
        },
        stroke: {
            curve: 'smooth',
            width: 3,
        },
        xaxis: {
            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri',
                'Sat'
            ], // Nhãn ngày trong tuần (thay đổi theo nhu cầu của bạn)
        },
        colors: ['#d63384'], // Màu của dòng biểu đồ
    };

    // Khởi tạo và render biểu đồ Deletes
    var deletesChart = new ApexCharts(document.querySelector("#deletes-chart-apex"), deletesChartData);
    deletesChart.render();

    // Khai báo dữ liệu biểu đồ Adds (thay đổi theo dữ liệu thực của bạn)
    var addsChartData = {
        series: [{
            name: "Adds",
            data: [15, 25, 20, 30, 10, 22] // Dữ liệu lượt thêm (thay đổi theo dữ liệu thực của bạn)
        }],
        chart: {
            type: 'line',
            height: 35,
            width: 100,
            sparkline: {
                enabled: true
            },
        },
        stroke: {
            curve: 'smooth',
            width: 3,
        },
        xaxis: {
            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri',
                'Sat'
            ], // Nhãn ngày trong tuần (thay đổi theo nhu cầu của bạn)
        },
        colors: ['#ff4d4d'], // Màu của dòng biểu đồ
    };

    // Khởi tạo và render biểu đồ Adds
    var addsChart = new ApexCharts(document.querySelector("#adds-chart-apex"), addsChartData);
    addsChart.render();
</script>

{{--  --}}
{{-- xử lí thêm nhiều danh mục sản phẩm --}}
<script>
    const formAdd = document.querySelector('#form-add');
    const selectDm = document.querySelector('#select-Dm');

    let sttDm = 0;

    const createElement = (name, atb, text = '') => {
        const element = document.createElement(name);
        for (key in atb) {
            if (atb.hasOwnProperty(key)) {
                element.setAttribute(key, atb[key]);
            }
        }
        element.innerText = text;
        if (element) {
            return element;
        } else {
            return createElement('div', {
                class: 'error'
            }, 'error');
        }
    }

    const addInputCategory = (tag, elmF) => {
        elmF.appendChild(createElement('input', {
            type: 'hidden',
            name: `idDm${sttDm}`,
            value: tag.value,
        }));

        sttDm++;
    }
    const addDivCategory = (tag, elmF) => {
        elmF.appendChild(createElement('div', {
            style: "border-radius: 10px; width: 90%; margin-top: 10px",
            class: 'text-success'

        }, tag.options[tag.selectedIndex].innerText));
    }

    selectDm.addEventListener('change', (e) => {
        const tag = e.target;
        tag.options[tag.selectedIndex].disabled = true;
        addInputCategory(tag, document.querySelector('#category-added'));
        addDivCategory(tag, document.querySelector('#category-added'));

        document.querySelector('#slDm').value = sttDm;
    });
</script>

{{-- xử lí chọn nhiều ảnh --}}
<script>
    function previewImages(input, previewId) {
        const previewContainer = document.getElementById(previewId);
        previewContainer.innerHTML = ''; // Clear previous previews

        const files = input.files;
        let i = 0;
        for (const file of files) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement('img');
                img.style.width = '50px';
                img.src = e.target.result;
                previewContainer.appendChild(img);
            };

            reader.readAsDataURL(file);
            i++;
        }
        document.querySelector('#slAnh').value = i;
    }

    document.getElementById('mainImage').addEventListener('change', function() {
        console.log(this);
        previewImages(this, 'mainImagePreview');
    });

    document.getElementById('additionalImages').addEventListener('change', function() {
        previewImages(this, 'additionalImagesPreview');
    });
</script>

{{-- xủ lí lấy ra idSp khi click vào checkbox --}}
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

        // Cập nhật số lượng checkbox được chọn và href của thẻ <a>
        function updateCheckedData() {
            var checkedCount = checkedIdSpArray.length;
            $('#checked-count').text(checkedCount);

            var editLink = "{{ route('admin.product.edit') }}?list_idSp=" + JSON.stringify(checkedIdSpArray);
            $('#sua').attr('href', editLink);

            var removeLink = "{{ route('admin.handle_remove') }}?list_idSp=" + JSON.stringify(
                checkedIdSpArray);
            $('#xoaSp').attr('href', removeLink);
        }

        // Chức năng của từng checkbox
        $('tbody').on('change', ':checkbox', function() {
            var idSp = $(this).closest('tr').attr('idSp');

            if ($(this).prop('checked')) {
                // Thêm idSp vào mảng nếu checkbox được chọn
                checkedIdSpArray.push(Number(idSp));
            } else {
                // Xóa idSp khỏi mảng nếu checkbox không được chọn
                checkedIdSpArray = checkedIdSpArray.filter(function(value) {
                    return value !== Number(idSp);
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
            }

            // Cập nhật số lượng checkbox được chọn và href của thẻ <a>
            updateCheckedData();
        });

        function removeSelected() {
            // Do something with the remove link if needed
        }
    });
</script>

@include('admin/footerAdmin')
