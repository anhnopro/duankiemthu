<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class ProductsModel extends Model
{
    use HasFactory;


    // class get model
    public function getAllIfProduct($offset, $take, $sort, $search, $searchCt)
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
                'sanpham.ngayTao',            )
            ->offset($offset)
            ->take($take)
            ->where('sanpham.trangThai', 1)
            ->where('sanpham.tenSp', 'LIKE', "%{$search}%");

        if (($searchCt[0] !== '')) {
            $result->whereIn('danhmucsanpham.idDm', $searchCt);
        }

        $result->orderBy('sanpham.idSp', $sort);
        $result = $result->get();

        foreach ($result as $prd) {
            $prd->danhMucTongHop = implode(',', array_unique(explode(',', $prd->danhMucTongHop)));
        }

        $result = json_decode(json_encode($result), true);

        return $result;
    }


    public function getAllIfProductThan($idSp)
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
                'sanpham.ngayTao',
                DB::raw('GROUP_CONCAT(DISTINCT danhmucsanpham.tenDm) as danhMucTongHop'),
                DB::raw('GROUP_CONCAT(DISTINCT anhsanpham.subImg) as subImgTongHop'),
                DB::raw('GROUP_CONCAT(DISTINCT loaisanpham.tenLoaiSp) as tenLoaiSpTongHop')
            )
            ->groupBy(
                'sanpham.idSp',
                'sanpham.tenSp',
                'loaisanpham.img',
                'loaisanpham.moTa',
                'loaisanpham.soLuong',
                'loaisanpham.giaSp',
                'loaisanpham.tenLoaiSp',
                'sanpham.ngayTao',            )
            ->where('sanpham.trangThai', 1)
            ->where('sanpham.idSp', '>', $idSp)
            ->orderBy('sanpham.idSp', 'asc')
            ->get();

        foreach ($result as $prd) {
            $prd->danhMucTongHop = implode(',', array_unique(explode(',', $prd->danhMucTongHop)));
        }

        $result = json_decode(json_encode($result), true);

        return $result;
    }

    public function getAllIfProductTrash()
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
                'sanpham.ngayTao',            )
            ->where('sanpham.trangThai', 0);

        $result = $result->get();

        foreach ($result as $prd) {
            $prd->danhMucTongHop = implode(',', array_unique(explode(',', $prd->danhMucTongHop)));
        }

        $result = json_decode(json_encode($result), true);

        return $result;
    }

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
                'sanpham.ngayTao',            )
            ->take(10)
            ->where('sanpham.trangThai', 1)
            ->where('sanpham.idSp', $idSp)
            ->where('loaisanpham.idLoaiSp', $idLoaiSp)

            ->get();

        foreach ($result as $prd) {
            $prd->danhMucTongHop = implode(',', array_unique(explode(',', $prd->danhMucTongHop)));
            $prd->subImgTongHop = implode(',', array_unique(explode(',', $prd->subImgTongHop)));
        }

        $result = json_decode(json_encode($result), true);

        return $result;
    }


    public function getIDnewProduct()
    {
        $idResults = DB::table('sanpham')
            ->orderBy('idSp', 'desc')
            ->pluck('idSp')
            ->first();
        if (!$idResults) {
            $idResults = 1;
        }
        return $idResults;
    }

    public function getTotalQuantityForAllProducts()
    {
        $totalProducts = DB::table('loaisanpham')->count();
        return $totalProducts;
    }

    public function getCategoryProductCategory($idSp)
    {
        $results = DB::table('sanphamdanhmucsanpham')->where('idSp', $idSp)->get()->toArray();
        return array_map(function ($item) {
            return (array) $item;
        }, $results);
    }

    public function getDataProImgId($idSp) {
        $results = DB::table('anhsanpham')->where('idSp', $idSp)->get()->toArray();
        return array_map(function ($item) {
            return (array) $item;
        }, $results);
    }


    // class insert model
    public function insertCategoryProduct($idSp, $idDm)
    {
        $data = [
            'idSp' => $idSp,
            'idDm' => $idDm,

        ];
        DB::table('sanphamdanhmucsanpham')->insert($data);
    }
    public function insertProduct($idSp, $tenSp)
    {
        $data = [
            'idSp' => $idSp,
            'tenSp' => $tenSp,
        ];
        DB::table('sanpham')->insert($data);
    }

    public function insertProductType($tenLoaiSp, $img, $moTa, $giaSp, $idSp, $soLuong)
    {
        $data = [
            'tenLoaiSp' => $tenLoaiSp,
            'moTa' => $moTa,
            'giaSp' => $giaSp,
            'idSp' => $idSp,
            'soLuong' => $soLuong,
        ];
        if(!empty($img)) {
            $data['img'] = $img; 
        }
        DB::table('loaisanpham')->insert($data);
    }

    public function insertProductImg($img, $idSp)
    {
        $data = [
            'subImg' => $img,
            'idSp' => $idSp
        ];
        DB::table('anhsanpham')->insert($data);
    }

    // class update model

    public function removeProduct($idSp)
    {
        $data = [
            'trangThai' => 0
        ];
        DB::table('sanpham')->where('idSp', $idSp)->update($data);
    }

    public function restoreProduct($idSp)
    {
        $data = [
            'trangThai' => 1
        ];
        DB::table('sanpham')->where('idSp', $idSp)->update($data);
    }



    public function updateCategoryProduct($idSpDm, $idDm)
    {
        $data = [
            'idDm' => $idDm
        ];
        DB::table('sanphamdanhmucsanpham')
            ->where('idSpDm', $idSpDm)
            ->update($data);
    }

    public function updateProduct($idSp, $tenSp)
    {
        $data = [
            'tenSp' => $tenSp,
            
        ];
        DB::table('sanpham')
            ->where('idSp', $idSp)
            ->update($data);
    }
    public function updateProductType($tenLoaiSp, $img, $moTa, $giaSp, $idLoaiSp, $soLuong)
    {

        $data = [
            'tenLoaiSp' => $tenLoaiSp,
            'moTa' => $moTa,
            'soLuong' => $soLuong,
            'giaSp' => $giaSp
        ];
        if(!empty($img)) {
            $data['img'] = $img;
        }
     
        DB::table('loaisanpham')->where('idLoaiSp', $idLoaiSp)->update($data);
    }

   
    public function updateProductImgIdImg($idImgs,$subImg) {
        DB::table('anhsanpham')
                ->where('idImgs', $idImgs)
                ->update(['subImg' => $subImg]);
    }
    // xóa delete sanphamdanhmuc

    public function deleteCuC($idSpDm)
    {

        DB::table('sanphamdanhmucsanpham')
            ->where('idSpDm', $idSpDm)
            ->delete();
    }

    public function deleteImg($idImgs)
    {

        DB::table('anhsanpham')
            ->where('idImgs', $idImgs)
            ->delete();
    }
}
