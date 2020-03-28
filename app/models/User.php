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

    // Admin Add User
    public function add($data)
    {
        // Add new user
        $this->register($data);

        // Get id of new user
        $this->db->query('SELECT MAX(id) AS newUserId FROM users');
        $new_id = $this->db->single();

        // Insert data in role_user table
        $this->db->query('INSERT INTO role_user (user_id, role_id) VALUES (:user_id, :role_id)');
        $this->db->bind('user_id', $new_id->newUserId);
        $this->db->bind('role_id', $data['role']);
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
        $this->db->query('UPDATE users SET first_name = :first_name, last_name = :last_name  WHERE id = :id');

        $this->db->bind('first_name', $data['first_name']);
        $this->db->bind('last_name', $data['last_name']);
        $this->db->bind('id', $data['id']); 

        $this->db->execute();

        if (!$this->db->execute()) {
            exit('Cannot update User information');
        }

        if (!empty($data['role'])) {
            $this->db->query('SELECT *
                            FROM role_user
                            INNER JOIN users ON role_user.user_id = users.id
                            INNER JOIN roles ON role_user.role_id = roles.id
                            WHERE users.id = :id
                            ');

            $this->db->bind('id', $data['id']);
            $this->db->execute();
            
            if ($this->db->rowCount()) {
                return $this->updateRoleUser($data);
            } else {
                return $this->addRoleUser($data);
            }
        } 
    }

    public function updateProfile($id, $first_name, $last_name)
    {
        $this->db->query('UPDATE users SET first_name = :first_name, last_name = :last_name
                            WHERE id = :id
                        ');
        $this->db->bind('first_name', $first_name);
        $this->db->bind('last_name', $last_name);
        $this->db->bind('id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function updatePass($id, $password)
    {
        $this->db->query('UPDATE users SET password = :password WHERE id = :id');
            $this->db->bind('password', $password);
            $this->db->bind('id', $id);
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
    }

    public function checkPass($id, $password)
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind('id', $id);
        $row = $this->db->single();

        if ($row) {
            $hash_pass = $row->password;
            if (password_verify($password,$hash_pass)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function addRoleUser($data)
    {
        $this->db->query('INSERT INTO role_user(user_id, role_id) VALUES (:user_id, :role_id)');
        $this->db->bind('user_id', $data['id']);
        $this->db->bind('role_id', $data['role']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateRoleUser($data)
    {
        $this->db->query('UPDATE role_user SET role_id = :role_id WHERE user_id = :user_id');
        $this->db->bind('user_id', $data['id']);
        $this->db->bind('role_id', $data['role']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
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

    public function activeUser($id)
    {
        $this->db->query('UPDATE users SET status = 1 WHERE id= :id');
        $this->db->bind('id', $id);
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function inactiveUser($id)
    {
        $this->db->query('UPDATE users SET status = 0 WHERE id= :id');
        $this->db->bind('id', $id);
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

}