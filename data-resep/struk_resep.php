<?php
include "../koneksi.php";

$kode = $_GET["kd_resep"];

$ambil = $koneksi->query("SELECT * FROM tb_resep a
            JOIN tb_pemeriksaan b ON a.id_pemeriksaan = b.id_pemeriksaan
            JOIN tb_pendaftaran c ON b.id_pendaftaran = c.id_pendaftaran
            JOIN tb_pasien d ON c.id_pasien = d.id_pasien
            JOIN tb_dokter e ON c.id_dokter = e.id_dokter
            JOIN tb_poli f ON c.id_poli = f.id_poli WHERE kd_resep='$kode'");

function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Struk Pendaftaran</title>
    <style>
        body {
            width: 300px;
        }

        img {
            width: 120px;
            height: 120px;
            display: block;
            margin: auto;
        }

        p {
            margin-top: 0px;
            text-align: left;
            margin-bottom: 0px;
        }
    </style>
</head>

<body>
    <img src="../assets/img/logo.png">
    <p style="text-align: center;">
    <span style="font-size: 16px; font-weight: bold;">Poliklinik Rhema Delapan </span><br>
        <span style="font-size: 13px;">Jl. Semeru, Telp : (123) 9876543</span><br>
        <span style="font-size: 12px;">E-mail: support@rhemadelapan.com</span>
    </p>
    <?php while ($pecah = $ambil->fetch_assoc()) { ?>
        <p style="margin-top: 10px;">
            <span style="font-size: 15px; margin-top: 0px;">Tanggal : <?php echo tgl_indo($pecah['tgl_resep']); ?></span><br>
            <span style="font-size: 15px; margin-top: 0px;">Nama &nbsp; &nbsp; : <?php echo $pecah['nm_pasien']; ?></span><br>
            <span style="font-size: 15px; margin-top: 0px;">Poli &nbsp; &nbsp; &nbsp; &nbsp;: <?php echo $pecah['nm_poli']; ?></span><br>
        </p>
        <hr>
        <p style="font-size: 15px; margin-top: 0px; font-weight: bold; text-align: center;">Resep Obat</p>
        <hr>
        <p>=================================</p>
        <p style="font-size: 15px; margin-top: 0px;"><?php echo $pecah['nama_obt']; ?></p>
        <p>
            <span style="font-size: 13px; margin-top: 0px;"><?php echo $pecah['jumlah_obt']; ?> x </span>
            <span style="font-size: 13px; margin-top: 0px;">Rp. <?php echo number_format($pecah['harga_obt']); ?></span>
            <span style="font-size: 13px; margin-top: 0px; margin-left: 155px;">Rp. <?php echo number_format($pecah['subharga_obt']); ?></span>
        </p>
        <p>=================================</p>
        <p>
            <span style="font-size: 13px; margin-top: 0px;">Tarif Dokter</span>
            <span style="font-size: 13px; margin-top: 0px; margin-left: 160px;">Rp. <?php echo number_format($pecah['tarif_dkt']); ?></span>
        </p>
        <p>=================================</p>
        <hr>
        <p>
            <span style="font-size: 13px; margin-top: 0px;">TOTAL </span>
            <span style="font-size: 13px; margin-top: 0px; margin-left: 185px;">Rp. <?php echo number_format($pecah['total']); ?></span>
        </p>
        <hr>

    <?php } ?>

    <script type="text/javascript">
        window.print();
    </script>
</body>

</html>