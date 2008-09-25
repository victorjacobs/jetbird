--
--		This file is part of Jetbird.
--		
--		Jetbird is free software: you can redistribute it and/or modify
--		it under the terms of the GNU General Public License as published by
--		the Free Software Foundation, either version 3 of the License, or
--		(at your option) any later version.
--		
--		Jetbird is distributed in the hope that it will be useful,
--		but WITHOUT ANY WARRANTY; without even the implied warranty of
--		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
--		GNU General Public License for more details.
--		You should have received a copy of the GNU General Public License
--		along with Jetbird.  If not, see <http://www.gnu.org/licenses/>.
-- 

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` bigint(20) unsigned NOT NULL auto_increment,
  `comment_parent_post_id` bigint(20) unsigned NOT NULL,
  `comment_author` varchar(32) NOT NULL,
  `comment_author_email` varchar(64) NOT NULL,
  `comment_author_url` varchar(64) NOT NULL,
  `comment_author_ip` varchar(15) NOT NULL,
  `comment_date` int(11) unsigned NOT NULL,
  `comment_content` text NOT NULL,
  `comment_session_id` varchar(32) NOT NULL,
  PRIMARY KEY  (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `post_id` bigint(20) unsigned NOT NULL auto_increment,
  `post_author` int(11) unsigned NOT NULL,
  `post_date` int(11) unsigned NOT NULL,
  `post_title` text NOT NULL,
  `post_content` longtext NOT NULL,
  `comment_status` enum('open','closed') NOT NULL,
  PRIMARY KEY  (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` bigint(20) unsigned NOT NULL auto_increment,
  `user_name` varchar(32) NOT NULL,
  `user_pass` varchar(32) NOT NULL,
  `user_mail` varchar(32) NOT NULL,
  `user_level` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

