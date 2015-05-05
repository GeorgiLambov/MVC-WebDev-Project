<?php

class PostsModel extends BaseModel{

    public function __construct($args = array()) {
        parent::__construct(array('table' => 'posts'));
    }

    public function getPostById($id) {
        return $this->getById(mysql_real_escape_string($id));
    }

    public function getAllPosts($tagName = NULL, $date = NULL) {
        if ($tagName != NULL) {
            $tagName = '%' . mysql_real_escape_string($tagName) . '%';
            $statement = self::$db->prepare(
                "SELECT 
                    p.id,
                    p.text,
                    p.title,
                    p.author_id,
                    p.visits,
                    p.date
                FROM posts p
                LEFT JOIN posts_tags pt
                ON p.id = pt.post_id
                LEFT JOIN tags t
                ON pt.tag_id = t.id
                WHERE t.text LIKE ?
                ORDER BY p.DATE DESC");
            $statement->bind_param("s", $tagName);
            return $this->executeStatementWithResultArray($statement);
        }

        if ($date != NULL) {
            return $this->find(array(
                'order' => 'date DESC',
                'where' => "date >= '$date'" ));
        }

        return $this->find(array('order' => 'date DESC'));
    }

    public function getByDate($date) {
        $statement = self::$db->prepare(
            "SELECT 
                p.id,
                p.text,
                p.author_id,
                p.visits,
                p.title,
                p.date    
            FROM posts p
            LEFT JOIN posts_tags pt
            ON p.id = pt.post_id
            LEFT JOIN tags t
            ON pt.tag_id = t.id
            WHERE p.date > ?
            ORDER BY p.DATE DESC");
        $statement->bind_param("s", $date);

        return $this->executeStatementWithResultArray($statement);
    }

    public function addPost($postData) {
        $queryData = array();
        $queryData['columns'] = 'author_id, text, visits, title, date';
        $queryData['values'] =
            mysql_real_escape_string($postData['author_id']) . ", '"
            . mysql_real_escape_string($postData['text']) . "', "
            . mysql_real_escape_string($postData['visits']) . ", '"
            . mysql_real_escape_string($postData['title']) . "', '"
            . mysql_real_escape_string($postData['date']) . "'";

        self::$db->autocommit(FALSE);
        $postInsertResult = $this->insert($queryData);
        $post_id = self::$db->insert_id;
        // Insert Tags from Post
        $tagsInsertQuery = "INSERT IGNORE INTO tags(text) VALUES";
        $tagsInsertQuery .= "('" . implode("'), ('", $postData['tags']) . "')";

        $insertTagsStatement = self::$db->prepare($tagsInsertQuery);
        $isertTagsResult = $this->executeStatement($insertTagsStatement);

        if (!$isertTagsResult) {
            self::$db->trans_rollback();
            return FALSE;
        }

        $getTagsIdQuery = "SELECT t.id FROM tags t WHERE t.text IN ";
        $getTagsIdQuery .= "('" . implode("', '", $postData['tags']) . "')";
        $getTagsIdStatement =  self::$db->prepare($getTagsIdQuery);
        $tagsIds = $this->executeStatementWithResultArray($getTagsIdStatement);
        if (count($tagsIds) < 1) {
            self::$db->rollback();
            return FALSE;
        }

        $finalTagsIdsList = array();
        foreach ($tagsIds as $value) {
            $finalTagsIdsList[] = $value['id'];
        }

        // posts_tags insertation preaparation
        $postsTagsQueryData = array(
            'table' => 'posts_tags',
            'columns' => 'post_id, tag_id',
            'values' => "'$post_id', '" . implode("'), ('$post_id', '", $finalTagsIdsList) . "'"
        );

        $postsTagsInsertResult = $this->insert($postsTagsQueryData);

        if (!$postsTagsInsertResult) {
            self::$db->rollback();
            return FALSE;
        }

        self::$db->commit();
        self::$db->autocommit(TRUE);
        return TRUE;
    }

     public function updateCounter($id) {
        $queryData = array();
        $queryData['table'] = 'posts';
        $queryData['set'] = "visits = visits + 1";
        $queryData['where'] = "id = " . mysql_real_escape_string($id);
        return $this->update($queryData);
    }
}