-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Generation Time: Feb 12, 2013 at 09:39 PM
-- Server version: 5.5.28
-- PHP Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` varchar(20) NOT NULL,
  `mod_desc` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `mod_dir` varchar(100) NOT NULL,
  `content_dir` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `app_modules`
--

INSERT INTO `app_modules` (`id`, `phrase`, `mod_desc`, `image`, `mod_dir`, `content_dir`) VALUES
(1, 'dynamic_content', 'Publishable Content ', 'img/icons/page_edit.png', 'dynamic_content', 'dynamic_content'),
(2, 'blogs', 'Blogs', 'img/icons/user_comment.png', 'blogs', 'blogs'),
(6, 'code_editor', 'Code Editor', 'img/icons/tag.png', 'code_editor', ''),
(14, 'static_content', 'Static Content ', 'img/icons/page_edit.png', 'static_content', 'static_content'),
(17, 'authors', 'Authors', 'img/icons/user_edit.png', 'authors', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
