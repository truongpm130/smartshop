<?php

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->productModel = $this->model('Product');
        $this->categoryProductModel = $this->model('ProductCategory');
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

        if ($products) {
            foreach ($products as $product) {

                $categories[$product->id] = $this->categoryProductModel->getCategory($product->category_id);

                $photos[$product->id] = $this->photoModel->getPhoto($product->photo_id);

            }
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

            $data = [
                'name' => test_input($_POST['name']),
                'slug' => test_input($_POST['slug']),
                'price' => test_input($_POST['price']),
                'category' => test_input($_POST['category']),
                'description' => test_input($_POST['description']),
                'photo_id' => '',
                'file' => $_FILES['file'],
                'name_err' => '',
                'price_err' => '',
                'file_err' => '',
                'description_err' => '',
                'categories' => $categories,
                'user_id' => $_SESSION['user_id'],
            ];

            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter product name';
            }

            if (empty($data['price'])) {
                $data['price_err'] = 'Please enter product price';
            }

            if (empty($data['description'])) {
                $data['description_err'] = 'Please enter product description';
            }

            if (empty($data['name_err']) && empty($data['price_err']) && empty($data['description_err'])) {
                $target_dir = PRODUCT_FOLDER;
                try {
                    $loader = new ThumbnailUpload($target_dir, true);
                    $loader->setThumbOptions($target_dir, MAX_SIZE);
                    $loader->upload('file', 1024*1000);
                    $data['file_err'] = $loader->getMessages();
                    $status = $loader->getStatus();
                    $name = $loader->getName($_FILES['file']);

                    if ($status) {
                        if ($this->photoModel->upload($name, 1, 'Products')) {
                            $photo_id = $this->photoModel->getMaxId();
                            $data['photo_id'] = $photo_id;
                            if ($this->productModel->add($data)) {
                                $product_id = $this->productModel->getMaxId();
                                if ($this->photoModel->updateProductId($photo_id, $product_id)) {
                                    flash('message', 'Create product success');
                                    redirect('/products/index');
                                } else {
                                    exit('Something went wrong');
                                }
                            } else {
                                exit('Something went wrong');
                            }
                        } else {
                            exit('Something went wrong');
                        }
                    } else {
                        return $this->view('admin/products/add', $data);
                    }
                } catch (Throwable $t) {
                    echo $t->getMessage();
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
        $product = $this->productModel->getById($id);

        if ($_SESSION['user_role'] == 'admin' || $_SESSION['user_id'] == $product->user_id) {
            $categories = $this->categoryProductModel->getAll();

            $category = $this->productModel->getCategory($id);

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $data = [
                    'name' => test_input($_POST['name']),
                    'slug' => test_input($_POST['slug']),
                    'price' => test_input($_POST['price']),
                    'category' => test_input($_POST['category']),
                    'description' => test_input($_POST['description']),
                    'photo_id' => $product->photo_id,
                    'file' => $_FILES['file'],
                    'name_err' => '',
                    'price_err' => '',
                    'file_err' => '',
                    'description_err' => '',
                    'categories' => $categories,
                    'user_id' => $_SESSION['user_id'],
                ];

                if (empty($data['name'])) {
                    $data['name_err'] = 'Please enter product name';
                }

                if (empty($data['price'])) {
                    $data['price_err'] = 'Please enter product price';
                }

                if (empty($data['description'])) {
                    $data['description_err'] = 'Please enter product description';
                }

                if (empty($data['name_err']) && empty($data['price_err']) && empty($data['description_err']) ) {

                    if (!empty($_FILES['file']['name'])) {

                        // specifies the directory where the file is going to be placed
                        $target_dir = PRODUCT_FOLDER;

                        try {
                            $loader = new ThumbnailUpload($target_dir, true);
                            $loader->setThumbOptions($target_dir, MAX_SIZE);
                            $loader->upload('file', 1024*1000);
                            $data['file_err'] = $loader->getMessages();
                            $status = $loader->getStatus();
                            $name = $loader->getName($_FILES['file']);

                            if ($status) {
                                // Delete old product image
                                $oldName = $this->productModel->getPhoto($id);
                                unlink(PRODUCT_FOLDER . $oldName);

                                // Update new path in DB
                                if ($this->photoModel->updatePath($product->photo_id, $name)) {
                                    if ($this->productModel->update($id, $data)) {

                                        flash('message', 'Update product success');
                                        redirect('/products/index');
                                    } else {
                                        exit('Something went wrong');
                                    }
                                } else {
                                    exit('Something went wrong');
                                }
                            } else {
                                return $this->view('admin/products/add', $data);
                            }
                        } catch (Throwable $t) {
                            echo $t->getMessage();
                        }

                    } else {

                        if ($this->productModel->update($id, $data)) {

                            // Flash message
                            flash('message', 'Update product success');

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
        } else {
            exit('Permission deny');
        }
    }

    public function active($id)
    {
        if ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'editor') {
            if ($this->productModel->active($id)) {
                redirect('products/index');
            } else {
                exit('Something went wrong');
            }
        } else {
            exit('Permission deny');
        }
    }

    public function inactive($id)
    {
        if ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'editor') {
            if ($this->productModel->inactive($id)) {
                redirect('products/index');
            } else {
                exit('Something went wrong');
            }
        } else {
            exit('Permission deny');
        }
    }

    public function delete($id)
    {
        $product = $this->productModel->getById($id);
        if ($_SESSION['user_role'] == 'admin' || $_SESSION['user_id'] == $product->user_id) {
            $photoName = $this->productModel->getPhoto($id);

            if ($this->productModel->delete($id)) {
                if ($this->photoModel->delete($product->photo_id)){
                    unlink(PRODUCT_FOLDER . $photoName);
                    flash('message', 'Product deleted!');
                    redirect('products/index');
                } else {
                    exit('Something went wrong');
                }
            } else {
                exit('Something went wrong');
            }
        } else {
            exit('Permission deny');
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

    public function search()
    {
        $input = $_POST['search'];
        $input = '%'. $input . '%';

        $products = $this->productModel->search($input);

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
            'num_pages' => '',
            'cur_page' => '',
        ];

        return $this->view('admin/products/index', $data);

    }

    public function priceDesc()
    {
        $products = $this->productModel->priceDesc();

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
            'num_pages' => '',
            'cur_page' => '',
        ];

        return $this->view('admin/products/index', $data);
    }

    public function priceAsc()
    {
        $products = $this->productModel->priceAsc();

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
            'num_pages' => '',
            'cur_page' => '',
        ];

        return $this->view('admin/products/index', $data);
    }

}
