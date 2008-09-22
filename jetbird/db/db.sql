-- phpMyAdmin SQL Dump
-- version 2.11.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generatie Tijd: 22 Sept 2008 om 20:17
-- Server versie: 5.0.51
-- PHP Versie: 5.2.6

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
-- Tabel structuur voor tabel `comment`
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
-- Tabel structuur voor tabel `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `post_id` int(11) NOT NULL auto_increment,
  `puser_id` int(11) NOT NULL,
  `post` text NOT NULL,
  `date` int(11) NOT NULL,
  `title` text NOT NULL,
  UNIQUE KEY `post_id` (`post_id`),
  UNIQUE KEY `post_id_2` (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL auto_increment,
  `username` varchar(18) NOT NULL,
  `password` varchar(32) NOT NULL,
  `auth_id` int(11) NOT NULL,
  KEY `user_id` (`user_id`),
  FULLTEXT KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;
