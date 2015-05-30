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
/* This SQL file will DROP, CREATE, and LOAD sample data into the tables
*  we need for the new La Casa section of the TRP database.
*
*  This table references the "Participants" table, and all 
*  La Casa students and residents will be entered into that table as 
*  their primary key.
*  
*  This file creates a La_Casa_Basics table to hold references to the Colleges
*  table with number of credits earned per term and specific loan
*  information that was requested by the LC director. 
*
*/

USE ttm-trp;



DROP TABLE IF EXISTS `Colleges`;

CREATE TABLE `Colleges`
(
`College_ID` int(11) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`College_ID`),
`College_Name` varchar(100),
`College_Type` varchar(100),
`Selectivity` varchar(100)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `Cohorts`;

CREATE TABLE `Cohorts`
(
`Cohort_ID` int(11) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`Cohort_ID`),
`Cohort_Name` varchar(100)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `La_Casa_Basics`; -- old name, ensure that it doesn't exist
DROP TABLE IF EXISTS `LC_Basics`;

CREATE TABLE `LC_Basics`
(
`Student_ID` int(11) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`Student_ID`),
`Participant_ID` int(11),
FOREIGN KEY (`Participant_ID`) REFERENCES `Participants`
    (`Participant_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
`Cohort` varchar(100),
`Status` varchar(3),
`Handbook` tinyint(1),
`Floor` int(1),
`Pod` int(5),
`Room_Number` varchar(5),
`Key_Card_Number` varchar(10),
`Transcript_Submitted` tinyint(1),
`Service_Hours_Submitted` tinyint(1),
`LCRC_Username` varchar(100),
`LCRC_Password` varchar(100), 
`LCRC_Print_Code` int(10),
`Roommate` int(11),
FOREIGN KEY (`Roommate`) REFERENCES `Participants`
        (`Participant_ID`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
`Application_Received` date,
`Application_Completed` date,
`Household_Size` int(3),
`Parent1_AGI` int(11),
`Parent2_AGI` int(11),
`Student_AGI` int(11),
`ACT_Score` int(5),
`High_School_GPA` varchar(5),
`Dependency_Status` varchar(10),
`HS_GPA_Weighted` varchar(5),
`Expected_Graduation_Year` int(4),
`College_Grade_Level` varchar(100),
`Reason_Leave` varchar(250),
`Reason_Stay` varchar(250),
`Father_Highest_Level_Education` int(11),
`Mother_Highest_Level_Education` int(11),
`Student_Aspiration` int(11),
`First_Generation_College_Student` varchar(30),
`Persistence_Graduation` varchar(30),
`Student_High_School` varchar(100),
`Pell_Grant` int(11),
`MAP_Grant` int(11),
`University_Scholarship` int(11),
`AMI` int(11),
`Move_In_Date` date,
`Move_Out_Date` date,
`Mid_Twenties` int(11),
`Masters_Degree` int(11),
`Married` int(11),
`Military` int(11),
`Has_Children` int(11),
`Homeless` int(11),
`Self_Sustaining` int(11),
`Tax_Exemptions` int(3),
`Household_Size_TRP` int(2),
`Tuition` int(10),
`Mandatory_Fees` int(10),
`College_Cost` int(10),
`Savings` int(10),
`Family_Help` int(10),
`LC_Scholarship` int(10),
`Application_Source` varchar(250),
`Notes` varchar(1000),
`Email_Pack` tinyint(1),
`Email_Orientation` tinyint(1),
`Email_Roommate` tinyint(1),
`Move_In_Time` varchar(10),
`Move_In_Registration` tinyint(1),
`Move_In_Address` varchar(10),
`Move_In_Note` varchar(1000),
`Orientation_Date` date,
`Orientation_Time` varchar(10)

) ENGINE=InnoDB;

DROP TABLE IF EXISTS `LC_Terms`;

CREATE TABLE LC_Terms
(
`Term_ID` int(11) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`Term_ID`),
`Participant_ID` int(11),
INDEX `student_by_term` (`Participant_ID`),
FOREIGN KEY (`Participant_ID`) REFERENCES `Participants`
    (`Participant_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
`College_ID` int(11), 
`Term_Type` varchar(45),
`Term` varchar(45),
`School_Year` int(4),
`Credits` varchar(45),
`Subsidized_Loan` int(11),
`Unsubsidized_Loan` int(11),
`Major` varchar(100),
`Minor` varchar(100),
`Expected_Match` varchar(30),
`Actual_Match` varchar(30),
`College_GPA` varchar(30),
`Internship_Status` int(11),
`Intern_Hours` int(11),
`Dropped_Classes` tinyint(1),
`Dropped_Credits` int(11)
) ENGINE=InnoDB;



 ALTER TABLE `Participants` ADD
   `Email_2` varchar(60); 

ALTER TABLE `Participants` ADD
`Mobile_Phone` varchar(45);


DROP TABLE IF EXISTS `Educational_Levels`;

CREATE TABLE `Educational_Levels`
(
`Education_ID` int(11) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`Education_ID`),
`Education_Level_Name` varchar(45)
) ENGINE = InnoDB;

INSERT INTO `Educational_Levels` (Education_Level_Name) VALUES ('Elementary'), ('Middle School'), ('Some HS'), ('GED'), ('High School Diploma'), ('Some College'), ('Trade School'), ('Associates Degree'), ('Bachelors Degree'), ('Masters Degree'), ('MD'), ('PhD'), ('Unknown');


DROP TABLE IF EXISTS `Emergency_Contacts`; 

CREATE TABLE `Emergency_Contacts` 
(
 `Emergency_Contact_ID` int(11) NOT NULL AUTO_INCREMENT,
 PRIMARY KEY (`Emergency_Contact_ID`),
 `Participant_ID` int(11),
  FOREIGN KEY (`Participant_ID`) REFERENCES `Participants` (`Participant_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
 `First_Name` varchar(45),
 `Last_Name` varchar(45),
 `Phone` varchar(15),
 `Relationship` varchar(45)
) ENGINE = InnoDB;