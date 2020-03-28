<?php

class Photo extends Database
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function upload($path)
    {
        $this->db->query('INSERT INTO photos(path) VALUE(:path)');
        $this->db->bind('path', $path);
        if ($this->db->execute()) {
            return true;
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

    public function updateUserAvatar($id, $path)
    {
        if ($this->upload($path)) {
            $this->db->query('SELECT MAX(id) AS maxID FROM photos');
            $photo_id = $this->db->single();
            if ($photo_id) {
                $this->db->query('UPDATE users SET photo_id = :photo_id WHERE id = :id');
                $this->db->bind('photo_id', $photo_id->maxID);
                $this->db->bind('id', $id);
                if ($this->db->execute()) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        
    }

}
