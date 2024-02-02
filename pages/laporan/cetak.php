<?php
require('class.php');
$laporan = new Laporan();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN PENJUALAN KASIR</title>
    <link rel="stylesheet" href="../../dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-4">
        <h1 class="text-center p-4">Laporan Penjualan Kasir</h1>
        <table id="data-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>ID TRANSAKSI</th>
                    <th>TANGGAL DAN WAKTU</th>
                    <th>BIAYA</th>
                </tr>
            </thead>
            <tbody id="laporan-list">
                <?php foreach ($laporan->dataPerTanggal((isset($_GET['tanggal'])) ? $_GET['tanggal'] : "") as $index => $value) : ?>
                    <tr>
                        <td><?= ($index + 1) ?></td>
                        <td>KSR-<?= $value['id'] ?></td>
                        <td><?= $value['tanggal'] ?></td>
                        <td data-harga-total-transaksi="<?= $value['total_harga'] ?>"><?= 'Rp ' . number_format($value['total_harga'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td class="fw-bold">TOTAL</td>
                    <td></td>
                    <td></td>
                    <td class="fw-bold" id="total-laporan-text">Rp.</td>
                </tr>
            </tbody>
        </table>

    </div>

    <script src="../../dist/js/jquery-3.7.0.js"></script>

    <script>
        $(document).ready(function() {
            var totalHarga = 0;
            $('#laporan-list td[data-harga-total-transaksi]').each(function() {
                var subtotalText = $(this).data('harga-total-transaksi');
                totalHarga += parseInt(subtotalText);
            });

            const formattedNumber = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(totalHarga);

            $('#total-laporan-text').text(formattedNumber);

            window.print();
        });
    </script>

</body>

</html>