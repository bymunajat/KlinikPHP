<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../login/index.php'</script>";
    exit();
}

$ambil = $koneksi->query("SELECT * FROM tb_pendaftaran WHERE id_pendaftaran='$_GET[id_pendaftaran]'");
$pecah = $ambil->fetch_assoc();

$koneksi->query("UPDATE tb_pendaftaran SET status='2' WHERE id_pendaftaran='$_GET[id_pendaftaran]'");

echo "<script>alert('Data Dibatalkan!');</script>";
echo "<script>location='pendaftaran.php'</script>";

?>