-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2022 at 11:54 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jsl_db`
--
-- CREATE DATABASE IF NOT EXISTS `jsl_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
-- USE `jsl_db`;

-- --------------------------------------------------------

--
-- Table structure for table `combinations`
--

DROP TABLE IF EXISTS `combinations`;
CREATE TABLE `combinations` (
  `comb_id` int(11) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `added_date` date NOT NULL,
  `added_time` time NOT NULL,
  `isFinished` int(11) NOT NULL DEFAULT 0 COMMENT 'is finished or not',
  `comment` text NOT NULL,
  `UserID` int(11) NOT NULL,
  `addedBy` int(11) NOT NULL,
  `isShowed` int(11) NOT NULL DEFAULT 0,
  `showed_date` date NOT NULL,
  `showed_time` time NOT NULL,
  `isAccepted` int(11) NOT NULL DEFAULT -1 COMMENT 'is accepts from technical man or not',
  `finished_date` date NOT NULL,
  `finished_time` time NOT NULL,
  `lastEditDate` date NOT NULL,
  `lastEditTime` time NOT NULL,
  `cost` int(11) NOT NULL,
  `tech_comment` text NOT NULL,
  `isReviewed` int(11) NOT NULL DEFAULT 0,
  `reviewed_date` date NOT NULL,
  `reviewed_time` time NOT NULL,
  `money_review` int(11) NOT NULL DEFAULT 0,
  `qty_service` int(11) NOT NULL DEFAULT 0,
  `qty_emp` int(11) NOT NULL DEFAULT 0,
  `qty_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `combinations`:
--

-- --------------------------------------------------------

--
-- Table structure for table `combinations_media`
--

DROP TABLE IF EXISTS `combinations_media`;
CREATE TABLE `combinations_media` (
  `id` int(11) NOT NULL,
  `comb_id` int(11) NOT NULL,
  `media` text NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `combinations_media`:
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `company_id` varchar(20) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `db_name` varchar(25) NOT NULL,
  `manager_name` varchar(50) NOT NULL,
  `manager_phone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `companies`:
--

-- --------------------------------------------------------

--
-- Table structure for table `comp_sugg`
--

DROP TABLE IF EXISTS `comp_sugg`;
CREATE TABLE `comp_sugg` (
  `id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `sugg` text NOT NULL,
  `added_date` date NOT NULL,
  `activate_status` int(11) NOT NULL DEFAULT 0,
  `admin_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `comp_sugg`:
--   `UserID`
--       `users` -> `UserID`
--

-- --------------------------------------------------------

--
-- Table structure for table `conn_types`
--

DROP TABLE IF EXISTS `conn_types`;
CREATE TABLE `conn_types` (
  `id` int(11) NOT NULL,
  `conn_name` varchar(50) NOT NULL,
  `notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `conn_types`:
--

-- --------------------------------------------------------

--
-- Table structure for table `direction`
--

DROP TABLE IF EXISTS `direction`;
CREATE TABLE `direction` (
  `direction_id` int(11) NOT NULL,
  `direction_name` varchar(50) NOT NULL,
  `direction_ip` varchar(20) NOT NULL,
  `added_date` date NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `direction`:
--   `added_by`
--       `users` -> `UserID`
--

-- --------------------------------------------------------

--
-- Table structure for table `license`
--

DROP TABLE IF EXISTS `license`;
CREATE TABLE `license` (
  `ID` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `expire_date` date NOT NULL,
  `isEnded` int(11) NOT NULL DEFAULT 0,
  `isTrial` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `license`:
--
TRUNCATE TABLE `license`;

--
-- Dumping data for table `license`
--
INSERT INTO `license` VALUES
(1, 1, '2022-10-24', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `malfunctions`
--

DROP TABLE IF EXISTS `malfunctions`;
CREATE TABLE `malfunctions` (
  `mal_id` int(11) NOT NULL COMMENT 'Malfunction ID',
  `mng_id` int(11) NOT NULL COMMENT 'Manager ID',
  `tech_id` int(11) NOT NULL COMMENT 'Technical ID',
  `client_id` int(11) NOT NULL COMMENT 'Client ID',
  `descreption` text NOT NULL COMMENT 'Malfunction description',
  `added_date` date NOT NULL COMMENT 'Malfunction date',
  `added_time` time NOT NULL COMMENT 'Malfunction time',
  `mal_status` int(11) NOT NULL DEFAULT 0 COMMENT 'Malfunction Status',
  `cost` int(11) NOT NULL DEFAULT 0,
  `repaired_date` date NOT NULL,
  `repaired_time` time NOT NULL,
  `tech_comment` text NOT NULL,
  `isShowed` int(11) NOT NULL DEFAULT 0,
  `showed_date` date NOT NULL,
  `showed_time` time NOT NULL,
  `isAccepted` int(11) NOT NULL DEFAULT -1,
  `isReviewed` int(11) NOT NULL DEFAULT 0,
  `reviewed_date` date NOT NULL,
  `reviewed_time` time NOT NULL,
  `money_review` int(11) NOT NULL DEFAULT 0,
  `qty_service` int(11) NOT NULL DEFAULT 0,
  `qty_emp` int(11) NOT NULL DEFAULT 0,
  `qty_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `malfunctions`:
--   `client_id`
--       `pieces` -> `piece_id`
--   `mng_id`
--       `users` -> `UserID`
--   `tech_id`
--       `users` -> `UserID`
--

-- --------------------------------------------------------

--
-- Table structure for table `malfunctions_media`
--

DROP TABLE IF EXISTS `malfunctions_media`;
CREATE TABLE `malfunctions_media` (
  `id` int(11) NOT NULL,
  `mal_id` int(11) NOT NULL,
  `media` text NOT NULL,
  `type` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `malfunctions_media`:
--

-- --------------------------------------------------------

--
-- Table structure for table `pieces`
--

DROP TABLE IF EXISTS `pieces`;
CREATE TABLE `pieces` (
  `piece_id` int(11) NOT NULL,
  `piece_ip` varchar(20) NOT NULL,
  `piece_pass` varchar(50) NOT NULL,
  `piece_name` varchar(50) NOT NULL,
  `conn_type` varchar(20) NOT NULL,
  `added_date` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `direct` int(11) NOT NULL DEFAULT 0 COMMENT 'direct connection to the source',
  `username` varchar(50) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `direction_id` int(11) DEFAULT NULL,
  `notes` varchar(500) DEFAULT NULL,
  `ssid` varchar(50) DEFAULT NULL,
  `pass_connection` varchar(50) DEFAULT NULL,
  `frequency` varchar(50) DEFAULT NULL,
  `device_type` varchar(50) DEFAULT NULL,
  `mac_add` varchar(25) DEFAULT NULL COMMENT 'mac address of the piece'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `pieces`:
--   `added_by`
--       `users` -> `UserID`
--   `conn_type`
--       `conn_types` -> `id`
--   `direction_id`
--       `direction` -> `direction_id`
--   `source_id`
--       `pieces` -> `piece_id`
--   `type_id`
--       `types` -> `type_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `pieces_additional`
--

DROP TABLE IF EXISTS `pieces_additional`;
CREATE TABLE `pieces_additional` (
  `piece_id` int(11) NOT NULL,
  `ssid` varchar(50) NOT NULL,
  `pass_connection` varchar(50) NOT NULL,
  `frequency` varchar(50) NOT NULL,
  `device_type` varchar(50) NOT NULL,
  `mac_add` varchar(25) NOT NULL COMMENT 'mac address of the piece'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `pieces_additional`:
--   `piece_id`
--       `pieces` -> `piece_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `pieces_addr`
--

DROP TABLE IF EXISTS `pieces_addr`;
CREATE TABLE `pieces_addr` (
  `piece_id` int(11) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `pieces_addr`:
--

-- --------------------------------------------------------

--
-- Table structure for table `pieces_phone`
--

DROP TABLE IF EXISTS `pieces_phone`;
CREATE TABLE `pieces_phone` (
  `piece_id` int(11) NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `pieces_phone`:
--

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
CREATE TABLE `types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `type_note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `types`:
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Fullname` varchar(255) NOT NULL,
  `isTech` int(11) NOT NULL DEFAULT 0,
  `job_title` varchar(50) NOT NULL,
  `gender` int(11) NOT NULL DEFAULT 0 COMMENT '0 => male\r\n1 => female',
  `address` text NOT NULL,
  `phone` varchar(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `TrustStatus` int(11) NOT NULL DEFAULT 0,
  `RegStatus` int(11) NOT NULL DEFAULT 1 COMMENT 'Registeration approval',
  `addedBy` int(11) NOT NULL COMMENT 'Who added this user',
  `isRoot` int(11) NOT NULL DEFAULT 0,
  `joinedDate` date NOT NULL,
  `isOnline` int(11) NOT NULL DEFAULT 0 COMMENT 'Online Status',
  `systemLang` int(11) NOT NULL DEFAULT 0,
  `twitter` text NOT NULL,
  `facebook` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `users`:
--

--
-- Truncate table before insert `users`
--

TRUNCATE TABLE `users`;
--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES
(1, 'eng-hassib', '768b292245aa8824e662508e2e2f38604b16f94d', 'hassib@jsl.com', 'ahmed hassib khalil', 0, 'مهندس برمجيات', 0, 'جنزور', '01028680375', '1998-05-01', 1, 1, 1, 1, '2021-09-08', 0, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_permissions`
--

DROP TABLE IF EXISTS `users_permissions`;
CREATE TABLE `users_permissions` (
  `id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `companies_add` int(11) NOT NULL DEFAULT 0,
  `companies_show` int(11) NOT NULL DEFAULT 0,
  `companies_update` int(11) NOT NULL DEFAULT 0,
  `companies_delete` int(11) NOT NULL DEFAULT 0,
  `user_add` int(11) NOT NULL DEFAULT 0,
  `user_update` int(11) NOT NULL DEFAULT 0,
  `user_delete` int(11) NOT NULL DEFAULT 0,
  `user_show` int(11) NOT NULL DEFAULT 0,
  `mal_add` int(11) NOT NULL DEFAULT 0,
  `mal_update` int(11) NOT NULL DEFAULT 0,
  `mal_delete` int(11) NOT NULL DEFAULT 0,
  `mal_show` int(11) NOT NULL DEFAULT 0,
  `mal_review` int(11) NOT NULL DEFAULT 0,
  `comb_add` int(11) NOT NULL DEFAULT 0,
  `comb_update` int(11) NOT NULL DEFAULT 0,
  `comb_delete` int(11) NOT NULL DEFAULT 0,
  `comb_show` int(11) NOT NULL DEFAULT 0,
  `comb_review` int(11) NOT NULL DEFAULT 0,
  `pcs_add` int(11) NOT NULL DEFAULT 0,
  `pcs_update` int(11) NOT NULL DEFAULT 0,
  `pcs_delete` int(11) NOT NULL DEFAULT 0,
  `pcs_show` int(11) NOT NULL DEFAULT 0,
  `dir_add` int(11) NOT NULL DEFAULT 0,
  `dir_update` int(11) NOT NULL DEFAULT 0,
  `dir_delete` int(11) NOT NULL DEFAULT 0,
  `dir_show` int(11) NOT NULL DEFAULT 0,
  `sugg_replay` int(11) NOT NULL DEFAULT 0,
  `sugg_delete` int(11) NOT NULL DEFAULT 0,
  `sugg_show` int(11) NOT NULL DEFAULT 0,
  `points_add` int(11) NOT NULL DEFAULT 0,
  `points_delete` int(11) NOT NULL DEFAULT 0,
  `points_show` int(11) NOT NULL DEFAULT 0,
  `reports_show` int(11) NOT NULL DEFAULT 0,
  `archive_show` int(11) NOT NULL DEFAULT 0,
  `take_backup` int(11) NOT NULL DEFAULT 0,
  `restore_backup` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `users_permissions`:
--   `UserID`
--       `users` -> `UserID`
--

--
-- Truncate table before insert `users_permissions`
--

TRUNCATE TABLE `users_permissions`;
--
-- Dumping data for table `users_permissions`
--

INSERT INTO `users_permissions` VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_pieces_columns`
--

DROP TABLE IF EXISTS `users_pieces_columns`;
CREATE TABLE `users_pieces_columns` (
  `id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL DEFAULT 1,
  `ip` int(11) NOT NULL DEFAULT 1,
  `mac_add` int(11) NOT NULL DEFAULT 1,
  `piece_name` int(11) NOT NULL DEFAULT 1,
  `username` int(11) NOT NULL DEFAULT 1,
  `password` int(11) NOT NULL DEFAULT 1,
  `direction` int(11) NOT NULL DEFAULT 1,
  `source` int(11) NOT NULL DEFAULT 1,
  `ssid` int(11) NOT NULL DEFAULT 1,
  `pass_conn` int(11) NOT NULL DEFAULT 1,
  `frequency` int(11) NOT NULL DEFAULT 1,
  `dev_type` int(11) NOT NULL DEFAULT 1,
  `conn_type` int(11) NOT NULL DEFAULT 1,
  `address` int(11) NOT NULL DEFAULT 1,
  `phone` int(11) NOT NULL DEFAULT 1,
  `type` int(11) NOT NULL DEFAULT 1,
  `notes` int(11) NOT NULL DEFAULT 1,
  `avg_ping` int(11) NOT NULL DEFAULT 1,
  `packet_loss` int(11) NOT NULL DEFAULT 1,
  `conn` int(11) NOT NULL DEFAULT 1,
  `added_date` int(11) NOT NULL DEFAULT 1,
  `added_by` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `users_pieces_columns`:
--   `UserID`
--       `users` -> `UserID`
--

-- --------------------------------------------------------

--
-- Table structure for table `users_points`
--

DROP TABLE IF EXISTS `users_points`;
CREATE TABLE `users_points` (
  `id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `points_type` int(11) NOT NULL,
  `points_date` date NOT NULL,
  `comment` text NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `users_points`:
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `combinations`
--
ALTER TABLE `combinations`
  ADD PRIMARY KEY (`comb_id`);

--
-- Indexes for table `combinations_media`
--
ALTER TABLE `combinations_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comp_sugg`
--
ALTER TABLE `comp_sugg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conn_types`
--
ALTER TABLE `conn_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `direction`
--
ALTER TABLE `direction`
  ADD PRIMARY KEY (`direction_id`);

--
-- Indexes for table `license`
--
ALTER TABLE `license`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `malfunctions`
--
ALTER TABLE `malfunctions`
  ADD PRIMARY KEY (`mal_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `mng_id` (`mng_id`),
  ADD KEY `malfunctions_ibfk_3` (`tech_id`);

--
-- Indexes for table `malfunctions_media`
--
ALTER TABLE `malfunctions_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mal_id` (`mal_id`);

--
-- Indexes for table `pieces`
--
ALTER TABLE `pieces`
  ADD PRIMARY KEY (`piece_id`);

--
-- Indexes for table `pieces_additional`
--
ALTER TABLE `pieces_additional`
  ADD PRIMARY KEY (`piece_id`);

--
-- Indexes for table `pieces_addr`
--
ALTER TABLE `pieces_addr`
  ADD PRIMARY KEY (`piece_id`);

--
-- Indexes for table `pieces_phone`
--
ALTER TABLE `pieces_phone`
  ADD PRIMARY KEY (`piece_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- Indexes for table `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UserID` (`UserID`);

--
-- Indexes for table `users_pieces_columns`
--
ALTER TABLE `users_pieces_columns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UserID` (`UserID`);

--
-- Indexes for table `users_points`
--
ALTER TABLE `users_points`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `combinations`
--
ALTER TABLE `combinations`
  MODIFY `comb_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `combinations_media`
--
ALTER TABLE `combinations_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comp_sugg`
--
ALTER TABLE `comp_sugg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conn_types`
--
ALTER TABLE `conn_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `direction`
--
ALTER TABLE `direction`
  MODIFY `direction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `license`
--
ALTER TABLE `license`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `malfunctions`
--
ALTER TABLE `malfunctions`
  MODIFY `mal_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Malfunction ID';

--
-- AUTO_INCREMENT for table `malfunctions_media`
--
ALTER TABLE `malfunctions_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pieces`
--
ALTER TABLE `pieces`
  MODIFY `piece_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users_permissions`
--
ALTER TABLE `users_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users_pieces_columns`
--
ALTER TABLE `users_pieces_columns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_points`
--
ALTER TABLE `users_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


--
-- Metadata
--
-- USE `phpmyadmin`;

--
-- Metadata for table combinations
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table combinations_media
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table companies
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table comp_sugg
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table conn_types
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table direction
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table license
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table malfunctions
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table malfunctions_media
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table pieces
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table pieces_additional
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table pieces_addr
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table pieces_phone
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table types
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table users
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table users_permissions
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table users_pieces_columns
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for table users_points
--
-- Error reading data for table phpmyadmin.pma__column_info: #1100 - Table 'pma__column_info' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__table_uiprefs: #1100 - Table 'pma__table_uiprefs' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__tracking: #1100 - Table 'pma__tracking' was not locked with LOCK TABLES

--
-- Metadata for database jsl_db
--
-- Error reading data for table phpmyadmin.pma__bookmark: #1100 - Table 'pma__bookmark' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__relation: #1100 - Table 'pma__relation' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__savedsearches: #1100 - Table 'pma__savedsearches' was not locked with LOCK TABLES
-- Error reading data for table phpmyadmin.pma__central_columns: #1100 - Table 'pma__central_columns' was not locked with LOCK TABLES

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
