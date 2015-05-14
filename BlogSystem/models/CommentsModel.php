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
        $queryData['where'] = "post_id = " . $this->mysql_escape_mimic($id);
        return $this->find($queryData);
    }

    public function insertComment($commentData)
    {
        $queryData = array();
        $queryData['columns'] = 'author, email, text, post_id, date';
        $queryData['values'] =
            "'" . $this->mysql_escape_mimic($commentData['author']) . "', '"
            . $this->mysql_escape_mimic($commentData['email'] == '' ? NULL : $commentData['email']) . "', '"
            . $this->mysql_escape_mimic($commentData['text']) . "', '"
            . $this->mysql_escape_mimic($commentData['post_id']) . "', '"
            . $this->mysql_escape_mimic($commentData['date']) . "'";

        return $this->insert($queryData);
    }
}