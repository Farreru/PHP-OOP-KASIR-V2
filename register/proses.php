<?php
session_start();
include('../function/config.php');
$db = new Database();

$result = $db->register($_POST['nama'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['alamat'], $_POST['tipe_pengguna']);

if ($result) {
    $user = $db->query("SELECT * FROM user WHERE email LIKE ?", array($_POST['email']), true);
    $_SESSION['user'] = $user;
    echo "<script> window.location.href = '../pages/dashboard' </script>";
} else if (!$result) {
    unset($_SESSION);
    session_destroy();
    echo "<script> window.location.href = 'index.php?pesan=gagal' </script>";
}
