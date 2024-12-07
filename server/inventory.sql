-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 05, 2024 at 01:04 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--
CREATE DATABASE IF NOT EXISTS `inventory` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `inventory`;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `id_history` int NOT NULL AUTO_INCREMENT,
  `id_produk` int NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `jumlah` int NOT NULL,
  `stok_awal` int NOT NULL,
  `stok_akhir` int NOT NULL,
  `id_user` int NOT NULL,
  `tanggal` timestamp NOT NULL,
  PRIMARY KEY (`id_history`),
  KEY `id_produk` (`id_produk`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

DROP TABLE IF EXISTS `pembelian`;
CREATE TABLE IF NOT EXISTS `pembelian` (
  `id_pembelian` int NOT NULL AUTO_INCREMENT,
  `id_produk` int NOT NULL,
  `id_user` int NOT NULL,
  `jumlah` int NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `tanggal` datetime NOT NULL,
  PRIMARY KEY (`id_pembelian`),
  KEY `id_produk` (`id_produk`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `pembelian`
--
DROP TRIGGER IF EXISTS `tambahi_stok_ketika_ada_pembelian`;
DELIMITER $$
CREATE TRIGGER `tambahi_stok_ketika_ada_pembelian` AFTER INSERT ON `pembelian` FOR EACH ROW BEGIN
  DECLARE stok_awal INT;
 DECLARE stok_akhir INT;

 -- Ambil stok awal dari tabel stok
 SELECT stok_terkini INTO stok_awal FROM stok WHERE id_produk = NEW.id_produk;

 -- tambahi stok sesuai dengan jumlah pembelian
 SET stok_akhir = stok_awal + NEW.jumlah;

 -- Perbarui stok di tabel stok
 UPDATE stok
 SET stok_terkini = stok_akhir
 WHERE id_produk = NEW.id_produk;

 -- Tambahkan data ke tabel history
 INSERT INTO history (id_produk,tipe,jumlah, stok_awal, stok_akhir,id_user, tanggal)
 VALUES ( NEW.id_produk, 'pembelian',NEW.jumlah, stok_awal, stok_akhir,NEW.id_user, NOW());

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

DROP TABLE IF EXISTS `penjualan`;
CREATE TABLE IF NOT EXISTS `penjualan` (
  `id_penjualan` int NOT NULL AUTO_INCREMENT,
  `id_produk` int NOT NULL,
  `id_user` int NOT NULL,
  `jumlah` int NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `total_harga` decimal(10,3) NOT NULL,
  `tanggal` datetime NOT NULL,
  PRIMARY KEY (`id_penjualan`),
  KEY `id_produk` (`id_produk`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `penjualan`
--
DROP TRIGGER IF EXISTS `kurangi_stok_ketika_ada_pembelian`;
DELIMITER $$
CREATE TRIGGER `kurangi_stok_ketika_ada_pembelian` AFTER INSERT ON `penjualan` FOR EACH ROW BEGIN
    DECLARE stok_awal INT;
    DECLARE stok_akhir INT;

    -- Ambil stok awal dari tabel stok
    SELECT stok_terkini INTO stok_awal FROM stok WHERE id_produk = NEW.id_produk;

    -- kurangi stok sesuai dengan jumlah penjualan
    SET stok_akhir = stok_awal - NEW.jumlah;

    -- Perbarui stok di tabel stok
    UPDATE stok
    SET stok_terkini = stok_akhir
    WHERE id_produk = NEW.id_produk;

    -- Tambahkan data ke tabel history
    INSERT INTO history (id_produk,tipe,jumlah, stok_awal, stok_akhir,id_user, tanggal)
    VALUES ( NEW.id_produk, 'penjualan',NEW.jumlah, stok_awal, stok_akhir,NEW.id_user, NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

DROP TABLE IF EXISTS `produk`;
CREATE TABLE IF NOT EXISTS `produk` (
  `id_produk` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `nama_produk` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `kategori` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok_awal` int NOT NULL,
  PRIMARY KEY (`id_produk`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `produk`
--
DROP TRIGGER IF EXISTS `Add_stok_after_add_produk`;
DELIMITER $$
CREATE TRIGGER `Add_stok_after_add_produk` AFTER INSERT ON `produk` FOR EACH ROW BEGIN
    DECLARE stok_aw INT;
    DECLARE stok_akhir INT;

	SET stok_aw = 0;

    -- tambahi stok sesuai dengan jumlah pembelian
    SET stok_akhir = stok_aw + NEW.stok_awal;

    -- add stok di tabel stok
     INSERT INTO stok (id_produk, stok_terkini)
 VALUES (NEW.id_produk, NEW.stok_awal);

    -- Tambahkan data ke tabel history
    INSERT INTO history (id_produk,tipe,jumlah, stok_awal, stok_akhir,id_user, tanggal)
    VALUES ( NEW.id_produk, 'Menambahkan Produk',NEW.stok_awal, stok_aw, stok_akhir,NEW.id_user, NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

DROP TABLE IF EXISTS `stok`;
CREATE TABLE IF NOT EXISTS `stok` (
  `id_produk` int NOT NULL,
  `stok_terkini` int NOT NULL,
  KEY `id_produk` (`id_produk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stok`
--
ALTER TABLE `stok`
  ADD CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
