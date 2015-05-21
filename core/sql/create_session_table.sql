
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
 * Create table to store user sessions (i.e., determine whether users are logged in).
*/

USE ttm-core;

DROP TABLE IF EXISTS `User_Sessions`;

CREATE TABLE `User_Sessions`
(
`Session_ID` INT (10) NOT NULL AUTO_INCREMENT,
`PHP_Session` VARCHAR (100),
`User_ID` INT (10),
`Time_Logged_On` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
`Expire_Time` TIMESTAMP,
PRIMARY KEY (Session_ID)
)
ENGINE=InnoDB;