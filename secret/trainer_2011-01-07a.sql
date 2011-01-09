-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 07, 2011 at 07:49 PM
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `competitions`
--

INSERT INTO `competitions` (`id`, `user_id`, `competitiondate`, `name`, `sportstype`, `swim_distance`, `swim_time`, `duathlon_run_distance`, `duathlon_run_time`, `bike_distance`, `bike_time`, `run_distance`, `run_time`, `important`, `location`, `created`, `modified`) VALUES
(1, 1, '2011-05-28', 'Viennaman', 'TRIATHLON HALFIRONMAN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Wien, Ã–sterreich', '2011-01-07 18:50:13', '2011-01-07 18:50:13'),
(2, 1, '2011-05-07', 'Triathlon in Obergrafendorf', 'TRIATHLON OLYMPIC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Obergrafendorf, Ã–sterreich', '2011-01-07 18:51:30', '2011-01-07 18:51:30');

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

INSERT INTO `mesocyclephases` (`date`, `phase`, `time`, `usertime`, `ratio`, `recovery`, `athlete_id`) VALUES
('2011-03-28', 'BUILD1', 160, 0, '', 0, 1),
('2011-03-21', 'BASE3', 140, 0, '', 1, 1),
('2011-03-14', 'BASE3', 90, 0, '', 0, 1),
('2011-03-07', 'BASE3', 160, 0, '', 0, 1),
('2011-02-28', 'BASE3', 180, 0, '', 1, 1),
('2011-02-21', 'BASE2', 80, 0, '', 0, 1),
('2011-02-14', 'BASE2', 150, 0, '', 0, 1),
('2011-02-07', 'BASE2', 170, 0, '', 1, 1),
('2011-01-31', 'BASE2', 80, 0, '', 0, 1),
('2011-01-24', 'BASE1', 120, 0, '', 0, 1),
('2011-01-17', 'BASE1', 140, 0, '', 1, 1),
('2011-01-10', 'BASE1', 90, 0, '', 0, 1),
('2011-01-03', 'BASE1', 170, 0, '', 0, 1),
('2011-04-04', 'BUILD1', 160, 0, '', 0, 1),
('2011-04-11', 'BUILD1', 80, 0, '', 1, 1),
('2011-04-18', 'BUILD2', 150, 0, '', 0, 1),
('2011-04-25', 'BUILD2', 150, 0, '', 0, 1),
('2011-05-02', 'BUILD2', 80, 0, '', 1, 1),
('2011-05-09', 'PEAK', 130, 0, '', 0, 1),
('2011-05-16', 'PEAK', 130, 0, '', 0, 1),
('2011-05-23', 'RACE', 90, 0, '', 0, 1);

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

