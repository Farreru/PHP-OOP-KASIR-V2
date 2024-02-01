<?php
require('../../function/config.php');

class Penjualan
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function data()
    {
        $sql = "SELECT penjualan.*, pelanggan.nama as nama_pelanggan, pelanggan.alamat as alamat_pelanggan, pelanggan.no_telp as no_telp_pelanggan FROM penjualan JOIN pelanggan ON pelanggan.id = penjualan.id_pelanggan ORDER BY (tanggal) DESC;";
        $result = $this->db->query($sql, []);

        $rows = [];

        while ($row = $result->fetch(2)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function dataPelanggan()
    {
        $sql = "SELECT * FROM pelanggan";
        $result = $this->db->query($sql, []);

        $rows = [];

        while ($row = $result->fetch(2)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function dataProduk()
    {
        $sql = "SELECT * FROM produk";
        $result = $this->db->query($sql, []);

        $rows = [];

        while ($row = $result->fetch(2)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function show($id)
    {
        $sql = "SELECT penjualan.*, pelanggan.nama as nama_pelanggan, pelanggan.alamat as alamat_pelanggan, pelanggan.no_telp as no_telp_pelanggan FROM penjualan JOIN pelanggan ON pelanggan.id = penjualan.id_pelanggan WHERE penjualan.id = ?";
        $result = $this->db->query($sql, [$id], true);

        return $result;
    }

    public function dataDetailPenjualan($id)
    {
        $sql = "SELECT detail_penjualan.* , produk.id as id_produk, produk.nama as nama_produk FROM detail_penjualan JOIN produk on produk.id = detail_penjualan.id_produk WHERE detail_penjualan.id_penjualan = ?";
        $result = $this->db->query($sql, [$id]);

        $rows = [];

        while ($row = $result->fetch(2)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function simpanDataDetail($id_penjualan, $totalharga, $produk = [], $jumlah = [], $subtotal = [])
    {
        $status = true;
        foreach ($produk as $index => $value) {
            $sql = "INSERT INTO detail_penjualan (id_penjualan, id_produk, jumlah, sub_total) VALUES (?, ?, ?, ?)";
            try {
                $this->db->query($sql, [$id_penjualan, $value, $jumlah[$index], $subtotal[$index]]);
            } catch (\PDOException $e) {
                $status = false;
                break;
            }
        }

        if ($status) {
            $this->db->query("UPDATE penjualan SET total_harga = ? WHERE id LIKE ?", [$totalharga, $id_penjualan]);
        }

        return $status;
    }

    public function hapusProdukDetail($id)
    {
        $getDetail = $this->db->query("SELECT * FROM detail_penjualan WHERE id LIKE ?", [$id], true);
        $getProduk = $getDetail['id_produk'];
        $getJumlah = $getDetail['jumlah'];

        $getProdukDetail = $this->db->query("SELECT * FROM produk WHERE id LIKE ?", [$getProduk], true);
        $getCurrentProdukStok = $getProdukDetail['stok'];

        $newStok = ($getJumlah + $getCurrentProdukStok);

        $deleteDetailProduk = $this->db->query("DELETE FROM detail_penjualan WHERE id LIKE ?", [$id]);

        $sql = "UPDATE produk SET stok = ? WHERE id LIKE ?";

        $result = $this->db->query($sql, [$newStok, $getProduk]);

        if ($result) {
            return true;
        }

        return false;
    }
}
