/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
CREATE DATABASE  IF NOT EXISTS `ttm-lsna` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ttm-lsna`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: localhost    Database: ttm-lsna
-- ------------------------------------------------------
-- Server version	5.5.25a

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
-- Dumping routines for database 'ttm-lsna'
--
/*!50003 DROP PROCEDURE IF EXISTS `get_aggregate_pm_survey_results` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmlsnarw`@`localhost` PROCEDURE `get_aggregate_pm_survey_results`(
    _season INT (1)
)
BEGIN

SELECT AVG(Student_Involvement_A), AVG(Student_Involvement_B), 
AVG(Student_Involvement_C), AVG(Student_Involvement_D), 
AVG(Student_Involvement_E), AVG(Student_Involvement_F), 
AVG(Student_Involvement_G), AVG(Student_Involvement_H), 
AVG(School_Network_I), AVG(School_Network_J), 
AVG(School_Network_K), AVG(School_Network_L), 
AVG(School_Involvement_M), AVG(School_Involvement_N), 
AVG(School_Involvement_O), AVG(School_Involvement_P), 
AVG(School_Involvement_Q), AVG(School_Involvement_R),
AVG(Self_Efficacy_Q), AVG(Self_Efficacy_R),
AVG(Self_Efficacy_S), AVG(Self_Efficacy_T),
AVG(Self_Efficacy_U), AVG(Self_Efficacy_V),
AVG(Self_Efficacy_W), AVG(Self_Efficacy_X)
FROM Parent_Mentor_Survey
WHERE Pre_Post=_season;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_count_pm_surveys` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmlsnarw`@`localhost` PROCEDURE `get_count_pm_surveys`(
    _survey_Time INT,
    _col VARCHAR(45)
)
BEGIN

SET @full_qry= CONCAT('SELECT ', _col, 
        ', COUNT(*) as count FROM Parent_Mentor_Survey WHERE Pre_Post=', _survey_Time,
        ' GROUP BY ', _col);
 PREPARE _result_finder FROM @full_qry;
-- SELECT @full_qry;
 EXECUTE _result_finder;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_count_satisfaction_surveys` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmlsnarw`@`localhost` PROCEDURE `get_count_satisfaction_surveys`(
    _col VARCHAR(45),
    _start DATE,
    _end DATE
)
BEGIN
IF (_start IS NULL OR _start = '0000-00-00') THEN
    SET @full_qry= CONCAT('SELECT ', _col, 
        ', COUNT(*) as count FROM Satisfaction_Surveys GROUP BY ', _col);
ELSE
    SET @full_qry= CONCAT('SELECT ', _col, 
        ', COUNT(*) as count FROM Satisfaction_Surveys WHERE Date>="',
        _start, '" AND Date<="', _end, '" GROUP BY ', _col);
END IF;
 PREPARE _result_finder FROM @full_qry;
-- SELECT @full_qry;
 EXECUTE _result_finder;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_count_satisfaction_surveys_by_program` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmlsnarw`@`localhost` PROCEDURE `get_count_satisfaction_surveys_by_program`(
    _col VARCHAR(45),
    _prog INT,
    _start DATE,
    _end DATE
)
BEGIN
IF (_start IS NULL OR _start = '0000-00-00') THEN
    SET @full_qry= CONCAT('SELECT ', _col, 
        ', COUNT(*) as count FROM Satisfaction_Surveys WHERE Program_ID= ', _prog,
        ' GROUP BY ', _col);
