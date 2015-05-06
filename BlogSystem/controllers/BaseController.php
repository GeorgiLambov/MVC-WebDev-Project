<?php

abstract class BaseController {
    protected $controllerName;
    protected $layoutName = DEFAULT_LAYOUT;
    protected $isViewRendered = false;
    protected $isPost = false;
    protected $fieldsErrors;

    function __construct($controllerName) {
        $this->controllerName = $controllerName;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->isPost = true;
        }
        $this->fieldsErrors = array();
        $this->validator = new \Valitron\Validator($_POST);

        $this->auth = new LoginModel();
        $loggedUser = $this->auth->getLoggedUser();
        $this->loggedUser = $loggedUser;

        $this->onInit();
    }

    public function onInit() {
        // Implement initializing logic in the subclasses
    }

    public function index() {
        // Implement the default action in the subclasses
    }

    public function renderView($viewName = "Index", $includeLayout = true) {
        if (!$this->isViewRendered) {
                   $viewFileName = 'views/' . $this->controllerName
                . '/' . $viewName . '.php';
            if ($includeLayout) {
                $headerFile = 'views/layouts/' . $this->layoutName . '/header.php';
                include_once($headerFile);
            }
            include_once($viewFileName);
            if ($includeLayout) {
                $footerFile = 'views/layouts/' . $this->layoutName . '/footer.php';
                include_once($footerFile);
            }
            $this->isViewRendered = true;
        }
    }

    function makeDateInFormat($dateStr)
    {
        $date = new \DateTime($dateStr);
        return $date->format('d M y');
    }

    public function redirectToUrl($url) {
        header("Location: " . $url);
        exit();
    }

    public function redirect(
            $controllerName, $actionName = null, $params = null) {
        $url = '/' . urlencode($controllerName);
        if ($actionName != null) {
            $url .= '/' . urlencode($actionName);
        }
        if ($params != null) {
            $encodedParams = array_map($params, 'urlencode');
            $url .= implode('/', $encodedParams);
        }
        $this->redirectToUrl($url);
    }

    function addMessage($msg, $type) {
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = array();
        };
        array_push($_SESSION['messages'],
            array('text' => $msg, 'type' => $type));
    }

    function addInfoMessage($msg) {
        $this->addMessage($msg, 'info');
    }

    function addErrorMessage($msg) {
        $this->addMessage($msg, 'error');
    }

    public function makeValidation($rules) {
        $this->validator->rules($rules);
        if($this->validator->validate()) {
            return $this->validator->data();
        } else {
            $allErrors = $this->validator->errors();
            $errors = array();

            foreach ($allErrors as $key => $error) {
                $errors[$key] = implode(', ', $error);
            }

            $this->fieldsErrors = $errors;
        }
    }
}
