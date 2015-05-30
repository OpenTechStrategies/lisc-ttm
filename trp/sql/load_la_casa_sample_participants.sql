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
/* This file creates sample participants for the La Casa section.  It must
 * be run before load_la_casa_sample_data.sql.
 *
*/

INSERT INTO Participants 
(First_Name, Last_Name, Address_Street_Name, Address_Street_Num,
Address_Street_Direction, Address_Street_Type, Address_State, Address_City,
Address_Zipcode, Phone, Email, Gender, DOB, Race, Email_2, Mobile_Phone
)
VALUES
('Juana', 'Lopez', 'Paulina', '1818', 'S', '', 'IL', 'Chicago', '60608', 
'(312) 888-9909', 'juanalopez@gmail.com', 'F', '1995-8-17', 'Hispanic', '',
'(312) 776-8976'
),
('Ricardo', 'Mendoza', 'Paulina', '1818', 'S', '', 'IL', 'Chicago', '60608',
'(773) 884-2314', 'ricardoooo@yahoo.com', 'M', '1996-6-7', 'Black', '',
'(773) 162-2231'
),
('Maxwell', 'Smith', 'Paulina', '1818', 'S', '', 'IL', 'Chicago', '60608',
'', 'maxsmith@hotmail.com', 'M', '1995-9-8', 'White', '',
'(847) 876-5543'
);
