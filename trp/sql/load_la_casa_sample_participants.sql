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
