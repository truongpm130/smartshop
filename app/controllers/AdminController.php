<?php

class AdminController extends Controller {

    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->roleModel = $this->model('Role');
        $this->photoModel = $this->model('Photo');
        $this->categoryPostModel = $this->model('CategoryPost');
        $this->postModel = $this->model('Post');
        $this->categoryProductModel = $this->model('CategoryProduct');
        $this->productModel = $this->model('Product');
    }

    public function members()
    {
        $users = $this->userModel->getAllUser();
        $all_rule_user = $this->roleModel->getAllRoleUser();

        $data = [
            'users' => $users,
            'role_user' => $all_rule_user,
        ];
        return $this->view('admin/users/index', $data);
    }

    public function profile($id)
    {
        $user = $this->userModel->getUserById($id);
        $data = [
            'user' => $user,
            'photo' => '',
        ];

        // Check if users has avatar
        $photo = $this->photoModel->getUserAvatar($id);

        if ($photo) {
            $data = [
                'user' => $user,
                'photo' => $photo->photoPath,
            ];
        }

        $_SESSION['avatar'] = $data['user']->photo_id ? URLROOT . '/images/users/' . $data['photo'] : AVATAR;

        return $this->view('admin/profile/index', $data);
    }


    public function posts()
    {
        $posts = $this->postModel->getAll();
        
        $authors = [];
        $categories = [];

        foreach ($posts as $post) {

            // Add key: post->id, value->author in array
            $row = $this->postModel->getAuthor($post->id);
            $author = $row->userLastName . ' ' . $row->userFirstName;
            $authors[$post->id] = $author;

            $category = $this->postModel->getCategory($post->id);
            $categories[$post->id] = $category->categoryName;
            
        }

        $data = [
            'posts' => $posts,
            'authors' => $authors,
            'categories' => $categories,
        ];
        return $this->view('admin/posts/index', $data);
    }

    public function categoriesPosts()
    {
        $categories = $this->categoryPostModel->getAll();
        $data = [
            'categories' =>$categories,
        ];
        return $this->view('admin/categories_posts/index', $data);
    }

    public function products()
    {
        $products = $this->productModel->getAll();

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
        ];
        return $this->view('admin/products/index', $data);
    }

    public function categoriesProducts()
    {
        $categories = $this->categoryProductModel->getAll();
        $data = [
            'categories' =>$categories,
        ];
        return $this->view('admin/products_categories/index', $data);
    }

}