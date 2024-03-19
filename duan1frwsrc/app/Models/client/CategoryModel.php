<?php

namespace App\Models\client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class CategoryModel extends Model
{
    use HasFactory;

    public function createCategoryTree($ctgrList, $parentId, $level, $maxLevel)
    {
        $categoryTree = [];
        
        foreach ($ctgrList as $ctgr) {
            if ($ctgr['idDmcha'] == $parentId) {
                $ctgr['children'] = [];
    
                // Kiểm tra xem đã đạt đến cấp tối đa chưa
                if ($level < $maxLevel) {
                    $ctgr['children'] = $this->createCategoryTree($ctgrList, $ctgr['idDm'], $level + 1, $maxLevel);
                }
    
                $categoryTree[] = $ctgr;
            }
        }
    
        return $categoryTree;
    }
    

    // từ cây danh mục phân cấp chuyển sang html được xếp các cấp





    public function handleCategorylevel()
    {
        $listCtgr = $this->getAllCategories();
        $categoryTree = $this->createCategoryTree($listCtgr, 0,1,3);
        return $categoryTree;
    }
    public function getAllCategories() {
        $categories = DB::table('danhmucsanpham')->get()->toArray();

        // Convert each object to an associative array
        $categories = array_map(function ($category) {
            return (array) $category;
        }, $categories);

        return $categories;
    }
    public function getAllCategoriesFt() {
        $categories = DB::table('danhmucsanpham')
        ->get()
        ->where('idDmcha', 0)
        ->toArray();

        // Convert each object to an associative array
        $categories = array_map(function ($category) {
            return (array) $category;
        }, $categories);

        return $categories;
    }
    public function getNameCategory($idDm) {
        $result = DB::table('danhmucsanpham')->select(
            'tenDm')
        ->where('idDm', $idDm)
        ->first();
        return $result->tenDm;
    }
    
}
