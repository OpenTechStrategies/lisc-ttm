/* This SQL file will DROP, CREATE, and LOAD sample data into the tables
*  we need for the new La Casa section of the TRP database.
*
*  Both of these tables reference the "Participants" table, and all 
*  La Casa students and residents will be entered into that table as 
*  their primary key.
*  
*  The "La_Casa_Residents" table holds all the information having to do with 
*  students' residence at La Casa.  We expect any imported information from HDS 
*  that does not belong in the "Participants" table to have a home in the 
*  "La_Casa_Residents" table.  
*
*  The "La_Casa_Students" table holds more specialized information about the
*  residents, but in their capacity as college students.  This will grow more
*  complicated as time goes on, but for now we have indications that we will
*  eventually be linking to a schools table that includes colleges and high
*  schools.
*/

USE ttm-trp;

DROP TABLE IF EXISTS `La_Casa_Residents`;

CREATE TABLE `La_Casa_Residents`
(
`Resident_ID` int(11) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`Resident_ID`),
`Participant_ID_Residents` int(11),
INDEX `par_ind_res` (`Participant_ID_Residents`),
FOREIGN KEY (`Participant_ID_Residents`) REFERENCES `Participants`
    (`Participant_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
`Group` varchar(45),
`Handbook` int(11),
`Status` varchar(45),
`Floor` int(45),
`Pod` int(11),
`Room_Number` varchar(45),
`Key_Card` varchar(45),
`App_Received` date,
`App_Completed` date,
`Roommate` int(11), -- should be a foreign key to the participants table
`Rmmate_Move_In` date,
`LC_Username` varchar(45),
`LC_Password` varchar(45),
`LC_Print_Code` varchar(45),
`HS_ID` int(11),  -- or the high school name, depending on whether we create a table of high schools
`ACT` int(11),
`HS_GPA_raw` varchar(45),
`HS_GPA_weight` varchar(45),
`Mother_Education` varchar(45),
`Father_Education` varchar(45),
`First_Gen` int(11),
`24_older` int(11),
`Master_plus` int(11),
`Married` int(11),
`Military` int(11),
`Has_Children` int(11),
`Homeless` int(11),
`Self_Sustaining` int(11),
`Tax_Exemptions` int(11),
`Household_size` int(11),
`Household_Income` varchar(45),
`Parent1_AGI` varchar(45), -- should be int?
`Parent2_AGI` varchar(45),
`Student_AGI` varchar(45),
`AMI` varchar(45), -- percentage
`App_Source` varchar(45), -- should we have a list of ways apps are submitted?
                          -- events, walkins...and reference that here?
`Notes` varchar(250), -- will probably need more space
`Packing_Email` date,
`Orientation_Email` date,
`Roommate_Email` date,
`Move_In` date,
`Move_In_Registration` int(11),
`Move_In_Address` varchar(45), -- I think we can calculate this from room number.  to confirm.
`Move_In_Note` varchar(250), -- make longer?
`Orientation` datetime, -- includes both date and time of orientation, combining
                        -- their two columns
`EC1_First_Name` varchar(45),
`EC1_Last_Name` varchar(45),
`EC1_Phone` varchar(45), -- or int?
`EC1_Relationship` varchar(45), -- or list to reference via int?
`EC2_First_Name` varchar(45),
`EC2_Last_Name` varchar(45),
`EC2_Phone` varchar(45), -- or int?
`EC2_Relationship` varchar(45), -- or list to reference via int?
`Scholarship` int(11)
) ENGINE=InnoDB;



DROP TABLE IF EXISTS `La_Casa_Students`;

CREATE TABLE `La_Casa_Students`
(
`Student_ID` int(11) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`Student_ID`),
`Participant_ID_Students` int(11),
INDEX `par_ind_stu` (`Participant_ID_Students`),
FOREIGN KEY (`Participant_ID_Students`) REFERENCES `Participants`
    (`Participant_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
`College_Grade_Level` int(11), -- will change over time.  Store elsewhere?
`Major` varchar(45),
`Minor` varchar(45),
`Comm_College` int(11),
`Four_yr_College` int(11),
`Selectivity` varchar(45),
`Expected_Match` int(11),
`Actual_Match` int(11),
`Credits_Fall` int(11),
`Credits_Spring` int(11),
`Spring_GPA` varchar(45),
`Summer_GPA` varchar(45),
`Fall_GPA` varchar(45),
`School_Year` int(11),
`Goal_Ed` varchar(45),
`Tuition` int(11),
`Fees` int(11),
`Other_Costs` int(11), -- food, transportation, books
`La_Casa_Rent` int(11),
`College_Stated_Cost` int(11),
`Pell_Grant` int(11),
`MAP_Grant` int(11),
`Scholarships` int(11),
`Federal_Sub_Loan` int(11),
`Federal_Unsub_Loan` int(11),
`Self_Help` int(11),
`Savings` int(11),
`La_Casa_Scholarship` int(11),
`Family_Help` int(11),
`College_ID` int(11),
`HS_ID` int(11),
`HS_Grad_Date` date,
`HS_GPA` varchar(5),
`Academic_Advisor` varchar(100),
`Advisor_Phone` varchar(45)
) ENGINE=InnoDB;

-- LOCK TABLES `Participants` WRITE; -- do I need to lock the table to add cols?

/* ALTER TABLE `Participants` ADD
   `Email_2` varchar(60); */

/*ALTER TABLE `Participants` ADD
`Mobile_Phone` varchar(45);*/

-- UNLOCK TABLES;