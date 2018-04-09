-- MySQL dump 10.13  Distrib 5.6.24, for osx10.8 (x86_64)
--
-- Host: us-cdbr-azure-east-a.cloudapp.net    Database: acsm_b1db89b5cc641ae
-- ------------------------------------------------------
-- Server version	5.5.56-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `achievement`
--

DROP TABLE IF EXISTS `achievement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `achievement` (
  `ACHIEVEMENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ACHIEVEMENT_MARK` int(11) DEFAULT NULL,
  `PUPIL_ID` int(11) DEFAULT NULL,
  `TYPE_ID` int(11) DEFAULT NULL,
  `LESSON_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ACHIEVEMENT_ID`),
  KEY `PUPIL_ID_5_idx` (`PUPIL_ID`),
  KEY `TYPE_ID_idx` (`TYPE_ID`),
  KEY `LESSON_ID_3_idx` (`LESSON_ID`),
  CONSTRAINT `LESSON_ID_1` FOREIGN KEY (`LESSON_ID`) REFERENCES `lesson` (`LESSON_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `PUPIL_ID_1` FOREIGN KEY (`PUPIL_ID`) REFERENCES `pupil` (`PUPIL_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `TYPE_ID` FOREIGN KEY (`TYPE_ID`) REFERENCES `type` (`TYPE_ID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2005 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance` (
  `ATTENDANCE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `LESSON_ID` int(11) DEFAULT NULL,
  `PUPIL_ID` int(11) DEFAULT NULL,
  `ATTENDANCE_PASS` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`ATTENDANCE_ID`),
  KEY `LESSON_ID_idx` (`LESSON_ID`),
  KEY `PUPIL_ID_1_idx` (`PUPIL_ID`),
  CONSTRAINT `LESSON_ID_2` FOREIGN KEY (`LESSON_ID`) REFERENCES `lesson` (`LESSON_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `PUPIL_ID_2` FOREIGN KEY (`PUPIL_ID`) REFERENCES `pupil` (`PUPIL_ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=265 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class` (
  `CLASS_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CLASS_NUMBER` int(11) DEFAULT NULL,
  `CLASS_LETTER` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `YEAR_ID` int(11) DEFAULT NULL,
  `CLASS_STATUS` int(11) DEFAULT NULL,
  `TEACHER_ID` int(11) DEFAULT NULL,
  `CLASS_PREVIOUS` int(11) DEFAULT NULL,
  PRIMARY KEY (`CLASS_ID`),
  KEY `YEAR_ID_idx` (`YEAR_ID`),
  KEY `TEACHER_ID_4_idx` (`TEACHER_ID`),
  KEY `CLASS_ID_5_idx` (`CLASS_PREVIOUS`),
  CONSTRAINT `CLASS_ID_5` FOREIGN KEY (`CLASS_PREVIOUS`) REFERENCES `class` (`CLASS_ID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `TEACHER_ID_1` FOREIGN KEY (`TEACHER_ID`) REFERENCES `teacher` (`TEACHER_ID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `YEAR_ID_1` FOREIGN KEY (`YEAR_ID`) REFERENCES `year` (`YEAR_ID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dayofweek`
--

DROP TABLE IF EXISTS `dayofweek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dayofweek` (
  `DAYOFWEEK_ID` int(11) NOT NULL AUTO_INCREMENT,
  `DAYOFWEEK_NAME` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`DAYOFWEEK_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file` (
  `FILE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FILE_NAME` varchar(500) DEFAULT NULL,
  `FILE_SIZE` varchar(45) DEFAULT NULL,
  `FILE_EXTENSION` varchar(10) DEFAULT NULL,
  `LESSON_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`FILE_ID`),
  KEY `LESSON_ID_3_idx` (`LESSON_ID`),
  KEY `LESSON_ID_4_idx` (`LESSON_ID`),
  CONSTRAINT `LESSON_ID_3` FOREIGN KEY (`LESSON_ID`) REFERENCES `lesson` (`LESSON_ID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gcm_users`
--

DROP TABLE IF EXISTS `gcm_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gcm_users` (
  `GCM_USERS_ID` int(11) NOT NULL AUTO_INCREMENT,
  `GCM_USERS_REGID` varchar(200) DEFAULT NULL,
  `PUPIL_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`GCM_USERS_ID`),
  KEY `PUPIL_ID_12_idx` (`PUPIL_ID`),
  CONSTRAINT `PUPIL_ID_12` FOREIGN KEY (`PUPIL_ID`) REFERENCES `pupil` (`PUPIL_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=465 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lesson`
--

DROP TABLE IF EXISTS `lesson`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lesson` (
  `LESSON_ID` int(11) NOT NULL AUTO_INCREMENT,
  `LESSON_DATE` date DEFAULT NULL,
  `LESSON_THEME` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `SUBJECTS_CLASS_ID` int(11) DEFAULT NULL,
  `LESSON_HOMEWORK` varchar(10000) CHARACTER SET utf8 DEFAULT NULL,
  `TIME_ID` int(11) DEFAULT NULL,
  `LESSON_STATUS` int(11) DEFAULT NULL,
  PRIMARY KEY (`LESSON_ID`),
  KEY `SUBJECTS_CLASS_ID_1_idx` (`SUBJECTS_CLASS_ID`),
  KEY `TIME_ID_2_idx` (`TIME_ID`),
  CONSTRAINT `SUBJECTS_CLASS_ID_1` FOREIGN KEY (`SUBJECTS_CLASS_ID`) REFERENCES `subjects_class` (`SUBJECTS_CLASS_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `TIME_ID_2` FOREIGN KEY (`TIME_ID`) REFERENCES `time` (`TIME_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=925 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `MESSAGE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MESSAGE_DATE` datetime DEFAULT NULL,
  `MESSAGE_TEXT` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`MESSAGE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3225 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `NEWS_ID` int(11) NOT NULL AUTO_INCREMENT,
  `NEWS_TIME` date NOT NULL,
  `TEACHER_ID` int(11) NOT NULL,
  `NEWS_TEXT` longtext CHARACTER SET utf8mb4 NOT NULL,
  `NEWS_THEME` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`NEWS_ID`),
  KEY `TEACHER_ID_6_idx` (`TEACHER_ID`),
  CONSTRAINT `TEACHER_ID_2` FOREIGN KEY (`TEACHER_ID`) REFERENCES `teacher` (`TEACHER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `note`
--

DROP TABLE IF EXISTS `note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note` (
  `NOTE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOTE_TEXT` varchar(200) DEFAULT NULL,
  `PUPIL_ID` int(11) DEFAULT NULL,
  `LESSON_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`NOTE_ID`),
  KEY `LESSON_ID_4_idx` (`LESSON_ID`),
  KEY `PUPIL_ID_8_idx` (`PUPIL_ID`),
  CONSTRAINT `LESSON_ID_4` FOREIGN KEY (`LESSON_ID`) REFERENCES `lesson` (`LESSON_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `PUPIL_ID_8` FOREIGN KEY (`PUPIL_ID`) REFERENCES `pupil` (`PUPIL_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `period`
--

DROP TABLE IF EXISTS `period`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `period` (
  `PERIOD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PERIOD_NAME` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `PERIOD_START` date DEFAULT NULL,
  `PERIOD_FINISH` date DEFAULT NULL,
  `YEAR_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`PERIOD_ID`),
  KEY `YEAR_ID_1_idx` (`YEAR_ID`),
  CONSTRAINT `YEAR_ID_2` FOREIGN KEY (`YEAR_ID`) REFERENCES `year` (`YEAR_ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `progress`
--

DROP TABLE IF EXISTS `progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `progress` (
  `PROGRESS_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PERIOD_ID` int(11) DEFAULT NULL,
  `SUBJECTS_CLASS_ID` int(11) DEFAULT NULL,
  `PROGRESS_MARK` int(11) DEFAULT NULL,
  `PUPIL_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`PROGRESS_ID`),
  KEY `SUBJECTS_CLASS_ID_idx` (`SUBJECTS_CLASS_ID`),
  KEY `PUPIL_ID_2_idx` (`PUPIL_ID`),
  KEY `PERIOD_ID_idx` (`PERIOD_ID`),
  CONSTRAINT `PERIOD_ID` FOREIGN KEY (`PERIOD_ID`) REFERENCES `period` (`PERIOD_ID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `PUPIL_ID_3` FOREIGN KEY (`PUPIL_ID`) REFERENCES `pupil` (`PUPIL_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `SUBJECTS_CLASS_ID_2` FOREIGN KEY (`SUBJECTS_CLASS_ID`) REFERENCES `subjects_class` (`SUBJECTS_CLASS_ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1375 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pupil`
--

DROP TABLE IF EXISTS `pupil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pupil` (
  `PUPIL_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PUPIL_NAME` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `PUPIL_LOGIN` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `PUPIL_PASSWORD` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `PUPIL_HASH` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `PUPIL_ADDRESS` varchar(400) CHARACTER SET utf8 DEFAULT NULL,
  `PUPIL_BIRTHDAY` date DEFAULT NULL,
  `PUPIL_STATUS` int(11) DEFAULT NULL,
  `ROLE_ID` int(11) DEFAULT NULL,
  `PUPIL_PHONE` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`PUPIL_ID`),
  KEY `ROLE_ID_2_idx` (`ROLE_ID`),
  CONSTRAINT `ROLE_ID_1` FOREIGN KEY (`ROLE_ID`) REFERENCES `role` (`ROLE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pupils_class`
--

DROP TABLE IF EXISTS `pupils_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pupils_class` (
  `PUPILS_CLASS_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CLASS_ID` int(11) DEFAULT NULL,
  `PUPIL_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`PUPILS_CLASS_ID`),
  KEY `CLASS_ID_5_idx` (`CLASS_ID`),
  KEY `PUPIL_ID_4_idx` (`PUPIL_ID`),
  CONSTRAINT `CLASS_ID_1` FOREIGN KEY (`CLASS_ID`) REFERENCES `class` (`CLASS_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `PUPIL_ID_4` FOREIGN KEY (`PUPIL_ID`) REFERENCES `pupil` (`PUPIL_ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pupils_message`
--

DROP TABLE IF EXISTS `pupils_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pupils_message` (
  `PUPILS_MESSAGE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PUPIL_ID` int(11) DEFAULT NULL,
  `MESSAGE_ID` int(11) DEFAULT NULL,
  `MESSAGE_READ` int(11) DEFAULT NULL,
  `MESSAGE_FOLDER` int(11) DEFAULT NULL,
  `TEACHER_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`PUPILS_MESSAGE_ID`),
  KEY `MESSAGE_ID_1_idx` (`MESSAGE_ID`),
  KEY `PUPIL_ID_6_idx` (`PUPIL_ID`),
  KEY `TEACHER_ID_5_idx` (`TEACHER_ID`),
  CONSTRAINT `MESSAGE_ID_1` FOREIGN KEY (`MESSAGE_ID`) REFERENCES `message` (`MESSAGE_ID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `PUPIL_ID_6` FOREIGN KEY (`PUPIL_ID`) REFERENCES `pupil` (`PUPIL_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `TEACHER_ID_5` FOREIGN KEY (`TEACHER_ID`) REFERENCES `teacher` (`TEACHER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3215 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `ROLE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ROLE_NAME` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`ROLE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room` (
  `ROOM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ROOM_NAME` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `ROOMcol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ROOM_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subject` (
  `SUBJECT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SUBJECT_NAME` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`SUBJECT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `subjects_class`
--

DROP TABLE IF EXISTS `subjects_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects_class` (
  `SUBJECTS_CLASS_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SUBJECT_ID` int(11) DEFAULT NULL,
  `CLASS_ID` int(11) DEFAULT NULL,
  `TEACHER_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`SUBJECTS_CLASS_ID`),
  KEY `SUBJECT_ID_idx` (`SUBJECT_ID`),
  KEY `CLASS_ID_idx` (`CLASS_ID`),
  KEY `TEACHER_ID_3_idx` (`TEACHER_ID`),
  CONSTRAINT `CLASS_ID_2` FOREIGN KEY (`CLASS_ID`) REFERENCES `class` (`CLASS_ID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `SUBJECT_ID_1` FOREIGN KEY (`SUBJECT_ID`) REFERENCES `subject` (`SUBJECT_ID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `TEACHER_ID_3` FOREIGN KEY (`TEACHER_ID`) REFERENCES `teacher` (`TEACHER_ID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=355 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teacher` (
  `TEACHER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TEACHER_LOGIN` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `TEACHER_PASSWORD` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `TEACHER_HASH` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `ROLE_ID` int(11) DEFAULT NULL,
  `TEACHER_NAME` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `TEACHER_STATUS` int(11) DEFAULT NULL,
  PRIMARY KEY (`TEACHER_ID`),
  KEY `ROLE_ID_1_idx` (`ROLE_ID`),
  CONSTRAINT `ROLE_ID_2` FOREIGN KEY (`ROLE_ID`) REFERENCES `role` (`ROLE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `teachers_message`
--

DROP TABLE IF EXISTS `teachers_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachers_message` (
  `TEACHERS_MESSAGE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TEACHER_ID` int(11) DEFAULT NULL,
  `MESSAGE_ID` int(11) DEFAULT NULL,
  `MESSAGE_READ` int(11) DEFAULT NULL,
  `MESSAGE_FOLDER` int(11) DEFAULT NULL,
  `PUPIL_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`TEACHERS_MESSAGE_ID`),
  KEY `TEACHER_ID_4_idx` (`TEACHER_ID`),
  KEY `MESSAGE_ID_idx` (`MESSAGE_ID`),
  KEY `PUPIL_ID_7_idx` (`PUPIL_ID`),
  CONSTRAINT `MESSAGE_ID_2` FOREIGN KEY (`MESSAGE_ID`) REFERENCES `message` (`MESSAGE_ID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `PUPIL_ID_7` FOREIGN KEY (`PUPIL_ID`) REFERENCES `pupil` (`PUPIL_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `TEACHER_ID_4` FOREIGN KEY (`TEACHER_ID`) REFERENCES `teacher` (`TEACHER_ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3225 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `time`
--

DROP TABLE IF EXISTS `time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time` (
  `TIME_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME_START` time DEFAULT NULL,
  `TIME_FINISH` time DEFAULT NULL,
  PRIMARY KEY (`TIME_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `timetable`
--

DROP TABLE IF EXISTS `timetable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timetable` (
  `TIMETABLE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME_ID` int(11) DEFAULT NULL,
  `ROOM_ID` int(11) DEFAULT NULL,
  `DAYOFWEEK_ID` int(11) DEFAULT NULL,
  `SUBJECTS_CLASS_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`TIMETABLE_ID`),
  KEY `TIME_ID_idx` (`TIME_ID`),
  KEY `ROOM_ID_idx` (`ROOM_ID`),
  KEY `DAYOFWEEK_ID_idx` (`DAYOFWEEK_ID`),
  KEY `SUBJECTS_CLASS_ID_2_idx` (`SUBJECTS_CLASS_ID`),
  CONSTRAINT `DAYOFWEEK_ID_1` FOREIGN KEY (`DAYOFWEEK_ID`) REFERENCES `dayofweek` (`DAYOFWEEK_ID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `ROOM_ID_1` FOREIGN KEY (`ROOM_ID`) REFERENCES `room` (`ROOM_ID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `SUBJECTS_CLASS_ID_3` FOREIGN KEY (`SUBJECTS_CLASS_ID`) REFERENCES `subjects_class` (`SUBJECTS_CLASS_ID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `TIME_ID_1` FOREIGN KEY (`TIME_ID`) REFERENCES `time` (`TIME_ID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=765 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type` (
  `TYPE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TYPE_NAME` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`TYPE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `year`
--

DROP TABLE IF EXISTS `year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `year` (
  `YEAR_ID` int(11) NOT NULL AUTO_INCREMENT,
  `YEAR_START` date NOT NULL,
  `YEAR_FINISH` date NOT NULL,
  PRIMARY KEY (`YEAR_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-09 21:46:12
