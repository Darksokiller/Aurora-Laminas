-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 12, 2021 at 05:47 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.9


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aurora-laminas`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

DROP TABLE IF EXISTS `album`;
CREATE TABLE IF NOT EXISTS `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `artist`, `title`) VALUES
(1, 'Hank Williams Jr.', 'Lone Wolf edit'),
(2, 'Alan Jackson', 'Chatahoocie'),
(3, 'Eminemmmmm', 'Love the way you lie'),
(4, 'random artist', 'test title'),
(5, 'home page artist', 'add from home page'),
(6, 'test artist two', 'test two');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `companyName` varchar(255) NOT NULL,
  `pageId` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `userId`, `companyName`, `pageId`, `active`) VALUES
(1, 2, 'Webinertia', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_files`
--

DROP TABLE IF EXISTS `project_files`;
CREATE TABLE IF NOT EXISTS `project_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectId` int(11) NOT NULL,
  `filePath` mediumtext NOT NULL,
  `fileName` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `projectId` (`projectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `project_images`
--

DROP TABLE IF EXISTS `project_images`;
CREATE TABLE IF NOT EXISTS `project_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectId` int(11) NOT NULL,
  `imgPath` mediumtext NOT NULL,
  `fileName` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `projectId` (`projectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(100) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `companyName` varchar(255) NOT NULL,
  `regDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='will join user_profile table on id';

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `userName`, `email`, `password`, `role`, `companyName`, `regDate`, `active`, `verified`) VALUES
(1, 'Joey Smith', 'jsmith@webinertia.net', '$2y$10$ncO3bgCRcWaCdeINBffN4eDBAuRnhden9eZd6hXQIttrGc1hjoFlO', 'admin', '', '2021-11-08 22:26:20', 1, 1),
(2, 'UserTwo', 'two@webinertia.net', '$2y$10$wi2CLqw83DaqREbg0y.yA.T1I/0UQL8r3yEcA6EQJ11868tUVhum2', 'user', '', '2021-11-08 22:26:20', 0, 0),
(3, 'Test Three', 'three@webinertia.net', '$2y$10$QrSQtxbPecBQbxju.8k9au.g.jZ3etqYLjcmosOk35wONpvH6iPGS', 'user', '', '2021-11-08 22:26:20', 0, 0),
(4, 'Test Four', 'four@webinertia.net', '$2y$10$dLZDo0yA85duccXQDoSgB.e4NYXPm1lFJhw48H5.xPUQW.WkPOlV6', 'user', '', '2021-11-08 22:26:20', 0, 0),
(5, 'LoginUser', 'logintest@webinertia.net', '$2y$10$g1RcC9cX7yUYEKoZKgO4CefhJ0QY8yPyqUi5eR4DkNOKa1BW8a1xe', 'user', '', '2021-11-08 22:26:20', 0, 0),
(6, 'LoginUserTwo', 'LoginUserTwo@webinertia.net', '$2y$10$ncO3bgCRcWaCdeINBffN4eDBAuRnhden9eZd6hXQIttrGc1hjoFlO', 'user', '', '2021-11-08 22:26:20', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `avatarPath` mediumtext NOT NULL,
  `age` int(11) NOT NULL,
  `birthday` varchar(10) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `race` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='dependent upon users table relational key is userId';

--
-- Constraints for dumped tables
--

--
-- Constraints for table `project_files`
--
ALTER TABLE `project_files`
  ADD CONSTRAINT `project_files_ibfk_1` FOREIGN KEY (`projectId`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `project_images`
--
ALTER TABLE `project_images`
  ADD CONSTRAINT `project_images_ibfk_1` FOREIGN KEY (`projectId`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
