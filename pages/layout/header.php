<?php session_start() ?>
<?php date_default_timezone_set('Asia/Jakarta'); ?>
<?php require(__DIR__ . '/../../function/route.php'); ?>
<?php $route = new Route() ?>
<?php if (!isset($_SESSION['user'])) {
    echo "<script> window.location.href = '" . $route->getBaseURL() . '/login?pesan=refresh' . "' </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKK WEB 2024</title>
    <link rel="stylesheet" href="../../dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../dist/css/dataTables.bootstrap5.min.css">
</head>

<body>

    <!-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            var input = prompt('Passwordnya apa bang?');

            if (input === "makanyabelajardek") {
                alert("Password benar!");
            } else {
                alert("Password salah!");
                window.location.reload();
            }
        });
    </script> -->


    <div class="container mt-5 ">
        <div class="d-flex justify-content-between align-items-start rounded border p-3 ">
            <?php require(__DIR__ . '/navbar.php') ?>
        </div>

        <div class="border rounded mt-2 p-3">