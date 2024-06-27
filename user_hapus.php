<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='login/index.php'</script>";
    exit();
}

$ambil = $koneksi->query("SELECT * FROM tb_user WHERE id_user='$_GET[id_user]'");
$pecah = $ambil->fetch_assoc();

$koneksi->query("DELETE FROM tb_user WHERE id_user='$_GET[id_user]'");

echo "<script>alert('Data User Terhapus!');</script>";
echo "<script>location='user.php'</script>";

?>