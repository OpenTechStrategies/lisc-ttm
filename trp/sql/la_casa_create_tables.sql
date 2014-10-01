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
*
*  Creating a La_Casa_Basics table to hold references to the Colleges
*  table with number of credits earned per term and specific loan
*  information that was requested by the LC director. 
*
*/

USE ttm-trp;




DROP TABLE IF EXISTS `La_Casa_Basics`;

CREATE TABLE `La_Casa_Basics`
(
`Student_ID` int(11) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`Student_ID`),
`Participant_ID_Students` int(11),
INDEX `par_ind_stu` (`Participant_ID_Students`),
FOREIGN KEY (`Participant_ID_Students`) REFERENCES `Participants`
    (`Participant_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
`College_ID` int(11), -- references Colleges table, that doesn't exist
-- yet.  Need to set as foreign key.
`Term_Type` varchar(45),
`Term` varchar(45),
`School_Year` int(4),
`Credits` varchar(45),
`Loan_Applications` int(3),
`Loan_Volume` varchar(45),
`Loans_Received` varchar(45)
) ENGINE=InnoDB;



DROP TABLE IF EXISTS `Colleges`;

CREATE TABLE `Colleges`
(
`College_ID` int(11) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`College_ID`),
`College_Name` varchar(100)
) ENGINE=InnoDB;

 ALTER TABLE `Participants` ADD
   `Email_2` varchar(60); 

ALTER TABLE `Participants` ADD
`Mobile_Phone` varchar(45);


