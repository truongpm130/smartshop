<?php

class PagesController extends Controller {

    public function index()
    {
        $data = [
            'title' => 'Welcome',
            $data = [],
        ];
        $this->view('pages/index', $data);
    }

}
