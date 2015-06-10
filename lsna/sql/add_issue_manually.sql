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
 * Add an Issue_Service table for counting people who are served but
 * aren't participants in the TTM system.
*/

DROP TABLE IF EXISTS `Issue_Service`;

CREATE TABLE `Issue_Service`
(
 `Issue_Served_ID` int(11) NOT NULL AUTO_INCREMENT,
 PRIMARY KEY (`Issue_Served_ID`),
 `Number_Served` int(11),
 `Issue_ID` int(11),
 FOREIGN KEY (`Issue_ID`) REFERENCES `Issue_Areas`
         (`Issue_ID`)
         ON DELETE CASCADE
         ON UPDATE CASCADE,
 `Month` int(11),
 `Year` int(11)
) ENGINE=InnoDB;
