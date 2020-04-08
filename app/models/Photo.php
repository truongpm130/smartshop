<?php

class Photo extends Database
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function upload($path, $imageable_id, $imageable_type)
    {
        $this->db->query('INSERT INTO photos(path, imageable_id, imageable_type) VALUE(:path, :imageable_id, :imageable_type)');
        $this->db->bind('path', $path);
        $this->db->bind('imageable_id', $imageable_id);
        $this->db->bind('imageable_type', $imageable_type);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getMaxId()
    {
        $this->db->query('SELECT MAX(id) AS maxId FROM photos');
        $row = $this->db->single();

        if ($row) {
            return $row->maxId;
        } else {
            return false;
        }
    }

    public function getUserAvatar($id)
    {
        $this->db->query('SELECT users.photo_id AS photo_id,
                            photos.path AS photoPath
                            FROM users 
                            INNER JOIN photos
                            ON users.photo_id = photos.id 
                            WHERE users.id = :id
                        ');
        $this->db->bind('id', $id);
        $row = $this->db->single();
        if ($row) {
            return $row;
        } else {
            return false;
        }
    }

    public function updateUserAvatar($photo_id, $path)
    {
        $this->db->query('UPDATE photos SET path = :path WHERE id = :photo_id');
        $this->db->bind('photo_id', $photo_id);
        $this->db->bind('path', $path);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getPhoto($id)
    {
        $this->db->query('SELECT path FROM photos WHERE id = :id');
        $this->db->bind('id', $id);
        $row = $this->db->single();

        if ($row) {
            return $row->path;
        } else {
            return false;
        }
    }

    public function getAllProductPhoto()
    {
        $this->db->query('SELECT photos.path as photoPath,
                            photos.created_at as photoCreatedAt
                            FROM photos
                            INNER JOIN products
                            ON products.photo_id = photos.id
                            ORDER BY photos.created_at DESC
                         ');
        $row = $this->db->resultSet();

        if ($row) {
            return $row;
        } else {
            return false;
        }
    }

    public function getAllUserPhoto()
    {
        $this->db->query('SELECT photos.path as photoPath,
                            photos.created_at as photoCreatedAt
                            FROM photos
                            INNER JOIN users
                            ON users.photo_id = photos.id
                            ORDER BY photos.created_at DESC
                         ');
        $row = $this->db->resultSet();

        if ($row) {
            return $row;
        } else {
            return false;
        }
    }
}
