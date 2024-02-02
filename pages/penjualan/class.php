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
            $productData = $this->db->query("SELECT * FROM produk WHERE id = ?", [$value], true);

            if ($productData) {
                $newStock = $productData['stok'] - $jumlah[$index];

                $this->db->query("UPDATE produk SET stok = ? WHERE id = ?", [$newStock, $value]);

                $sql = "INSERT INTO detail_penjualan (id_penjualan, id_produk, jumlah, sub_total) VALUES (?, ?, ?, ?)";

                try {
                    $this->db->query($sql, [$id_penjualan, $value, $jumlah[$index], $subtotal[$index]]);
                } catch (\PDOException $e) {
                    $status = $e;
                    break;
                }
            } else {
                $status = false;
                break;
            }
        }

        if ($status) {
            $this->db->query("UPDATE penjualan SET total_harga = ? WHERE id = ?", [$totalharga, $id_penjualan]);
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

    public function simpan($id_pelanggan, $tanggal, $totalharga = 0)
    {
        $sql = "INSERT INTO penjualan (id_pelanggan, tanggal, total_harga) VALUES (?, ?, ?)";
        $result = $this->db->query($sql, [$id_pelanggan, $tanggal, $totalharga]);

        if ($result) {
            return true;
        }

        return false;
    }

    public function hapus($id)
    {
        try {
            $getDetail = $this->db->query("SELECT * FROM detail_penjualan WHERE id_penjualan LIKE ?", [$id]);

            $rowsDetail = [];
            $produkIds = [];
            $jumlahs = [];

            while ($row = $getDetail->fetch(2)) {
                $rowsDetail[] = $row;
                $produkIds[] = $row['id_produk'];
                $jumlahs[] = $row['jumlah'];
            }

            $deleteDetail = $this->db->query("DELETE FROM detail_penjualan WHERE id_penjualan LIKE ?", [$id]);

            if (!$deleteDetail) {
                return false;
            }

            foreach ($produkIds as $index => $produkId) {
                $getProdukDetail = $this->db->query("SELECT * FROM produk WHERE id LIKE ?", [$produkId], true);
                $getCurrentProdukStok = $getProdukDetail['stok'];

                $newStok = $getCurrentProdukStok + $jumlahs[$index];

                $updateStok = $this->db->query("UPDATE produk SET stok = ? WHERE id LIKE ?", [$newStok, $produkId]);

                if (!$updateStok) {
                    return false;
                }
            }

            $deletePenjualan = $this->db->query("DELETE FROM penjualan WHERE id LIKE ?", [$id]);

            if ($deletePenjualan) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
}
