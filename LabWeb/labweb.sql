-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-08-06 13:26:39
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
(12, '福娃额', '&lt;p&gt;		&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;测试&lt;/p&gt;&lt;p&gt;	&lt;/p&gt;', 1, '124611172', '124611172', '2014-07-27 01:30:50', '2014-08-04 16:56:26'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `lab_printaddition`
--

INSERT INTO `lab_printaddition` (`id`, `uid`, `addnum`, `month`, `available`) VALUES
(1, '134612274', 12, '2014-08-01', 1);

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
(1, '134612274', 5);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
-- 表的结构 `lab_report`
--

CREATE TABLE IF NOT EXISTS `lab_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) NOT NULL COMMENT '学号/编号/帐号',
  `kind` tinyint(1) DEFAULT '71' COMMENT '71科研进展，72文献阅读，73项目开发，74知识学习，75综合报告，76其他',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` text,
  `submittime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `available` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`,`uid`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `lab_report`
--

INSERT INTO `lab_report` (`id`, `uid`, `kind`, `title`, `content`, `submittime`, `updatetime`, `available`) VALUES
(1, '124611172', 71, '1233131', '&lt;p&gt;		&lt;/p&gt;&lt;p&gt;gerg&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;gs&lt;span style=&quot;font-size: 24px;&quot;&gt;&lt;strong&gt;er&lt;/strong&gt;&lt;/span&gt;gre&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;	&lt;/p&gt;', '2014-08-14 22:22:44', '2014-08-06 00:25:45', 1),
(2, '124611172', 71, '1', '&lt;p&gt;131&lt;/p&gt;', '2014-08-06 00:36:28', '2014-08-06 00:36:28', 1),
(3, '124611172', 71, '1', '&lt;p&gt;131&lt;/p&gt;', '2014-08-06 00:36:41', '2014-08-06 00:36:41', 1),
(4, '124611172', 71, '1', '&lt;p&gt;131&lt;/p&gt;', '2014-08-06 00:37:18', '2014-08-06 00:37:18', 1),
(5, '124611172', 71, '313', '&lt;p&gt;131&lt;/p&gt;', '2014-08-06 00:37:27', '2014-08-06 00:37:27', 1),
(6, '124611172', 71, '3131', '&lt;p&gt;31&lt;/p&gt;', '2014-08-06 00:37:51', '2014-08-06 00:37:51', 1),
(7, '124611172', 72, '31', '&lt;p&gt;rwer&lt;/p&gt;', '2014-08-06 00:40:22', '2014-08-06 00:45:05', 1);

-- --------------------------------------------------------

--
-- 表的结构 `lab_report_discuss`
--

CREATE TABLE IF NOT EXISTS `lab_report_discuss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) NOT NULL COMMENT '学号/编号/帐号',
  `content` text,
  `submittime` datetime DEFAULT NULL,
  `reportid` int(11) NOT NULL,
  PRIMARY KEY (`id`,`uid`),
  KEY `reportid` (`reportid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lab_statistic`
--

CREATE TABLE IF NOT EXISTS `lab_statistic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `des` text,
  `items` text COMMENT 'json格式的内容',
  `available` tinyint(1) DEFAULT '0',
  `submitter` varchar(30) DEFAULT NULL COMMENT 'uid,提交该内容的管理员',
  `submittime` datetime DEFAULT NULL,
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `allow_anonymous` tinyint(1) DEFAULT '0' COMMENT '为0只有登录系统才能填表，为1允许任何游客填表',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `lab_statistic`
--

INSERT INTO `lab_statistic` (`id`, `title`, `des`, `items`, `available`, `submitter`, `submittime`, `starttime`, `endtime`, `allow_anonymous`) VALUES
(1, 'test', NULL, '[""]', 0, '124611172', '2014-08-04 22:12:36', '2014-08-04 22:12:32', '2014-08-04 22:12:32', 0),
(2, 'test', NULL, '[""]', 0, '124611172', '2014-08-04 22:12:53', '2014-08-04 22:12:32', '2014-08-04 22:12:32', 0),
(3, 'test', NULL, '["123"]', 0, '124611172', '2014-08-04 22:13:36', '2014-08-04 22:13:33', '2014-08-04 22:13:33', 0),
(4, 'test', NULL, '["123","456","777"]', 0, '124611172', '2014-08-04 22:13:45', '2014-08-04 22:13:33', '2014-08-04 22:13:33', 0),
(5, 'test', NULL, '["121","3131","1313","13","13"]', 0, '124611172', '2014-08-04 22:22:06', '2014-08-04 22:21:59', '2014-08-04 22:21:59', 0),
(6, 'test213', NULL, '["121","3131","1313","13","13"]', 0, '124611172', '2014-08-04 22:51:00', '2014-08-04 22:21:59', '2014-08-04 22:21:59', 0),
(7, '123', NULL, '["121","3131","1313","13","13"]', 0, '124611172', '2014-08-04 22:54:42', '2015-02-06 08:12:00', '2018-01-01 08:00:00', 0),
(8, '', NULL, '[""]', 0, '124611172', '2014-08-04 22:55:20', '2014-08-04 22:55:08', '2015-08-04 22:55:08', 0),
(9, '123', '&lt;p&gt;		&lt;/p&gt;&lt;h1&gt;223131&lt;/h1&gt;&lt;p&gt;13131313&lt;br/&gt;&lt;/p&gt;&lt;h1&gt;&lt;span style=&quot;font-family: 隶书, SimLi;&quot;&gt;21&lt;/span&gt;&lt;/h1&gt;&lt;p&gt;	&lt;/p&gt;', '["123"]', 0, '124611172', '2014-08-05 10:19:13', '2014-08-05 10:13:13', '2014-08-05 10:13:13', 0),
(10, '', '', '[""]', 0, '124611172', '2014-08-05 10:50:04', '2014-08-05 10:46:20', '2014-08-05 10:46:20', 0),
(11, '', '', '[""]', 0, '124611172', '2014-08-05 10:50:39', '2014-08-05 10:50:37', '2014-08-05 10:50:37', 0),
(12, '', '&lt;p&gt;1313&lt;/p&gt;', '["1313"]', 0, '124611172', '2014-08-05 10:50:55', '2014-08-05 10:50:37', '2014-08-05 10:50:37', 0),
(13, '', '&lt;p&gt;1313&lt;/p&gt;', '["1313"]', 0, '124611172', '2014-08-05 10:51:09', '2014-08-05 10:50:37', '2014-08-05 10:50:37', 0),
(14, '3131', '', '["3131"]', 0, '124611172', '2014-08-05 11:07:51', '2001-08-05 10:57:16', '2015-08-05 10:57:16', 0),
(15, '学号姓名统计', '&lt;p&gt;		&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;本系统用于实验室日常工作，目前有实验室通知，打印机纸张管理，进展报告提交与批示评论，计算机运行状况实时监测等功能，以后还会加入更多方便大家学习和工作的功能，有好的意见和建议也可以提出来。&lt;br/&gt;&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;&lt;br/&gt;&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;为合理使用本系统，需要给大家每人一个可登录的帐号。用学号登录是最合适的了，这里统计一下大家的学号和姓名，方便批量导入系统。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;	&lt;/p&gt;', '["\\u5b66\\u53f7","\\u59d3\\u540d"]', 1, '124611172', '2014-08-05 13:51:16', '2014-08-05 11:23:31', '2014-08-20 11:23:31', 1);

-- --------------------------------------------------------

--
-- 表的结构 `lab_statisticdo`
--

CREATE TABLE IF NOT EXISTS `lab_statisticdo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statisticid` int(11) DEFAULT NULL,
  `uid` varchar(30) DEFAULT '' COMMENT '学号/编号/帐号',
  `items` text COMMENT 'json格式的内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- 转存表中的数据 `lab_statisticdo`
--

INSERT INTO `lab_statisticdo` (`id`, `statisticid`, `uid`, `items`) VALUES
(41, 15, NULL, '["124612265","\\u5434\\u5c1a"]'),
(57, 15, NULL, '["134611130","\\u90d1\\u665a\\u79cb"]'),
(58, 15, NULL, '["134612253","\\u5468\\u5176\\u4e9a"]');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- 转存表中的数据 `lab_user`
--

INSERT INTO `lab_user` (`id`, `uid`, `passwd`, `name`, `kind`, `graduate`) VALUES
(35, '124611172', '96e79218965eb72c92a549dd5a330112', '郭云镝', 41, 61),
(36, '134612274', 'beb30d3aa02fa666608ae97a82d055d0', '谢娜', 41, 61),
(37, '124612265', '24d85bd9d80e4ae8c5f07ccc02edae5b', '吴尚', 41, 61),
(38, '134611130', 'd6566e905dfcc11798eda777aa586803', '郑晚秋', 41, 61),
(39, '134612253', '91e4d3fe89f043a2d0b4d887709c5f04', '周其亚', 41, 61);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `lab_userdetail`
--

INSERT INTO `lab_userdetail` (`id`, `uid`, `sex`, `phone`, `email`, `degree`, `grade`, `birthday`, `idcard`, `nation`, `political`, `institute`, `major`, `supervisor`, `teacher`, `supervisorid`, `teacherid`) VALUES
(4, '124611172', 51, '1212', '313', 21, '551', '1985-06-13', '2', '汉', '团员', 201, 401, 'test', 'test', '#', '#'),
(5, '134612274', 52, '', '', 11, '120', '0000-00-00', '123', '', '', 201, 401, '', '', '', '');

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
-- 限制表 `lab_report_discuss`
--
ALTER TABLE `lab_report_discuss`
  ADD CONSTRAINT `lab_report_discuss_ibfk_1` FOREIGN KEY (`reportid`) REFERENCES `lab_report` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `lab_userdetail`
--
ALTER TABLE `lab_userdetail`
  ADD CONSTRAINT `lab_userdetail_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_user` (`uid`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
