<?php
require('../layout/header.php');
require('class.php');
$penjualan = new Penjualan();
?>

<div id="content">
    <h1>Detail Penjualan</h1>
    <?php if (isset($_GET['pesan'])) : ?>

        <?php if ($_GET['pesan'] == 'gagal') : ?>
            <div class="alert alert-danger" role="alert">
                Transaksi gagal disimpan!
            </div>
        <?php endif; ?>

        <?php if ($_GET['pesan'] == 'berhasil') : ?>
            <div class="alert alert-success" role="alert">
                Transaksi berhasil disimpan!
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

    <?php endif; ?>

    <table class="my-4">
        <?php $data_detail = $penjualan->show($_GET['id']) ?>
        <tr>
            <td>ID Transaksi</td>
            <td>&nbsp;:</td>
            <td>&nbsp;KSR-<?= $data_detail['id'] ?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>&nbsp;:</td>
            <td>&nbsp;<?= $data_detail['tanggal'] ?></td>
        </tr>
        <tr>
            <td>Nama Pelanggan</td>
            <td>&nbsp;:</td>
            <td>&nbsp;<?= $data_detail['nama_pelanggan'] ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>&nbsp;:</td>
            <td>&nbsp;<?= $data_detail['alamat_pelanggan'] ?></td>
        </tr>
        <tr>
            <td>No Telp</td>
            <td>&nbsp;:</td>
            <td>&nbsp;<?= $data_detail['no_telp_pelanggan'] ?></td>
        </tr>
        <tr>
            <td>Total Harga</td>
            <td>&nbsp;:</td>
            <td>&nbsp;Rp. <?= $data_detail['total_harga'] ?></td>
        </tr>
    </table>

    <div class="">
        <?php foreach ($penjualan->dataDetailPenjualan($_GET['id']) as $value) : ?>
            <div class="d-flex gap-1 my-1">
                <button class="btn btn-primary" disabled>+</button>
                <select name="produk" class="form-select" disabled>
                    <option value=""></option>
                    <option value="<?= $value['id'] ?>" selected><?= $value['nama_produk'] ?></option>
                </select>
                <input type="number" class="form-control" name="jumlah[]" min="0" value="<?= $value['jumlah'] ?>" disabled>
                <input type="number" class="form-control" readonly name="subtotal[]" value="<?= $value['sub_total'] ?>" disabled>
                <div class="d-flex gap-1">
                    <button class="btn btn-warning" disabled>Proses</button>
                    <form action="" method="post">
                        <button type="submit" name="hapus" value="<?= $value['id'] ?>" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>

        <form action="" method="post" class="" id="data-input-fill">
            <div id="data-input-detail">
                <div class="d-flex gap-1 my-1">
                    <button class="btn btn-primary" id="button-add-produk">+</button>
                    <select name="produk[]" class="form-select" id="produk-select">
                        <option value="">Pilih Produk</option>
                        <?php foreach ($penjualan->dataProduk() as $value) : ?>
                            <option id="produk-<?= $value['id'] ?>" data-stok="<?= $value['stok'] ?>" data-harga="<?= $value['harga'] ?>" value="<?= $value['id'] ?>"><?= $value['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" class="form-control" placeholder="Jumlah" name="jumlah[]" min="0">
                    <input type="number" class="form-control" value="0" name="subtotal[]" readonly>
                    <button id="button-proses-harga" data-id="<?= $value['id'] ?>" class="btn btn-warning">Proses</button>
                    <button id="button-hapus-input" class="btn btn-danger" disabled>Hapus</button>
                </div>
            </div>
            <div>
                <label for="total_harga">Total Harga</label>
                <input type="hidden" name="total_harga_penjualan" id="total_harga_penjualan">
                <input type="text" name="total_harga" id="total_harga" class="form-control">
            </div>
            <div class="form-group col-lg-12 mt-4">
                <button type="submit" name="simpan" class="btn w-100 btn-primary">Simpan</button>
            </div>
        </form>
    </div>


    <hr>


</div>

<?php
if (isset($_POST['simpan'])) {

    $produk = $_POST['produk'];
    $jumlah = $_POST['jumlah'];
    $subtotal = $_POST['subtotal'];
    $totalharga = $_POST['total_harga_penjualan'];

    $result = $penjualan->simpanDataDetail($_GET['id'], $totalharga, $produk, $jumlah, $subtotal);

    if ($result) {
        unset($_POST);
        echo "<script> window.location.href = '?pesan=berhasil&id=" . $_GET['id'] . "' </script>";
    } else {
        unset($_POST);
        echo "<script> window.location.href = '?pesan=gagal&id=" . $_GET['id'] . "' </script>";
    }
}

if (isset($_POST['hapus'])) {
    $id = $_POST['hapus'];

    $result = $penjualan->hapusProdukDetail($id);

    if ($result === "ERROR:CANT_DELETE") {
        unset($_POST);
        echo "<script> window.location.href = '?pesan=gagal_hapus&id=" . $_GET['id'] . "' </script>";
    } else if ($result) {
        unset($_POST);
        echo "<script> window.location.href = '?pesan=berhasil_hapus&id=" . $_GET['id'] . "' </script>";
    }
}
?>

<?php
require('../layout/footer.php');
?>

<script>
    // var table = new DataTable('#table');

    $(document).ready(function() {
        updateTotalHarga();
        setInterval(() => {
            updateTotalHarga()
        }, 1000);
    })

    $('body').on('click', '#button-add-produk', function(e) {
        e.preventDefault();
        var element = $('#data-input-detail');
        element.append(`
        <div class="d-flex gap-1 my-1">
                    <button class="btn btn-primary" id="button-add-produk">+</button>
                    <select name="produk[]" class="form-select" id="produk-select">
                        <option value="">Pilih Produk</option>
                        <?php foreach ($penjualan->dataProduk() as $value) : ?>
                            <option id="produk-<?= $value['id'] ?>" data-stok="<?= $value['stok'] ?>" data-harga="<?= $value['harga'] ?>" value="<?= $value['id'] ?>"><?= $value['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" class="form-control" name="jumlah[]" min="0">
                    <input type="number" class="form-control" value="0" name="subtotal[]" readonly>
                        <button id="button-proses-harga" data-id="<?= $value['id'] ?>" class="btn btn-warning">Proses</button>
                        <button id="button-hapus-input" class="btn btn-danger">Hapus</button>
                </div>
        `);
    });

    $('body').on('change', '#produk-select', function() {
        var id = $(this).val();
        var element = $(`#produk-${id}`);

        if (parseInt(element.data('stok')) === 0) {
            $(this).val("");
            return alert('Produk ini kehabisan stok!');
        }
    });

    $('body').on('click', '#button-proses-harga', function(e) {

        e.preventDefault();

        var currentRow = $(this).closest('.d-flex');

        var selectedProduk = currentRow.find('select[name="produk[]"]').val();
        var jumlah = currentRow.find('input[name="jumlah[]"]').val();
        var subtotal = currentRow.find('input[name="subtotal[]"]').val();
        var currentSubtotal = currentRow.find('input[name="subtotal[]"]');

        var stok = currentRow.find('select[name="produk[]"] option:selected').data('stok');
        var harga = currentRow.find('select[name="produk[]"] option:selected').data('harga');

        if (selectedProduk == "" || jumlah == "") {
            return false;
        }

        if (stok < jumlah) {
            return alert('Stok produk tidak cukup, silahkan ubah jumlah produk.');
        }

        console.log('harga : ' + harga);

        currentSubtotal.val((jumlah * harga));

    });

    $('body').on('click', '#button-hapus-input', function(e) {
        e.preventDefault();

        var currentRow = $(this).closest('.d-flex');
        var totalRows = $('.d-flex').length;

        if (totalRows > 1) {
            currentRow.remove();
        } else {
            return false;
        }
    });


    function updateTotalHarga() {
        var totalHarga = 0;

        $('.d-flex').each(function() {
            var subtotal = parseFloat($(this).find('input[name="subtotal[]"]').val()) || 0;
            totalHarga += subtotal;
        });

        $('#total_harga_penjualan').val(totalHarga);

        $('#total_harga').val('Rp. ' + totalHarga.toFixed(2));
    }
</script>