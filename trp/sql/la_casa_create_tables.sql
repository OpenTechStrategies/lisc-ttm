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
`College_Name` varchar(100)
) ENGINE=InnoDB;

INSERT INTO Colleges (College_Name)
VALUES ('University of Chicago'), ('Southern Illinois University'),
('Howard Washington College');


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

INSERT INTO La_Casa_Basics (Participant_ID_Students, College_ID,
Credits)
VALUES ('69', '1', '3.5'), ('70', '2', '18');


/* ALTER TABLE `Participants` ADD
   `Email_2` varchar(60); 

ALTER TABLE `Participants` ADD
`Mobile_Phone` varchar(45);
*/

