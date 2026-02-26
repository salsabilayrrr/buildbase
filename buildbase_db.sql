-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Feb 2026 pada 04.23
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
-- Struktur dari tabel `boq`
--

CREATE TABLE `boq` (
  `id_boq` int(11) NOT NULL,
  `id_rfq` int(11) DEFAULT NULL,
  `id_user_estimator` int(11) DEFAULT NULL,
  `total_biaya` double DEFAULT NULL,
  `status_boq` enum('Draft','Menunggu Evaluasi','Revisi','Disetujui') DEFAULT 'Draft',
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_rfq`
--

CREATE TABLE `data_rfq` (
  `id_rfq` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `tanggal_rfq` date NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status_rfq` varchar(50) DEFAULT 'Baru'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_boq`
--

CREATE TABLE `detail_boq` (
  `id_detail` int(11) NOT NULL,
  `id_boq` int(11) DEFAULT NULL,
  `id_material` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga_satuan` double DEFAULT NULL,
  `subtotal` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_keuangan`
--

CREATE TABLE `laporan_keuangan` (
  `id_laporan` int(11) NOT NULL,
  `id_boq` int(11) DEFAULT NULL,
  `nama_laporan` varchar(255) DEFAULT NULL,
  `file_pdf` varchar(255) DEFAULT NULL,
  `catatan_evaluasi` text DEFAULT NULL,
  `id_user_finance` int(11) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `material`
--

CREATE TABLE `material` (
  `id_material` int(11) NOT NULL,
  `nama_material` varchar(100) NOT NULL,
  `stok` int(11) DEFAULT 0,
  `satuan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `negosiasi_harga`
--

CREATE TABLE `negosiasi_harga` (
  `id_nego` int(11) NOT NULL,
  `id_boq` int(11) DEFAULT NULL,
  `harga_akhir` double DEFAULT NULL,
  `status_nego` enum('Pending','Disetujui','Ditolak') DEFAULT 'Pending',
  `tanggal_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notif` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `status_baca` tinyint(1) DEFAULT 0,
  `link_aksi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_perusahaan` varchar(150) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan_qc`
--

CREATE TABLE `pemeriksaan_qc` (
  `id_qc` int(11) NOT NULL,
  `id_produksi` int(11) DEFAULT NULL,
  `id_user_qc` int(11) DEFAULT NULL,
  `tanggal_periksa` timestamp NOT NULL DEFAULT current_timestamp(),
  `catatan_temuan` text DEFAULT NULL,
  `status_kelulusan` enum('Lolos','Gagal','Revisi') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan_negosiasi`
--

CREATE TABLE `pesan_negosiasi` (
  `id_pesan` int(11) NOT NULL,
  `id_boq` int(11) DEFAULT NULL,
  `pengirim` enum('finance','customer') DEFAULT NULL,
  `isi_pesan` text DEFAULT NULL,
  `harga_ajuan` double DEFAULT NULL,
  `waktu_kirim` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produksi`
--

CREATE TABLE `produksi` (
  `id_produksi` int(11) NOT NULL,
  `id_boq` int(11) DEFAULT NULL,
  `jadwal_produksi` date DEFAULT NULL,
  `status_produksi` enum('Pending','Proses','Selesai','QC Lolos','QC Gagal') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `shop_drawing`
--

CREATE TABLE `shop_drawing` (
  `id_drawing` int(11) NOT NULL,
  `id_rfq` int(11) DEFAULT NULL,
  `id_user_drafter` int(11) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `status_verifikasi` enum('Pending','Revisi','Disetujui') DEFAULT 'Pending',
  `catatan_engineer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Salsabila Yufli Ramadhani', 'salsabilayufli@gmail.com', '12345', 'manager', '2026-02-12 23:32:51'),
(2, 'Dyah Nayla Amalia Putri', 'dyahnayla@gmail.com', 'nayla123', 'cs', '2026-02-13 21:13:05'),
(3, 'Jeno', 'jeno.estimator@gmail.com', 'jeno123', 'estimator', '2026-02-13 21:13:05'),
(4, 'siti', 'siti.drafter@gmail.com', 'siti123', 'drafter', '2026-02-13 21:13:05'),
(5, 'nana', 'nana.engineer@gmail.com', 'nana123', 'engineer', '2026-02-13 21:13:05'),
(6, 'Martin', 'martin.finance@gmail.com', 'martin123', 'finance', '2026-02-13 21:13:05'),
(8, 'Charles', 'charles.qc@gmail.com', 'charles123', 'qc', '2026-02-13 21:13:05');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `boq`
--
ALTER TABLE `boq`
  ADD PRIMARY KEY (`id_boq`),
  ADD KEY `id_rfq` (`id_rfq`),
  ADD KEY `id_user_estimator` (`id_user_estimator`);

--
-- Indeks untuk tabel `data_rfq`
--
ALTER TABLE `data_rfq`
  ADD PRIMARY KEY (`id_rfq`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `detail_boq`
--
ALTER TABLE `detail_boq`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_boq` (`id_boq`),
  ADD KEY `id_material` (`id_material`);

--
-- Indeks untuk tabel `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_boq` (`id_boq`),
  ADD KEY `id_user_finance` (`id_user_finance`);

--
-- Indeks untuk tabel `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id_material`);

--
-- Indeks untuk tabel `negosiasi_harga`
--
ALTER TABLE `negosiasi_harga`
  ADD PRIMARY KEY (`id_nego`),
  ADD KEY `id_boq` (`id_boq`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notif`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `pemeriksaan_qc`
--
ALTER TABLE `pemeriksaan_qc`
  ADD PRIMARY KEY (`id_qc`),
  ADD KEY `id_produksi` (`id_produksi`),
  ADD KEY `id_user_qc` (`id_user_qc`);

--
-- Indeks untuk tabel `pesan_negosiasi`
--
ALTER TABLE `pesan_negosiasi`
  ADD PRIMARY KEY (`id_pesan`),
  ADD KEY `id_boq` (`id_boq`);

--
-- Indeks untuk tabel `produksi`
--
ALTER TABLE `produksi`
  ADD PRIMARY KEY (`id_produksi`),
  ADD KEY `id_boq` (`id_boq`);

--
-- Indeks untuk tabel `shop_drawing`
--
ALTER TABLE `shop_drawing`
  ADD PRIMARY KEY (`id_drawing`),
  ADD KEY `id_rfq` (`id_rfq`),
  ADD KEY `id_user_drafter` (`id_user_drafter`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `boq`
--
ALTER TABLE `boq`
  MODIFY `id_boq` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_rfq`
--
ALTER TABLE `data_rfq`
  MODIFY `id_rfq` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_boq`
--
ALTER TABLE `detail_boq`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `material`
--
ALTER TABLE `material`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `negosiasi_harga`
--
ALTER TABLE `negosiasi_harga`
  MODIFY `id_nego` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan_qc`
--
ALTER TABLE `pemeriksaan_qc`
  MODIFY `id_qc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesan_negosiasi`
--
ALTER TABLE `pesan_negosiasi`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produksi`
--
ALTER TABLE `produksi`
  MODIFY `id_produksi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `shop_drawing`
--
ALTER TABLE `shop_drawing`
  MODIFY `id_drawing` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `boq`
--
ALTER TABLE `boq`
  ADD CONSTRAINT `boq_ibfk_1` FOREIGN KEY (`id_rfq`) REFERENCES `data_rfq` (`id_rfq`),
  ADD CONSTRAINT `boq_ibfk_2` FOREIGN KEY (`id_user_estimator`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `data_rfq`
--
ALTER TABLE `data_rfq`
  ADD CONSTRAINT `data_rfq_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);

--
-- Ketidakleluasaan untuk tabel `detail_boq`
--
ALTER TABLE `detail_boq`
  ADD CONSTRAINT `detail_boq_ibfk_1` FOREIGN KEY (`id_boq`) REFERENCES `boq` (`id_boq`),
  ADD CONSTRAINT `detail_boq_ibfk_2` FOREIGN KEY (`id_material`) REFERENCES `material` (`id_material`);

--
-- Ketidakleluasaan untuk tabel `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  ADD CONSTRAINT `laporan_keuangan_ibfk_1` FOREIGN KEY (`id_boq`) REFERENCES `boq` (`id_boq`),
  ADD CONSTRAINT `laporan_keuangan_ibfk_2` FOREIGN KEY (`id_user_finance`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `negosiasi_harga`
--
ALTER TABLE `negosiasi_harga`
  ADD CONSTRAINT `negosiasi_harga_ibfk_1` FOREIGN KEY (`id_boq`) REFERENCES `boq` (`id_boq`);

--
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `pemeriksaan_qc`
--
ALTER TABLE `pemeriksaan_qc`
  ADD CONSTRAINT `pemeriksaan_qc_ibfk_1` FOREIGN KEY (`id_produksi`) REFERENCES `produksi` (`id_produksi`),
  ADD CONSTRAINT `pemeriksaan_qc_ibfk_2` FOREIGN KEY (`id_user_qc`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `pesan_negosiasi`
--
ALTER TABLE `pesan_negosiasi`
  ADD CONSTRAINT `pesan_negosiasi_ibfk_1` FOREIGN KEY (`id_boq`) REFERENCES `boq` (`id_boq`);

--
-- Ketidakleluasaan untuk tabel `produksi`
--
ALTER TABLE `produksi`
  ADD CONSTRAINT `produksi_ibfk_1` FOREIGN KEY (`id_boq`) REFERENCES `boq` (`id_boq`);

--
-- Ketidakleluasaan untuk tabel `shop_drawing`
--
ALTER TABLE `shop_drawing`
  ADD CONSTRAINT `shop_drawing_ibfk_1` FOREIGN KEY (`id_rfq`) REFERENCES `data_rfq` (`id_rfq`),
  ADD CONSTRAINT `shop_drawing_ibfk_2` FOREIGN KEY (`id_user_drafter`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
