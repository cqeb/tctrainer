-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 06. Januar 2011 um 14:55
-- Server Version: 5.1.41
-- PHP-Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `trainer`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `competitions`
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
-- Daten für Tabelle `competitions`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `i18n`
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
-- Daten für Tabelle `i18n`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `logs`
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
-- Daten für Tabelle `logs`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mesocyclephases`
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
-- Daten für Tabelle `mesocyclephases`
--

INSERT INTO `mesocyclephases` (`date`, `phase`, `time`, `usertime`, `ratio`, `recovery`, `athlete_id`) VALUES
('2011-01-03', 'BASE1', 300, 0, '', 0, 2),
('2011-01-10', 'BASE1', 360, 0, '', 0, 2),
('2011-01-17', 'BASE1', 230, 0, '', 1, 2),
('2011-01-24', 'BASE1', 420, 0, '', 0, 2),
('2011-01-31', 'BASE2', 320, 0, '', 0, 2),
('2011-02-07', 'BASE2', 210, 0, '', 1, 2),
('2011-02-14', 'BASE2', 380, 0, '', 0, 2),
('2011-02-21', 'BASE2', 420, 0, '', 0, 2),
('2011-02-28', 'BASE3', 230, 0, '', 1, 2),
('2011-03-07', 'BASE3', 410, 0, '', 0, 2),
('2011-03-14', 'BASE3', 450, 0, '', 0, 2),
('2011-03-21', 'BASE3', 230, 0, '', 1, 2),
('2011-03-28', 'RACE', 230, 0, '', 0, 2),
('2011-01-03', 'BASE1', 360, 0, '', 0, 1),
('2011-01-10', 'BASE1', 430, 0, '', 0, 1),
('2011-01-17', 'BASE1', 270, 0, '', 1, 1),
('2011-01-24', 'BASE1', 500, 0, '', 0, 1),
('2011-01-31', 'BASE2', 380, 0, '', 0, 1),
('2011-02-07', 'BASE2', 250, 0, '', 1, 1),
('2011-02-14', 'BASE2', 450, 0, '', 0, 1),
('2011-02-21', 'BASE2', 500, 0, '', 0, 1),
('2011-02-28', 'BASE3', 270, 0, '', 1, 1),
('2011-03-07', 'BASE3', 490, 0, '', 0, 1),
('2011-03-14', 'BASE3', 540, 0, '', 0, 1),
('2011-03-21', 'BASE3', 270, 0, '', 1, 1),
('2011-03-28', 'RACE', 270, 0, '', 0, 1),
('2011-01-03', 'BASE1', 480, 0, '', 0, 3),
('2011-01-10', 'BASE1', 580, 0, '', 0, 3),
('2011-01-17', 'BASE1', 360, 0, '', 1, 3),
('2011-01-24', 'BASE2', 500, 0, '', 0, 3),
('2011-01-31', 'BASE2', 600, 0, '', 0, 3),
('2011-02-07', 'BASE2', 340, 0, '', 1, 3),
('2011-02-14', 'BASE3', 550, 0, '', 0, 3),
('2011-02-21', 'BASE3', 650, 0, '', 0, 3),
('2011-02-28', 'BUILD1', 340, 0, '', 1, 3),
('2011-03-07', 'BUILD1', 620, 0, '', 0, 3),
('2011-03-14', 'BUILD1', 620, 0, '', 0, 3),
('2011-03-21', 'PEAK', 410, 0, '', 1, 3),
('2011-03-28', 'RACE', 360, 0, '', 0, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `payments`
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
  `paid_from` date DEFAULT NULL,
  `paid_to` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `payments`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `scheduledtrainings`
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
-- Daten für Tabelle `scheduledtrainings`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `starts`
--

CREATE TABLE IF NOT EXISTS `starts` (
  `id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `starts`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `trainingplans`
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
-- Daten für Tabelle `trainingplans`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `trainingstatistics`
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=65 ;

--
-- Daten für Tabelle `trainingstatistics`
--

