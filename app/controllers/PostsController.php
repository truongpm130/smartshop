<?php 

class PostsController extends Controller {

    protected $postModel;
    private $categoryPostModel;
    
    public function __construct()
    {
        $this->postModel = $this->model('Post');
        $this->categoryPostModel = $this->model('CategoryPost');
    }

    public function index()
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

    public function add()
    {
        $categories = $this->categoryPostModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // Sanitize Post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'title' => trim($_POST['title']),
                'slug' => trim($_POST['slug']),
                'category' => trim($_POST['category']),
                'content' => trim($_POST['content']),
                'title_err' => '',
                'content_err' => '',
                'categories' => $categories,
                'user_id' => $_SESSION['user_id'],
            ];

            if (empty($data['title'])) {
                $data['title_err'] = 'Tiêu đề không được để trống';
            }
            
            if (empty($data['content'])) {
                $data['content_err'] = 'Nội dung không được để trống';
            }

            if (empty($data['title_err']) && empty($data['content_err'])) {
                if ($this->postModel->add($data['title'], $data['slug'], $data['category'], $data['content'], $data['user_id'])) {
                    flash('message', 'Thêm bài viết thành công');
                    redirect('posts/index');
                }
            } else {
                return $this->view('admin/posts/add', $data);
            }

        } else {

            $data = [
                'title' => '',
                'slug' => '',
                'content' => '',
                'title_err' => '',
                'content_err' => '',
                'categories' => $categories,
                'user_id' => $_SESSION['user_id'],
            ];
            return $this->view('admin/posts/add', $data);
        }
        
    }

    public function edit($id)
    {
        $categories = $this->categoryPostModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // Sanitize Post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'title' => trim($_POST['title']),
                'slug' => trim($_POST['slug']),
                'category' => trim($_POST['category']),
                'content' => trim($_POST['content']),
                'title_err' => '',
                'content_err' => '',
                'categories' => $categories,
                'user_id' => $_SESSION['user_id'],
            ];

            if (empty($data['title'])) {
                $data['title_err'] = 'Tiêu đề không được để trống';
            }
            
            if (empty($data['content'])) {
                $data['content_err'] = 'Nội dung không được để trống';
            }

            if (empty($data['title_err']) && empty($data['content_err'])) {
                if ($this->postModel->update($id, $data['title'], $data['slug'], $data['category'], $data['content'], $data['user_id'])) {
                    flash('message', 'Cập nhật bài viết thành công');
                    redirect('posts/index');
                }
            } else {
                return $this->view('admin/posts/add', $data);
            }
        } else {
            $post = $this->postModel->getById($id);
            $category = $this->postModel->getCategoryOfPost($id);

            $data = [
                'title' => $post->title,
                'slug' => $post->slug,
                'category' => $post->category_id,
                'content' => $post->content,
                'id' => $post->id,
                'categories' => $categories,
                'category_post' => $category,
            ];
            return $this->view('admin/posts/edit', $data);
        }
        
    }

    public function delete($id)
    {
        if ($this->postModel->delete($id)) {
            flash('message', 'Xóa bài viết thành công!');
            redirect('posts/index');
        } else {
            exit('Something went wrong');
        }
    }

    public function active($id)
    {
        if ($this->postModel->active($id)) {
            redirect('posts/index');
        } else {
            exit('Something went wrong');
        }
    }

    public function inactive($id)
    {
        if ($this->postModel->inactive($id)) {
            redirect('posts/index');
        } else {
            exit('Something went wrong');
        }
    }
}