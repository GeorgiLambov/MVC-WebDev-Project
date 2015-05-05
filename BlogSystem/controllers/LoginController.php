<?php

namespace Controllers;

use Models\BaseModel;

class LoginController extends BaseController {

    function index() {
        $this->renderView();

        if (isset($_POST['submitted'])) {
            $data = $this->getData();
            if ($data != NULL) {
                $isLogged = $this->auth->logIn($data['username'], $data['password']);
            }
            
            if (isset($isLogged) && $isLogged == TRUE) {
                $this->addInfoMessage('Hello, '. $data['username']);
                $this->redirectToUrl('/posts/index');
            } else {
                $this->addErrorMessage('Your login data is invalid!');
            }
        }


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
