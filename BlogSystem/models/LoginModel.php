<?php

class LoginModel extends BaseModel {

    private static $isLogged = FALSE;
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
        }
    }
    
    public function isLogged() {
        return self::$isLogged;
    }
    
    public function getLoggedUser() {
        return self::$loggedUser;
    }
    
    public function logIn($username, $password) {
        $username=  mysql_real_escape_string($username);
        $password=  mysql_real_escape_string($password);

        $statement = self::$db->prepare(
                "SELECT id, username, pass_hash
                 FROM users
                 WHERE username = ?");

        $statement->bind_param('s', $username);
        $resultSet = $this->executeStatementWithResultArray($statement);

        if (!empty($resultSet) && password_verify($password, $resultSet[0]['pass_hash'])) {
            $_SESSION['username'] =  $resultSet[0]['username'];
            $_SESSION['user_id'] =  $resultSet[0]['id'];
            return TRUE;
        }
        
        return FALSE;
    }

    public function userInfo($username, $password) {
        $username=  mysql_real_escape_string($username);
        $password=  mysql_real_escape_string($password);

        $statement = self::$db->prepare(
            "SELECT *
                 FROM users
                 WHERE username = ?");

        $statement->bind_param('s', $username);
        $resultSet = $this->executeStatementWithResultArray($statement);

        if (!empty($resultSet) && password_verify($password, $resultSet[0]['pass_hash'])) {
            $_SESSION['username'] =  $resultSet[0]['username'];
            $_SESSION['user_id'] =  $resultSet[0]['id'];
            return TRUE;
        }

        return FALSE;
    }
}
