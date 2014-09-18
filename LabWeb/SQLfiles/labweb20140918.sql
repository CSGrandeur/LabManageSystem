-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-09-18 16:18:18
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lab_checkingin`
--

CREATE TABLE IF NOT EXISTS `lab_checkingin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) NOT NULL COMMENT '学号',
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
  `uid` varchar(30) NOT NULL DEFAULT '#' COMMENT '可能为空，由管理员设置',
  `onlyname` varchar(100) NOT NULL,
  `clientIP` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `lab_privilege`
--

INSERT INTO `lab_privilege` (`id`, `uid`, `privi`, `kind`) VALUES
(1, 'admin', 'lab_super_admin', 0),
(2, '124612280', 'lab_admin', 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `lab_report`
--

INSERT INTO `lab_report` (`id`, `uid`, `kind`, `title`, `content`, `submittime`, `updatetime`, `available`) VALUES
(1, '144601044', 76, '[2014秋课表]', '&lt;p&gt;		&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:7px;text-align:center;line-height:19px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;text-decoration:underline;&quot;&gt;&lt;span style=&quot;font-size:19px;font-family:黑体;color:red;letter-spacing:1px&quot;&gt;中南大学信息学院2014年秋季博士研究生专业课程表&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:7px;text-align:center;line-height:19px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体;color:blue;letter-spacing:1px&quot;&gt;（控制科学与工程、计算机科学与技术、交通信息工程及控制）&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt; &lt;/strong&gt;&lt;strong&gt; &lt;/strong&gt;&lt;strong&gt; &lt;/strong&gt;&lt;strong&gt; &lt;/strong&gt;&lt;strong&gt; &amp;nbsp; &lt;/strong&gt;&lt;/p&gt;&lt;table cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; width=&quot;1003&quot; style=&quot;width: 992px;&quot;&gt;&lt;tbody&gt;&lt;tr style=&quot;;page-break-inside:avoid&quot; class=&quot;firstRow&quot;&gt;&lt;td width=&quot;20&quot; rowspan=&quot;2&quot; style=&quot;border: 1px solid windowtext; padding: 0px 7px;&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px;font-family: 宋体&quot;&gt;星期&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;661&quot; colspan=&quot;5&quot; style=&quot;border-top-color: windowtext; border-right-color: windowtext; border-bottom-color: windowtext; border-width: 1px; border-style: solid; padding: 0px 7px;&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px;font-family: 宋体&quot;&gt;节&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px&quot;&gt;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px;font-family: 宋体&quot;&gt;次&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;159&quot; rowspan=&quot;2&quot; style=&quot;border-top-color: windowtext; border-right-color: windowtext; border-bottom-color: windowtext; border-width: 1px; border-style: solid; padding: 0px 7px;&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 宋体&quot;&gt;（课程号）课程名称&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;84&quot; rowspan=&quot;2&quot; style=&quot;border-top-color: windowtext; border-right-color: windowtext; border-bottom-color: windowtext; border-width: 1px; border-style: solid; padding: 0px 7px;&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 宋体&quot;&gt;学&lt;/span&gt; &lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 宋体&quot;&gt;时&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;100&quot; rowspan=&quot;2&quot; style=&quot;border-top-color: windowtext; border-right-color: windowtext; border-bottom-color: windowtext; border-width: 1px; border-style: solid; padding: 0px 7px;&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 宋体&quot;&gt;任课教师&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr style=&quot;;page-break-inside:avoid&quot;&gt;&lt;td width=&quot;142&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px&quot;&gt;1 &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px;font-family: 宋体&quot;&gt;—&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px&quot;&gt; 2&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;147&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px&quot;&gt;3 &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px;font-family: 宋体&quot;&gt;—&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px&quot;&gt; 4&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;133&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px&quot;&gt;5 &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px;font-family: 宋体&quot;&gt;—&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px&quot;&gt; 6&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;133&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px&quot;&gt;7 &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px;font-family: 宋体&quot;&gt;—&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px&quot;&gt; 8&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;107&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px;font-family: 宋体&quot;&gt;晚上&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr style=&quot;;page-break-inside:avoid;height:87px&quot;&gt;&lt;td width=&quot;20&quot; style=&quot;border-right-color: windowtext; border-bottom-color: windowtext; border-left-color: windowtext; border-width: 1px; border-style: solid; padding: 0px 7px;&quot; height=&quot;87&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px;font-family: 宋体&quot;&gt;一&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;142&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;87&quot;&gt;&lt;p style=&quot;line-height:20px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;3-10&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;先进机器人学&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;line-height:20px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;科北&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;106&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;line-height:20px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;11-18&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;现代通信与安全技术&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;科北&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;106&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;147&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;87&quot;&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;3-10&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;先进机器人学&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;line-height:20px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;科北&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;106&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;11-18&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;现代通信与安全技术&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;科北&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;106&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-right-color: windowtext; border-width: 1px; padding: 0px 7px;&quot; height=&quot;87&quot;&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;11-18&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;列车通信网络&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;二综&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;604&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;87&quot;&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;11-18&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;列车通信网络&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;二综&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;604&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;107&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;87&quot;&gt;&lt;br/&gt;&lt;/td&gt;&lt;td width=&quot;159&quot; rowspan=&quot;5&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;87&quot;&gt;&lt;p style=&quot;margin-right:3px;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;（&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;081101201&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;）智能系统原理与应用&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;（&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;081101203&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;）先进控制理论与控制工程&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;（&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;081101302&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;）复杂过程控制技术及应用&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;（&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;081101401&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;）先进机器人学&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;（&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;081201201&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;）现代计算机应用技术&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;（&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;081201303&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;）现代通信与安全技术&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;（&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;082301293&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;）智能交通系统理论与应用&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;（&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;082301391&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;）网络动态系统协调控制&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;（&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;082301417&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;）列车通信网路&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;（&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;082301418&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;）列车综合测试及故障诊断&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;84&quot; rowspan=&quot;5&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;87&quot;&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;32&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;32&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;32&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;32&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;32&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;32&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;32&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;32&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:   17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;32&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-indent:24px;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;32&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;100&quot; rowspan=&quot;5&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;87&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;蔡自兴&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;停开&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;阳春华&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;谭冠政&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;王国军&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;王建新&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;樊晓平&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;王晶（排课待定）&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;陈特放&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:17px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:   12px;font-family:宋体&quot;&gt;陈特放&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr style=&quot;;page-break-inside:avoid;height:103px&quot;&gt;&lt;td width=&quot;20&quot; style=&quot;border-right-color: windowtext; border-bottom-color: windowtext; border-left-color: windowtext; border-width: 1px; border-style: solid; padding: 0px 7px;&quot; height=&quot;103&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px;font-family: 宋体&quot;&gt;二&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;142&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;103&quot;&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;3-10&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;复杂过程控制技术及应用&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;科北&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;106&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;147&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;103&quot;&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;3-10&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;复杂过程控制技术及应用&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;科北&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;106&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;border-top-color: windowtext; border-right-color: windowtext; border-bottom-color: windowtext; border-width: 1px; border-style: solid; padding: 0px 7px;&quot; height=&quot;103&quot;&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;11-18&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;智能交通系统理论与应用&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;二综&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;608&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;103&quot;&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;3-10&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;智能系统原理与应用&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;科北&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;103&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;11-18&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;智能交通系统理论与应用&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt; &lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;二综&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;608&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;107&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;103&quot;&gt;&lt;br/&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr style=&quot;;page-break-inside:avoid;height:97px&quot;&gt;&lt;td width=&quot;20&quot; style=&quot;border-right-color: windowtext; border-bottom-color: windowtext; border-left-color: windowtext; border-width: 1px; border-style: solid; padding: 0px 7px;&quot; height=&quot;97&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px;font-family: 宋体&quot;&gt;三&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;142&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;97&quot;&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体;color:blue;letter-spacing:1px&quot;&gt;2-9&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体;color:blue;letter-spacing:1px&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体;color:blue;letter-spacing:1px&quot;&gt;中国马克思主义与当代&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体;color:blue;letter-spacing:1px&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;M3 &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体;color:blue;letter-spacing:1px&quot;&gt;科南204&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;147&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;97&quot;&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体;color:blue;letter-spacing:1px&quot;&gt;2-9&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体;color:blue;letter-spacing:1px&quot;&gt;周公&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体;color:blue;letter-spacing:1px&quot;&gt;中国马克思主义与当代&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体;color:blue;letter-spacing:1px&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;M3 &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体;color:blue;letter-spacing:1px&quot;&gt;科南204&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;97&quot;&gt;&lt;br/&gt;&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;97&quot;&gt;&lt;br/&gt;&lt;/td&gt;&lt;td width=&quot;107&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;97&quot;&gt;&lt;br/&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr style=&quot;;page-break-inside:avoid;height:16px&quot;&gt;&lt;td width=&quot;20&quot; rowspan=&quot;3&quot; style=&quot;border-right-color: windowtext; border-bottom-color: windowtext; border-left-color: windowtext; border-width: 1px; border-style: solid; padding: 0px 7px;&quot; height=&quot;16&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px;font-family: 宋体&quot;&gt;四&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;142&quot; rowspan=&quot;3&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;16&quot;&gt;&lt;br/&gt;&lt;/td&gt;&lt;td width=&quot;147&quot; rowspan=&quot;3&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;16&quot;&gt;&lt;br/&gt;&lt;/td&gt;&lt;td width=&quot;133&quot; rowspan=&quot;3&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;16&quot;&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;11-18&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;列车综合测试及故障诊断&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;二综&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;604&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;133&quot; rowspan=&quot;3&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;16&quot;&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;3-10&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;智能系统原理与应用&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;科北&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;103&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;11-18&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;列车综合测试及故障诊断&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;二综&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;604&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;107&quot; rowspan=&quot;3&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;16&quot;&gt;&lt;br/&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr style=&quot;;page-break-inside:avoid;height:18px&quot;&gt;&lt;/tr&gt;&lt;tr style=&quot;;page-break-inside:avoid;height:78px&quot;&gt;&lt;td width=&quot;343&quot; colspan=&quot;3&quot; rowspan=&quot;2&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;78&quot;&gt;&lt;p&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;说明：&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;1&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;、本学期&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;9&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;月&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;17&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;日（第二周星期三）正式上课。课程名称前面的数字为上课起止周；课程名称后面的数字为上课地点：校本部科教南、北楼简称“科南”、“科北”；二综是指铁道校区第二综合楼&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt; &lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;。&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;2&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;、上课时间：&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;1-2&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;节&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;8:00—9:40&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;，&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;3-4&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;节&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;10:00—11:40&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;，&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;5-6&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;节&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;14:00—15:40&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;，&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;7-8&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;节&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;16:00—17:40&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;，&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;9-10&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;节&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;19:00—20&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;:&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;40&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;。&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;3&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;、第&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;9&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;、&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;15&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;周周三下午&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;5-8&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;节全校《形势与政策》课时间，具体安排届时由研究生院培养办另行通知。&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;4&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;、&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体;color:blue;letter-spacing:1px&quot;&gt;蓝色&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体&quot;&gt;为选了的课&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr style=&quot;;page-break-inside:avoid;height:17px&quot;&gt;&lt;td width=&quot;20&quot; style=&quot;border-right-color: windowtext; border-bottom-color: windowtext; border-left-color: windowtext; border-width: 1px; border-style: solid; padding: 0px 7px;&quot; height=&quot;17&quot;&gt;&lt;p style=&quot;margin-right:3px;text-align:center;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 10px;font-family: 宋体&quot;&gt;五&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;142&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;17&quot;&gt;&lt;br/&gt;&lt;/td&gt;&lt;td width=&quot;147&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;17&quot;&gt;&lt;br/&gt;&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;17&quot;&gt;&lt;br/&gt;&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;17&quot;&gt;&lt;p style=&quot;margin-right:3px;line-height:16px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体;color:blue;letter-spacing:1px&quot;&gt;3-18&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px;font-family:宋体;color:blue;letter-spacing:1px&quot;&gt;周&amp;nbsp; &amp;nbsp; 现代计算机应用技术&amp;nbsp;&amp;nbsp; &amp;nbsp; 科北107&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:12px&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;/td&gt;&lt;td width=&quot;107&quot; valign=&quot;top&quot; style=&quot;border-style: solid; border-bottom-color: windowtext; border-width: 1px; border-right-color: windowtext; padding: 0px 7px;&quot; height=&quot;17&quot;&gt;&lt;br/&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;	&lt;/p&gt;', '2014-09-17 11:43:50', '2014-09-17 11:53:28', 1);

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
  `available` tinyint(1) DEFAULT '1',
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
  `item_key` varchar(255) DEFAULT NULL COMMENT '内容主键',
  `item_key_flag` tinyint(4) DEFAULT '0' COMMENT '是否有主键',
  `item_pass_flag` tinyint(4) DEFAULT '0' COMMENT '是否有内容密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lab_statisticdo`
--

CREATE TABLE IF NOT EXISTS `lab_statisticdo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statisticid` int(11) DEFAULT NULL,
  `uid` varchar(30) DEFAULT '' COMMENT '学号/编号/帐号',
  `items` text COMMENT 'json格式的内容',
  `item_key` varchar(255) DEFAULT NULL COMMENT '内容主键（如果要求）',
  `item_pass` varchar(100) DEFAULT NULL COMMENT '内容密码（如果要求）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- 转存表中的数据 `lab_user`
--

INSERT INTO `lab_user` (`id`, `uid`, `passwd`, `name`, `kind`, `graduate`) VALUES
(1, 'admin', 'c46a5191492cbbf468d6c732e90e9a38', '管理员', 41, 61),
(2, '144601044', 'a190a6162d6f0b82b6a58e35e7fc19af', '郭云镝', 41, 61),
(3, '134612274', 'beb30d3aa02fa666608ae97a82d055d0', '谢娜', 41, 61),
(4, '124612265', '24d85bd9d80e4ae8c5f07ccc02edae5b', '吴尚', 41, 61),
(5, '134611130', 'f726f016aeabc18058127cc3e7b72708', '郑晚秋', 41, 61),
(6, '134612253', '91e4d3fe89f043a2d0b4d887709c5f04', '周其亚', 41, 61),
(7, '134611155', '1ab2587819209f9d1243cbf17c307633', '张学程', 41, 61),
(8, '134611150', '5b5392c9d7ae4612f9d2ef87e37bb45c', '刘秀芝', 41, 61),
(9, '94601042', '538332be280c3da8dedee98e4667b5cc', '张潇云', 41, 61),
(10, '104601050', 'dffeda68035a40e0b508fd7130b9acf8', '刘石坚', 41, 61),
(11, '124601018', '446a510f0ad77fd9c3c3bf3fc202c048', '朱承璋', 41, 61),
(12, '134712317', '952a6b8573aa87f3f73c8350f8e0faf4', '魏发然', 41, 61),
(13, '124611171', 'c0ee95cefac7c22ce1f59947451a9786', '邱从贤', 41, 61),
(14, '207050', 'd88cd48d516f86966c366c1e70877a1d', '梁毅雄', 42, 61),
(15, '208191', 'dbb475695f6c84cba75a728a91f7913a', '向遥', 42, 61),
(16, '114601805', '7450879bac20fb094969474b2f26a4c3', '刘晴', 41, 61),
(17, 'bjzou', 'e10adc3949ba59abbe56e057f20f883e', '邹北骥', 42, 61),
(18, '134612254', 'a5b6e1bf70e1079438079ffd0dcd1949', '喻成', 41, 61),
(19, '124712039', '90615824708f956f6733c456d569345a', '杨欢', 41, 61),
(20, '134611129', '4362fa7b2b1fddcdb1bd300b04de412f', '唐娇', 41, 61),
(21, '144611157', '499a4d234e1bd3f538da12fd10a3c71d', '郭建京', 41, 61),
(22, '144612625', '74290be06653ba620f5e30ed5531537f', '崔锦恺', 41, 61),
(23, '144611122', '2b3641be0004d8ccf17054e5876d0b53', '梅楚璇', 41, 61),
(24, '144611156', '3105940bf58f2907874cad475a43e656', '杜婧瑜', 41, 61),
(25, '124611174', '006ed7301cd2dabd5281d370c79ccb9b', '罗四伟', 41, 61),
(26, '134611153', 'd08541888277ed64b9e64340bce82e24', '李潇', 41, 61),
(27, '144601002', '0bfa80ac6b30cdcf762646c81f152679', '吴慧', 41, 61),
(28, '124612280', 'fd7a0386a473dcacd5799110afa59e08', '刘日', 41, 61),
(29, '134611154', '02a58dc8b95273313445c11ea714bc29', '张思剑', 41, 61),
(30, '124611149', '0bddf6438f9f5c1b7faeba110b91bef8', '王勋', 41, 61),
(31, '144611150', '2233d68684d7dc6c0faa16a31421cb8e', '李暄', 41, 61);

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
(1, '144601044', 51, '', '', 21, '2014', '0000-00-00', '', '', '', 201, 401, '', '', '', '');

--
-- 限制导出的表
--

--
-- 限制表 `lab_checkingin`
--
ALTER TABLE `lab_checkingin`
  ADD CONSTRAINT `lab_checkingin_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_user` (`uid`);

--
-- 限制表 `lab_printaddition`
--
ALTER TABLE `lab_printaddition`
  ADD CONSTRAINT `lab_printaddition_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_user` (`uid`);

--
-- 限制表 `lab_printarrange`
--
ALTER TABLE `lab_printarrange`
  ADD CONSTRAINT `lab_printarrange_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_user` (`uid`);

--
-- 限制表 `lab_report_discuss`
--
ALTER TABLE `lab_report_discuss`
  ADD CONSTRAINT `lab_report_discuss_ibfk_1` FOREIGN KEY (`reportid`) REFERENCES `lab_report` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `lab_userdetail`
--
ALTER TABLE `lab_userdetail`
  ADD CONSTRAINT `lab_userdetail_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `lab_user` (`uid`) ON DELETE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
