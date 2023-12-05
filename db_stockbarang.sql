-- Adminer 4.8.1 MySQL 8.0.30 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `keluar`;
CREATE TABLE `keluar` (
  `id_keluar` int NOT NULL AUTO_INCREMENT,
  `id_barang` int NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `penerima` varchar(25) NOT NULL,
  `qty` int NOT NULL,
  PRIMARY KEY (`id_keluar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `keluar` (`id_keluar`, `id_barang`, `tanggal`, `penerima`, `qty`) VALUES
(1,	2,	'2021-11-27 15:34:48',	'Pembeli',	51),
(2,	4,	'2023-11-28 16:32:18',	'sa',	5),
(4,	7,	'2023-11-28 16:47:54',	'ojak',	2),
(14,	13,	'2023-12-01 03:44:38',	'as',	1),
(15,	14,	'2023-12-01 03:45:40',	'asep',	1),
(16,	15,	'2023-12-01 03:47:34',	'asep',	1),
(17,	16,	'2023-12-01 03:56:38',	'dudung',	1);

DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `login` (`id_user`, `username`, `email`, `password`) VALUES
(1,	'',	'k9@gmail.com',	'123'),
(2,	'farid',	'farid@test.com',	'farid'),
(3,	'gilang',	'gilang@test.com',	'gilang');

DROP TABLE IF EXISTS `masuk`;
CREATE TABLE `masuk` (
  `id_masuk` int NOT NULL AUTO_INCREMENT,
  `id_barang` int NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan` varchar(25) NOT NULL,
  `qty` int NOT NULL,
  PRIMARY KEY (`id_masuk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `masuk` (`id_masuk`, `id_barang`, `tanggal`, `keterangan`, `qty`) VALUES
(1,	2,	'2021-11-27 15:34:25',	'Udin',	100),
(2,	3,	'2023-11-28 16:27:35',	'f',	1),
(3,	4,	'2023-11-28 16:30:36',	's',	5),
(4,	5,	'2023-11-28 16:36:13',	'asep',	2),
(6,	8,	'2023-11-29 02:49:04',	'asep',	2),
(11,	15,	'2023-12-01 05:18:50',	'sa',	1);

DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `id_barang` int NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(25) NOT NULL,
  `deskripsi` varchar(25) NOT NULL,
  `stock` int NOT NULL,
  `harga` int NOT NULL,
  `total_harga` int NOT NULL,
  PRIMARY KEY (`id_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `stock` (`id_barang`, `nama_barang`, `deskripsi`, `stock`, `harga`, `total_harga`) VALUES
(15,	'kuaci',	'enak',	3,	5,	15),
(16,	'garpu',	'enak',	2,	10,	20),
(18,	'nasi',	'mantap',	22,	2000,	44000);

-- 2023-12-05 14:14:14
