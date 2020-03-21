<?php

class Core
{

    protected $currentController = 'PagesController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->getURL();

        // Lock in controllers for the first value
        if (file_exists(APPROOT . '/controllers/' . ucwords($url[0]) . 'Controller.php')) {
            // If exists, set as controller
            $this->currentController = ucwords($url[0] . 'Controller');
            // Unset 0 index
            unset($url[0]);
        }

        // Require controller
        require_once APPROOT . '/controllers/' . $this->currentController . '.php';

        // Instance controller class
        $this->currentController = new $this->currentController;

        // Check for second part of url
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];

                // Unset 1 index
                unset($url[1]);
            }
        }

        // Get Params
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array(array($this->currentController, $this->currentMethod), $this->params);
    }

    public function getURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
