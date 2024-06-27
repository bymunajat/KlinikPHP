<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../../login/index.php'</script>";
    exit();
}

$ambil = $koneksi->query("SELECT * FROM tb_pasien WHERE id_pasien='$_GET[id_pasien]'");
$pecah = $ambil->fetch_assoc();

$koneksi->query("DELETE FROM tb_pasien WHERE id_pasien='$_GET[id_pasien]'");

echo "<script>alert('Data Pasien Terhapus!');</script>";
echo "<script>location='pasien.php'</script>";

?>