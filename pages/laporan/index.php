<?php
require('../layout/header.php');
require('class.php');
$laporan = new Laporan();

// if (!isset($_GET['tanggal']) && isset($_SESSION['laporan_tanggal'])) {
//     unset($_SESSION['laporan_tanggal']);
//     echo "<script> window.location.reload() </script>";
// }
?>

<div id="content">
    <h1>Laporan</h1>

    <div class="d-flex justify-content-end align-items-center">
        <form action="" method="post">
            <button tyoe="submit" name="cetak" class="btn btn-success">Cetak</button>
        </form>
    </div>

    <form action="" method="post">
        <div class="d-flex gap-1 justify-content-start align-items-center">

            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" value="<?= (isset($_GET['tanggal']) ? $_GET['tanggal'] : '') ?>" name="tanggal" id="" class="form-control">
            </div>

            <div class="form-group">
                <button type="submit" name="ganti_tanggal" class="btn btn-primary mt-4">Ganti</button>
            </div>
        </div>
    </form>

    <div class="table-responsive mt-3">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    <th>ID Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <Th>Total Bayar</Th>
                </tr>
            </thead>
            <tbody>
                <?php if (!isset($_GET['tanggal'])) : ?>
                    <?php foreach ($laporan->data() as $index => $value) : ?>
                        <tr>
                            <td><?= $index + 1  ?></td>
                            <td>KSR-<?= $value['id'] ?></td>
                            <td><?= $value['nama_pelanggan'] ?></td>
                            <td><?= $value['tanggal'] ?></td>
                            <td>Rp. <?= $value['total_harga'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php foreach ($laporan->dataPerTanggal($_GET['tanggal']) as $index => $value) : ?>
                        <tr>
                            <td><?= $index + 1  ?></td>
                            <td>KSR-<?= $value['id'] ?></td>
                            <td><?= $value['nama_pelanggan'] ?></td>
                            <td><?= $value['tanggal'] ?></td>
                            <td>Rp. <?= $value['total_harga'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php
if (isset($_POST['ganti_tanggal'])) {
    $tanggal = $_POST['tanggal'];
    $_SESSION['laporan_tanggal'] = $tanggal;

    if (isset($tanggal) && empty($tanggal)) {
        echo "<script> window.location.href= '?'; </script>";
    } else {
        echo "<script> window.location.href = '?tanggal=" . $tanggal . "' </script>";
        exit;
    }
}

if (isset($_POST['cetak'])) {
    if (isset($_GET['tanggal'])) {
        echo "<script> window.location.href = 'cetak.php?tanggal=" . $_GET['tanggal'] . "' </script>";
    } else {
        echo "<script> window.location.href = 'cetak.php' </script>";
    }
}

?>

<?php
require('../layout/footer.php');
?>