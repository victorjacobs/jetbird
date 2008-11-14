-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 04, 2008 at 10:29 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `jetbird_new`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` bigint(20) unsigned NOT NULL auto_increment,
  `user_name` varchar(32) NOT NULL,
  `user_pass` varchar(32) NOT NULL,
  `user_mail` varchar(32) NOT NULL,
  `user_level` tinyint(1) NOT NULL,
  `user_reg_key` varchar(13) NOT NULL,
  `user_last_login` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- Table structure for table `search`
--
CREATE TABLE IF NOT EXISTS `search` (
  `id` int(11) NOT NULL auto_increment,
  `word` text NOT NULL,
  `post_id` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
