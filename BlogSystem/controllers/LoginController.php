<?php

class LoginController extends BaseController {

    function index() {
        if ($this->isPost) {
            $userData = $this->getData();
            if ($userData != NULL) {
                $isLoggedIn = $this->auth->logIn($userData['username'], $userData['password']);
            }

            if (isset($isLoggedIn) && $isLoggedIn == TRUE) {
                $this->addInfoMessage('Successful login!');
                $this->addInfoMessage('Hello, '. $userData['username']);
                $this->redirectToUrl('/posts/index');
            } else {
                $this->addErrorMessage('Login Error!!!');
            }
        }

        $this->renderView();
    }

    private function getData() {
        $rules = [
            'required' => [
                ['username'],
                ['password']
            ],
            'lengthMin' => [
                ['username', 2],
                ['password', 3]
            ],
            'lengthMax' => [
                ['username', 20],
                ['password', 10]
            ],
            'slug' => [
                ['userName'],
                ['password']
            ]
        ];

        return $this->makeValidation($rules);
    }
}
