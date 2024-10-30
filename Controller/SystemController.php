<?php
class SystemController extends Controller {
    function index() {
        $this->show('View/system/homepage');
    }
    function contact() {
        $this->show('View/system/contact');
    }
    function rules() {
        $this->show('View/system/rules');
    }
}