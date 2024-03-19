@include("admin/headerAdmin")
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
{{-- code ở đây --}}


<div class="table-responsive">

    {{-- bảng --}}
    
    <table class="table table-custom table-lg mb-0" id="products">
        <thead>
            <tr>
                <td>
                    <input class="form-check-input select-all" type="checkbox"
                        data-select-all-target="#products" id="defaultCheck1">
                </td>
                <td>Id</td>
                <td>Img</td>
                <td>Name</td>
                <td>Type</td>
                <td>Buyer</td>
                <td>Phone</td>
                <td>Email</td>
                <td>Address</td>
                <td>Buy at</td>
                <td>Price</td>
                <td>Quantity</td>
                <td>Total</td>
                <td>Status</td>
                <td class="text-end">Actions</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($allOrders as $pr)
                <tr idDonHang= "{{ $pr['idDonHang'] }}">
                    <td>
                        <input class="form-check-input" type="checkbox">
                    </td>
                    <td> {{ $pr['idDonHang'] }} </td>
                    <td>
                        <img width="40px" src="{{ asset('storage/upload/'.$pr['img']) }}" class="truncate">
                    </td>
                    <td>
                        <p class="truncate">{{ $pr['tenSp'] }}</p> 
                    </td>
                    <td class="truncate tenSp">{{ $pr['tenLoaiSp'] }}</td>
                    <td>
                        <span class="truncate">{{ $pr['ten'] }}</span>
                    </td>
                    <td>
                        <span class="truncate">{{ $pr['Sdt'] }}</span>
                    </td>
                    <td>
                        <span class="truncate">{{ $pr['Email'] }}</span>
                    </td>
                    <td>
                        <span class="truncate">{{ $pr['DiaChi'] }}</span>
                    </td>

                    <td>
                        <span class="truncate">{{ $pr['ngayMuaHang'] }}</span>
                    </td>

                    <td>
                        <span class="truncate">{{ $pr['giaSp'] }}</span>
                    </td>

                    <td>
                        <span class="truncate">{{ $pr['soLuongMua'] }}</span>
                    </td>
                    
                    <td>
                        <span class="truncate">{{ $pr['soLuongMua'] * $pr['giaSp'] }}</span>
                    </td>
                    <td>
                        @switch($pr['trangThai'])
                            @case('Đợi xử lý')
                                <span class="text-danger">Wait</span>
                                @break
                            @case('Đóng gói')
                                <span class="text-bg-half">Đóng gói</span>
                                @break
                            @case('Vận chuyển')
                                <span class="text-danger">Vận chuyển</span>
                                @break
                           
                            @case('Đang giao')
                                <span class="text-success">Đang giao</span>
                                @break
                            
                            @case('Đã giao')
                                <span class="text-bg-primary">Đã giao</span>
                                @break
                            @default
                                
                        @endswitch
                    </td>
            
                    <td class="text-end">
                        <div class="d-flex">
                            <div class="dropdown ms-auto">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-floating"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href=""
                                        class="dropdown-item">Xử lý đơn hàng</a>

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