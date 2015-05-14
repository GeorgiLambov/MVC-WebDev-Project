<?php

class LoginModel extends BaseModel {

    private static $isLogged = FALSE;
    private static $isAdmin = FALSE;
    private static $loggedUser = ARRAY();

    public function __construct($args = array()) {
        parent::__construct(array('table' => 'users'));
        session_set_cookie_params(3000, '/');
        //session_start();
        
        if (!empty($_SESSION['username'])) {
            self::$isLogged = TRUE;
            self::$loggedUser = array(
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username']
            );

            if( $_SESSION['admin'] ){
                self::$isAdmin = true;
            }
        }
    }
    
    public function isLogged() {
        return self::$isLogged;
    }

    public function isAdmin() {
        return self::$isAdmin;
    }
    
    public function getLoggedUser() {
        return self::$loggedUser;
    }
    
    public function logIn($username, $password) {
        $username = $this->mysql_escape_mimic($username);
        $password = $this->mysql_escape_mimic($password);

        $statement = self::$db->prepare(
                "SELECT id, username, pass_hash, is_admin
                 FROM users
                 WHERE username = ?");

        $statement->bind_param('s', $username);
        $resultSet = $this->executeStatementWithResultArray($statement);

        if (!empty($resultSet) && password_verify($password, $resultSet[0]['pass_hash'])) {
            $_SESSION['username'] =  $resultSet[0]['username'];
            $_SESSION['user_id'] =  $resultSet[0]['id'];
            $_SESSION['admin'] =  $resultSet[0]['is_admin'];

            return TRUE;
        }

        return FALSE;
    }
}
