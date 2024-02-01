<?php
require('../../function/config.php');

class Pengguna
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function data()
    {
        $result = $this->db->query("SELECT * FROM user", []);

        $rows = [];
        while ($row = $result->fetch(2)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function tambah($nama, $username, $email, $password, $alamat, $tipe_pengguna)
    {
        $password = password_hash($password, PASSWORD_BCRYPT);

        $query = $this->db->query(
            "INSERT INTO user (nama,username,email, password, alamat, tipe_pengguna) VALUES (?,?,?,?,?,?)",
            [$nama, $username, $email, $password, $alamat, $tipe_pengguna]
        );

        if ($query) {
            return true;
        }

        return false;
    }

    public function hapus($id)
    {
        $query = $this->db->query(
            "DELETE FROM user WHERE id LIKE ?",
            [$id]
        );

        if ($query) {
            return true;
        }

        return false;
    }

    public function show($id)
    {
        $query = $this->db->query(
            "SELECT * FROM user WHERE id LIKE ?",
            [$id]
        );

        return $query;
    }

    public function update($id, $name, $username, $email, $password, $alamat, $tipe_pengguna, $password_status = false)
    {
        if ($password_status) {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $query = $this->db->query(
                "UPDATE user SET nama = ?, username = ?, email = ?, alamat = ?, tipe_pengguna = ?, password = ? WHERE id LIKE ?",
                [$name, $username, $email, $alamat, $tipe_pengguna, $password, $id]
            );
        } else {
            $query = $this->db->query(
                "UPDATE user SET nama = ?, username = ?, email = ?, alamat = ?, tipe_pengguna = ? WHERE id LIKE ?",
                [$name, $username, $email, $alamat, $tipe_pengguna, $id]
            );
        }

        if ($query) {
            return true;
        }

        return false;
    }
}
