-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2022 at 03:27 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jadwalkerja`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `kd_admin` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`kd_admin`, `username`, `password`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `kd_jadwal` int(10) NOT NULL,
  `tanggal` date NOT NULL,
  `nik` int(10) NOT NULL,
  `kd_shift` int(10) NOT NULL,
  `hari` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `nik` int(10) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `area` varchar(30) NOT NULL,
  `plotting` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`nik`, `nama_karyawan`, `area`, `plotting`) VALUES
(190506201, 'Iis Wulandari', 'Lantai 2', 'Toilet I.S 02W'),
(191119701, 'Sahrudin', 'Lantai 2', 'Selasar'),
(191119901, 'Salman Farisi', 'Lantai 2', 'Toilet I.S 02P'),
(191121101, 'Tuti Alawiyah', 'Lantai 2', 'Toilet I.S 01'),
(200307301, 'Abdul Kahfi', 'Lantai 2', 'Drop Off'),
(200901301, 'Bima Al Bantani', 'Lantai 2', 'Skybride'),
(200902601, 'M Yulpiadi', 'Lantai 2', 'Garbage'),
(201003501, 'Sintia Nur Islami', 'Lantai 2', 'SCP 2');

-- --------------------------------------------------------

--
-- Table structure for table `libur`
--

CREATE TABLE `libur` (
  `kd_libur` int(10) NOT NULL,
  `nik` int(10) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `hari` varchar(7) NOT NULL,
  `keterangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `libur`
--

INSERT INTO `libur` (`kd_libur`, `nik`, `nama_karyawan`, `tanggal`, `hari`, `keterangan`) VALUES
(1, 190506201, 'Iis Wulandari', '2022-01-17', 'Senin', 'Off Day'),
(2, 191119701, 'Sahrudin', '2022-01-18', 'Selasa', 'Off Day'),
(3, 191119901, 'Salman Farisi', '2022-01-19', 'Rabu', 'Off Day'),
(4, 191121101, 'Tuti Alawiyah', '2022-01-20', 'Kamis', 'Off Day'),
(5, 200307301, 'Abdul Kahfi', '2022-01-21', 'Jumat', 'Off Day'),
(6, 200901301, 'Bima Al Bantani', '2022-01-22', 'Sabtu', 'Off Day'),
(7, 200902601, 'M Yulpiadi', '2022-01-23', 'Minggu', 'Off Day'),
(8, 201003501, 'Sintia Nur Islami', '2022-01-24', 'Senin', 'Off Day');

-- --------------------------------------------------------

--
-- Table structure for table `parameter`
--

CREATE TABLE `parameter` (
  `kd` int(10) NOT NULL,
  `individu` varchar(4) NOT NULL,
  `iterasi` varchar(4) NOT NULL,
  `pc` varchar(4) NOT NULL,
  `pm` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parameter`
--

INSERT INTO `parameter` (`kd`, `individu`, `iterasi`, `pc`, `pm`) VALUES
(1, '100', '100', '0.8', '0.8');

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `kd_shift` int(10) NOT NULL,
  `nama_shift` varchar(10) NOT NULL,
  `jam_mulai` varchar(10) NOT NULL,
  `jam_selesai` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`kd_shift`, `nama_shift`, `jam_mulai`, `jam_selesai`) VALUES
(1, 'Pagi', '06.00 WIB', '14.00 WIB'),
(2, 'Siang', '14.00 WIB', '22.00 WIB'),
(3, 'Malam', '22.00 WIB', '06.00 WIB');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`kd_admin`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`kd_jadwal`),
  ADD KEY `nik` (`nik`,`kd_shift`),
  ADD KEY `kd_shift` (`kd_shift`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`nik`);

--
-- Indexes for table `libur`
--
ALTER TABLE `libur`
  ADD PRIMARY KEY (`kd_libur`),
  ADD KEY `nik` (`nik`);

--
-- Indexes for table `parameter`
--
ALTER TABLE `parameter`
  ADD PRIMARY KEY (`kd`),
  ADD KEY `kd` (`kd`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`kd_shift`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `kd_admin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `kd_jadwal` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `nik` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201003502;

--
-- AUTO_INCREMENT for table `libur`
--
ALTER TABLE `libur`
  MODIFY `kd_libur` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `parameter`
--
ALTER TABLE `parameter`
  MODIFY `kd` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `kd_shift` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`kd_shift`) REFERENCES `shift` (`kd_shift`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwal_ibfk_3` FOREIGN KEY (`kd_jadwal`) REFERENCES `parameter` (`kd`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `libur`
--
ALTER TABLE `libur`
  ADD CONSTRAINT `libur_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
