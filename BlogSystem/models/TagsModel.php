<?php



class TagsModel extends BaseModel{

    public function __construct($args = array()) {
        parent::__construct(array('table' => 'tags'));
    }

    public function getTagsFromPostId($postId){
        $statement = self::$db->prepare(
            "SELECT t.id, t.text
                 FROM tags t
                 JOIN posts_tags pt
                 ON t.id = pt.tag_id
                 WHERE pt.post_id = ?
                 LIMIT 5");
        $statement->bind_param("i", $postId);

        return $this->executeStatementWithResultArray($statement);
     }

    public function getMostPopularTags() {
          $statement = self::$db->prepare("
                    SELECT t.id, t.text, COUNT(t.text) AS popularity
                    FROM blog_system.posts_tags pt
                    LEFT JOIN tags t
                    ON pt.tag_id = t.id
                    GROUP BY t.text
                    ORDER BY popularity DESC
                    LIMIT 10");

        return $this->executeStatementWithResultArray($statement);
    }
}













