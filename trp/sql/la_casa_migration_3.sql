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
 * This file will move the subsidized and unsubsidized loan information
 * to the LC_Basics table from the LC_Terms. 
 *
*/


USE ttm-trp;

ALTER TABLE LC_Basics ADD COLUMN Unsubsidized_Loan int(11);
ALTER TABLE LC_Basics ADD COLUMN Subsidized_Loan int(11);

UPDATE LC_Basics INNER JOIN LC_Terms ON LC_Basics.Participant_ID = LC_Terms.Participant_ID SET LC_Basics.Unsubsidized_Loan = LC_Terms.Unsubsidized_Loan, LC_Basics.Subsidized_Loan = LC_Terms.Subsidized_Loan;

ALTER TABLE LC_Terms DROP COLUMN Unsubsidized_Loan;
ALTER TABLE LC_Terms DROP COLUMN Subsidized_Loan;




