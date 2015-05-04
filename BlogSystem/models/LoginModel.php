<?php

namespace Models;

class LoginModel extends BaseModel {
    public function __construct($args = array()) {
        parent::__construct(array('table' => 'users'));
    }
}