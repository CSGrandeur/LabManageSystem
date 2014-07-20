-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-07-20 12:53:15
-- 服务器版本： 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `labweb`
--

-- --------------------------------------------------------

--
-- 表的结构 `lab_checkingin`
--

CREATE TABLE IF NOT EXISTS `lab_checkingin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL COMMENT '学号',
  `onlyname` varchar(255) NOT NULL,
  `cpuload` double NOT NULL,
  `memload` double NOT NULL,
  `mousebutton0` int(11) NOT NULL,
  `mousebutton1` int(11) NOT NULL,
  `mousemove` int(11) NOT NULL,
  `keybutton` int(11) NOT NULL,
  `upload` double NOT NULL,
  `download` double NOT NULL,
  `appprocessnum` int(11) NOT NULL,
  `processnum` int(11) NOT NULL,
  `receivetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lab_name2onlyname`
--

CREATE TABLE IF NOT EXISTS `lab_name2onlyname` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL,
  `onlyname` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lab_printaddition`
--

CREATE TABLE IF NOT EXISTS `lab_printaddition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL,
  `addnum` int(11) NOT NULL,
  `month` date NOT NULL,
  `available` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lab_printarrange`
--

CREATE TABLE IF NOT EXISTS `lab_printarrange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL,
  `paperlimit` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lab_printcount`
--

CREATE TABLE IF NOT EXISTS `lab_printcount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL,
  `papersum` int(11) NOT NULL,
  `month` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `lab_printcount`
--

INSERT INTO `lab_printcount` (`id`, `uid`, `papersum`, `month`) VALUES
(1, 'CSGrandeur', 1, '2014-07-01');

-- --------------------------------------------------------

--
-- 表的结构 `lab_printrecord`
--

CREATE TABLE IF NOT EXISTS `lab_printrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL,
  `papernum` int(11) NOT NULL,
  `jobname` varchar(255) NOT NULL,
  `identifier` int(11) NOT NULL,
  `submittime` datetime NOT NULL,
  `updatetime` datetime NOT NULL,
  `infohash` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `lab_printrecord`
--

INSERT INTO `lab_printrecord` (`id`, `uid`, `papernum`, `jobname`, `identifier`, `submittime`, `updatetime`, `infohash`) VALUES
(1, 'CSGrandeur', 1, 'Print System Document', 28, '2014-07-17 12:34:41', '2014-07-18 11:37:26', 'c90b4a01e0e04e50cfa4d295825a8c4e');

-- --------------------------------------------------------

--
-- 表的结构 `lab_userdetail`
--

CREATE TABLE IF NOT EXISTS `lab_userdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL COMMENT '学号',
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `degree` varchar(20) NOT NULL,
  `grade` varchar(20) NOT NULL,
  `birthday` date NOT NULL,
  `idcard` varchar(30) NOT NULL,
  `nation` varchar(20) NOT NULL,
  `political` varchar(20) NOT NULL,
  `institute` varchar(20) NOT NULL,
  `major` varchar(20) NOT NULL,
  `supervisor` varchar(50) NOT NULL,
  `teacher` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lab_userinfo`
--

CREATE TABLE IF NOT EXISTS `lab_userinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL COMMENT '学号',
  `name` varchar(50) NOT NULL,
  `sex` varchar(2) NOT NULL,
  `supervisorid` varchar(20) NOT NULL,
  `teacherid` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 限制导出的表
--

--
-- 限制表 `lab_checkingin`
--
ALTER TABLE `lab_checkingin`
  ADD CONSTRAINT `lab_checkingin_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_userinfo` (`uid`) ON DELETE CASCADE;

--
-- 限制表 `lab_name2onlyname`
--
ALTER TABLE `lab_name2onlyname`
  ADD CONSTRAINT `lab_name2onlyname_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_userinfo` (`uid`) ON DELETE CASCADE;

--
-- 限制表 `lab_printaddition`
--
ALTER TABLE `lab_printaddition`
  ADD CONSTRAINT `lab_printaddition_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_userinfo` (`uid`) ON DELETE CASCADE;

--
-- 限制表 `lab_printarrange`
--
ALTER TABLE `lab_printarrange`
  ADD CONSTRAINT `lab_printarrange_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_userinfo` (`uid`) ON DELETE CASCADE;

--
-- 限制表 `lab_userdetail`
--
ALTER TABLE `lab_userdetail`
  ADD CONSTRAINT `lab_userdetail_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_userinfo` (`uid`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
