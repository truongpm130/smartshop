<?php

class Post extends Database {

    protected $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }
}