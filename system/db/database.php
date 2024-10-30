<?php
defined('BASE_URL') OR exit('Access denied !!!');

/**
 * Database class to directly connect and get data from server
 */
class database {
    var $sql, $pdo, $statement;

    function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=".HOST.";dbname=".DBNAME."; port=".PORT, USER, PASS);
            // if exist font errors
//            $this->pdo->query("SET NAMES utf8");
        } catch (PDOException $e) {
            exit("Database connection failed: " . $e->getMessage());
        }
    }

    function set_query($sql)
    {
        $this->sql = $sql;
        return $this;
    }

    private function exec($params = []) {
        $this->statement = $this->pdo->prepare($this->sql);
        $this->statement->execute($params);
        return $this->statement;
    }

    function load_row($params = [])
    {
        try {
            return $this->exec($params)->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "false";
            exit("Query execution failed: " . $e->getMessage());
        }
    }

    function load_rows($params = [])
    {
        try {
            return $this->exec($params)->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            exit("Query execution failed: " . $e->getMessage());
        }
    }

    function save($params = [])
    {
        try {
            return $this->exec($params);
        } catch (PDOException $e) {
            exit("Query execution failed: " . $e->getMessage());
        }
    }

    function disconnect() {
        $this->pdo = $this->statement = null;
    }
}