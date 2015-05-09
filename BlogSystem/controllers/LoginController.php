<?php

class LoginController extends BaseController {

    function index() {
        if ($this->isPost) {
            If(!isset($_POST['formToken']) || $_POST['formToken'] != $_SESSION['formToken']) {
                $this->addErrorMessage('Invalid request!');
                $this->redirectToUrl('/Home');
            }

            $userData = $this->validateFormData();
            if ($userData != NULL) {
                $isLoggedIn = $this->auth->logIn($userData['username'], $userData['password']);

                if (isset($isLoggedIn) && $isLoggedIn == TRUE) {
                    $this->addInfoMessage('Successful login!');
                    $this->addInfoMessage('Hello, '. htmlspecialchars($userData['username']));
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
            ],
            'alpha' => [
                ['username']
             ]
        ];

        return $this->makeValidation($rules);
    }
}