INSERT INTO `scheduledtrainings` (`athlete_id`, `week`, `sport`, `type`, `duration`, `trimp`, `lsd`) VALUES
(1, '2011-01-03', 'RUN', 'E1', 50, 50, 0),
(1, '2011-01-03', 'BIKE', 'E1', 60, 60, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=68 ;

--
-- Dumping data for table `trainingstatistics`
--

INSERT INTO `trainingstatistics` (`id`, `user_id`, `name`, `date`, `sportstype`, `distance`, `duration`, `avg_pulse`, `avg_pulse_zone1`, `avg_pulse_zone2`, `avg_pulse_zone3`, `avg_pulse_zone4`, `avg_pulse_zone5`, `avg_speed`, `trimp`, `kcal`, `location`, `weight`, `weightfat`, `comment`, `testworkout`, `competition`, `workout_link`, `conditions_temperature`, `conditions_weather`, `conditions_inclination`, `conditions_mood`, `created`, `modified`) VALUES
(1, 1, '', '2010-09-14', 'RUN', '11.00000', 4593, 136, NULL, NULL, NULL, NULL, NULL, '8.62', 84, 996, 'Wiener Neudorf, Austria', '84.00000', NULL, '06:36', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(2, 1, '', '2010-09-15', 'RUN', '7.40000', 2580, 159, NULL, NULL, NULL, NULL, NULL, '10.33', 193, 709, 'Wiener Neudorf, Austria', '84.00000', NULL, '09:25', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(3, 1, 'Gentics Office Run', '2010-09-17', 'RUN', '20.00000', 7020, 152, NULL, NULL, NULL, NULL, NULL, '10.26', 257, 1338, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '0.00000', NULL, '07:53', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(4, 1, '', '2010-09-18', 'BIKE', '35.00000', 4620, 141, NULL, NULL, NULL, NULL, NULL, '27.27', 92, 753, '', '0.00000', NULL, '18:47', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(5, 1, '', '2010-09-21', 'RUN', '9.70000', 3420, 138, NULL, NULL, NULL, NULL, NULL, '10.21', 62, 532, '', '0.00000', NULL, '06:40', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(6, 1, 'Gentics Office Run', '2010-09-24', 'RUN', '20.00000', 6720, 152, NULL, NULL, NULL, NULL, NULL, '10.71', 246, 1281, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '0.00000', NULL, '07:17', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(7, 1, '', '2010-09-25', 'RUN', '11.00000', 3960, 140, NULL, NULL, NULL, NULL, NULL, '10.00', 79, 635, '', '0.00000', NULL, '17:09', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(8, 1, '', '2010-09-29', 'RUN', '9.70000', 3020, 159, NULL, NULL, NULL, NULL, NULL, '11.56', 226, 830, 'Wiener Neudorf, Ã–sterreich', '84.00000', NULL, '06:40', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(9, 1, 'Gentics Office Run', '2010-10-01', 'RUN', '20.00000', 6682, 151, NULL, NULL, NULL, NULL, NULL, '10.78', 245, 1257, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '0.00000', NULL, '06:47', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(10, 1, '', '2010-10-04', 'RUN', '11.80000', 3832, 152, NULL, NULL, NULL, NULL, NULL, '11.09', 140, 730, '', '0.00000', NULL, '06:38', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(11, 1, '', '2010-10-05', 'RUN', '10.30000', 3530, 146, NULL, NULL, NULL, NULL, NULL, '10.50', 70, 854, 'Wiener Neudorf, Ã–sterreich', '84.00000', NULL, '06:41', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(12, 1, 'Gentics Office Run', '2010-10-08', 'RUN', '20.00000', 6848, 151, NULL, NULL, NULL, NULL, NULL, '10.51', 251, 1288, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '0.00000', NULL, '07:16', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(13, 1, '', '2010-10-09', 'RUN', '9.70000', 3210, 150, NULL, NULL, NULL, NULL, NULL, '10.88', 117, 596, '', '0.00000', NULL, '14:35', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(14, 1, 'Husarentempel', '2010-10-10', 'RUN', '17.60000', 6060, 158, NULL, NULL, NULL, NULL, NULL, '10.46', 454, 1650, 'Husarentempel, MÃ¶dling, Ã–sterreich', '84.00000', NULL, '09:49', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(15, 1, '', '2010-10-12', 'RUN', '9.50000', 3120, 146, NULL, NULL, NULL, NULL, NULL, '10.96', 62, 548, '', '0.00000', NULL, '06:41', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(16, 1, '', '2010-10-18', 'RUN', '9.30000', 3488, 143, NULL, NULL, NULL, NULL, NULL, '9.60', 69, 818, '', '84.00000', NULL, '06:45', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(17, 1, '', '2010-10-19', 'RUN', '10.90000', 4080, 147, NULL, NULL, NULL, NULL, NULL, '9.62', 149, 726, '', '0.00000', NULL, '06:41', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(18, 1, '', '2010-10-21', 'RUN', '5.60000', 2100, 150, NULL, NULL, NULL, NULL, NULL, '9.60', 77, 526, '', '82.00000', NULL, '07:02', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(19, 1, '', '2010-10-22', 'BIKE', '30.00000', 7483, 152, NULL, NULL, NULL, NULL, NULL, '14.43', 274, 1426, '', '0.00000', NULL, '06:42', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(20, 1, '', '2010-10-23', 'RUN', '9.00000', 3101, 145, NULL, NULL, NULL, NULL, NULL, '10.45', 62, 537, '', '0.00000', NULL, '18:08', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(21, 1, '', '2010-10-25', 'RUN', '10.30000', 3900, 144, NULL, NULL, NULL, NULL, NULL, '9.51', 78, 665, '', '0.00000', NULL, '06:43', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(22, 1, '', '2010-10-27', 'RUN', '8.30000', 3128, 147, NULL, NULL, NULL, NULL, NULL, '9.55', 114, 760, '', '82.00000', NULL, '06:47', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(23, 1, '', '2010-10-25', 'SWIM', '2.00000', 2700, 130, NULL, NULL, NULL, NULL, NULL, '2.67', 45, 365, '', '0.00000', NULL, '19:00', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(24, 1, 'Gentics Office Run', '2010-10-29', 'RUN', '20.00000', 7413, 155, NULL, NULL, NULL, NULL, NULL, '9.71', 271, 1469, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '0.00000', NULL, '07:23', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(25, 1, 'Baden - Richtung Neufeldersee / Tadej', '2010-10-31', 'BIKE', '30.00000', 7171, 116, NULL, NULL, NULL, NULL, NULL, '15.06', 119, 718, '', '0.00000', NULL, '09:30', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(26, 1, '', '2010-11-01', 'SWIM', '2.00000', 2700, 130, NULL, NULL, NULL, NULL, NULL, '2.67', 45, 365, '', '0.00000', NULL, '19:00', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(27, 1, 'Aarhus City', '2010-11-03', 'RUN', '4.20000', 1453, 158, NULL, NULL, NULL, NULL, NULL, '10.41', 108, 299, 'Aarhus, Denmark', '0.00000', NULL, '06:38', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(28, 1, 'Kopenhagen City', '2010-11-05', 'RUN', '4.40000', 2030, 139, NULL, NULL, NULL, NULL, NULL, '7.80', 40, 321, 'Copenhagen, Denmark', '0.00000', NULL, '09:44', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(29, 1, 'Biedermannsdorf Runde', '2010-11-06', 'RUN', '9.00000', 3001, 147, NULL, NULL, NULL, NULL, NULL, '10.80', 110, 729, 'Biedermannsdorf, Austria', '82.00000', NULL, '07:14', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(30, 1, 'MTB Thallern Runde', '2010-11-06', 'BIKE', '30.00000', 8263, 123, NULL, NULL, NULL, NULL, NULL, '13.07', 137, 973, '', '0.00000', NULL, '14:31', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(31, 1, '', '2010-11-08', 'SWIM', '2.00000', 2700, 130, NULL, NULL, NULL, NULL, NULL, '2.67', 45, 365, '', '0.00000', NULL, '19:00', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(32, 1, 'MÃ¶dling Lauf', '2010-11-07', 'RUN', '9.70000', 3373, 138, NULL, NULL, NULL, NULL, NULL, '10.35', 61, 524, 'MÃ¶dling, Austria', '0.00000', NULL, '09:11', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(33, 1, 'MÃ¶dling', '2010-11-09', 'RUN', '11.00000', 4460, 150, NULL, NULL, NULL, NULL, NULL, '8.88', 163, 828, 'MÃ¶dling, Austria', '0.00000', NULL, '06:44', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(34, 1, 'MÃ¶dling', '2010-11-12', 'RUN', '20.00000', 6927, 155, NULL, NULL, NULL, NULL, NULL, '10.39', 253, 1373, 'MÃ¶dling, Austria', '0.00000', NULL, '06:47', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(35, 1, 'Berglauf', '2010-11-14', 'RUN', '14.60000', 5537, 146, NULL, NULL, NULL, NULL, NULL, '9.49', 110, 1336, 'Husarentempel, MÃ¶dling, Austria', '83.00000', NULL, '11:08', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(36, 1, '', '2010-11-15', 'SWIM', '2.00000', 2700, 130, NULL, NULL, NULL, NULL, NULL, '2.67', 45, 365, '', '0.00000', NULL, '19:00', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(37, 1, 'MÃ¶dling', '2010-11-15', 'RUN', '9.30000', 3637, 140, NULL, NULL, NULL, NULL, NULL, '9.21', 72, 584, 'MÃ¶dling, Austria', '0.00000', NULL, '07:21', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(38, 1, 'MÃ¶dling', '2010-11-16', 'RUN', '8.40000', 3358, 138, NULL, NULL, NULL, NULL, NULL, '9.01', 61, 522, 'MÃ¶dling, Austria', '0.00000', NULL, '07:41', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(39, 1, 'MÃ¶dling', '2010-11-18', 'RUN', '9.30000', 3606, 136, NULL, NULL, NULL, NULL, NULL, '9.28', 66, 542, 'MÃ¶dling, Austria', '0.00000', NULL, '06:48', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(40, 1, 'Husarentempel', '2010-11-21', 'RUN', '16.40000', 6452, 139, NULL, NULL, NULL, NULL, NULL, '9.15', 129, 1019, 'Husarentempel, MÃ¶dling, Austria', '0.00000', NULL, '14:53', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(41, 1, '', '2010-11-22', 'SWIM', '2.00000', 2700, 130, NULL, NULL, NULL, NULL, NULL, '2.67', 45, 365, '', '0.00000', NULL, '19:00', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(42, 1, 'MÃ¶dling', '2010-11-23', 'RUN', '9.00000', 3306, 141, NULL, NULL, NULL, NULL, NULL, '9.80', 66, 539, 'MÃ¶dling, Austria', '0.00000', NULL, '08:05', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(43, 1, '?', '2010-11-24', 'RUN', '9.50000', 3645, 134, NULL, NULL, NULL, NULL, NULL, '9.38', 66, 769, 'MÃ¶dling, Austria', '83.00000', NULL, '06:40', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(44, 1, 'Gentics Office Run', '2010-11-26', 'RUN', '20.00000', 7215, 151, NULL, NULL, NULL, NULL, NULL, '9.98', 264, 1357, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '0.00000', NULL, '06:56', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(45, 1, 'MÃ¶dling - Laxemburg - rechts rein', '2010-11-28', 'RUN', '14.00000', 5400, 150, NULL, NULL, NULL, NULL, NULL, '9.33', 198, 1002, 'Laxenburg, Austria', '0.00000', NULL, '08:00', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(46, 1, '', '2010-11-29', 'SWIM', '2.00000', 2700, 130, NULL, NULL, NULL, NULL, NULL, '2.67', 45, 365, '', '0.00000', NULL, '19:00', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(47, 1, 'Gentics - Prater', '2010-11-30', 'RUN', '9.40000', 4020, 138, NULL, NULL, NULL, NULL, NULL, '8.42', 73, 625, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '0.00000', NULL, '06:45', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(48, 1, 'MÃ¶dling Lauf', '2010-12-02', 'RUN', '9.70000', 3780, 147, NULL, NULL, NULL, NULL, NULL, '9.24', 138, 920, '', '82.50000', NULL, '06:42', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(49, 1, 'MÃ¶dling Lauf', '2010-12-03', 'RUN', '9.70000', 3780, 142, NULL, NULL, NULL, NULL, NULL, '9.24', 75, 871, 'MÃ¶dling Austria', '82.00000', NULL, '06:42', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(50, 1, 'MÃ¶dling Lauf', '2010-12-06', 'RUN', '9.70000', 3864, 142, NULL, NULL, NULL, NULL, NULL, '9.04', 77, 890, 'MÃ¶dling Austria', '82.00000', NULL, '06:40', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(51, 1, 'Gentics Runners Point', '2010-12-07', 'RUN', '11.00000', 4147, 137, NULL, NULL, NULL, NULL, NULL, '9.55', 76, 634, 'Gonzagagasse 11, 1010 Wien, Austria', '0.00000', NULL, '07:53', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(52, 1, 'MÃ¶dling Lauf', '2010-12-09', 'RUN', '9.70000', 3600, 154, NULL, NULL, NULL, NULL, NULL, '9.70', 132, 941, 'MÃ¶dling Austria', '83.00000', NULL, '06:50', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(53, 1, 'Laxenburg-MÃ¶dling', '2010-12-10', 'RUN', '13.30000', 5394, 146, NULL, NULL, NULL, NULL, NULL, '8.88', 107, 947, 'Laxemburg, Austria', '0.00000', NULL, '06:44', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(54, 1, '', '2010-12-12', 'RUN', '14.10000', 5431, 141, NULL, NULL, NULL, NULL, NULL, '9.35', 108, 885, '', '0.00000', NULL, '17:03', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(55, 1, 'Gentics Runners Point', '2010-12-14', 'RUN', '10.00000', 3600, 150, NULL, NULL, NULL, NULL, NULL, '10.00', 132, 668, 'Gonzagagasse 11, 1010 Wien, Austria', '0.00000', NULL, '08:01', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(56, 1, '', '2010-12-18', 'RUN', '11.20000', 4540, 150, NULL, NULL, NULL, NULL, NULL, '8.88', 166, 1137, '', '82.00000', NULL, '16:46', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(57, 1, 'MÃ¶dling Lauf', '2010-12-20', 'RUN', '9.20000', 3377, 146, NULL, NULL, NULL, NULL, NULL, '9.81', 67, 593, '', '0.00000', NULL, '06:44', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(58, 1, 'Gentics Runners Point', '2010-12-21', 'RUN', '10.70000', 4020, 142, NULL, NULL, NULL, NULL, NULL, '9.58', 80, 926, '', '82.00000', NULL, '07:47', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(59, 1, 'MÃ¶dling Lauf', '2010-12-22', 'RUN', '9.70000', 3660, 145, NULL, NULL, NULL, NULL, NULL, '9.54', 73, 633, '', '0.00000', NULL, '06:40', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(60, 1, 'Gentics Office Run', '2010-12-23', 'RUN', '20.00000', 6628, 157, NULL, NULL, NULL, NULL, NULL, '10.86', 497, 1774, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '81.50000', NULL, '06:58', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(61, 1, 'St. Veit - Wr. Neudorf', '2010-12-25', 'RUN', '28.00000', 9480, 139, NULL, NULL, NULL, NULL, NULL, '10.63', 189, 2113, 'St. Veit', '82.00000', NULL, '16:15', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(62, 1, 'MÃ¶dling', '2010-12-26', 'RUN', '9.70000', 3600, 146, NULL, NULL, NULL, NULL, NULL, '9.70', 72, 632, '', '0.00000', NULL, '15:00', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(63, 1, 'Laxenburg-MÃ¶dling', '2010-12-28', 'RUN', '10.50000', 3960, 152, NULL, NULL, NULL, NULL, NULL, '9.55', 145, 1012, '', '82.00000', NULL, '06:38', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(64, 1, 'Gentics Office Run', '2010-12-30', 'RUN', '20.00000', 7320, 146, NULL, NULL, NULL, NULL, NULL, '9.84', 146, 1760, '', '82.00000', NULL, '06:46', 0, 0, '\r\n', '', '', '', '', '2011-01-07 19:00:23', '2011-01-07 19:00:23'),
(65, 1, 'Neujahrslauf', '2011-01-01', 'RUN', '25.00000', 10166, 142, NULL, NULL, NULL, NULL, NULL, '8.85', 203, NULL, 'Anninger, Ã–sterreich', '83.00000', NULL, 'Kalt, aber ohne Schnee', 0, 0, 'http://', 'cold', 'windy', 'mountainous', 'feeling_well', '2011-01-07 19:03:01', '2011-01-07 19:03:01'),
(66, 1, 'MÃ¶dling, Ã–sterreich', '2011-01-04', 'RUN', '10.00000', 3600, 151, NULL, NULL, NULL, NULL, NULL, '10.00', 132, 914, '', '83.00000', NULL, '', 0, 0, 'http://', 'cold', 'sunny', 'flat', 'feeling_well', '2011-01-07 19:04:15', '2011-01-07 19:04:15'),
(67, 1, 'MÃ¶dling, Ã–sterreich', '2011-01-07', 'RUN', '9.50000', 3536, 156, NULL, NULL, NULL, NULL, NULL, '9.67', 265, 942, 'MÃ¶dling, Ã–sterreich', '83.00000', NULL, '', 0, 0, 'http://', 'cold', 'sunny', 'flat', 'feeling_well', '2011-01-07 19:05:34', '2011-01-07 19:05:34');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction`, `transaction_key`, `transaction_value`, `created`, `modified`) VALUES
(1, '16b2e1ced33edd3af5906a6ca5cfa405', 'activation_userid', '1', '2011-01-07 18:42:32', '2011-01-07 18:42:32'),
(2, '16b2e1ced33edd3af5906a6ca5cfa405', 'activation_email', 'tri@schremser.com', '2011-01-07 18:42:32', '2011-01-07 18:42:32');

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

INSERT INTO `tribikeworkouttypesequence` (`athlete_id`, `week`, `position`, `e`, `f`, `m`, `s`) VALUES
(1, '2011-01-03', 1, 0, -1, -1, 0);

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

INSERT INTO `trirunworkouttypesequence` (`athlete_id`, `week`, `position`, `e`, `f`, `m`, `s`) VALUES
(1, '2011-01-03', 1, 0, -1, -1, 0);

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

INSERT INTO `triswimworkouttypesequence` (`athlete_id`, `week`, `position`, `e`, `f`, `m`, `s`) VALUES
(1, '2011-01-03', 0, 0, -1, -1, -1),
(1, '2011-01-10', 4, 1, -1, -1, 1),
(1, '2011-01-17', 6, 1, -1, -1, 0),
(1, '2011-01-24', 8, 2, 0, -1, 0);

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
  `paid_from` date NOT NULL,
  `paid_to` date NOT NULL,
  `canceled` tinyint(1) NOT NULL,
  `cancellation_reason` text COLLATE utf8_unicode_ci NOT NULL,
  `advanced_features` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `gender`, `phonemobile`, `address`, `zip`, `city`, `country`, `email`, `emailcheck`, `birthday`, `password`, `passwordcheck`, `maximumheartrate`, `lactatethreshold`, `bikelactatethreshold`, `youknowus`, `newsletter`, `notifications`, `mytrainingsphilosophy`, `myrecommendation`, `typeofsport`, `tos`, `weight`, `targetweight`, `targetweightcheck`, `targetweightdate`, `height`, `coldestmonth`, `unit`, `unitdate`, `publicprofile`, `publictrainings`, `rookie`, `traininglevel`, `weeklyhours`, `dayofheaviesttraining`, `activated`, `deactivated`, `yourlanguage`, `myimage`, `mybike`, `level`, `paid_from`, `paid_to`, `canceled`, `cancellation_reason`, `advanced_features`, `created`, `modified`) VALUES
(1, 'Klaus-M.', 'Schremser', 'm', '+4369916301524', 'Reisenbauerring 4/2/7', '2351', 'Wiener Neudorf', 'AT', 'tri@schremser.com', 1, '1975-11-26', 'd72c1d8306cf2b41408cbe7d663b747c', 1, 185, 157, 151, NULL, 1, 0, NULL, '', 'TRIATHLON HALFIRONMAN', 1, '83.00000', '78.00000', 0, '2011-03-31', '182.00000', '1', 'metric', 'ddmmyyyy', 0, 0, 0, 0, 2, 'FRI', 1, 0, 'deu', '', '', 'freemember', '2011-01-07', '2011-02-06', 0, '', 1, '2011-01-07 18:42:32', '2011-01-07 19:44:38');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
