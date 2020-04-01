<?php

class UsersController extends Controller
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->roleModel = $this->model('Role');
        $this->photoModel = $this->model('Photo');
    }

    public function index()
    {
        $users = $this->userModel->getAllUser();
        $all_rule_user = $this->roleModel->getAllRoleUser();

        $data = [
            'users' => $users,
            'role_user' => $all_rule_user,
        ];
        return $this->view('admin/users/index', $data);
    }

    public function register()
    {
        // Check for Post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form

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
            ];

            // Validate Name
            $name_errors = $this->validateName($data['first_name'], $data['last_name']);

            // Validate Email
            $email_errors = $this->validateEmail($data['email']);

            // Validate Password
            $pass_errors = $this->validatePassword($data['password'], $data['confirm_password']);
            $data = array_merge($data, $name_errors ,$email_errors, $pass_errors);


            // Make sure errors are empty
            if (empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {

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
        redirect('users/profile/' . $_SESSION['user_id']);
    }

    public function add()
    {
        $roles = $this->roleModel->getAllRoles();

        // Check for Post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
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
            ];

            // Validate Name
            $name_errors = $this->validateName($data['first_name'], $data['last_name']);

            // Validate Email
            $email_errors = $this->validateEmail($data['email']);

            // Validate Password
            $pass_errors = $this->validatePassword($data['password'], $data['confirm_password']);
            $data = array_merge($data, $name_errors ,$email_errors, $pass_errors);
            

            // Make sure errors are empty
            if (empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {

                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if (isset($_POST['role'])) {
                    $data['role'] = $_POST['role'];
                }

                // Register User
                if ($this->userModel->add($data)) {
                    flash('message', 'Tạo người dùng thành công!'); 
                    redirect('users/index');
                    
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
        $role = $this->roleModel->getRoleOfUser($id);
        $roles = $this->roleModel->getAllRoles();

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
                $name_errors = $this->validateName($data['first_name'], $data['last_name']);
                $data = array_merge($data, $name_errors);

                if (empty($data['first_name_err']) && empty($data['last_name_err'])) {

                    if ($this->userModel->update($data)) {
                        flash('message', 'Cập nhật người dùng thành công');
                        redirect('users/index');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    $data['user'] = $user;
                    $data['role'] = $role;
                    $data['roles'] = $roles;
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
                $name_errors = $this->validateName($data['first_name'], $data['last_name']);

                // Validate Password
                $pass_errors = $this->validatePassword($data['password'], $data['confirm_password']);

                $data = array_merge($data, $name_errors, $pass_errors);

                // Make sure errors are empty
                if (empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {

                    // Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Register User
                    if ($this->userModel->update($data)) {
                        flash('message', ' Cập nhật thông tin thành công!');
                        redirect('users/index');
                        
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    // Load view with errors
                    $data['user'] = $user;
                    $data['role'] = $role;
                    $data['roles'] = $roles;
                    $this->view('admin/users/edit', $data);
                }
            }
        }
    }

    public function delete($id)
    {
        if ($this->userModel->delete($id)) {
            flash('message', 'Xóa người dùng thành công');
            redirect('users/index');
        } else {
            exit('Something went wrong');
        }

        
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

    public function profileUpdate($id)
    {
        $user = $this->userModel->getUserById($id);
        $photo = $this->photoModel->getUserAvatar($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize Post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'first_name_err' => '',
                'last_name_err' => '',
                'id' => $id,
                'user' => $user,
            ];

            $errors = $this->validateName($data['first_name'], $data['last_name']);
            $data = array_merge($data, $errors);

            if (empty($data['first_name_err']) && empty($data['last_name_err'])) {

                // Update profile
                if ($this->userModel->updateProfile($id, $data['first_name'], $data['last_name'])) {
                    flash('message', 'Cập nhật người dùng thành công');
                    redirect('/admin/profile/'. $id);
                } else {
                    exit('Something went wrong');
                }
            } else {
                return $this->view('/admin/profile/edit', $data);
            }
        } else {
            $data = [
                'first_name_err' => '',
                'last_name_err' => '',
                'user' => $user,
                'photo' => '',
            ];

            if ($photo) {
                $data = [
                    'first_name_err' => '',
                    'last_name_err' => '',
                    'user' => $user,
                    'photo' => $photo->photoPath,
                ];
            }
            
            return $this->view('/admin/profile/edit', $data);            
        }
    }


    public function changePass($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize Post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //  init data
            $data = [
                'password' => $_POST['password'],
                'new_password' => $_POST['new_password'],
                'confirm_new_password' => $_POST['confirm_new_password'],
                'password_err' => '',
                'new_password_err' =>  '',
                'confirm_new_password_err' => '',
                'id' => $id,
            ];


            // Check password
            if (empty($data['password'])) {
                $data['password_err'] = 'Vui lòng nhập mật khẩu';
            } else {
                if (!$this->userModel->checkPass($id, $data['password'])) {
                    $data['password_err'] = 'Mật khẩu không đúng';
                } 
                ;
            }

            // Check new pass
            $errors = $this->validatePassword($data['new_password'], $data['confirm_new_password']);

            $data['new_password_err'] = $errors['password_err'];
            $data['confirm_new_password_err'] = $errors['confirm_password_err'];

            if (empty($data['password_err']) && empty($data['new_password_err']) && empty($data['confirm_new_pass_err'])) {

                // Hash password
                $data['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);

                // Update new password
                if ($this->userModel->updatePass($id, $data['new_password'])) {
                    flash('message','Cập nhật người dùng thành công');
                    redirect('/admin/profile/'. $id);
                }
            } else {
                $this->view('/admin/profile/change_pass', $data);
            }

        } else {
            $data = [
                'pass_err' => '',
                'new_pass_err' =>  '',
                'conf_new_pass_err' => '',
            ];
            return $this->view('admin/profile/change_pass', $data);
        }
    }


    public function validateName($first_name, $last_name)
    {
        $data = [
            $data['first_name_err'] = '',
            $data['last_name_err'] = '',
        ];
        if (empty($first_name)) {
            $data['first_name_err'] = 'Vui lòng nhập tên bạn';
        }

        if (empty($last_name)) {
            $data['last_name_err'] = 'Vui lòng nhập họ của bạn';
        }
        
        return $data;
    }

    public function validateEmail($email)
    {
        $data = [
            $data['emal_err'] = '',
        ];

        if (empty($email)) {
            $data['email_err'] = 'Vui lòng nhập địa chỉ email';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data['email_err'] = 'Địa chỉ email không hợp lệ';
        } else {
            // Check unique email
            if ($this->userModel->findUserByEmail($email)) {
                $data['email_err'] = 'Địa chỉ email này đã được dùng, vui lòng nhập địa chỉ email khác ';
            }
        }
        
        return $data;
    }

    public function validatePassword($pass, $confirm_pass)
    {
        $data = [
            'password_err' => '',
            'confirm_password_err' => '',
        ];

        // Validate Password
        if (empty($pass)) {
            $data['password_err'] = 'Vui lòng nhập mật khẩu';;
        } elseif (strlen($pass) < 6) {
            $data['password_err'] = 'Mật khẩu phải tối thiểu 6 ký tự';
        }

        // Validate confirm password
        if (empty($confirm_pass)) {
            $data['confirm_password_err'] = 'Vui lòng xác thực lại mật khẩu';
        } else {
            if ($pass !== $confirm_pass) {
                $data['confirm_password_err'] = 'Mật khẩu xác nhận không khớp, vui lòng nhập lại';
            }
        }

        return $data;
    }

    public function active($id)
    {
        if ($this->userModel->activeUser($id)) {
            redirect('users/index');
        } else {
            exit('Something went wrong');
        }
    }

    public function inactive($id)
    {
        if ($this->userModel->inactiveUser($id)) {
            redirect('users/index');
        } else {
            exit('Something went wrong');
        }
    }

}
