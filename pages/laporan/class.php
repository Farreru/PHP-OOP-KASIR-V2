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
        $query = $this->db->query("SELECT * FROM penjualan", []);

        $rows = [];

        while ($row = $query->fetch(2)) {
            $rows[] = $row;
        }

        if ($query) {
            return $rows;
        }

        return false;
    }

    public function dataPerTanggal($tanggal)
    {
        $query = $this->db->query("SELECT * FROM penjualan WHERE DATE(tanggal) = ?", [$tanggal]);

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
