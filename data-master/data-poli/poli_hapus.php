<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../../login/index.php'</script>";
    exit();
}

$ambil = $koneksi->query("SELECT * FROM tb_poli WHERE id_poli='$_GET[id_poli]'");
$pecah = $ambil->fetch_assoc();

$koneksi->query("DELETE FROM tb_poli WHERE id_poli='$_GET[id_poli]'");

echo "<script>alert('Data Poli Terhapus!');</script>";
echo "<script>location='poli.php'</script>";

?>