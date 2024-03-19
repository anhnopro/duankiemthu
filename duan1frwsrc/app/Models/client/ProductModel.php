<?php

namespace App\Models\client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class ProductModel extends Model
{
    use HasFactory;

    // model này để lấy ra sản phẩm home có giới hạn là 8
    public function getHomeProduct()
    {
        $result = DB::table('sanpham')
            ->join('sanphamdanhmucsanpham', 'sanphamdanhmucsanpham.idSp', '=', 'sanpham.idSp')
            ->join('danhmucsanpham', 'danhmucsanpham.idDm', '=', 'sanphamdanhmucsanpham.idDm')
            ->join('loaisanpham', 'loaisanpham.idSp', '=', 'sanpham.idSp')
            ->join('anhsanpham', 'anhsanpham.idSp', '=', 'sanpham.idSp')
            ->select(
                'sanpham.idSp',
                'sanpham.tenSp',
                'loaisanpham.moTa',
                'loaisanpham.soLuong',
                'loaisanpham.giaSp',
                'loaisanpham.tenLoaiSp',
                'loaisanpham.idLoaiSp',
                'sanpham.ngayTao',
                'loaisanpham.img',
                DB::raw('GROUP_CONCAT(DISTINCT danhmucsanpham.tenDm) as danhMucTongHop'),
                DB::raw('GROUP_CONCAT(DISTINCT anhsanpham.subImg) as subImgTongHop')
            )
            ->groupBy(
                'sanpham.idSp',
                'sanpham.tenSp',
                'loaisanpham.moTa',
                'loaisanpham.soLuong',
                'loaisanpham.giaSp',
                'loaisanpham.tenLoaiSp',
                'loaisanpham.idLoaiSp',
                'sanpham.ngayTao',
                'loaisanpham.img'
            )
            ->where('sanpham.trangThai', 1)
            ->limit(8);

        $result = $result->get();

        $result = json_decode(json_encode($result), true);

        return $result;
    }

    public function getHotProduct()
    {
        $result = DB::table('sanpham')
            ->join('sanphamdanhmucsanpham', 'sanphamdanhmucsanpham.idSp', '=', 'sanpham.idSp')
            ->join('danhmucsanpham', 'danhmucsanpham.idDm', '=', 'sanphamdanhmucsanpham.idDm')
            ->join('loaisanpham', 'loaisanpham.idSp', '=', 'sanpham.idSp')
            ->join('anhsanpham', 'anhsanpham.idSp', '=', 'sanpham.idSp')
            ->select(
                'sanpham.idSp',
                'sanpham.tenSp',
                'loaisanpham.moTa',
                'loaisanpham.soLuong',
                'loaisanpham.giaSp',
                'loaisanpham.tenLoaiSp',
                'loaisanpham.idLoaiSp',
                'sanpham.ngayTao',
                'loaisanpham.img',
                DB::raw('GROUP_CONCAT(DISTINCT danhmucsanpham.tenDm) as danhMucTongHop'),
                DB::raw('GROUP_CONCAT(DISTINCT anhsanpham.subImg) as subImgTongHop')
            )
            ->groupBy(
                'sanpham.idSp',
                'sanpham.tenSp',
                'loaisanpham.moTa',
                'loaisanpham.soLuong',
                'loaisanpham.giaSp',
                'loaisanpham.tenLoaiSp',
                'loaisanpham.idLoaiSp',
                'sanpham.ngayTao',
                'loaisanpham.img'
            )
            ->orderBy('loaisanpham.luotXem','desc')
            ->where('sanpham.trangThai', 1)
            ->limit(8);

        $result = $result->get();

        $result = json_decode(json_encode($result), true);

        return $result;
    }

    public function getProductCategories($idDm)
    {
        $result = DB::table('sanpham')
            ->join('sanphamdanhmucsanpham', 'sanphamdanhmucsanpham.idSp', '=', 'sanpham.idSp')
            ->join('danhmucsanpham', 'danhmucsanpham.idDm', '=', 'sanphamdanhmucsanpham.idDm')
            ->join('loaisanpham', 'loaisanpham.idSp', '=', 'sanpham.idSp')
            ->join('anhsanpham', 'anhsanpham.idSp', '=', 'sanpham.idSp')
            ->select(
                'danhmucsanpham.tenDm',
                'sanpham.idSp',
                'sanpham.tenSp',
                'loaisanpham.moTa',
                'loaisanpham.soLuong',
                'loaisanpham.giaSp',
                'loaisanpham.tenLoaiSp',
                'loaisanpham.idLoaiSp',
                'sanpham.ngayTao',
                'loaisanpham.img',
                DB::raw('GROUP_CONCAT(DISTINCT danhmucsanpham.tenDm) as danhMucTongHop'),
                DB::raw('GROUP_CONCAT(DISTINCT anhsanpham.subImg) as subImgTongHop')
            )
            ->groupBy(
                'danhmucsanpham.tenDm',
                'sanpham.idSp',
                'sanpham.tenSp',
                'loaisanpham.moTa',
                'loaisanpham.soLuong',
                'loaisanpham.giaSp',
                'loaisanpham.tenLoaiSp',
                'loaisanpham.idLoaiSp',
                'sanpham.ngayTao',
                'loaisanpham.img'
            )
            ->where('sanpham.trangThai', 1)
            ->where('danhmucsanpham.idDm', $idDm)
            ->limit(8);

        $result = $result->get();

        $result = json_decode(json_encode($result), true);

        return $result;
    }

