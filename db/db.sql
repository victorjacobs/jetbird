-- SQL Dump

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for`comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL auto_increment,
  `comment_parent_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `pcomment_id` int(11) NOT NULL,
  `comment_date` int(11) NOT NULL,
  KEY `comment_id` (`comment_id`),
  KEY `comment_parent_id` (`comment_parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `post_id` int(11) NOT NULL auto_increment,
  `puser_id` int(11) NOT NULL,
  `post` text NOT NULL,
  `date` int(11) NOT NULL,
  `title` text NOT NULL,
  UNIQUE KEY `post_id` (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

-- --------------------------------------------------------

--
-- Table structure for `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL auto_increment,
  `username` varchar(18) NOT NULL,
  `password` varchar(32) NOT NULL,
  `auth_id` int(11) NOT NULL,
  KEY `user_id` (`user_id`),
  FULLTEXT KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;
