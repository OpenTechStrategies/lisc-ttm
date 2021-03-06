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
/*
 * This file will add a "La Casa" program to TRP's program table in accordance 
 * with Issue #5.  This file should be run before deleting any programs,
 * such that the La Casa program will have program ID equal to 6.
*/


USE ttm-trp;

ALTER TABLE LC_Basics DROP COLUMN Household_Size_TRP;
ALTER TABLE LC_Basics DROP COLUMN Dependency_Status;


ALTER TABLE LC_Basics ADD COLUMN Move_In_Season varchar(45);
ALTER TABLE LC_Basics ADD COLUMN Move_Out_Season varchar(45);
ALTER TABLE LC_Basics ADD COLUMN Move_In_Year int(4);
ALTER TABLE LC_Basics ADD COLUMN Move_Out_Year int(4);


ALTER TABLE LC_Terms MODIFY School_Year varchar(10);

-- Add existing cohort names:
INSERT INTO Cohorts (Cohort_Name) VALUES ('Chicago Semester'), ('Casa Norte'), ('Associated Colleges of the Midwest'), ('Does not have one'), ('Missing/Not reported'), ('ARCHEWORKS');

-- Create table for statuses, so that users can add new ones:

DROP TABLE IF EXISTS `Statuses`;

CREATE TABLE `Statuses`
(
`Status_ID` int(11) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`Status_ID`),
`Status_Name` varchar(100)
) ENGINE=InnoDB;


INSERT INTO Statuses (Status_Name) VALUES ('Signed'), ('Scheduled to Sign'), ('May Sign'), ('Moved Out'), ('Pending App'), ('Not Admitted'), ('Not Interested');
