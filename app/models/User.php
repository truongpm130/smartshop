<?php

class User extends Database {

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Register User
    public function register($data)
    {
        $this->db->query('INSERT INTO users (first_name, last_name, email, password) VAlUES (:first_name, :last_name, :email, :password)');

        // Bind values
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function login($email, $password)
    {   

        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind('email', $email);

        $row = $this->db->single();

        if ($row) {
            $hashed_password = $row->password;
            if (password_verify($password, $hashed_password)) {
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
        
    }

    public function update($data)
    {
        if (empty($data['password'])) {
            $this->db->query('UPDATE user SET first_name = :first_name, last_name = :last_name, email = :email WHERE id = :id');

            $this->db->bind('first_name', $data['first_name']);
            $this->db->bind('last_name', $data['last_name']);
            $this->db->bind('email', $data['email']);
            $this->db->bind('email', $data['id']);
            
            
            $this->db->execute();            
        }
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind('id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Find user by email
    public function findUserByEmail($email)      
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        
        // Bind value
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // Check row
        if ($row) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllUser()
    {
        $this->db->query('SELECT * FROM users');
        $users = $this->db->resultSet();
        return $users;
    }

    // Get user by id
    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM users WHERE id= :id');
        $this->db->bind('id', $id);
        $user = $this->db->single();
        return $user;
    }

}