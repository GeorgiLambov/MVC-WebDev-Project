<?php

class RegisterModel extends BaseModel {

    public function __construct($args = array()) {
        parent::__construct(array('table' => 'users'));
    }

    public function registerUser($userData) {
        $firstName = $userData['firstName'];
        $lastName = $userData['lastName'];
        $username = $userData['username'];
        $email = $userData['email'];
        $password = $userData['password'];

        $isUsernameUnique = self::$db->prepare(
               "SELECT COUNT(u.id) AS count
                FROM users u
                WHERE u.username = ?");
        $isUsernameUnique->bind_param("s", $username);
        $count = $this->executeStatementWithResultArray($isUsernameUnique)[0]['count'];
        if ($count > 0) {
            return FALSE;
        }

        $admin = 1;
        $pass_hash = password_hash($password, PASSWORD_BCRYPT);

        $statement = self::$db->prepare(
            "INSERT INTO users(first_name, last_name, username, pass_hash, email, is_admin)
             VALUES(?, ?, ?, ?, ?, ?)");
        $statement->bind_param('sssssi', $firstName, $lastName, $username, $pass_hash, $email, $admin);

        return $this->executeStatement($statement);
    }
}