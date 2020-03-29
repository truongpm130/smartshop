<?php

class Post extends Database {

    protected $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }

    public function add($title, $slug, $category_id, $content, $user_id)
    {
        $this->db->query('INSERT INTO posts (title, slug, category_id, content, user_id)
                            VALUES (:title, :slug, :category_id, :content, :user_id)
                        ');
        $this->db->bind('title', $title);
        $this->db->bind('slug', $slug);
        $this->db->bind('category_id', $category_id);
        $this->db->bind('content', $content);
        $this->db->bind('user_id', $user_id);
        
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $title, $slug, $category_id, $content, $user_id)
    {
        $this->db->query('UPDATE posts SET title = :title, slug = :slug, category_id = :category_id, content = :content, user_id = :user_id WHERE id = :id');
        $this->db->bind('title', $title);
        $this->db->bind('slug', $slug);
        $this->db->bind('category_id', $category_id);
        $this->db->bind('content', $content);
        $this->db->bind('user_id', $user_id);
        $this->db->bind('id', $id);
        
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll()
    {
        $this->db->query('SELECT * FROM posts');
        $rows = $this->db->resultSet();

        if ($rows) {
            return $rows;
        } else {
            return false;
        }
        
    }

    public function getCategoryOfPost($id)
    {
        $this->db->query('SELECT 
                            categories.name AS name,
                            categories.id AS categoryId
                            FROM posts
                            INNER JOIN categories
                            ON posts.category_id = categories.id
                            WHERE posts.id = :id
        ');

        $this->db->bind('id', $id);
        $row = $this->db->single();
        
        if ($row) {
            return $row;
        } else {
            return false;
        }
    }

    public function getAuthor($id)
    {
        $this->db->query('SELECT 
                            users.first_name AS userFirstName,
                            users.last_name AS userLastName
                            FROM posts
                            INNER JOIN users
                            ON posts.user_id = users.id
                            WHERE posts.id = :id
                       ');

        $this->db->bind('id', $id);
        $row = $this->db->single();

        if ($row) {
            return $row;
        } else {
            return false;
        }
    }

    public function getCategory($id)
    {
        $this->db->query('SELECT 
                            categories.name AS categoryName
                            FROM posts
                            INNER JOIN categories
                            ON posts.category_id = categories.id
                            WHERE posts.id = :id
                       ');

        $this->db->bind('id', $id);
        $row = $this->db->single();

        if ($row) {
            return $row;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM posts WHERE id = :id');
        $this->db->bind('id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function active($id)
    {
        $this->db->query('UPDATE posts SET status = 1 WHERE id= :id');
        $this->db->bind('id', $id);
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function inactive($id)
    {
        $this->db->query('UPDATE posts SET status = 0 WHERE id= :id');
        $this->db->bind('id', $id);
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getById($id)
    {
        $this->db->query('SELECT * FROM posts WHERE id = :id');
        $this->db->bind('id', $id);
        $row = $this->db->single();

        if ($row) {
            return $row;
        } else {
            return false;
        }
    }


}