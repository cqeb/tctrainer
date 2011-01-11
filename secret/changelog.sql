DROP TABLE IF EXISTS `athletes`;

#2010-08-21 KMS
DROP TABLE IF EXISTS `cmspages`;
DROP TABLE IF EXISTS `cmspagespagestatuses`;
DROP TABLE IF EXISTS `cmspagespagetypes`;
RENAME TABLE `trainingsplans`  TO `trainingplans`;
 
#2010-09-09 KMS
ALTER TABLE `trainingstatistics` CHANGE `distancetime` `duration` INT( 11 ) NULL DEFAULT NULL;
DROP TABLE IF EXISTS `trainingplans`;

#2010-09-10 CP
ALTER TABLE  `scheduledtrainings` ADD  `trimp` INT NOT NULL AFTER  `duration`;

#2010-09-11 KMS
ALTER TABLE `trainingstatistics` CHANGE `trimps` `trimp` INT( 11 ) NOT NULL;

#2010-09-19 KMS
CREATE TABLE IF EXISTS starts (id int);
CREATE TABLE IF EXISTS trainingplans (id int);

#2010-09-22 CP
ALTER TABLE `mesocyclephases` ADD  `usertime` INT NOT NULL AFTER  `time`;
ALTER TABLE `mesocyclephases` ADD  `ratio` VARCHAR( 20 ) NOT NULL AFTER  `usertime`;

#2010-11-13 KMS
ALTER TABLE `trainingstatistics` CHANGE `date` `date` DATE NULL DEFAULT NULL;
ALTER TABLE `trainingstatistics` ADD `workout_link` VARCHAR( 255 ) NOT NULL AFTER `competition`;

#2010-12-26 CP
CREATE TABLE IF NOT EXISTS `tribikeworkouttypesequence` (
  `athlete_id` int(11) NOT NULL,
  `week` date NOT NULL,
  `position` int(11) NOT NULL,
  `e` int(11) NOT NULL,
  `f` int(11) NOT NULL,
  `m` int(11) NOT NULL,
  `s` int(11) NOT NULL,
  PRIMARY KEY (`athlete_id`,`week`)
)

#2010-12-29 KMS
ALTER TABLE `users` CHANGE `medicallimitations` `tos` TINYINT( 1 ) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `notifications` TINYINT NOT NULL AFTER `newsletter`;

#2011-01-02 KMS
#-- for beta users
ALTER TABLE `users` ADD `advanced_features` TINYINT NOT NULL AFTER `cancelation_reason`

#2011-01-02 CP
#-- added bike lactate threshold
ALTER TABLE  `users` ADD  `bikelactatethreshold` INT NOT NULL AFTER  `lactatethreshold` 

#2011-01-03 KMS
ALTER TABLE `users` CHANGE `cancelation_reason` `cancellation_reason` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `users` CHANGE `unit` `unit` ENUM( 'metric', 'imperial' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;

#2011-01-04 CP
#-- added tri swim provider - swim workouts, finally!
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

#2011-01-06 KMS
DROP TABLE IF EXISTS `starts`;

#2011-01-07 KMS
ALTER TABLE `users` CHANGE `payed_from` `paid_from` DATE NOT NULL;
ALTER TABLE `users` CHANGE `payed_to` `paid_to` DATE NOT NULL;

# comment all non-sql strings!!
#2011-01-09 KMS
DROP TABLE IF EXISTS `trainingplans`;

#2011-01-09 KMS
ALTER TABLE  `payments` CHANGE  `payed_from`  `paid_from` DATE NULL DEFAULT NULL;
ALTER TABLE  `payments` CHANGE  `payed_to`  `paid_to` DATE NULL DEFAULT NULL;

