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
 * This file adds a "funder" row to the Institution_Types table and
 *  adds a column for funder to the Subcategory_Dates table.
*/

USE ttm-lsna;

INSERT INTO Institution_Types (Institution_Type_Name) VALUES
('Funder');

ALTER TABLE `Subcategory_Dates` ADD
`Funder_ID` int(11);
ALTER TABLE `Subcategory_Dates`
ADD FOREIGN KEY (Funder_ID)
REFERENCES Institutions(Institution_ID);