<?php

abstract class BaseController {
    protected $controller;
    protected $action;
    protected $layout = DEFAULT_LAYOUT;
    protected $viewBag = [];
    protected $viewRendered = false;

    public function __construct($controller, $action) {
        $this->controller = $controller;
        $this->action = $action;
        $this->onInit();
    }

    public function __get($name) {
        // Properties come from $this->viewBag
        if (isset($this->viewBag[$name])) {
            return $this->viewBag[$name];
        }
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }

    public function __set($name, $value) {
        // Non-existing properties are stored in $this->viewBag
        $this->viewBag[$name] = $value;
    }

    protected function onInit() {
        // Override this function to initialize the controller
    }

    public function index() {
        $this->renderView();
    }

    public function renderView($viewName = null, $isPartial = false) {
        if (!$this->viewRendered) {
            if ($viewName == null) {
                $viewName = $this->action;
            }
            if (!$isPartial) {
                include_once('views/layouts/' . $this->layout . '/header.php');
            }
            include_once('views/' . $this->controller . '/' . $viewName . '.php');
            if (!$isPartial) {
                include_once('views/layouts/' . $this->layout . '/footer.php');
            }
            $this->viewRendered = true;
        }
    }

    protected function redirect($controller = null, $action = null, $params = []) {
        if ($controller == null) {
            $controller = $this->controller;
        }
        $url = "/$controller/$action";
        $paramsUrlEncoded = array_map('urlencode', $params);
        $paramsJoined = implode('/', $paramsUrlEncoded);
        if ($paramsJoined != '') {
            $url = $url . '/' . $paramsJoined;
        }
        header("Location: $url");
        die;
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    protected function addErrorMessage($errorMsg) {
        if (!isset($_SESSION['errorMessages'])) {
            $_SESSION['errorMessages'] = [];
        }
        array_push($_SESSION['errorMessages'], $errorMsg);
    }

    protected function addInfoMessage($infoMsg) {
        if (!isset($_SESSION['infoMessages'])) {
            $_SESSION['infoMessages'] = [];
        }
        array_push($_SESSION['infoMessages'], $infoMsg);
    }

    protected function isLoggedIn() {
        return isset($_SESSION['username']);
    }

    protected function isAdmin() {
        return isset($_SESSION['isAdmin']);
    }

    protected function authorize() {
        if (! $this->isLoggedIn()) {
            $this->redirect("users", "login");
        }
    }

    protected function authorizeAdmin() {
        if (! $this->isAdmin()) {
            die('Administrator account is required!');
        }
    }
}
