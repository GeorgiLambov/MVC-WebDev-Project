<?php

class RegisterModel extends BaseModel {

    public function __construct($args = array()) {
        parent::__construct(array('table' => 'users'));
    }

    public function registerUser($userData) {
        $firstName = mysql_real_escape_string($userData['firstName']);
        $lastName = mysql_real_escape_string($userData['lastName']);
        $username = mysql_real_escape_string($userData['username']);
        $email = mysql_real_escape_string($userData['email']);
        $password = mysql_real_escape_string($userData['password']);

        $isUsernameUnique = self::$db->prepare(
               "SELECT COUNT(u.id) AS count
                FROM users u
                WHERE u.username = ?");
        $isUsernameUnique->bind_param("s", $username);
        $count = $this->executeStatementWithResultArray($isUsernameUnique)[0]['count'];
        if ($count > 0) {
            return FALSE;
        }

        $pass_hash = password_hash($password, PASSWORD_BCRYPT);

        $statement = self::$db->prepare(
            "INSERT INTO users(first_name, last_name, username, pass_hash, email, is_admin)
             VALUES(?, ?, ?, ?, ?, ?)");
        $statement->bind_param('sssssi', $firstName, $lastName, $username, $pass_hash, $email, $admin);

        return $this->executeStatement($statement);
    }
}