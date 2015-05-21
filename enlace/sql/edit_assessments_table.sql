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
*//* 
 * In order to connect participant surveys to multiple sessions, this
 * file adds a Session_ID column to the Assessments table.  Since the
 * Assessments table already functions as a connector between the
 * different parts of the surveys, this new Session_ID column will serve
 * to connect those survey parts to one or more sessions, as
 * appropriate.  That is, one survey might now appear in more than one
 * row in the Assessments table.
 *
 * WARNING: As currently written, running this file WILL change data.
 * It copies information from one table to another, which shouldn't
 * cause any loss of information, but is relevant to know before running
 * "source {this file}"
*/

Use ttm-enlace;

ALTER TABLE `Assessments` ADD
   `Session_ID` int(11);

ALTER TABLE `Assessments`
ADD FOREIGN KEY (Session_ID)
REFERENCES Session_Names(Session_ID);


-- Add the previous information to this new column:

UPDATE Assessments JOIN Participants_Caring_Adults ON
Assessments.Caring_ID = Participants_Caring_Adults.Caring_Adults_ID
SET Assessments.Session_ID = Participants_Caring_Adults.Program; 