-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2025 at 07:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventori_sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_lokasi` int(11) DEFAULT NULL,
  `kode_barang` varchar(50) DEFAULT NULL,
  `kondisi` enum('Baik','Rusak Ringan','Rusak Berat') DEFAULT 'Baik',
  `jumlah` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `id_kategori`, `id_lokasi`, `kode_barang`, `kondisi`, `jumlah`) VALUES
(1, 'stop kontak', 1, 1, '1', 'Baik', 4),
(2, 'komputer', 1, 2, '2', 'Rusak Ringan', 4),
(3, 'printer', 1, 1, '3', 'Baik', 10),
(4, 'ac', 1, 1, '4', 'Baik', 4),
(5, 'meja', 2, 6, '5', 'Baik', 20),
(6, 'kursi', 2, 6, '6', 'Baik', 40),
(7, 'papan tilis', 2, 5, '10', 'Baik', 10),
(8, 'ac', 1, 3, '7', 'Rusak Berat', 3);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'perlengkapan eleltronik'),
(2, 'perabot'),
(3, 'peralatan olahraga'),
(4, 'perlengkapan sekolah'),
(5, 'bangunan dan tanah'),
(6, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` int(11) NOT NULL,
  `nama_lokasi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `nama_lokasi`) VALUES
(1, 'lab 1'),
(2, 'lab 2'),
(3, 'Ruangan Kepala sekolah'),
(4, 'Ruangan Administrasi'),
(5, 'Ruangan Kelas'),
(6, 'Gudang'),
(7, 'lab 3');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `nama_peminjam` varchar(100) DEFAULT NULL,
  `tgl_pinjam` datetime DEFAULT NULL,
  `tanggal_kembali` datetime DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_barang`, `nama_peminjam`, `tgl_pinjam`, `tanggal_kembali`, `keterangan`, `status`) VALUES
(1, 1, 'Irfan Armansyah', '2025-06-20 05:39:00', '2025-06-20 11:15:15', NULL, 'Dikembalikan'),
(2, 2, 'arman', '2025-06-20 10:52:00', '2025-06-20 11:03:07', NULL, 'Dikembalikan'),
(3, 3, 'haha', '2025-06-20 11:12:00', '2025-06-20 15:55:52', NULL, 'Dikembalikan'),
(4, 2, 'riwal', '2025-06-20 11:13:00', NULL, NULL, 'dipinjam'),
(5, 3, 'facri', '2025-06-20 11:13:00', NULL, NULL, 'dipinjam'),
(6, 3, 'yoo', '2025-06-20 11:13:00', NULL, NULL, 'dipinjam');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `nama_lengkap`, `password`) VALUES
(3, 'irfan', 'irfan armansyah', '827ccb0eea8a706c4c34a16891f84e7b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_lokasi` (`id_lokasi`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id_lokasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
