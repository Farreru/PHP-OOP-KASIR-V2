<?php
session_start();
include('../function/config.php');
$db = new Database();

$result = $db->login($_POST['email'], $_POST['password']);

if ($result === "OK:LOGGED") {
    $user = $db->query("SELECT * FROM user WHERE email LIKE ?", array($_POST['email']), true);
    $_SESSION['user'] = $user;
    echo "<script> window.location.href = '../pages/dashboard' </script>";
} else if ($result === "ERROR:EMAIL_OR_PASS_NOT_VALID") {
    unset($_SESSION);
    session_destroy();
    echo "<script> window.location.href = 'index.php?pesan=gagal' </script>";
}
