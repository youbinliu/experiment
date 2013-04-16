-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 04 月 16 日 04:04
-- 服务器版本: 5.5.27
-- PHP 版本: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `cgrid`
--

-- --------------------------------------------------------

--
-- 表的结构 `cluster_info`
--

CREATE TABLE IF NOT EXISTS `cluster_info` (
  `exp_id` int(10) NOT NULL,
  `cluster_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `template_id` int(10) NOT NULL,
  `master_vcpu` int(5) NOT NULL,
  `master_mem` int(10) NOT NULL,
  `slave_vcpu` int(5) NOT NULL,
  `slave_mem` int(10) NOT NULL,
  `slave_count` int(5) NOT NULL,
  PRIMARY KEY (`exp_id`,`cluster_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cluster_info`
--

-- --------------------------------------------------------

--
-- 表的结构 `diary`
--

CREATE TABLE IF NOT EXISTS `diary` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `exp_id` int(10) NOT NULL,
  `title` varchar(40) NOT NULL,
  `time` datetime NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `exp_id` (`exp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `diary`
--

-- --------------------------------------------------------

--
-- 表的结构 `experiment`
--

CREATE TABLE IF NOT EXISTS `experiment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type_id` int(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `start_time` datetime NOT NULL,
  `describe` text NOT NULL,
  `title` varchar(40) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `tools` text,
  `result` text,
  `papers` text,
  `keywords` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- 转存表中的数据 `experiment`
--

-- --------------------------------------------------------

--
-- 表的结构 `experiment_type`
--

CREATE TABLE IF NOT EXISTS `experiment_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(40) NOT NULL,
  `detail` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `experiment_type`
--

-- --------------------------------------------------------

--
-- 表的结构 `hpcjob_info`
--

CREATE TABLE IF NOT EXISTS `hpcjob_info` (
  `job_id` int(10) NOT NULL,
  `exp_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `node_count` int(10) NOT NULL,
  `command` varchar(255) NOT NULL,
  `template_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`job_id`),
  KEY `exp_id` (`exp_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hpcjob_info`
--

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8 NOT NULL,
  `password` varchar(40) CHARACTER SET utf8 NOT NULL,
  `email` varchar(40) CHARACTER SET utf8 NOT NULL,
  `salt` varchar(40) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `salt`) VALUES
(4, 'test', 'b3e1f110084a619373feff4540891d51', 'test@test.com', '388b98c3e4a5312094b1f3a91aaed4bb59645cb4'),
(6, 'lycc316', '98b8cd406dc90f316b329c73371838d0', 'lycc316@foxmail.com', '173278222d458320f3f05eef80bc8e5cbc6b0b6a'),
(7, 'lyctest', 'caca58e53ba546353be50375b6afb071', 'lycctest@test.com', 'c745fefb23af297d80717637337979d40582b02d'),
(9, 'test001', '9b2bd8d34ab3515f6443a42a98a0e1db', 'test001@126.com', 'dc0f7a5026499b08401a03aae8a24d1d600f95bd');

-- --------------------------------------------------------

--
-- 表的结构 `user_rating`
--

CREATE TABLE IF NOT EXISTS `user_rating` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(20) DEFAULT NULL,
  `exp_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `rate_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_rating_ibfk1` (`user_id`),
  KEY `user_rating_ibfk2` (`exp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `user_rating`
--

-- --------------------------------------------------------

--
-- 表的结构 `vm_info`
--

CREATE TABLE IF NOT EXISTS `vm_info` (
  `vm_id` int(10) NOT NULL,
  `exp_id` int(10) NOT NULL,
  `memory` int(10) DEFAULT NULL,
  `image` varchar(20) DEFAULT NULL,
  `key` varchar(20) DEFAULT NULL,
  `vcpu` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`vm_id`,`exp_id`),
  KEY `exp_id` (`exp_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `vm_info`
--

--
-- 限制导出的表
--

--
-- 限制表 `cluster_info`
--
ALTER TABLE `cluster_info`
  ADD CONSTRAINT `cluster_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `cluster_info_ibfk_2` FOREIGN KEY (`exp_id`) REFERENCES `experiment` (`id`);

--
-- 限制表 `diary`
--
ALTER TABLE `diary`
  ADD CONSTRAINT `diary_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `diary_ibfk_2` FOREIGN KEY (`exp_id`) REFERENCES `experiment` (`id`);

--
-- 限制表 `experiment`
--
ALTER TABLE `experiment`
  ADD CONSTRAINT `experiment_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `experiment_type` (`id`),
  ADD CONSTRAINT `experiment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- 限制表 `hpcjob_info`
--
ALTER TABLE `hpcjob_info`
  ADD CONSTRAINT `hpcjob_info_ibfk_1` FOREIGN KEY (`exp_id`) REFERENCES `experiment` (`id`),
  ADD CONSTRAINT `hpcjob_info_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- 限制表 `user_rating`
--
ALTER TABLE `user_rating`
  ADD CONSTRAINT `user_rating_ibfk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_rating_ibfk2` FOREIGN KEY (`exp_id`) REFERENCES `experiment` (`id`);

--
-- 限制表 `vm_info`
--
ALTER TABLE `vm_info`
  ADD CONSTRAINT `vm_info_ibfk_1` FOREIGN KEY (`exp_id`) REFERENCES `experiment` (`id`),
  ADD CONSTRAINT `vm_info_ibfk_2` FOREIGN KEY (`exp_id`) REFERENCES `experiment` (`id`),
  ADD CONSTRAINT `vm_info_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
