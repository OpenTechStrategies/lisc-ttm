#!/usr/bin/env python

# see
# http://viewvc.red-bean.com/labelnation/trunk/csv_to_ln?revision=187&view=markup
# for ideas on reading from a csv
#
# I will add instructions on how to create the simplified csv (with fewer
# columns) from the encrypted file that we receive from users


import csv

# this still needs a full path
reader = csv.reader(open('/input_file.csv', "r"))
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
INSERT INTO La_Casa_Basics (
 Participant_ID_Students,
 Student_High_School,
 ACT_Score,
 High_School_GPA,
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
 Parent1_AGI,
 Parent2_AGI,
 Student_AGI,
 AMI,
 Pell_Grant,
MAP_Grant,
University_Scholarship,
 Move_In_Date,
 Move_Out_Date
) VALUES (
  @participant_id,
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
 College_Match,
 Term_Type,
 Term,
 School_Year,
 Credits,
 College_GPA,
Subsidized_Loan,
Unsubsidized_Loan
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
    print(address_cell)
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

print(handle_address('4229 Custer Ave'))
print(handle_address('4600 W. 101 Street'))
print(handle_address("2706 W. 37th Plave, Floor 3"))
print(handle_address("None"))

# need to manage strings v. ints (quoting or not)
j = 0
for row in reader:
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
        if i == 2:
            # is dob
            participant_query = participant_query + "'" + handle_date(cell) + "', "
        if i == 7:
            participant_query = participant_query + handle_address(cell)
        if i != 2 and i != 7 and i < 12:
            participant_query = participant_query + '"' + cell + '"' + ", " 
        elif (i > 12 and i < 16) or (i > 25 and i < 46) or i == 48:
            basic_query = basic_query + "'" + cell + "', " 
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
