SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lwcms`
--

--
-- Dumping data for table `app_modules`
--

INSERT INTO `app_modules` (`id`, `phrase`, `mod_desc`, `image`, `mod_dir`, `content_dir`, `version`) VALUES
(1, 'dynamic_content', 'Publishable Content ', 'fa fa-file-text-o', 'dynamic_content', 'dynamic_content', NULL),
(2, 'blogs', 'Blogs', 'fa fa-pencil-square-o', 'blogs', 'blogs', NULL),
(6, 'code_editor', 'Code Editor', 'fa fa-code', 'code_editor', '', NULL),
(14, 'static_content', 'Static Content ', 'fa fa-file-text-o', 'static_content', 'static_content', NULL),
(17, 'authors', 'Authors', 'fa fa-user', 'authors', '', NULL),
(18, 'testimonials', 'Testimonials', 'fa fa-comments-o', 'testimonials', '', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
