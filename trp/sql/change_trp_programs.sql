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

INSERT INTO Programs (Program_ID, Program_Name) VALUES ('6', 'La Casa');

/*Connect sample participants to the La Casa program.  Again, we will 
want to change the way we do this later but I need to finish it for now.*/

INSERT INTO Participants_Programs (Participant_ID, Program_ID) 
    VALUES ('69', '6'), ('70', '6'), ('71', '6');
