-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 04, 2021 at 03:19 AM
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
-- Truncate table before insert `album`
--

TRUNCATE TABLE `album`;
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
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `logId` int(11) NOT NULL AUTO_INCREMENT,
  `extra_userId` int(11) DEFAULT NULL,
  `fileId` int(11) NOT NULL DEFAULT '0',
  `userName` varchar(255) DEFAULT NULL,
  `timeStamp` varchar(255) NOT NULL,
  `priorityName` varchar(20) NOT NULL,
  `priority` int(1) NOT NULL,
  `message` longtext NOT NULL,
  `extra_referenceId` tinytext,
  `extra_errno` tinytext,
  `extra_file` text,
  `extra_line` text,
  `extra_trace` text,
  PRIMARY KEY (`logId`),
  KEY `userId` (`extra_userId`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `log`
--

TRUNCATE TABLE `log`;
--
-- Dumping data for table `log`
--

INSERT INTO `log` (`logId`, `extra_userId`, `fileId`, `userName`, `timeStamp`, `priorityName`, `priority`, `message`, `extra_referenceId`, `extra_errno`, `extra_file`, `extra_line`, `extra_trace`) VALUES
(58, NULL, 0, NULL, '12-2-2021 5:47:27', 'INFO', 6, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}', NULL, NULL, NULL, NULL, '0'),
(59, NULL, 0, NULL, '12-2-2021 6:01:21', 'INFO', 6, 'this is a test registration email', NULL, NULL, NULL, NULL, '0'),
(60, NULL, 0, NULL, '313412America/ChicagoDecember2021Thu, 02 Dec 2021 13:34:06 -060012pm31', 'INFO', 6, 'this is a test registration email', NULL, NULL, NULL, NULL, '0'),
(61, NULL, 0, NULL, '12-2-2021 1:35:43', 'INFO', 6, 'this is a test registration email', NULL, NULL, NULL, NULL, '0'),
(62, NULL, 0, NULL, '12-2-2021 1:47:01', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', NULL, NULL, NULL, NULL, '0'),
(63, NULL, 0, NULL, '12-2-2021 4:41:49', 'NOTICE', 5, 'Trying to get property \'role\' of non-object', NULL, '8', 'C:\\aurora\\Aurora-Laminas\\module\\Application\\view\\layout\\layout.phtml', '53', '0'),
(64, NULL, 0, NULL, '12-2-2021 5:42:45', 'NOTICE', 5, 'Trying to access array offset on value of type null', NULL, '8', 'C:\\aurora\\Aurora-Laminas\\module\\User\\view\\user\\register\\index.phtml', '8', NULL),
(65, NULL, 0, NULL, '12-2-2021 5:55:11', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(66, NULL, 0, NULL, '12-2-2021 5:58:18', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(67, NULL, 0, NULL, '12-2-2021 6:08:35', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(68, NULL, 0, NULL, '12-2-2021 6:08:35', 'NOTICE', 5, 'Trying to get property \'disableRegistration\' of non-object', '1', '8', 'C:\\aurora\\Aurora-Laminas\\module\\User\\view\\user\\register\\index.phtml', '8', NULL),
(69, NULL, 0, NULL, '12-2-2021 6:50:50', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(70, NULL, 0, NULL, '12-2-2021 6:50:50', 'NOTICE', 5, 'Trying to get property \'disableRegistration\' of non-object', '1', '8', 'C:\\aurora\\Aurora-Laminas\\module\\User\\view\\user\\register\\index.phtml', '8', NULL),
(71, NULL, 0, NULL, '12-2-2021 6:53:37', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(72, NULL, 0, NULL, '12-2-2021 6:56:11', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(73, NULL, 0, NULL, '12-2-2021 6:57:05', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(74, NULL, 0, NULL, '12-2-2021 7:00:36', 'NOTICE', 5, 'Trying to get property \'role\' of non-object', NULL, '8', 'C:\\aurora\\Aurora-Laminas\\module\\Application\\view\\layout\\layout.phtml', '53', NULL),
(75, NULL, 0, NULL, '12-2-2021 7:01:09', 'NOTICE', 5, 'Trying to get property \'role\' of non-object', NULL, '8', 'C:\\aurora\\Aurora-Laminas\\module\\Application\\view\\layout\\layout.phtml', '53', NULL),
(76, NULL, 0, NULL, '12-2-2021 7:01:19', 'NOTICE', 5, 'Trying to get property \'role\' of non-object', NULL, '8', 'C:\\aurora\\Aurora-Laminas\\module\\Application\\view\\layout\\layout.phtml', '53', NULL),
(77, NULL, 0, NULL, '12-2-2021 7:03:03', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(78, NULL, 0, NULL, '12-2-2021 7:04:28', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(79, NULL, 0, NULL, '12-2-2021 7:07:33', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(80, NULL, 0, NULL, '12-2-2021 7:17:59', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(81, NULL, 0, NULL, '12-2-2021 7:31:05', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(82, NULL, 0, NULL, '12-2-2021 7:31:05', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(83, NULL, 0, NULL, '12-2-2021 7:33:17', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(84, NULL, 0, NULL, '12-2-2021 7:36:28', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(85, NULL, 0, NULL, '12-2-2021 7:36:58', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(86, NULL, 0, NULL, '12-2-2021 7:38:41', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(87, NULL, 0, NULL, '12-2-2021 7:40:24', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(88, NULL, 0, NULL, '12-2-2021 7:41:12', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(89, NULL, 0, NULL, '12-2-2021 7:41:12', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(90, NULL, 0, NULL, '12-2-2021 7:46:07', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(91, NULL, 0, NULL, '12-2-2021 8:04:19', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(92, NULL, 0, NULL, '12-2-2021 8:05:48', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(93, NULL, 0, NULL, '12-2-2021 8:07:24', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(94, NULL, 0, NULL, '12-2-2021 8:07:24', 'NOTICE', 5, 'Undefined property: User\\Model\\UserTable::$log', '1', '8', 'C:\\aurora\\Aurora-Laminas\\module\\User\\src\\Model\\UserTable.php', '84', NULL),
(95, NULL, 0, NULL, '12-2-2021 8:09:43', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(96, NULL, 0, NULL, '12-2-2021 8:09:43', 'NOTICE', 5, 'Undefined property: User\\Model\\UserTable::$log', '1', '8', 'C:\\aurora\\Aurora-Laminas\\module\\User\\src\\Model\\UserTable.php', '84', NULL),
(97, NULL, 0, NULL, '12-2-2021 8:10:03', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(98, NULL, 0, NULL, '12-2-2021 8:11:28', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(99, NULL, 0, NULL, '12-2-2021 8:13:18', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(100, NULL, 0, NULL, '12-2-2021 8:13:40', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(101, NULL, 0, NULL, '12-2-2021 8:21:00', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(102, NULL, 0, NULL, '12-2-2021 8:35:23', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(103, NULL, 0, NULL, '12-2-2021 8:36:20', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(104, NULL, 0, NULL, '12-2-2021 8:36:21', 'DEBUG', 7, 'testUser\\Model\\UserTable', '1', NULL, NULL, NULL, NULL),
(105, NULL, 0, NULL, '12-2-2021 8:42:19', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(106, NULL, 0, NULL, '12-2-2021 8:43:09', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(107, NULL, 0, NULL, '12-2-2021 8:43:09', 'DEBUG', 7, 'test', '1', NULL, NULL, NULL, NULL),
(108, NULL, 0, NULL, '12-2-2021 8:43:45', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(109, NULL, 0, NULL, '12-2-2021 8:44:58', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(110, NULL, 0, NULL, '12-2-2021 8:44:58', 'DEBUG', 7, '', '1', NULL, NULL, NULL, NULL),
(111, NULL, 0, NULL, '12-2-2021 8:46:16', 'INFO', 6, 'array (\n  \'userId\' => \'1\',\n  \'message\' => \'this is a test registration email\',\n  \'sendTo\' => \'someuser@domain.com\',\n)', '1', NULL, NULL, NULL, NULL),
(112, NULL, 0, NULL, '12-2-2021 8:46:16', 'DEBUG', 7, 'debug message', '1', NULL, NULL, NULL, NULL),
(113, NULL, 0, NULL, '12-2-2021 9:12:37', 'NOTICE', 5, 'Undefined variable: log', NULL, '8', 'C:\\aurora\\Aurora-Laminas\\module\\User\\src\\Controller\\RegisterController.php', '50', NULL),
(114, NULL, 0, NULL, '12-2-2021 9:14:06', 'INFO', 6, 'This is a test', NULL, NULL, NULL, NULL, NULL),
(115, NULL, 0, NULL, '12-2-2021 9:14:32', 'DEBUG', 7, 'This is a test', NULL, NULL, NULL, NULL, NULL),
(116, NULL, 0, NULL, '12-2-2021 9:16:33', 'DEBUG', 7, 'This is a test', NULL, NULL, NULL, NULL, NULL),
(117, NULL, 0, NULL, '12-2-2021 9:22:35', 'DEBUG', 7, 'array (\n  0 => \'test\',\n  1 => \'another test\',\n)', NULL, NULL, NULL, NULL, NULL),
(118, NULL, 0, NULL, '12-2-2021 9:24:11', 'INFO', 6, 'array (\n  0 => \'test\',\n  1 => \'another test\',\n)', NULL, NULL, NULL, NULL, NULL),
(119, NULL, 0, NULL, '12-2-2021 10:36:06', 'DEBUG', 7, 'array (\n  0 => \'test\',\n  1 => \'another test\',\n)', NULL, NULL, NULL, NULL, NULL),
(120, NULL, 0, NULL, '12-2-2021 10:37:06', 'DEBUG', 7, '[\"test\",\"another test\"]', NULL, NULL, NULL, NULL, NULL),
(121, NULL, 0, NULL, '12-2-2021 10:37:57', 'DEBUG', 7, 'test message', NULL, NULL, NULL, NULL, NULL),
(122, NULL, 0, NULL, '12-2-2021 10:39:13', 'NOTICE', 5, 'Undefined property: User\\Controller\\RegisterController::$id', NULL, '8', 'C:\\aurora\\Aurora-Laminas\\module\\User\\src\\Controller\\RegisterController.php', '45', NULL),
(123, 1, 0, NULL, '12-2-2021 10:39:54', 'INFO', 6, 'test message', NULL, NULL, NULL, NULL, NULL),
(124, 1, 0, NULL, '12-2-2021 10:51:12', 'INFO', 6, 'test message', NULL, NULL, NULL, NULL, NULL),
(125, NULL, 0, NULL, '12-3-2021 12:43:11', 'NOTICE', 5, 'Trying to get property \'role\' of non-object', NULL, '8', 'C:\\aurora\\Aurora-Laminas\\module\\Application\\view\\layout\\layout.phtml', '53', NULL),
(126, NULL, 0, NULL, '12-3-2021 12:43:11', 'NOTICE', 5, 'Trying to get property \'role\' of non-object', NULL, '8', 'C:\\aurora\\Aurora-Laminas\\module\\Application\\view\\layout\\layout.phtml', '53', NULL),
(127, NULL, 0, NULL, '12-3-2021 12:54:15', 'NOTICE', 5, 'Undefined variable: form', NULL, '8', 'C:\\aurora\\Aurora-Laminas\\module\\User\\view\\user\\user\\login.phtml', '7', NULL),
(128, 1, 0, NULL, '12-3-2021 12:57:06', 'INFO', 6, 'test message', NULL, NULL, NULL, NULL, NULL);

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
-- Truncate table before insert `project`
--

TRUNCATE TABLE `project`;
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

--
-- Truncate table before insert `project_files`
--

TRUNCATE TABLE `project_files`;
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

--
-- Truncate table before insert `project_images`
--

TRUNCATE TABLE `project_images`;
-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `variable` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `settingType` tinytext NOT NULL,
  `label` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `variable` (`variable`,`value`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `settings`
--

TRUNCATE TABLE `settings`;
--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `variable`, `value`, `settingType`, `label`) VALUES
(1, 'allowedTags', '<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<hr>', 'text', 'Allowed Tags'),
(2, 'enableCaptchaSupport', '1', 'Checkbox', 'Enable Captcha Support'),
(3, 'recaptchaPrivateKey', '6Lewcs0SAAAAAGfBkJsG1mxf-yGFUjq9JgglSwRL', 'text', 'Recaptcha Private Key'),
(4, 'recaptchaPrivateKey', '6Lewcs0SAAAAAGfBkJsG1mxf-yGFUjq9JgglSwRL', 'text', 'Recaptcha Public Key'),
(5, 'seoKeyWords', 'Aurora CMS, Webinertia.net, Php, MySQL', 'text', 'SEO Key Words'),
(6, 'appName', 'Aurora CMS', 'Text', 'Application Name'),
(7, 'smtpSenderAddress', 'devel@webinertia.net', 'Text', 'SMTP Sender Email'),
(8, 'smtpSenderPasswd', '**bffbGfbd88**', 'Text', 'SMTP Sender Password'),
(9, 'appContactEmail', 'jsmith@dirextion.com', 'Text', 'Website Contact Email'),
(10, 'enableMobileSupport', '1', 'CheckBox', 'Enable Mobile App support'),
(11, 'seoDescription', 'Aurora Content Management System', 'text', 'SEO Description'),
(12, 'facebookAppId', '431812843521907', 'Text', 'Facebook App ID'),
(13, 'faceBookSecretKey', 'd86702c59bd48f3a76bc57d923cd237e', 'Text', 'Facebook App Secret Key'),
(14, 'enableFacebookPageLink', '1', 'CheckBox', 'Enable Facebook Page Link'),
(15, 'enableFacebookOg', '0', 'Checkbox', 'Enable Facebook Open Graph Support'),
(16, 'sessionLength', '86400', 'Text', 'Session Length (default is 1 day)'),
(17, 'enableOnlineList', '1', 'Checkbox', 'Enable Online List'),
(18, 'enableLogging', '1', 'Checkbox', 'Enable Logging'),
(19, 'enableHomeTab', '1', 'Checkbox', 'Enable Home Menu Tab'),
(20, 'enableLinkedLogo', '1', 'Checkbox', 'Enable Linked Logo'),
(21, 'disableLogin', '0', 'checkbox', 'Disable User Login'),
(22, 'disableRegistration', '0', 'checkbox', 'Disable Registration'),
(23, 'timeFormat', 'm-j-Y g:i:s', 'text', 'Time Format (Month:Day:Year:Hr:Min:sec)'),
(24, 'timeZone', 'America/Chicago', 'text', 'Time Zone'),
(25, 'copyRightText', 'Aurora Content Management Test', 'text', 'Site Copyright Text'),
(26, 'copyRightLink', 'http://webinertia.net/aurora', 'text', 'Copyright Link (If any)'),
(27, 'footerText', 'Developed by Webinertia Data Systems', 'text', 'Footer Text (Next to copyright)');

-- --------------------------------------------------------

--
-- Table structure for table `test_log`
--

DROP TABLE IF EXISTS `test_log`;
CREATE TABLE IF NOT EXISTS `test_log` (
  `logId` int(11) NOT NULL AUTO_INCREMENT,
  `log` json NOT NULL,
  PRIMARY KEY (`logId`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `test_log`
--

TRUNCATE TABLE `test_log`;
--
-- Dumping data for table `test_log`
--

INSERT INTO `test_log` (`logId`, `log`) VALUES
(1, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(2, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(3, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(4, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(5, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(6, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(7, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(8, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(9, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(10, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(11, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(12, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(13, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(14, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(15, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(16, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(17, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(18, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(19, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(20, '{\"sendTo\": \"someuser@domain.com\", \"userId\": null, \"message\": \"this is a test registration email\"}'),
(21, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(22, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(23, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(24, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(25, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}'),
(26, '{\"sendTo\": \"someuser@domain.com\", \"userId\": \"1\", \"message\": \"this is a test registration email\"}');

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
  `companyName` varchar(255) DEFAULT NULL,
  `regDate` tinytext,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `regHash` varchar(255) DEFAULT NULL,
  `resetHash` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='will join user_profile table on id';

--
-- Truncate table before insert `user`
--

TRUNCATE TABLE `user`;
--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `userName`, `email`, `password`, `role`, `companyName`, `regDate`, `active`, `verified`, `regHash`, `resetHash`) VALUES
(1, 'jsmith', 'jsmith@webinertia.net', '$2y$10$ncO3bgCRcWaCdeINBffN4eDBAuRnhden9eZd6hXQIttrGc1hjoFlO', 'admin', '', '2021-11-08 22:26:20', 1, 1, NULL, NULL),
(2, 'UserTwo', 'two@webinertia.net', '$2y$10$wi2CLqw83DaqREbg0y.yA.T1I/0UQL8r3yEcA6EQJ11868tUVhum2', 'user', '', '2021-11-08 22:26:20', 0, 0, NULL, NULL),
(3, 'Test Three', 'three@webinertia.net', '$2y$10$QrSQtxbPecBQbxju.8k9au.g.jZ3etqYLjcmosOk35wONpvH6iPGS', 'user', '', '2021-11-08 22:26:20', 0, 0, NULL, NULL),
(4, 'Test Four', 'four@webinertia.net', '$2y$10$dLZDo0yA85duccXQDoSgB.e4NYXPm1lFJhw48H5.xPUQW.WkPOlV6', 'user', '', '2021-11-08 22:26:20', 0, 0, NULL, NULL),
(5, 'LoginUser', 'logintest@webinertia.net', '$2y$10$g1RcC9cX7yUYEKoZKgO4CefhJ0QY8yPyqUi5eR4DkNOKa1BW8a1xe', 'user', '', '2021-11-08 22:26:20', 0, 0, NULL, NULL),
(6, 'LoginUserTwo', 'LoginUserTwo@webinertia.net', '$2y$10$ncO3bgCRcWaCdeINBffN4eDBAuRnhden9eZd6hXQIttrGc1hjoFlO', 'user', '', '2021-11-08 22:26:20', 1, 1, NULL, NULL),
(7, 'Chino', 'eduardomdzhernandez@gmail.com', '$2y$10$ied9xYircXBuCku0pSxzSezlLZdj1sXXT8faNSpvYgs5rjYR4rvF6', 'user', NULL, '2021-11-17 19:32:46', 0, 0, NULL, NULL),
(8, 'jsmithclone', 'jsmithclone@webinertia.net', '$2y$10$sShe1Bsj1GEZAgtSS3AMeekJNQkV6qpjCRQsEaoyG0m5QTCHhLcBy', 'user', NULL, NULL, 0, 0, NULL, NULL),
(9, 'jsmithclone3', 'jsmithclone3@webinertia.net', '$2y$10$u42F2.oZa9fVyOzYuerkneVorYXbnPYCtKMkTY6Kil43rZ1qn5Ey2', 'user', NULL, NULL, 0, 0, NULL, NULL),
(10, 'sworsham', 'shelleyworsham@gmail.com', '$2y$10$tB7EEngaA0l..1Mzrtgjq.g3r0pynkjvWaeku6gb8pqJ2hnjF0OyK', 'user', NULL, NULL, 0, 0, NULL, NULL),
(11, 'eventtest', 'eventtest@webinertia.net', '$2y$10$ddTHWHzKjpcb/k2tRtSrJuKomlSxJMFxKXmSIhrEMWwvBlTTlEdJa', 'user', NULL, NULL, 0, 0, NULL, NULL),
(12, 'eventtest2', 'eventtest2@webinertia.net', '$2y$10$x/evHqX7LHq8maWqYCgmPOiGQWcv4a8whFHeM55jnQkhx2I2IynMS', 'user', NULL, NULL, 0, 0, NULL, NULL),
(13, 'eventtest3', 'eventtest3@webinertia.net', '$2y$10$h6XaApMD3Uh0f678eFm.WuJ1xQkKWdx9wPzkxLGttJnWpcYkx2k7W', 'user', NULL, NULL, 0, 0, NULL, NULL),
(14, 'evettest4', 'eventtest4@webinertia.net', '$2y$10$jw.waVggd8.F7S/jcNng/.m82Cor8qXQ2.9YkdD2s0sqKTg1aEc7m', 'user', NULL, NULL, 0, 0, NULL, NULL),
(15, 'eventtest5', 'eventtest5@webinertia.net', '$2y$10$IQbEEnArH9yLRNIAcBQXCemMIArVUc9vMvJD4xKNbAjt9rEbYOLl.', 'user', NULL, NULL, 0, 0, NULL, NULL),
(16, 'eventtest7', 'eventtest7@webinertia.net', '$2y$10$.3wS75twjNB7cBjbkm6Ww.qBprlmATJzNFnMvj10TCojFrzseLHLS', 'user', NULL, NULL, 0, 0, NULL, NULL),
(17, 'eventtest8', 'eventtest8@webinertia.net', '$2y$10$LcOaTnXuBs3n7KpSxuEOF.BPVdmmBBq3mysEU0arWOmcKcNuYYR2K', 'user', NULL, NULL, 0, 0, NULL, NULL),
(18, 'eventtest9', 'eventtest9@webinertia.net', '$2y$10$552M9diu8x0xkYEyM.KdV.3xeMWvo9v2eo/36IZXLs6lB/EFwMg8O', 'user', NULL, NULL, 0, 0, NULL, NULL),
(19, 'event10', 'event10@webinertia.net', '$2y$10$IgPwVilr4k2MPKEL5B6O8eP1e3/4HEJVustm.D8MGiQZUjtn6BWLC', 'user', NULL, NULL, 0, 0, NULL, NULL),
(20, 'event11', 'event11@webinertia.com', '$2y$10$syfUqnJdxKLGRB5Vr8zFOOfz/7p1RChxXKm./Ql2dmIlcpe75tsEu', 'user', NULL, NULL, 0, 0, NULL, NULL),
(21, 'event12', 'event12@webinertia.net', '$2y$10$n.NIGdW5y6nBozmz12IwFu9.i0TMPuT/7tkNesyOMuGe72yPy6Jq2', 'user', NULL, NULL, 0, 0, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='dependent upon users table relational key is userId';

--
-- Truncate table before insert `user_profile`
--

TRUNCATE TABLE `user_profile`;
--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `userId`, `firstName`, `lastName`, `avatarPath`, `age`, `birthday`, `gender`, `race`, `bio`) VALUES
(1, 1, 'Joey', 'Smith', '/module/profile/avatars/jsmith.png', 46, '02/13/1975', 'male', 'white', 'This is a bio entry for my profile. its just some test data so that its not empty..'),
(3, 2, 'John', 'Doe', '/modules/profile/avatars/jdoe.png', 77, '02/99/1904', 'male', 'whiter', 'this is some bio info for the oldest user on the site haha');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`extra_userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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
