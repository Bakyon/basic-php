<?php
class auctions extends Database {
    function update() {
        $finished = $this->set_query('SELECT aid, pid, current_bid_id, current_bid_price FROM auctions WHERE status = 1 and end_at < NOW() and current_bid_id != 0')->load_rows();
        foreach ($finished as $row) {
            (new prods())->setStatus($row-> pid, 3);
            $seller = (new prods())->getProductById($row->pid)->owner;
            $this->set_query('INSERT INTO transactions(seller_id, bid_winner_id, bid_price, aid, status) VALUES(?, ?, ?, ?, ?, 0)')->save([$seller, $row->current_bid_id, $row->current_bid_price, $row->aid]);
            (new prods())->setOwner($row->pid, $row->current_bid_id);
        }
        $this->set_query('UPDATE auctions SET status = 0 WHERE status = 1 and end_at < NOW()')->save();
    }
    function getAll() {
        $result = $this->set_query('SELECT * FROM auctions')->load_rows();
        $this->disconnect();
        return $result;
    }

    function getAuctionById($id) {
        $result = $this->set_query('SELECT * FROM auctions WHERE aid = ?')->load_row([$id]);
        $this->disconnect();
        return $result;
    }

    //aid	pid     step    $min_price	$max_price	current_bid_price	current_bid_id	$start_at	$end_at	$status
    function postToAuction($pid, $step, $min_price, $max_price, $period) {
        $start = time();
        $end = $start + $period * 3600;
        $this->set_query('INSERT INTO auctions(pid, step, min_price, max_price, current_bid_price, currend_bid_id, start_at, end_at, status) VALUES(?, ?, ?, ?, 0, 0, ?, ?, 1) ')->save([$pid, $step, $min_price, $max_price, $start, $end]);
        $result = $this->pdo->lastInsertId();
        $this->disconnect();
        return $result;
    }

    function updateBidder($aid, $uid, $price) {

    }
}