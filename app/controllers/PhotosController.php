<?php

class PhotosController extends Controller {

    private $userModel;
    private $photoModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->photoModel = $this->model('Photo');
    }

    public function upload($file, $target, $max)
    {
        $file = $_FILES['file'];
        $error = '';

        // specifies the directory where the file is going to be placed
        $target_dir = $target;

        // specifies the path of the file to be uploaded
        $target_file = $target_dir . basename($file["name"]);

        // Max size file
        $maxSize = $max;
        $uploadOk = 1;

        // holds the file extension of the file (in lower case)
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Check if image file is actual image or fake image
        if ($check = getimagesize($file['tmp_name'])) {
            
        } else {

            $error = 'File is not an image';
            $uploadOK = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $error = 'Sorry, file already exists';
            $uploadOK = 0;
        }

        // Check file size
        if ($file['size'] > $maxSize) {
            $error = 'Sorry, this file is too large';
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' &&$imageFileType != 'gif') {
            $error = 'Sorry! Only JPG, GIF, JPEG, GIF files are allowed';
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $error = 'Sorry, can not upload your file';
        } else {
            
            // Move photo to dir
            if (move_uploaded_file($file['tmp_name'], $target_file)) {

                // Insert photo path in DB
                if ($this->photoModel->upload($file['name'])) {

                    return true;
                    
                } else {
                    exit('something went wrong');
                }
            } else {
                exit('Something went wrong');
            }
        }
    }

    public function updateAvatar($id)
    {   
        // specifies the directory where the file is going to be placed
        $target_dir = AVATAR_USER_FOLDER;

        // specifies the path of the file to be uploaded
        $target_file = $target_dir . basename($_FILES["file"]["name"]);

        // Max size file
        $maxSize = MAX_SIZE;
        $uploadOk = 1;

        // holds the file extension of the file (in lower case)
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Get user by id
        $user = $this->userModel->getUserById($id);
        
        // Init data
        $data = [
            'file_err' => '',
            'user' => $user,
        ];
        
        // Check if image file is actual image or fake image
        if ($check = getimagesize($_FILES['file']['tmp_name'])) {
            
        } else {

            $data['file_err'] = 'File is not an image';
            $uploadOK = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $data['file_err'] = 'Sorry, file already exists';
            $uploadOK = 0;
        }

        // Check file size
        if ($_FILES['file']['size'] > $maxSize) {
            $data['file_err'] = 'Sorry, this file is too large';
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' &&$imageFileType != 'gif') {
            $data['file_err'] = 'Sorry! Only JPG, GIF, JPEG, GIF files are allowed';
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            return $this->view('admin/profile/edit', $data);
        } else {
            
            // Move photo to dir
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {

                // Insert photo tables, update users table
                if ($this->photoModel->updateUserAvatar($id, $_FILES['file']['name'])) {
                    
                    // Flash message
                    flash('message','Your avatar is updated!');

                    redirect('admin/profile/'. $data['user']->id, $data);
                } else {
                    exit('something went wrong');
                }
            } else {
                exit('Something went wrong');
            }
        }
        
    }

    


}