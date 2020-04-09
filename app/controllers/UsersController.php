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
        $this->genderModel = $this->model('Gender');
    }

    public function index()
    {
        if ($_SESSION['user_role'] && $_SESSION['user_role'] == 'admin') {
            $users = $this->userModel->getAllUser();
            $all_rule_user = $this->roleModel->getAllRoleUser();

            $user_photo = [];

            foreach ($users as $user) {
                $avatar = $this->photoModel->getUserAvatar($user->id);
                if ($avatar) {
                    $user_photo[$user->id] = $avatar->photoPath;
                } else {
                    $user_photo[$user->id] = '';
                }

            }

            $data = [
                'users' => $users,
                'role_user' => $all_rule_user,
                'user_photo' => $user_photo,
            ];

            return $this->view('admin/users/index', $data);
        } else {
            exit('Permission deny');
        }

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
                'birthday' => $_POST['birthday'],
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

            $genders = $this->genderModel->getAll();

            // Init data
            $data = [
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'genders' => $genders,
                'gender' => '',
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
        // Empty session array
       $_SESSION = [];
       // Invalidate the session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-86400, '/');
        }
        // End session and redirect
        session_destroy();
        redirect('users/login');
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->last_name . ' ' . $user->first_name;
        $_SESSION['start'] = time();
        redirect('users/profile/' . $_SESSION['user_id']);
    }

    public function add()
    {
        if ($_SESSION['user_role'] && $_SESSION['user_role'] == 'admin') {
            $roles = $this->roleModel->getAllRoles();
            $genders = $this->genderModel->getAll();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Init data
                $data = [
                    'first_name' => test_input($_POST['first_name']),
                    'last_name' => test_input($_POST['last_name']),
                    'email' => test_input($_POST['email']),
                    'password' => test_input($_POST['password']),
                    'confirm_password' => test_input($_POST['confirm_password']),
                    'gender' => $_POST['gender'],
                    'genders' => $genders,
                    'birthday' => test_input($_POST['birthday']),
                    'role' => $_POST['role'],
                    'roles' => $roles,
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
                    if ($this->userModel->add($data)) {
                        flash('message', 'Add user success!');
                        redirect('users/members');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    // Load view with errors
                    $this->view('admin/users/add', $data);
                }
            } else {
                // Init data
                $data = [
                    'first_name' => '',
                    'last_name' => '',
                    'email' => '',
                    'genders' => $genders,
                    'gender' => '',
                    'roles' => $roles,
                    'password' => '',
                    'confirm_password' => '',

                    'first_name_err' => '',
                    'last_name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Load view
                $this->view('admin/users/add', $data);
            }
        } else {
            exit('Permission deny');
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
        if ($_SESSION['user_role'] && $_SESSION['user_role'] == 'admin') {
            $user = $this->userModel->getUserById($id);
            $role = $this->roleModel->getRoleOfUser($id);
            $roles = $this->roleModel->getAllRoles();

            $data = [
                'user' => $user,
                'role' => $role,
                'roles' => $roles,
            ];
            return $this->view('admin/users/edit', $data);
        } else {
            exit('Permission deny');
        }

    }

    public function update($id)
    {
        if ($_SESSION['user_role'] && $_SESSION['user_role'] == 'admin') {
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
        } else {
            exit('Permission deny');
        }
    }

    public function delete($id)
    {
        if ($_SESSION['user_role'] && $_SESSION['user_role'] == 'admin') {
            $user = $this->userModel->getUserById($id);
            $photo = $this->photoModel->getPhoto($user->photo_id);
            if ($user->photo_id) {
                $this->photoModel->delete($user->photo_id);
            }
            if ($this->userModel->delete($id)) {
                unlink(AVATAR_USER_FOLDER . $photo);
                flash('message', 'Delete user success');
                redirect('users/index');
            } else {
                exit('Something went wrong');
            }
        } else {
            exit('Permission deny');
        }
    }

    public function profile($id)
    {
        if ($_SESSION['user_id'] == $id) {
            $user = $this->userModel->getUserById($id);
            $gender = $this->userModel->getGender($id)->name;
            $role = $this->userModel->getRole($id);

            $data = [
                'user' => $user,
                'photo' => '',
                'gender' => $gender,
            ];

            if ($role) {
                $_SESSION['user_role'] = $role;
                $data['role'] = $role;
            }

            // Check if users has avatar
            $photo = $this->photoModel->getUserAvatar($id);

            if ($photo) {
                $data['photo'] = $photo->photoPath;
            }

            if (!empty($data['user']->photo_id)) {
                $_SESSION['avatar'] = URLROOT . '/images/users/' . $data['photo'];
            } elseif ($data['user']->gender == 2) {
                $_SESSION['avatar'] = AVATAR_FEMALE;
            } else {
                $_SESSION['avatar'] = AVATAR_MALE;
            }

            return $this->view('admin/profile/index', $data);
        } else {
            redirect('users/profile/' . $_SESSION['user_id']);
        }
    }

    public function profileUpdate($id)
    {
        if ($_SESSION['user_id'] == $id) {
            $user = $this->userModel->getUserById($id);
            $photo = $this->photoModel->getUserAvatar($id);
            if ($photo) {
                $photo = $photo->photoPath;
            }
            $gender = $this->userModel->getGender($id);
            $genders = $this->genderModel->getAll();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Init data
                $data = [
                    'first_name' => test_input($_POST['first_name']),
                    'last_name' => test_input($_POST['last_name']),
                    'gender' => test_input($_POST['gender']),
                    'phone' => test_input($_POST['phone']),
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
                    if ($this->userModel->updateProfile($id, $data['first_name'], $data['last_name'], $data['gender'], $data['phone'])) {
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
                    'genders' => $genders,
                    'gender' => $gender->id,
                    'photo' => '',
                ];
                if ($photo) {
                    $data['photo'] = $photo;
                }

                return $this->view('/admin/profile/edit', $data);
            }
        } else {
            redirect('users/profileUpdate/' . $_SESSION['user_id']);
        }

    }

    public function updateAvatar($id)
    {
        if ($_SESSION['user_id'] == $id) {
            if (isset($_POST['update_file'])) {

                // specifies the directory where the file is going to be placed
                $target_dir = AVATAR_USER_FOLDER;

                $user = $this->userModel->getUserById($id);
                $gender = $this->userModel->getGender($id);
                $genders = $this->genderModel->getAll();

                $data = [
                    'first_name_err' => '',
                    'last_name_err' => '',
                    'user' => $user,
                    'genders' => $genders,
                    'gender' => $gender->id,
                    'photo' => '',
                    'file_err' => [],
                ];

                // Check if user already have photo
                $photo = $this->photoModel->getUserAvatar($id);

                if ($photo) {
                    $data['photo'] = $photo->photoPath;
                }

                try {
                    $loader = new ThumbnailUpload($target_dir, true);
                    $loader->setThumbOptions($target_dir, MAX_SIZE);
                    $loader->upload('file', 1024*1000);
                    $data['file_err'] = $loader->getMessages();
                    $status = $loader->getStatus();
                    $name = $loader->getName($_FILES['file']);

                    if ($status) {
                        if (!$photo) {
                            if ($this->photoModel->upload($name, $user->id, 'Users')) {
                                $photo_id = $this->photoModel->getMaxId();
                                if ($this->userModel->updateAvatar($id, $photo_id)) {
                                    flash('message', 'Your avatar is updated!');
                                    redirect('users/profile/' . $data['user']->id);
                                }
                            } else {
                                exit('Something went wrong');
                            }
                        } else {

                            $user_photo_id = $user->photo_id;
                            if ($this->photoModel->updateUserAvatar($user_photo_id, $name)) {

                                unlink(AVATAR_USER_FOLDER . $photo->photoPath);
                                // Flash message
                                flash('message', 'Your avatar is updated!');

                                redirect('users/profile/' . $data['user']->id);
                            } else {
                                exit('something went wrong');
                            }
                        }
                    } else {
                        return $this->view('admin/profile/edit', $data);
                    }
                } catch (Throwable $t) {
                    echo $t->getMessage();
                }
            }
        } else {
            exit('Permisison deny');
        }
    }

    public function changePass($id)
    {
        if ($_SESSION['user_id'] == $id) {
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
        } else {
            redirect('users/changePass/' . $_SESSION['user_id']);
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
