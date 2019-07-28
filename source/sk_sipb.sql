-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jul 2019 pada 01.43
-- Versi server: 10.1.40-MariaDB
-- Versi PHP: 7.1.29

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
-- Struktur dari tabel `barang`
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `no_keluar` varchar(11) NOT NULL,
  `tgl_keluar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_customer` varchar(6) NOT NULL,
  `alamat_kirim` varchar(200) NOT NULL,
  `no_sp` varchar(20) NOT NULL,
  `ekspedisi` varchar(30) NOT NULL,
  `no_truk` varchar(9) NOT NULL,
  `status` enum('Proses','Disetujui','','') NOT NULL,
  `id_user` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar_detail`
--

CREATE TABLE `barang_keluar_detail` (
  `id_keluar_detail` int(11) NOT NULL,
  `no_keluar` varchar(11) NOT NULL,
  `id_identifikasi` int(11) NOT NULL,
  `qty_keluar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `no_masuk` varchar(11) NOT NULL,
  `no_surat` varchar(20) NOT NULL,
  `no_po` varchar(20) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `id_supplier` varchar(6) NOT NULL,
  `status` enum('Proses','Disetujui','','') NOT NULL,
  `id_user` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk_detail`
--

CREATE TABLE `barang_masuk_detail` (
  `id_masuk_detail` int(11) NOT NULL,
  `no_masuk` varchar(11) NOT NULL,
  `id_identifikasi` int(11) NOT NULL,
  `qty_masuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
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
-- Struktur dari tabel `log`
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
-- Dumping data untuk tabel `log`
--

