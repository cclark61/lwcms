-- phpMyAdmin SQL Dump
-- version 4.2.10.1
-- http://www.phpmyadmin.net
--
-- Host: db.emonlade.net
-- Generation Time: Dec 11, 2015 at 03:53 AM
-- Server version: 5.5.32-log
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lwcms`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_modules`
--

CREATE TABLE IF NOT EXISTS `app_modules` (
`id` int(11) NOT NULL,
  `phrase` varchar(20) NOT NULL,
  `mod_desc` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `mod_dir` varchar(100) NOT NULL,
  `content_dir` varchar(50) NOT NULL,
  `version` varchar(7) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_modules`
--

INSERT INTO `app_modules` (`id`, `phrase`, `mod_desc`, `image`, `mod_dir`, `content_dir`, `version`) VALUES
(1, 'dynamic_content', 'Publishable Content ', 'fa fa-file-text-o', 'dynamic_content', 'dynamic_content', NULL),
(2, 'blogs', 'Blogs', 'fa fa-pencil-square-o', 'blogs', 'blogs', NULL),
(6, 'code_editor', 'Code Editor', 'fa fa-code', 'code_editor', '', NULL),
(14, 'static_content', 'Static Content ', 'fa fa-file-text-o', 'static_content', 'static_content', NULL),
(17, 'authors', 'Authors', 'fa fa-user', 'authors', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_modules`
--
ALTER TABLE `app_modules`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_modules`
--
ALTER TABLE `app_modules`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
