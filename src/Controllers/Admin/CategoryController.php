<?php

namespace Dangson\XuongOop\Controllers\Admin;

use Dangson\XuongOop\Commons\Controller;
use Dangson\XuongOop\Commons\Helper;
use Dangson\XuongOop\Models\Category;
use Rakit\Validation\Validator;

class CategoryController extends Controller
{
    private Category $category;

    public function __construct()
    {
        $this->category = new Category();
    }

    public function index()
    {
        [$categories, $totalPage] = $this->category->paginate($_GET['page'] ?? 1);

        $this->renderViewAdmin("categories.index", [
            'categories' => $categories,
            'totalPage' => $totalPage,
            'page' => $_GET['page'] ?? 1,
        ]);
    }

    public function create()
    {
        $this->renderViewAdmin('categories.create', ['']);
    }

    public function store()
    {

        $validator = new Validator;

        $validation = $validator->make($_POST + $_FILES, [
            'name' => 'required'
        ]);

        $validation->validate();

        if ($validation->fails()) {
            $_SESSION['error'] = $validation->errors()->firstOfAll();

            header("Location: " . url('admin/categories/create'));
        } else {
            $data = [
                'name'   => $_POST['name']
            ];

            $this->category->insert($data);

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công';

            header('Location: ' . url('admin/categories'));
        }
    }

    public function show($id)
    {
        $category = $this->category->findByID($id);

        $this->renderViewAdmin('categories.show', [
            'category' =>  $category
        ]);
    }

    public function edit($id)
    {
        try {
            $category = $this->category->findByID($id);

            if (empty($category)) {
                throw new \Exception('Model not found');
            }
            $this->renderViewAdmin('categories.edit', [
                'category' =>  $category
            ]);
        } catch (\Throwable $th) {
            $th -> getMessage();
            die;
        }
    }

    public function update($id){

        $category = $this->category->findByID($id);

        $validator = new Validator;

        $validation = $validator->make($_POST + $_FILES, [
            'name' => 'required'
        ]);

        $validation->validate();

        if ($validation->fails()) {
            $_SESSION['error'] = $validation->errors()->firstOfAll();

            header("Location: " . url("admin/categories/{$category['id']}/edit"));
        } else {
            $data = [
                'name'   => $_POST['name']
            ];

            $this->category->update($id , $data);

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công';

            header("Location: " . url("admin/categories/{$category['id']}/edit"));
        }
    }

    public function delete($id){

        $this->category->delete($id);

        $_SESSION['status'] = true;
        $_SESSION['msg'] = 'Xóa thành công';

        header('Location: '. url('admin/categories'));
        exit;
    }
}
