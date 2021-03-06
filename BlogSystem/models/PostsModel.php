<?php

class PostsModel extends BaseModel{

    public function __construct($args = array()) {
        parent::__construct(array('table' => 'posts'));
    }

    public function getPostById($id) {
        return $this->getById($this->mysql_escape_mimic($id));
    }

    public function getAllPosts($date = NULL, $tagName = NULL) {
        if ($tagName != NULL) {
            $tagName = '%' . $this->mysql_escape_mimic($tagName) . '%';
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
                ORDER BY p.DATE DESC, p.id DESC");
            $statement->bind_param("s", $tagName);

            return $this->executeStatementWithResultArray($statement);
        }

        if ($date != NULL) {
            return $this->find(array(
                'order' => 'date DESC, id DESC',
                'where' => "date >= '$date'" ));
        }

        return $this->find(array('order' => 'date DESC, id DESC'));
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
        // Insert  Post
        $queryData = array();
        $queryData['columns'] = 'author_id, text, visits, title, date';
        $queryData['values'] =
            $this->mysql_escape_mimic($postData['author_id']) . ", '"
            . $this->mysql_escape_mimic($postData['text']) . "', "
            . $this->mysql_escape_mimic($postData['visits']) . ", '"
            . $this->mysql_escape_mimic($postData['title']) . "', '"
            . $this->mysql_escape_mimic($postData['date']) . "'";

        self::$db->autocommit(FALSE);
        $postInsertResult = $this->insert($queryData);
        $post_id = self::$db->insert_id;
        $finalTagsIdsList = array();

        // Check existing tag
        foreach ($postData['tags'] as $tag) {
            $tagText = $this->mysql_escape_mimic($tag);
            $existingTag = $this->findExistingTag($tagText);

            // not exist in DB
            if (!$existingTag) {
                $tagInsertQuery = "INSERT IGNORE INTO tags(text) VALUES ('$tagText')";
                $insertTagStatement = self::$db->prepare($tagInsertQuery);
                $insertTagsResult= $this->executeStatement($insertTagStatement);

                if (!$insertTagsResult && !$postInsertResult) {
                    self::$db->trans_rollback();
                    return FALSE;
                }

                $existingTag = $this->findExistingTag($tagText);
            }

            $existingTagId =  $existingTag['id'];
            if(!in_array($existingTagId, $finalTagsIdsList)){
                $finalTagsIdsList[] = $existingTagId;
            }

        }

        // Insert posts_tags
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
        $queryData['set'] = "visits = visits + 1";
        $queryData['where'] = "id = " . $this->mysql_escape_mimic($id);
        return $this->update($queryData);
    }

    public function deletePost($id) {
        $queryData = array();
        $queryData['where'] = "id = " . $this->mysql_escape_mimic($id);

        return $this->delete($queryData);
    }

    public function deletePostComments($postId){
        $queryData = array();
        $queryData['table'] = 'comments';
        $queryData['where'] = "post_id = " . $this->mysql_escape_mimic($postId);

        return $this->delete($queryData);
    }

    public function deletePostTags($postId){
        $queryData = array();
        $queryData['table'] = 'posts_tags';
        $queryData['where'] = "post_id = " . $this->mysql_escape_mimic($postId);

        return $this->delete($queryData);
    }

    public function deleteComment($Id){
        $queryData = array();
        $queryData['table'] = 'comments';
        $queryData['where'] = "id = " . $this->mysql_escape_mimic($Id);

        return $this->delete($queryData);
    }

    private function findExistingTag($tagText)
    {
        $tagQueryData = array(
            'table' => 'tags',
            'where' =>  "text LIKE '$tagText'");
        $tag =  $this->find($tagQueryData);
        if($tag){
            $tag = $tag[0];
        }

        return $tag;
    }
}