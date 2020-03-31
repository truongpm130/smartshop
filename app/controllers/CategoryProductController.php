<?php

class CategoryProductController extends Controller {

    protected $categoryProductModel;

    public function __construct()
    {
        $this->categoryProductModel = $this->model('CategoryProduct');
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize Post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'name' => trim($_POST['name']),
                'slug' => trim($_POST['slug']),
                'name_err' => '',
            ];

            // Validated name
            if (empty($data['name'])) {
                $data['name_err'] = 'Vui lòng nhập thể loại';
            }

            if (empty($data['name_err'])) {
                if ($this->categoryProductModel->add($data['name'], $data['slug'])) {
                    flash('message', 'Tạo thể loaị mới thành công');
                    redirect('admin/categoriesProducts');
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
            
            // Sanitize Post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'slug' => trim($_POST['slug']),
                'name_err' => '',
            ];

            // Validated name
            if (empty($data['name'])) {
                $data['name_err'] = 'Vui lòng nhập thể loại';
            }

            if (empty($data['name_err'])) {
                if ($this->categoryProductModel->update($id, $data['name'], $data['slug'])) {
                    flash('message', 'Tạo thể loaị mới thành công');
                    redirect('admin/categoriesProducts');
                } else {
                    exit('Something went wrong');
                }
                
            } else {
                return $this->view('admin/products_categories/edit', $data);
            }
        } else {
            $category = $this->categoryProductModel->findCategoryById($id);
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
        if ($this->categoryProductModel->delete($id)) {
            flash('message', 'Xóa thể loại thành công');
            redirect('admin/categoriesProducts');
        } else {
            exit('Something went wrong');
        }
    }


}