-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 07, 2011 at 04:57 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `trainer`
--

-- --------------------------------------------------------

--
-- Table structure for table `competitions`
--

CREATE TABLE IF NOT EXISTS `competitions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `competitiondate` date DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sportstype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `swim_distance` decimal(10,5) DEFAULT NULL,
  `swim_time` int(11) DEFAULT NULL,
  `duathlon_run_distance` decimal(10,5) DEFAULT NULL,
  `duathlon_run_time` int(11) DEFAULT NULL,
  `bike_distance` decimal(10,5) DEFAULT NULL,
  `bike_time` int(11) DEFAULT NULL,
  `run_distance` decimal(10,5) DEFAULT NULL,
  `run_time` int(11) DEFAULT NULL,
  `important` tinyint(1) DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `competitions`
--


-- --------------------------------------------------------

--
-- Table structure for table `i18n`
--

CREATE TABLE IF NOT EXISTS `i18n` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `i18n`
--


-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logtype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logmessage` text COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `mesocyclephases`
--

CREATE TABLE IF NOT EXISTS `mesocyclephases` (
  `date` date NOT NULL,
  `phase` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `usertime` int(11) NOT NULL,
  `ratio` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `recovery` tinyint(1) NOT NULL,
  `athlete_id` int(11) NOT NULL,
  PRIMARY KEY (`date`,`athlete_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mesocyclephases`
--


-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `invoice` int(11) NOT NULL,
  `timeinterval` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(7,2) DEFAULT NULL,
  `currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_transaction_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_confirmed` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payed_from` date DEFAULT NULL,
  `payed_to` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `payments`
--


-- --------------------------------------------------------

--
-- Table structure for table `scheduledtrainings`
--

CREATE TABLE IF NOT EXISTS `scheduledtrainings` (
  `athlete_id` int(11) NOT NULL,
  `week` date NOT NULL,
  `sport` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `trimp` int(11) NOT NULL,
  `lsd` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `scheduledtrainings`
--


-- --------------------------------------------------------

--
-- Table structure for table `trainingplans`
--

CREATE TABLE IF NOT EXISTS `trainingplans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `sportstype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `distance` decimal(8,2) DEFAULT NULL,
  `distancetime` int(11) DEFAULT NULL,
  `avg_pulse` int(11) DEFAULT NULL,
  `avg_speed` decimal(5,2) DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `conditions` text COLLATE utf8_unicode_ci,
  `testworkout` tinyint(1) DEFAULT NULL,
  `competition` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `trainingplans`
--


-- --------------------------------------------------------

--
-- Table structure for table `trainingstatistics`
--

CREATE TABLE IF NOT EXISTS `trainingstatistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `sportstype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `distance` decimal(10,5) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `avg_pulse` int(11) DEFAULT NULL,
  `avg_pulse_zone1` int(11) DEFAULT NULL,
  `avg_pulse_zone2` int(11) DEFAULT NULL,
  `avg_pulse_zone3` int(11) DEFAULT NULL,
  `avg_pulse_zone4` int(11) DEFAULT NULL,
  `avg_pulse_zone5` int(11) DEFAULT NULL,
  `avg_speed` decimal(5,2) DEFAULT NULL,
  `trimp` int(11) NOT NULL,
  `kcal` int(11) DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `weight` decimal(10,5) DEFAULT NULL,
  `weightfat` decimal(10,5) DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `testworkout` tinyint(1) DEFAULT NULL,
  `competition` tinyint(1) DEFAULT NULL,
  `workout_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `conditions_temperature` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `conditions_weather` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `conditions_inclination` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `conditions_mood` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `trainingstatistics`
--


-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `transactions`
--


-- --------------------------------------------------------

--
-- Table structure for table `tribikeworkouttypesequence`
--

CREATE TABLE IF NOT EXISTS `tribikeworkouttypesequence` (
  `athlete_id` int(11) NOT NULL,
  `week` date NOT NULL,
  `position` int(11) NOT NULL,
  `e` int(11) NOT NULL,
  `f` int(11) NOT NULL,
  `m` int(11) NOT NULL,
  `s` int(11) NOT NULL,
  PRIMARY KEY (`athlete_id`,`week`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tribikeworkouttypesequence`
--


-- --------------------------------------------------------

--
-- Table structure for table `trirunworkouttypesequence`
--

CREATE TABLE IF NOT EXISTS `trirunworkouttypesequence` (
  `athlete_id` int(11) NOT NULL,
  `week` date NOT NULL,
  `position` int(11) NOT NULL,
  `e` int(11) NOT NULL,
  `f` int(11) NOT NULL,
  `m` int(11) NOT NULL,
  `s` int(11) NOT NULL,
  PRIMARY KEY (`athlete_id`,`week`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `trirunworkouttypesequence`
--


-- --------------------------------------------------------

--
-- Table structure for table `triswimworkouttypesequence`
--

CREATE TABLE IF NOT EXISTS `triswimworkouttypesequence` (
  `athlete_id` int(11) NOT NULL,
  `week` date NOT NULL,
  `position` int(11) NOT NULL,
  `e` int(11) NOT NULL,
  `f` int(11) NOT NULL,
  `m` int(11) NOT NULL,
  `s` int(11) NOT NULL,
  PRIMARY KEY (`athlete_id`,`week`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `triswimworkouttypesequence`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phonemobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emailcheck` tinyint(1) NOT NULL,
  `birthday` date DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passwordcheck` tinyint(1) NOT NULL,
  `maximumheartrate` int(3) DEFAULT NULL,
  `lactatethreshold` int(3) DEFAULT NULL,
  `bikelactatethreshold` int(11) NOT NULL,
  `youknowus` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT NULL,
  `notifications` tinyint(4) NOT NULL,
  `mytrainingsphilosophy` text COLLATE utf8_unicode_ci,
  `myrecommendation` text COLLATE utf8_unicode_ci NOT NULL,
  `typeofsport` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tos` tinyint(1) DEFAULT NULL,
  `weight` decimal(10,5) DEFAULT NULL,
  `targetweight` decimal(10,5) DEFAULT NULL,
  `targetweightcheck` tinyint(1) NOT NULL,
  `targetweightdate` date DEFAULT NULL,
  `height` decimal(10,5) DEFAULT NULL,
  `coldestmonth` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit` enum('metric','imperial') COLLATE utf8_unicode_ci NOT NULL,
  `unitdate` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publicprofile` tinyint(1) DEFAULT NULL,
  `publictrainings` tinyint(1) DEFAULT NULL,
  `rookie` tinyint(1) DEFAULT NULL,
  `traininglevel` tinyint(4) NOT NULL DEFAULT '0',
  `weeklyhours` float NOT NULL,
  `dayofheaviesttraining` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `activated` tinyint(1) NOT NULL,
  `deactivated` tinyint(1) NOT NULL,
  `yourlanguage` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `myimage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mybike` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'freemember',
  `payed_from` date NOT NULL,
  `payed_to` date NOT NULL,
  `canceled` tinyint(1) NOT NULL,
  `cancellation_reason` text COLLATE utf8_unicode_ci NOT NULL,
  `advanced_features` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
