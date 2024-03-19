@include('client/headerClient')
<div class="home-products">
    <h2>Danh mục: {{$tenDm }}</h2>

    <div class="list-home-prds">

        @foreach ($listProCtgries as $Pr)
            @php
                $ts = explode(' ', $Pr['tenLoaiSp']);
                $plug = implode('_', explode(' ', $Pr['tenSp']));

            @endphp
            <a href="{{ route('sanpham.productdetail', [
                'plug' => $plug,
                'idSp' => $Pr['idSp'],
                'idLoaiSp' => $Pr['idLoaiSp'],
            ]) }}"
                class="product">
                <img src=  "{{ asset('storage/upload/' . $Pr['img']) }}" alt="">

                <div class="name-pr">{{ $Pr['tenSp'] }}</div>

                <div class="ifPro">
                    @foreach ($ts as $t)
                        <div style="padding: 5px">{{ $t }}</div>
                    @endforeach
                </div>
                <div class="price-Pr">{{ number_format($Pr['giaSp'], 0, ',', '.') }}</div>
            </a>
        @endforeach
    </div>
</div>
@include('client/footerClient')
