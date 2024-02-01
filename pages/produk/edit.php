<?php
require('../layout/header.php');
require('class.php');
$produk = new Produk();
?>

<div id="content">
    <h1>Edit Produk</h1>

    <form action="" method="post" class="row g-2">
        <?php foreach ($produk->show($_GET['id']) as $value) : ?>
            <div class="form-group col-lg-6">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" value="<?= $value['nama'] ?>" class="form-control" required>
            </div>
            <div class="form-group col-lg-6">
                <label for="harga">Harga</label>
                <input type="number" name="harga" id="harga" value="<?= $value['harga'] ?>" class="form-control" required>
            </div>
            <div class="form-group col-lg-12">
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok" value="<?= $value['stok'] ?>" class="form-control" required>
            </div>
            <div class="form-group col-lg-12">
                <button type="submit" name="simpan" class="btn w-100 btn-primary">Simpan</button>
            </div>
        <?php endforeach; ?>
    </form>

    <hr>

</div>

<?php
if (isset($_POST['simpan'])) {
    $id = $_GET['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $result = $produk->update($id, $nama, $harga, $stok);
    if ($result) {
        unset($_POST);
        echo "<script> window.location.href = '" . $route->getBaseUrl() . "/pages/produk/?pesan=berhasil_diubah' </script>";
    } else {
        unset($_POST);
        echo "<script> window.location.href = '" . $route->getBaseUrl() . "/pages/produk/?pesan=gagal_diubah' </script>";
    }
}

?>

<?php
require('../layout/footer.php');
?>