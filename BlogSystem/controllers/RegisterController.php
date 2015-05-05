<?php


class RegisterController extends BaseController{
    public function __construct() {
        parent::__construct(get_class());
        $this->fieldsErrors = array();
    }
    
    function index() {
        if (isset($_POST['submitted']) && $_POST['submitted'] = 1) {
            $userData = $this->getFormData();
            $result = $this->model->registerUser($userData);
            if ($result) {
                $this->addInfoMessage('Successful Registration!. Please Login!');
                $this->redirectToUrl('/login/index');
            } else {
                $this->addErrorMessage('You ar not registered! Please try again later!');
            } 
        }

        $this->renderView();
    }

    private function getFormData() {
        $rules = [
            'required' => [
                ['username'], 
                ['password'],
                ['confirmPassword']
            ],
            'lengthMin' => [
                ['username', 3],
                ['password', 5]
            ],
            'lengthMax' => [
                ['username', 20],
                ['password', 10]
            ],
            'alpha' => [
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
    }
}
