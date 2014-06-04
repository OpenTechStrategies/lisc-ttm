CREATE DATABASE  IF NOT EXISTS `ttm-bickerdike` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ttm-bickerdike`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: localhost    Database: ttm-bickerdike
-- ------------------------------------------------------
-- Server version	5.5.25a
/*test*/

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
-- Dumping routines for database 'ttm-bickerdike'
--
/*!50003 DROP PROCEDURE IF EXISTS `get_aggregate_survey_results` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmbickerdikerw`@`localhost` PROCEDURE `get_aggregate_survey_results`(
    _age VARCHAR(45),
    _pre_post INT (1)
)
BEGIN
DECLARE _start INT;
SET _start=0;

 SELECT AVG(Question_2), AVG(Question_3), 
        AVG(Question_4_A), AVG(Question_4_B),
        AVG(Question_5_A), AVG(Question_5_B),
        AVG(Question_6), AVG(Question_7),
        AVG(Question_8), AVG(Question_9_A),
        AVG(Question_9_B), AVG(Question_11),
        AVG(Question_12), AVG(Question_13),
        AVG(Question_14)
 FROM Participant_Survey_Responses 
    WHERE 
    Participant_Type = _age
    AND
    Pre_Post_Late = _pre_post;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_aggregate_survey_results_with_dates` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmbickerdikerw`@`localhost` PROCEDURE `get_aggregate_survey_results_with_dates`(
    _age VARCHAR(45),
    _pre_post INT (1),
    _start DATE,
    _end DATE
)
BEGIN
SELECT AVG(Question_2), AVG(Question_3), 
        AVG(Question_4_A), AVG(Question_4_B),
        AVG(Question_5_A), AVG(Question_5_B),
        AVG(Question_6), AVG(Question_7),
        AVG(Question_8), AVG(Question_9_A),
        AVG(Question_9_B), AVG(Question_11),
        AVG(Question_12), AVG(Question_13),
        AVG(Question_14)
 FROM Participant_Survey_Responses 
    WHERE 
    Participant_Type = _age
    AND
    Pre_Post_Late = _pre_post
    AND Date_Survey_Administered >= _start
    AND Date_Survey_Administered <= _end;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_full_aggregate_individual_survey_results` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmbickerdikerw`@`localhost` PROCEDURE `get_full_aggregate_individual_survey_results`(
    _pre_post_late INT (1)
)
BEGIN
-- set 'other' variables
DECLARE _other_1 INT;
DECLARE _other_2 INT;

IF (_pre_post_late = 1)
THEN
	SET _other_1 = 2;
	SET _other_2 = 3;
ELSEIF (_pre_post_late = 2)
THEN
	SET _other_1 = 1;
	SET _other_2 = 3;
ELSEIF (_pre_post_late = 3)
THEN
	SET _other_1 = 1;
	SET _other_2 = 2;
END IF;

SELECT DISTINCT Participant_Survey_ID,
		Participant_Survey_Responses.User_ID,
		Participant_Survey_Responses.Program_ID,
		AVG(Question_2), AVG(Question_3), 
        AVG(Question_4_A), AVG(Question_4_B),
        AVG(Question_5_A), AVG(Question_5_B),
        AVG(Question_6), AVG(Question_7),
        AVG(Question_8), AVG(Question_9_A),
        AVG(Question_9_B), AVG(Question_11),
        AVG(Question_12), AVG(Question_13),
        AVG(Question_14)
 FROM Participant_Survey_Responses
	JOIN (SELECT User_ID, Program_ID
	FROM
		Participant_Survey_Responses
		WHERE Pre_Post_Late = _other_1) AS Other_1 ON Other_1.User_ID = Participant_Survey_Responses.User_ID
			AND Other_1.Program_ID = Participant_Survey_Responses.Program_ID
	JOIN (SELECT User_ID, Program_ID
	FROM
		Participant_Survey_Responses
		WHERE Pre_Post_Late = _other_2) AS Other_2 ON Other_2.User_ID = Participant_Survey_Responses.User_ID
			AND Other_2.Program_ID = Participant_Survey_Responses.Program_ID
WHERE
	Participant_Survey_Responses.Pre_Post_Late = _pre_post_late;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_full_aggregate_individual_survey_results_count` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmbickerdikerw`@`localhost` PROCEDURE `get_full_aggregate_individual_survey_results_count`(
    _pre_post_late INT (1)
)
BEGIN
-- set 'other' variables
DECLARE _other_1 INT;
DECLARE _other_2 INT;

