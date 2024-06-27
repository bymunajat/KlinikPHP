<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../../login/index.php'</script>";
    exit();
}

$ambil = $koneksi->query("SELECT * FROM tb_obat WHERE id_obat='$_GET[id_obat]'");
$pecah = $ambil->fetch_assoc();

$koneksi->query("DELETE FROM tb_obat WHERE id_obat='$_GET[id_obat]'");

echo "<script>alert('Data Obat Terhapus!');</script>";
echo "<script>location='obat.php'</script>";

?>