<?php
require('../layout/header.php');
require('class.php');
$dashboard = new Dashboard();
?>

<div id="content">
    <h1>Beranda</h1>
    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row g-1">
                        Data Pengguna
                        <h3> <?= $dashboard->JumlahPengguna() ?> </h3>
                        <a href="<?= $route->getBaseURL() ?>/pages/pengguna" class="btn btn-outline-primary btn-sm">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row g-1">
                        Data Produk
                        <h3> <?= $dashboard->JumlahProduk() ?> </h3>
                        <a href="<?= $route->getBaseURL() ?>/pages/produk" class="btn btn-outline-primary btn-sm">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row g-1">
                        Data Penjualan
                        <h3> <?= $dashboard->JumlahPenjualan() ?> </h3>
                        <a href="<?= $route->getBaseURL() ?>/pages/penjualan" class="btn btn-outline-primary btn-sm">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row g-1">
                        Data Pelanggan
                        <h3> <?= $dashboard->JumlahPelanggan() ?> </h3>
                        <a href="<?= $route->getBaseURL() ?>/pages/pelanggan" class="btn btn-outline-primary btn-sm">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row g-1">
                        Total Penjualan (Hari ini)
                        <h3> <?= $dashboard->JumlahTotalPenjualanHariIni() ?> </h3>
                        <button class="btn btn-outline-primary btn-sm">Selengkapnya</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
require('../layout/footer.php');
?>