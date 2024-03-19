<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// link tới các class model
use App\Models\admin\ProductsModel;
use App\Models\admin\CategoryModel;

// link tới các class để setcookie
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class ProductAdminController extends Controller
{
    protected $data;
    protected $objProduct;
    protected $redirect;
    public function __construct()
    {

    }
    // phương thức(GET) hiện thị các page sản phẩm

    public function showListProduct(Request $request)
    {
        $objCt = new CategoryModel();
        $objPr = new ProductsModel();

        $take = $request->input('take', 5);
        $offsetPage = ($request->input('page', 0) - 1) * $take;
        $sort = $request->input('sort', 'desc');
        $search = $request->input('search', '');

        $searchCt = explode(',', urldecode($request->input('searchCategory')));

        $data = [
            'qttPrd' => $objPr->getTotalQuantityForAllProducts(),
            'allPro' => $objPr->getAllIfProduct($offsetPage, $take, $sort, $search, $searchCt),
            'allCtgr' => $objCt->getAllCategories(1)
        ];
        return view("admin/product/listProduct", $data);
    }

    public function showAddProduct()
    {
        $objMd = new CategoryModel();
        $objPr = new ProductsModel();

        $allCtgr = $objMd->getAllCategories(1);
        $newProInDay = [];

        $newProInDayCookie = Cookie::get('newProIdInDay');
        if ($newProInDayCookie) {
            $newProInDay = $objPr->getAllIfProductThan($newProInDayCookie);
        }



        $data = [
            'allCtgr' => $allCtgr,
            'newProInDay' => $newProInDay
        ];

        return view("admin/product/addProduct", $data);
    }

    public function showEditProduct(Request $request)
    {
        $objCt = new CategoryModel();
        $objPr = new ProductsModel();

        $listIdSpString = $request->input('list_idSp');
        $ListidLoaiSpString = $request->input('idLoaiSp');
        $IdSp = json_decode($listIdSpString, true);

        $idLoaiSp = json_decode($ListidLoaiSpString, true);




        $result = [];
        if (gettype($IdSp) != 'array') {

            $result[] = $objPr->getProducFltId($IdSp, $idLoaiSp);
        } else {

            foreach ($IdSp as $index => $idSp) {

                $result[] = $objPr->getProducFltId($idSp, $idLoaiSp[$index]);
            }

        }
        $data = [
            'Pro' => $result,
            'allCtgr' => $objCt->getAllCategories(1)
        ];
        return view("admin/product/editProduct", $data);
    }

    public function showTrashProduct()
    {
        $idSp = Cookie::get('newProIdInDay');
        $objPr = new ProductsModel();

        $data = [
            'trashPr' => $objPr->getAllIfProductTrash()
        ];
        return view("admin/product/trashProduct", $data);
    }

    // phương thức(POST) xử lí các form danh mục

    public function handleAddProduct(Request $request)
    {
        try {
            $objModelProduct = new ProductsModel();

            $idSPNew = $objModelProduct->getIDnewProduct() + 1;
            $rqAll = $request->all();

            // xử lý lấy ra tên ảnh
            $mainImage = $request->file('main-img');
            $subImages = $request->file('sub-img');

        
            // insert sản phẩm
            $objModelProduct->insertProduct($idSPNew, $rqAll['tenSp']);

            // insert danh mục sản phẩm
            for ($i = 0; $i < $rqAll['slDm']; $i++) {
                $idDm = $rqAll["idDm$i"];
                $objModelProduct->insertCategoryProduct($idSPNew, $idDm);
            }

            // insert loại sản phẩm
            $mainImageName = '';
            if(isset($mainImage)) {
                $mainImageName = $mainImage->getClientOriginalName();
            }
            $objModelProduct->insertProductType($rqAll['tenLoaiSp'], $mainImageName,  $rqAll['moTa'],  $rqAll['giaSp'], $idSPNew, $rqAll['soLuong']);


            // insert ảnh phụ danh mục

            $subImageNames = [];
            foreach ($subImages as $subImage) {
                $subImageName = $subImage->getClientOriginalName();
                $subImageNames[] = $subImageName;
            }
            foreach ($subImageNames as $subImg) {
                $objModelProduct->insertProductImg($subImg, $idSPNew);
            }

            // upload ảnh vào public/upload
            $mainImage->storeAs('upload', $mainImageName, 'public');
            foreach ($subImages as $index => $subImage) {
                $subImage->storeAs('upload', $subImageNames[$index], 'public');
            }

            // setcookie
            if (!Cookie::has('newProIdInDay')) {
                $expiration = strtotime('tomorrow');
                Cookie::queue('newProIdInDay', $idSPNew, $expiration);
            }

            return redirect()->route('admin.product.add');
        } catch (\Exception $e) {
            // Xử lý ngoại lệ (ghi log hoặc trả về một phản hồi lỗi)
            return response()->json(['success' => false, 'message' => 'Lỗi khi thêm sản phẩm']);
        }
    }

    public function handleEditProduct(Request $request)
    {
        $objModelProduct = new ProductsModel();
        $allData = $request->all();


        for ($i = 0; $i < $allData['editTable']; $i++) {
            $idSp = $allData["idSp$i"];
            $idLoaiSp = $allData["idLoaiSp$i"];

            // Trường hợp update nhiều
            $idDms = $allData["idDm$i"];
            $tenSp = $allData["tenSp$i"];
            $moTa = $allData["moTa$i"];

            $mainImageName = '';
            $mainImg = '';
            if (isset($allData["main-img$i"])) {
                $mainImg = $allData["main-img$i"];
                $mainImageName = $mainImg->getClientOriginalName();
                // upload ảnh vào public/upload
                $mainImg->storeAs('upload', $mainImageName, 'public');
            }

            $soLuong = $allData["soLuong$i"];
            $tenLoaiSp = $allData["tenLoaiSp$i"];
            $giaSp = $allData["giaSp$i"];

            // update sản phẩm 
            $objModelProduct->updateProduct($idSp, $tenSp);

            // update danh mục
            $idSpDms = [];
            $dataUpdateCuC = $objModelProduct->getCategoryProductCategory($idSp);
            foreach ($dataUpdateCuC as $dt) {
                $idSpDms[] = $dt['idSpDm'];
            }

            $coutListIdSpDms = count($idSpDms);
            $checkDl = 0;

            foreach ($idDms as $index => $idDm) {
                if ($index < $coutListIdSpDms) {
                    $objModelProduct->updateCategoryProduct($idSpDms[$index], $idDm);
                } else {
                    $objModelProduct->insertCategoryProduct($idSp, $idDm);
                }
                $checkDl += 1;
            }

            for ($j = $checkDl; $j < $coutListIdSpDms; $j++) {
                $objModelProduct->deleteCuC($idSpDms[$j]);
            }

            // update loai san pham
            $objModelProduct->updateProductType($tenLoaiSp, $mainImageName, $moTa, $giaSp, $idLoaiSp, $soLuong);

            // update ảnh con
            // Trường hợp update nhiều
            $subImgs = []; // Sửa thành mảng

            // 

            $dataProImg = $objModelProduct->getDataProImgId($idSp);
            $listIdPrImg = [];
            foreach ($dataProImg as $dtPI) {
                $listIdPrImg[] = $dtPI['idImgs'];
            }
            // var_dump($listIdPrImg);
            $coutListIdPrImg = count($listIdPrImg);
            $checkDlimgs = 0;

            if (isset($allData["sub-img$i"])) {
                $subImgs = $allData["sub-img$i"];

                foreach ($subImgs as $index => $subImg) {

                    $subImgname = $subImg->getClientOriginalName();
                    if ($index < $coutListIdPrImg) {
                        $objModelProduct->updateProductImgIdImg($listIdPrImg[$index], $subImgname);
                    } else {
                        $objModelProduct->insertProductImg($subImgname, $idSp);
                    }
                    $checkDlimgs += 1;

                    $subImg->storeAs('upload', $subImgname, 'public');
                }
                for ($i = $checkDlimgs; $i < $coutListIdPrImg; $i++) {
                    $objModelProduct->deleteImg($listIdPrImg[$i]);
                }
            }
        }

        return redirect()->route('admin.product.list');
    }

    public function handleRemoveProduct(Request $request)
    {
        $objModelProduct = new ProductsModel();


        $listIdSpString = $request->input('list_idSp');
        $listIdSp = json_decode($listIdSpString, true);

        if (gettype($listIdSp) != 'array') {
            $objModelProduct->removeProduct($listIdSp);
        } else {

            foreach ($listIdSp as $idSp) {
                $objModelProduct->removeProduct($idSp);
            }

        }

        return redirect(route('admin.product.list'));

    }

    public function handleRestoreProduct(Request $request)
    {
        $objModelProduct = new ProductsModel();

        $gAll = $request->all();
        $idSp = $gAll['idSp'];
        $objModelProduct->restoreProduct($idSp);

        return redirect(route('admin.product.trash'));
    }

    public function handleAddProductType(Request $request) {
        $objPr = new ProductsModel();

        $allData = $request->all();
        $inputImg = $request->file('img');

        $img = $inputImg->getClientOriginalName();
        
        $objPr->insertProductType($allData['tenLoaiSp'],$img ,$allData['moTa'],$allData['giaSp'],$allData['idSp'],$allData['soLuong']);

        $inputImg->storeAs('upload', $img, 'public');


        return redirect(route('admin.product.list'));
    }

    public function handleDeleleProduct()
    {

    }




}
