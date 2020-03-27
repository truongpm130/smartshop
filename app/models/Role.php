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
        $roles = $this->db->resultSet();
        return $roles;
    }

    public function getRoleOfUser($id)
    {
        $this->db->query('SELECT users.first_name  as userName, 
                            roles.name as roleName,
                            roles.id as roleId
                            FROM role_user
                            INNER JOIN users ON role_user.user_id = users.id
                            INNER JOIN roles ON role_user.role_id = roles.id
                            WHERE users.id = :id
        ');

        $this->db->bind('id', $id); 
        
        if ($row = $this->db->single()) {
            return $row;
        } else {
            return false;
        }
    }

    public function getAllRoleUser()
    {
        $this->db->query('SELECT users.id as userId,
                            roles.id as roleId,
                            users.first_name as userName,
                            roles.name as roleName
                            FROM role_user
                            INNER JOIN users ON role_user.user_id = users.id
                            INNER JOIN roles ON role_user.role_id = roles.id
        ');

        if ($result = $this->db->resultSet()) {
            return $result;
        } else {
            exit('Something went wrong');
        }
        
    }


}