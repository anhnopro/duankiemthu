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

<div class="table-responsive">

    {{-- bảng --}}
    <table class="table table-custom table-lg mb-0" id="products">
        <thead>
            <tr>
                <td>
                    <input class="form-check-input select-all" type="checkbox"
                        data-select-all-target="#products" id="defaultCheck1">
                </td>
                <td>Danh mục</td>
                <td>Ảnh</td>
                <td>Tên sản phẩm</td>
                <td>Mô tả</td>
                <td>Tình trạng</td>
                <td>Loại</td>
                <td>Giá</td>
                <td class="text-end">Actions</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($trashPr as $pr)
                <tr idSp= "{{ $pr['idSp'] }}">
                    <td>
                        <input class="form-check-input" type="checkbox">
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
                    <td>
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
                                    <form action="handle_restore_product" method="post">
                                        <input type="hidden" name="idSp" value="{{ $pr['idSp'] }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button class="dropdown-item">Khôi phục</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@include('admin/footerAdmin');
