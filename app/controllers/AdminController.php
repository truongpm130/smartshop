<?php

class AdminController extends Controller {

    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->roleModel = $this->model('Role');
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
        ];

        return $this->view('admin/profile/index', $data);
    }

}