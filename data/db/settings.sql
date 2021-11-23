-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 22, 2021 at 04:49 PM
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
-- Database: `aurora`
--

-- --------------------------------------------------------

--
-- Table structure for table `appsettings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `variable` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `settingType` tinytext NOT NULL,
  KEY `variable` (`variable`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appsettings`
--

INSERT INTO `settings` (`variable`, `value`, `settingType`) VALUES
('allowTags', '<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<hr>', 'Textarea'),
('enableCaptcha', '1', 'Checkbox'),
('recaptchaPrivateKey', '6Lewcs0SAAAAADCeIUYYuiHBWemBpQ5FkuI_cK7H', 'Textarea'),
('recaptchaPublicKey', '6Lewcs0SAAAAAGfBkJsG1mxf-yGFUjq9JgglSwRL', 'Textarea'),
('seoKeyWords', 'Dirextion Inc, Dxcore, Php, Development, MySQL', 'Textarea'),
('siteName', 'Aurora CMS', 'Text'),
('webMasterEmail', 'noreply@dirextion.com', 'Text'),
('remoteLicenseKey', 'SingleDomain18446aad51de8a3a596b594c3fcca5d137cf8c34', 'Textarea'),
('siteEmail', 'jsmith@dirextion.com', 'Text'),
('enableMobileSupport', '1', 'CheckBox'),
('seoDescription', 'Custom CMS', 'Textarea'),
('facebookAppId', '431812843521907', 'Text'),
('facebookAppSecret', 'd86702c59bd48f3a76bc57d923cd237e', 'Text'),
('enableFbPageLink', '1', 'CheckBox'),
('enableFbOpenGraph', '0', 'Checkbox'),
('sessionLength', '86400', 'Text'),
('showOnlineList', '1', 'Checkbox'),
('enableLogging', '1', 'Checkbox'),
('enableHomeTab', '1', 'Checkbox'),
('enableLinkLogo', '1', 'Checkbox');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
