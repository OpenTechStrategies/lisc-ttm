#!/usr/bin/env python

# see
# http://viewvc.red-bean.com/labelnation/trunk/csv_to_ln?revision=187&view=markup
# for ideas on reading from a csv
#
# I will add instructions on how to create the simplified csv (with fewer
# columns) from the encrypted file that we receive from users


import csv

#input file should be a csv file with no header row and with cells enclosed in
#quotations. Columns should appear in exactly this order:

input_file = ""

reader = csv.reader(open(input_file, "r"))
participant_prefix = """    
INSERT INTO Participants (First_Name,
    Last_Name,
    DOB,
    Gender,
    Race,
    Email,
    Email_2,
    Address_Street_Name,
    Address_Street_Num,
    Address_Street_Direction,
    Address_Street_Type,
    Address_City,
    Address_State,
    Address_Zipcode,
    Phone,
    Mobile_Phone) VALUES (
    """

basic_prefix = """ 
INSERT INTO LC_Basics (
 Participant_ID_Students,
Group,
Status,
Handbook,
Floor,
Pod,
Room_Number,
Key_Card_Number,
Transcript_Submitted,
Service_Hours_Submitted,
LCRC_Username,
LCRC_Password,
LCRC_Print_Code,
Roommate,
Application_Received,
Application_Completed,
 Student_High_School,
 ACT_Score,
 High_School_GPA,
HS_GPA_Weighted,
Expected_Graduation_Year,
College_Grade_Level,
Reason_Leave,
Reason_Stay,
 Student_Aspiration,
 Father_Highest_Level_Education,
 Mother_Highest_Level_Education,
 First_Generation_College_Student,
 Mid_Twenties,
 Masters_Degree,
 Married,
 Military,
 Has_Children,
 Homeless,
 Self_Sustaining,
 Dependency_Status,
 Household_Size,
 Tax_Exemptions,
Household_Size_TRP,
 Parent1_AGI,
 Parent2_AGI,
 Student_AGI,
 AMI,
Tuition,
Mandatory_Fees,
College_Cost,
 Pell_Grant,
 MAP_Grant,
 University_Scholarship,
 Move_In_Date,
 Move_Out_Date,
Savings,
Family_Help,
LC_Scholarship,
Application_Source,
Notes,
Email_Pack,
Email_Orientation,
Email_Roommate,
Move_In_Time,
Move_In_Registration,
Move_In_Address,
Move_In_Note,
Orientation_Date,
Orientation_Time
) VALUES (
  @participant_id,
"""

emergency_contacts_prefix = """
INSERT INTO Emergency_Contacts ( 
    Participant_ID,
    First_Name,
    Last_Name,
    Phone,
    Relationship)
VALUES (
    @participant_id,
"""


internship = """
Internship for 2014-2015?,If so, where and how many hours per term?,
"""

college_prefix = """ 
INSERT INTO Colleges (College_Name, College_Type,
Selectivity) VALUES (
"""

term_prefix = """ 
INSERT INTO LC_Terms (
 Participant_ID,
 College_ID,
 Major,
Minor
 College_Match,
 Expected_Match,
Actual_Match,
 Term_Type,
 Term,
 School_Year,
 Credits,
 College_GPA,
Subsidized_Loan,
Unsubsidized_Loan,
Dropped classes during Fall 2014?,
If dropped classes, how many credits?
)
VALUES 

"""

output_file = 'output_file.sql'
f_out = open(output_file, 'w')

la_casa_id = "6"

add_to_program = """
SET @participant_id = LAST_INSERT_ID();

INSERT INTO Participants_Programs (Participant_ID, Program_ID)
 VALUES (@participant_id, 
"""
add_to_program = add_to_program + la_casa_id + ");"

set_college_id = """ 
SET @college_id = LAST_INSERT_ID(); """

def handle_address(address_cell):
    address_array = address_cell.split()
    if len(address_array) == 4:
        new_address = "'" + address_array[0] + "', '" + address_array[1] + "', '" + address_array[2] + "', '" + address_array[3] + "', "
    elif len(address_array) < 4:
        # we don't have 4 pieces, and things are hairier
        new_address = ""
        j = 0
        for item in address_array:
            new_address = new_address + "'" + item + "', "
            j = j+1
        while j < 4:
            new_address = new_address +  "'', "
            j = j+1
    elif len(address_array) > 4:
        new_address = "'"
        j = 0
        for item in address_array:
            if j < 3:
                new_address = new_address + item + "', '"
            else:
                new_address = new_address + item 
            j = j+1
        new_address = new_address + "' "
    return new_address

def handle_date(date_cell):
    if len(cell.split("/")) > 1:
        date = "'" + cell.split("/")[2] + '-' + cell.split("/")[0] + '-' + cell.split("/")[1] + "'"
    else:
        date = 'NULL'
    return date

# need to manage strings v. ints (quoting or not)
j = 0
for row in reader:
    if (j > 2):
        break
    i = 0
    participant_query = participant_prefix
    basic_query = basic_prefix
    college_query = college_prefix + "'" + row[17] + "', '4-year', '" + row[18] + "');"
    # these may belong in a different table, given the repetition
    term_row_begin = "( @participant_id, @college_id, '"  + row[16] + "', '" + row[19] + "', NULL, "
    term_row_end =  "', '" + row[46] + "', '" + row [47] + "')"
    term_1 = term_row_begin + " 'Spring', '2013', " + " NULL, '" + row[22] + term_row_end + ", "
    term_2 = term_row_begin + " 'Summer', '2013', " + " NULL, '" + row[23] + term_row_end + ", "
    term_3 = term_row_begin + " 'Fall', '2013', '" + row[20] + "', '" + row[24] + term_row_end + ", "
    term_4 = term_row_begin + " 'Spring', '2014', '" + row[21] + "', '" + row[25] + term_row_end + "; "
    term_query = term_prefix + term_1 + term_2 + term_3 + term_4
    # note that mailing address will need to be managed
    for cell in row:
#        print(i)
#        print(row[i])
        if  (i > 9 and i < 12) or i == 15 or (i > 20 and i < 29):
            participant_query = participant_query + '"' + cell + '"' + ", " 
        elif (i < 9) or (i > 11 and i < 21) or (i > 28 and i < 35) or (i > 51 and i < 59) or (i > 60 and i < 110):
            basic_query = basic_query + "'" + cell + "', " 
        elif (i == 111 or i == 115):
            emergency_contacts_query = emergency_contacts_prefix  + "'" + cell + "', " 
        elif (i > 111 and i < 115) or (i > 115 and i < 118):
            emergency_contacts_query = emergency_contacts_query + "'" + cell + "', " 
        i += 1
    participant_query = participant_query + '"' + row[12]  + '"' + ");"
    basic_query = basic_query + handle_date(row[49]) + ");"
    f_out.write(participant_query + "\n")
    f_out.write(add_to_program + "\n");
    f_out.write(basic_query + "\n")
    f_out.write(college_query + "\n")
    f_out.write(set_college_id + "\n")
    f_out.write(term_query + "\n")
    j = j+1