IF (_pre_post_late = 1)
THEN
	SET _other_1 = 2;
	SET _other_2 = 3;
ELSEIF (_pre_post_late = 2)
THEN
	SET _other_1 = 1;
	SET _other_2 = 3;
ELSEIF (_pre_post_late = 3)
THEN
	SET _other_1 = 1;
	SET _other_2 = 2;
END IF;

SELECT DISTINCT Participant_Survey_ID,
		Participant_Survey_Responses.User_ID,
		Participant_Survey_Responses.Program_ID
 FROM Participant_Survey_Responses
	JOIN (SELECT User_ID, Program_ID
	FROM
		Participant_Survey_Responses
		WHERE Pre_Post_Late = _other_1) AS Other_1 ON Other_1.User_ID = Participant_Survey_Responses.User_ID
			AND Other_1.Program_ID = Participant_Survey_Responses.Program_ID
	JOIN (SELECT User_ID, Program_ID
	FROM
		Participant_Survey_Responses
		WHERE Pre_Post_Late = _other_2) AS Other_2 ON Other_2.User_ID = Participant_Survey_Responses.User_ID
			AND Other_2.Program_ID = Participant_Survey_Responses.Program_ID
WHERE
	Participant_Survey_Responses.Pre_Post_Late = _pre_post_late;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_full_aggregate_individual_survey_results_pre_post` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmbickerdikerw`@`localhost` PROCEDURE `get_full_aggregate_individual_survey_results_pre_post`(
    _pre_post INT (1)
)
BEGIN
-- set 'other' variable
DECLARE _other_1 INT;

IF (_pre_post = 1)
THEN
	SET _other_1 = 2;
ELSEIF (_pre_post = 2)
THEN
	SET _other_1 = 1;
END IF;

SELECT DISTINCT Participant_Survey_ID,
		Participant_Survey_Responses.User_ID,
		Participant_Survey_Responses.Program_ID,
		AVG(Question_2), AVG(Question_3), 
        AVG(Question_4_A), AVG(Question_4_B),
        AVG(Question_5_A), AVG(Question_5_B),
        AVG(Question_6), AVG(Question_7),
        AVG(Question_8), AVG(Question_9_A),
        AVG(Question_9_B), AVG(Question_11),
        AVG(Question_12), AVG(Question_13),
        AVG(Question_14)
 FROM Participant_Survey_Responses
	JOIN (SELECT User_ID, Program_ID
	FROM
		Participant_Survey_Responses
		WHERE Pre_Post_Late = _other_1) AS Other_1 ON Other_1.User_ID = Participant_Survey_Responses.User_ID
			AND Other_1.Program_ID = Participant_Survey_Responses.Program_ID
WHERE
	Participant_Survey_Responses.Pre_Post_Late = _pre_post;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_full_aggregate_individual_survey_results_pre_post_count` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmbickerdikerw`@`localhost` PROCEDURE `get_full_aggregate_individual_survey_results_pre_post_count`(
    _pre_post INT (1)
)
BEGIN
-- set 'other' variable
DECLARE _other_1 INT;

IF (_pre_post = 1)
THEN
	SET _other_1 = 2;
ELSEIF (_pre_post = 2)
THEN
	SET _other_1 = 1;
END IF;

SELECT DISTINCT Participant_Survey_ID,
		Participant_Survey_Responses.User_ID,
		Participant_Survey_Responses.Program_ID
 FROM Participant_Survey_Responses
	JOIN (SELECT User_ID, Program_ID
	FROM
		Participant_Survey_Responses
		WHERE Pre_Post_Late = _other_1) AS Other_1 ON Other_1.User_ID = Participant_Survey_Responses.User_ID
			AND Other_1.Program_ID = Participant_Survey_Responses.Program_ID
