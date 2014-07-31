-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-07-31 08:01:35
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
-- 表的结构 `lab_announcement`
--

CREATE TABLE IF NOT EXISTS `lab_announcement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` text,
  `available` tinyint(1) DEFAULT '0',
  `submitter` varchar(30) DEFAULT NULL COMMENT 'uid,提交该内容的管理员',
  `mender` varchar(30) DEFAULT NULL COMMENT 'uid,提交该内容的管理员',
  `submittime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `lab_announcement`
--

INSERT INTO `lab_announcement` (`id`, `title`, `content`, `available`, `submitter`, `mender`, `submittime`, `updatetime`) VALUES
(1, '', '&lt;p&gt;&lt;img src=&quot;/Public/upload/Announcement/image/201407/1406450170928754.jpg&quot; title=&quot;1406450170928754.jpg&quot; alt=&quot;1.jpg&quot;/&gt;&lt;/p&gt;', 1, '124611172', '124611172', '2014-07-27 00:36:38', '2014-07-27 16:36:12'),
(2, '1', '', 1, '124611172', NULL, '2014-07-27 00:36:38', '2014-07-27 00:36:38'),
(3, '3333333333', '&lt;p&gt;		&lt;/p&gt;&lt;h2&gt;333&lt;span style=&quot;color: rgb(31, 73, 125);&quot;&gt;333&lt;span style=&quot;color: rgb(31, 73, 125); font-family: 楷体, 楷体_GB2312, SimKai; font-size: 20px;&quot;&gt;33&lt;/span&gt;33&lt;/span&gt;&lt;span style=&quot;background-color: rgb(229, 224, 236);&quot;&gt;&lt;span style=&quot;background-color: rgb(229, 224, 236); color: rgb(31, 73, 125);&quot;&gt;33&lt;/span&gt;33333&lt;/span&gt;3&lt;/h2&gt;&lt;h1&gt;}d&lt;strong&gt;wf&lt;/strong&gt;&lt;/h1&gt;', 1, '124611172', '124611172', '2014-07-26 21:45:58', '2014-07-27 16:43:48'),
(4, '313131', '&lt;p&gt;3131&lt;/p&gt;', 1, '124611172', NULL, '2014-07-27 00:31:12', '2014-07-27 00:36:38'),
(5, '1414', '&lt;p&gt;14&lt;/p&gt;', 1, '124611172', NULL, '2014-07-27 00:31:24', '2014-07-27 00:36:38'),
(6, '414141', '&lt;p&gt;41&lt;/p&gt;', 1, '124611172', NULL, '2014-07-27 00:31:30', '2014-07-27 00:36:38'),
(7, '414141', '&lt;p&gt;\n		ffffffffffffffffffffffffffffffffffffffffff&lt;/p&gt;', 1, '124611172', NULL, '2014-07-27 00:35:20', '2014-07-27 00:36:38'),
(8, '1啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊嘿嗯', '&lt;p&gt;		&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;3123123&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;	&lt;/p&gt;', 1, '124611172', '124611172', '2014-07-27 01:27:13', '2014-07-27 01:29:22'),
(9, '1', '&lt;p&gt;		&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;噶恶&lt;strong&gt;搞&lt;/strong&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;eargagaregaega&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;br/&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(75, 172, 198);&quot;&gt;&lt;strong&gt;gaeaer&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;br/&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;br/&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;	&lt;/p&gt;', 1, '124611172', NULL, '2014-07-27 01:12:52', '2014-07-27 00:36:38'),
(10, '阿发违法', '', 1, '124611172', '124611172', '2014-07-27 01:30:37', '2014-07-27 01:30:37'),
(11, 'fawe福娃福娃额', '&lt;p&gt;法俄无法&lt;/p&gt;', 1, '124611172', '124611172', '2014-07-27 01:30:42', '2014-07-27 01:30:42'),
(12, '福娃额', '&lt;p&gt;分啊无法违法&lt;/p&gt;', 1, '124611172', '124611172', '2014-07-27 01:30:50', '2014-07-27 01:30:50'),
(13, '132', '&lt;p&gt;		&lt;/p&gt;&lt;p&gt;&lt;embed type=&quot;application/x-shockwave-flash&quot; class=&quot;edui-faked-music&quot; pluginspage=&quot;http://www.macromedia.com/go/getflashplayer&quot; src=&quot;http://box.baidu.com/widget/flash/bdspacesong.swf?from=tiebasongwidget&amp;url=&amp;name=%E5%A4%9C%E7%A9%BA%E4%B8%AD%E6%9C%80%E4%BA%AE%E7%9A%84%E6%98%9F&amp;artist=%E5%BC%A0%E6%81%92%E8%BF%9C&amp;extra=%E4%B8%AD%E5%9B%BD%E5%A5%BD%E5%A3%B0%E9%9F%B3%E7%AC%AC%E4%BA%8C%E5%AD%A3%20%E5%B7%85%E5%B3%B0%E4%B9%8B%E5%A4%9C&amp;autoPlay=false&amp;loop=true&quot; width=&quot;400&quot; height=&quot;95&quot; align=&quot;none&quot; wmode=&quot;transparent&quot; play=&quot;true&quot; loop=&quot;false&quot; menu=&quot;false&quot; allowscriptaccess=&quot;never&quot; allowfullscreen=&quot;true&quot;/&gt;&lt;/p&gt;&lt;p&gt;	&lt;/p&gt;', 1, '124611172', '124611172', '2014-07-27 11:15:28', '2014-07-27 18:17:08');

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
  `available` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0无效，1有效',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `lab_printaddition`
--

INSERT INTO `lab_printaddition` (`id`, `uid`, `addnum`, `month`, `available`) VALUES
(1, '124611172', 0, '1970-01-01', 1),
(2, '124611172', 0, '1970-01-01', 1),
(3, '124611172', 1, '1970-01-01', 1),
(4, '124611172', 21, '1970-01-01', 1),
(5, '124611172', 31, '1970-01-01', 1),
(6, '124611172', 2, '2014-07-01', 1),
(7, '124611172', 3131, '2014-07-01', 1),
(8, '124611172', 41412, '2014-07-01', 1),
(9, '124611172', 31, '2014-07-01', 1),
(10, '124611172', 313, '2014-07-01', 1),
(11, '124611172', 121, '2014-07-01', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `lab_printarrange`
--

INSERT INTO `lab_printarrange` (`id`, `uid`, `paperlimit`) VALUES
(1, '124611172', 1);

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
(35, '124611172', '96e79218965eb72c92a549dd5a330112', '郭云镝', 41, 61);

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
(4, '124611172', 51, '1212', '313', 10, '551', '1985-06-13', '2', '汉', '团员', 201, 401, '郭云镝', '郭云镝', '#', '124611172');

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
