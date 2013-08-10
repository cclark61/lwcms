-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Generation Time: Feb 23, 2013 at 03:41 PM
-- Server version: 5.5.28
-- PHP Version: 5.4.11

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
-- Table structure for table `active_site_modules`
--

CREATE TABLE IF NOT EXISTS `active_site_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=450 ;

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
  `version` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE IF NOT EXISTS `app_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `module_id` int(11) NOT NULL DEFAULT '0',
  `option_name` varchar(50) NOT NULL,
  `option_value` varchar(100) NOT NULL,
  `spare_key` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `content_versions`
--

CREATE TABLE IF NOT EXISTS `content_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_user` varchar(30) NOT NULL,
  `content_type` varchar(10) NOT NULL,
  `entry_id` int(11) NOT NULL,
  `indexed_content` text,
  `raw_content` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE IF NOT EXISTS `sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(100) NOT NULL,
  `site_desc` text,
  `site_url` varchar(200) DEFAULT NULL,
  `document_root` varchar(200) DEFAULT NULL,
  `content_dir` varchar(200) NOT NULL,
  `cache_dynamic_content` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `site_access`
--

CREATE TABLE IF NOT EXISTS `site_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `userid` varchar(30) NOT NULL,
  `acc_lvl` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=189 ;

-- --------------------------------------------------------

--
-- Table structure for table `site_blogs`
--

CREATE TABLE IF NOT EXISTS `site_blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `create_user` varchar(50) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `blog_title` varchar(200) NOT NULL,
  `blog_url` varchar(200) DEFAULT NULL,
  `active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `site_blog_authors`
--

CREATE TABLE IF NOT EXISTS `site_blog_authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL DEFAULT '0',
  `create_user` varchar(50) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `site_blog_cats`
--

CREATE TABLE IF NOT EXISTS `site_blog_cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `create_user` varchar(50) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(200) NOT NULL,
  `active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `site_blog_entries`
--

CREATE TABLE IF NOT EXISTS `site_blog_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `create_user` varchar(50) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `entry_title` varchar(200) NOT NULL,
  `entry_author` varchar(100) DEFAULT NULL,
  `entry_content` text NOT NULL,
  `entry_keywords` text,
  `active` smallint(6) NOT NULL DEFAULT '1',
  `stage` tinyint(4) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `site_entries`
--

CREATE TABLE IF NOT EXISTS `site_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL DEFAULT '0',
  `site_id` int(11) NOT NULL,
  `node_path` varchar(200) NOT NULL,
  `create_user` varchar(50) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mod_date` timestamp NULL DEFAULT NULL,
  `post_date` timestamp NULL DEFAULT NULL,
  `cat_id` smallint(6) NOT NULL DEFAULT '0',
  `entry_author` smallint(6) NOT NULL DEFAULT '0',
  `entry_title` varchar(200) NOT NULL,
  `entry_desc` varchar(200) DEFAULT NULL,
  `content` mediumtext NOT NULL,
  `metadata` text,
  `entry_type` smallint(6) NOT NULL DEFAULT '0',
  `url_tag` varchar(30) DEFAULT NULL,
  `index_content` tinyint(4) NOT NULL DEFAULT '1',
  `version_dev` int(11) NOT NULL DEFAULT '0',
  `version_test` int(11) NOT NULL DEFAULT '0',
  `version_live` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=412 ;

-- --------------------------------------------------------

--
-- Table structure for table `site_entry_cats`
--

CREATE TABLE IF NOT EXISTS `site_entry_cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `create_user` varchar(50) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(200) NOT NULL,
  `active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `system_updates`
--

CREATE TABLE IF NOT EXISTS `system_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `update_num` int(11) NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  `super_admin` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
