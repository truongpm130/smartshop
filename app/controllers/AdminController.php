<?php

class AdminController extends Controller {

    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $users = $this->userModel->getAllUser();
        $data = [
            'users' => $users
        ];
        return $this->view('admin/users/index', $data);
    }
}