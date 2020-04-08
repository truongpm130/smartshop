<?php

class Gender extends Database {

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll() {
        $this->db->query('SELECT * FROM genders');
        $rows = $this->db->resultSet();

        if ($rows) {
            return $rows;
        } else {
            exit('Something went wrong');
        }
    }
}
