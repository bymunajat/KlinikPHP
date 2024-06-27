-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2021 at 01:43 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbproyek`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_dokter`
--

CREATE TABLE `tb_dokter` (
  `id_dokter` int(11) NOT NULL,
  `kd_dokter` varchar(10) NOT NULL,
  `nm_dokter` varchar(30) NOT NULL,
  `spesialis_dokter` varchar(25) NOT NULL,
  `id_poli` int(11) NOT NULL,
  `tarif_dokter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_dokter`
--

INSERT INTO `tb_dokter` (`id_dokter`, `kd_dokter`, `nm_dokter`, `spesialis_dokter`, `id_poli`, `tarif_dokter`) VALUES
(1, 'DOK-1', 'Dr. Ardian', 'Mata', 1, 100000),
(2, 'DOK-2', 'Dr. Ardian', 'Kulit dan Kelamin', 2, 500000),
(3, 'DOK-3', 'Dr. Budi', 'THT', 9, 450000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_obat`
--

CREATE TABLE `tb_obat` (
  `id_obat` int(11) NOT NULL,
  `kd_obat` varchar(10) NOT NULL,
  `nm_obat` varchar(30) NOT NULL,
  `jenis_obat` varchar(25) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga_obat` int(11) NOT NULL,
  `exp_obat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_obat`
--

INSERT INTO `tb_obat` (`id_obat`, `kd_obat`, `nm_obat`, `jenis_obat`, `stok`, `harga_obat`, `exp_obat`) VALUES
(1, 'OBT-1', 'Hemaviton+', 'Pil', 100, 10000, '2021-11-04'),
(2, 'OBT-2', 'Vitamin C', 'Tablet', 100, 10000, '2025-11-12'),
(3, 'OBT-3', 'Sulfasomidin', 'Kapsul', 93, 230000, '2024-10-22');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pasien`
--

CREATE TABLE `tb_pasien` (
  `id_pasien` int(11) NOT NULL,
  `nm_pasien` varchar(30) NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pasien`
--

INSERT INTO `tb_pasien` (`id_pasien`, `nm_pasien`, `jenis_kelamin`, `tgl_lahir`, `alamat`) VALUES
(1, 'Dinda', 'Perempuan', '2021-11-04', 'Jl.Jalam'),
(2, 'Evina', 'Perempuan', '2021-11-19', 'Jl. Mawar'),
(3, 'Syawalia', 'Perempuan', '2021-11-19', 'Jl. Mawar M'),
(5, 'Daftar1', 'Laki-Laki', '2021-12-03', 'Daftar'),
(7, 'Pasien', 'Laki-Laki', '2021-12-23', 'Jl suhat'),
(9, 'Ria Sukma', 'Perempuan', '2021-12-24', 'adda');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `kd_pembayaran` varchar(10) NOT NULL,
  `id_resep` int(11) NOT NULL,
  `nama_pasien` varchar(30) NOT NULL,
  `total_pembayaran` int(11) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `status_pembayaran` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`kd_pembayaran`, `id_resep`, `nama_pasien`, `total_pembayaran`, `jumlah_bayar`, `kembalian`, `tgl_pembayaran`, `status_pembayaran`) VALUES
('TRA-01', 1, 'Dinda', 200000, 1900000, 1700000, '2021-12-16', '1'),
('TRA-02', 2, 'Daftar1', 460000, 500000, 40000, '2021-12-22', '1'),
('TRA-03', 3, 'Pasien', 680000, 700000, 20000, '2021-12-23', '1'),
('TRA-04', 4, 'Ria Sukma', 680000, 700000, 20000, '2021-12-24', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pemeriksaan`
--

CREATE TABLE `tb_pemeriksaan` (
  `id_pemeriksaan` int(11) NOT NULL,
  `kd_pemeriksaan` varchar(10) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `keluhan` varchar(50) NOT NULL,
  `diagnosa` varchar(50) NOT NULL,
  `status_periksa` enum('0','1') NOT NULL,
  `tgl_pemeriksaan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pemeriksaan`
--

INSERT INTO `tb_pemeriksaan` (`id_pemeriksaan`, `kd_pemeriksaan`, `id_pendaftaran`, `keluhan`, `diagnosa`, `status_periksa`, `tgl_pemeriksaan`) VALUES
(1, 'PRK-01', 1, 'Sakit', 'sakit', '1', '2021-11-19'),
(2, 'PRK-02', 3, 'kakak', 'akakaka', '1', '2021-12-03'),
(3, 'PRK-03', 7, 'Sakit Telinga', 'Tersumbat', '1', '2021-12-23'),
(4, 'PRK-04', 9, 'sakit telinga', 'tersumbat', '1', '2021-12-24');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pendaftaran`
--

CREATE TABLE `tb_pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `kd_pendaftaran` varchar(10) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `id_poli` int(11) NOT NULL,
  `status` enum('0','1','2') NOT NULL,
  `tgl_pendaftaran` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pendaftaran`
--

INSERT INTO `tb_pendaftaran` (`id_pendaftaran`, `kd_pendaftaran`, `id_pasien`, `id_dokter`, `id_poli`, `status`, `tgl_pendaftaran`) VALUES
(1, 'DTF-01', 1, 1, 1, '1', '2021-11-19'),
(2, 'DTF-02', 2, 3, 9, '2', '2021-11-19'),
(3, 'DTF-03', 5, 3, 9, '1', '2021-12-03'),
(4, 'DTF-04', 2, 3, 9, '2', '2021-12-03'),
(5, 'DTF-05', 3, 3, 9, '0', '2021-12-22'),
(6, 'DTF-06', 3, 3, 9, '2', '2021-12-23'),
(7, 'DTF-07', 7, 3, 9, '1', '2021-12-23'),
(8, 'DTF-08', 9, 3, 9, '2', '2021-12-24'),
(9, 'DTF-09', 9, 3, 9, '1', '2021-12-24');

-- --------------------------------------------------------

--
-- Table structure for table `tb_poli`
--

CREATE TABLE `tb_poli` (
  `id_poli` int(11) NOT NULL,
  `kd_poli` varchar(10) NOT NULL,
  `nm_poli` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_poli`
--

INSERT INTO `tb_poli` (`id_poli`, `kd_poli`, `nm_poli`) VALUES
(1, 'POL-1', 'Poli Mata'),
(2, 'POL-2', 'Kulit dan Kelamin'),
(3, 'POL-3', 'Gigi'),
(4, 'POL-4', 'Umum'),
(5, 'POL-5', 'Anak'),
(7, 'POL-6', 'Saraf'),
(9, 'POL-8', 'THT');

-- --------------------------------------------------------

--
-- Table structure for table `tb_resep`
--

CREATE TABLE `tb_resep` (
  `id_resep` int(11) NOT NULL,
  `kd_resep` varchar(10) NOT NULL,
  `id_pemeriksaan` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `nama_obt` varchar(30) NOT NULL,
  `harga_obt` int(11) NOT NULL,
  `jumlah_obt` int(11) NOT NULL,
  `subharga_obt` int(11) NOT NULL,
  `tarif_dkt` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `status_rsp` enum('0','1') NOT NULL,
  `tgl_resep` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_resep`
--

INSERT INTO `tb_resep` (`id_resep`, `kd_resep`, `id_pemeriksaan`, `keterangan`, `nama_obt`, `harga_obt`, `jumlah_obt`, `subharga_obt`, `tarif_dkt`, `total`, `status_rsp`, `tgl_resep`) VALUES
(1, 'RSP-01', 1, 'sakit\r\n', 'Vitamin C', 10000, 10, 100000, 100000, 200000, '1', '2021-12-16'),
(2, 'RSP-02', 2, 'hhhh', 'Vitamin C', 10000, 1, 10000, 450000, 460000, '1', '2021-12-22'),
(3, 'RSP-03', 3, 'Minum 2 kali sehari', 'Sulfasomidin', 230000, 1, 230000, 450000, 680000, '1', '2021-12-23'),
(4, 'RSP-04', 4, 'Minum 2 kali sehari', 'Sulfasomidin', 230000, 1, 230000, 450000, 680000, '1', '2021-12-24');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(20) NOT NULL,
  `jabatan` enum('admin','pembayaran','pendaftaran','pemeriksaan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `jabatan`) VALUES
(1, 'admin', 'admin', 'admin'),
(2, 'kasir', 'kasir', 'pembayaran'),
(3, 'pendaftaran', 'pendaftaran', 'pendaftaran'),
(4, 'pemeriksaan', 'pemeriksaan', 'pemeriksaan'),
(5, 'evina', 'evina', 'pembayaran'),
(7, 'pegawai', 'pegawai', 'pembayaran');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD KEY `id_poli` (`id_poli`);

--
-- Indexes for table `tb_obat`
--
ALTER TABLE `tb_obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `tb_pasien`
--
ALTER TABLE `tb_pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD KEY `id_resep` (`id_resep`);

--
-- Indexes for table `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  ADD PRIMARY KEY (`id_pemeriksaan`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`);

--
-- Indexes for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_poli` (`id_poli`);

--
-- Indexes for table `tb_poli`
--
ALTER TABLE `tb_poli`
  ADD PRIMARY KEY (`id_poli`);

--
-- Indexes for table `tb_resep`
--
ALTER TABLE `tb_resep`
  ADD PRIMARY KEY (`id_resep`),
  ADD KEY `id_pemeriksaan` (`id_pemeriksaan`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_dokter`
--
ALTER TABLE `tb_dokter`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_obat`
--
ALTER TABLE `tb_obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_pasien`
--
ALTER TABLE `tb_pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  MODIFY `id_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_poli`
--
ALTER TABLE `tb_poli`
  MODIFY `id_poli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_resep`
--
ALTER TABLE `tb_resep`
  MODIFY `id_resep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD CONSTRAINT `tb_dokter_ibfk_1` FOREIGN KEY (`id_poli`) REFERENCES `tb_poli` (`id_poli`);

--
-- Constraints for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD CONSTRAINT `tb_pembayaran_ibfk_1` FOREIGN KEY (`id_resep`) REFERENCES `tb_resep` (`id_resep`);

--
-- Constraints for table `tb_pemeriksaan`
--
ALTER TABLE `tb_pemeriksaan`
  ADD CONSTRAINT `tb_pemeriksaan_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `tb_pendaftaran` (`id_pendaftaran`);

--
-- Constraints for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD CONSTRAINT `tb_pendaftaran_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `tb_pasien` (`id_pasien`),
  ADD CONSTRAINT `tb_pendaftaran_ibfk_2` FOREIGN KEY (`id_pasien`) REFERENCES `tb_pasien` (`id_pasien`),
  ADD CONSTRAINT `tb_pendaftaran_ibfk_3` FOREIGN KEY (`id_poli`) REFERENCES `tb_poli` (`id_poli`);

--
-- Constraints for table `tb_resep`
--
ALTER TABLE `tb_resep`
  ADD CONSTRAINT `tb_resep_ibfk_1` FOREIGN KEY (`id_pemeriksaan`) REFERENCES `tb_pemeriksaan` (`id_pemeriksaan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
