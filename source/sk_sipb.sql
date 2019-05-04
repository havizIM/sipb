-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 04, 2019 at 02:23 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sk_sipb`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `no_persediaan` varchar(15) NOT NULL,
  `nama_persediaan` varchar(50) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `warna` varchar(10) NOT NULL,
  `keterangan` varchar(30) NOT NULL,
  `foto` text NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`no_persediaan`, `nama_persediaan`, `satuan`, `warna`, `keterangan`, `foto`, `tgl_input`) VALUES
('HYY-01X070-LV', 'HYY 1 X 70 MM2', 'Meter', '-', '-', 'HYY-01X070-LV.jpg', '2019-04-01 18:10:56'),
('HYY-01X095-LV', 'HYY 1 X 95 MM2', 'Meter Persegi', '-', 'Test', 'HYY-01X095-LV.jpg', '2019-04-01 18:10:56'),
('NYX123126', 'Coba', 'Coba', 'Coba', 'Coba', 'NYX123126.jpg', '2019-04-10 20:52:22');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `no_keluar` varchar(11) NOT NULL,
  `tgl_keluar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_customer` varchar(6) NOT NULL,
  `alamat_kirim` varchar(200) NOT NULL,
  `no_sp` varchar(20) NOT NULL,
  `ekspedisi` varchar(30) NOT NULL,
  `no_truk` varchar(9) NOT NULL,
  `ref_id` varchar(12) NOT NULL,
  `id_user` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar_detail`
--

