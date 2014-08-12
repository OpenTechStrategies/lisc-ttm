/* Data from La Casa will be entered into the Participants table, the new
 * La_Casa_Residents table, and the new La_Casa_Students table.
 *
 * This is sample data for three people to be entered into those three tables.
 * 
 * Note that the Residents and Students tables will need to use the Participant
 * ID generated from the insertion into the Participants table.
*/

/*INSERT INTO Participants 
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
);*/

INSERT INTO La_Casa_Residents
(Participant_ID_Residents, Handbook, Status, Floor, Pod, Room_Number,
Key_Card, App_Received, App_Completed, Roommate, Rmmate_Move_In, LC_Username,
LC_Password, LC_Print_Code, HS_ID, ACT, HS_GPA_raw, HS_GPA_weight, 
Mother_Education, Father_Education, First_Gen, 24_older, Master_plus,
Married, Military, Has_Children, Homeless, Self_Sustaining, Tax_Exemptions,
Household_size, Parent1_AGI, Parent2_AGI, Student_AGI,
AMI, App_Source, Notes, Packing_Email, Orientation_Email, Roommate_Email, 
Move_In, Move_In_Registration, Move_In_Address, Move_In_Note, Orientation,
EC1_First_Name, EC1_Last_Name, EC1_Phone, EC1_Relationship, EC2_First_Name,
EC2_Last_Name,  EC2_Phone, EC2_Relationship, Scholarship)
VALUES
('69',  '', 'Complete', '', '', '', '', '2014-4-3', '2014-4-3', '', '', 
'jlopez', 'LCRC2014', '', '', '', '', '', '', '', '', '0', '0', '0', '0', '0', 
'0', '0', '4', '3', '25070', '0', '0', '.4', 'Open House 7/19/2014', 'Complete.',
'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),

('70', '',  'Complete', '', '', '', '', '2014-4-3', '', '', '', 
'rmendoza', 'LCRC2014', '', '', '', '', '', '', '', '', '0', '0', '0', '0', '0', 
'0', '0', '5', '7', '32889', '0', '0', '.4', 'Walk-In', 'Complete.',
'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),

('71', '',  'Complete', '', '', '', '', '2014-5-14', '2014-5-14', '', '', 
'msmith', 'LCRC2014', '', '', '', '', '', '', '', '', '0', '0', '0', '0', '0', 
'0', '0', '4', '4', '34890', '0', '0', '.5', 'Benito Juarez Spring College Fair',
 'Complete.', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

INSERT INTO La_Casa_Students
(Participant_ID_Students, College_Grade_Level, Major, Minor, Comm_College,
Four_yr_College, Selectivity, Expected_Match, Actual_Match, Credits_Fall,
Credits_Spring, Spring_GPA, Summer_GPA, Fall_GPA, School_Year, Goal_Ed, Tuition,
Fees, Other_Costs, La_Casa_Rent, College_Stated_Cost, Pell_Grant, MAP_Grant,
Scholarships, Federal_Sub_Loan, Federal_Unsub_Loan, Self_Help, Savings, 
La_Casa_Scholarship, Family_Help, HS_GPA, Academic_Advisor, Advisor_Phone)
VALUES
('69', 'Sophomore', 'Urban Planning', 'None', 'None', 'Illinois Institute of Technology',
'', '', '', '', '', '', '', '', '2013-14', '', '11582', '5004', '2800', '6255',
'30566', '5730', '4720', '9990', '3500', '', '3500', '', '', '', '', '', ''
),
('70', 'Sophomore', 'Sociology', 'Spanish', 'Harold Washington College',
 'University of Illinois at Chicago',
'', '', '', '', '', '', '', '', '2013-14', '', '12587', '3852', '2800', '6255',
'21184', '5730', '4720', '4005', '3500', '', '3500', '', '3150', '', '', '', ''
),
('71', 'Freshman', 'Poetry', 'English', 'None', 'Columbia College',
'', '', '', '', '', '', '', '', '2013-14', '', '40000', '1500', '2800', '6255',
'53745', '5730', '4720', '31000', '3500', '', '3500', '', '1350', '', '', '', ''
);