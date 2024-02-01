<?php
require('../../function/config.php');

class Produk
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function data()
    {
        $result = $this->db->query("SELECT * FROM produk", []);

        $rows = [];
        while ($row = $result->fetch(2)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function tambah($nama, $harga, $stok)
    {

        $query = $this->db->query(
            "INSERT INTO produk (nama, harga, stok) VALUES (?,?,?)",
            [$nama, $harga, $stok]
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
                "DELETE FROM produk WHERE id LIKE ?",
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
            "SELECT * FROM produk WHERE id LIKE ?",
            [$id]
        );

        return $query;
    }

    public function update($id, $nama, $harga, $stok)
    {
        $query = $this->db->query(
            "UPDATE produk SET nama = ?, harga = ?, stok = ? WHERE id LIKE ?",
            [$nama, $harga, $stok, $id]
        );

        if ($query) {
            return true;
        }

        return false;
    }
}
