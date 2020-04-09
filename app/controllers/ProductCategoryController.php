<?php

class ProductCategoryController extends Controller {

    protected $productCategoryModel;

    public function __construct()
    {
        $this->productCategoryModel = $this->model('ProductCategory');
    }

    public function index()
    {
        $categories = $this->productCategoryModel->getAll();
        $data = [
            'categories' =>$categories,
        ];
        return $this->view('admin/products_categories/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Init data
            $data = [
                'name' => test_input($_POST['name']),
                'slug' => test_input($_POST['slug']),
                'name_err' => '',
            ];

            // Validated name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter category name';
            }

            if (empty($data['name_err'])) {
                if ($this->productCategoryModel->add($data['name'], $data['slug'])) {
                    flash('message', 'Create new category success');
                    redirect('productCategory/index');
                } else {
                    exit('Something went wrong');
                }
                
            } else {
                return $this->view('admin/products_categories/add', $data);
            }
        } else {
            $data = [
                'name' => '',
                'name_err' => '',
            ];
            return $this->view('admin/products_categories/add', $data);
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Init data
            $data = [
                'id' => $id,
                'name' => test_input($_POST['name']),
                'slug' => test_input($_POST['slug']),
                'name_err' => '',
            ];

            // Validated name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter category name';
            }

            if (empty($data['name_err'])) {
                if ($this->productCategoryModel->update($id, $data['name'], $data['slug'])) {
                    flash('message', 'Category edit success');
                    redirect('productCategory/index');
                } else {
                    exit('Something went wrong');
                }
                
            } else {
                return $this->view('admin/products_categories/edit', $data);
            }
        } else {
            $category = $this->productCategoryModel->findCategoryById($id);
            $data = [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'name_err' => '',
            ];
            return $this->view('admin/products_categories/edit', $data);
        }
        
    }

    public function delete($id)
    {
        if ($this->productCategoryModel->delete($id)) {
            flash('message', 'Category is deleted');
            redirect('productCategory/index');
        } else {
            exit('Something went wrong');
        }
    }


}