-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 06, 2025 at 12:38 PM
-- Server version: 8.3.0
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir_ukk_widia`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `iddetail` int NOT NULL,
  `idpenjualan` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `idproduk` int NOT NULL,
  `jumlah_produk` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tanggal_penjualan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`iddetail`, `idpenjualan`, `idproduk`, `jumlah_produk`, `subtotal`, `tanggal_penjualan`) VALUES
(88, 'KSS-20250315-8827', 13, 3, '160500.00', '2025-03-15'),
(89, 'KSS-20250316-7808', 3, 3, '405000.00', '2025-03-16'),
(90, 'KSS-20250316-8437', 5, 6, '30000.00', '2025-03-16'),
(91, 'KSS-20250316-8437', 3, 4, '540000.00', '2025-03-16'),
(92, 'KSS-20250316-8437', 13, 2, '107000.00', '2025-03-16'),
(102, 'KSS-20250318-5626', 12, 1, '42000.00', '2025-03-18'),
(105, 'KSS-20250318-6886', 12, 2, '84000.00', '2025-03-18'),
(106, 'KSS-20250318-5275', 15, 2, '84000.00', '2025-03-18'),
(107, 'KSS-20250318-2723', 15, 2, '84000.00', '2025-03-18'),
(108, 'KSS-20250318-5446', 4, 1, '2500.00', '2025-03-18'),
(109, 'KSS-20250318-5446', 3, 1, '135000.00', '2025-03-18'),
(110, 'KSS-20250318-5446', 16, 1, '15000.00', '2025-03-18'),
(111, 'KSS-20250318-5446', 8, 1, '32000.00', '2025-03-18'),
(112, 'KSS-20250319-2938', 12, 4, '168000.00', '2025-03-19'),
(113, 'KSS-20250319-2938', 4, 5, '12500.00', '2025-03-19'),
(114, 'KSS-20250319-2938', 7, 1, '10000.00', '2025-03-19'),
(115, 'KSS-20250319-2938', 9, 4, '20000.00', '2025-03-19'),
(116, 'KSS-20250319-5188', 1, 3, '396000.00', '2025-03-19'),
(117, 'KSS-20250319-5188', 13, 1, '53500.00', '2025-03-19'),
(118, 'KSS-20250319-5188', 5, 1, '5000.00', '2025-03-19'),
(119, 'KSS-20250319-5188', 13, 3, '160500.00', '2025-03-19'),
(120, 'KSS-20250319-8037', 21, 2, '200000.00', '2025-03-19'),
(121, 'KSS-20250319-8949', 10, 10, '50000.00', '2025-03-19'),
(123, 'KSS-20250319-8832', 15, 6, '252000.00', '2025-03-19'),
(128, 'KSS-20250410-8594', 12, 1, '42000.00', '2025-04-10'),
(129, 'KSS-20250410-8594', 12, 3, '126000.00', '2025-04-10'),
(130, 'KSS-20250410-8594', 21, 2, '200000.00', '2025-04-10'),
(131, 'KSS-20250410-5275', 13, 3, '160500.00', '2025-04-10'),
(132, 'KSS-20250412-5719', 3, 4, '540000.00', '2025-04-12'),
(136, 'KSS-20250412-9678', 2, 2, '240000.00', '2025-04-12'),
(137, 'KSS-20250412-7042', 6, 4, '30000.00', '2025-04-12'),
(138, 'KSS-20250412-7042', 6, 4, '30000.00', '2025-04-12'),
(139, 'KSS-20250412-7042', 6, 2, '15000.00', '2025-04-12'),
(140, 'KSS-20250412-1993', 15, 2, '84000.00', '2025-04-12'),
(141, 'KSS-20250412-1993', 15, 8, '336000.00', '2025-04-12'),
(147, 'KSS-20250412-7471', 12, 2, '84000.00', '2025-04-12'),
(148, 'KSS-20250412-7471', 11, 2, '28000.00', '2025-04-12'),
(149, 'KSS-20250412-7471', 7, 2, '20000.00', '2025-04-12'),
(150, 'KSS-20250412-7471', 29, 3, '118500.00', '2025-04-12'),
(151, 'KSS-20250413-6473', 3, 1, '135000.00', '2025-04-13'),
(152, 'KSS-20250413-6473', 4, 1, '2500.00', '2025-04-13'),
(153, 'KSS-20250414-7284', 30, 2, '200000.00', '2025-04-14');

--
-- Triggers `detail_penjualan`
--
DELIMITER $$
CREATE TRIGGER `stok_hapus` AFTER DELETE ON `detail_penjualan` FOR EACH ROW UPDATE produk set stok = stok + old.jumlah_produk where idproduk=old.idproduk
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `stok_kurang` AFTER INSERT ON `detail_penjualan` FOR EACH ROW UPDATE produk set stok = stok-new.jumlah_produk where idproduk=new.idproduk
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `stok_ubah` AFTER UPDATE ON `detail_penjualan` FOR EACH ROW update produk set stok = stok - (new.jumlah_produk - old.jumlah_produk) where idproduk = new.idproduk
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `idpelanggan` int NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`idpelanggan`, `nama_pelanggan`, `alamat`, `no_telepon`) VALUES
(0, 'Guest', '-', '-'),
(1, 'Anggi', 'Bandung', '089217536543'),
(2, 'Amara', 'Sumedang', '087595365542'),
(3, 'Agus', 'Sumedang', '087632146509'),
(4, 'Surya', 'Sumedang', '086598124567'),
(5, 'Raka', 'Bandung', '087214680924'),
(6, 'Arka', 'Bandung', '087398412309'),
(7, 'Nalika', 'Sumedang', '083127321098'),
(8, 'Rika', 'Bandung', '087612983409'),
(9, 'Angga', 'Bandung', '084598150628'),
(10, 'Rama', 'Sumedang', '087609127409');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `idpengguna` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`idpengguna`, `nama`, `username`, `password`, `level`) VALUES
(1, 'Sri Widia', 'widia', '$2y$10$n4Hm5Xzoai6O1uhT9fkRUO4DmYFUnWGh/yPNpZjsS.qbewu5o74qq', 'admin'),
(2, 'Widia Lestari', 'lestari', '$2y$10$YKkQv5yuYyyM2fAb4Sp.6OdbFTEd1bPywPiaaLBROAG9Ei5dhfp3G', 'petugas'),
(3, 'Sri Widia Lestari', 'sri', '$2y$10$TC5Az/1jpzRtTjdsNBxy5eTmlRYvcjP8LmtDYo3WV1jbzFObEvchq', 'petugas'),
(11, 'BuMaya', 'BuMaya', '$2y$10$LtnTpiKRLxCALffhHBpHCuWxs8NgYLlqBZl8z7wSaJ6oOVZ1gyd6.', 'petugas');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `idpenjualan` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `potongan_harga` decimal(10,2) NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `total_uang` decimal(10,2) NOT NULL,
  `total_kembali` decimal(10,2) NOT NULL,
  `idpelanggan` int NOT NULL,
  `idkasir` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`idpenjualan`, `tanggal_penjualan`, `total_harga`, `potongan_harga`, `total_bayar`, `total_uang`, `total_kembali`, `idpelanggan`, `idkasir`) VALUES
('KSS-20250318-2723', '2025-03-18', '84000.00', '0.00', '84000.00', '100000.00', '16000.00', 0, 11),
('KSS-20250318-5446', '2025-03-18', '184500.00', '18450.00', '166050.00', '170000.00', '3950.00', 1, 11),
('KSS-20250318-6886', '2025-03-18', '84000.00', '8400.00', '75600.00', '100000.00', '24400.00', 1, 1),
('KSS-20250319-2938', '2025-03-19', '210500.00', '21050.00', '189450.00', '200000.00', '10550.00', 1, 2),
('KSS-20250319-5188', '2025-03-19', '615000.00', '0.00', '615000.00', '650000.00', '35000.00', 0, 2),
('KSS-20250319-8037', '2025-03-19', '200000.00', '20000.00', '180000.00', '200000.00', '20000.00', 1, 2),
('KSS-20250319-8832', '2025-03-19', '252000.00', '25200.00', '226800.00', '300000.00', '73200.00', 7, 2),
('KSS-20250410-5275', '2025-04-10', '160500.00', '0.00', '160500.00', '200000.00', '39500.00', 0, 1),
('KSS-20250410-8594', '2025-04-10', '368000.00', '36800.00', '331200.00', '400000.00', '68800.00', 1, 1),
('KSS-20250412-1993', '2025-04-12', '420000.00', '42000.00', '378000.00', '400000.00', '22000.00', 1, 1),
('KSS-20250412-5719', '2025-04-12', '540000.00', '54000.00', '486000.00', '500000.00', '14000.00', 1, 1),
('KSS-20250412-7042', '2025-04-12', '75000.00', '0.00', '75000.00', '100000.00', '25000.00', 0, 1),
('KSS-20250412-7471', '2025-04-12', '250500.00', '25050.00', '225450.00', '300000.00', '74550.00', 5, 1),
('KSS-20250412-9678', '2025-04-12', '360000.00', '36000.00', '324000.00', '350000.00', '26000.00', 1, 1),
('KSS-20250413-6473', '2025-04-13', '137500.00', '13750.00', '123750.00', '150000.00', '26250.00', 2, 1),
('KSS-20250414-7284', '2025-04-14', '200000.00', '20000.00', '180000.00', '200000.00', '20000.00', 10, 3);

--
-- Triggers `penjualan`
--
DELIMITER $$
CREATE TRIGGER `detail_hapus` AFTER DELETE ON `penjualan` FOR EACH ROW DELETE FROM detail_penjualan WHERE idpenjualan = OLD.idpenjualan
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `idproduk` int NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `harga_beli` decimal(10,2) NOT NULL,
  `stok` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`idproduk`, `nama_produk`, `harga_jual`, `harga_beli`, `stok`) VALUES
(1, 'Smart Watch 468 h', '142000.00', '120000.00', 173),
(2, 'Smart Watch 348 a', '120000.00', '100000.00', 137),
(3, 'Smart Watch 567 w', '155000.00', '120000.00', 54),
(4, 'Paper Bag S', '2500.00', '1500.00', 1043),
(5, 'Paper Bag M', '5000.00', '3500.00', 993),
(6, 'Paper Bag L', '7500.00', '6500.00', 990),
(7, 'Paper Bag XL', '10000.00', '8500.00', 997),
(8, 'Baterai Aokeyo', '32000.00', '28000.00', 99),
(9, 'Baterai PhiLipe Ricci', '5000.00', '3000.00', 96),
(10, 'Boring Batery', '5000.00', '3000.00', 90),
(11, 'Baterai Krisbwo', '14000.00', '11000.00', 98),
(12, 'Jam Dinding 001', '42000.00', '35000.00', 27),
(13, 'Jam Dinding 002', '53500.00', '47000.00', 23),
(14, 'Jam Dinding 003', '72000.00', '68000.00', 45),
(15, 'Jam Wanita 034', '42000.00', '35000.00', 30),
(16, 'Jam Weker 567', '15000.00', '12000.00', 29),
(21, 'Jam Weker 80', '100000.00', '83000.00', 16),
(22, 'Jam Weker 76', '66000.00', '23000.00', 24),
(24, 'Jam Tangan', '52000.00', '23000.00', 20),
(25, 'Jam Weker 987', '50000.00', '23000.00', 23),
(26, 'Batrai A3', '8000.00', '5000.00', 30),
(27, 'Batrai A2', '7000.00', '3000.00', 100),
(29, 'Jam Dinding 128', '39500.00', '31500.00', 89),
(30, 'Jam Tangan 359', '100000.00', '80000.00', 38);

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `idstok` int NOT NULL,
  `idproduk` int NOT NULL,
  `tanggal_input_stok` date NOT NULL,
  `input_stok` int NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stok`
