-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Nov 2023 pada 07.22
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipangkat`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jenis`
--

CREATE TABLE `tb_jenis` (
  `id_jenis` int(11) NOT NULL,
  `jenis` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_jenis`
--

INSERT INTO `tb_jenis` (`id_jenis`, `jenis`) VALUES
(3, 'Perbaikan Lampu Jalan'),
(6, 'Penambahan Lampu Jalan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kunciapi`
--

CREATE TABLE `tb_kunciapi` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `kunci` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kunciapi`
--

INSERT INTO `tb_kunciapi` (`id`, `nama`, `kunci`) VALUES
(1, 'Google Maps API', 'AIzaSyCkyPyVxHBaWGGsJgiQDe0ttKfhE1zzDZ0'),
(2, 'WhatsApp Fonnte API', 'kQXDoqDmuLDAN!owWbbQ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengadu`
--

CREATE TABLE `tb_pengadu` (
  `id_pengadu` varchar(255) NOT NULL,
  `nama_pengadu` varchar(255) NOT NULL,
  `jekel` varchar(10) NOT NULL CHECK (`jekel` in ('Laki-Laki','Perempuan')),
  `no_hp` varchar(20) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_pengadu`
--

INSERT INTO `tb_pengadu` (`id_pengadu`, `nama_pengadu`, `jekel`, `no_hp`, `alamat`) VALUES
('111fae3b-cce3-4ce9-b115-6f31717826cc', 'Masyarakat', 'Laki-Laki', '-', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengaduan`
--

CREATE TABLE `tb_pengaduan` (
  `id_pengaduan` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `no_telpon` varchar(20) NOT NULL,
  `jenis` int(11) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `foto` varchar(500) NOT NULL,
  `waktu_aduan` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Proses',
  `tanggapan` text DEFAULT NULL,
  `author` varchar(255) NOT NULL,
  `lat` double(10,6) NOT NULL,
  `lng` double(10,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_pengaduan`
--

INSERT INTO `tb_pengaduan` (`id_pengaduan`, `judul`, `no_telpon`, `jenis`, `alamat`, `keterangan`, `foto`, `waktu_aduan`, `status`, `tanggapan`, `author`, `lat`, `lng`) VALUES
(93, 'Jem', '081227208060', 3, '', 'as', '20220414_133923.jpg', '2023-11-05 17:45:44', 'Tanggapi', 'ok', '111fae3b-cce3-4ce9-b115-6f31717826cc', -7.025459, 110.415053),
(94, 'Ubet', '087742006161', 6, '', 'qqq', 'madrid-spain-12th-dec-2022-tom-hanks-attends-the-el-peor-vecino-del-mundo-a-man-called-otto-premiere-at-capitol-cinema-in-madrid-spain-photo-by-carlos-dafontenurphoto-credit-nurphotoalamy-live-news-2M1K9AB(2).jpg', '2023-11-05 17:47:05', 'Proses', NULL, '111fae3b-cce3-4ce9-b115-6f31717826cc', -7.052718, 109.794325),
(95, 'Reffinka Meisya ', '082134420080', 6, '', 'Penambahan lampu jalan di pertigaan jalan medoho cempaka', 'InShot_20231102_184957046.jpg', '2023-11-05 18:48:47', 'Proses', NULL, '111fae3b-cce3-4ce9-b115-6f31717826cc', -6.987962, 110.446453),
(96, 'Alvira olivia zenia', '081918543721', 3, '', 'Perbaikan lampu jalan di jl medoho cempaka ', 'B85D56C9-6A78-4540-8F23-B6C681D15AE0.jpeg', '2023-11-05 18:50:48', 'Proses', NULL, '111fae3b-cce3-4ce9-b115-6f31717826cc', -6.987926, 110.446480),
(97, 'Mayaaa', '088221024030', 6, '', 'Masih banyak jalan terutama diarah desa desa gang masih belum dipasang lampu jalan  yang menyebabkan pembegalan ', '1693399461008.jpg', '2023-11-05 19:09:59', 'Proses', NULL, '111fae3b-cce3-4ce9-b115-6f31717826cc', -7.019056, 110.515446),
(98, 'Hanik', '083870318985', 6, '', 'Penambahan lampu jalan', '3E09CDAF-3B25-4A1F-A530-81AC9364552B.jpeg', '2023-11-05 19:16:16', 'Proses', NULL, '111fae3b-cce3-4ce9-b115-6f31717826cc', -7.048446, 110.059482),
(99, 'sesa', '085325454412', 3, '', 'lampu jalan', 'IMG_1608.jpeg', '2023-11-05 19:18:26', 'Proses', NULL, '111fae3b-cce3-4ce9-b115-6f31717826cc', -7.702996, 110.417223),
(100, 'Rasudhi', '081116789101', 3, '', 'Lampu pecah karena terkena petir, tolong di perbaiki?', 'a4c438b60a0977cb5769c45f7389bb12.jpg', '2023-11-06 20:59:09', 'Proses', NULL, '111fae3b-cce3-4ce9-b115-6f31717826cc', -7.010245, 110.388888),
(104, 'Widya', '08263451678', 6, '', 'Penambahan lampu jalan di dekat perempatan', 'Screenshot_20231106_083031.jpg', '2023-11-07 08:05:32', 'Proses', NULL, '111fae3b-cce3-4ce9-b115-6f31717826cc', -6.989044, 110.447436),
(105, 'Sulastri', '087654321890', 3, '', 'Tolong,.lampu jalan di dekat pertigaan gang di perbaiki ', 'IMG-20231101-WA0009.jpg', '2023-11-07 08:07:58', 'Proses', NULL, '111fae3b-cce3-4ce9-b115-6f31717826cc', -6.989044, 110.447436);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengguna`
--

CREATE TABLE `tb_pengguna` (
  `id_pengguna` varchar(255) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `level` varchar(50) NOT NULL CHECK (`level` in ('Administrator','Petugas','Pengadu')),
  `grup` varchar(10) NOT NULL CHECK (`grup` in ('A','B'))
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_pengguna`
--

INSERT INTO `tb_pengguna` (`id_pengguna`, `nama_pengguna`, `username`, `password`, `whatsapp`, `level`, `grup`) VALUES
('111fae3b-cce3-4ce9-b115-6f31717826cc', 'Masyarakat', 'pengadu', '123', '', 'Pengadu', 'B'),
('5351949a-6598-11eb-96e0-60eb69a13690', 'Reffrains', 'petugas', '123', '0897675745357', 'Petugas', 'A'),
('766b07b7-658e-11eb-96e0-60eb69a13690', 'Arifinza Eska Nugraha', 'admin', '123', '0895377897675', 'Administrator', 'A');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_jenis`
--
ALTER TABLE `tb_jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indeks untuk tabel `tb_kunciapi`
--
ALTER TABLE `tb_kunciapi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_pengadu`
--
ALTER TABLE `tb_pengadu`
  ADD PRIMARY KEY (`id_pengadu`);

--
-- Indeks untuk tabel `tb_pengaduan`
--
ALTER TABLE `tb_pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `jenis` (`jenis`),
  ADD KEY `author` (`author`);

--
-- Indeks untuk tabel `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_jenis`
--
ALTER TABLE `tb_jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_kunciapi`
--
ALTER TABLE `tb_kunciapi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_pengaduan`
--
ALTER TABLE `tb_pengaduan`
  MODIFY `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_pengaduan`
--
ALTER TABLE `tb_pengaduan`
  ADD CONSTRAINT `tb_pengaduan_ibfk_1` FOREIGN KEY (`jenis`) REFERENCES `tb_jenis` (`id_jenis`),
  ADD CONSTRAINT `tb_pengaduan_ibfk_2` FOREIGN KEY (`author`) REFERENCES `tb_pengadu` (`id_pengadu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
