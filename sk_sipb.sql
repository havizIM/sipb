-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 05, 2019 at 08:08 PM
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
  `merk` varchar(30) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`no_persediaan`, `nama_persediaan`, `satuan`, `warna`, `merk`, `tgl_input`) VALUES
('HYY-01X070-LV/S', 'HYY 1 X 70 MM2', 'Meter', '-', '-', '2019-04-01 18:10:56'),
('HYY-01X095-LV/S', 'HYY 1 X 95 MM2', 'Meter', '-', '-', '2019-04-01 18:10:56');

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

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_indentifikasi` int(11) NOT NULL,
  `no_persediaan` varchar(15) NOT NULL,
  `no_identifikasi` varchar(10) NOT NULL,
  `keterangan` varchar(15) NOT NULL,
  `saldo_awal` int(11) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_indentifikasi`, `no_persediaan`, `no_identifikasi`, `keterangan`, `saldo_awal`, `tgl_input`) VALUES
(1, 'HYY-01X070-LV/S', '01', '-', 0, '2019-04-01 18:14:22'),
(2, 'HYY-01X070-LV/S', '81-19', '-', 0, '2019-04-01 18:14:22'),
(3, 'HYY-01X070-LV/S', '81-24', '-', 0, '2019-04-01 18:14:22'),
(4, 'HYY-01X070-LV/S', '81-25', '-', 0, '2019-04-01 18:14:22'),
(5, 'HYY-01X070-LV/S', '81-26', '-', 0, '2019-04-01 18:14:22'),
(6, 'HYY-01X070-LV/S', '81-27', '-', 0, '2019-04-01 18:14:22'),
(7, 'HYY-01X070-LV/S', '82-01', '-', 0, '2019-04-01 18:14:22'),
(8, 'HYY-01X095-LV/S', '01', '-', 0, '2019-04-01 18:18:14'),
(9, 'HYY-01X095-LV/S', '02', '-', 0, '2019-04-01 18:18:14'),
(10, 'HYY-01X095-LV/S', '84-05', '-', 0, '2019-04-01 18:18:14'),
(11, 'HYY-01X095-LV/S', '84-06', '-', 0, '2019-04-01 18:18:14'),
(12, 'HYY-01X095-LV/S', '84-07', '-', 0, '2019-04-01 18:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `user` varchar(11) NOT NULL,
  `keterangan` text NOT NULL,
  `kategori` varchar(20) NOT NULL,
  `tgl_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id_log`, `user`, `keterangan`, `kategori`, `tgl_log`) VALUES
(1, 'USR00000001', 'User login', 'Login', '2019-03-28 06:23:48'),
(2, 'USR00000001', 'User login', 'Login', '2019-03-28 06:27:33'),
(3, 'USR00000001', 'User logout', 'Logout', '2019-03-28 06:29:25'),
(4, 'USR00000001', 'Mengganti password lama menjadi password baru', 'Ganti Password', '2019-03-28 06:31:03'),
(5, 'USR00000001', 'User login', 'Login', '2019-03-28 20:15:23'),
(6, 'USR00000001', 'User login', 'Login', '2019-04-05 17:48:58'),
(7, 'USR00000001', 'User logout', 'Logout', '2019-04-05 17:49:56'),
(8, 'USR00000001', 'User login', 'Login', '2019-04-05 17:51:40');

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
  `id_indentifikasi` int(11) NOT NULL,
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
  `status` enum('Inden','Batal','Proses','') NOT NULL,
  `id_user` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id_detail_pesanan` int(11) NOT NULL,
  `no_pesanan` varchar(12) NOT NULL,
  `id_identifikasi` int(11) NOT NULL,
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
  `id_indentifikasi` int(11) NOT NULL,
  `qty_return_masuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
('USR00000003', 'Dian Ratna Sari', 'dianrs', 'm0ejl', 'Sales', '2019-04-05 17:54:39', 'user.jpg', 'Aktif', 'e2baa50d717f2e8'),
('USR00000004', 'test', 'test', 'qd9ee', '', '2019-04-05 18:01:52', 'user.jpg', 'Aktif', 'a94a8fe5ccb19ba'),
('USR00000005', 'Devan Dirgantara', 'devandp', 'ye37q', 'Manager', '2019-04-05 18:02:50', 'user.jpg', 'Aktif', 'cbb527c93eb9b52');

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
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_indentifikasi`),
  ADD KEY `id_persediaan` (`no_persediaan`);

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
  ADD KEY `id_indentifikasi` (`id_indentifikasi`);

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
  ADD KEY `id_identifikasi` (`id_identifikasi`);

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
  ADD KEY `id_indentifikasi` (`id_indentifikasi`),
  ADD KEY `no_return_masuk` (`no_return_masuk`);

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
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_indentifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `memorandum_detail`
--
ALTER TABLE `memorandum_detail`
  MODIFY `id_memorandum_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id_detail_pesanan` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `barang_keluar_detail_ibfk_2` FOREIGN KEY (`id_identifikasi`) REFERENCES `kategori` (`id_indentifikasi`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `barang_masuk_detail_ibfk_2` FOREIGN KEY (`id_identifikasi`) REFERENCES `kategori` (`id_indentifikasi`) ON UPDATE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `return_masuk` (`id_customer`) ON UPDATE CASCADE;

--
-- Constraints for table `kategori`
--
ALTER TABLE `kategori`
  ADD CONSTRAINT `kategori_ibfk_1` FOREIGN KEY (`no_persediaan`) REFERENCES `barang` (`no_persediaan`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `memorandum_detail_ibfk_2` FOREIGN KEY (`id_indentifikasi`) REFERENCES `kategori` (`id_indentifikasi`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `pesanan_detail_ibfk_1` FOREIGN KEY (`no_pesanan`) REFERENCES `pesanan` (`no_pesanan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_detail_ibfk_2` FOREIGN KEY (`id_identifikasi`) REFERENCES `kategori` (`id_indentifikasi`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `return_keluar_detail_ibfk_2` FOREIGN KEY (`id_identifikasi`) REFERENCES `kategori` (`id_indentifikasi`) ON UPDATE CASCADE;

--
-- Constraints for table `return_masuk`
--
ALTER TABLE `return_masuk`
  ADD CONSTRAINT `return_masuk_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE;

--
-- Constraints for table `return_masuk_detail`
--
ALTER TABLE `return_masuk_detail`
  ADD CONSTRAINT `return_masuk_detail_ibfk_1` FOREIGN KEY (`no_return_masuk`) REFERENCES `return_masuk` (`no_return_masuk`) ON UPDATE CASCADE,
  ADD CONSTRAINT `return_masuk_detail_ibfk_2` FOREIGN KEY (`id_indentifikasi`) REFERENCES `kategori` (`id_indentifikasi`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
