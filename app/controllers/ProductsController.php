<?php

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->productModel = $this->model('Product');
        $this->categoryProductModel = $this->model('CategoryProduct');
        $this->photoModel = $this->model('Photo');
    }

    public function index()
    {
        // Pagination

        // Get current page or set default
        if (isset($_GET['cur_page']) && is_numeric($_GET['cur_page'])) {
            $cur_page = (int) $_GET['cur_page'];
        } else {    
            $cur_page = 1;
        }
        
        // Number of rows to show per page
        $result_per_page = LIMIT_PRODUCTS;

        $skip = ($cur_page - 1)*$result_per_page;

        // Total pages
        $total = $this->productModel->getRows();
        $num_pages = ceil($total/$result_per_page);


        $products = $this->productModel->pagination($skip, $result_per_page);
        $categoryAll = $this->categoryProductModel->getAll();

        $categories = [];
        $photos = [];

        foreach ($products as $product) {

            $categories[$product->id] = $this->categoryProductModel->getCategory($product->category_id);

            $photos[$product->id] = $this->photoModel->getPhoto($product->photo_id);

        }
        
        $data = [
            'products' => $products,
            'categories' => $categories,
            'photos' => $photos,
            'category_all' => $categoryAll,
            'num_pages' => $num_pages,
            'cur_page' => $cur_page,
        ];
        
        return $this->view('admin/products/index', $data);
    }

    public function add()
    {
        $categories = $this->categoryProductModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize Post data
            // $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'slug' => trim($_POST['slug']),
                'price' => trim($_POST['price']),
                'category' => trim($_POST['category']),
                'description' => trim($_POST['description']),
                'photo_id' => '',
                'file' => $_FILES['file'],
                'name_err' => '',
                'price_err' => '',
                'file_err' => '',
                'description_err' => '',
                'categories' => $categories,
            ];

            if (empty($data['name'])) {
                $data['name_err'] = 'Vui lòng điền tên sản phẩm';
            }

            if (empty($data['price'])) {
                $data['price_err'] = 'Vui lòng nhập giá sản phẩm';
            }

            if (empty($data['file']['name'])) {
                $data['file_err'] = 'Vui lòng nhập ảnh miêu tả sản phẩm';
            }

            if (empty($data['description'])) {
                $data['description_err'] = 'Vui lòng điền thông tin sản phẩm';
            }

            if (empty($data['name_err']) && empty($data['price_err']) && empty($data['description_err']) && empty($data['file_err'])) {

                // specifies the directory where the file is going to be placed
                $target_dir = PRODUCT_FOLDER;

                // specifies the path of the file to be uploaded
                $target_file = $target_dir . basename($_FILES["file"]["name"]);

                // Max size file
                $maxSize = MAX_SIZE;
                $uploadOk = 1;

                // holds the file extension of the file (in lower case)
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if image file is actual image or fake image
                if ($check = getimagesize($_FILES['file']['tmp_name'])) {
                } else {

                    $data['file_err'] = 'File is not an image';
                    $uploadOK = 0;
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    $data['file_err'] = 'Sorry, file already exists';
                    $uploadOK = 0;
                }

                // Check file size
                if ($_FILES['file']['size'] > $maxSize) {
                    $data['file_err'] = 'Sorry, this file is too large';
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif') {
                    $data['file_err'] = 'Sorry! Only JPG, GIF, JPEG, GIF files are allowed';
                    $uploadOk = 0;
                }

                if ($uploadOk == 0) {
                    return $this->view('admin/products/add', $data);
                } else {

                    // Move photo to dir
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {

                        // Insert photo tables, update users table
                        if ($this->photoModel->upload($_FILES['file']['name'])) {

                            // Insert products table
                            $data['photo_id'] = $this->photoModel->getMaxId();

                            if ($this->productModel->add($data)) {

                                // Flash message
                                flash('message', 'Tạo sản phẩm mới thành công');

                                redirect('products/index', $data);
                            } else {
                                exit('Some thing went wrong');
                            }
                        } else {
                            exit('something went wrong');
                        }
                    } else {
                        exit('Something went wrong');
                    }
                }
            } else {
                return $this->view('admin/products/add', $data);
            }
        } else {

            $data = [
                'name' => '',
                'slug' => '',
                'price' => '',
                'description' => '',
                'name_err' => '',
                'price_err' => '',
                'description_err' => '',
                'categories' => $categories,
            ];
            return $this->view('admin/products/add', $data);
        }
    }

    public function edit($id)
    {
        $categories = $this->categoryProductModel->getAll();
        $product = $this->productModel->getById($id);
        $category = $this->productModel->getCategory($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize Post data
            // $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'slug' => trim($_POST['slug']),
                'price' => trim($_POST['price']),
                'category' => trim($_POST['category']),
                'description' => trim($_POST['description']),
                'photo_id' => '',
                'file' => $_FILES['file'],
                'name_err' => '',
                'price_err' => '',
                'file_err' => '',
                'description_err' => '',
                'categories' => $categories,
            ];

            if (empty($data['name'])) {
                $data['name_err'] = 'Vui lòng điền tên sản phẩm';
            }

            if (empty($data['price'])) {
                $data['price_err'] = 'Vui lòng nhập giá sản phẩm';
            }

            if (empty($data['description'])) {
                $data['description_err'] = 'Vui lòng điền thông tin sản phẩm';
            }

            if (empty($data['name_err']) && empty($data['price_err']) && empty($data['description_err']) && empty($data['file_err'])) {

                if (!empty($_FILES['file']['name'])) {

                    // specifies the directory where the file is going to be placed
                    $target_dir = PRODUCT_FOLDER;

                    // specifies the path of the file to be uploaded
                    $target_file = $target_dir . basename($_FILES["file"]["name"]);

                    // Max size file
                    $maxSize = MAX_SIZE;
                    $uploadOk = 1;

                    // holds the file extension of the file (in lower case)
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // Check if image file is actual image or fake image
                    if ($check = getimagesize($_FILES['file']['tmp_name'])) {
                    } else {

                        $data['file_err'] = 'File is not an image';
                        $uploadOK = 0;
                    }

                    // Check if file already exists
                    if (file_exists($target_file)) {
                        $data['file_err'] = 'Sorry, file already exists';
                        $uploadOK = 0;
                    }

                    // Check file size
                    if ($_FILES['file']['size'] > $maxSize) {
                        $data['file_err'] = 'Sorry, this file is too large';
                        $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif') {
                        $data['file_err'] = 'Sorry! Only JPG, GIF, JPEG, GIF files are allowed';
                        $uploadOk = 0;
                    }

                    if ($uploadOk == 0) {
                        return $this->view('admin/products/edit', $data);
                    } else {

                        // Move photo to dir
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {

                            // Insert photo tables, update users table
                            if ($this->photoModel->upload($_FILES['file']['name'])) {

                                // Insert products table
                                $data['photo_id'] = $this->photoModel->getMaxId();

                                if ($this->productModel->update($id, $data)) {

                                    // Flash message
                                    flash('message', 'Cập nhật sản phẩm thành công');

                                    redirect('products/index');
                                } else {
                                    exit('Some thing went wrong');
                                }
                            } else {
                                exit('something went wrong');
                            }
                        } else {
                            exit('Something went wrong');
                        }
                    }
                } else {
                    
                    $data['photo_id'] = $product->photo_id;

                    if ($this->productModel->update($id, $data)) {

                        // Flash message
                        flash('message', 'Cập nhật sản phẩm thành công');

                        redirect('products/index', $data);
                    } else {
                        exit('Some thing went wrong');
                    }
                }
            } else {
                return $this->view('admin/products/add', $data);
            }
        } else {

            $data = [
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'description' => $product->description,
                'name_err' => '',
                'price_err' => '',
                'description_err' => '',
                'categories' => $categories,
                'id' => $product->id,
                'category' => $category,
            ];

            return $this->view('admin/products/edit', $data);
        }
    }

    public function active($id)
    {
        if ($this->productModel->active($id)) {
            redirect('products/index');
        } else {
            exit('Something went wrong');
        }
    }

    public function inactive($id)
    {
        if ($this->productModel->inactive($id)) {
            redirect('products/index');
        } else {
            exit('Something went wrong');
        }
    }

    public function delete($id)
    {
        if ($this->productModel->delete($id)) {
            flash('message', 'Xóa sản phẩm thành công!');
            redirect('products/index');
        } else {
            exit('Something went wrong');
        }
    }

    public function getByCategory($id)
    {
        $products = $this->productModel->getAllOfCate($id);

        $categoryAll = $this->categoryProductModel->getAll();

        $categories = [];
        $photos = [];

        foreach ($products as $product) {

            $categories[$product->id] = $this->categoryProductModel->getCategory($product->category_id);

            $photos[$product->id] = $this->photoModel->getPhoto($product->photo_id);

        }
        
        $data = [
            'products' => $products,
            'categories' => $categories,
            'photos' => $photos,
            'category_all' => $categoryAll,
        ];
        return $this->view('admin/products/index', $data);
    }
}
