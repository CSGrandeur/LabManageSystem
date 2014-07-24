-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-07-24 17:14:03
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `lab_printcount`
--

INSERT INTO `lab_printcount` (`id`, `uid`, `papersum`, `month`) VALUES
(4, 'CSGrandeur', 1, '2014-07-01');

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
  `result` tinyint(1) DEFAULT '0' COMMENT '该打印记录返回的内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `lab_printrecord`
--

INSERT INTO `lab_printrecord` (`id`, `uid`, `papernum`, `jobname`, `identifier`, `submittime`, `updatetime`, `infohash`, `result`) VALUES
(9, 'CSGrandeur', 0, 'Print System Document', 3, '2014-07-22 01:26:09', '2014-07-22 09:26:09', '9b33a2866d33857ba2b6a1fa78a26e15', NULL),
(10, 'CSGrandeur', 1, 'Print System Document', 4, '2014-07-22 01:26:16', '2014-07-22 09:26:16', '460c8f4f2b31c752b15cde40d5b28267', NULL),
(11, 'CSGrandeur', 0, 'Print System Document', 5, '2014-07-22 01:26:20', '2014-07-22 09:26:20', 'e11666807711801b43bb83ff7c45e575', NULL),
(12, 'CSGrandeur', 1, 'Print System Document', 6, '2014-07-22 01:26:26', '2014-07-22 09:26:26', 'c93667f27e6a3cd54a8084c4caa3b292', NULL),
(13, 'CSGrandeur', 1, 'Print System Document', 7, '2014-07-22 01:26:31', '2014-07-22 09:26:31', '56303c1f95702076abb87583a365a680', NULL),
(14, 'CSGrandeur', 1, 'Print System Document', 14, '2014-07-22 01:35:51', '2014-07-22 09:35:51', '3cc134f06a815297b4829f1dd0b5b102', 0),
(15, 'CSGrandeur', 1, 'Print System Document', 15, '2014-07-22 01:36:10', '2014-07-22 09:36:10', 'eb59937429e1f2f3d4e9b4cfb7edba36', 0),
(16, 'CSGrandeur', 1, 'Print System Document', 16, '2014-07-22 01:36:22', '2014-07-22 09:36:23', '0e24a5a85f0c4ec39dadd0aec3eb6c8e', 1),
(17, 'CSGrandeur', 1, 'Print System Document', 17, '2014-07-22 01:37:34', '2014-07-22 09:37:34', '22b3b1e647b6244f302e5ad91c85a29d', 1);

-- --------------------------------------------------------

--
-- 表的结构 `lab_privilege`
--

CREATE TABLE IF NOT EXISTS `lab_privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '学号/编号/帐号',
  `privi` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT '权限',
  `kind` tinyint(1) DEFAULT '0' COMMENT '类型标记',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `lab_privilege`
--

INSERT INTO `lab_privilege` (`id`, `uid`, `privi`, `kind`) VALUES
(4, '124611172', 'lab_super_admin', 1);

-- --------------------------------------------------------

--
-- 表的结构 `lab_user`
--

CREATE TABLE IF NOT EXISTS `lab_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) NOT NULL COMMENT '学号/编号/帐号',
  `passwd` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `kind` tinyint(1) DEFAULT '41' COMMENT '是老师还是学生。41学生，42老师。详见ConstVal.php',
  `graduate` tinyint(1) DEFAULT '61' COMMENT '是否毕业离校。61在校，62离校',
  PRIMARY KEY (`id`,`uid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- 转存表中的数据 `lab_user`
--

INSERT INTO `lab_user` (`id`, `uid`, `passwd`, `name`, `kind`, `graduate`) VALUES
(35, '124611172', 'e0c10f451217b93f76c2654b2b729b85', '郭云镝', 42, 62);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `lab_userdetail`
--

INSERT INTO `lab_userdetail` (`id`, `uid`, `sex`, `phone`, `email`, `degree`, `grade`, `birthday`, `idcard`, `nation`, `political`, `institute`, `major`, `supervisor`, `teacher`, `supervisorid`, `teacherid`) VALUES
(4, '124611172', 51, '1212', '313', 10, '2121', '0000-00-00', '123', '汉', '', 202, 402, '郭云镝', '郭云镝', '', '');

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
-- 限制表 `lab_userdetail`
--
ALTER TABLE `lab_userdetail`
  ADD CONSTRAINT `lab_userdetail_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_user` (`uid`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
