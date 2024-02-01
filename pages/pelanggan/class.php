<?php
require('../../function/config.php');

class Pelanggan
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function data()
    {
        $result = $this->db->query("SELECT * FROM pelanggan", []);

        $rows = [];
        while ($row = $result->fetch(2)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function tambah($nama, $alamat, $no_telp)
    {

        $query = $this->db->query(
            "INSERT INTO pelanggan (nama, alamat, no_telp) VALUES (?,?,?)",
            [$nama, $alamat, $no_telp]
        );

        if ($query) {
            return true;
        }

        return false;
    }

    public function hapus($id)
    {
        try {
            $query = $this->db->query(
                "DELETE FROM pelanggan WHERE id LIKE ?",
                [$id]
            );

            if ($query) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                return "ERROR:CANT_DELETE";
            } else {
                return "Gagal: " . $e->getMessage();
            }
        }
    }


    public function show($id)
    {
        $query = $this->db->query(
            "SELECT * FROM pelanggan WHERE id LIKE ?",
            [$id]
        );

        return $query;
    }

    public function update($id, $nama, $alamat, $no_telp)
    {
        $query = $this->db->query(
            "UPDATE pelanggan SET nama = ?, alamat = ?, no_telp = ? WHERE id LIKE ?",
            [$nama, $alamat, $no_telp, $id]
        );

        if ($query) {
            return true;
        }

        return false;
    }
}