    // model này lấy ra sản phẩm theo 
    public function getProducFltId($idSp, $idLoaiSp)
    {
        $result = DB::table('sanpham')
            ->join('sanphamdanhmucsanpham', 'sanphamdanhmucsanpham.idSp', '=', 'sanpham.idSp')
            ->join('danhmucsanpham', 'danhmucsanpham.idDm', '=', 'sanphamdanhmucsanpham.idDm')
            ->join('loaisanpham', 'loaisanpham.idSp', '=', 'sanpham.idSp')
            ->join('anhsanpham', 'anhsanpham.idSp', '=', 'sanpham.idSp')
            ->select(
                'sanpham.idSp',
                'sanpham.tenSp',
                'loaisanpham.img',
                'loaisanpham.moTa',
                'loaisanpham.soLuong',
                'loaisanpham.giaSp',
                'loaisanpham.tenLoaiSp',
                'loaisanpham.idLoaiSp',
                'sanpham.ngayTao',
                DB::raw('GROUP_CONCAT(DISTINCT danhmucsanpham.tenDm) as danhMucTongHop'),
                DB::raw('GROUP_CONCAT(DISTINCT anhsanpham.subImg) as subImgTongHop')
            )
            ->groupBy(
                'sanpham.idSp',
                'sanpham.tenSp',
                'loaisanpham.img',
                'loaisanpham.moTa',
                'loaisanpham.soLuong',
                'loaisanpham.giaSp',
                'loaisanpham.tenLoaiSp',
                'loaisanpham.idLoaiSp',
                'sanpham.ngayTao'
            )
            ->where('sanpham.trangThai', 1)
            ->where('sanpham.idSp', $idSp)
            ->where('loaisanpham.soLuong', '>', 0)
            ->where('loaisanpham.idLoaiSp', $idLoaiSp)

            ->get();

        foreach ($result as $prd) {
            $prd->danhMucTongHop = implode(',', array_unique(explode(',', $prd->danhMucTongHop)));
            $prd->subImgTongHop = implode(',', array_unique(explode(',', $prd->subImgTongHop)));
        }

        $result = json_decode(json_encode($result), true);

        return $result;
    }
    public function getTypeProduct($idSp)
    {
        $result = DB::table('loaisanpham')
            ->where('idSp', $idSp)
            ->get()->toArray();

        return array_map(function ($vl) {
            return (array) $vl;
        }, $result);
    }

    public function getCartProduct($idLoaiSp)
    {
        $result = DB::table('loaisanpham')
            ->join('sanpham', 'loaisanpham.idSp', '=', 'sanpham.idSp')
            ->select(
                'idLoaiSp',
                'tenSp',
                'img',
                'giaSp',
                'tenLoaiSp'
            )
            ->where('idLoaiSp', $idLoaiSp)
            ->first();

        return $result;
    }

    public function getIdnewDonHang()
    {
        $result = DB::table('donhang')->select('idDonHang')
            ->orderBy('idDonHang', 'desc')
            ->first();

        return ($result ? intval($result->idDonHang) : 1);
    }
    // model này để lấy ra luotXem của loại sản phẩm theo idLoaiSp
    public function getViewTypePr($idLoaiSp) {
        $result = DB::table('loaisanpham')->select(
            'luotXem'
        )->where('idLoaiSp', $idLoaiSp)->first();

        return $result->luotXem;
    }

    public function insertDonHang($idDonHang, $ten, $sdt, $email, $diaChi)
    {
        DB::table('donhang')->insert([
            [
                'idDonHang' => $idDonHang,
                'ten' => $ten,
                'Sdt' => $sdt,
                'Email' => $email,
                'Diachi' => $diaChi,
            ]
        ]);
    }
    
    public function insertCtDonHang($soLuongMua, $idDonHang, $idLoaiSp)
    {
        DB::table('chitietdonhang')->insert([
            [
                'soLuongMua' => $soLuongMua,
                'idDonHang' => $idDonHang,
                'idLoaiSp' => $idLoaiSp,
            ]
        ]);
    }

    public function updateViewTypePr($idLoaiSp, $curentView) {
        $data = [
            'luotXem' => $curentView + 1
        ];

        DB::table('loaisanpham')->where('idLoaiSp', $idLoaiSp)->update($data);
    }
   
}
