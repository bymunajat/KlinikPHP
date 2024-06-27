<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../../login/index.php'</script>";
    exit();
}

$ambil = $koneksi->query("SELECT * FROM tb_dokter WHERE id_dokter='$_GET[id_dokter]'");
$pecah = $ambil->fetch_assoc();

$koneksi->query("DELETE FROM tb_dokter WHERE id_dokter='$_GET[id_dokter]'");

echo "<script>alert('Data Dokter Terhapus!');</script>";
echo "<script>location='dokter.php'</script>";

?>