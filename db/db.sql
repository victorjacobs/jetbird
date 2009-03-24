-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generatie Tijd: 24 Mar 2009 om 21:39
-- Server versie: 5.1.30
-- PHP Versie: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jetbird`
--

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `attachment_list`
--

CREATE TABLE IF NOT EXISTS `attachment_list` (
  `attachment_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `attachment_owner` int(11) unsigned NOT NULL,
  `attachment_file` varchar(40) NOT NULL,
  `attachment_original_name` varchar(256) NOT NULL,
  `attachment_type` varchar(32) NOT NULL,
  `attachment_size` int(32) NOT NULL DEFAULT '0',
  `attachment_date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`attachment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_parent_post_id` bigint(20) unsigned NOT NULL,
  `comment_author` varchar(32) NOT NULL,
  `comment_author_email` varchar(64) NOT NULL,
  `comment_author_url` varchar(64) NOT NULL,
  `comment_author_ip` varchar(15) NOT NULL,
  `comment_date` int(11) unsigned NOT NULL,
  `comment_content` text NOT NULL,
  `comment_session_id` varchar(32) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `post_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` int(11) unsigned NOT NULL,
  `post_date` int(11) unsigned NOT NULL,
  `post_title` text CHARACTER SET utf8 NOT NULL,
  `post_content` longtext CHARACTER SET utf8 NOT NULL,
  `comment_status` enum('open','closed') CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `search_cache`
--

CREATE TABLE IF NOT EXISTS `search_cache` (
  `search_key` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `search_index`
--

CREATE TABLE IF NOT EXISTS `search_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` text CHARACTER SET utf8 NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86 ;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `search_word`
--

CREATE TABLE IF NOT EXISTS `search_word` (
  `word_id` text NOT NULL,
  `post_id` text NOT NULL,
  `weight` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL,
  `user_pass` varchar(32) NOT NULL,
  `user_mail` varchar(32) NOT NULL,
  `user_level` tinyint(1) NOT NULL,
  `user_reg_key` varchar(13) NOT NULL,
  `user_last_login` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
