<?php
if ($_SESSION['user']['tipe_pengguna'] === 'admin') {
    return true;
} else {
    echo "<script> window.location.href = '" . $route->getBaseURL() . "/pages/dashboard' </script>";
    exit;
}
