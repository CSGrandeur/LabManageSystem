-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-07-21 12:14:51
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
  `uid` varchar(30) NOT NULL COMMENT '学号',
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
  `uid` varchar(30) NOT NULL,
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
  `uid` varchar(30) NOT NULL,
  `addnum` int(11) NOT NULL,
  `month` date NOT NULL,
  `available` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lab_printarrange`
--

CREATE TABLE IF NOT EXISTS `lab_printarrange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) NOT NULL,
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
  `uid` varchar(30) NOT NULL,
  `papersum` int(11) NOT NULL DEFAULT '0',
  `month` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `lab_printcount`
--

INSERT INTO `lab_printcount` (`id`, `uid`, `papersum`, `month`) VALUES
(1, 'CSGrandeur', 3, '2014-07-01');

-- --------------------------------------------------------

--
-- 表的结构 `lab_printrecord`
--

CREATE TABLE IF NOT EXISTS `lab_printrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) NOT NULL,
  `papernum` int(11) NOT NULL,
  `jobname` varchar(255) NOT NULL,
  `identifier` int(11) NOT NULL,
  `submittime` datetime NOT NULL,
  `updatetime` datetime NOT NULL,
  `infohash` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `lab_printrecord`
--

INSERT INTO `lab_printrecord` (`id`, `uid`, `papernum`, `jobname`, `identifier`, `submittime`, `updatetime`, `infohash`) VALUES
(1, 'CSGrandeur', 1, 'Print System Document', 28, '2014-07-17 12:34:41', '2014-07-18 11:37:26', 'c90b4a01e0e04e50cfa4d295825a8c4e'),
(2, 'CSGrandeur', 1, 'Print System Document', 27, '2014-07-17 12:11:35', '2014-07-21 17:12:36', '8edef83eb128e1e46df9522049e9f3b6'),
(3, 'CSGrandeur', 1, 'Print System Document', 27, '2014-07-17 12:11:35', '2014-07-21 17:13:27', '8edef83eb128e1e46df9522049e9f3b6'),
(4, 'CSGrandeur', 1, 'Print System Document', 27, '2014-07-17 12:11:35', '2014-07-21 17:13:29', '8edef83eb128e1e46df9522049e9f3b6'),
(5, 'CSGrandeur', 1, 'Print System Document', 27, '2014-07-17 12:11:35', '2014-07-21 17:13:30', '8edef83eb128e1e46df9522049e9f3b6'),
(6, 'CSGrandeur', 1, 'Print System Document', 27, '2014-07-17 12:11:35', '2014-07-21 17:16:15', '8edef83eb128e1e46df9522049e9f3b6'),
(7, 'CSGrandeur', 1, 'Print System Document', 27, '2014-07-17 12:11:35', '2014-07-21 17:16:18', '8edef83eb128e1e46df9522049e9f3b6');

-- --------------------------------------------------------

--
-- 表的结构 `lab_privilege`
--

CREATE TABLE IF NOT EXISTS `lab_privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '学号/编号/帐号',
  `privilege` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT '权限',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lab_user`
--

CREATE TABLE IF NOT EXISTS `lab_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) NOT NULL COMMENT '学号/编号/帐号',
  `passwd` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `kind` tinyint(1) DEFAULT NULL COMMENT '是老师还是学生。41老师，42学生。详见ConstVal.php',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `lab_user`
--

INSERT INTO `lab_user` (`id`, `uid`, `passwd`, `name`, `kind`) VALUES
(1, '1246xxxxx', '11121', '121', 42);

-- --------------------------------------------------------

--
-- 表的结构 `lab_userdetail`
--

CREATE TABLE IF NOT EXISTS `lab_userdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) NOT NULL COMMENT '学号',
  `sex` tinyint(1) NOT NULL COMMENT '性别',
  `phone` varchar(20) NOT NULL COMMENT '电话',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `degree` tinyint(1) NOT NULL COMMENT '攻读学位',
  `grade` varchar(20) NOT NULL COMMENT '年级',
  `birthday` date NOT NULL COMMENT '生日',
  `idcard` varchar(30) NOT NULL COMMENT '身份证号',
  `nation` varchar(20) NOT NULL COMMENT '民族',
  `political` varchar(20) NOT NULL COMMENT '政治面貌',
  `institute` int(1) NOT NULL COMMENT '学院',
  `major` int(1) NOT NULL COMMENT '专业',
  `supervisor` varchar(50) NOT NULL,
  `teacher` varchar(50) NOT NULL,
  `supervisorid` varchar(20) NOT NULL COMMENT '导师',
  `teacherid` varchar(20) NOT NULL COMMENT '小导师',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `lab_userdetail`
--

INSERT INTO `lab_userdetail` (`id`, `uid`, `sex`, `phone`, `email`, `degree`, `grade`, `birthday`, `idcard`, `nation`, `political`, `institute`, `major`, `supervisor`, `teacher`, `supervisorid`, `teacherid`) VALUES
(1, '1246xxxxx', 51, '1511633xxxx', 'csgrandeur@csu.edu.cn', 21, '21', '0000-00-00', '212', '12', '1221', 201, 31, '13', '13', '31', '31');

--
-- 限制导出的表
--

--
-- 限制表 `lab_checkingin`
--
ALTER TABLE `lab_checkingin`
  ADD CONSTRAINT `lab_checkingin_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_user` (`uid`) ON DELETE CASCADE;

--
-- 限制表 `lab_name2onlyname`
--
ALTER TABLE `lab_name2onlyname`
  ADD CONSTRAINT `lab_name2onlyname_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_user` (`uid`) ON DELETE CASCADE;

--
-- 限制表 `lab_printaddition`
--
ALTER TABLE `lab_printaddition`
  ADD CONSTRAINT `lab_printaddition_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_user` (`uid`) ON DELETE CASCADE;

--
-- 限制表 `lab_printarrange`
--
ALTER TABLE `lab_printarrange`
  ADD CONSTRAINT `lab_printarrange_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_user` (`uid`) ON DELETE CASCADE;

--
-- 限制表 `lab_privilege`
--
ALTER TABLE `lab_privilege`
  ADD CONSTRAINT `lab_privilege_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_user` (`uid`) ON DELETE CASCADE;

--
-- 限制表 `lab_userdetail`
--
ALTER TABLE `lab_userdetail`
  ADD CONSTRAINT `lab_userdetail_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_user` (`uid`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
