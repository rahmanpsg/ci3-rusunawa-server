-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2020 at 03:58 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rusunawa`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`username`, `password`, `level`) VALUES
('admin', 'admin', 'admin'),
('biro', 'biro', 'biro');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kamar`
--

CREATE TABLE `tbl_kamar` (
  `id` varchar(18) NOT NULL,
  `nomor` int(11) NOT NULL,
  `lantai` int(1) NOT NULL,
  `total` int(11) NOT NULL,
  `tipe` char(1) NOT NULL,
  `kategori` varchar(5) NOT NULL,
  `attribut` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`attribut`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kamar`
--

INSERT INTO `tbl_kamar` (`id`, `nomor`, `lantai`, `total`, `tipe`, `kategori`, `attribut`) VALUES
('_az1bl1bia', 9, 2, 3, 'B', 'putra', '{\"left\":7.968696796515496,\"top\":121.03145473968283,\"width\":150.74251040659254,\"height\":108.86959084920574,\"angle\":270}'),
('_d0y1b50az', 8, 2, 4, 'B', 'putra', '{\"left\":174.99999999999983,\"top\":123.50452957954614,\"width\":160.901285524942,\"height\":116.2064839902359,\"angle\":90}'),
('_hblrrpu6r', 3, 1, 4, 'A', 'putra', '{\"left\":180.9999999999999,\"top\":185.2144923852937,\"width\":152.48916661305117,\"height\":110.1310647760925,\"angle\":90}'),
('_kvweioe8j', 1, 1, 4, 'A', 'putri', '{\"left\":6.841684188714663,\"top\":6.999650624876409,\"width\":128.98843727716442,\"height\":93.15831581128542,\"angle\":270}'),
('_m9t8pj4j2', 3, 2, 4, 'B', 'putri', '{\"left\":6.999999999999804,\"top\":6.891154025186609,\"width\":138.10877441605317,\"height\":99.74522596714951,\"angle\":270}'),
('_mlrdnsgoi', 2, 1, 4, 'B', 'putri', '{\"left\":184.99999999999997,\"top\":3.116959254733565,\"width\":150.8830070705559,\"height\":108.97106066206814,\"angle\":90}'),
('_o8vg7qpde', 7, 2, 4, 'A', 'putra', '{\"left\":6,\"top\":8.99961695016566,\"width\":113.51654997464927,\"height\":83.09528609280225,\"angle\":0}'),
('_qj32oarf3', 1, 1, 4, 'A', 'putra', '{\"left\":4.285003293194278,\"top\":3.548386120831111,\"width\":158.516490763828,\"height\":114.48413221832021,\"angle\":270}'),
('_u53o7m58p', 6, 2, 4, 'B', 'putra', '{\"left\":170,\"top\":9.9996211595045,\"width\":113.5810734360782,\"height\":82.03077525938981,\"angle\":0}'),
('_ua0sm5pgh', 2, 1, 4, 'B', 'putra', '{\"left\":177.11964302904863,\"top\":5.993064188142569,\"width\":114.72752630804885,\"height\":154.27307141806634,\"angle\":0}'),
('_xboqmpl3u', 4, 1, 3, 'A', 'putra', '{\"left\":12.543067809323349,\"top\":185.29107928569317,\"width\":142.2583822533187,\"height\":102.74216496073016,\"angle\":270}'),
('_yvf3zh5r0', 5, 1, 4, 'B', 'putra', '{\"left\":187.00000000000094,\"top\":361.05391978893215,\"width\":144.94752822362938,\"height\":104.68432593928787,\"angle\":270}');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sewa`
--

CREATE TABLE `tbl_sewa` (
  `id` varchar(18) NOT NULL,
  `nim` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `pembayaran` varchar(7) NOT NULL,
  `id_kamar` varchar(18) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `file` blob DEFAULT NULL,
  `status` varchar(25) NOT NULL,
  `ditambahkan_pada` datetime NOT NULL DEFAULT current_timestamp(),
  `diubah_pada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `nim` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `telp` varchar(14) NOT NULL,
  `jurusan` varchar(25) DEFAULT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`detail`)),
  `token` text DEFAULT NULL,
  `ditambahkan_pada` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `tbl_kamar`
--
ALTER TABLE `tbl_kamar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipe` (`tipe`);

--
-- Indexes for table `tbl_sewa`
--
ALTER TABLE `tbl_sewa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim` (`nim`),
  ADD KEY `id_kamar` (`id_kamar`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`nim`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_sewa`
--
ALTER TABLE `tbl_sewa`
  ADD CONSTRAINT `tbl_sewa_ibfk_1` FOREIGN KEY (`id_kamar`) REFERENCES `tbl_kamar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_sewa_ibfk_2` FOREIGN KEY (`nim`) REFERENCES `tbl_user` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