--

INSERT INTO `stok` (`idstok`, `idproduk`, `tanggal_input_stok`, `input_stok`, `keterangan`) VALUES
(12, 2, '2025-03-05', 29, '-'),
(14, 1, '2025-03-05', 14, '-'),
(15, 3, '2025-03-14', 20, '-'),
(16, 12, '2025-03-14', 10, '-'),
(17, 12, '2025-03-14', 10, '-'),
(18, 21, '2025-03-15', 20, '-'),
(19, 22, '2025-03-15', 24, '-'),
(21, 24, '2025-03-18', 20, '-'),
(23, 25, '2025-03-18', 23, '-'),
(24, 26, '2025-04-07', 30, '-'),
(25, 27, '2025-04-07', 100, '-'),
(26, 28, '2025-04-07', 100, '-'),
(27, 29, '2025-04-10', 92, '-'),
(28, 30, '2025-04-10', 27, '-'),
(29, 30, '2025-04-14', 40, 'Stok Bulanan');

--
-- Triggers `stok`
--
DELIMITER $$
CREATE TRIGGER `hapus_stok` AFTER DELETE ON `stok` FOR EACH ROW UPDATE produk SET stok = stok - OLD.input_stok WHERE idproduk = OLD.idproduk
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambah_stok` AFTER INSERT ON `stok` FOR EACH ROW UPDATE produk SET stok = stok + NEW.input_stok WHERE idproduk = NEW.idproduk
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`iddetail`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`idpelanggan`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`idpengguna`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`idpenjualan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idproduk`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`idstok`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `iddetail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `idpelanggan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `idpengguna` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `idproduk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `idstok` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
