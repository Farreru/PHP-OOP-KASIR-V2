<?php
session_start();

if (isset($_SESSION['user'])) {
    echo "<script> window.location.href = '../pages/dashboard' </script>";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../dist/css/bootstrap.min.css">
</head>

<body>

    <div class="d-flex align-items-center justify-content-center">
        <div class="col-lg-5 col-md-7 col-sm-7" style="margin-top: 4rem;">
            <div class="card">
                <div class="card-header">
                    Register
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['pesan'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php if ($_GET['pesan'] == 'gagal') : ?>
                                Email atau Password salah!
                            <?php endif; ?>
                            <?php if ($_GET['pesan'] == 'refresh') : ?>
                                Sesi telah berakhir, silahkan login ulang!
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <form action="proses.php" method="post">
                        <div class="form-group mb-2">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="tipe_pengguna">Tipe Pengguna</label>
                            <select name="tipe_pengguna" id="tipe_pengguna" class="form-select">
                                <option value=""></option>
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="../login">Sudah punya akun.</a>
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>