ELSE
    SET @full_qry= CONCAT('SELECT ', _col, 
        ', COUNT(*) as count FROM Satisfaction_Surveys WHERE Program_ID= ', _prog,
        ' AND Date>="', _start, '" AND Date<="', _end, '" 
        GROUP BY ', _col);
END IF;

 PREPARE _result_finder FROM @full_qry;
-- SELECT @full_qry;
 EXECUTE _result_finder;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_count_teacher_post_surveys` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmlsnarw`@`localhost` PROCEDURE `get_count_teacher_post_surveys`(
    _col VARCHAR(45)
)
BEGIN

SET @full_qry= CONCAT('SELECT ', _col, 
        ', COUNT(*) as count FROM PM_Teacher_Survey_Post GROUP BY ', _col);
 PREPARE _result_finder FROM @full_qry;
-- SELECT @full_qry;
 EXECUTE _result_finder;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_count_teacher_pre_post_surveys` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmlsnarw`@`localhost` PROCEDURE `get_count_teacher_pre_post_surveys`(
    _col VARCHAR(45)
)
BEGIN

SET @full_qry= CONCAT('SELECT PM_Teacher_Survey_Post.', _col, 
        ', COUNT(*) as count FROM PM_Teacher_Survey_Post 
			JOIN PM_Teacher_Survey ON
				PM_Teacher_Survey.Teacher_Name = PM_Teacher_Survey_Post.Teacher_Name AND
				PM_Teacher_Survey.Parent_Mentor_ID = PM_Teacher_Survey_Post.Parent_Mentor_ID AND
				PM_Teacher_Survey.School_Name = PM_Teacher_Survey_Post.School_Name
		GROUP BY ', _col);
 PREPARE _result_finder FROM @full_qry;
-- SELECT @full_qry;
 EXECUTE _result_finder;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_count_teacher_surveys` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmlsnarw`@`localhost` PROCEDURE `get_count_teacher_surveys`(
    _col VARCHAR(45)
)
BEGIN

SET @full_qry= CONCAT('SELECT ', _col, 
        ', COUNT(*) as count FROM PM_Teacher_Survey GROUP BY ', _col);
 PREPARE _result_finder FROM @full_qry;
-- SELECT @full_qry;
 EXECUTE _result_finder;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_count_teacher_surveys_pre_post` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmlsnarw`@`localhost` PROCEDURE `get_count_teacher_surveys_pre_post`(
    _col VARCHAR(45)
)
BEGIN

SET @full_qry= CONCAT('SELECT PM_Teacher_Survey.', _col, 
        ', COUNT(*) as count FROM PM_Teacher_Survey
			JOIN PM_Teacher_Survey_Post ON
				PM_Teacher_Survey.Teacher_Name = PM_Teacher_Survey_Post.Teacher_Name AND
				PM_Teacher_Survey.Parent_Mentor_ID = PM_Teacher_Survey_Post.Parent_Mentor_ID AND
				PM_Teacher_Survey.School_Name = PM_Teacher_Survey_Post.School_Name
			GROUP BY ', _col);
 PREPARE _result_finder FROM @full_qry;
-- SELECT @full_qry;
 EXECUTE _result_finder;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_sum_teacher_post_surveys` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmlsnarw`@`localhost` PROCEDURE `get_sum_teacher_post_surveys`(
    _col VARCHAR(45)
)
BEGIN

SET @full_qry= CONCAT('SELECT SUM(', _col, 
        ')  FROM PM_Teacher_Survey_Post');
  PREPARE _result_finder FROM @full_qry;
 -- SELECT @full_qry;
  EXECUTE _result_finder;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_sum_teacher_surveys` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmlsnarw`@`localhost` PROCEDURE `get_sum_teacher_surveys`(
    _col VARCHAR(45)
)
BEGIN

SET @full_qry= CONCAT('SELECT SUM(', _col, 
        ')  FROM PM_Teacher_Survey');
  PREPARE _result_finder FROM @full_qry;
 -- SELECT @full_qry;
  EXECUTE _result_finder;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_sum_teacher_surveys_pre_post` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmlsnarw`@`localhost` PROCEDURE `get_sum_teacher_surveys_pre_post`(
    _col VARCHAR(45)
)
BEGIN

SET @full_qry= CONCAT('SELECT SUM(PM_Teacher_Survey.', _col, 
        ')  FROM PM_Teacher_Survey
			JOIN PM_Teacher_Survey_Post ON
				PM_Teacher_Survey.Teacher_Name = PM_Teacher_Survey_Post.Teacher_Name AND
				PM_Teacher_Survey.Parent_Mentor_ID = PM_Teacher_Survey_Post.Parent_Mentor_ID AND
				PM_Teacher_Survey.School_Name = PM_Teacher_Survey_Post.School_Name');
  PREPARE _result_finder FROM @full_qry;
 -- SELECT @full_qry;
  EXECUTE _result_finder;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Import__Activity_Status_Report` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmlsnarw`@`localhost` PROCEDURE `Import__Activity_Status_Report`(
IN
    _Program_Name VARCHAR(100),
    _Program_Category varchar(45),
  _Funding_Source varchar(45)  ,
  _Total_Enrollment int(11)  ,
  _Total_Dropped int(11)  ,
  _Current_Enrollment int(11)  ,
  _Total_Service_Days int(11)  ,
  _Total_Service_Hours int(11)  ,
  _Total_Present int(11)  ,
  _Total_Activity int(11)  ,
  _Average_Daily_Attendance int(11)  ,
  _Average_Weekly_Attendance int(11)  ,
  _Num_Weeks int(11)  ,
  _Attendance_Rate varchar(45)  ,
  _Percent_Sessions_With_Attendees varchar(45)  ,
  _Percent_Attendance_Recorded varchar(45),
  _Month varchar(100),
  _School varchar(100)
)
BEGIN
/*IF (NOT EXISTS(SELECT Database_ID
            FROM
                `Databases`
            WHERE
                Database_Name = _Database_Name))
THEN*/
    -- insert newly imported DB
    INSERT INTO `Import_Destination`
        (Program_ID,
        Program_Category,
  Funding_Source,
  Total_Enrollment,
  Total_Dropped,
  Current_Enrollment,
  Total_Service_Days,
  Total_Service_Hours,
  Total_Present,
  Total_Activity,
  Average_Daily_Attendance,
  Average_Weekly_Attendance,
  Num_Weeks,
  Attendance_Rate,
  Percent_Sessions_With_Attendees,
  Percent_Attendance_Recorded,
  Report_Period,
  School_Reported)
    VALUES
        (_Program_Name,
        _Program_Category,
  _Funding_Source,
  _Total_Enrollment,
  _Total_Dropped ,
  _Current_Enrollment,
  _Total_Service_Days,
  _Total_Service_Hours,
  _Total_Present,
  _Total_Activity,
  _Average_Daily_Attendance,
  _Average_Weekly_Attendance ,
  _Num_Weeks,
  _Attendance_Rate,
  _Percent_Sessions_With_Attendees,
  _Percent_Attendance_Recorded,
  _Month,
  _School);

SET @_full_qry = CONCAT(" INSERT INTO `Import_Destination`
        (Program_Category,
  Funding_Source,
  Total_Enrollment,
  Total_Dropped,
  Current_Enrollment,
  Total_Service_Days,
  Total_Service_Hours,
  Total_Present,
  Total_Activity,
  Average_Daily_Attendance,
  Average_Weekly_Attendance,
  Num_Weeks,
  Attendance_Rate,
  Percent_Sessions_With_Attendees,
  Percent_Attendance_Recorded,
  Report_Period,
  School_Reported)
    VALUES
        (", _Program_Category, ", ",
  _Funding_Source, ", ",
  _Total_Enrollment, ", ",
  _Total_Dropped , ", ",
  _Current_Enrollment, ", ",
  _Total_Service_Days, ", ",
  _Total_Service_Hours, ", ",
  _Total_Present, ", ",
  _Total_Activity, ", ",
  _Average_Daily_Attendance, ", ",
  _Average_Weekly_Attendance , ", ",
  _Num_Weeks, ", ",
  _Attendance_Rate, ", ",
  _Percent_Sessions_With_Attendees, ", ",
  _Percent_Attendance_Recorded, ", ",
  _Month, ", ",
  _School, ");");
-- PREPARE _result_finder FROM @_full_qry;
 SELECT @_full_qry;
-- EXECUTE _result_finder;

    -- get newly imported Database Record (if it exists)
    SELECT *
    FROM
        `Import_Destination`
    WHERE
        Import_Destination_ID = LAST_INSERT_ID();
/*END IF;*/
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Participant__Load_With_ID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmlsnarw`@`localhost` PROCEDURE `Participant__Load_With_ID`(
    _participant_id INT
)
BEGIN

SELECT * FROM Participants
        WHERE Participants.Participant_ID = _participant_id;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-28 15:56:06
