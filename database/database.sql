# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: vpc-elasty-projects.ce4vzohcv7gt.us-east-1.rds.amazonaws.com (MySQL 5.7.21-log)
# Database: interview
# Generation Time: 2019-07-30 01:06:19 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=''NO_AUTO_VALUE_ON_ZERO'' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table interviews
# ------------------------------------------------------------

DROP TABLE IF EXISTS `interviews`;

CREATE TABLE `interviews` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT ''0'',
  `first_name` varchar(32) DEFAULT '''',
  `last_name` varchar(32) DEFAULT '''',
  `email` varchar(96) DEFAULT '''',
  `phone` varchar(14) DEFAULT '''',
  `date` date DEFAULT NULL,
  `method` varchar(64) DEFAULT NULL,
  `qa` text,
  `notes` text,
  `hire` smallint(1) DEFAULT ''0'',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `interviews` WRITE;
/*!40000 ALTER TABLE `interviews` DISABLE KEYS */;

INSERT INTO `interviews` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone`, `date`, `method`, `qa`, `notes`, `hire`, `created`, `modified`)
VALUES
	(1,0,''Adam'',''Miller'',''adam@elasty.co'',''(602) 123-4567'',''2019-07-25'',''Phone'',''There were no questions asked by the interviewee.'',''Interviewee exhibits a strong sense of programming late at night without caffeine!'',1,''2019-07-25 10:38:41'',''2019-07-25 10:38:41'');

/*!40000 ALTER TABLE `interviews` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table interviews_answers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `interviews_answers`;

CREATE TABLE `interviews_answers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `interview_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer` text,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `interviews_answers` WRITE;
/*!40000 ALTER TABLE `interviews_answers` DISABLE KEYS */;

INSERT INTO `interviews_answers` (`id`, `interview_id`, `question_id`, `answer`, `created`, `modified`)
VALUES
	(1,1,1,''This is the answer to question one!'',''2019-07-25 10:38:41'',''2019-07-25 10:38:41''),
	(2,1,2,''This is the answer to question two!'',''2019-07-25 10:38:41'',''2019-07-25 10:38:41''),
	(3,1,3,''This is the answer to question three!'',''2019-07-25 10:38:41'',''2019-07-25 10:38:41''),
	(4,1,4,''This is the answer to question four!'',''2019-07-25 10:38:41'',''2019-07-25 10:38:41''),
	(5,1,5,''This is the answer to question five!'',''2019-07-25 10:38:41'',''2019-07-25 10:38:41'');

/*!40000 ALTER TABLE `interviews_answers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '''',
  `question` text NOT NULL,
  `active` tinyint(1) DEFAULT ''1'',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;

INSERT INTO `questions` (`id`, `name`, `question`, `active`, `created`, `modified`)
VALUES
	(1,''Experience: upset customer'',''Tell me about a time you were faced with an angry or upset customer, and what did you do to resolve it? And tell me about the steps you took to de-escalate and get to the resolution.'',1,''2019-07-25 09:21:27'',''2019-07-25 09:21:27''),
	(2,''Angry Customer with Profanity'',''Lets say you have an angry customer on the phone and they are using profanity at you, and / or making threats. What steps would you take to complete this call, and what steps would you take after the call is over? '',1,''2019-07-25 09:22:16'',''2019-07-25 09:22:16''),
	(3,''Gift Giving Pleased Customer'',''You just got a call where the customer is very pleased with the service. They want to buy you a gift and tell your boss how wonderful you\''ve been resolving their issue. What is your next course of action and response to the customer?'',1,''2019-07-25 09:22:42'',''2019-07-25 09:22:42''),
	(4,''Difficult Situation'',''You are faced with a difficult situation and you don\''t know the answer. How would you proceed with the customer? What would you say to them and what steps would you use to get the answers you need to resolve the issue?'',1,''2019-07-25 09:23:05'',''2019-07-25 09:23:05''),
	(5,''Time Off'',''You know you have a situation where you will need some time off from work. What do you feel are the appropriate steps to take to make that request, and what will your action be if that request could not be fulfilled?'',1,''2019-07-25 09:23:22'',''2019-07-25 09:25:14'');

/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(32) DEFAULT NULL,
  `last_name` varchar(32) DEFAULT NULL,
  `email` varchar(96) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `active` tinyint(1) DEFAULT ''0'',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastlogin` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `active`, `created`, `modified`, `lastlogin`)
VALUES
	(1,''Brian'',''LastName'',''peredy@yahoo.com'',''$2y$10$D3k3/fhRUg1EiVFEPTSL7OR6xk7BrXn9UIx3wFK/KVfiLEk/nkX5u'',1,''2019-07-25 09:44:10'',''2019-07-25 09:53:13'',NULL),
	(2,''Adam'',''Miller'',''adam@elasty.co'',''$2y$10$LeMJ90ZIX03GSElpvXUNW.pDOQ9/27Dc6t9cuvLdMQFXjuT0bytFK'',1,''2019-07-25 09:50:39'',''2019-07-25 09:55:18'',NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
