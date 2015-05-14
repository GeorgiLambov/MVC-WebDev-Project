<?php

class RegisterModel extends BaseModel {

    public function __construct($args = array()) {
        parent::__construct(array('table' => 'users'));
    }

    public function registerUser($userData) {
        // in production mysql_real_escape_string is a function of the mysql extension
        $firstName = $this->mysql_escape_mimic($userData['firstName']);
        $lastName = $this->mysql_escape_mimic($userData['lastName']);
        $username = $this->mysql_escape_mimic($userData['username']);
        $email = $this->mysql_escape_mimic($userData['email']);
        $password = $this->mysql_escape_mimic($userData['password']);

        $isUsernameUnique = self::$db->prepare(
               "SELECT COUNT(u.id) AS count
                FROM users u
                WHERE u.username = ?");
        $isUsernameUnique->bind_param("s", $username);
        $count = $this->executeStatementWithResultArray($isUsernameUnique)[0]['count'];
        if ($count) {
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