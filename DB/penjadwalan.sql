-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Jul 2023 pada 15.43
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjadwalan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `links`
--

CREATE TABLE `links` (
  `id` bigint(100) NOT NULL,
  `date` date NOT NULL,
  `vroom_id` bigint(100) NOT NULL,
  `link` varchar(255) NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `links`
--

INSERT INTO `links` (`id`, `date`, `vroom_id`, `link`, `start`, `end`, `status`, `created_at`) VALUES
(3, '2023-06-10', 3, 'https://zoom.us/google', '15:57:00', '16:57:00', 2, '2023-06-10 07:16:34'),
(7, '2023-06-16', 4, 'https://zoom.us/google123', '09:48:00', '10:48:00', 1, '2023-06-14 01:01:05'),
(8, '2023-06-12', 5, 'https://zoom.us/google', '10:20:00', '11:20:00', 3, '2023-06-12 01:30:08'),
(14, '2023-07-18', 5, 'https:zoom/test', '12:53:00', '14:53:00', 2, '2023-07-18 03:54:27'),
(15, '2023-07-20', 5, 'https:zoom/test', '15:22:00', '16:22:00', 2, '2023-07-20 06:22:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Petugas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `status`) VALUES
(17, 'Ruang 3', 1),
(18, 'ruang 4', 1),
(19, 'Ruang 5', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `user_borrower_id` varchar(255) NOT NULL,
  `room_id` bigint(255) DEFAULT NULL,
  `vroom_id` bigint(255) DEFAULT NULL,
  `requested_at` datetime DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `schedules`
--

INSERT INTO `schedules` (`id`, `date`, `start`, `end`, `description`, `status`, `user_borrower_id`, `room_id`, `vroom_id`, `requested_at`, `approved_at`, `created_at`, `updated_at`) VALUES
(361, '2023-07-03', '11:13:00', '12:13:00', '12312', 2, 'nandes', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2023-07-03 02:13:19', NULL),
(367, '2023-07-05', '15:01:00', '17:01:00', '214', 2, 'des', NULL, NULL, NULL, NULL, '2023-07-04 07:01:43', '2023-07-05 05:20:23'),
(376, '2023-07-18', '12:51:00', '15:51:00', '123321', 2, 'fernandes', NULL, NULL, NULL, NULL, '2023-07-18 03:53:09', NULL),
(377, '2023-07-20', '14:09:00', '15:09:00', '123321', 2, 'nandes2', NULL, NULL, NULL, NULL, '2023-07-20 05:09:24', NULL),
(378, '2023-07-20', '16:20:00', '17:20:00', '123321', 2, 'fernandes', NULL, NULL, NULL, NULL, '2023-07-20 06:21:18', NULL),
(379, '2023-07-20', '15:31:00', '16:30:00', '123', 2, 'nandes', NULL, NULL, NULL, NULL, '2023-07-20 06:31:09', NULL),
(380, '2023-07-20', '15:32:00', '16:32:00', 'test27', 2, 'nandes', NULL, NULL, NULL, NULL, '2023-07-20 06:33:28', NULL),
(381, '2023-07-20', '15:33:00', '16:33:00', 'test27', 2, 'nandes', NULL, NULL, NULL, NULL, '2023-07-20 06:34:07', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedule_room`
--

CREATE TABLE `schedule_room` (
  `id` bigint(100) NOT NULL,
  `schedule_id` bigint(100) NOT NULL,
  `room_id` bigint(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `schedule_room`
--

INSERT INTO `schedule_room` (`id`, `schedule_id`, `room_id`) VALUES
(107, 361, 1),
(108, 362, 1),
(111, 363, 18),
(113, 368, 1),
(114, 368, 17),
(115, 369, 1),
(116, 369, 17),
(119, 367, 6),
(120, 367, 1),
(121, 371, 1),
(122, 370, 1),
(123, 376, 1),
(124, 377, 1),
(125, 378, 1),
(126, 378, 18),
(127, 379, 17),
(128, 380, 17),
(129, 381, 17);

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedule_vroom`
--

CREATE TABLE `schedule_vroom` (
  `id` bigint(100) NOT NULL,
  `schedule_id` bigint(100) NOT NULL,
  `vroom_id` bigint(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `schedule_vroom`
--

INSERT INTO `schedule_vroom` (`id`, `schedule_id`, `vroom_id`) VALUES
(11, 361, 3),
(12, 361, 5),
(13, 362, 3),
(15, 363, 5),
(19, 368, 3),
(20, 368, 4),
(21, 368, 5),
(22, 369, 3),
(24, 369, 5),
(29, 367, 3),
(30, 367, 2),
(31, 367, 4),
(32, 367, 5),
(33, 370, 2),
(34, 371, 2),
(35, 371, 3),
(36, 376, 3),
(37, 376, 4),
(38, 376, 5),
(39, 377, 2),
(40, 378, 3),
(41, 379, 3),
(42, 379, 4),
(43, 380, 3),
(44, 381, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`, `phone`, `gender`, `role_id`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'nandes@gmail.com', '$2y$10$4Grk797eEQ9JjrY.xT64kuB3fvtYwlyHRMWnxbtGGwuuBZth03h56', '082146335727', 'Pria', 1, 1, NULL, '2022-05-13 07:34:36', '2022-05-13 07:34:36'),
(2, 'petugas', 'petugas', 'petugas@gmail.com', '$2y$10$GXqA3afWz8y15M4GwlXYA.KZfmv5aYleweoEp/NrE0QQN1BIeyhbW', '089671800585', 'Pria', 2, 1, 'BiEZXOWAot1SSGSL6ycGFhoqzbxgXZQ9vDR2tPzkEEejMssx81KXWPGYSuQ4', '2022-05-13 07:34:36', '2022-05-26 16:21:25'),
(6, 'test', 'test', 'test@gmail.com', '$2y$10$07HY0VCnkeSEeuXQMMMecumTqtLl4jeTQ/ikezd.jqKXJWik2xQYq', '142143124', 'Pria', 2, 1, NULL, '2023-05-15 22:18:06', '2023-07-06 02:13:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vrooms`
--

CREATE TABLE `vrooms` (
  `id` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `vrooms`
--

INSERT INTO `vrooms` (`id`, `name`, `status`) VALUES
(2, 'zoom meeting 1', 0),
(3, 'zoom meeting 2', 1),
(4, 'zoom meeting 3', 1),
(5, 'zoom meeting 4', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `schedule_room`
--
ALTER TABLE `schedule_room`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `schedule_vroom`
--
ALTER TABLE `schedule_vroom`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `vrooms`
--
ALTER TABLE `vrooms`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `links`
--
ALTER TABLE `links`
  MODIFY `id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=382;

--
-- AUTO_INCREMENT untuk tabel `schedule_room`
--
ALTER TABLE `schedule_room`
  MODIFY `id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT untuk tabel `schedule_vroom`
--
ALTER TABLE `schedule_vroom`
  MODIFY `id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `vrooms`
--
ALTER TABLE `vrooms`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
