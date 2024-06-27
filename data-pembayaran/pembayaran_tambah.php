<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../login/index.php'</script>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Poli Klinik | Kasir Pembayaran</title>
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="../assets/js/all.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand font-weight-bold text-center" href="../index.php">Poli Klinik</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-light" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="../login/logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Poli Klinik</div>
                        <?php if ($_SESSION["jabatan"] == 'admin') : ?>
                            <a class="nav-link active" href="../data-pembayaran/pembayaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                                Kasir Pembayaran
                            </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pembayaran') : ?>
                            <a class="nav-link active" href="../data-pembayaran/pembayaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                                Kasir Pembayaran
                            </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pendaftaran') : ?>
                            <a class="nav-link" href="../data-pendaftaran/pendaftaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Data Pendaftaran
                            </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pemeriksaan') : ?>
                            <a class="nav-link" href="../data-pemeriksaan/pemeriksaan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                Data Pemeriksaan
                            </a>
                            <a class="nav-link" href="../data-resep/resep.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
                                Resep Obat
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content" class="bg-white text-dark">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Pembayaran</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../index.php" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Kasir Pembayaran</li>
                        <li class="breadcrumb-item active">Pembayaran</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header font-weight-bold">
                            Kasir Pembayaran
                        </div>
                        <div class="card-body">
                            <div class="">
                                <div class="form-group row">
                                    <div class="btn-block disabled mx-4">
                                        <?php $ambil = mysqli_query($koneksi, "SELECT * FROM tb_pembayaran ORDER BY kd_pembayaran DESC LIMIT 1"); ?>
                                        <?php $data = $ambil->fetch_assoc(); ?>
                                        <label>Data Terakhir</label>
                                        <input type="text" class="form-control text-center" value="<?php echo $data['kd_pembayaran'] ?>" readonly>
                                    </div>
                                </div>
                                <form class="mx-4" method="post" class="rsp" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>Kode Pembayaran</label>
                                            <input type="text" class="form-control" name="kd_pembayaran" value="TRA-" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1">
                                            <label>ID</label>
                                            <input type="text" class="form-control" name="id_resep" id="id_resep" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Kode Resep</label>
                                            <input type="text" class="form-control" name="kd_resep" id="kd_resep" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Pasien</label>
                                            <select class="custom-select" name="nm_pasien" id="nm_pasien" onchange='dataResep(this.value)'>
                                                <option value="0" disabled selected>Pilih Pasien</option>
                                                <?php
                                                $ambil2 = $koneksi->query("SELECT * FROM tb_resep a
                                                    JOIN tb_pemeriksaan b ON a.id_pemeriksaan = b.id_pemeriksaan
                                                    JOIN tb_pendaftaran c ON b.id_pendaftaran = c.id_pendaftaran
                                                    JOIN tb_pasien d ON c.id_pasien = d.id_pasien
                                                    JOIN tb_dokter e ON c.id_dokter = e.id_dokter
                                                    JOIN tb_poli f ON c.id_poli = f.id_poli WHERE a.status_rsp = '0'");
                                                $dataArray = "var dataName = new Array();\n";

                                                ?>

                                                <?php while ($daftar = $ambil2->fetch_array()) { ?>
                                                    <option value="<?php echo $daftar['nm_pasien']; ?>">
                                                        <?php echo $daftar['nm_pasien']; ?>
                                                    </option>
                                                <?php
                                                    $dataArray .= "dataName['" . $daftar['nm_pasien'] . "'] = {
                                                        id_resep:'" . $daftar['id_resep'] . "',
                                                        tarif_dokter:'" . $daftar['tarif_dokter'] . "',
                                                        nm_dokter:'" . $daftar['nm_dokter'] . "',
                                                        nm_poli:'" . $daftar['nm_poli'] . "',
                                                        nama_obt:'" . $daftar['nama_obt'] . "',
                                                        harga_obt:'" . $daftar['harga_obt'] . "',
                                                        jumlah_obt:'" . $daftar['jumlah_obt'] . "',
                                                        subharga_obt:'" . $daftar['subharga_obt'] . "',
                                                        total:'" . $daftar['total'] . "',
                                                        kd_resep:'" . $daftar['kd_resep'] . "'
                                                    };\n";
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <div class="col-sm-5">
                                            <label>Poli</label>
                                            <input type="text" class="form-control" name="nm_poli" id="nm_poli" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label>Nama Dokter</label>
                                            <input type="text" class="form-control" name="nm_dokter" id="nm_dokter" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Tarif Dokter</label>
                                            <input type="text" class="form-control" name="tarif_dokter" id="tarif_dokter" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-5">
                                            <label>Obat</label>
                                            <input type="text" class="form-control" name="nama_obt" id="nama_obt" readonly>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Harga</label>
                                            <input type="text" class="form-control" name="harga_obt" id="harga_obt" readonly>
                                        </div>
                                        <div class="col-sm-1">
                                            <label>Jumlah</label>
                                            <input type="text" class="form-control" name="jumlah_obt" id="jumlah_obt" readonly>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Harga Obat</label>
                                            <input type="text" class="form-control" name="subharga_obt" id="subharga_obt" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>Total Pembayaran</label>
                                            <input type="text" class="form-control" name="total" id="total" onkeyup="Hitung();" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <input type="hidden" class="form-control" name="tgl_pembayaran" value="<?php echo date("Y-m-d"); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-8">
                                            <label>Bayar</label>
                                            <input type="text" class="form-control" name="jumlah_bayar" id="jumlah_bayar" onkeyup="Hitung();">
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Kembalian</label>
                                            <input type="text" class="form-control" name="kembalian" id="kembalian" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <button class="btn btn-success font-weight-bold px-3 mr-2" name="save"><i class="far fa-save"></i> Simpan</button>
                                        <a href="pembayaran.php" class="btn btn-danger font-weight-bold px-3 mr-2"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
                                    </div>
                                </form>

                                <?php
                                if (isset($_POST['save'])) {
                                    if ($_POST['id_resep'] == 0) {
                                        echo "<script>alert('Pilih Resep dengan Benar!');</script>";
                                    } else {
                                        $nama_pasien = $_POST['nm_pasien'];
                                        $total_pembayaran = $_POST['total'];

                                        $sql = "UPDATE tb_resep SET status_rsp = '1' WHERE id_resep='$_POST[id_resep]';";
                                        $sql .= "INSERT INTO tb_pembayaran (kd_pembayaran, id_resep, nama_pasien, total_pembayaran, 
                                                    jumlah_bayar, kembalian, tgl_pembayaran, status_pembayaran) 
                                                VALUES ('$_POST[kd_pembayaran]', '$_POST[id_resep]', '$nama_pasien', '$total_pembayaran', 
                                                    '$_POST[jumlah_bayar]', '$_POST[kembalian]', '$_POST[tgl_pembayaran]', '1')";

                                        $koneksi->multi_query($sql);

                                        echo "<script>alert('Data Tersimpan!');</script>";
                                        echo "<script>location='pembayaran.php'</script>";
                                    }
                                }

                                ?>

                            </div>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted font-weight-bold">Copyright &copy; Poli Klinik 2020</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/Chart.min.js"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/demo/datatables-demo.js"></script>

    <script type="text/javascript">
        $(".rsp").keyup(function() {
            var id_resep = $("#id_resep").val()
            var tarif_dokter = $("#tarif_dokter").val()
            var nm_dokter = $("#nm_dokter").val()
            var nm_poli = $("#nm_poli").val()
            var kd_resep = $("#kd_resep").val()
            var nama_obt = $("#nama_obt").val()
            var harga_obt = $("#harga_obt").val()
            var jumlah_obt = $("#jumlah_obt").val()
            var total = $("#total").val()
            var subharga_obt = $("#subharga_obt").val()

        });
    </script>

    <script type="text/javascript">
        function Hitung() {
            var total = document.getElementById('total').value;
            var jumlah_bayar = document.getElementById('jumlah_bayar').value;

            var hasil = parseFloat(jumlah_bayar) - parseFloat(total);
            if (!isNaN(hasil)) {
                document.getElementById('kembalian').value = hasil;
            };
        }
    </script>

    <script type="text/javascript">
        <?php echo $dataArray; ?>

        function dataResep(id) {
            document.getElementById('id_resep').value = dataName[id].id_resep;
            document.getElementById('tarif_dokter').value = dataName[id].tarif_dokter;
            document.getElementById('nm_dokter').value = dataName[id].nm_dokter;
            document.getElementById('nm_poli').value = dataName[id].nm_poli;
            document.getElementById('kd_resep').value = dataName[id].kd_resep;
            document.getElementById('nama_obt').value = dataName[id].nama_obt;
            document.getElementById('harga_obt').value = dataName[id].harga_obt;
            document.getElementById('jumlah_obt').value = dataName[id].jumlah_obt;
            document.getElementById('total').value = dataName[id].total;
            document.getElementById('subharga_obt').value = dataName[id].subharga_obt;
        };
    </script>

</body>

</html>