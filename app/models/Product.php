<?php

class Product extends Database {

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function add($data)
    {
        $this->db->query('INSERT INTO products (category_id, name, slug, price, photo_id,  description) VALUES (:category_id, :name, :slug, :price, :photo_id, :description)');

        $this->db->bind('category_id', $data['category']);
        $this->db->bind('name', $data['name']);
        $this->db->bind('slug', $data['slug']);
        $this->db->bind('price', $data['price']);
        $this->db->bind('photo_id', $data['photo_id']);
        $this->db->bind('description', $data['description']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
        
    }

    public function update($id, $data)
    {
        $this->db->query('UPDATE products SET category_id = :category_id, name = :name, slug = :slug, price = :price, photo_id = :photo_id, description = :description WHERE id= :id');

        $this->db->bind('category_id', $data['category']);
        $this->db->bind('name', $data['name']);
        $this->db->bind('slug', $data['slug']);
        $this->db->bind('price', $data['price']);
        $this->db->bind('photo_id', $data['photo_id']);
        $this->db->bind('description', $data['description']);
        $this->db->bind('id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll()
    {
        $this->db->query('SELECT * FROM products');
        $rows = $this->db->resultSet();

        if ($rows) {
            return $rows;
        } else {
            return false;
        }
        
    }

    public function active($id)
    {
        $this->db->query('UPDATE products SET status = 1 WHERE id= :id');
        $this->db->bind('id', $id);
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function inactive($id)
    {
        $this->db->query('UPDATE products SET status = 0 WHERE id= :id');
        $this->db->bind('id', $id);
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM products WHERE id = :id');
        $this->db->bind('id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getById($id)
    {
        $this->db->query('SELECT * FROM products WHERE id = :id');
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
                            products_categories.id AS categoryId, 
                            products_categories.name AS categoryName
                            FROM products
                            INNER JOIN products_categories
                            ON products.category_id = products_categories.id
                            WHERE products.id = :id
                       ');

        $this->db->bind('id', $id);
        $row = $this->db->single();

        if ($row) {
            return $row;
        } else {
            return false;
        }
    }
}