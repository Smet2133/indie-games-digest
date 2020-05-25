-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 17 2013 г., 02:07
-- Версия сервера: 5.5.35-log
-- Версия PHP: 5.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `indiedigest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `InDarticles`
--

CREATE TABLE IF NOT EXISTS `InDarticles` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `text` longtext NOT NULL,
  `poster_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `main_img_link` tinytext NOT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Дамп данных таблицы `InDarticles`
--

INSERT INTO `InDarticles` (`article_id`, `name`, `text`, `poster_id`, `date`, `main_img_link`) VALUES
(24, 'Starbound', '', 8, '2013-12-15 16:01:15', 'images/starbound.jpg'),
(27, 'Garry''s Mod', '', 8, '2013-12-15 16:17:34', 'images/GarrysMod.jpg'),
(28, 'Game Dev Tycoon', '', 8, '2013-12-15 16:20:48', 'images/gamedevtycoon.jpg'),
(30, 'Violett', '', 8, '2013-12-15 16:25:23', 'images/Violett.jpg'),
(31, 'Dino D-Day', '', 8, '2013-12-15 16:27:09', 'images/DinoD-Day.jpg'),
(34, 'Don&#8217;t Starve', '', 8, '2013-12-15 16:36:26', 'images/DontStarve.jpg'),
(35, 'Space Engineers', '', 8, '2013-12-15 16:37:23', 'images/SpaceEngineers.jpg'),
(36, 'DayZ', '', 8, '2013-12-17 01:37:01', 'images/DayZ.jpg'),
(37, 'Rust', '', 8, '2013-12-17 01:39:06', 'images/Rust.jpg'),
(38, 'Motor Rock', '', 8, '2013-12-17 01:45:38', 'images/MotorRock.jpg'),
(39, 'Nether', '', 8, '2013-12-17 01:48:03', 'images/Nether.jpg'),
(40, 'Blockland', '', 8, '2013-12-17 01:48:26', 'images/Blockland.jpg'),
(41, 'Dungeon of the Endless', '', 8, '2013-12-17 01:52:15', 'images/DungeonoftheEndless.jpg'),
(42, 'Kerbal Space Program', '', 8, '2013-12-17 01:53:44', 'images/KerbalSpaceProgram.jpg'),
(43, 'Project Zomboid', '', 8, '2013-12-17 01:54:35', 'images/ProjectZomboid.jpg'),
(44, 'Kingdoms Rise', '', 8, '2013-12-17 01:55:16', 'images/KingdomsRise.jpg'),
(45, 'Endless Space Gold', '', 8, '2013-12-17 01:56:22', 'images/EndlessSpaceGold.jpg'),
(46, 'Blackguards', '', 8, '2013-12-17 01:58:17', 'images/Blackguards.jpg'),
(47, 'Teslagrad', '', 8, '2013-12-17 02:01:06', 'images/Teslagrad.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `InDcomments`
--

CREATE TABLE IF NOT EXISTS `InDcomments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `author_login` tinytext NOT NULL,
  `title` tinytext,
  `text` mediumtext NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `InDcomments`
--

INSERT INTO `InDcomments` (`comment_id`, `date`, `author_login`, `title`, `text`, `article_id`) VALUES
(1, '2013-12-15 13:00:03', '11', '123', '321', 4),
(2, '2013-12-15 13:00:07', '11', '11', '22', 4),
(3, '2013-12-15 13:00:12', '11', '11', '22', 4),
(4, '2013-12-15 13:00:17', '11', '32', '213', 4),
(5, '2013-12-15 13:00:21', '11', '321', '123', 4),
(6, '2013-12-15 13:00:24', '11', '321', '1233', 4),
(7, '2013-12-16 23:50:50', '11', 'укц', 'цук', 30),
(8, '2013-12-16 23:51:02', '11', 'укцук', 'цкцук', 30),
(9, '2013-12-16 23:51:10', '11', 'пукп', 'уккеу', 30),
(10, '2013-12-16 23:51:19', '11', 'кцукцукуцк', 'цуццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццц', 30),
(11, '2013-12-16 23:51:30', '11', 'аывавы', 'цуцццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццуцццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццуцццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццуцццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццуцццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццуцццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццуцццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццуцццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццуццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццццц', 30);

-- --------------------------------------------------------

--
-- Структура таблицы `InDFavArticles`
--

CREATE TABLE IF NOT EXISTS `InDFavArticles` (
  `login` tinytext NOT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `InDFavArticles`
--

INSERT INTO `InDFavArticles` (`login`, `article_id`) VALUES
('11', 30),
('11', 35),
('11', 31);

-- --------------------------------------------------------

--
-- Структура таблицы `indusers`
--

CREATE TABLE IF NOT EXISTS `indusers` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `login` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `name` tinytext,
  `surname` tinytext,
  `country` tinytext,
  `birthdate` date DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `indusers`
--

INSERT INTO `indusers` (`user_id`, `login`, `password`, `email`, `name`, `surname`, `country`, `birthdate`) VALUES
(8, '11', '11', '11', 'вап', 'ап', 'ап', '2015-03-01');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
