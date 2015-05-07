<?php

class CommentsModel extends BaseModel
{
    public function __construct($args = array())
    {
        parent::__construct(array('table' => 'comments'));
    }

    public function getAllCommentsFromPost($id)
    {
        $queryData = array();
        $queryData['where'] = "post_id = " . mysql_real_escape_string($id);
        return $this->find($queryData);
    }

    public function insertComment($commentData)
    {
        $queryData = array();
        $queryData['table'] = 'comments';
        $queryData['columns'] = 'author, email, text, post_id, date';
        $queryData['values'] =
            "'" . mysql_real_escape_string($commentData['author']) . "', '"
            . mysql_real_escape_string($commentData['email'] == '' ? NULL : $commentData['email']) . "', '"
            . mysql_real_escape_string($commentData['text']) . "', '"
            . mysql_real_escape_string($commentData['post_id']) . "', '"
            . mysql_real_escape_string($commentData['date']) . "'";
        return $this->insert($queryData);
    }
}