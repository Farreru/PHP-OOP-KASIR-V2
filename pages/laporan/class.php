<?php
require("../../function/config.php");

class Laporan
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function data()
    {
        $query = $this->db->query("SELECT penjualan.*, pelanggan.nama AS nama_pelanggan FROM penjualan JOIN pelanggan ON pelanggan.id = penjualan.id_pelanggan;", []);

        $rows = [];

        while ($row = $query->fetch(2)) {
            $rows[] = $row;
        }

        if ($query) {
            return $rows;
        }

        return false;
    }

    public function dataPerTanggal($tanggal = "")
    {
        if ($tanggal == "") {
            $query = $this->db->query("SELECT penjualan.*, pelanggan.nama AS nama_pelanggan FROM penjualan JOIN pelanggan ON pelanggan.id = penjualan.id_pelanggan;", []);
        } else {
            $query = $this->db->query("SELECT penjualan.*, pelanggan.nama AS nama_pelanggan FROM penjualan JOIN pelanggan ON pelanggan.id = penjualan.id_pelanggan WHERE DATE(tanggal) = ?", [$tanggal]);
        }

        $rows = [];

        while ($row = $query->fetch(2)) {
            $rows[] = $row;
        }

        if ($query) {
            return $rows;
        }

        return false;
    }
}
