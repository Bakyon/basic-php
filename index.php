<?php
// Adding core config to web service
include 'system/config/config.php';
include 'system/libs/functions.php';
include 'Controller/Controller.php';
include 'system/db/database.php';
include 'system/db/auctions.php';

// Checking cookies once, when user first visiting web service, do nothing if cookie is checked
if (!isset($_SESSION['cookie_checked']) or !$_SESSION['cookie_checked']) {
    // Set a session flag to know if the cookie is checked
    $_SESSION['cookie_checked'] = true;

    // Checking cookie and set required values
    if (isset($_COOKIE['remember'])) {
        $_SESSION['login_status'] = 1;
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['alias'] = $_COOKIE['alias'];
        $_SESSION['avatar'] = $_COOKIE['avatar'];
    }
}

// Update auction database
(new auctions())->update();

$action = $_GET["action"] ?? 'index';
$controller_name = ($_GET["cont"] ?? 'System').'Controller';
$path = 'Controller/'.$controller_name.'.php';
if (file_exists($path)) {
    include_once $path;
    $controller = new $controller_name();
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        $controller = new Controller();
        $controller->_404();
    }
} else {
    $controller = new Controller();
    $controller->_404();
}
ob_end_flush();