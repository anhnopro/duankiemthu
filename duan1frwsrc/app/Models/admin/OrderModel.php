<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class OrderModel extends Model
{
    use HasFactory;
    protected $data;
    public function __construct()
    {

    }
    public function getAllDataOrders()
    {

        $result = DB::table('donhang')
            ->join('chitietdonhang', 'chitietdonhang.idDonHang', '=', 'donhang.idDonHang')
            ->join('loaisanpham','loaisanpham.idLoaiSp', '=', 'chitietdonhang.idLoaiSp')
            ->join('sanpham','sanpham.idSp', '=', 'loaisanpham.idSp')
            ->select(
                'donhang.idDonHang',
                'donhang.ten',
                'donhang.Sdt',
                'donhang.Email',
                'donhang.DiaChi',
                'donhang.trangThai',
                'donhang.ngayMuaHang',
                'sanpham.tenSp',
                'loaisanpham.tenLoaiSp',
                'loaisanpham.img',
                'loaisanpham.giaSp',
                'chitietdonhang.soLuongMua'
            )
            ->get()->toArray();
        return array_map(function ($item) {
            return (array) $item;
        }, $result);
    }

}
