<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\admin\CategoryModel;

class CategoryAdminController extends Controller
{

    protected $data;
    protected $objCategory;
    protected $redirect;
    
    public function __construct() {
        $this->objCategory = new CategoryModel();
    }

    // phương thức(GET) hiện thị các page danh mục
    public function showAddCategory() {
        
        $this->data = [
            'categories'=>$this->objCategory->handleCategorylevel(1)
        ];
        return view("admin/category/addCategory",$this->data);
    }

    public function showEditCategory() {
        
        $this->data = [
            'categories'=>$this->objCategory->handleCategorylevel(1),
            'categoriesAll' => $this->objCategory->getAllCategories(1)
        ];
        return view("admin/category/editCategory", $this->data);
    }

    public function showTrashCategory() {
        $this->data = [
            'categoriesRemove'=>$this->objCategory->handleCategorylevel(0),
        ];
        return view("admin/category/trashCategory",$this->data);
    }

    // phương thức(POST) xử lí các form danh mục

    public function handleAddCategory(Request $request) {
        $this->data = $request->all();
        
        $this->objCategory->insertCategory($this->data['tenDm'],htmlspecialchars($this->data['iconDm']),$this->data['idCtgrFt']);
        $this->redirect = route('admin.category.add');
        return redirect($this->redirect);
    }

    public function handleUpdateLevelCategory(Request $request) {
        $this->data = $request->all();
    
        $this->objCategory->updateLevelCategory($this->data['idDm'], $this->data['idDmcha']);
        $this->redirect = route('admin.category.edit');
        return redirect($this->redirect);
    }
    public function handleRenameCateogory(Request $request) {
        $this->data = $request->all();

        $this->objCategory->renameCateogory($this->data['idDm'],htmlspecialchars($this->data['iconDm']),$this->data['newname']);
        $this->redirect = route('admin.category.edit');
        return redirect($this->redirect);
    }
    public function handleRemoveCategory(Request $request) {
        $this->data = $request->all();
       
        $this->objCategory->removeCategory($this->data['idDm']);
        $this->redirect = route('admin.category.add');
        return redirect($this->redirect);
    }

    public function handleRestoreCategory(Request $request) {
        $this->data = $request->all();
        $this->objCategory->restoreCategory($this->data['idDm']);
        $this->redirect = route('admin.category.trash');
        return redirect($this->redirect);
    }

    public function handleDeleleCategory() {
        
    }

   
}
