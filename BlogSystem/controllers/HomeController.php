<?php

namespace Controllers;

class HomeController extends BaseController {
    public function __construct() {
        parent::__construct(get_class(), 'home', '/views/home/');
    }

    function index() {
        $template = ROOT_DIR . $this->viewsDir . 'index.php';
        include_once $this->layout;
    }
}