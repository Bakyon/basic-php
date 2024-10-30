<?php
class AuctionController extends Controller {
    function index() {
        $this->show('View/auctions/index');
    }
    function posting() {
        $pid = $_GET['pid'];
        if (!empty($_POST)) {
            $flag = true;

        }
        $this->show('View/auctions/posting');
    }
}