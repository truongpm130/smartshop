<?php

// Base Controller
// Load the model and view

class Controller {

    // Load model
    public function model($model)
    {
        require_once APPROOT . '/models/' . $model . '.php';

        return new $model();
    }

    // Load view
    public function view($view, $data = [])
    {
        // Check for the view file
        if (file_exists(APPROOT . '/views/' . $view . '.php')) {
            require_once APPROOT . '/views/' . $view . '.php';
        } else {
            die('View does not exists');
        }
    }
}