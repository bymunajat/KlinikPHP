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
    <title>Poli Klinik | Data Pendaftaran</title>
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
                        <a class="nav-link active" href="../data-pendaftaran/pendaftaran.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                            Data Pendaftaran
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content" class="bg-white text-dark">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Tambah Data Pendaftaran</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../index.php" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Pendaftaran</li>
                        <li class="breadcrumb-item active">Tambah Data Pendaftaran</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header font-weight-bold">
                            Data Pendaftaran
                        </div>
                        <div class="card-body">
                            <div class="">
                                <div class="form-group row">
                                    <div class="btn-block disabled mx-4">
                                        <?php $ambil = mysqli_query($koneksi, "SELECT * FROM tb_pendaftaran ORDER BY id_pendaftaran DESC LIMIT 1"); ?>
                                        <?php $data = $ambil->fetch_assoc(); ?>
                                        <label>Data Terakhir</label>
                                        <input type="text" class="form-control text-center" value="<?php echo $data['kd_pendaftaran'] ?>" readonly>
                                    </div>
                                </div>
                                <form class="mx-4" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label>Kode Pendaftaran</label>
                                            <input type="text" class="form-control" name="kd_pendaftaran" value="DTF-" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label>Nama Pasien</label>
                                            <select class="custom-select" name="id_pasien">
                                                <option value="0" disabled selected>Pilih Pasien</option>
                                                <?php
                                                $ambil2 = $koneksi->query("SELECT * FROM tb_pasien");
                                                $pecah2 = $ambil2->fetch_assoc();
                                                ?>

                                                <?php foreach ($ambil2 as $pasien) : ?>
                                                    <option value="<?php echo $pasien['id_pasien']; ?>"><?php echo $pasien['nm_pasien']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label>Poli</label>
                                            <select class="custom-select" name="id_poli">
                                                <option value="0" disabled selected>Pilih Poli</option>
                                                <?php
                                                $ambil3 = $koneksi->query("SELECT * FROM tb_poli");
                                                $pecah3 = $ambil3->fetch_assoc();
                                                ?>

                                                <?php foreach ($ambil3 as $poli) : ?>
                                                    <option value="<?php echo $poli['id_poli']; ?>"><?php echo $poli['nm_poli']; ?></option>
                                                <?php endforeach; ?>
                                                <?php $poli_id = $_POST['id_poli']; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label>Dokter</label>
                                            <select class="custom-select" name="id_dokter">
                                                <option value="0" disabled selected>Pilih Dokter</option>
                                                <?php
                                                $ambil4 = $koneksi->query("SELECT * FROM tb_dokter JOIN tb_poli ON tb_dokter.id_poli = tb_poli.id_poli");
                                                $pecah4 = $ambil4->fetch_assoc();
                                                ?>

                                                <?php foreach ($ambil4 as $dokter) : ?>
                                                    <option value="<?php echo $dokter['id_dokter']; ?>"><?php echo $dokter['nm_dokter']; ?> - <?php echo $dokter['nm_poli']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <input type="hidden" class="form-control" name="tgl_pendaftaran" value="<?php echo date("Y-m-d"); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <button class="btn btn-success font-weight-bold px-3 mr-2" name="save"><i class="far fa-save"></i> Simpan</button>
                                        <a href="pendaftaran.php" class="btn btn-danger font-weight-bold px-3 mr-2"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
                                    </div>
                                </form>

                                <?php
                                if (isset($_POST['save'])) {
                                    if ($_POST['id_pasien'] == 0) {
                                        echo "<script>alert('Pilih Pasien dengan Benar!');</script>";
                                    } elseif ($_POST['id_poli'] == 0) {
                                        echo "<script>alert('Pilih Dokter dengan Benar!');</script>";
                                    } elseif ($_POST['id_dokter'] == 0) {
                                        echo "<script>alert('Pilih Poli dengan Benar!');</script>";
                                    } else {
                                        $koneksi->query("INSERT INTO tb_pendaftaran (id_pendaftaran, kd_pendaftaran, id_pasien, 
                                            id_dokter, id_poli, status, tgl_pendaftaran) 
                                        VALUES ('', '$_POST[kd_pendaftaran]', '$_POST[id_pasien]', '$_POST[id_dokter]',
                                            '$_POST[id_poli]', '0', '$_POST[tgl_pendaftaran]')");

                                            $kode = $_POST['kd_pendaftaran'];

                                        echo "<script>alert('Data Tersimpan!');</script>";
                                        echo "<script>location='struk_pendaftaran.php?kd_pendaftaran=$kode'</script>";
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
</body>

</html>