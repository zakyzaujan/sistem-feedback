-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Des 2024 pada 12.54
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
-- Database: `feedback_system`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `feedback`
--

CREATE TABLE `feedback` (
  `id_feedback` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal_feedback` date NOT NULL,
  `isi_feedback` text NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `status` enum('pending','diproses','selesai') DEFAULT 'pending',
  `id_karyawan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `feedback`
--

INSERT INTO `feedback` (`id_feedback`, `id_user`, `tanggal_feedback`, `isi_feedback`, `id_kategori`, `status`, `id_karyawan`) VALUES
(9, 6, '2024-12-07', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 'selesai', NULL),
(10, 6, '2024-12-07', 'tes', 1, 'selesai', NULL),
(11, 6, '2024-12-07', 'tes', 3, 'selesai', NULL),
(12, 2, '2024-12-07', 'baru444', 1, 'selesai', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_feedback`
--

CREATE TABLE `kategori_feedback` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_feedback`
--

INSERT INTO `kategori_feedback` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Positif'),
(2, 'Negatif'),
(3, 'Saran');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL,
  `id_feedback` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `balasan` text NOT NULL,
  `tanggal_balasan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_log`, `id_feedback`, `id_karyawan`, `balasan`, `tanggal_balasan`) VALUES
(10, 9, 5, 'What is Lorem Ipsum? From its medieval origins to the digital era, learn everything there is to know about the ubiquitous lorem ipsum passage.', '2024-12-07 12:18:34'),
(11, 10, 5, 'ok', '2024-12-07 12:28:28'),
(12, 11, 3, '123456789', '2024-12-07 12:39:31'),
(13, 12, 3, '78ui', '2024-12-07 12:39:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `email_user` varchar(100) NOT NULL,
  `password_user` varchar(100) NOT NULL,
  `role_user` enum('pemilik','karyawan','pengguna') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `email_user`, `password_user`, `role_user`) VALUES
(2, 'user1', 'user1@gmail.com', 'user1', 'pengguna'),
(3, 'karyawan1', 'karyawan1@gmail.com', 'karyawan1', 'karyawan'),
(5, 'karyawan2', 'karyawan2@gmail.com', 'karyawan2', 'karyawan'),
(6, 'user2', 'user2@gmail.com', 'user2', 'pengguna');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id_feedback`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `kategori_feedback`
--
ALTER TABLE `kategori_feedback`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_feedback` (`id_feedback`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email_user` (`email_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id_feedback` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `kategori_feedback`
--
ALTER TABLE `kategori_feedback`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_feedback` (`id_kategori`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`id_feedback`) REFERENCES `feedback` (`id_feedback`) ON DELETE CASCADE,
  ADD CONSTRAINT `log_aktivitas_ibfk_2` FOREIGN KEY (`id_karyawan`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
