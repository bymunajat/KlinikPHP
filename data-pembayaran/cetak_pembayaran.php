<?php
include "../koneksi.php";

?>

<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan Pembayaran</title>
    <style>
        .content img {
            width: 105px;
            height: 105px;
            float: left;
            margin-right: 10px;
        }

        .content p {
            text-align: left;
            margin-left: 20px;
        }

        .content h2 {
            text-align: left;
            margin-left: 5px;
        }

        .content h4 {
            text-align: left;
            margin-left: 5px;
        }
    </style>
</head>

<body>
    <div class="content">
        <table border="0" width="950">
            <tr>
                <td>
                    <img src="../assets/img/logo.png">
                    <p>
                        <span style="font-size: 16px; font-weight: bold;">Poliklinik Rhema Delapan </span><br>
                        <span style="font-size: 13px;">Jl. Semeru, Telp : (123) 9876543</span><br>
                        <span style="font-size: 12px;">E-mail: support@rhemadelapan.com</span>
                    </p>
                </td>
            </tr>
        </table>
    </div>


    <table class="tabel" colspan="11" border="1" width="950" style="border: 1px solid black; border-collapse: collapse;">
        <tr>
            <th>No</th>
            <th>Kode Pembayaran</th>
            <th>Nama Pasien</th>
            <th>Tagihan</th>
            <th>Bayar</th>
            <th>Kembalian</th>
            <th>Tanggal</th>
        </tr>
        <?php
        $nomer = 1;
        $tanggal_1 = $_POST['tanggal_1'];
        $tanggal_2 = $_POST['tanggal_2'];
        $cetak = "SELECT * FROM tb_pembayaran WHERE (tgl_pembayaran BETWEEN '$tanggal_1' AND '$tanggal_2');";
        $sql  = mysqli_query($koneksi, $cetak);
        while ($data = mysqli_fetch_array($sql)) {
        ?>
            <tr>
                <th><?php echo $nomer++; ?></th>
                <td><?php echo $data['kd_pembayaran']; ?></td>
                <td><?php echo $data['nama_pasien']; ?></td>
                <td><?php echo 'Rp. ' . number_format($data['total_pembayaran']); ?></td>
                <td><?php echo 'Rp. ' . number_format($data['jumlah_bayar']); ?></td>
                <td><?php echo 'Rp. ' . number_format($data['kembalian']); ?></td>
                <td><?php echo $data['tgl_pembayaran']; ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
    <script type="text/javascript">
        window.print();
    </script>
</body>

</html>