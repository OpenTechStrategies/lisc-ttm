#!/usr/bin/env python

import csv
import sys

# input file should be a csv file with no header row and with cells enclosed in
# quotations. Columns should appear in exactly this order: 
#
# To Dos:
# remember to escape all inputs!

input_file = sys.argv[1]
la_casa_id = '6'


def handle_address(address_cell):
    address_array = address_cell.split()
    if len(address_array) == 4:
        new_address = "'" + address_array[0] + "', '" + address_array[1] + """',
        '""" + address_array[2] + "', '" + address_array[3] + "', " 
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


def make_participant_query(f_out, first_name, last_name, dob, gender,
                               email_1, email_2, address, city, state,
                               zipcode, home_phone, mobile_phone, la_casa_id):  

    participant_prefix = """    
INSERT INTO Participants (First_Name,
    Last_Name,
    DOB,
    Gender,
    Email,
    Email_2,
    Address_Street_Num,
    Address_Street_Direction,
    Address_Street_Name,
    Address_Street_Type,
    Address_City,
    Address_State,
    Address_Zipcode,
    Phone,
    Mobile_Phone) VALUES (
    """
    participant_query = participant_prefix + "'" + first_name + "', '" + last_name + "', '" + dob + "', '" + gender + "', '" + email_1 + "', '" + email_2 + "', " + handle_address(address) + "'" + city + "', '" + state + "', '" + zipcode + "', '" + home_phone + "', '" + mobile_phone  + "');"
    f_out.write(participant_query + "\n")
    add_to_program = """
        SET @participant_id = LAST_INSERT_ID();

        INSERT INTO Participants_Programs (Participant_ID, Program_ID)
             VALUES (@participant_id, """  + la_casa_id + ");"
    f_out.write(add_to_program + "\n")


def make_basic_query(f_out, array_of_cells):
    basic_prefix = """ 
INSERT INTO LC_Basics (
 Participant_ID,
Cohort,
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
Application_Received,
Application_Completed,
 Student_High_School,
 ACT_Score,
 High_School_GPA,
HS_GPA_Weighted,
College_Grade_Level,
Expected_Graduation_Year,
Reason_Leave,
Reason_Stay,
 Student_Aspiration,
 Mother_Highest_Level_Education,
 Father_Highest_Level_Education,
 First_Generation_College_Student,
 Mid_Twenties,
 Masters_Degree,
 Married,
 Military,
 Has_Children,
 Homeless,
 Self_Sustaining,
 Dependency_Status,
 Tax_Exemptions,
 Household_Size,
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
Savings,
Family_Help,
LC_Scholarship,
Application_Source,
Notes,
Email_Pack,
Email_Orientation,
Email_Roommate,
Move_In_Date,
Move_In_Time,
Move_In_Registration,
Move_In_Address,
Move_In_Note,
Orientation_Date,
Orientation_Time
) VALUES (
  @participant_id,
"""
    basic_query = basic_prefix
    counter = 0
    for cell in array_of_cells:
        if counter == (len(array_of_cells) - 1):
            basic_query = basic_query + "'" + cell + "');"
        else:
            basic_query = basic_query + "'" + cell + "', "
        counter = counter + 1
    f_out.write(basic_query + "\n")

def make_ec_query(f_out, first, last, phone, relation):
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
    emergency_contact_query = emergency_contacts_prefix + "'" + first + "', '" + last + "', '"  + phone + "', '"  + relation + "');"
    f_out.write(emergency_contact_query + "\n")



def make_college_query(f_out, community_college, four_yr_college, selectivity):
    college_prefix = """ 
INSERT INTO Colleges (College_Name, College_Type,
Selectivity) VALUES (
"""
    college_fouryr_query = college_prefix + "'" + four_yr_college + "', '4-year', '" + selectivity + "');"
    college_comm_query = college_prefix + "'" + community_college + "', 'Community College', '" + selectivity + "');"
    college_query = college_fouryr_query + college_comm_query
    f_out.write(college_query + "\n")
    set_college_id = """ 
        SET @college_id = LAST_INSERT_ID(); """
    f_out.write(set_college_id + "\n")


