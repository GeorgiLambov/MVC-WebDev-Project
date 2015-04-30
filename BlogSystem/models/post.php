<?php

namespace Models;

class Post_Model extends Master_Model{
    public function __construct($args = array()) {
        parent::__construct(array('table' => 'posts'));
    }
    
    public function getAllPosts() {
        return $this->find();
    }
    
    public function addPost($postData) {
        $queryData = array();
        $queryData['columns'] = 'user_id, text, visits, title, date';
        $queryData['values'] = 
                $postData['user_id'] . ", '" 
                . $postData['text'] . "', " 
                . $postData['visits'] . ", '"
                . $postData['title'] . "', '"
                . $postData['date'] . "'";
        return $this->insert($queryData);
    }
}