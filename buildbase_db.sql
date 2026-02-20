-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Feb 2026 pada 05.36
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
-- Database: `buildbase_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('cs','estimator','drafter','engineer','finance','manager','qc') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Salsabila Yufli Ramadhani', 'salsabilayufli@gmail.com', '12345', 'manager', '2026-02-13 06:32:51'),
(2, 'Dyah Nayla Amalia Putri', 'dyahnayla425@gmail.com', 'nayla123', 'cs', '2026-02-14 04:13:05'),
(3, 'Lee Jeno', 'jeno.estimator@buildbase.com', 'jeno123', 'estimator', '2026-02-14 04:13:05'),
(4, 'Anh Keonho', 'keonho.drafter@buildbase.com', 'keonho123', 'drafter', '2026-02-14 04:13:05'),
(5, 'Kim Juhoon', 'juhoon.engineer@buildbase.com', 'juhoon123', 'engineer', '2026-02-14 04:13:05'),
(6, 'Martin', 'martin.finance@buildbase.com', 'martin123', 'finance', '2026-02-14 04:13:05'),
(7, 'Lee Jaemin', 'jaemin.manager@buildbase.com', 'jaemin123', 'manager', '2026-02-14 04:13:05'),
(8, 'Charles Leclerc', 'charles.qc@buildbase.com', 'leclerc123', 'qc', '2026-02-14 04:13:05');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
