-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2014 年 5 月 13 日 14:59
-- サーバのバージョン： 5.5.37-log
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `codeigniter`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `tweet`
--

CREATE TABLE IF NOT EXISTS `tweet` (
  `tweet_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `content` varchar(140) NOT NULL,
  `create_tweet` datetime NOT NULL,
  `adress` varchar(128) NOT NULL,
  PRIMARY KEY (`tweet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- テーブルのデータのダンプ `tweet`
--

INSERT INTO `tweet` (`tweet_id`, `name`, `content`, `create_tweet`, `adress`) VALUES
(1, '悠太', '海鮮丼が食べたい', '2014-05-13 12:58:52', 'yuta@yuta.jp'),
(2, '悠太', 'カレーが食べたい', '2014-05-13 12:58:58', 'yuta@yuta.jp'),
(3, '悠太', 'お寿司が久しぶりに食べたい', '2014-05-13 12:59:07', 'yuta@yuta.jp'),
(4, '悠太', '東大の学食に言ってみたい', '2014-05-13 12:59:13', 'yuta@yuta.jp'),
(5, '悠太', '間違えた', '2014-05-13 12:59:17', 'yuta@yuta.jp'),
(6, '悠太', '行ってみたいだった', '2014-05-13 12:59:23', 'yuta@yuta.jp'),
(7, '悠太', '今日は晴れだなー', '2014-05-13 12:59:35', 'yuta@yuta.jp'),
(8, '悠太', '海は綺麗かな？', '2014-05-13 12:59:47', 'yuta@yuta.jp'),
(9, '悠太', 'ああああ・・・', '2014-05-13 12:59:56', 'yuta@yuta.jp'),
(10, '悠太', '本郷', '2014-05-13 13:00:02', 'yuta@yuta.jp'),
(11, '悠太', '駅', '2014-05-13 13:00:06', 'yuta@yuta.jp'),
(12, '悠太', 'fnaefae', '2014-05-13 14:11:00', 'yuta@yuta.jp'),
(13, '悠太', 'fnaefae', '2014-05-13 14:29:19', 'yuta@yuta.jp'),
(14, '悠太', 'fnaefae', '2014-05-13 14:42:50', 'yuta@yuta.jp'),
(15, '悠太', 'fnaefae', '2014-05-13 14:46:45', 'yuta@yuta.jp'),
(16, '悠太', 'fnaefae', '2014-05-13 14:47:24', 'yuta@yuta.jp'),
(17, '悠太', 'fnaefae', '2014-05-13 14:48:14', 'yuta@yuta.jp'),
(18, '悠太', 'fnaefae', '2014-05-13 14:48:56', 'yuta@yuta.jp'),
(19, '悠太', 'fnaefae', '2014-05-13 14:49:35', 'yuta@yuta.jp');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
