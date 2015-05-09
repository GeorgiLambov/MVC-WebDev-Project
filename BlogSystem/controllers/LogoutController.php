<?php

class LogoutController extends BaseController {

    public function index() {
        session_destroy();
        $this->addInfoMessage('Successful Logout!');
        $this->redirectToUrl('/Home');
        exit();
    }
}
