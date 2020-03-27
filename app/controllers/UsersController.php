<?php

class UsersController extends Controller
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->roleModel = $this->model('Role');
    }

    public function register()
    {
        // Check for Post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form

            // Validate input
            $data = $this->checkRegisterInput();

            
            // Make sure errors are empty
            if ($data['check']) {

                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register User
                if ($this->userModel->register($data)) {
                    flash('message', 'Bạn đã đăng ký thành công!'); 
                    redirect('users/login');
                    
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('pages/register', $data);
            }
        } else {

            // Init data
            $data = [
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',

                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Load view            
            $this->view('pages/register', $data);
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Vui lòng nhập địa chỉ email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Địa chỉ email không hợp lệ';
            }

            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Vui lòng nhập mật khẩu';
            }

            if (empty($data['email_err']) && empty($data['password_err'])) {
                
                // Check and set logged user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Email hoăc mật khẩu không chính xác';
                    $this->view('pages/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('pages/login', $data);
            }

        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            // Load view
            $this->view('pages/login', $data);
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        redirect('/users/login');
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->last_name . ' ' . $user->first_name;
        redirect('home');
    }

    public function add()
    {
        $roles = $this->roleModel->getAllRoles();

        // Check for Post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            
            // Validate input
            $data = $this->checkRegisterInput();

            // Make sure errors are empty
            if ($data['check']) {

                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if (isset($_POST['role'])) {
                    $data['role'] = $_POST['role'];
                }

                // Register User
                if ($this->userModel->add($data)) {
                    flash('message', 'Tạo người dùng thành công!'); 
                    redirect('admin/users/index');
                    
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $data['roles'] = $roles;
                $this->view('admin/users/add', $data);
            }
        } else {

            // Init data
            $data = [
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',

                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'roles' => $roles,
            ];

            // Load view            
            $this->view('admin/users/add', $data);
        }
    }

    public function edit($id)
    {
        $user = $this->userModel->getUserById($id);
        $role = $this->roleModel->getRoleOfUser($id);
        $roles = $this->roleModel->getAllRoles();

        $data = [
            'user' => $user,
            'role' => $role,
            'roles' => $roles,
        ];
        return $this->view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->getUserById($id);

        // Check for Post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
        
            // Sanitize Post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (empty($_POST['password']) && empty($_POST['confirm_password'])) {

                // Init data
                $data = [
                    'first_name' => trim($_POST['first_name']),
                    'last_name' => trim($_POST['last_name']),
                    'password' => $user->password,
                    'first_name_err' => '',
                    'last_name_err' => '',
                    'id' => $user->id,
                ];

                if ($_POST['role']) {
                    $data['role'] = $_POST['role'];
                }

                // Validate Name
                if (empty($data['first_name'])) {
                    $data['first_name_err'] = 'Vui lòng nhập tên bạn';
                }

                if (empty($data['last_name'])) {
                    $data['last_name_err'] = 'Vui lòng nhập họ của bạn';
                }

                if (empty($data['first_name_err']) && empty($data['last_name_err'])) {

                    if ($this->userModel->update($data)) {
                        flash('message', 'Cập nhật người dùng thành công');
                        redirect('admin/users/index');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    $data['user'] = $user;
                    return $this->view('admin/users/edit', $data);
                }

            } else {
                // Init data
                $data = [
                    'first_name' => trim($_POST['first_name']),
                    'last_name' => trim($_POST['last_name']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'first_name_err' => '',
                    'last_name_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                    'id' => $user->id,
                ];

                // Validate Name
                if (empty($data['first_name'])) {
                    $data['first_name_err'] = 'Vui lòng nhập tên bạn';
                }

                if (empty($data['last_name'])) {
                    $data['last_name_err'] = 'Vui lòng nhập họ của bạn';
                }

                // Validate Password
                if (strlen($data['password']) < 6) {
                    $data['password_err'] = 'Mật khẩu phải tối thiểu 6 ký tự';
                }

                if ($data['confirm_password'] !== $data['password']) {
                    $data['confirm_password_err'] = 'Mật khẩu xác nhận không khớp, vui lòng nhập lại';
                }

                // Make sure errors are empty
                if (empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {

                    // Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Register User
                    if ($this->userModel->update($data)) {
                        flash('message', ' Cập nhật thông tin thành công!');
                        redirect('admin/users/index');
                        
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    // Load view with errors
                    $this->view('admin/users/edit', $data);
                }
            }
        }
    }

    public function delete($id)
    {
        if ($this->userModel->delete($id)) {
            flash('message', 'Xóa người dùng thành công');
            redirect('admin/users/index');
        } else {
            exit('Something went wrong');
        }

        
    }

    public function checkRegisterInput()
    {
        // Sanitize Post data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'first_name' => trim($_POST['first_name']),
            'last_name' => trim($_POST['last_name']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'first_name_err' => '',
            'last_name_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => '',
            'check' => false,
        ];

        // Validate Name
        if (empty($data['first_name'])) {
            $data['first_name_err'] = 'Vui lòng nhập tên bạn';
        }

        if (empty($data['last_name'])) {
            $data['last_name_err'] = 'Vui lòng nhập họ của bạn';
        }

        // Validate Email
        if (empty($data['email'])) {
            $data['email_err'] = 'Vui lòng nhập địa chỉ email';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $data['email_err'] = 'Địa chỉ email không hợp lệ';
        } else {
            // Check unique email
            if ($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Địa chỉ email này đã được dùng, vui lòng nhập địa chỉ email khác ';
            }
        }

        // Validate Password
        if (empty($data['password'])) {
            $data['password_err'] = 'Vui lòng nhập mật khẩu';;
        } elseif (strlen($data['password']) < 6) {
            $data['password_err'] = 'Mật khẩu phải tối thiểu 6 ký tự';
        }

        // Validate confirm password
        if (empty($data['confirm_password'])) {
            $data['confirm_password_err'] = 'Vui lòng xác thực lại mật khẩu';
        } else {
            if ($data['confirm_password'] !== $data['password']) {
                $data['confirm_password_err'] = 'Mật khẩu xác nhận không khớp, vui lòng nhập lại';
            }
        }

        if (empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
            $data['check'] = true;
        } else {
            $data['check'] = false;
        }

        return $data;
    }

    public function active($id)
    {
        if ($this->userModel->activeUser($id)) {
            redirect('admin/users/index');
        } else {
            exit('Something went wrong');
        }
    }

    public function inactive($id)
    {
        if ($this->userModel->inactiveUser($id)) {
            redirect('admin/users/index');
        } else {
            exit('Something went wrong');
        }
    }



}