INSERT INTO `log` (`id_log`, `user`, `id_ref`, `refrensi`, `keterangan`, `kategori`, `tgl_log`) VALUES
(192, 'USR001', '-', 'Auth', 'User login', 'Login', '2019-07-28 22:40:42'),
(193, 'USR001', '-', 'Auth', 'User logout', 'Logout', '2019-07-28 22:40:49'),
(194, 'USR001', '-', 'Auth', 'User login', 'Login', '2019-07-28 22:41:03'),
(195, 'USR001', 'USR002', 'User', 'Menambah data user baru', 'Add', '2019-07-28 23:08:18'),
(196, 'USR001', '-', 'Auth', 'User logout', 'Logout', '2019-07-28 23:08:25'),
(197, 'USR002', '-', 'Auth', 'User login', 'Login', '2019-07-28 23:08:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memorandum`
--

CREATE TABLE `memorandum` (
  `no_memo` varchar(15) NOT NULL,
  `tgl_memo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan_memo` varchar(200) NOT NULL,
  `id_user` varchar(11) NOT NULL,
  `status` enum('Proses','Batal','Disetujui','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `memorandum_detail`
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
-- Struktur dari tabel `pesanan`
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
-- Struktur dari tabel `pesanan_detail`
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
-- Struktur dari tabel `return_keluar`
--

CREATE TABLE `return_keluar` (
  `no_return_keluar` varchar(15) NOT NULL,
  `tgl_return` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `no_ref` varchar(20) NOT NULL,
  `status` enum('Proses','Batal','Disetujui','') NOT NULL,
  `id_supplier` varchar(6) NOT NULL,
  `id_user` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `return_keluar_detail`
--

CREATE TABLE `return_keluar_detail` (
  `id_dreturn_keluar` int(11) NOT NULL,
  `no_return_keluar` varchar(15) NOT NULL,
  `id_identifikasi` int(11) NOT NULL,
  `qty_return_keluar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `return_masuk`
--

CREATE TABLE `return_masuk` (
  `no_return_masuk` varchar(15) NOT NULL,
  `tgl_return` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `no_ref` varchar(20) NOT NULL,
  `status` enum('Proses','Disetujui','Batal','') NOT NULL,
  `id_customer` varchar(6) NOT NULL,
  `id_user` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `return_masuk_detail`
--

CREATE TABLE `return_masuk_detail` (
  `id_dreturn_masuk` int(11) NOT NULL,
  `no_return_masuk` varchar(15) NOT NULL,
  `id_identifikasi` int(11) NOT NULL,
  `qty_return_masuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock`
--

CREATE TABLE `stock` (
  `id_identifikasi` int(11) NOT NULL,
  `no_persediaan` varchar(15) NOT NULL,
  `no_identifikasi` varchar(10) NOT NULL,
  `keterangan` varchar(15) NOT NULL,
  `saldo_awal` int(11) NOT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
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
-- Struktur dari tabel `user`
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
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`, `level`, `tgl_registrasi`, `foto`, `status`, `token`) VALUES
('USR001', 'Haviz Indra Maulana', 'helpdesk', 'helpdesk', 'Helpdesk', '2019-07-28 22:40:34', 'user.jpg', 'Aktif', '875a8f2f42c570f'),
('USR002', 'Haviz Indra Maulana', 'HavizIM', 'k0gpc', 'Manager', '2019-07-28 23:08:18', 'user.jpg', 'Aktif', 'd8fbc0f237a2667');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`no_persediaan`);

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`no_keluar`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indeks untuk tabel `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  ADD PRIMARY KEY (`id_keluar_detail`),
  ADD KEY `no_keluar` (`no_keluar`),
  ADD KEY `id_identifikasi` (`id_identifikasi`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`no_masuk`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  ADD PRIMARY KEY (`id_masuk_detail`),
  ADD KEY `no_masuk` (`no_masuk`),
  ADD KEY `id_identifikasi` (`id_identifikasi`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indeks untuk tabel `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `user` (`user`);

--
-- Indeks untuk tabel `memorandum`
--
ALTER TABLE `memorandum`
  ADD PRIMARY KEY (`no_memo`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `memorandum_detail`
--
ALTER TABLE `memorandum_detail`
  ADD PRIMARY KEY (`id_memorandum_detail`),
  ADD KEY `no_memo` (`no_memo`),
  ADD KEY `id_indentifikasi` (`id_identifikasi`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`no_pesanan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indeks untuk tabel `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD PRIMARY KEY (`id_detail_pesanan`),
  ADD KEY `no_pesanan` (`no_pesanan`),
  ADD KEY `id_identifikasi` (`no_persediaan`),
  ADD KEY `no_persediaan` (`no_persediaan`);

--
-- Indeks untuk tabel `return_keluar`
--
ALTER TABLE `return_keluar`
  ADD PRIMARY KEY (`no_return_keluar`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `return_keluar_detail`
--
ALTER TABLE `return_keluar_detail`
  ADD PRIMARY KEY (`id_dreturn_keluar`),
  ADD KEY `no_return_keluar` (`no_return_keluar`),
  ADD KEY `id_identifikasi` (`id_identifikasi`);

--
-- Indeks untuk tabel `return_masuk`
--
ALTER TABLE `return_masuk`
  ADD PRIMARY KEY (`no_return_masuk`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `return_masuk_detail`
--
ALTER TABLE `return_masuk_detail`
  ADD PRIMARY KEY (`id_dreturn_masuk`),
  ADD KEY `id_indentifikasi` (`id_identifikasi`),
  ADD KEY `no_return_masuk` (`no_return_masuk`);

--
-- Indeks untuk tabel `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_identifikasi`),
  ADD KEY `id_persediaan` (`no_persediaan`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  MODIFY `id_keluar_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  MODIFY `id_masuk_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT untuk tabel `memorandum_detail`
--
ALTER TABLE `memorandum_detail`
  MODIFY `id_memorandum_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id_detail_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `return_keluar_detail`
--
ALTER TABLE `return_keluar_detail`
  MODIFY `id_dreturn_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `return_masuk_detail`
--
ALTER TABLE `return_masuk_detail`
  MODIFY `id_dreturn_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `stock`
--
ALTER TABLE `stock`
  MODIFY `id_identifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_keluar_ibfk_2` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  ADD CONSTRAINT `barang_keluar_detail_ibfk_1` FOREIGN KEY (`no_keluar`) REFERENCES `barang_keluar` (`no_keluar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_keluar_detail_ibfk_2` FOREIGN KEY (`id_identifikasi`) REFERENCES `stock` (`id_identifikasi`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  ADD CONSTRAINT `barang_masuk_detail_ibfk_1` FOREIGN KEY (`no_masuk`) REFERENCES `barang_masuk` (`no_masuk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_detail_ibfk_2` FOREIGN KEY (`id_identifikasi`) REFERENCES `stock` (`id_identifikasi`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `memorandum`
--
ALTER TABLE `memorandum`
  ADD CONSTRAINT `memorandum_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `memorandum_detail`
--
ALTER TABLE `memorandum_detail`
  ADD CONSTRAINT `memorandum_detail_ibfk_1` FOREIGN KEY (`no_memo`) REFERENCES `memorandum` (`no_memo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `memorandum_detail_ibfk_2` FOREIGN KEY (`id_identifikasi`) REFERENCES `stock` (`id_identifikasi`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD CONSTRAINT `pesanan_detail_ibfk_1` FOREIGN KEY (`no_pesanan`) REFERENCES `pesanan` (`no_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_detail_ibfk_2` FOREIGN KEY (`no_persediaan`) REFERENCES `barang` (`no_persediaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `return_keluar`
--
ALTER TABLE `return_keluar`
  ADD CONSTRAINT `return_keluar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `return_keluar_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `return_keluar_detail`
--
ALTER TABLE `return_keluar_detail`
  ADD CONSTRAINT `return_keluar_detail_ibfk_1` FOREIGN KEY (`no_return_keluar`) REFERENCES `return_keluar` (`no_return_keluar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `return_keluar_detail_ibfk_2` FOREIGN KEY (`id_identifikasi`) REFERENCES `stock` (`id_identifikasi`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `return_masuk`
--
ALTER TABLE `return_masuk`
  ADD CONSTRAINT `return_masuk_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `return_masuk_ibfk_2` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `return_masuk_detail`
--
ALTER TABLE `return_masuk_detail`
  ADD CONSTRAINT `return_masuk_detail_ibfk_1` FOREIGN KEY (`no_return_masuk`) REFERENCES `return_masuk` (`no_return_masuk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `return_masuk_detail_ibfk_2` FOREIGN KEY (`id_identifikasi`) REFERENCES `stock` (`id_identifikasi`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`no_persediaan`) REFERENCES `barang` (`no_persediaan`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
