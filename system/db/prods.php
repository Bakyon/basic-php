<?php
class prods extends database {
    function getALl() {
        $result = $this->set_query('SELECT * FROM products')->load_rows();
        $this->disconnect();
        return $result;
    }

    function getProductById($id) {
        $result = $this->set_query('SELECT * FROM products WHERE pid = ?')->load_row([$id]);
        $this->disconnect();
        return $result;
    }

    function addProduct($name, $cid, $description, $owner, $status, $brand) {
        $this->set_query('INSERT INTO products(name, cid, description, owner, status, brand) VALUES(?, ?, ?, ?, ?, ?)')->save([$name, $cid, $description, $owner, $status, $brand]);
        $pid = $this->pdo->lastInsertId();
        $this->disconnect();
        return $pid;
    }

    function updateProduct($id, $name, $cid, $description, $brand) {
        $result = $this->set_query('UPDATE products SET name = ?, cid = ?, description = ?, brand = ? WHERE pid = ?')->save([$name, $cid, $description, $brand, $id]);
        $this->disconnect();
        return $result;
    }

    function setOwner($id, $owner) {
        $result = $this->set_query('UPDATE products SET owner = ? WHERE pid = ?')->save([$owner, $id]);
        $this->disconnect();
        return $result;
    }

    function getCategories() {
        include 'system/db/categories.php';
        return (new categories())->getCategories();
    }

    function getProdsByStatus($status) {
        $result = $this->set_query('SELECT * FROM products WHERE status = ?')->load_rows([$status]);
        $this->disconnect();
        return $result;
    }

    function setImages($pid, $image) {
        $result = $this->set_query('UPDATE products SET images = ? WHERE pid = ?')->save([$image, $pid]);
        $this->disconnect();
        return $result;
    }

    function getProductByUserID($uid, $status = -1) {
        if ($status == -1)
            $result = $this->set_query('SELECT * FROM products WHERE owner = ? and status != 0')->load_rows([$uid]);
        else
            $result = $this->set_query('SELECT * FROM products WHERE owner = ? and status = ?')->load_rows([$uid, $status]);
        $this->disconnect();
        return $result;
    }

    function setStatus($id, $status) {
        $result = $this->set_query('UPDATE products SET status = ? WHERE pid = ?')->save([$status, $id]);
        $this->disconnect();
        return $result;
    }

    function checkOwner($pid, $username) {
        $result = $this->set_query('SELECT prod.* FROM (SELECT * FROM products WHERE pid = ?) AS prod INNER JOIN (SELECT * FROM users WHERE username = ?) AS user ON owner = uid')->load_row([$pid, $username]);
        $this->disconnect();
        return $result;
    }
}