INSERT INTO `trainingstatistics` (`id`, `user_id`, `name`, `date`, `sportstype`, `distance`, `duration`, `avg_pulse`, `avg_pulse_zone1`, `avg_pulse_zone2`, `avg_pulse_zone3`, `avg_pulse_zone4`, `avg_pulse_zone5`, `avg_speed`, `trimp`, `kcal`, `location`, `weight`, `weightfat`, `comment`, `testworkout`, `competition`, `workout_link`, `conditions_temperature`, `conditions_weather`, `conditions_inclination`, `conditions_mood`, `created`, `modified`) VALUES
(1, 3, '', '2010-09-14', 'RUN', '11.00000', 4593, 136, NULL, NULL, NULL, NULL, NULL, '8.62', 84, 996, 'Wiener Neudorf, Austria', '84.00000', NULL, '06:36', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(2, 3, '', '2010-09-15', 'RUN', '7.40000', 2580, 159, NULL, NULL, NULL, NULL, NULL, '10.33', 193, 709, 'Wiener Neudorf, Austria', '84.00000', NULL, '09:25', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(3, 3, 'Gentics Office Run', '2010-09-17', 'RUN', '20.00000', 7020, 152, NULL, NULL, NULL, NULL, NULL, '10.26', 257, 1338, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '0.00000', NULL, '07:53', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(4, 3, '', '2010-09-18', 'BIKE', '35.00000', 4620, 141, NULL, NULL, NULL, NULL, NULL, '27.27', 92, 753, '', '0.00000', NULL, '18:47', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(5, 3, '', '2010-09-21', 'RUN', '9.70000', 3420, 138, NULL, NULL, NULL, NULL, NULL, '10.21', 68, 532, '', '0.00000', NULL, '06:40', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(6, 3, 'Gentics Office Run', '2010-09-24', 'RUN', '20.00000', 6720, 152, NULL, NULL, NULL, NULL, NULL, '10.71', 246, 1281, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '0.00000', NULL, '07:17', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(7, 3, '', '2010-09-25', 'RUN', '11.00000', 3960, 140, NULL, NULL, NULL, NULL, NULL, '10.00', 79, 635, '', '0.00000', NULL, '17:09', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(8, 3, '', '2010-09-29', 'RUN', '9.70000', 3020, 159, NULL, NULL, NULL, NULL, NULL, '11.56', 226, 830, 'Wiener Neudorf, Ã–sterreich', '84.00000', NULL, '06:40', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(9, 3, 'Gentics Office Run', '2010-10-01', 'RUN', '20.00000', 6682, 151, NULL, NULL, NULL, NULL, NULL, '10.78', 245, 1257, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '0.00000', NULL, '06:47', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(10, 3, '', '2010-10-04', 'RUN', '11.80000', 3832, 152, NULL, NULL, NULL, NULL, NULL, '11.09', 140, 730, '', '0.00000', NULL, '06:38', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(11, 3, '', '2010-10-05', 'RUN', '10.30000', 3530, 146, NULL, NULL, NULL, NULL, NULL, '10.50', 129, 854, 'Wiener Neudorf, Ã–sterreich', '84.00000', NULL, '06:41', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(12, 3, 'Gentics Office Run', '2010-10-08', 'RUN', '20.00000', 6848, 151, NULL, NULL, NULL, NULL, NULL, '10.51', 251, 1288, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '0.00000', NULL, '07:16', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(13, 3, '', '2010-10-09', 'RUN', '9.70000', 3210, 150, NULL, NULL, NULL, NULL, NULL, '10.88', 117, 596, '', '0.00000', NULL, '14:35', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(14, 3, 'Husarentempel', '2010-10-10', 'RUN', '17.60000', 6060, 158, NULL, NULL, NULL, NULL, NULL, '10.46', 454, 1650, 'Husarentempel, MÃ¶dling, Ã–sterreich', '84.00000', NULL, '09:49', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(15, 3, '', '2010-10-12', 'RUN', '9.50000', 3120, 146, NULL, NULL, NULL, NULL, NULL, '10.96', 114, 548, '', '0.00000', NULL, '06:41', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(16, 3, '', '2010-10-18', 'RUN', '9.30000', 3488, 143, NULL, NULL, NULL, NULL, NULL, '9.60', 69, 818, '', '84.00000', NULL, '06:45', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(17, 3, '', '2010-10-19', 'RUN', '10.90000', 4080, 147, NULL, NULL, NULL, NULL, NULL, '9.62', 149, 726, '', '0.00000', NULL, '06:41', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(18, 3, '', '2010-10-21', 'RUN', '5.60000', 2100, 150, NULL, NULL, NULL, NULL, NULL, '9.60', 77, 526, '', '82.00000', NULL, '07:02', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(19, 3, '', '2010-10-22', 'BIKE', '30.00000', 7483, 152, NULL, NULL, NULL, NULL, NULL, '14.43', 274, 1426, '', '0.00000', NULL, '06:42', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(20, 3, '', '2010-10-23', 'RUN', '9.00000', 3101, 145, NULL, NULL, NULL, NULL, NULL, '10.45', 62, 537, '', '0.00000', NULL, '18:08', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(21, 3, '', '2010-10-25', 'RUN', '10.30000', 3900, 144, NULL, NULL, NULL, NULL, NULL, '9.51', 78, 665, '', '0.00000', NULL, '06:43', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(22, 3, '', '2010-10-27', 'RUN', '8.30000', 3128, 147, NULL, NULL, NULL, NULL, NULL, '9.55', 114, 760, '', '82.00000', NULL, '06:47', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(23, 3, '', '2010-10-25', 'SWIM', '2.00000', 2700, 130, NULL, NULL, NULL, NULL, NULL, '2.67', 45, 365, '', '0.00000', NULL, '19:00', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(24, 3, 'Gentics Office Run', '2010-10-29', 'RUN', '20.00000', 7413, 155, NULL, NULL, NULL, NULL, NULL, '9.71', 555, 1469, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '0.00000', NULL, '07:23', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(25, 3, 'Baden - Richtung Neufeldersee / Tadej', '2010-10-31', 'BIKE', '30.00000', 7171, 116, NULL, NULL, NULL, NULL, NULL, '15.06', 119, 718, '', '0.00000', NULL, '09:30', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(26, 3, '', '2010-11-01', 'SWIM', '2.00000', 2700, 130, NULL, NULL, NULL, NULL, NULL, '2.67', 45, 365, '', '0.00000', NULL, '19:00', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(27, 3, 'Aarhus City', '2010-11-03', 'RUN', '4.20000', 1453, 158, NULL, NULL, NULL, NULL, NULL, '10.41', 108, 299, 'Aarhus, Denmark', '0.00000', NULL, '06:38', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(28, 3, 'Kopenhagen City', '2010-11-05', 'RUN', '4.40000', 2030, 139, NULL, NULL, NULL, NULL, NULL, '7.80', 40, 321, 'Copenhagen, Denmark', '0.00000', NULL, '09:44', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(29, 3, 'Biedermannsdorf Runde', '2010-11-06', 'RUN', '9.00000', 3001, 147, NULL, NULL, NULL, NULL, NULL, '10.80', 110, 729, 'Biedermannsdorf, Austria', '82.00000', NULL, '07:14', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(30, 3, 'MTB Thallern Runde', '2010-11-06', 'BIKE', '30.00000', 8263, 123, NULL, NULL, NULL, NULL, NULL, '13.07', 137, 973, '', '0.00000', NULL, '14:31', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(31, 3, '', '2010-11-08', 'SWIM', '2.00000', 2700, 130, NULL, NULL, NULL, NULL, NULL, '2.67', 45, 365, '', '0.00000', NULL, '19:00', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(32, 3, 'MÃ¶dling Lauf', '2010-11-07', 'RUN', '9.70000', 3373, 138, NULL, NULL, NULL, NULL, NULL, '10.35', 67, 524, 'MÃ¶dling, Austria', '0.00000', NULL, '09:11', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(33, 3, 'MÃ¶dling', '2010-11-09', 'RUN', '11.00000', 4460, 150, NULL, NULL, NULL, NULL, NULL, '8.88', 163, 828, 'MÃ¶dling, Austria', '0.00000', NULL, '06:44', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(34, 3, 'MÃ¶dling', '2010-11-12', 'RUN', '20.00000', 6927, 155, NULL, NULL, NULL, NULL, NULL, '10.39', 519, 1373, 'MÃ¶dling, Austria', '0.00000', NULL, '06:47', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(35, 3, 'Berglauf', '2010-11-14', 'RUN', '14.60000', 5537, 146, NULL, NULL, NULL, NULL, NULL, '9.49', 203, 1336, 'Husarentempel, MÃ¶dling, Austria', '83.00000', NULL, '11:08', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(36, 3, '', '2010-11-15', 'SWIM', '2.00000', 2700, 130, NULL, NULL, NULL, NULL, NULL, '2.67', 45, 365, '', '0.00000', NULL, '19:00', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(37, 3, 'MÃ¶dling', '2010-11-15', 'RUN', '9.30000', 3637, 140, NULL, NULL, NULL, NULL, NULL, '9.21', 72, 584, 'MÃ¶dling, Austria', '0.00000', NULL, '07:21', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(38, 3, 'MÃ¶dling', '2010-11-16', 'RUN', '8.40000', 3358, 138, NULL, NULL, NULL, NULL, NULL, '9.01', 67, 522, 'MÃ¶dling, Austria', '0.00000', NULL, '07:41', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(39, 3, 'MÃ¶dling', '2010-11-18', 'RUN', '9.30000', 3606, 136, NULL, NULL, NULL, NULL, NULL, '9.28', 66, 542, 'MÃ¶dling, Austria', '0.00000', NULL, '06:48', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(40, 3, 'Husarentempel', '2010-11-21', 'RUN', '16.40000', 6452, 139, NULL, NULL, NULL, NULL, NULL, '9.15', 129, 1019, 'Husarentempel, MÃ¶dling, Austria', '0.00000', NULL, '14:53', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(41, 3, '', '2010-11-22', 'SWIM', '2.00000', 2700, 130, NULL, NULL, NULL, NULL, NULL, '2.67', 45, 365, '', '0.00000', NULL, '19:00', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(42, 3, 'MÃ¶dling', '2010-11-23', 'RUN', '9.00000', 3306, 141, NULL, NULL, NULL, NULL, NULL, '9.80', 66, 539, 'MÃ¶dling, Austria', '0.00000', NULL, '08:05', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(43, 3, '?', '2010-11-24', 'RUN', '9.50000', 3645, 134, NULL, NULL, NULL, NULL, NULL, '9.38', 66, 769, 'MÃ¶dling, Austria', '83.00000', NULL, '06:40', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(44, 3, 'Gentics Office Run', '2010-11-26', 'RUN', '20.00000', 7215, 151, NULL, NULL, NULL, NULL, NULL, '9.98', 264, 1357, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '0.00000', NULL, '06:56', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(45, 3, 'MÃ¶dling - Laxemburg - rechts rein', '2010-11-28', 'RUN', '14.00000', 5400, 150, NULL, NULL, NULL, NULL, NULL, '9.33', 198, 1002, 'Laxenburg, Austria', '0.00000', NULL, '08:00', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(46, 3, '', '2010-11-29', 'SWIM', '2.00000', 2700, 130, NULL, NULL, NULL, NULL, NULL, '2.67', 45, 365, '', '0.00000', NULL, '19:00', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(47, 3, 'Gentics - Prater', '2010-11-30', 'RUN', '9.40000', 4020, 138, NULL, NULL, NULL, NULL, NULL, '8.42', 80, 625, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '0.00000', NULL, '06:45', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(48, 3, 'MÃ¶dling Lauf', '2010-12-02', 'RUN', '9.70000', 3780, 147, NULL, NULL, NULL, NULL, NULL, '9.24', 138, 920, '', '82.50000', NULL, '06:42', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(49, 3, 'MÃ¶dling Lauf', '2010-12-03', 'RUN', '9.70000', 3780, 142, NULL, NULL, NULL, NULL, NULL, '9.24', 75, 871, 'MÃ¶dling Austria', '82.00000', NULL, '06:42', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(50, 3, 'MÃ¶dling Lauf', '2010-12-06', 'RUN', '9.70000', 3864, 142, NULL, NULL, NULL, NULL, NULL, '9.04', 77, 890, 'MÃ¶dling Austria', '82.00000', NULL, '06:40', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(51, 3, 'Gentics Runners Point', '2010-12-07', 'RUN', '11.00000', 4147, 137, NULL, NULL, NULL, NULL, NULL, '9.55', 76, 634, 'Gonzagagasse 11, 1010 Wien, Austria', '0.00000', NULL, '07:53', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(52, 3, 'MÃ¶dling Lauf', '2010-12-09', 'RUN', '9.70000', 3600, 154, NULL, NULL, NULL, NULL, NULL, '9.70', 132, 941, 'MÃ¶dling Austria', '83.00000', NULL, '06:50', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(53, 3, 'Laxenburg-MÃ¶dling', '2010-12-10', 'RUN', '13.30000', 5394, 146, NULL, NULL, NULL, NULL, NULL, '8.88', 197, 947, 'Laxemburg, Austria', '0.00000', NULL, '06:44', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(54, 3, '', '2010-12-12', 'RUN', '14.10000', 5431, 141, NULL, NULL, NULL, NULL, NULL, '9.35', 108, 885, '', '0.00000', NULL, '17:03', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(55, 3, 'Gentics Runners Point', '2010-12-14', 'RUN', '10.00000', 3600, 150, NULL, NULL, NULL, NULL, NULL, '10.00', 132, 668, 'Gonzagagasse 11, 1010 Wien, Austria', '0.00000', NULL, '08:01', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(56, 3, '', '2010-12-18', 'RUN', '11.20000', 4540, 150, NULL, NULL, NULL, NULL, NULL, '8.88', 166, 1137, '', '82.00000', NULL, '16:46', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(57, 3, 'MÃ¶dling Lauf', '2010-12-20', 'RUN', '9.20000', 3377, 146, NULL, NULL, NULL, NULL, NULL, '9.81', 123, 593, '', '0.00000', NULL, '06:44', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(58, 3, 'Gentics Runners Point', '2010-12-21', 'RUN', '10.70000', 4020, 142, NULL, NULL, NULL, NULL, NULL, '9.58', 80, 926, '', '82.00000', NULL, '07:47', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(59, 3, 'MÃ¶dling Lauf', '2010-12-22', 'RUN', '9.70000', 3660, 145, NULL, NULL, NULL, NULL, NULL, '9.54', 73, 633, '', '0.00000', NULL, '06:40', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(60, 3, 'Gentics Office Run', '2010-12-23', 'RUN', '20.00000', 6628, 157, NULL, NULL, NULL, NULL, NULL, '10.86', 497, 1774, 'Gentics, Gonzagagasse 11, 1010 Vienna, Austria', '81.50000', NULL, '06:58', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(61, 3, 'St. Veit - Wr. Neudorf', '2010-12-25', 'RUN', '28.00000', 9480, 139, NULL, NULL, NULL, NULL, NULL, '10.63', 189, 2113, 'St. Veit', '82.00000', NULL, '16:15', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(62, 3, 'MÃ¶dling', '2010-12-26', 'RUN', '9.70000', 3600, 146, NULL, NULL, NULL, NULL, NULL, '9.70', 132, 632, '', '0.00000', NULL, '15:00', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(63, 3, 'Laxenburg-MÃ¶dling', '2010-12-28', 'RUN', '10.50000', 3960, 152, NULL, NULL, NULL, NULL, NULL, '9.55', 145, 1012, '', '82.00000', NULL, '06:38', 0, 0, '\r\n', '', '', '', '', '2011-01-06 12:44:48', '2011-01-06 12:44:48'),
(64, 3, 'Gentics Office Run', '2010-12-30', 'RUN', '20.00000', 7320, 146, NULL, NULL, NULL, NULL, NULL, '9.84', 268, 1760, '', '82.00000', NULL, '06:46', 0, 0, 'http://www.gentics.com', 'warm', 'sunny', 'flat', 'feeling_well', '2011-01-06 12:44:48', '2011-01-06 14:31:43');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `transactions`
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
-- Daten für Tabelle `transactions`
--

INSERT INTO `transactions` (`id`, `transaction`, `transaction_key`, `transaction_value`, `created`, `modified`) VALUES
(1, 'b74937f29e43cba84531cf1ed9b8bc30', 'activation_userid', '3', '2011-01-06 11:58:29', '2011-01-06 11:58:29'),
(2, 'b74937f29e43cba84531cf1ed9b8bc30', 'activation_email', 'tri@schremser.com', '2011-01-06 11:58:29', '2011-01-06 11:58:29');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tribikeworkouttypesequence`
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
-- Daten für Tabelle `tribikeworkouttypesequence`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `trirunworkouttypesequence`
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
-- Daten für Tabelle `trirunworkouttypesequence`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `gender`, `phonemobile`, `address`, `zip`, `city`, `country`, `email`, `emailcheck`, `birthday`, `password`, `passwordcheck`, `maximumheartrate`, `lactatethreshold`, `bikelactatethreshold`, `youknowus`, `newsletter`, `notifications`, `mytrainingsphilosophy`, `myrecommendation`, `typeofsport`, `tos`, `weight`, `targetweight`, `targetweightcheck`, `targetweightdate`, `height`, `coldestmonth`, `unit`, `unitdate`, `publicprofile`, `publictrainings`, `rookie`, `traininglevel`, `weeklyhours`, `dayofheaviesttraining`, `activated`, `deactivated`, `yourlanguage`, `myimage`, `mybike`, `level`, `paid_from`, `paid_to`, `canceled`, `cancellation_reason`, `advanced_features`, `created`, `modified`) VALUES
(3, 'Klaus-M.', 'Schremser', 'm', NULL, '', '', '', '', 'tri@schremser.com', 1, '1975-11-26', 'e7efda40b1c94805070cd9bf9638ae27', 1, 184, 156, 149, NULL, 1, 0, NULL, '', 'TRIATHLON HALFIRONMAN', 1, '82.00000', NULL, 0, NULL, NULL, '1', 'metric', 'ddmmyyyy', 0, 0, 0, 0, 8, 'FRI', 1, 0, 'eng', '', '', 'freemember', '2011-01-06', '2011-02-05', 0, '', 0, '2011-01-06 11:58:29', '2011-01-06 14:31:43');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
