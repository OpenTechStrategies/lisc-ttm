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
 * Add the Issue_Areas and Issue_Attendance tables used in the services
 * rendered report for LSNA.  If the tables do already exist, then we need to
 * drop Issue_Attendance first, since it has a foreign key to Issue_Areas, but
 * create Issue_Areas first for the same reason.
 */

USE ttm-lsna;

DROP TABLE IF EXISTS `Issue_Attendance`;

DROP TABLE IF EXISTS `Issue_Areas`;

CREATE TABLE `Issue_Areas` (
  `Issue_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Issue_Area` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Issue_ID`)
) ENGINE=InnoDB;

INSERT INTO `Issue_Areas` VALUES (1,'SNAP'),(2,'Medical Card'),(3,'Dental Van'),(4,'Health External referrals'),(5,'DACA Application'),(6,'Citizenship'),(7,'JFON Clinic'),(8,'Immigration external referrals'),(9,'Foreclosure referrals'),(10,'Housing Doors Knock/Outreach'),(11,'Voter Registration Doors Knock'),(12,'New Registered Voters');

CREATE TABLE `Issue_Attendance` (
  `Issue_Attendance_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Issue_ID` int(11) DEFAULT NULL,
  `Month` int(11) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL,
  `Participant_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Issue_Attendance_ID`),
  KEY `issue_idx` (`Issue_ID`),
  KEY `issue_attendee_idx` (`Participant_ID`),
  CONSTRAINT `issue_attendee` FOREIGN KEY (`Participant_ID`) REFERENCES `Participants` (`Participant_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `issue` FOREIGN KEY (`Issue_ID`) REFERENCES `Issue_Areas` (`Issue_ID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;



