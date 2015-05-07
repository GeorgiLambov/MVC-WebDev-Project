<?php

class PostsController extends BaseController {
    private $postsModel;
    private $tagsModel;
    private $commentsModel;

    public function onInit() {
        $this->postsModel = new PostsModel();
        $this->tagsModel = new TagsModel();
        $this->commentsModel = new CommentsModel();
        $this->posts = array();
    }

    public function index($days = NULL) {
        $tagName = NULL;
        if (isset($_POST['searched']) && $_POST['searched'] == 1) {
            if (isset($_POST['tagName'])) {
                $tagName = $_POST['tagName'];
            }
        }

        $this->postsQwery = $this->postsModel->getAllPosts($tagName, $days);
        foreach ($this->postsQwery as $post) {
            $post['tags'] = $this->tagsModel->getTagsFromPostId($post['id']);
            $this->posts[] = $post;
        }

        $mostPopularTags = $this->tagsModel->getMostPopularTags();
        if (!empty($mostPopularTags)){
            $this->mostPopularTags = $mostPopularTags;
        }

        $this->renderView();
    }

    public function create() {
        if (!$this->auth->isLogged()) {
            $this->redirectToUrl('/login/index');
        }

        if ($this->isPost && $_POST['submitted'] == 1) {
            $isAdded = FALSE;
            $validData = $this->validateFormData();

            if ($validData != NULL) {
                $postData = $this->preparePostData($validData);
                $postData['author_id'] = $this->auth->getLoggedUser()['id'];
                $postData['visits'] = 0;
                $postData['date'] = date('Y-m-d H:m:s', time());
                $isAdded = $this->postsModel->addPost($postData);

                if ($isAdded) {
                    $this->addInfoMessage('Post created successfully!');
                    $this->redirectToUrl('/posts/index');
                }else {
                    $this->addErrorMessage("Error creating post!");
                }
            }
        }

        $this->renderView(__FUNCTION__);
    }

    public function delete($id) {
        if (!$this->auth->isLogged()) {
            $this->redirectToUrl('/login/index');
        }

    }

    public function byDays($days) {
        if (!is_numeric($days)) {
            $this->addErrorMessage('Invalid URL');
            $this->redirectToUrl('/');
        }

        $date = date_create(date(''));
        date_sub($date, date_interval_create_from_date_string("$days days"));
        $dateAsString = date_format($date, 'Y-m-d H:i:s');
        $this->index($dateAsString);
    }

    private function validateFormData() {
        $rules = [
            'required' => [
                ['title'],
                ['text'],
                ['tag1']
            ],
            'lengthMin' => [
                ['title', 5],
                ['text', 5],
                ['tag1', 3],
                ['tag2', 3],
                ['tag3', 3],
                ['tag4', 3],
                ['tag5', 3]
            ],
            'lengthMax' => [
                ['title', 200],
                ['text', 1000],
                ['tag1', 20],
                ['tag2', 20],
                ['tag3', 20],
                ['tag4', 20],
                ['tag5', 20]
            ],
            'slug' => [
                ['tag1'],
                ['tag2'],
                ['tag3'],
                ['tag4'],
                ['tag5']
            ]
        ];

        return $this->makeValidation($rules);
    }

    private function preparePostData($validData) {
        $data = array();
        $data['title'] = trim($validData['title']);
        $data['text'] = trim($validData['text']);
        $tags = array();
        foreach ($validData as $key => $value) {
            if (strpos($key,'tag') !== FALSE && !empty($value)) {
                $tags[] = mysql_real_escape_string(trim($value));
            }
        }

        $data['tags'] = $tags;
        return $data;
    }

    public function view($id = array()) {
        if (!is_numeric($id)) {
            $this->addErrorMessage('Invalid URL');
            $this->redirectToUrl('/');
        }

        $this->postsModel->updateCounter($id);

        if (isset($_POST['submitted']) && $_POST['submitted'] == 1) {
            $commentData = $this->getAddCommentFormData();

            if ($commentData != NULL) {
                $commentData['post_id'] = $id;
                $commentData['date'] = date('Y-m-d H:m:s', time());
                $isAdded = $this->model->insertComment($commentData);
                if ($isAdded) {
                    $this->addMessage('Your comment in the system now ;)', 'info');
                    $this->redirectTo("/posts/view/$id");
                } else {
                    $this->addMessage('Post is not recorded in database! Please try again later!', 'error');
                }
            }
        }

        $post = $this->postsModel->getPostById($id)[0];
        $comments = $this->commentsModel->getAllCommentsFromPost($id);

        $this->renderView(__FUNCTION__);
    }

}