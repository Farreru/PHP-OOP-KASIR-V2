<?php
require('../layout/header.php');
require('class.php');
require('../../function/authAdmin.php');
$pengguna = new Pengguna();
?>

<div id="content">
    <h1>Pengguna</h1>
    <?php if (isset($_GET['pesan'])) : ?>

        <?php if ($_GET['pesan'] == 'gagal') : ?>
            <div class="alert alert-danger" role="alert">
                Pengguna gagal ditambakan!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'berhasil') : ?>
            <div class="alert alert-success" role="alert">
                Pengguna berhasil ditambahkan!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'gagal_hapus') : ?>
            <div class="alert alert-danger" role="alert">
                Pengguna gagal dihapus!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'berhasil_hapus') : ?>
            <div class="alert alert-success" role="alert">
                Pengguna berhasil dihapus!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'gagal_diubah') : ?>
            <div class="alert alert-danger" role="alert">
                Pengguna gagal diperbarui!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'berhasil_diubah') : ?>
            <div class="alert alert-success" role="alert">
                Pengguna berhasil diperbarui!
            </div>
        <?php endif; ?>

    <?php endif; ?>
    <form action="" method="post" class="row g-2">
        <div class="form-group col-lg-6">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>
        <div class="form-group col-lg-6">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control">
        </div>
        <div class="form-group">
            <label for="tipe_pengguna">Tipe Pengguna</label>
            <select name="tipe_pengguna" id="tipe_pengguna" class="form-select" required>
                <option value=""></option>
                <option value="admin">Admin</option>
                <option value="petugas">Petugas</option>
            </select>
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
                        <th>Username</th>
                        <th>Email</th>
                        <th>Tipe Pengguna</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($pengguna->data()) < 1) : ?>
                        <tr>
                            <td colspan="6" class="text-center">Data tidak tersedia!</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($pengguna->data() as $index => $value) : ?>
                        <tr>
                            <td><?= ($index + 1) ?></td>
                            <td><?= $value['nama'] ?></td>
                            <td><?= $value['username'] ?></td>
                            <td><?= $value['email'] ?></td>
                            <td><?= $value['tipe_pengguna'] ?></td>
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
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $tipe_pengguna = $_POST['tipe_pengguna'];

    $result = $pengguna->tambah($nama, $username, $email, $password, $alamat, $tipe_pengguna);
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

    $result = $pengguna->hapus($id);

    if ($result) {
        unset($_POST);
        echo "<script> window.location.href = '?pesan=berhasil_hapus' </script>";
    } else {
        unset($_POST);
        echo "<script> window.location.href = '?pesan=gagal_hapus' </script>";
    }
}
?>

<?php
require('../layout/footer.php');
?>

<script>
    var table = new DataTable(".table");
</script>