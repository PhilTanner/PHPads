-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 26, 2015 at 12:31 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `PHPads`
--
CREATE DATABASE IF NOT EXISTS `PHPads` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `PHPads`;

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--
-- Creation: Jun 26, 2015 at 12:30 AM
--

DROP TABLE IF EXISTS `ads`;
CREATE TABLE IF NOT EXISTS `ads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `weighting` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enddate` timestamp NULL DEFAULT NULL,
  `remaining` int(11) NOT NULL,
  `impressions` int(11) NOT NULL DEFAULT '0' COMMENT 'Could be unsigned - but then has different max value to `remaining`, which makes no sense',
  `clickthrus` int(10) unsigned NOT NULL DEFAULT '0',
  `width` smallint(5) unsigned NOT NULL DEFAULT '0',
  `height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `link_uri` varchar(255) NOT NULL,
  `image_uri` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `startdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `adtype` tinyint(4) NOT NULL DEFAULT '0',
  `othercontent` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='Columns are in same order as PHPADS_ defines in ads.inc.php' AUTO_INCREMENT=3 ;

CREATE USER 'PHPads'@'%' IDENTIFIED BY  '***';
GRANT SELECT, INSERT, UPDATE ON * . * TO  'PHPads'@'%' IDENTIFIED BY  '***' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;
GRANT ALL PRIVILEGES ON  `PHPads` . * TO  'PHPads'@'%';

