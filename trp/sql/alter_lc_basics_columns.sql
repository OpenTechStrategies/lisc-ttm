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

ALTER TABLE LC_Basics MODIFY Email_Pack date;
ALTER TABLE LC_Basics MODIFY Email_Orientation date;
ALTER TABLE LC_Basics MODIFY Email_Roommate date;

ALTER TABLE LC_Basics ADD COLUMN Work_Study int(11);
ALTER TABLE LC_Basics ADD COLUMN Other_Costs int(11);
ALTER TABLE LC_Basics ADD COLUMN LC_Rent int(11);
ALTER TABLE LC_Basics ADD COLUMN Graduation_Month varchar(45);