CREATE TABLE `barang_keluar_detail` (
  `id_keluar_detail` int(11) NOT NULL,
  `no_keluar` varchar(11) NOT NULL,
  `id_identifikasi` int(11) NOT NULL,
  `qty_keluar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `no_masuk` varchar(11) NOT NULL,
  `no_surat` varchar(20) NOT NULL,
  `no_po` varchar(20) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `id_supplier` varchar(6) NOT NULL,
  `id_user` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk_detail`
--

CREATE TABLE `barang_masuk_detail` (
  `id_masuk_detail` int(11) NOT NULL,
  `no_masuk` varchar(11) NOT NULL,
  `id_identifikasi` int(11) NOT NULL,
  `qty_masuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_customer` varchar(6) NOT NULL,
  `nama_customer` varchar(50) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_customer`, `nama_customer`, `telepon`, `fax`, `email`, `alamat`, `tgl_input`) VALUES
('C00001', 'PT Mundur Maju', '1357913753901', '135938590832', 'coba1@gmail.com', 'Bogor', '2019-04-18 14:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `user` varchar(11) NOT NULL,
  `id_ref` varchar(15) NOT NULL,
  `refrensi` varchar(30) NOT NULL,
  `keterangan` text NOT NULL,
  `kategori` varchar(20) NOT NULL,
  `tgl_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id_log`, `user`, `id_ref`, `refrensi`, `keterangan`, `kategori`, `tgl_log`) VALUES
(18, 'USR00000001', '-', 'Auth', 'User login', 'Login', '2019-04-12 03:01:08'),
(19, 'USR00000001', '-', 'Auth', 'User login', 'Login', '2019-04-12 03:01:09'),
(20, 'USR00000001', '-', 'Auth', 'User login', 'Login', '2019-04-12 03:01:50'),
(21, 'USR00000001', '-', 'Auth', 'User logout', 'Logout', '2019-04-12 03:02:22'),
(22, 'USR00000001', 'USR00000006', 'User', 'Menambah data user baru', 'Add', '2019-04-12 03:05:11'),
(23, 'USR00000001', 'USR00000006', 'User', 'Mengedit data user', 'Edit', '2019-04-12 03:08:41'),
(24, 'USR00000001', 'USR00000006', 'User', 'Menghapus data user baru', 'Delete', '2019-04-12 03:09:37'),
(25, 'USR00000002', 'NYX123127', 'Barang', 'Menambah data barang', 'Add', '2019-04-12 03:11:15'),
(26, 'USR00000002', 'NYX123127', 'Barang', 'Mengedit data barang', 'Edit', '2019-04-12 03:12:10'),
(27, 'USR00000002', 'NYX123127', 'Barang', 'Menghapus data barang', 'Delete', '2019-04-12 03:12:53'),
(28, 'USR00000002', 'NYX123123', 'Barang', 'Mengedit data barang', 'Edit', '2019-04-15 15:30:00'),
(29, 'USR00000002', 'NYX123126', 'Barang', 'Mengedit data barang', 'Edit', '2019-04-15 15:30:49'),
(30, 'USR00000002', 'NYX123126', 'Barang', 'Mengedit data barang', 'Edit', '2019-04-15 15:32:16'),
(31, 'USR00000001', '-', 'Auth', 'User login', 'Login', '2019-04-15 19:22:12'),
(32, 'USR00000001', 'USR00000006', 'User', 'Menambah data user baru', 'Add', '2019-04-15 19:24:16'),
(33, 'USR00000001', 'USR00000007', 'User', 'Menambah data user baru', 'Add', '2019-04-15 19:53:09'),
(34, 'USR00000001', '-', 'Auth', 'User logout', 'Logout', '2019-04-15 20:01:01'),
(35, 'USR00000001', '-', 'Auth', 'User login', 'Login', '2019-04-17 01:41:55'),
(36, 'USR00000001', '-', 'Auth', 'User login', 'Login', '2019-04-17 20:43:55'),
(37, 'USR00000001', '-', 'Auth', 'User logout', 'Logout', '2019-04-17 20:52:45'),
(38, 'USR00000001', '-', 'Auth', 'User login', 'Login', '2019-04-18 09:26:49'),
(39, 'USR00000001', '-', 'Auth', 'User logout', 'Logout', '2019-04-18 09:27:34'),
(40, 'USR00000002', '-', 'Auth', 'User login', 'Login', '2019-04-18 09:29:01'),
(41, 'USR00000002', 'HYY-01X070-LV', 'Barang', 'Mengedit data barang', 'Edit', '2019-04-18 09:35:45'),
(42, 'USR00000002', 'HYY-01X095-LV', 'Barang', 'Mengedit data barang', 'Edit', '2019-04-18 09:36:09'),
(43, 'USR00000002', 'NYX123126', 'Barang', 'Mengedit data barang', 'Edit', '2019-04-18 10:53:56'),
(44, 'USR00000002', 'NYX123126 - 010', 'Stock', 'Menambah data stock baru', 'Add', '2019-04-18 13:32:55'),
(45, 'USR00000002', '14', 'Stock', 'Mengedit data stock', 'Edit', '2019-04-18 13:39:24'),
(46, 'USR00000002', '12', 'Stock', 'Menghapus data stock baru', 'Delete', '2019-04-18 13:40:42'),
(47, 'USR00000002', '14', 'Stock', 'Menghapus data stock baru', 'Delete', '2019-04-18 13:42:09'),
(48, 'USR00000002', 'S00001', 'Supplier', 'Menambah data supplier baru', 'Add', '2019-04-18 14:06:08'),
(49, 'USR00000002', 'S00002', 'Supplier', 'Menambah data supplier baru', 'Add', '2019-04-18 14:06:59'),
(50, 'USR00000002', 'S00002', 'Supplier', 'Mengedit data supplier', 'Edit', '2019-04-18 14:11:06'),
(51, 'USR00000002', 'S00002', 'Supplier', 'Menghapus data supplier baru', 'Delete', '2019-04-18 14:12:37'),
(52, 'USR00000002', 'C00001', 'Customer', 'Menambah data customer baru', 'Add', '2019-04-18 14:30:43'),
(53, 'USR00000002', 'C00002', 'Customer', 'Menambah data customer baru', 'Add', '2019-04-18 14:33:28'),
(54, 'USR00000002', 'C00002', 'Customer', 'Mengedit data customer', 'Edit', '2019-04-18 14:33:49'),
(55, 'USR00000002', 'S00002', 'Customer', 'Menghapus data customer baru', 'Delete', '2019-04-18 14:34:18'),
(56, 'USR00000002', 'C00002', 'Customer', 'Menghapus data customer baru', 'Delete', '2019-04-18 14:34:24'),
(57, 'USR00000001', '-', 'Auth', 'User login', 'Login', '2019-04-19 19:14:44'),
(58, 'USR00000001', '-', 'Auth', 'User logout', 'Logout', '2019-04-19 19:15:18'),
(59, 'USR00000001', '-', 'Auth', 'User login', 'Login', '2019-04-19 19:15:45'),
(60, 'USR00000001', '-', 'Auth', 'User logout', 'Logout', '2019-04-19 19:17:25'),
(61, 'USR00000002', '-', 'Auth', 'User login', 'Login', '2019-04-19 19:18:01'),
(62, 'USR00000002', '-', 'Auth', 'User logout', 'Logout', '2019-04-19 19:19:39'),
(63, 'USR00000001', '-', 'Auth', 'User login', 'Login', '2019-04-22 02:33:23'),
(64, 'USR00000001', '-', 'Auth', 'User logout', 'Logout', '2019-04-22 02:34:26'),
(65, 'USR00000002', '-', 'Auth', 'User login', 'Login', '2019-04-22 02:35:06'),
(66, 'USR00000002', 'HYY-01X095-LV', 'Barang', 'Mengedit data barang', 'Edit', '2019-04-22 02:35:30'),
(67, 'USR00000002', 'HYY-01X095-LV', 'Barang', 'Mengedit data barang', 'Edit', '2019-04-22 02:35:41'),
(68, 'USR00000001', '-', 'Auth', 'User login', 'Login', '2019-04-25 13:24:00'),
(69, 'USR00000001', '-', 'Auth', 'User logout', 'Logout', '2019-04-25 13:24:20'),
(70, 'USR00000003', 'PS0000000001', 'Type', 'Menambah data pesanan baru', 'Add', '2019-05-04 11:21:11'),
(71, 'USR00000003', 'PS0000000002', 'Type', 'Menambah data pesanan baru', 'Add', '2019-05-04 11:28:14'),
(72, 'USR00000003', 'PS0000000002', 'Pesanan', 'Mengedit data pesanan', 'Edit', '2019-05-04 11:46:36'),
(73, 'USR00000002', 'PS0000000002', 'Pesanan', 'Menghapus data Menghapus Data Pesanan', 'Delete', '2019-05-04 11:49:24'),
(74, 'USR00000002', 'PS0000000002', 'Pesanan', 'Menghapus data Menghapus Data Pesanan', 'Delete', '2019-05-04 11:49:45'),
(75, 'USR00000002', 'PS0000000001', 'Pesanan', 'Menghapus data Menghapus Data Pesanan', 'Delete', '2019-05-04 11:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `memorandum`
--

CREATE TABLE `memorandum` (
  `no_memo` varchar(15) NOT NULL,
  `tgl_memo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan_memo` varchar(200) NOT NULL,
  `id_user` varchar(11) NOT NULL,
  `status` enum('Menunggu','Ditolak','Disetujui','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `memorandum_detail`
--

CREATE TABLE `memorandum_detail` (
  `id_memorandum_detail` int(11) NOT NULL,
  `no_memo` varchar(15) NOT NULL,
  `id_identifikasi` int(11) NOT NULL,
  `qty_masuk` int(11) NOT NULL,
  `qty_keluar` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `no_pesanan` varchar(12) NOT NULL,
  `tgl_pesanan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_kirim` date NOT NULL,
  `id_customer` varchar(6) NOT NULL,
  `alamat_kirim` varchar(200) NOT NULL,
  `status` enum('Proses','Batal','Disetujui','') NOT NULL,
  `id_user` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id_detail_pesanan` int(11) NOT NULL,
  `no_pesanan` varchar(12) NOT NULL,
  `no_persediaan` varchar(15) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `qty_pesanan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `return_keluar`
--

CREATE TABLE `return_keluar` (
  `no_return_keluar` varchar(15) NOT NULL,
  `tgl_return` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `no_ref` varchar(20) NOT NULL,
  `id_supplier` varchar(6) NOT NULL,
  `id_user` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `return_keluar_detail`
--

CREATE TABLE `return_keluar_detail` (
  `id_dreturn_keluar` int(11) NOT NULL,
  `no_return_keluar` varchar(15) NOT NULL,
  `id_identifikasi` int(11) NOT NULL,
  `qty_return_keluar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `return_masuk`
--

CREATE TABLE `return_masuk` (
  `no_return_masuk` varchar(15) NOT NULL,
  `tgl_return` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `no_ref` varchar(20) NOT NULL,
  `id_customer` varchar(6) NOT NULL,
  `id_user` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `return_masuk_detail`
--

CREATE TABLE `return_masuk_detail` (
  `id_dreturn_masuk` int(11) NOT NULL,
  `no_return_masuk` varchar(15) NOT NULL,
  `id_identifikasi` int(11) NOT NULL,
  `qty_return_masuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id_identifikasi` int(11) NOT NULL,
  `no_persediaan` varchar(15) NOT NULL,
  `no_identifikasi` varchar(10) NOT NULL,
  `keterangan` varchar(15) NOT NULL,
  `saldo_awal` int(11) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id_identifikasi`, `no_persediaan`, `no_identifikasi`, `keterangan`, `saldo_awal`, `tgl_input`) VALUES
(1, 'HYY-01X070-LV', '01', '-', 0, '2019-04-01 18:14:22'),
(2, 'HYY-01X070-LV', '81-19', '-', 0, '2019-04-01 18:14:22'),
(3, 'HYY-01X070-LV', '81-24', '-', 0, '2019-04-01 18:14:22'),
(4, 'HYY-01X070-LV', '81-25', '-', 0, '2019-04-01 18:14:22'),
(5, 'HYY-01X070-LV', '81-26', '-', 0, '2019-04-01 18:14:22'),
(6, 'HYY-01X070-LV', '81-27', '-', 0, '2019-04-01 18:14:22'),
(7, 'HYY-01X070-LV', '82-01', '-', 0, '2019-04-01 18:14:22'),
(8, 'HYY-01X095-LV', '01', '-', 0, '2019-04-01 18:18:14'),
(9, 'HYY-01X095-LV', '02', '-', 0, '2019-04-01 18:18:14'),
(10, 'HYY-01X095-LV', '84-05', '-', 0, '2019-04-01 18:18:14'),
(11, 'HYY-01X095-LV', '84-06', '-', 0, '2019-04-01 18:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` varchar(6) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `telepon`, `fax`, `email`, `alamat`, `tgl_input`) VALUES
('S00001', 'PT Maju Mundur', '1357913753901', '135938590832', 'coba@gmail.com', 'Jakarta', '2019-04-18 14:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` varchar(11) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `level` enum('Admin','Sales','Kepala Gudang','Helpdesk','Manager') NOT NULL,
  `tgl_registrasi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `foto` text NOT NULL,
  `status` enum('Aktif','Nonaktif','','') NOT NULL,
  `token` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`, `level`, `tgl_registrasi`, `foto`, `status`, `token`) VALUES
('USR00000001', 'helpdesk', 'helpdesk', 'helpdesk', 'Helpdesk', '2019-03-24 17:28:40', 'helpdesk.jpg', 'Aktif', '2fa535dfeca3f34'),
('USR00000002', 'Kalyssa Innara Putri', 'kalyssaip', '37e4v', 'Admin', '2019-03-28 06:36:09', 'user.jpg', 'Aktif', 'e2baa50d717f2e8'),
('USR00000003', 'Dian Ratna Sari', 'dianrs', 'm0ejl', 'Sales', '2019-04-05 17:54:39', 'user.jpg', 'Aktif', 'e2baa50d717f2e9'),
('USR00000005', 'Devan Dirgantara', 'devandp', 'ye37q', 'Manager', '2019-04-05 18:02:50', 'user.jpg', 'Aktif', 'cbb527c93eb9b52'),
('USR00000006', 'Coba', 'Coba', 'sqkp8', 'Admin', '2019-04-15 19:24:16', 'user.jpg', 'Aktif', '2866a3fd7a01fce'),
('USR00000007', 'Tezar Tri Handika', 'tezarth', 'yfbhn', 'Kepala Gudang', '2019-04-15 19:53:09', 'user.jpg', 'Aktif', 'b34716876d1413c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`no_persediaan`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`no_keluar`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indexes for table `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  ADD PRIMARY KEY (`id_keluar_detail`),
  ADD KEY `no_keluar` (`no_keluar`),
  ADD KEY `id_identifikasi` (`id_identifikasi`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`no_masuk`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  ADD PRIMARY KEY (`id_masuk_detail`),
  ADD KEY `no_masuk` (`no_masuk`),
  ADD KEY `id_identifikasi` (`id_identifikasi`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `memorandum`
--
ALTER TABLE `memorandum`
  ADD PRIMARY KEY (`no_memo`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `memorandum_detail`
--
ALTER TABLE `memorandum_detail`
  ADD PRIMARY KEY (`id_memorandum_detail`),
  ADD KEY `no_memo` (`no_memo`),
  ADD KEY `id_indentifikasi` (`id_identifikasi`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`no_pesanan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indexes for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD PRIMARY KEY (`id_detail_pesanan`),
  ADD KEY `no_pesanan` (`no_pesanan`),
  ADD KEY `id_identifikasi` (`no_persediaan`),
  ADD KEY `no_persediaan` (`no_persediaan`);

--
-- Indexes for table `return_keluar`
--
ALTER TABLE `return_keluar`
  ADD PRIMARY KEY (`no_return_keluar`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `return_keluar_detail`
--
ALTER TABLE `return_keluar_detail`
  ADD PRIMARY KEY (`id_dreturn_keluar`),
  ADD KEY `no_return_keluar` (`no_return_keluar`),
  ADD KEY `id_identifikasi` (`id_identifikasi`);

--
-- Indexes for table `return_masuk`
--
ALTER TABLE `return_masuk`
  ADD PRIMARY KEY (`no_return_masuk`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `return_masuk_detail`
--
ALTER TABLE `return_masuk_detail`
  ADD PRIMARY KEY (`id_dreturn_masuk`),
  ADD KEY `id_indentifikasi` (`id_identifikasi`),
  ADD KEY `no_return_masuk` (`no_return_masuk`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_identifikasi`),
  ADD KEY `id_persediaan` (`no_persediaan`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  MODIFY `id_keluar_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  MODIFY `id_masuk_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `memorandum_detail`
--
ALTER TABLE `memorandum_detail`
  MODIFY `id_memorandum_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id_detail_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `return_keluar_detail`
--
ALTER TABLE `return_keluar_detail`
  MODIFY `id_dreturn_keluar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_masuk_detail`
--
ALTER TABLE `return_masuk_detail`
  MODIFY `id_dreturn_masuk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id_identifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_keluar_ibfk_2` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`) ON UPDATE CASCADE;

--
-- Constraints for table `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  ADD CONSTRAINT `barang_keluar_detail_ibfk_1` FOREIGN KEY (`no_keluar`) REFERENCES `barang_keluar` (`no_keluar`) ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_keluar_detail_ibfk_2` FOREIGN KEY (`id_identifikasi`) REFERENCES `stock` (`id_identifikasi`) ON UPDATE CASCADE;

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON UPDATE CASCADE;

--
-- Constraints for table `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  ADD CONSTRAINT `barang_masuk_detail_ibfk_1` FOREIGN KEY (`no_masuk`) REFERENCES `barang_masuk` (`no_masuk`) ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_detail_ibfk_2` FOREIGN KEY (`id_identifikasi`) REFERENCES `stock` (`id_identifikasi`) ON UPDATE CASCADE;

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `memorandum`
--
ALTER TABLE `memorandum`
  ADD CONSTRAINT `memorandum_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE;

--
-- Constraints for table `memorandum_detail`
--
ALTER TABLE `memorandum_detail`
  ADD CONSTRAINT `memorandum_detail_ibfk_1` FOREIGN KEY (`no_memo`) REFERENCES `memorandum` (`no_memo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `memorandum_detail_ibfk_2` FOREIGN KEY (`id_identifikasi`) REFERENCES `stock` (`id_identifikasi`) ON UPDATE CASCADE;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`) ON UPDATE CASCADE;

--
-- Constraints for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD CONSTRAINT `pesanan_detail_ibfk_1` FOREIGN KEY (`no_pesanan`) REFERENCES `pesanan` (`no_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_detail_ibfk_2` FOREIGN KEY (`no_persediaan`) REFERENCES `barang` (`no_persediaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `return_keluar`
--
ALTER TABLE `return_keluar`
  ADD CONSTRAINT `return_keluar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `return_keluar_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON UPDATE CASCADE;

--
-- Constraints for table `return_keluar_detail`
--
ALTER TABLE `return_keluar_detail`
  ADD CONSTRAINT `return_keluar_detail_ibfk_1` FOREIGN KEY (`no_return_keluar`) REFERENCES `return_keluar` (`no_return_keluar`) ON UPDATE CASCADE,
  ADD CONSTRAINT `return_keluar_detail_ibfk_2` FOREIGN KEY (`id_identifikasi`) REFERENCES `stock` (`id_identifikasi`) ON UPDATE CASCADE;

--
-- Constraints for table `return_masuk`
--
ALTER TABLE `return_masuk`
  ADD CONSTRAINT `return_masuk_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `return_masuk_ibfk_2` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`) ON UPDATE CASCADE;

--
-- Constraints for table `return_masuk_detail`
--
ALTER TABLE `return_masuk_detail`
  ADD CONSTRAINT `return_masuk_detail_ibfk_1` FOREIGN KEY (`no_return_masuk`) REFERENCES `return_masuk` (`no_return_masuk`) ON UPDATE CASCADE,
  ADD CONSTRAINT `return_masuk_detail_ibfk_2` FOREIGN KEY (`id_identifikasi`) REFERENCES `stock` (`id_identifikasi`) ON UPDATE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`no_persediaan`) REFERENCES `barang` (`no_persediaan`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
