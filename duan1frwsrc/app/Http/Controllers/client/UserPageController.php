<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use App\Models\client\ProductModel;
use App\Models\client\CategoryModel;
use App\Models\client\UserClientModel;
use Illuminate\Support\Facades\Session;
use App\Models\client\CommentModel;

class UserPageController extends Controller
{

    public function index()
    {
        $objPro = new ProductModel();
        $objCt = new CategoryModel();
        $data = [
            'allHomePr' => $objPro->getHomeProduct(),
            'allCate' => $objCt->getAllCategories(),
            'CateFt' => $objCt->getAllCategoriesFt(),
            'getLevelCate' => $objCt->handleCategorylevel(),
            'allHotPr' => $objPro->getHotProduct()
        ];
        return view('client/index', $data);
    }
    public function getProductDetail($plug = null, $idSp = null, $idLoaiSp = null)
    {
        $objPro = new ProductModel();
        $objCt = new CategoryModel();
        $objCm = new CommentModel();

        // update view hiện tại + thêm 1
        $objPro->updateViewTypePr($idLoaiSp,$objPro->getViewTypePr($idLoaiSp));
        $data = [
            'plug' => $plug,
            'idSp' => $idSp,
            'idLoaiSp' => $idLoaiSp,
            'CateFt' => $objCt->getAllCategoriesFt(),
            'getIdSp' => $objPro->getProducFltId($idSp, $idLoaiSp),
            'typeProduct' => $objPro->getTypeProduct($idSp),
            'view' => $objPro->getViewTypePr($idLoaiSp),
            'infoComment' => $objCm->getInfoCommentIdLoaiSp($idLoaiSp),

        ];
        return view('client/productDetail', $data);
    }

    public function showCartProduct()
    {
        $objPro = new ProductModel();
        $objCt = new CategoryModel();


        $cartSession = Session::get('cart', []);

        $listCart = [];
        foreach ($cartSession as $key => $sl) {
            $getCart = $objPro->getCartProduct($key);
            $cart = (array) $getCart;
            $cart['soLuong'] = $sl;
            $listCart[] = $cart;
        }
        $data = [
            'CateFt' => $objCt->getAllCategoriesFt(),
            'CartItems' => $listCart,
        ];
        return view('client/cartProduct', $data);
    }
    public function showProductCategories(Request $request, $idDm = null) {
        $objPro = new ProductModel();
        $objCt = new CategoryModel();
        $data = [
            'CateFt' => $objCt->getAllCategoriesFt(),
            'listProCtgries' => $objPro->getProductCategories($idDm),
            'tenDm' => $objCt->getNameCategory($idDm)
        ];
        return view('client/productCategories',$data);
    }
    public function handleAddCart(Request $request)
    {
        $idLoaiSp = $request->input('idLoaiSp');
        $soLuong = $request->input('soLuong');
        $plug = $request->input('plug');
        $idSp = $request->input('idSp');
        $idLoaiSp = $request->input('idLoaiSp');

        if (Session::has('cart')) {
            $cart = Session::get('cart');
        } else {
            $cart = [];
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng hay chưa
        if (array_key_exists($idLoaiSp, $cart)) {
            // Nếu đã có, cập nhật số lượng
            $cart[$idLoaiSp] += $soLuong;
        } else {
            // Nếu chưa có, thêm sản phẩm vào giỏ hàng với số lượng mới
            $cart[$idLoaiSp] = $soLuong;
        }

        Session::put('cart', $cart);

        return redirect(route('sanpham.productdetail', [
            'plug' => $plug,
            'idSp' => $idSp,
            'idLoaiSp' => $idLoaiSp,
        ]));

    }
    public function handleDeleteCart(Request $request)
    {
        $idLoaiSp = $request->input('idLoaiSp');

        $cart = session()->get('cart');

        if (array_key_exists($idLoaiSp, $cart)) {

            unset($cart[$idLoaiSp]);
            session()->put('cart', $cart);
        }
        return redirect(route('sanpham.cart'));
    }
    public function handleInsertOrders(Request $request)
    {
        $objPro = new ProductModel();
        $getAll = $request->all();

        $idDonHang = $objPro->getIdnewDonHang() + 1;


        // isert DH 
        $objPro->insertDonHang($idDonHang, $getAll['ten'], $getAll['sdt'], $getAll['email'], $getAll['diaChi']);

        var_dump($getAll);

        for ($i = 0; $i <= $getAll['soLuongCart']; $i++) {
            $idLoaiSp = $getAll["idLoaiSp$i"];
            $soLuongMua = $getAll["soLuongMua$i"];
            echo "check";
            $objPro->insertCtDonHang($soLuongMua, $idDonHang, $idLoaiSp);
        }
        return redirect(route('sanpham.home'));

    }
    public function handleInsertComment(Request $request) 
    {
        $getAll = $request->all();
        $objCm = new CommentModel();
        if(Cookie::has('infoLog')) {
            $idUser = json_decode(Cookie::get('infoLog'),true)['idUser'];
            $objCm->insertComment($getAll['ndComment'],$idUser, $getAll['idLoaiSp']);
            return redirect(route('sanpham.productdetail', [
                'plug' => $getAll['plug'],
                'idSp' => $getAll['idSp'],
                'idLoaiSp' => $getAll['idLoaiSp'],
            ]));
        } else {
            return redirect()->route('home');
        }
    }
    public function handleLogin(Request $request)
    {
        $allData = $request->all();
        $objUser = new UserClientModel();

        $dataGeted = $objUser->getDataUser($allData['email'], $allData['password']);



        if ($dataGeted) {

            $infoLogValue = json_encode([
                'idUser' => $dataGeted->idUser,
                'email' => $dataGeted->Email,
                'nickName' => $dataGeted->nickName,
                'vaiTro' => $dataGeted->vaiTro
            ]);

            Cookie::queue('infoLog', $infoLogValue, 60);

        }
        return redirect(route('home'));
    }

    public function handleLogout()
    {
        Cookie::queue('infoLog', null, -1);
        return redirect(route('home'));
    }
    public function handleRegister(Request $request) {
        $objUser = new UserClientModel();
        $getAll = $request->all();
        if($objUser->checkExistUser($getAll['Email'])) {
            echo "Email đã có người đăng ký";
        }else {
            $objUser->registerUser($getAll['Email'],$getAll['nickName'],$getAll['password']);
            return redirect()->route('home');
        }
    }

}
