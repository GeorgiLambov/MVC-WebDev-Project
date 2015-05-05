<?php

class LogoutController extends BaseController {

    public function index() {
        session_destroy();
        $this->message['type'] = 'info';
        $this->message['text'] = 'You are out of the system now ;)';

        header("Location: " . '/'); 
        exit();
    }
}
