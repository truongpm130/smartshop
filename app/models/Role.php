<?php

class Role extends Database {

    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllRoles()
    {
        $this->db->query('SELECT * FROM roles');
        $roles = $this->db->execute();
        return $roles;
    }


}