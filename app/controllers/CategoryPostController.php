<?php
class CategoryPostController extends Controller {

    protected $categoryPostModel;

    public function __construct()
    {
        $this->categoryPostModel = $this->model('CategoryPost');
    }

    public function index()
    {
        $categories = $this->categoryPostModel->getAll();
        $data = [
            'categories' =>$categories,
        ];
        return $this->view('admin/categories_posts/index', $data);
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
                if ($this->categoryPostModel->add($data['name'], $data['slug'])) {
                    flash('message', 'Tạo thể loaị mới thành công');
                    redirect('categoryPost/index');
                } else {
                    exit('Something went wrong');
                }
                
            } else {
                return $this->view('admin/categories_posts/add', $data);
            }
        } else {
            $data = [
                'name' => '',
                'name_err' => '',
            ];
            return $this->view('admin/categories_posts/add', $data);
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
                if ($this->categoryPostModel->update($id, $data['name'], $data['slug'])) {
                    flash('message', 'Tạo thể loaị mới thành công');
                    redirect('categoryPost/index');
                } else {
                    exit('Something went wrong');
                }
                
            } else {
                return $this->view('admin/categories_posts/add', $data);
            }
        } else {
            $category = $this->categoryPostModel->findCategoryById($id);
            $data = [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'name_err' => '',
            ];
            return $this->view('admin/categories_posts/edit', $data);
        }
        
    }

    public function delete($id)
    {
        if ($this->categoryPostModel->delete($id)) {
            flash('message', 'Xóa thể loại thành công');
            redirect('categoryPost/index');
        } else {
            exit('Something went wrong');
        }
    }

    public function active($id)
    {
        if ($this->categoryPostModel->active($id)) {
            redirect('categoryPost/index');
        } else {
            exit('Something went wrong');
        }
    }

    public function inactive($id)
    {
        if ($this->categoryPostModel->inactive($id)) {
            redirect('categoryPost/index');
        } else {
            exit('Something went wrong');
        }
    }
}