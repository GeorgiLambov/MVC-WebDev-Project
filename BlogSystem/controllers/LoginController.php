<?php

class LoginController extends BaseController {

    function index() {
        if ($this->isPost) {
            $userData = $this->validateFormData();
            if ($userData != NULL && $_POST['submitted'] == 1) {
                $isLoggedIn = $this->auth->logIn($userData['username'], $userData['password']);

                if (isset($isLoggedIn) && $isLoggedIn == TRUE) {
                    $this->addInfoMessage('Successful login!');
                    $this->addInfoMessage('Hello, '. $userData['username']);
                    $this->redirectToUrl('/Home');
                } else {
                    $this->addErrorMessage('Login Error! Invalid Username or Password!');
                }
            }
        }

        $this->renderView();
    }

    private function validateFormData() {
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