def make_lc_terms_query(f_out, major, minor, exp_match, actual_match,
                        credits_fall_2013, credits_spring_2014,
                        credits_fall_2014, gpa_spring_2013, gpa_summer_2013,
                        gpa_fall_2013, gpa_fall_2014, dropped_classes,
                        dropped_credits, gpa_spring_2014, internship_status,
                        internship_hours, subsidized_loan, unsubsidized_loan):

    term_prefix = """ 
        INSERT INTO LC_Terms (
         Participant_ID,
         College_ID,
         Major,
         Minor,
         Expected_Match,
         Actual_Match,
         Term_Type,
         Term,
         School_Year,
         Credits,
         College_GPA,
         Subsidized_Loan,
         Unsubsidized_Loan,
         Dropped_Classes,
         Dropped_Credits,
         Internship_Status,
         Intern_Hours
        )
        VALUES 
        
        """
    term_row_begin = "( @participant_id, @college_id, '"  + major + """', 
        '""" + minor +  "', '" + exp_match + "', '" + actual_match + "', NULL, "
    term_row_end =  "', '" + subsidized_loan + "', '" + unsubsidized_loan + """',
        NULL, NULL, NULL, NULL )""" 
    term_1 = term_row_begin + " 'Spring', '2013', " + """ NULL, 
        '""" + gpa_spring_2013 + term_row_end + ", "
    term_2 = term_row_begin + " 'Summer', '2013', " + """ NULL,
        '""" + gpa_summer_2013 + term_row_end + ", "
    term_3 = term_row_begin + " 'Fall', '2013', '" + credits_fall_2013 + """', 
        '""" + gpa_fall_2013 + term_row_end + ", "
    term_4 = term_row_begin + " 'Spring', '2014', '" + credits_spring_2014 + """',
        '""" + gpa_spring_2014 + term_row_end + ", "
    term_5 = term_row_begin + " 'Fall', '2014', '" + credits_fall_2014 + """', 
        '""" + gpa_fall_2014 + "', '" +  subsidized_loan +  "', '" + unsubsidized_loan +  """',
        '""" + dropped_classes +  "', '" + dropped_credits + """', 
        '""" + internship_status + "', '" + internship_hours + "'); "
    term_query = term_prefix + term_1 + term_2 + term_3 + term_4 + term_5
    f_out.write(term_query + "\n")



def construct_sql_file(input_file, la_casa_id):
    if len(sys.argv) != 2:
        print("Call this like:\n"
              " ./import_lc_data.py DATA_CSV")
        sys.exit(1)
    input_file = sys.argv[1]
    # this function depends on the order of columns in the input file 
    reader = csv.reader(open(input_file, "r"))
    output_file = 'output_file.sql'
    f_out = open(output_file, 'w')
    j = 0
    for row in reader:
        #skip header row
        if (j == 0):
            j = j+1
            continue
        i = 0
        # each function creates the query and writes it to the output file
        make_participant_query(f_out, row[9], row[10], row[11], row[15],
                               row[21], row[22], row[23], row[24], row[25],
                               row[26], row[27], row[28], la_casa_id)
        basic_query_array = [ row[0], row[1], row[2], row[3], row[4], row[5],
                         row[6], row[7], row[8], row[12], row[13], row[14],
                         row[19], row[20], row[29], row[30], row[31],
                         row[32], row[34], row[33], row[53], row[54], row[55],
                         row[56], row[57], row[58], row[61], row[62], row[63],
                         row[64], row[65], row[66], row[67], row[68], row[69],
                         row[70], row[71], row[72], row[73], row[74], row[76],
                         row[77], row[78], row[82], row[84], row[85], row[86],
                         row[92], row[93], row[96], row[99], row[100], row[101],
                         row[102], row[103], row[104], row[105], row[106],
                         row[107], row[108], row[109], row[110]]
        make_basic_query(f_out, basic_query_array)
        make_college_query(f_out, row[37], row[38], row[39])
        make_lc_terms_query(f_out, row[35], row[36], row[40], row[41], row[42], 
                            row[43], row[44], row[45], row[46], row[47],
                            row[48], row[49], row[50], row[51], row[59],
                            row[60], row[87], row[88])  
        make_ec_query(f_out, row[111], row[112], row[113], row[114])
        make_ec_query(f_out, row[115], row[116], row[117], row[118])
        j = j + 1

construct_sql_file(input_file, la_casa_id)
print("done")
