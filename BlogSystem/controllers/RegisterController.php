<?php

class RegisterController extends BaseController{

    private $registerModel;

    public function onInit() {
        // Names of fields for validation messages
        $this->validator->labels(array(
            'username' => 'Username',
            'firstName' => 'First name',
            'lastName' => 'Last name',
            'email' => 'Email address',
            'Password' => 'Password',
            'confirmPassword' => 'Confirm password'
        ));

        $this->registerModel = new RegisterModel();
    }

    function index() {
        if ($this->isPost) {
            If(!isset($_POST['formToken']) || $_POST['formToken'] != $_SESSION['formToken']) {
                $this->addErrorMessage('Invalid request!');
                $this->redirectToUrl('/Home');
            }

            $userData = $this->validateFormData();
            if ($userData != NULL ) {
                $result = $this->registerModel->registerUser($userData);

                if ($result) {
                    $this->addInfoMessage('Successful Registration!. Please Login!');
                    $this->redirectToUrl('/login');
                } else {
                    $this->addErrorMessage('Error in Registration! Username ['. $userData['username'] . '] is not available!');
                }
            }
        }

        $this->renderView();
    }

    private function validateFormData() {
        $rules = [
            'required' => [
                ['username'],
                ['password'],
                ['lastName'],
                ['confirmPassword']
            ],
            'lengthMin' => [
                ['username', 3],
                ['password', 3]
            ],
            'lengthMax' => [
                ['username', 20],
                ['password', 10]
            ],
            'alpha' => [
                ['username'],
                ['firstName'],
                ['lastName'],
            ],
            'slug' => [
                ['userName'],
                ['password']
            ],
            'email' => [
                ['email']
            ],
            'equals' => [
                ['password', 'confirmPassword']
            ]
        ];

        return $this->makeValidation($rules);
    }
}
