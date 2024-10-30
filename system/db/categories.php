<?php
class Categories extends Database {
    function getCategories() {
        $result = $this->set_query('SELECT * FROM categories')->load_rows();
        $this->disconnect();
        return $result;
    }

    function getCategory($id) {
        $result = $this->set_query('SELECT * FROM categories WHERE cid = ?')->load_row([$id]);
        $this->disconnect();
        return $result;
    }
}