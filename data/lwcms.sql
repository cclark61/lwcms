SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lwcms`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_site_modules`
--

CREATE TABLE `active_site_modules` (
  `id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_modules`
--

CREATE TABLE `app_modules` (
  `id` int(11) NOT NULL,
  `phrase` varchar(20) NOT NULL,
  `mod_desc` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `mod_dir` varchar(100) NOT NULL,
  `content_dir` varchar(50) NOT NULL,
  `version` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `module_id` int(11) NOT NULL DEFAULT '0',
  `option_name` varchar(50) NOT NULL,
  `option_value` varchar(100) NOT NULL,
  `spare_key` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `content_versions`
--

CREATE TABLE `content_versions` (
  `id` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_user` varchar(30) NOT NULL,
  `content_type` varchar(10) NOT NULL,
  `entry_id` int(11) NOT NULL,
  `indexed_content` text,
  `raw_content` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `site_desc` text,
  `site_url` varchar(200) DEFAULT NULL,
  `document_root` varchar(200) DEFAULT NULL,
  `content_dir` varchar(200) NOT NULL,
  `cache_dynamic_content` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_access`
--

CREATE TABLE `site_access` (
  `id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `userid` varchar(30) NOT NULL,
  `acc_lvl` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_blogs`
--

CREATE TABLE `site_blogs` (
  `id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `create_user` varchar(50) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `blog_title` varchar(200) NOT NULL,
  `blog_url` varchar(200) DEFAULT NULL,
  `active` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_blog_authors`
--

CREATE TABLE `site_blog_authors` (
  `id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL DEFAULT '0',
  `create_user` varchar(50) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_blog_cats`
--

CREATE TABLE `site_blog_cats` (
  `id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `create_user` varchar(50) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(200) NOT NULL,
  `active` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_blog_entries`
--

CREATE TABLE `site_blog_entries` (
  `id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `create_user` varchar(50) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `entry_title` varchar(200) NOT NULL,
  `entry_author` varchar(100) DEFAULT NULL,
  `entry_content` text NOT NULL,
  `metadata` text,
  `entry_keywords` text,
  `active` smallint(6) NOT NULL DEFAULT '1',
  `stage` tinyint(4) NOT NULL DEFAULT '2',
  `version_dev` int(11) NOT NULL DEFAULT '0',
  `version_test` int(11) NOT NULL DEFAULT '0',
  `version_live` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_entries`
--

CREATE TABLE `site_entries` (
  `id` int(11) NOT NULL,
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
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_entry_cats`
--

CREATE TABLE `site_entry_cats` (
  `id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `create_user` varchar(50) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(200) NOT NULL,
  `active` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `system_updates`
--

CREATE TABLE `system_updates` (
  `id` int(11) NOT NULL,
  `update_num` int(11) NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mod_date` timestamp NULL DEFAULT NULL,
  `person_name` varchar(50) NOT NULL,
  `testimonial` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  `super_admin` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_site_modules`
--
ALTER TABLE `active_site_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_modules`
--
ALTER TABLE `app_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_versions`
--
ALTER TABLE `content_versions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_access`
--
ALTER TABLE `site_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_blogs`
--
ALTER TABLE `site_blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_blog_authors`
--
ALTER TABLE `site_blog_authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_blog_cats`
--
ALTER TABLE `site_blog_cats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_blog_entries`
--
ALTER TABLE `site_blog_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_entries`
--
ALTER TABLE `site_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_entry_cats`
--
ALTER TABLE `site_entry_cats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_updates`
--
ALTER TABLE `system_updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_site_modules`
--
ALTER TABLE `active_site_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=490;
--
-- AUTO_INCREMENT for table `app_modules`
--
ALTER TABLE `app_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `content_versions`
--
ALTER TABLE `content_versions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `site_access`
--
ALTER TABLE `site_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;
--
-- AUTO_INCREMENT for table `site_blogs`
--
ALTER TABLE `site_blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `site_blog_authors`
--
ALTER TABLE `site_blog_authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `site_blog_cats`
--
ALTER TABLE `site_blog_cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `site_blog_entries`
--
ALTER TABLE `site_blog_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `site_entries`
--
ALTER TABLE `site_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=418;
--
-- AUTO_INCREMENT for table `site_entry_cats`
--
ALTER TABLE `site_entry_cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `system_updates`
--
ALTER TABLE `system_updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
