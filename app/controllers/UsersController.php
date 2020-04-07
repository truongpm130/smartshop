<?php

class UsersController extends Controller
{

    private $userModel;
    protected $registerMsg = [];

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

            // Init data
            $data = [
                'first_name' => test_input($_POST['first_name']),
                'last_name' => test_input($_POST['last_name']),
                'email' => test_input($_POST['email']),
                'password' => test_input($_POST['password']),
                'confirm_password' => test_input($_POST['confirm_password']),
                'gender' => $_POST['gender'],
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
            ];

            // Validate Register Input
            $result = $this->validateRegisterInput($data);

            $data = array_merge($data, $this->registerMsg);


            // Make sure errors are empty
            if ($result) {

                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register User
                if ($this->userModel->register($data)) {
                    flash('message', 'Register success!');
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

            // Init data
            $data = [
                'email' => test_input($_POST['email']),
                'password' => test_input($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            $validate = new Validate();

            // Validate email
            $checkEmail = $validate->validateEmail($data['email']);
            

            // Validate password
            $checkPass = $validate->validatePass($data['password']);

            $msg = $validate->getMsg();
            $data = array_merge($data, $msg);

            if ($checkEmail && $checkPass) {

                // Check and set logged user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Email or password is not correct';
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

            // Init data
            $data = [
                'first_name' => test_input($_POST['first_name']),
                'last_name' => test_input($_POST['last_name']),
                'email' => test_input($_POST['email']),
                'password' => test_input($_POST['password']),
                'confirm_password' => test_input($_POST['confirm_password']),
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
            ];

            // Validate Register Input
            // Validate Register Input
            $result = $this->ValidateRegisterInput($data);

            $data = array_merge($data, $this->registerMsg);


            // Make sure errors are empty
            if ($result) {

                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if (isset($_POST['role'])) {
                    $data['role'] = $_POST['role'];
                }

                // Register User
                if ($this->userModel->add($data)) {
                    flash('message', 'Add user success');
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

    public function ValidateRegisterInput($data)
    {
        // Validate Register Input   
        $validate = new Validate();

        // Validate name
        $validateFirstName = $validate->validateFirstName($data['first_name']);
        $validateLastName = $validate->validateLastName($data['last_name']);

        // Validate Email
        $validateEmail = $validate->validateEmail($data['email']);

        if ($this->userModel->findUserByEmail($data['email'])) {
            $emailError = 'This email has been taken, please choose other email address';
            $validateEmail = false;
        }

        // Validate Password
        $validatePass = $validate->validatePass($data['password']);
        $validateConfPass = $validate->validateConfPass($data['password'], $data['confirm_password']);

        
        $msg = $validate->getMsg();
        if (!empty($emailError)) {
            $msg['email_err'] = $emailError;
        }
        $this->registerMsg = $msg;

        // Make sure errors are empty
        if ($validateFirstName && $validateLastName && $validateEmail && $validatePass && $validateConfPass) {
            return true;
        } else {
            return false;
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

            if (empty($_POST['password']) && empty($_POST['confirm_password'])) {

                // Init data
                $data = [
                    'first_name' => test_input($_POST['first_name']),
                    'last_name' => test_input($_POST['last_name']),
                    'password' => $user->password,
                    'first_name_err' => '',
                    'last_name_err' => '',
                    'id' => $user->id,
                ];

                if ($_POST['role']) {
                    $data['role'] = $_POST['role'];
                }

                // Validate Name
                $validate = new Validate();

                $checkfName = $validate->validateFirstName($data['first_name']);
                $checklName = $validate->validateLastName($data['last_name']);
                
                $msg = $validate->getMsg();
                
                $data = array_merge($data, $msg);

                if ($checkfName && $checklName) {

                    if ($this->userModel->update($data)) {
                        flash('message', 'Update user success');
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
                    'first_name' => test_input($_POST['first_name']),
                    'last_name' => test_input($_POST['last_name']),
                    'password' => test_input($_POST['password']),
                    'confirm_password' => test_input($_POST['confirm_password']),
                    'first_name_err' => '',
                    'last_name_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                    'id' => $user->id,
                ];

                // Validate Name
                $validate = new Validate();

                $checkfName = $validate->validateFirstName($data['first_name']);
                $checklName = $validate->validateLastName($data['last_name']);

                // Validate Password
                $checkPass = $validate->validatePass($data['password']);
                $checkCfPass = $validate->validateConfPass($data['password'], $data['confirm_password']);
                
                $msg = $validate->getMsg();
                
                $data = array_merge($data, $msg);

                // Make sure errors are empty
                if ($checkfName && $checklName && $checkPass && $checkCfPass) {

                    // Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Register User
                    if ($this->userModel->update($data)) {
                        flash('message', ' Update user success!');
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
            flash('message', 'Delete user success');
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
            
            // Init data
            $data = [
                'first_name' => test_input($_POST['first_name']),
                'last_name' => test_input($_POST['last_name']),
                'first_name_err' => '',
                'last_name_err' => '',
                'id' => $id,
                'user' => $user,
            ];

            $validate = new Validate();

            $checkfName = $validate->validateFirstName($data['first_name']);
            $checklName = $validate->validateLastName($data['last_name']);

            $msg = $validate->getMsg();

            $data = array_merge($data, $msg);

            if ($checkfName && $checklName) {

                // Update profile
                if ($this->userModel->updateProfile($id, $data['first_name'], $data['last_name'])) {
                    flash('message', 'Update user success');
                    redirect('/users/profile/' . $id);
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

    public function updateAvatar($id)
    {

        if (isset($_POST['update_file'])) {

            // specifies the directory where the file is going to be placed
            $target_dir = AVATAR_USER_FOLDER;

            // Get user by id
            $user = $this->userModel->getUserById($id);
            // Check if users has avatar
            $photo = $this->photoModel->getUserAvatar($id);

            if ($photo) {
                $data = [
                    'user' => $user,
                    'photo' => $photo->photoPath,
                ];
            }

            $data['file_err'] = [];

            try {
                $loader = new ThumbnailUpload($target_dir, true);
                $loader->setThumbOptions($target_dir, MAX_SIZE);
                $loader->upload('file', 100000);
                $data['file_err'] = $loader->getMessages();
                $status = $loader->getStatus();
                $name = $loader->getName($_FILES['file']);

                if ($status) {
                    // Insert photo tables, update users table
                    if ($this->photoModel->updateUserAvatar($id, $name)) {

                        // Flash message
                        flash('message', 'Your avatar is updated!');

                        redirect('users/profile/' . $data['user']->id, $data);
                    } else {
                        exit('something went wrong');
                    }
                } else {
                    return $this->view('admin/profile/edit', $data);
                }
            } catch (Throwable $t) {
                echo $t->getMessage();
            }
        }
    }


    public function changePass($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //  init data
            $data = [
                'password' => test_input($_POST['password']),
                'new_password' => test_input($_POST['new_password']),
                'confirm_new_password' => test_input($_POST['confirm_new_password']),
                'password_err' => '',
                'new_password_err' =>  '',
                'confirm_new_password_err' => '',
                'id' => $id,
            ];


            // Check password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
                $checkOldPass = false;
            } else {
                if (!$this->userModel->checkPass($id, $data['password'])) {
                    $data['password_err'] = 'Password is not correct';
                    $checkOldPass = false;
                } else {
                    $checkOldPass = true;
                }
            }

            // Check new pass
            $validate = new Validate();
            $checkPass = $validate->validatePass($data['new_password']);
            $checkCofPass = $validate->validateConfPass($data['new_password'], $data['confirm_new_password']);

            $msg = $validate->getMsg();

            $data['new_password_err'] = $msg['password_err'];
            $data['confirm_new_password_err'] = $msg['confirm_password_err'];

            if ($checkOldPass && $checkPass && $checkCofPass) {

                // Hash password
                $data['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);

                // Update new password
                if ($this->userModel->updatePass($id, $data['new_password'])) {
                    flash('message', 'Update password success');
                    redirect('/users/profile/' . $id);
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