WHERE
	Participant_Survey_Responses.Pre_Post_Late = _pre_post;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_full_aggregate_survey_results` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmbickerdikerw`@`localhost` PROCEDURE `get_full_aggregate_survey_results`(
    _pre_post INT (1)
)
BEGIN
DECLARE _start INT;
SET _start=0;

 SELECT AVG(Question_2), AVG(Question_3), 
        AVG(Question_4_A), AVG(Question_4_B),
        AVG(Question_5_A), AVG(Question_5_B),
        AVG(Question_6), AVG(Question_7),
        AVG(Question_8), AVG(Question_9_A),
        AVG(Question_9_B), AVG(Question_11),
        AVG(Question_12), AVG(Question_13),
        AVG(Question_14)
 FROM Participant_Survey_Responses 
    WHERE 
    Pre_Post_Late = _pre_post;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_full_aggregate_survey_results_with_dates` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmbickerdikerw`@`localhost` PROCEDURE `get_full_aggregate_survey_results_with_dates`(
    _pre_post INT (1),
    _start DATE,
    _end DATE
)
BEGIN
SELECT AVG(Question_2), AVG(Question_3), 
        AVG(Question_4_A), AVG(Question_4_B),
        AVG(Question_5_A), AVG(Question_5_B),
        AVG(Question_6), AVG(Question_7),
        AVG(Question_8), AVG(Question_9_A),
        AVG(Question_9_B), AVG(Question_11),
        AVG(Question_12), AVG(Question_13),
        AVG(Question_14)
 FROM Participant_Survey_Responses 
    WHERE 
    Pre_Post_Late = _pre_post
    AND Date_Survey_Administered >= _start
    AND Date_Survey_Administered <= _end;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `pie_chart_arrays_all_individual` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmbickerdikerw`@`localhost` PROCEDURE `pie_chart_arrays_all_individual`(
    _pre_post_late INT,
    _col VARCHAR(45)
)
BEGIN

-- set 'other' variables
DECLARE _other_1 INT;
DECLARE _other_2 INT;

IF (_pre_post_late = 1)
THEN
	SET _other_1 = 2;
	SET _other_2 = 3;
ELSEIF (_pre_post_late = 2)
THEN
	SET _other_1 = 1;
	SET _other_2 = 3;
ELSEIF (_pre_post_late = 3)
THEN
	SET _other_1 = 1;
	SET _other_2 = 2;
END IF;

SET @full_qry = CONCAT('SELECT COUNT(*), ', _col, 
        ', Pre_Post_Late FROM Participant_Survey_Responses 
		JOIN (SELECT User_ID, Program_ID
		FROM
			Participant_Survey_Responses
		WHERE Pre_Post_Late = ', _other_1,
		') AS Other_1 ON Other_1.User_ID = Participant_Survey_Responses.User_ID
			AND Other_1.Program_ID = Participant_Survey_Responses.Program_ID
		JOIN (SELECT User_ID, Program_ID
		FROM
			Participant_Survey_Responses
		WHERE Pre_Post_Late = ', _other_2,
		') AS Other_2 ON Other_2.User_ID = Participant_Survey_Responses.User_ID
			AND Other_2.Program_ID = Participant_Survey_Responses.Program_ID
		WHERE
			Participant_Survey_Responses.Pre_Post_Late = ',
		_pre_post_late,
        ' GROUP BY Pre_Post_Late, ',
		_col);

PREPARE _result_finder FROM @full_qry;
-- SELECT @full_qry;
EXECUTE _result_finder;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Program__Download_Attendance` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmbickerdikerw`@`localhost` PROCEDURE `Program__Download_Attendance`(
    _program_id INT
)
BEGIN

SELECT Program_Date, Program_Dates_Users.User_ID, Users.First_Name, Users.Last_Name
    FROM Program_Dates_Users,  Users, Program_Dates

        LEFT JOIN (Programs)
        ON Program_Dates.Program_ID=Programs.Program_ID
    
            WHERE 
            Program_Dates_Users.Program_Date_ID=Program_Dates.Program_Date_ID
            AND
            Programs.Program_ID=_program_id
            AND Program_Dates_Users.User_ID=Users.User_ID
                GROUP BY Program_Date, Program_Dates_Users.User_ID;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `User__Download_Attendance` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmbickerdikerw`@`localhost` PROCEDURE `User__Download_Attendance`(
    _user INT
)
BEGIN

SELECT * FROM `lisc-bickerdike.chapinhall.org`.Program_Dates_Users, Program_Dates 
    LEFT JOIN (Programs)
    ON Program_Dates.Program_ID=Programs.Program_ID
    WHERE 
    Program_Dates_Users.Program_Date_ID=Program_Dates.Program_Date_ID
    AND
    Program_Dates_Users.User_ID=_user
    ORDER BY Programs.Program_ID;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `User__Load_With_ID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`ttmbickerdikerw`@`localhost` PROCEDURE `User__Load_With_ID`(
    _user_id INT
)
BEGIN

SELECT * FROM Users
        WHERE Users.User_ID = _user_id;

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

-- Dump completed on 2014-05-28 15:57:16
