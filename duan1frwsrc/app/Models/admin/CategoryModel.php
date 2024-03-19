<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CategoryModel extends Model
{
    use HasFactory;

    // sử dụng đệ quy tạo cây danh mục cấp cha con

    public function createCategoryTree($ctgrList, $parentId)
    {
        $categoryTree = [];
        foreach ($ctgrList as $ctgr) {

            if ($ctgr['idDmcha'] == $parentId) {

                $ctgr['children'] = $this->createCategoryTree($ctgrList, $ctgr['idDm']);
                $categoryTree[] = $ctgr;
            }
        }
        return $categoryTree;
    }

    // từ cây danh mục phân cấp chuyển sang html được xếp các cấp

    function handleCategoryTreeHTML($childerArr)
    {
        $listHTML = "";

        foreach ($childerArr as $child) {
            extract($child);
            $iconDm = htmlspecialchars_decode($iconDm);
            $listHTML .= "<div class='menu-item' idDm='$idDm'>$iconDm$tenDm</div>";

            if (!empty($child['children'])) {
                $listHTML .= "<div class='submenu'>";
                $listHTML .= $this->handleCategoryTreeHTML($child['children']);
                $listHTML .= "</div>";
            }
        }

        return $listHTML;
    }



    public function handleCategorylevel($status)
    {
        $listCtgr = $this->getAllCategories($status);
        $categoryTree = $this->createCategoryTree($listCtgr, 0);
        return $this->handleCategoryTreeHTML($categoryTree);
    }


    // trả về mảng dữ liệu database danh mục
    public function getAllCategories($status)
    {
        $categories = DB::table('danhmucsanpham')->where('trangThai',$status)->get()->toArray();

        // Convert each object to an associative array
        $categories = array_map(function ($category) {
            return (array) $category;
        }, $categories);

        return $categories;
    }

    // insert danh muc 
    public function insertCategory($tenDm, $iconDm, $idDmcha = 0)
    {

        $data = [
            'tenDm' => $tenDm,
            'iconDm' => $iconDm,
            'idDmcha' => $idDmcha,
            'trangThai' => 1,
        ];

        // Chèn dữ liệu vào cơ sở dữ liệu
        DB::table('danhmucsanpham')->insert($data);
    }


    public function updateLevelCategory($idDm, $idDmcha)
    {
        $newData = [
            'idDmcha' => $idDmcha,
        ];

        // Sử dụng DB facade để cập nhật bản ghi
        DB::table('danhmucsanpham')->where('idDm', $idDm)->update($newData);
    }

    public function renameCateogory($idDm, $iconDm = '', $tenDm) {
        $newName = [
            'iconDm' => $iconDm,
            "tenDm" => $tenDm
        ];
        DB::table('danhmucsanpham')->where('idDm', $idDm)->update($newName);
    }
    public function removeCategory($idDm){
        $changed = [
            'trangThai' => 0
        ];
        DB::table('danhmucsanpham')->where('idDm', $idDm)->update($changed);
    }

    public function restoreCategory($idDm){
        $changed = [
            'trangThai' => 1
        ];
        DB::table('danhmucsanpham')->where('idDm', $idDm)->update($changed);
    }


}