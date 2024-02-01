<?php
require('../layout/header.php');
require('class.php');
$pelanggan = new Pelanggan();
?>

<div id="content">
    <h1>Edit Pelanggan</h1>

    <form action="" method="post" class="row g-2">
        <?php foreach ($pelanggan->show($_GET['id']) as $value) : ?>
            <div class="form-group col-lg-12">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" value="<?= $value['nama'] ?>" class="form-control" required>
            </div>
            <div class="form-group col-lg-12">
                <label for="harga">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control"><?= $value['alamat'] ?></textarea>
            </div>
            <div class="form-group col-lg-12">
                <label for="no_telp">No Telp</label>
                <input type="number" name="no_telp" id="no_telp" value="<?= $value['no_telp'] ?>" class="form-control" required>
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
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];

    $result = $pelanggan->update($id, $nama, $alamat, $no_telp);
    if ($result) {
        unset($_POST);
        echo "<script> window.location.href = '" . $route->getBaseUrl() . "/pages/pelanggan/?pesan=berhasil_diubah' </script>";
    } else {
        unset($_POST);
        echo "<script> window.location.href = '" . $route->getBaseUrl() . "/pages/pelanggan/?pesan=gagal_diubah' </script>";
    }
}

?>

<?php
require('../layout/footer.php');
?>