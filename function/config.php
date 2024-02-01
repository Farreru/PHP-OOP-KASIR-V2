<?php

class Database
{

    public function query($sql, $data, $fetch = false)
    {
        require('connection.php');
        $q = $db->prepare($sql);

        $q->execute($data);

        return $fetch ? $q->fetch(2) : $q;
    }

    public function count($table, $condition = "")
    {
        $sql = "SELECT COUNT(*) as count FROM $table";

        if ($condition !== "") {
            $sql .= " WHERE $condition";
        }

        $result = $this->query($sql, [], true);

        return $result['count'];
    }

    public function login($email, $password)
    {

        $getUserPassword = $this->query("SELECT * FROM user WHERE email LIKE ? ", array($email), true)['password'];

        if (password_verify($password, $getUserPassword)) {
            return "OK:LOGGED";
        } else {
            return "ERROR:EMAIL_OR_PASS_NOT_VALID";
        }
    }

    public function register($nama, $username, $email, $password, $alamat, $tipe_pengguna)
    {

        $password = password_hash($password, PASSWORD_BCRYPT);

        $query = $this->query(
            "INSERT INTO user (nama,username,email, password, alamat, tipe_pengguna) VALUES (?,?,?,?,?,?)",
            [$nama, $username, $email, $password, $alamat, $tipe_pengguna]
        );

        if ($query) {
            return true;
        }

        return false;
    }
}
