-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Aug 24, 2021 at 12:33 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banana`
--
CREATE DATABASE IF NOT EXISTS `banana` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `banana`;

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `album_artist`
--

CREATE TABLE `album_artist` (
  `album_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `artist_type`
--

CREATE TABLE `artist_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artist_type`
--

INSERT INTO `artist_type` (`id`, `name`) VALUES
(1, 'main'),
(2, 'featuring'),
(3, 'prod.'),
(4, 'remix'),
(5, 'sample'),
(6, 'cover'),
(7, 'mashup');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210824122955', '2021-08-24 12:30:02', 1437);

-- --------------------------------------------------------

--
-- Table structure for table `mood`
--

CREATE TABLE `mood` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mood`
--

INSERT INTO `mood` (`id`, `name`) VALUES
(1, 'music');

-- --------------------------------------------------------

--
-- Table structure for table `song`
--

CREATE TABLE `song` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `song_album`
--

CREATE TABLE `song_album` (
  `song_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `song_artist`
--

CREATE TABLE `song_artist` (
  `song_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `song_has_artist`
--

CREATE TABLE `song_has_artist` (
  `id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `song_mood`
--

CREATE TABLE `song_mood` (
  `song_id` int(11) NOT NULL,
  `mood_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `album_artist`
--
ALTER TABLE `album_artist`
  ADD PRIMARY KEY (`album_id`,`artist_id`),
  ADD KEY `IDX_D322AB301137ABCF` (`album_id`),
  ADD KEY `IDX_D322AB30B7970CF8` (`artist_id`);

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artist_type`
--
ALTER TABLE `artist_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `mood`
--
ALTER TABLE `mood`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `song_album`
--
ALTER TABLE `song_album`
  ADD PRIMARY KEY (`song_id`,`album_id`),
  ADD KEY `IDX_F43CFB06A0BDB2F3` (`song_id`),
  ADD KEY `IDX_F43CFB061137ABCF` (`album_id`);

--
-- Indexes for table `song_artist`
--
ALTER TABLE `song_artist`
  ADD PRIMARY KEY (`song_id`,`artist_id`),
  ADD KEY `IDX_722870DA0BDB2F3` (`song_id`),
  ADD KEY `IDX_722870DB7970CF8` (`artist_id`);

--
-- Indexes for table `song_has_artist`
--
ALTER TABLE `song_has_artist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_97D31B0CA0BDB2F3` (`song_id`),
  ADD KEY `IDX_97D31B0CB7970CF8` (`artist_id`),
  ADD KEY `IDX_97D31B0CC54C8C93` (`type_id`);

--
-- Indexes for table `song_mood`
--
ALTER TABLE `song_mood`
  ADD PRIMARY KEY (`song_id`,`mood_id`),
  ADD KEY `IDX_70AA7803A0BDB2F3` (`song_id`),
  ADD KEY `IDX_70AA7803B889D33E` (`mood_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `artist_type`
--
ALTER TABLE `artist_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mood`
--
ALTER TABLE `mood`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `song`
--
ALTER TABLE `song`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `song_has_artist`
--
ALTER TABLE `song_has_artist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album_artist`
--
ALTER TABLE `album_artist`
  ADD CONSTRAINT `FK_D322AB301137ABCF` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D322AB30B7970CF8` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `song_album`
--
ALTER TABLE `song_album`
  ADD CONSTRAINT `FK_F43CFB061137ABCF` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F43CFB06A0BDB2F3` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `song_artist`
--
ALTER TABLE `song_artist`
  ADD CONSTRAINT `FK_722870DA0BDB2F3` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_722870DB7970CF8` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `song_has_artist`
--
ALTER TABLE `song_has_artist`
  ADD CONSTRAINT `FK_97D31B0CA0BDB2F3` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`),
  ADD CONSTRAINT `FK_97D31B0CB7970CF8` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`),
  ADD CONSTRAINT `FK_97D31B0CC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `artist_type` (`id`);

--
-- Constraints for table `song_mood`
--
ALTER TABLE `song_mood`
  ADD CONSTRAINT `FK_70AA7803A0BDB2F3` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_70AA7803B889D33E` FOREIGN KEY (`mood_id`) REFERENCES `mood` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
