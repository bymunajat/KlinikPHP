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
    <title>Poli Klinik | Data Pemeriksaan</title>
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
                        <a class="nav-link active" href="../data-pemeriksaan/pemeriksaan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                            Data Pemeriksaan
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content" class="bg-white text-dark">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Tambah Data Pemeriksaan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../index.php" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Pemeriksaan</li>
                        <li class="breadcrumb-item active">Tambah Data Pemeriksaan</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header font-weight-bold">
                            Data Pemeriksaan
                        </div>
                        <div class="card-body">
                            <div class="">
                                <div class="form-group row">
                                    <div class="btn-block disabled mx-4">
                                        <?php $ambil = mysqli_query($koneksi, "SELECT * FROM tb_pemeriksaan ORDER BY id_pemeriksaan DESC LIMIT 1"); ?>
                                        <?php $data = $ambil->fetch_assoc(); ?>
                                        <label>Data Terakhir</label>
                                        <input type="text" class="form-control text-center" value="<?php echo $data['kd_pemeriksaan'] ?>" readonly>
                                    </div>
                                </div>
                                <form class="mx-4" method="post" class="pemeriksaan" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label>Kode Pemeriksaan</label>
                                            <input type="text" class="form-control" name="kd_pemeriksaan" value="PRK-" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label>Pasien</label>
                                            <select class="custom-select" name="id_pendaftaran" onchange='changeValue(this.value)'>
                                                <option value="0" disabled selected>Pilih Pasien</option>
                                                <?php
                                                $ambil2 = $koneksi->query("SELECT * FROM tb_pendaftaran a
                                                    JOIN tb_pasien b ON a.id_pasien = b.id_pasien
                                                    JOIN tb_dokter c ON a.id_dokter = c.id_dokter
                                                    JOIN tb_poli d ON a.id_poli =  d.id_poli WHERE a.status = '0'");
                                                $dataArray = "var dataName = new Array();\n";

                                                ?>

                                                <?php while ($daftar = $ambil2->fetch_array()) { ?>
                                                    <option value="<?php echo $daftar['id_pendaftaran']; ?>">
                                                        <?php echo $daftar['nm_pasien']; ?>
                                                    </option>
                                                <?php
                                                    $dataArray .= "dataName['" . $daftar['id_pendaftaran'] . "'] = {
                                                        kd_pendaftaran:'" . $daftar['kd_pendaftaran'] . "',
                                                        nm_dokter:'" . $daftar['nm_dokter'] . "',
                                                        nm_poli:'" . $daftar['nm_poli'] . "',
                                                        tgl_pendaftaran:'" . $daftar['tgl_pendaftaran'] . "'
                                                    };\n";
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Kode Pendaftaran</label>
                                            <input type="text" class="form-control" name="kd_pendaftaran" id="kd_pendaftaran" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Nama Dokter</label>
                                            <input type="text" class="form-control" name="nm_dokter" id="nm_dokter" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">

                                        </div>
                                        <div class="col-sm-4">
                                            <label>Poli</label>
                                            <input type="text" class="form-control" name="nm_poli" id="nm_poli" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Tanggal Daftar</label>
                                            <input type="date" class="form-control" name="tgl_pendaftaran" id="tgl_pendaftaran" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label>Keluhan</label>
                                            <textarea class="form-control" name="keluhan" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label>Diagnosa</label>
                                            <textarea class="form-control" name="diagnosa" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <input type="hidden" class="form-control" name="tgl_pemeriksaan" value="<?php echo date("Y-m-d"); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <button class="btn btn-success font-weight-bold px-3 mr-2" name="save"><i class="far fa-save"></i> Simpan</button>
                                        <a href="pemeriksaan.php" class="btn btn-danger font-weight-bold px-3 mr-2"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
                                    </div>
                                </form>

                                <?php
                                if (isset($_POST['save'])) {
                                    if ($_POST['id_pendaftaran'] == 0) {
                                        echo "<script>alert('Pilih Pasien dengan Benar!');</script>";
                                    } else {
                                        $sql = "UPDATE tb_pendaftaran SET status='1' WHERE id_pendaftaran='$_POST[id_pendaftaran]';";
                                        $sql .= "INSERT INTO tb_pemeriksaan (id_pemeriksaan, kd_pemeriksaan, id_pendaftaran, 
                                                    keluhan, diagnosa, status_periksa, tgl_pemeriksaan) 
                                                VALUES ('', '$_POST[kd_pemeriksaan]', '$_POST[id_pendaftaran]', '$_POST[keluhan]', 
                                                    '$_POST[diagnosa]', '0', '$_POST[tgl_pemeriksaan]')";

                                        $koneksi->multi_query($sql);

                                        echo "<script>alert('Data Tersimpan!');</script>";
                                        echo "<script>location='pemeriksaan.php'</script>";
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
                        <div class="text-muted font-weight-bold">Copyright &copy; Poli Klinik 2021</div>
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
        $(".pemeriksaan").keyup(function() {
            var kd_pendaftaran = $("#kd_pendaftaran").val()
            var nm_dokter = $("#nm_dokter").val()
            var nm_poli = $("#nm_poli").val()
            var tgl_pendaftaran = $("#tgl_pendaftaran").val()
        });
    </script>

    <script type="text/javascript">
        <?php echo $dataArray; ?>

        function changeValue(id) {
            document.getElementById('kd_pendaftaran').value = dataName[id].kd_pendaftaran;
            document.getElementById('nm_dokter').value = dataName[id].nm_dokter;
            document.getElementById('nm_poli').value = dataName[id].nm_poli;
            document.getElementById('tgl_pendaftaran').value = dataName[id].tgl_pendaftaran;

        };
    </script>

</body>

</html>