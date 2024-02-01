<?php
require('../layout/header.php');
require('class.php');
$penjualan = new Penjualan();
?>

<div id="content">
    <h1>Penjualan</h1>
    <?php if (isset($_GET['pesan'])) : ?>

        <?php if ($_GET['pesan'] == 'gagal') : ?>
            <div class="alert alert-danger" role="alert">
                Transaksi gagal ditambakan!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'berhasil') : ?>
            <div class="alert alert-success" role="alert">
                Transaksi berhasil ditambahkan!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'gagal_hapus') : ?>
            <div class="alert alert-danger" role="alert">
                Transaksi gagal dihapus, Produk masih terkait dengan data Penjualan!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'berhasil_hapus') : ?>
            <div class="alert alert-success" role="alert">
                Transaksi berhasil dihapus!
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
            <label for="pelanggan">Pelanggan</label>
            <select name="pelanggan" id="pelanggan" class="form-select">
                <option value=""></option>
                <?php foreach ($penjualan->dataPelanggan() as $value) : ?>
                    <option value="<?= $value['id'] ?>"><?= $value['nama'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-lg-6">
            <label for="tanggal">Tanggal</label>
            <input type="datetime-local" name="tanggal" id="tanggal" value="<?= date('Y-m-d H:i:s') ?>" class="form-control">
        </div>

        <div class="form-group col-lg-12">
            <button type="submit" name="simpan" class="btn w-100 btn-primary">Transaksi Baru</button>
        </div>
    </form>

    <hr>

    <div class="py-2">
        <div class="table-responsive">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID Penjualan</th>
                        <th>Tanggal</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>No Telp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($penjualan->data()) < 1) : ?>
                        <tr>
                            <td colspan="7" class="text-center">Data tidak tersedia!</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($penjualan->data() as $index => $value) : ?>
                        <tr id="<?= $value['id'] ?>">
                            <td><?= ($index + 1) ?></td>
                            <td>KSR-<?= $value['id'] ?></td>
                            <td><?= $value['tanggal'] ?></td>
                            <td><a href="<?= $route->getBaseURL() ?>/pages/pelanggan/?id=<?= $value['id_pelanggan'] ?>"><?= $value['nama_pelanggan'] ?></a></td>
                            <td><?= $value['alamat_pelanggan'] ?></td>
                            <td><?= $value['no_telp_pelanggan'] ?></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <form action="" method="post">
                                        <a href="detail.php?id=<?= $value['id'] ?>" class="btn btn-sm btn-info">Detail</a>
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
    $pelanggan = $_POST['pelanggan'];
    $tanggal = $_POST['tanggal'];

    $result = $penjualan->simpan($pelanggan, $tanggal, 0);
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

    $result = $penjualan->hapus($id);

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
    $(document).ready(function() {
        $(".table").DataTable();
    });
</script>