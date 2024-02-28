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
        <div class="col-lg-5 col-md-5 col-sm-6" style="margin-top: 10rem;">
            <div class="card">
                <div class="card-header">
                    Login
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
                            <label for="email">Email</label>
                            <input type="email" name="email" required id="email" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="password">Password</label>
                            <input type="password" name="password" required id="password" class="form-control">
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="../register">Belum punya akun.</a>
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>