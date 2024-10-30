<?php

class Controller {
    function show($view, $layout = 'SharedLayout') {
        include 'View/'.$layout.'.php';
    }
    function _404() {
        include 'View/system/404.php';
    }
}