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
    <title>Poli Klinik | Resep Obat</title>
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
                            <a class="nav-link active" href="../data-resep/resep.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
                                Resep Obat
                            </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pembayaran') : ?>
                            <a class="nav-link" href="../data-pembayaran/pembayaran.php">
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
                    <h1 class="mt-4">Tambah Resep Obat</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../index.php" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Resep Obat</li>
                        <li class="breadcrumb-item active">Tambah Resep Obat</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header font-weight-bold">
                            Data Resep Obat
                        </div>
                        <div class="card-body">
                            <div class="">
                                <div class="form-group row">
                                    <div class="btn-block disabled mx-4">
                                        <?php $ambil = mysqli_query($koneksi, "SELECT * FROM tb_resep ORDER BY id_resep DESC LIMIT 1"); ?>
                                        <?php $data = $ambil->fetch_assoc(); ?>
                                        <label>Data Terakhir</label>
                                        <input type="text" class="form-control text-center" value="<?php echo $data['kd_resep'] ?>" readonly>
                                    </div>
                                </div>
                                <form class="mx-4" method="post" class="rsp" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>Kode Resep</label>
                                            <input type="text" class="form-control" name="kd_resep" value="RSP-" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1">
                                            <label>ID</label>
                                            <input type="text" class="form-control" name="id_pendaftaran" id="id_pendaftaran" readonly>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Pasien</label>
                                            <select class="custom-select" name="id_pemeriksaan" id="id_pemeriksaan" onchange='dataPemeriksaan(this.value)'>
                                                <option value="0" disabled selected>Pilih Pasien</option>
                                                <?php
                                                $ambil2 = $koneksi->query("SELECT * FROM tb_pemeriksaan a
                                                    JOIN tb_pendaftaran b ON a.id_pendaftaran = b.id_pendaftaran
                                                    JOIN tb_pasien c ON b.id_pasien = c.id_pasien
                                                    JOIN tb_dokter d ON b.id_dokter = d.id_dokter
                                                    JOIN tb_poli e ON b.id_poli = e.id_poli WHERE a.status_periksa = '0'");
                                                $dataArray = "var dataName = new Array();\n";

                                                ?>

                                                <?php while ($daftar = $ambil2->fetch_array()) { ?>
                                                    <option value="<?php echo $daftar['id_pemeriksaan']; ?>">
                                                        <?php echo $daftar['nm_pasien']; ?>
                                                    </option>
                                                <?php
                                                    $dataArray .= "dataName['" . $daftar['id_pemeriksaan'] . "'] = {
                                                        tarif_dokter:'" . $daftar['tarif_dokter'] . "',
                                                        nm_dokter:'" . $daftar['nm_dokter'] . "',
                                                        nm_poli:'" . $daftar['nm_poli'] . "',
                                                        tgl_pendaftaran:'" . $daftar['tgl_pendaftaran'] . "',
                                                        tgl_pemeriksaan:'" . $daftar['tgl_pemeriksaan'] . "',
                                                        keluhan:'" . $daftar['keluhan'] . "',
                                                        diagnosa:'" . $daftar['diagnosa'] . "',
                                                        id_pendaftaran:'" . $daftar['id_pendaftaran'] . "'
                                                    };\n";
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Nama Dokter</label>
                                            <input type="text" class="form-control" name="nm_dokter" id="nm_dokter" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Tarif Dokter</label>
                                            <input type="text" class="form-control" name="tarif_dokter" id="tarif_dokter" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label>Poli</label>
                                            <input type="text" class="form-control" name="nm_poli" id="nm_poli" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Tanggal Daftar</label>
                                            <input type="date" class="form-control" name="tgl_pendaftaran" id="tgl_pendaftaran" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Tanggal Periksa</label>
                                            <input type="date" class="form-control" name="tgl_pemeriksaan" id="tgl_pemeriksaan" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label>Keluhan</label>
                                            <textarea class="form-control" name="keluhan" id="keluhan" rows="3" readonly></textarea>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Diagnosa</label>
                                            <textarea class="form-control" name="diagnosa" id="diagnosa" rows="3" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-5">
                                            <label>Obat</label>
                                            <select class="custom-select" name="nm_obat" id="nm_obat" onchange='dataObat(this.value)'>
                                                <option value="0" disabled selected>Pilih Obat</option>
                                                <?php
                                                $ambil3 = $koneksi->query("SELECT * FROM tb_obat WHERE stok > 0");
                                                $dataArray2 = "var dataName2 = new Array();\n";

                                                ?>

                                                <?php while ($obat = $ambil3->fetch_array()) { ?>
                                                    <option value="<?php echo $obat['nm_obat']; ?>">
                                                        <?php echo $obat['nm_obat']; ?> - <?php echo $obat['stok']; ?> Stok
                                                    </option>
                                                <?php
                                                    $dataArray2 .= "dataName2['" . $obat['nm_obat'] . "'] = {
                                                        harga_obat:'" . $obat['harga_obat'] . "'
                                                    };\n";
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Harga</label>
                                            <input type="text" class="form-control" name="harga_obat" id="harga_obat" onkeyup="Hitung();" readonly>
                                        </div>
                                        <div class="col-sm-1">
                                            <label>Jumlah</label>
                                            <input type="text" class="form-control" name="jumlah_obt" id="jumlah_obt" onkeyup="Hitung();">
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Total Harga</label>
                                            <input type="text" class="form-control" name="subharga_obt" id="subharga_obt" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>Keterangan</label>
                                            <textarea class="form-control" name="keterangan" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <input type="hidden" class="form-control" name="tgl_resep" value="<?php echo date("Y-m-d"); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <button class="btn btn-success font-weight-bold px-3 mr-2" name="save"><i class="far fa-save"></i> Simpan</button>
                                        <a href="pemeriksaan.php" class="btn btn-danger font-weight-bold px-3 mr-2"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
                                    </div>
                                </form>

                                <?php
                                if (isset($_POST['save'])) {
                                    if ($_POST['id_pemeriksaan'] == 0) {
                                        echo "<script>alert('Pilih Pasien dengan Benar!');</script>";
                                    } else {
                                        $tarif_dkt = $_POST['tarif_dokter'];
                                        $total = $_POST['subharga_obt'] +  $_POST['tarif_dokter'];

                                        $sql = "UPDATE tb_pemeriksaan SET status_periksa = '1' WHERE id_pemeriksaan='$_POST[id_pemeriksaan]';";
                                        $sql .= "INSERT INTO tb_resep (id_resep, kd_resep, id_pemeriksaan, keterangan, nama_obt, harga_obt, 
                                                    jumlah_obt, subharga_obt, tarif_dkt, total, status_rsp, tgl_resep) 
                                                VALUES ('', '$_POST[kd_resep]', '$_POST[id_pemeriksaan]', '$_POST[keterangan]', '$_POST[nm_obat]', 
                                                    '$_POST[harga_obat]', '$_POST[jumlah_obt]', '$_POST[subharga_obt]', '$tarif_dkt', '$total', '0', 
                                                    '$_POST[tgl_resep]');";

                                        $koneksi->multi_query($sql);

                                        $kode = $_POST['kd_resep'];

                                        echo "<script>alert('Data Tersimpan!');</script>";
                                        echo "<script>location='struk_resep.php?kd_resep=$kode'</script>";
                                    }
                                }

                                ?>

                            </div>
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
            var tarif_dokter = $("#tarif_dokter").val()
            var nm_dokter = $("#nm_dokter").val()
            var nm_poli = $("#nm_poli").val()
            var tgl_pendaftaran = $("#tgl_pendaftaran").val()
            var tgl_pemeriksaan = $("#tgl_pemeriksaan").val()
            var keluhan = $("#keluhan").val()
            var diagnosa = $("#diagnosa").val()

        });
    </script>

    <script type="text/javascript">
        function Hitung() {
            var harga_obat = document.getElementById('harga_obat').value;
            var jumlah_obt = document.getElementById('jumlah_obt').value;

            var hasil = parseFloat(harga_obat) * parseFloat(jumlah_obt);
            if (!isNaN(hasil)) {
                document.getElementById('subharga_obt').value = hasil;
            };
        }
    </script>

    <script type="text/javascript">
        <?php echo $dataArray; ?>

        function dataPemeriksaan(id) {
            document.getElementById('tarif_dokter').value = dataName[id].tarif_dokter;
            document.getElementById('nm_dokter').value = dataName[id].nm_dokter;
            document.getElementById('nm_poli').value = dataName[id].nm_poli;
            document.getElementById('tgl_pendaftaran').value = dataName[id].tgl_pendaftaran;
            document.getElementById('tgl_pemeriksaan').value = dataName[id].tgl_pemeriksaan;
            document.getElementById('keluhan').value = dataName[id].keluhan;
            document.getElementById('diagnosa').value = dataName[id].diagnosa;
            document.getElementById('id_pendaftaran').value = dataName[id].id_pendaftaran;
        };
    </script>

    <script type="text/javascript">
        <?php echo $dataArray2; ?>

        function dataObat(id) {
            document.getElementById('harga_obat').value = dataName2[id].harga_obat;
        };
    </script>

</body>

</html>