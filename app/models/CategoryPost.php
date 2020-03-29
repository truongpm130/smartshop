<?php

class CategoryPost extends Database {

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAll()
    {
        $this->db->query('SELECT * FROM categories');
        $categories = $this->db->resultSet();

        if ($categories) {
            return $categories;
        } else {
            return false;
        }
    }


    public function add($name, $slug)
    {
        $this->db->query('INSERT INTO categories(name, slug) VALUES(:name, :slug)');
        $this->db->bind('name', $name);
        $this->db->bind('slug', $slug);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $name, $slug)
    {
        $this->db->query('UPDATE categories SET name = :name, slug = :slug WHERE id = :id');
        $this->db->bind('name', $name);
        $this->db->bind('slug', $slug);
        $this->db->bind('id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM categories WHERE id = :id');
        $this->db->bind('id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function findCategoryById($id)
    {
        $this->db->query('SELECT * FROM categories WHERE id = :id');
        $this->db->bind('id', $id);
        $row = $this->db->single();

        if ($row) {
            return $row;
        } else {
            return false;
        }
        
    }



    public function active($id)
    {
        $this->db->query('UPDATE categories SET status = 1 WHERE id= :id');
        $this->db->bind('id', $id);
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function inactive($id)
    {
        $this->db->query('UPDATE categories SET status = 0 WHERE id= :id');
        $this->db->bind('id', $id);
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}