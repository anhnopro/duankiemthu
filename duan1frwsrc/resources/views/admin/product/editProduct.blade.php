@include('admin/headerAdmin')

@php
    $icheck = 0;
@endphp

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



<div class="form-add-product bg-white p-4 mt-2 rounded">
    <h4 class="pt-5">Form Sửa Sản Phẩm</h4>
    <form id="form-add" class=" row pt-5" action="./hanlde_edit_products" method="post" enctype="multipart/form-data">
        @foreach ($Pro as $P)
            <h4 class="mt-1">{{ $P[0]['tenSp'] }}</h4>
            <div class="form-section col-12">
                <label for="category">Danh Mục (chọn nhiều):</label>
                <div style="text-align: center; display: grid; grid-template-columns: repeat(10,1fr);
                 height: 140px; overflow-y: scroll;">
                    @foreach ($allCtgr as $ctgr)
                        <div>
                            

                            <input type="checkbox" name="idDm{{ $icheck }}[]" value="{{ $ctgr['idDm'] }}" >
                            <label>{{ $ctgr['tenDm'] }}</label>
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="form-section col-12">
                <label for="productName">Tên Sản Phẩm:</label>
                <input name="tenSp{{ $icheck }}" type="text" class="form-control" id="productName"
                    value="{{ $P[0]['tenSp'] }}" required>
            </div>

            <div class="form-section col-12">
                <label for="description">Mô Tả:</label>
                <textarea required name="moTa{{ $icheck }}" class="form-control" id="description">{{ $P[0]['moTa'] }}</textarea>
            </div>

            <div class="form-section col-12">
                <label for="mainImage">Ảnh Chính:</label>

                <input name="main-img{{ $icheck }}" type="file" class="form-control" id="mainImage">
                <div id="mainImagePreview" class="mt-2 w-20">
                    <input type="hidden" name="mainLmgSave{{ $icheck }}" value="{{ $P[0]['img'] }}">
                    <img width="200px" src="{{ asset('storage/upload/' . $P[0]['img']) }}" alt="">
                </div>
            </div>

            <div class="form-section col-12">
                {{ $P[0]['subImgTongHop'] }}
                <label for="additionalImages">Ảnh Phụ (Chọn Nhiều):</label>
                <input name="sub-img{{ $icheck }}[]" type="file" class="form-control" id="additionalImages"
                    multiple>
                <div id="additionalImagesPreview" class="mt-2"
                    style="display: grid; grid-template-columns: repeat(4, 1fr)">
                    @php
                        $i = 0;
                        $result = explode(',', $P[0]['subImgTongHop']);
                    @endphp
                    <input type="hidden" name="subLmgSave{{$icheck}}" value="{{ $P[0]['subImgTongHop'] }}">
                    @foreach ($result as $subImg)
                        <img width="200px" src="{{ asset('storage/upload/' . $subImg) }}" alt="">
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </div>
            </div>

            <div class="form-section col-12">
                <label for="quantity">Số Lượng:</label>
                <input name="soLuong{{ $icheck }}" type="number" class="form-control" id="quantity"
                    value="{{ $P[0]['soLuong'] }}" required>
            </div>

            <div class="form-section col-12">
                <label for="productType">Loại Sản Phẩm:</label>
                <input name="tenLoaiSp{{ $icheck }}" type="text" class="form-control" id="productType"
                    value="{{ $P[0]['tenLoaiSp'] }}" required>
            </div>

            <div class="form-section col-12">
                <label for="price">Giá:</label>
                <input name="giaSp{{ $icheck }}" type="number" class="form-control" id="price"
                    value="{{ $P[0]['giaSp'] }}" required>
            </div>

            <div class="form-section col-12">

                <input type="hidden" name="idSp{{ $icheck }}" value="{{ $P[0]['idSp'] }}">
                <input type="hidden" name="idLoaiSp{{ $icheck }}" value="{{ $P[0]['idLoaiSp'] }}">

                @php
                    $icheck++;
                @endphp
        @endforeach
        <input type="hidden" name="editTable" value="{{ $icheck }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" class="btn btn-primary">Sửa Sản Phẩm</button>
</div>
</form>
</div>


@include('admin/footerAdmin')
