-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 12, 2014 at 01:17 AM
-- Server version: 5.5.35
-- PHP Version: 5.3.10-1ubuntu3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `thread_id` int(10) unsigned NOT NULL,
  `post_index` int(11) NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `votes` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9474526CE29040191768EBEE` (`thread_id`,`post_index`),
  KEY `IDX_9474526CA76ED395` (`user_id`),
  KEY `IDX_9474526CE2904019` (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comment_track`
--

CREATE TABLE IF NOT EXISTS `comment_track` (
  `user_id` int(10) unsigned NOT NULL,
  `comment_id` int(10) unsigned NOT NULL,
  `thread_id` int(10) unsigned DEFAULT NULL,
  `has_voted` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`comment_id`),
  KEY `IDX_7F796057A76ED395` (`user_id`),
  KEY `IDX_7F796057F8697D13` (`comment_id`),
  KEY `IDX_7F796057E2904019` (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_displayed` tinyint(1) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `num_threads` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C242628727ACA70` (`parent_id`),
  KEY `IDX_C24262846C53D4C` (`is_enabled`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `parent_id`, `name`, `description`, `is_displayed`, `is_enabled`, `num_threads`) VALUES
(1, NULL, 'module-1', '', 0, 0, 0),
(2, NULL, 'module-2', '', 0, 0, 0),
(3, 1, 'submodule-1-1', 'description1', 1, 1, 0),
(4, 1, 'submodule-1-2', 'description2', 1, 1, 0),
(5, 2, 'submodule-2-1', '', 1, 1, 0),
(6, 2, 'submodule-2-2', '', 1, 1, 0),
(7, 1, 'submodule-1-3', '', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_57698A6A57698A6A` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `role`) VALUES
(1, 'admin', 'ROLE_ADMIN'),
(2, 'user', 'ROLE_USER');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE IF NOT EXISTS `thread` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `num_replies` int(10) unsigned NOT NULL,
  `num_views` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_31204C83A76ED395` (`user_id`),
  KEY `IDX_31204C83AFC2B591` (`module_id`),
  KEY `IDX_31204C8343625D9F` (`updated_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `thread_track`
--

CREATE TABLE IF NOT EXISTS `thread_track` (
  `user_id` int(10) unsigned NOT NULL,
  `thread_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  `has_viewed` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`thread_id`),
  KEY `IDX_DC67E79DA76ED395` (`user_id`),
  KEY `IDX_DC67E79DE2904019` (`thread_id`),
  KEY `IDX_DC67E79DAFC2B591` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_2DE8C6A3A76ED395` (`user_id`),
  KEY `IDX_2DE8C6A3D60322AC` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CE2904019` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`),
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `comment_track`
--
ALTER TABLE `comment_track`
  ADD CONSTRAINT `FK_7F796057E2904019` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`),
  ADD CONSTRAINT `FK_7F796057A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_7F796057F8697D13` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`);

--
-- Constraints for table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `FK_C242628727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `module` (`id`);

--
-- Constraints for table `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `FK_31204C83AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`),
  ADD CONSTRAINT `FK_31204C83A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `thread_track`
--
ALTER TABLE `thread_track`
  ADD CONSTRAINT `FK_DC67E79DAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`),
  ADD CONSTRAINT `FK_DC67E79DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_DC67E79DE2904019` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `FK_2DE8C6A3D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2DE8C6A3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
