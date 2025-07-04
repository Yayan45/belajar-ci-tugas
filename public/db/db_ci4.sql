-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Jul 2025 pada 16.44
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ci4`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-05-07-143702', 'App\\Database\\Migrations\\User', 'default', 'App', 1746628925, 1),
(2, '2025-05-07-143715', 'App\\Database\\Migrations\\Product', 'default', 'App', 1746628925, 1),
(3, '2025-05-07-143722', 'App\\Database\\Migrations\\Transaction', 'default', 'App', 1746628925, 1),
(4, '2025-05-07-143729', 'App\\Database\\Migrations\\TransactionDetail', 'default', 'App', 1746628925, 1),
(5, '2025-05-07-150057', 'App\\Database\\Migrations\\CreateProductCategoryTable', 'default', 'App', 1746630222, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` double NOT NULL,
  `jumlah` int(5) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`id`, `nama`, `harga`, `jumlah`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'ASUS TUF A15 FA506NF', 10899000, 5, 'asus_tuf_a15.jpg', '2025-05-07 14:45:15', NULL),
(2, 'Asus Vivobook 14 A1404ZA', 6899000, 7, 'asus_vivobook_14.jpg', '2025-05-07 14:45:15', NULL),
(3, 'Lenovo IdeaPad Slim 3-14IAU7', 6299000, 5, 'lenovo_idepad_slim_3.jpg', '2025-05-07 14:45:15', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_category`
--

CREATE TABLE `product_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `product_category`
--

INSERT INTO `product_category` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Laptop Gaming ', '2025-05-07 15:13:09', '2025-05-23 15:48:23'),
(3, 'keyboard ', '2025-05-07 15:13:09', '2025-05-23 15:49:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `total_harga` double NOT NULL,
  `alamat` text NOT NULL,
  `ongkir` double DEFAULT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `transaction`
--

INSERT INTO `transaction` (`id`, `username`, `total_harga`, `alamat`, `ongkir`, `status`, `created_at`, `updated_at`) VALUES
(1, 'halimah.jane', 11399000, '', 500000, 0, '2025-06-13 15:18:45', '2025-06-13 15:18:45'),
(2, 'halimah.jane', 7299000, 'desa kalirandu', 400000, 0, '2025-06-13 15:21:50', '2025-06-13 15:21:50'),
(3, 'wuwais', 11399000, 'Pemalang', 500000, 0, '2025-06-18 06:13:52', '2025-06-18 06:13:52'),
(4, 'oliva61', 6911000, 'kalirandu dusun petinggen RT/01 RW/05', 12000, 0, '2025-07-03 14:35:54', '2025-07-03 14:35:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_detail`
--

CREATE TABLE `transaction_detail` (
  `id` int(11) UNSIGNED NOT NULL,
  `transaction_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `jumlah` int(5) NOT NULL,
  `diskon` double DEFAULT NULL,
  `subtotal_harga` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `transaction_detail`
--

INSERT INTO `transaction_detail` (`id`, `transaction_id`, `product_id`, `jumlah`, `diskon`, `subtotal_harga`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, 10899000, '2025-06-13 15:18:45', '2025-06-13 15:18:45'),
(2, 2, 2, 1, 0, 6899000, '2025-06-13 15:21:50', '2025-06-13 15:21:50'),
(3, 3, 1, 1, 0, 10899000, '2025-06-18 06:13:52', '2025-06-18 06:13:52'),
(4, 4, 2, 1, 0, 6899000, '2025-07-03 14:35:54', '2025-07-03 14:35:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'halimah.upik', 'betania.halim@yahoo.com', '$2y$10$p1rJNolYteMseG/Rd8w1XeVepXSOseRxmuJfS491qF37G3ANebIjy', 'guest', '2025-05-07 14:46:11', NULL),
(2, 'halimah.jane', 'eli95@nashiruddin.co.id', '$2y$10$XN8.qP0kocTIoJL/TCVaY.iGbaaFDGcIGBUkFA.P/YinPgBtKTY6i', 'admin', '2025-05-07 14:46:11', NULL),
(3, 'wuwais', 'pandu06@suryatmi.name', '$2y$10$eesRV7MFOsKbYVUuux4HleAWLT34ci6JHYxmAKkFYMV/zlmLYeyk2', 'admin', '2025-05-07 14:46:11', NULL),
(4, 'uda.pudjiastuti', 'lala03@nasyiah.id', '$2y$10$hMc9ceroRz6fGVe0JwfKreDrALyd7dFNz1aV6TAzSAcDTZNUTvo9S', 'jawak', '2025-05-07 14:46:11', NULL),
(5, 'oliva61', 'karja45@gmail.co.id', '$2y$10$ZUPiZHmJBMCNlpflEB2YXey86R6fJgY7UTzAG1kPFWsLi83liBMU.', 'guest', '2025-05-07 14:46:11', NULL),
(6, 'yayanRifan', 'usyi85@gmail.co.id', '$2y$10$bKquqtb3zv7aBSzZT.VFjutVcINz49GbWzH2yXKYGFmEQjx3kWdlC', 'admin', '2025-05-07 14:46:11', NULL),
(7, 'paramita.prakasa', 'zulaikha89@mansur.tv', '$2y$10$s3ks8hj0UfwWV.tENMP7pe.aFotspkz8ofEwmLUx9lCgTBbjmnTH2', 'guest', '2025-05-07 14:46:11', NULL),
(8, 'wwulandari', 'wulan97@gmail.com', '$2y$10$vTe1eScOi7JZPlKDejIDnevVo.OCkf6kSgUukpFwVf8M0IPJ5P8Qy', 'guest', '2025-05-07 14:46:11', NULL),
(9, 'cemani.hariyah', 'omar.waluyo@yahoo.com', '$2y$10$qE/8vp6/nICejny4SBKe5OlUkDngU3RPX5DwZ.qTpbvp26cwmrgLe', 'guest', '2025-05-07 14:46:11', NULL),
(10, 'budi.maryati', 'julia.kusmawati@gunarto.asia', '$2y$10$fgHqFvRzhFoawXyJJEBl8OnS3x2Qu8MLbTs6O/mdtEAtTzN4uuBxu', 'guest', '2025-05-07 14:46:11', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaction_detail`
--
ALTER TABLE `transaction_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `transaction_detail`
--
ALTER TABLE `transaction_detail`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
