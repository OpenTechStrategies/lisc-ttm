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
/* The load_la_casa_sample_participants.sql file must be run before this file.
 * 
 * Data from La Casa will be entered into the Participants table, the new
 * La_Casa_Residents table, and the new La_Casa_Students table.
 *
 * This is sample data for three people to be entered into those three tables.
 * 
 * Note that the Residents and Students tables will need to use the Participant
 * ID generated from the insertion into the Participants table.
*/


INSERT INTO Colleges (College_Name)
VALUES ('University of Chicago'), ('Southern Illinois University'),
('Howard Washington College');


INSERT INTO La_Casa_Basics (Participant_ID_Students, College_ID,
Credits)
VALUES ('69', '1', '3.5'), ('70', '2', '18');


