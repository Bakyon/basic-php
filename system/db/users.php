<?php
class users extends database {
    function login($username, $password) {
        $result = $this->set_query('SELECT * FROM users WHERE username = ? and password = ? and status != 2')->load_row([$username, $password]);
        $this->disconnect();
        return $result;
    }

    function getAllUsers() {
        $result = $this->set_query('SELECT * FROM users where status != 2')->load_rows([]);
        $this->disconnect();
        return $result;
    }

    function getUserById($id) {
        $result = $this->set_query('SELECT * FROM users WHERE uid = ? and status != 2')->load_row([$id]);
        $this->disconnect();
        return $result;
    }

    function getUserByUsername($username) {
        $result = $this->set_query('SELECT * FROM users WHERE username = ? and status != 2')->load_row([$username]);
        $this->disconnect();
        return $result;
    }

    function getUserByPhone($phone) {
        $result = $this->set_query('SELECT * FROM users WHERE phone = ? and status != 2')->load_row([$phone]);
        $this->disconnect();
        return $result;
    }

    function addUser($username, $password, $alias, $phone, $address, $avatar, $about_me, $status) {
        $exist_user = $this->set_query('SELECT * FROM users WHERE username = ?')->load_row([$username]);
        $exist_phone = $this->set_query('SELECT * FROM users WHERE phone = ?')->load_row([$phone]);
        if ($exist_user or  $exist_phone) {
            return false;
        }
        try {
            $result = $this->set_query('INSERT INTO users(username, password, alias, phone, address, avatar, about_me, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')->save([$username, $password, $alias, $phone, $address, $avatar, $about_me, $status]);
            $this->disconnect();
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function activeUser($username) {
        $result = $this->set_query('UPDATE users SET status = 1 WHERE username = ?')->load_row([$username]);
        $this->disconnect();
        return $result;
    }

    function deactiveUser($username) {
        $result = $this->set_query('UPDATE users SET status = 0 WHERE username = ?')->load_row([$username]);
        $this->disconnect();
        return $result;
    }

    function setAvatar($username, $name) {
        $this->set_query('UPDATE users SET avatar = ? WHERE username = ?')->load_row([$name, $username]);
        $this->disconnect();
    }

    function unsetAvatar($username) {
        $this->setAvatar($username, 'no-avatar.png');
    }

    function updateInfo($username, $alias, $phone, $address, $about_me) {
        $result= $this->set_query('UPDATE users SET alias = ? , phone = ? , address = ? , about_me = ? WHERE username = ?')->save([$alias, $phone, $address, $about_me, $username]);
        $this->disconnect();
        return $result;
    }

    function updatePassword($username, $password) {
        $result = $this->set_query('UPDATE users SET password = ? WHERE username = ?')->save([$password, $username]);
        $this->disconnect();
        return $result;
    }

    function remove($username) {
        $result = $this->set_query('UPDATE users SET status = 2 WHERE username = ?')->save([$username]);
        $this->disconnect();
        return $result;
    }
}