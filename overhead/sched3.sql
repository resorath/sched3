-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: mysql.tophatandmonocle.com
-- Generation Time: Jun 02, 2013 at 05:49 PM
-- Server version: 5.1.56
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sched3`
--

-- --------------------------------------------------------

--
-- Table structure for table `cisessions`
--

CREATE TABLE IF NOT EXISTS `cisessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='codeigniter sessions, not to be confused with session';

-- --------------------------------------------------------

--
-- Table structure for table `controllerRole`
--

CREATE TABLE IF NOT EXISTS `controllerRole` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `controllerName` varchar(50) NOT NULL,
  `roleId` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `supervisorId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `hour`
--

CREATE TABLE IF NOT EXISTS `hour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` mediumint(9) NOT NULL,
  `sessionId` mediumint(9) NOT NULL,
  `time` varchar(64) NOT NULL,
  `date` varchar(64) DEFAULT NULL,
  `day` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=117 ;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `roleName` varchar(64) NOT NULL,
  `roleDescription` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `scheduleType` char(1) NOT NULL,
  `startDate` varchar(30) NOT NULL,
  `endDate` varchar(30) NOT NULL,
  `startTime` varchar(30) NOT NULL,
  `endTime` varchar(30) NOT NULL,
  `timeIncrementAmount` varchar(10) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isPrimary` tinyint(1) NOT NULL,
  `isLocked` tinyint(1) NOT NULL,
  `groupId` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE IF NOT EXISTS `shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hourId` int(11) NOT NULL,
  `status` bigint(1) NOT NULL,
  `coveredUserId` mediumint(9) NOT NULL,
  `chainedShiftsId` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `ucid` varchar(8) NOT NULL,
  `itUsername` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `userGroup`
--

CREATE TABLE IF NOT EXISTS `userGroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` mediumint(9) NOT NULL,
  `groupId` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `userRole`
--

CREATE TABLE IF NOT EXISTS `userRole` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `userId` mediumint(9) NOT NULL,
  `roleId` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
