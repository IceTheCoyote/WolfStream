-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 31, 2017 at 03:53 PM
-- Server version: 5.6.34
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wolfstream`
--
CREATE DATABASE IF NOT EXISTS `wolfstream` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `wolfstream`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `username` varchar(9999) NOT NULL,
  `password` varchar(999) NOT NULL,
  `stream_name` varchar(999) NOT NULL,
  `stream_key` varchar(999) NOT NULL,
  `stream_pass` varchar(999) NOT NULL DEFAULT 'cf83e1357eefb8bdf1542850d66d8007d620e4050b5715dc83f4a921d36ce9ce47d0d13c5d85f2b0ff8318d2877eec2f63b931bd47417a81a538327af927da3e',
  `stream_game` varchar(999) NOT NULL,
  `banned` int(11) NOT NULL,
  `banreason` varchar(999) NOT NULL,
  `enablePicture` int(11) NOT NULL DEFAULT '0',
  `enableYT` int(11) NOT NULL DEFAULT '0',
  `YouTubeMusicPlayer` varchar(999) NOT NULL DEFAULT '5WEUKj7jAO0',
  `isLocked` int(11) NOT NULL DEFAULT '0',
  `profile_picture` varchar(999) NOT NULL DEFAULT 'http://gurucul.com/wp-content/uploads/2015/01/default-user-icon-profile.png',
  `background_pg` varchar(999) NOT NULL DEFAULT 'http://pre10.deviantart.net/bbfa/th/pre/i/2015/102/6/b/ninetales_by_bluekomadori-d8pfbwl.jpg',
  `description` varchar(999) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Dumping data for table `accounts`
--

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `username` varchar(9999) NOT NULL,
  `reason` varchar(9999) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
