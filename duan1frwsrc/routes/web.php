<?php

use Illuminate\Support\Facades\Route;

// nhúng các class controller
// controller user
use App\Http\Controllers\client\UserPageController;
// controller admin

use App\Http\Controllers\admin\AdminsController;

use App\Http\Controllers\admin\CategoryAdminController;
use App\Http\Controllers\admin\ProductAdminController;
use App\Http\Controllers\admin\OrdersController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// client routes

Route::get('/', [UserPageController::class, 'index'])->name('home');


Route::get('product_detail/{plug?}/{idSp?}/{idLoaiSp?}', 
    [UserPageController::class, 'getProductDetail'])->name('sanpham.productdetail');
Route::get('cart_product', 
    [UserPageController::class, 'showCartProduct'])->name('sanpham.cart');
Route::get('product_categories/{idDm}',[UserPageController::class,'showProductCategories'])->name('client.productCategories');
Route::get('handle_logout',[UserPageController::class,'handleLogout'])->name('client.logout');



// xử lí form 
Route::post('handle_add_cart', [UserPageController::class, 'handleAddCart'])->name('client.add.cart');
Route::get('handle_delete_cart', [UserPageController::class, 'handleDeleteCart'])->name('client.delete.cart');
Route::post('handle_insert_orders', [UserPageController::class, 'handleInsertOrders'])->name('client.insert.orders');
Route::post('handle_insert_comment',[UserPageController::class, 'handleInsertComment'])->name('client.insert.comment');
Route::post('handle_login', [UserPageController::class, 'handleLogin'])->name('client.login');
Route::post('handle_register', [UserPageController::class, 'handleRegister'])->name('client.register');






// // admin routes

// các tiền tố trên url sẽ chạy các route bên dưới tương ứng với các tên tiền tố 


// route::prefix thêm 1 tiền tố đằng trước các route con của nó
Route::middleware('auth.admin')->prefix("admin")->group(function (){ 

    // Phương thức get sẽ check url trên thanh search nếu trùng với ts 1 sẽ chạy vào route đó
    Route::get('/', [AdminsController::class, 'index']);

    Route::get('dashboard', [AdminsController::class, 'index'])->name('home.admin');

    // tiền tố product
    Route::prefix("products")->group(function () {

        Route::get('/',[CategoryAdminController::class, 'showAddCategory']);

        // category
        Route::prefix("category")->group(function (){

            // url
            Route::get('/',[CategoryAdminController::class, 'showAddCategory']);

            // tiền tố thêm
            Route::get('add_category',[CategoryAdminController::class, 'showAddCategory'])->name('admin.category.add');

            // tiền tố edit
            Route::get('edit_category',[CategoryAdminController::class, 'showEditCategory'])->name('admin.category.edit');

            // tiền tố trásh
            Route::get('trash_category',[CategoryAdminController::class, 'showTrashCategory'])->name('admin.category.trash');


            // form
            // submit có action tương ứng sẽ chạy vào đây
            //xử lí thêm danh mục
            Route::post('handle_add_category',[CategoryAdminController::class, 'handleAddCategory']);

            // xử lí sửa id danh mục cha
            Route::post('handle_Up_categoryLevel',[CategoryAdminController::class, 'handleUpdateLevelCategory']);

            // xử lí rename danh mục
            Route::post('handle_rename_category',[CategoryAdminController::class,'handleRenameCateogory']);
            
            // xử lí xóa mềm
            Route::post('handle_remove_category',[CategoryAdminController::class,'handleRemoveCategory']);

            // xử lí khôi phục xóa mềm
            Route::post('handle_restore_category',[CategoryAdminController::class,'handleRestoreCategory']);

        });

        // product
        Route::prefix("product")->group(function (){
            Route::get('/',[ProductAdminController::class, 'showListProduct']);
           
            // 
            // tiền tố list_products
            Route::get('list_products',[ProductAdminController::class, 'showListProduct'])->name('admin.product.list');

            // tiền tố add_products
            Route::get('add_product',[ProductAdminController::class, 'showAddProduct'])->name('admin.product.add');

            // tiền tố edit_products
            Route::get('edit_product',[ProductAdminController::class, 'showEditProduct'])->name('admin.product.edit');

            // tiền tố trash_products
            Route::get('trash_product',[ProductAdminController::class, 'showTrashProduct'])->name('admin.product.trash');


            // form xử lí form của sản phẩm ở đây
            Route::post('handle_add_product',[ProductAdminController::class, 'handleAddProduct']);
            Route::post('hanlde_remove_products',[ProductAdminController::class, 'handleRemoveProduct']);
            Route::post('hanlde_edit_products',[ProductAdminController::class, 'handleEditProduct']);
            Route::get('hanlde_remove_products',[ProductAdminController::class, 'handleRemoveProduct'])->name('admin.handle_remove');
            Route::post('handle_restore_product',[ProductAdminController::class, 'handleRestoreProduct']);
            Route::post('handle_add_typePro',[ProductAdminController::class, 'handleAddProductType']);
            
        });

        // xử lí tiền tố order 

        Route::prefix("orders")->group(function (){
            Route::get('order_list',[OrdersController::class, 'showListOrders'])->name('admin.order.list');
        });
 
    });
    

});