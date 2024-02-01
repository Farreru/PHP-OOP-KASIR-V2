<?php

require('../../function/config.php');

class Dashboard
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function JumlahPengguna()
    {
        return $this->db->count('user');
    }

    public function JumlahProduk()
    {
        return $this->db->count('produk');
    }

    public function JumlahPenjualan()
    {
        return $this->db->count('penjualan');
    }

    public function JumlahPelanggan()
    {
        return $this->db->count('pelanggan');
    }

    public function JumlahTotalPenjualanHariIni()
    {
        $hari_ini = date("Y-m-d");
        return $this->db->count('penjualan', "DATE(tanggal) = '$hari_ini'");
    }
}
