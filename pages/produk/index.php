<?php
require('../layout/header.php');
require('class.php');
$produk = new Produk();
?>

<div id="content">
    <h1>Produk</h1>
    <?php if (isset($_GET['pesan'])) : ?>

        <?php if ($_GET['pesan'] == 'gagal') : ?>
            <div class="alert alert-danger" role="alert">
                Produk gagal ditambakan!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'berhasil') : ?>
            <div class="alert alert-success" role="alert">
                Produk berhasil ditambahkan!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'gagal_hapus') : ?>
            <div class="alert alert-danger" role="alert">
                Produk gagal dihapus, Produk masih terkait dengan data Penjualan!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'berhasil_hapus') : ?>
            <div class="alert alert-success" role="alert">
                Produk berhasil dihapus!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'gagal_diubah') : ?>
            <div class="alert alert-danger" role="alert">
                Produk gagal diperbarui!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'berhasil_diubah') : ?>
            <div class="alert alert-success" role="alert">
                Produk berhasil diperbarui!
            </div>
        <?php endif; ?>

    <?php endif; ?>
    <form action="" method="post" class="row g-2">
        <div class="form-group col-lg-6">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>
        <div class="form-group col-lg-6">
            <label for="harga">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" required>
        </div>
        <div class="form-group col-lg-12">
            <label for="stok">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" required>
        </div>
        <div class="form-group col-lg-12">
            <button type="submit" name="simpan" class="btn w-100 btn-primary">Simpan</button>
        </div>
    </form>

    <hr>

    <div class="py-2">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($produk->data()) < 1) : ?>
                        <tr>
                            <td colspan="6" class="text-center">Data tidak tersedia!</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($produk->data() as $index => $value) : ?>
                        <tr>
                            <td><?= ($index + 1) ?></td>
                            <td><?= $value['nama'] ?></td>
                            <td><?= $value['harga'] ?></td>
                            <td><?= $value['stok'] ?></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <form action="" method="post">
                                        <a href="edit.php?id=<?= $value['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <button type="submit" name="hapus" value="<?= $value['id'] ?>" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $result = $produk->tambah($nama, $harga, $stok);
    if ($result) {
        unset($_POST);
        echo "<script> window.location.href = '?pesan=berhasil' </script>";
    } else {
        unset($_POST);
        echo "<script> window.location.href = '?pesan=gagal' </script>";
    }
}

if (isset($_POST['hapus'])) {
    $id = $_POST['hapus'];

    $result = $produk->hapus($id);

    if ($result === "ERROR:CANT_DELETE") {
        unset($_POST);
        echo "<script> window.location.href = '?pesan=gagal_hapus' </script>";
    } else if ($result) {
        unset($_POST);
        echo "<script> window.location.href = '?pesan=berhasil_hapus' </script>";
    }
}
?>

<?php
require('../layout/footer.php');
?>

<script>
    var table = new DataTable('.table');
</script>