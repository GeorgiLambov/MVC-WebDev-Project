<?php

namespace Models;

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

        $count = $this->exuteStatementWithResultArray($isUsernameUnique)[0]['count'];
        if ($count > 0) {
            return FALSE;
        }

        $admin = 1;
        $statement = self::$db->prepare(
            "INSERT INTO users(first_name, last_name, username, pass_hash, email, is_admin)
            VALUES(?, ?, ?, ?, ?, ?)");
        $statement->bind_param("sssssi", $firstName, $lastName, $username, md5($password), $email, $admin );
        return $this->exuteStatement($statement);
    }
}