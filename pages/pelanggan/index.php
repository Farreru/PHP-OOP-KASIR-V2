<?php
require('../layout/header.php');
require('class.php');
$pelanggan = new Pelanggan();
?>

<div id="content">
    <h1>Pelanggan</h1>
    <?php if (isset($_GET['pesan'])) : ?>

        <?php if ($_GET['pesan'] == 'gagal') : ?>
            <div class="alert alert-danger" role="alert">
                Pelanggan gagal ditambakan!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'berhasil') : ?>
            <div class="alert alert-success" role="alert">
                Pelanggan berhasil ditambahkan!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'gagal_hapus') : ?>
            <div class="alert alert-danger" role="alert">
                Pelanggan gagal dihapus, Pelanggan masih terkait dengan data Penjualan!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'berhasil_hapus') : ?>
            <div class="alert alert-success" role="alert">
                Pelanggan berhasil dihapus!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'gagal_diubah') : ?>
            <div class="alert alert-danger" role="alert">
                Pelanggan gagal diperbarui!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'berhasil_diubah') : ?>
            <div class="alert alert-success" role="alert">
                Pelanggan berhasil diperbarui!
            </div>
        <?php endif; ?>

    <?php endif; ?>
    <form action="" method="post" class="row g-2">
        <div class="form-group col-lg-12">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>
        <div class="form-group col-lg-12">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" class="form-control" id="alamat"></textarea>
        </div>
        <div class="form-group col-lg-12">
            <label for="no_telp">No Telp</label>
            <input type="number" name="no_telp" id="no_telp" class="form-control" required>
        </div>
        <div class="form-group col-lg-12">
            <button type="submit" name="simpan" class="btn w-100 btn-primary">Simpan</button>
        </div>
    </form>

    <hr>

    <div class="py-2">
        <div class="table-responsive">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No Telp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($pelanggan->data()) < 1) : ?>
                        <tr>
                            <td colspan="6" class="text-center">Data tidak tersedia!</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($pelanggan->data() as $index => $value) : ?>
                        <tr id="tr-<?= $value['id'] ?>">
                            <td><?= ($index + 1) ?></td>
                            <td><?= $value['nama'] ?></td>
                            <td><?= $value['alamat'] ?></td>
                            <td><?= $value['no_telp'] ?></td>
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
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];

    $result = $pelanggan->tambah($nama, $alamat, $no_telp);
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

    $result = $pelanggan->hapus($id);

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
    var table = new DataTable('#table');

    <?php if (isset($_GET['id'])) : ?>
        var rowIdToFocus = <?= $_GET['id'] ?>;

        $('#tr-' + rowIdToFocus).addClass('selected');
    <?php endif; ?>
</script>