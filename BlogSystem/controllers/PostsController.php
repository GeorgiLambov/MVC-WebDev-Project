<?php

class PostsController extends BaseController {
    private $postsModel;
    private $tagsModel;
    private $commentsModel;
    private $records_per_page;

    public function onInit() {
        $this->postsModel = new PostsModel();
        $this->tagsModel = new TagsModel();
        $this->commentsModel = new CommentsModel();
        $this->posts = array();

        $this->pagination = new Zebra_Pagination();
        $this->records_per_page = 4;
    }

    public function index($days = NULL, $tagName = NULL) {
         if($this->isPost){
            If(!isset($_POST['formToken']) || $_POST['formToken'] != $_SESSION['formToken']) {
                $this->addErrorMessage('Invalid request!');
                $this->redirectToUrl('/Home');
            }

            if (isset($_POST['tagName'])) {
                $tagName = $_POST['tagName'];
            }
        }

        $this->postsQwery = $this->postsModel->getAllPosts($days, $tagName);
        foreach ($this->postsQwery as $post) {
            $post['tags'] = $this->tagsModel->getTagsFromPostId($post['id']);
            $this->posts[] = $post;
        }

        $mostPopularTags = $this->tagsModel->getMostPopularTags();
        if (!empty($mostPopularTags)){
            $this->mostPopularTags = $mostPopularTags;
        }

        // the number of total records is the number of records in the array
        $this->pagination->records(count($this->posts));

        // records per page
        $this->pagination->records_per_page($this->records_per_page);

        // here's the magic: we need to display *only* the records for the current page
        $this->posts = array_slice(
            $this->posts,
            (($this->pagination->get_page() - 1) * $this->records_per_page),
            $this->records_per_page
        );

        $this->renderView();
    }

    public function tags($tagName = NULL){
        $this->index(NUll, $tagName);
    }

    public function create() {
        if (!$this->auth->isLogged()) {
            $this->redirectToUrl('/login');
        }

        if ($this->isPost) {
            If(!isset($_POST['formToken']) || $_POST['formToken'] != $_SESSION['formToken']) {
                $this->addErrorMessage('Invalid request!');
                $this->redirectToUrl('/Home');
            }

            $isAdded = FALSE;
            $validData = $this->validatePostFormData();

            if ($validData != NULL) {
                $postData = $this->preparePostData($validData);
                $postData['author_id'] = $this->auth->getLoggedUser()['id'];
                $postData['visits'] = 0;
                $date = date_create(date(''));
                $postData['date'] = date_format($date, 'Y-m-d H:i:s');
                $isAdded = $this->postsModel->addPost($postData);

                if ($isAdded) {
                    $this->addInfoMessage('Post created successfully!');
                    $this->redirectToUrl('/posts');
                }else {
                    $this->addErrorMessage("Error creating post!");
                }
            }
        }

        $this->renderView(__FUNCTION__);
    }

    public function view($id = array()) {
        if (!is_numeric($id)) {
            $this->addErrorMessage('Page not found!');
            $this->redirectToUrl('/');
        }

        $this->postsModel->updateCounter($id);
        if ($this->isPost) {
            If(!isset($_POST['formToken']) || $_POST['formToken'] != $_SESSION['formToken']) {
                $this->addErrorMessage('Invalid request!');
                $this->redirectToUrl('/Home');
            }

            $commentData = $this->validateCommentFormData();
            if ($commentData != NULL) {
                $commentData['post_id'] = $id;
                $date = date_create(date(''));
                $commentData['date'] = date_format($date, 'Y-m-d H:i:s');
                $isAdded = $this->commentsModel->insertComment($commentData);
                if ($isAdded) {
                    $this->addInfoMessage('Comment add successfully!');
                    $this->redirectToUrl("/posts/view/$id");
                } else {
                    $this->addErrorMessage('Error creating comment! Please try again later!');
                }
            }
        }

        $this->post = $this->postsModel->getPostById($id)[0];
        $this->comments = $this->commentsModel->getAllCommentsFromPost($id);

        $this->renderView(__FUNCTION__);
    }

    public function deletePost($id) {
        if (!$this->auth->isAdmin() && !$this->auth->isLogged()) {
            $this->redirectToUrl('/login');
        }

         // todo make confirm
        $deletePostComments = $this->postsModel->deletePostComments($id);
        $deletePostTags = $this->postsModel->deletePostTags($id);


        $isDeletePost = $this->postsModel->deletePost($id);

        if ($isDeletePost) {
            $this->addInfoMessage('Post delete successfully!');
        }else {
            $this->addErrorMessage("Error delete post!");
        }

        $this->redirectToUrl('/posts');
    }

    public function deleteComment($id){
        if (!$this->auth->isAdmin() && !$this->auth->isLogged()) {
            $this->redirectToUrl('/login');
        }

        $deletePostComments = $this->postsModel->deleteComment($id);

        if ($deletePostComments) {
            $this->addInfoMessage('Comment delete successfully!');
        }else {
            $this->addErrorMessage("Error delete Comment!");
        }

        $this->redirectToUrl('/posts');
    }

    public function byDays($days) {
        if (!is_numeric($days) || $days > 365) {
            $this->addErrorMessage('Page not found!');
            $this->redirectToUrl('/');
        }

        $date = date_create(date(''));
        date_sub($date, date_interval_create_from_date_string("$days days"));
        $dateAsString = date_format($date, 'Y-m-d H:i:s');
        $this->index($dateAsString, null);
    }

    private function validatePostFormData() {
        $rules = [
            'required' => [
                ['title'],
                ['text'],
                ['tag1']
            ],
            'lengthMin' => [
                ['title', 5],
                ['text', 5],
                ['tag1', 2],
                ['tag2', 2],
                ['tag3', 2],
                ['tag4', 2],
                ['tag5', 2]
            ],
            'lengthMax' => [
                ['title', 100],
                ['text', 500],
                ['tag1', 30],
                ['tag2', 30],
                ['tag3', 30],
                ['tag4', 30],
                ['tag5', 30]
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

    private function validateCommentFormData() {
        $rules = [
            'required' => [
                ['author'],
                ['text']
            ],
            'lengthMin' => [
                ['author', 3],
                ['text', 5]
            ],
            'lengthMax' => [
                ['author', 20],
                ['text', 500]
            ],
            'slug' => [
                ['author']
            ],
            'email' => [
                ['email']
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
                $tags[] = trim($value);
            }
        }

        $data['tags'] = $tags;
        return $data;
    }
}