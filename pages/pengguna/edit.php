<?php
require('../layout/header.php');
require('class.php');
require('../../function/authAdmin.php');
$pengguna = new Pengguna();
?>

<div id="content">
    <h1>Edit Pengguna</h1>
    <form action="" method="post" class="row g-2">
        <?php foreach ($pengguna->show($_GET['id']) as $value) : ?>
            <div class="form-group col-lg-6">
                <label for="nama">Nama</label>
                <input type="text" name="nama" value="<?= $value['nama'] ?>" id="nama" class="form-control" required>
            </div>
            <div class="form-group col-lg-6">
                <label for="username">Username</label>
                <input type="text" value="<?= $value['username'] ?>" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" value="<?= $value['email'] ?>" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Kosongin jika tidak ada perubahan." id="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" value="<?= $value['alamat'] ?>" name="alamat" id="alamat" class="form-control">
            </div>
            <div class="form-group">
                <label for="tipe_pengguna">Tipe Pengguna</label>
                <select name="tipe_pengguna" id="tipe_pengguna" class="form-select" required>
                    <option value=""></option>
                    <option value="admin" <?= $value['tipe_pengguna'] == "admin" ? 'selected' : '' ?>>Admin</option>
                    <option value="petugas" <?= $value['tipe_pengguna'] == "petugas" ? 'selected' : '' ?>>Petugas</option>
                </select>


            </div>
        <?php endforeach; ?>
        <div class="form-group col-lg-12">
            <button type="submit" name="simpan" class="btn w-100 btn-primary">Simpan</button>
        </div>
    </form>

    <hr>


</div>

<?php
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $tipe_pengguna = $_POST['tipe_pengguna'];

    if ($password !== "") {
        $result = $pengguna->update($_GET['id'], $nama, $username, $email, $password, $alamat, $tipe_pengguna, true);
    } else {
        $result = $pengguna->update($_GET['id'], $nama, $username, $email, "", $alamat, $tipe_pengguna);
    }

    if ($result) {
        unset($_POST);
        echo "<script> window.location.href = '" . $route->getBaseUrl() . "/pages/pengguna/?pesan=berhasil_diubah' </script>";
    } else {
        unset($_POST);
        echo "<script> window.location.href = '" . $route->getBaseUrl() . "/pages/pengguna/?pesan=gagal_diubah' </script>";
    }
}

?>

<?php
require('../layout/footer.php');
?>