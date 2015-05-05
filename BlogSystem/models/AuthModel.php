<?php

class AuthModel extends BaseModel {
    private static $isLogged = FALSE;
    private static $loggedUser = ARRAY();

    public function __construct($args = array()) {
        parent::__construct(array('table' => 'users'));
        session_set_cookie_params(1800, '/');
        //session_start();
        
        if (! empty($_SESSION['username'])) {
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

        //TODO: make hash on login query after make hashing on password on register
        // "AND password = MD5(?) LIMIT 1"
        $statement = self::$db->prepare(
                "SELECT id, username "
                . "FROM users "
                . "WHERE username = ? "
                . "AND password = ? "
                . "LIMIT 1");
        
        $statement->bind_param('ss', $username, md5($password));
        $statement->execute();
        
        $resultSet = $statement->get_result();
        $row = $resultSet->fetch_assoc();
        if (!empty($row)) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];
            return TRUE;
        }
        
        return FALSE;
    }
}
