<?php 

class PostsController extends Controller {

    protected $postModel;
    
    public function __construct()
    {
        $this->postModel = $this->model('Post');
    }
}