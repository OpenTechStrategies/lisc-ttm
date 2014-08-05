<?php

//takes as arguments the query, database connection and database connection
//file, column headers, and file name.

//code drawn from tutorial at:
// http://code.stephenmorley.org/php/creating-downloadable-csv-files/

function generalized_download($download_name){
    $download_list_array=array(
        'aldermans_records'=>array('db'=>'bickerdike', 'query'=> 
            'SELECT * FROM Aldermanic_Records', 
            'titles'=>array("ID", "Environmental_Improvement_Money", "Date")),
        
        'bike_trail_records'=>array('db'=>'bickerdike', 'query'=>
            'SELECT * FROM Bike_Trails',
            'titles'=>array("ID", "Miles of Bike Lanes", "Date")),
        
        'cws_baseline'=>array('db'=>'bickerdike', 'query'=>
            'SELECT * FROM Community_Wellness_Survey_Aggregates',
            'titles'=>array("ID", "CWS Baseline Question 15", "Question 20", 
                "Question 21", "Question 24", "Question 29", "Question 31", 
                "Question 30",  "Question 32", "Question 69", "Question 72", 
                "Question 91", "Question 41a", "Question 41b", "Question 44", 
                "Date")),
        
        'corner_stores'=>array('db'=>'bickerdike', 'query'=>
            'SELECT * FROM Corner_Store_Assessment INNER JOIN Corner_Stores ON '
            . 'Corner_Store_Assessment.Corner_Store_ID= Corner_Stores.Corner_Store_ID',
            'titles'=>array("ID", "Store ID", "2 Vegetable Options?", "Lowfat Milk?",
                "Health Signage?", "Healthy Items in the Front?", "Date", 
                "Store ID", "Name", "Address")),
        
        'corner_stores_deid'=>array('db'=>'bickerdike', 'query'=>
            'SELECT * FROM Corner_Store_Assessment',
            'titles'=>array("ID", "Store ID", "2 Vegetable Options?", "Lowfat Milk?",
            "Health Signage?", "Healthy Items in the Front?", "Date")),
        
        'store_sales'=>array('db'=>'bickerdike', 'query'=>
            'SELECT * FROM Funded_Organization_Records_Stores',
            'titles'=>array("ID", "Store", "Date", "Sales Data")),
        
        'partner_orgs'=>array('db'=>'bickerdike', 'query'=>
            'SELECT * FROM Org_Partners',
            'titles'=>array("ID", "Partner Name")),
        
        'all_surveys_bickerdike'=>array('db'=>'bickerdike', 'query'=>
            'SELECT Users.User_ID, First_Name, Last_Name, Gender, Age, 
                Address_Number, Address_Street_Direction, 
                Address_Street_Name, Address_Street_Type, Zipcode, Race, 
                Question_2, Question_3, 
                Question_4_A, Question_4_B, Question_5_A, Question_5_B, 
                Question_6, Question_7, Question_8,
                Question_9_A, Question_9_B, Question_11, Question_12, 
                Question_13, Question_14, Date_Survey_Administered,
                Pre_Post_Late, Programs.Program_ID, Program_Name, Partner_Name,
                Participant_Type, Child_ID FROM Participant_Survey_Responses
                LEFT JOIN (Programs, Users, Org_Partners)
                ON (Participant_Survey_Responses.User_ID=Users.User_ID
                AND Participant_Survey_Responses.Program_ID=Programs.Program_ID
                AND Programs.Program_Organization=Org_Partners.Partner_ID)',
            'titles'=>array("User ID", "First Name", "Last Name", "Gender", 
                "Age", "Address Number", "Street Direction", "Street Name", 
                "Street Type", "Zipcode", "Race/Ethnicity -- (b) African American, "
                . "(l) Latino, (a) Asian, (w) White, (o) Other", "Question 2 -- "
                . "(1) Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", 
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Program Name", "Program Organization", "Participant Type", 
                "Child ID")),
        
        'all_surveys_bickerdike_deid'=>array('db'=>'bickerdike', 'query'=>
            'SELECT Users.User_ID, Gender, Age, 
                Zipcode, Race, 
                Question_2, Question_3, 
                Question_4_A, Question_4_B, Question_5_A, Question_5_B, 
                Question_6, Question_7, Question_8,
                Question_9_A, Question_9_B, Question_11, Question_12, 
                Question_13, Question_14, Date_Survey_Administered,
                Pre_Post_Late, Programs.Program_ID, Program_Name, Partner_Name,
                Participant_Type, Child_ID FROM Participant_Survey_Responses
                LEFT JOIN (Programs, Users, Org_Partners)
                ON (Participant_Survey_Responses.User_ID=Users.User_ID
                AND Participant_Survey_Responses.Program_ID=Programs.Program_ID
                AND Programs.Program_Organization=Org_Partners.Partner_ID)',
            'titles'=>array("User ID", "Zipcode", 
                "Race/Ethnicity -- (b) African American, "
                . "(l) Latino, (a) Asian, (w) White, (o) Other", "Question 2 -- "
                . "(1) Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", 
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Program Name", "Program Organization", "Participant Type", 
                "Child ID")),
        
        'adult_surveys_bickerdike'=>array('db'=>'bickerdike', 'query'=>
            "SELECT Users.User_ID, First_Name, Last_Name, Gender, Age, 
                Address_Number, Address_Street_Direction, 
                Address_Street_Name, Address_Street_Type, Zipcode, Race, 
                Question_2, Question_3, 
                Question_4_A, Question_4_B, Question_5_A, Question_5_B, 
                Question_6, Question_7, Question_8,
                Question_9_A, Question_9_B, Question_11, Question_12, 
                Question_13, Question_14, Date_Survey_Administered,
                Pre_Post_Late, Programs.Program_ID, Program_Name, Partner_Name,
                Participant_Type, Child_ID FROM Participant_Survey_Responses
                LEFT JOIN (Programs, Users, Org_Partners)
                ON (Participant_Survey_Responses.User_ID=Users.User_ID
                AND Participant_Survey_Responses.Program_ID=Programs.Program_ID
                AND Programs.Program_Organization=Org_Partners.Partner_ID)
                 WHERE Participant_Type='adult'",
            'titles'=>array("User ID", "First Name", "Last Name", "Gender", 
                "Age", "Address Number", "Street Direction", "Street Name", 
                "Street Type", "Zipcode", "Race/Ethnicity -- (b) African American, "
                . "(l) Latino, (a) Asian, (w) White, (o) Other", "Question 2 -- "
                . "(1) Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", 
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Program Name", "Program Organization", "Participant Type", 
                "Child ID")),
        
        'adult_surveys_bickerdike_deid'=>array('db'=>'bickerdike', 'query'=>
            "SELECT Users.User_ID, Gender, Age, 
                Zipcode, Race, 
                Question_2, Question_3, 
                Question_4_A, Question_4_B, Question_5_A, Question_5_B, 
                Question_6, Question_7, Question_8,
                Question_9_A, Question_9_B, Question_11, Question_12, 
                Question_13, Question_14, Date_Survey_Administered,
                Pre_Post_Late, Programs.Program_ID, Program_Name, Partner_Name,
                Participant_Type, Child_ID FROM Participant_Survey_Responses
                LEFT JOIN (Programs, Users, Org_Partners)
                ON (Participant_Survey_Responses.User_ID=Users.User_ID
                AND Participant_Survey_Responses.Program_ID=Programs.Program_ID
                AND Programs.Program_Organization=Org_Partners.Partner_ID)
                 WHERE Participant_Type='adult'",
            'titles'=>array("User ID", "Gender", 
                "Age", "Zipcode", "Race/Ethnicity -- (b) African American, "
                . "(l) Latino, (a) Asian, (w) White, (o) Other", "Question 2 -- "
                . "(1) Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", 
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Program Name", "Program Organization", "Participant Type", 
                "Child ID")),
        
        'parent_surveys_bickerdike'=>array('db'=>'bickerdike', 'query'=>
            "SELECT Users.User_ID, First_Name, Last_Name, Gender, Age, 
                Address_Number, Address_Street_Direction, 
                Address_Street_Name, Address_Street_Type, Zipcode, Race, 
                Question_2, Question_3, 
                Question_4_A, Question_4_B, Question_5_A, Question_5_B, 
                Question_6, Question_7, Question_8,
                Question_9_A, Question_9_B, Question_11, Question_12, 
                Question_13, Question_14, Date_Survey_Administered,
                Pre_Post_Late, Programs.Program_ID, Program_Name, Partner_Name,
                Participant_Type, Child_ID FROM Participant_Survey_Responses
                LEFT JOIN (Programs, Users, Org_Partners)
                ON (Participant_Survey_Responses.User_ID=Users.User_ID
                AND Participant_Survey_Responses.Program_ID=Programs.Program_ID
                AND Programs.Program_Organization=Org_Partners.Partner_ID)
                 WHERE Participant_Type='parent'",
            'titles'=>array("User ID", "First Name", "Last Name", "Gender", 
                "Age", "Address Number", "Street Direction", "Street Name", 
                "Street Type", "Zipcode", "Race/Ethnicity -- (b) African American, "
                . "(l) Latino, (a) Asian, (w) White, (o) Other", "Question 2 -- "
                . "(1) Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", 
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Program Name", "Program Organization", "Participant Type", 
                "Child ID")),
        
        'parent_surveys_bickerdike_deid'=>array('db'=>'bickerdike', 'query'=>
            "SELECT Users.User_ID,  Gender, Age, 
                Zipcode, Race, 
                Question_2, Question_3, 
                Question_4_A, Question_4_B, Question_5_A, Question_5_B, 
                Question_6, Question_7, Question_8,
                Question_9_A, Question_9_B, Question_11, Question_12, 
                Question_13, Question_14, Date_Survey_Administered,
                Pre_Post_Late, Programs.Program_ID, Program_Name, Partner_Name,
                Participant_Type, Child_ID FROM Participant_Survey_Responses
                LEFT JOIN (Programs, Users, Org_Partners)
                ON (Participant_Survey_Responses.User_ID=Users.User_ID
                AND Participant_Survey_Responses.Program_ID=Programs.Program_ID
                AND Programs.Program_Organization=Org_Partners.Partner_ID)
                 WHERE Participant_Type='parent'",
            'titles'=>array("User ID", "Gender", 
                "Age", "Zipcode", "Race/Ethnicity -- (b) African American, "
                . "(l) Latino, (a) Asian, (w) White, (o) Other", "Question 2 -- "
                . "(1) Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", 
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Program Name", "Program Organization", "Participant Type", 
                "Child ID")),
        
        'youth_surveys_bickerdike'=>array('db'=>'bickerdike', 'query'=>
            "SELECT Users.User_ID, First_Name, Last_Name, Gender, Age, 
                Address_Number, Address_Street_Direction, 
                Address_Street_Name, Address_Street_Type, Zipcode, Race, 
                Question_2, Question_3, 
                Question_4_A, Question_4_B, Question_5_A, Question_5_B, 
                Question_6, Question_7, Question_8,
                Question_9_A, Question_9_B, Question_11, Question_12, 
                Question_13, Question_14, Date_Survey_Administered,
                Pre_Post_Late, Programs.Program_ID, Program_Name, Partner_Name,
                Participant_Type, Child_ID FROM Participant_Survey_Responses
                LEFT JOIN (Programs, Users, Org_Partners)
                ON (Participant_Survey_Responses.User_ID=Users.User_ID
                AND Participant_Survey_Responses.Program_ID=Programs.Program_ID
                AND Programs.Program_Organization=Org_Partners.Partner_ID)
                 WHERE Participant_Type='youth'",
            'titles'=>array("User ID", "First Name", "Last Name", "Gender", 
                "Age", "Address Number", "Street Direction", "Street Name", 
                "Street Type", "Zipcode", "Race/Ethnicity -- (b) African American, "
                . "(l) Latino, (a) Asian, (w) White, (o) Other", "Question 2 -- "
                . "(1) Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", 
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Program Name", "Program Organization", "Participant Type", 
                "Child ID")),
        
        'youth_surveys_bickerdike_deid'=>array('db'=>'bickerdike', 'query'=>
            "SELECT Users.User_ID, Gender, Age, 
                Zipcode, Race, 
                Question_2, Question_3, 
                Question_4_A, Question_4_B, Question_5_A, Question_5_B, 
                Question_6, Question_7, Question_8,
                Question_9_A, Question_9_B, Question_11, Question_12, 
                Question_13, Question_14, Date_Survey_Administered,
                Pre_Post_Late, Programs.Program_ID, Program_Name, Partner_Name,
                Participant_Type, Child_ID FROM Participant_Survey_Responses
                LEFT JOIN (Programs, Users, Org_Partners)
                ON (Participant_Survey_Responses.User_ID=Users.User_ID
                AND Participant_Survey_Responses.Program_ID=Programs.Program_ID
                AND Programs.Program_Organization=Org_Partners.Partner_ID)
                 WHERE Participant_Type='youth'",
            'titles'=>array("User ID",  "Gender", 
                "Age", "Zipcode", "Race/Ethnicity -- (b) African American, "
                . "(l) Latino, (a) Asian, (w) White, (o) Other", "Question 2 -- "
                . "(1) Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", 
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Program Name", "Program Organization", "Participant Type", 
                "Child ID")),
        
        'parent_children_surveys_bickerdike'=>array('db'=>'bickerdike', 'query'=>
            'SELECT parent_table.User_ID, parent_table.Gender, parent_table.Age, 
                parent_table.Address_Number,
                parent_table.Address_Street_Direction, parent_table.Address_Street_Name, 
                parent_table.Address_Street_Type,
                parent_table.Zipcode, parent_table.Race, Question_2, Question_3, 
                Question_4_A, Question_4_B,
                Question_5_A, Question_5_B, Question_6, Question_7, Question_8, 
                Question_9_A, Question_9_B, 
                Question_11, Question_12, Question_13, Question_14, 
                Date_Survey_Administered, Pre_Post_Late, 
                Programs.Program_ID, Programs.Program_Name, 
                Org_Partners.Partner_Name,
                Participant_Type, child_table.User_ID as child_id, 
                child_table.First_Name as child_first, child_table.Last_Name as child_last,
                child_table.DOB as child_dob, child_table.Gender as child_gender,
                child_table.Age as child_age, child_table.Race as child_race,
                parent_table.First_Name, parent_table.Last_Name
                FROM Users as parent_table, Users as child_table, 
                Participant_Survey_Responses, Programs, Org_Partners     
                WHERE parent_table.User_ID = Participant_Survey_Responses.User_ID 
                AND child_table.User_ID=Participant_Survey_Responses.Child_ID
                AND Participant_Survey_Responses.Program_ID=Programs.Program_ID
                AND Programs.Program_Organization=Org_Partners.Partner_ID;',
            'titles'=>array("User ID", "Gender", "Age", "Address Number", 
                "Street Direction", "Street Name", "Street Type", 
                "Zipcode", "Race/Ethnicity", "Question 2 -- (1) "
                . "Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No"
                . " to (1) Yes", "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date",
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Program Name", "Program Organization", "Participant Type", 
                "Child ID",  "Child First Name", "Child Last Name",  "Child DOB",
                "Child Gender", "Child's Age", "Child Race", "Parent First Name",
                "Parent Last Name")),
        
        'parent_children_surveys_bickerdike_deid'=>array('db'=>'bickerdike', 'query'=>
            'SELECT parent_table.User_ID, parent_table.Gender, parent_table.Age, 
                parent_table.Zipcode, parent_table.Race, Question_2, Question_3, 
                Question_4_A, Question_4_B,
                Question_5_A, Question_5_B, Question_6, Question_7, Question_8, 
                Question_9_A, Question_9_B, 
                Question_11, Question_12, Question_13, Question_14, 
                Date_Survey_Administered, Pre_Post_Late, 
                Programs.Program_ID, Programs.Program_Name, 
                Org_Partners.Partner_Name,
                Participant_Type, child_table.User_ID as child_id, 
                child_table.Gender as child_gender,
                child_table.Age as child_age, child_table.Race as child_race
                FROM Users as parent_table, Users as child_table, 
                Participant_Survey_Responses, Programs, Org_Partners     
                WHERE parent_table.User_ID = Participant_Survey_Responses.User_ID 
                AND child_table.User_ID=Participant_Survey_Responses.Child_ID
                AND Participant_Survey_Responses.Program_ID=Programs.Program_ID
                AND Programs.Program_Organization=Org_Partners.Partner_ID;',
            'titles'=>array("User ID", "Gender", "Age", 
                "Zipcode", "Race/Ethnicity", "Question 2 -- (1) "
                . "Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", 
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Program Name", "Program Organization", "Participant Type", 
                "Child ID",   "Child Gender",
                "Child's Age",  "Child Race" )),
        
        'program_dates_bickerdike'=>array('db'=>'bickerdike', 'query'=>
            'SELECT * FROM Program_Dates INNER JOIN Programs ON '
            . 'Program_Dates.Program_ID=Programs.Program_ID',
            'titles'=>array("ID", "Program ID", "Program Name", "Date")),
        
        'program_attendance_bickerdike'=>array('db'=>'bickerdike', 'query'=>
            'SELECT Program_Dates_Users_ID, Program_Dates.Program_ID, 
                Users.User_ID, Programs.Program_ID, Program_Date, Program_Name,
                First_Name, Last_Name, Gender, Age, Address_Number, 
                Address_Street_Direction,
                Address_Street_Name, Address_Street_Type, Adult, Parent, Child
                FROM Program_Dates_Users LEFT JOIN (Program_Dates, Programs, Users)
                ON (Program_Dates_Users.Program_Date_ID=Program_Dates.Program_Date_ID
                AND Programs.Program_ID=Program_Dates.Program_ID
                AND Program_Dates_Users.User_ID=Users.User_ID)',
            'titles'=>array("ID", "Program Date ID", "User ID", "Program ID", 
                "Program Date", "Program Name", 
                "Participant First Name" , "Participant Last Name", "Gender", 
                "Age", "Address Number", "Street Direction", "Street Name", 
                "Street Type", "Is Adult? 1=Yes, 0=No", "Is Parent? 1=Yes, 0=No", 
                "Is Child? 1=Yes, 0=No")),
        
        'program_attendance_bickerdike_deid'=>array('db'=>'bickerdike', 'query'=>
            'SELECT Program_Dates_Users_ID, Program_Dates.Program_Date_ID, 
                Users.User_ID, Programs.Program_ID,
                Program_Date, Program_Name, Gender, Age, Adult, Parent, Child
                FROM Program_Dates_Users LEFT JOIN (Program_Dates, Programs, Users)
                ON (Program_Dates_Users.Program_Date_ID=Program_Dates.Program_Date_ID
                AND Programs.Program_ID=Program_Dates.Program_ID
                AND Program_Dates_Users.User_ID=Users.User_ID)',
            'titles'=>array("ID", "Program Date ID", "User ID", "Program ID", 
                "Program Date", "Program Name", "Gender", "Age", 
                "Is Adult? 1=Yes, 0=No", "Is Parent? 1=Yes, 0=No", 
                "Is Child? 1=Yes, 0=No")),
        
        'programs_bickerdike'=>array('db'=>'bickerdike', 'query'=>
            'SELECT * FROM Programs', 
            'titles'=>array("ID", "Program Name", "Organization", "Type", 
                "Program Created Date", "Notes")),
        
        'program_participants_bickerdike'=>array('db'=>'bickerdike', 'query'=>
            'SELECT Programs.Program_ID, Users.User_ID, Program_Name, Gender, Age,
            Address_Number, Address_Street_Direction, Address_Street_Name, 
            Address_Street_Type FROM Programs_Users INNER JOIN (Programs, Users)
            ON (Programs_Users.Program_ID=Programs.Program_ID
            AND Programs_Users.User_ID=Users.User_ID)', 
            'titles'=>array("Program ID", "User ID", "Program Name", "Gender", "Age",
                "Address Number", "Street Direction", "Street Name", "Street Type")),
        
        'program_participants_bickerdike_deid'=>array('db'=>'bickerdike', 'query'=>
            'SELECT Programs.Program_ID, Users.User_ID, Program_Name, Gender, 
                Age FROM Programs_Users INNER JOIN (Programs, Users)
                ON (Programs_Users.Program_ID=Programs.Program_ID
                AND Programs_Users.User_ID=Users.User_ID)', 
            'titles'=> array("Program ID", "User ID", "Program Name", "Gender", 
                "Age")),
        
        'health_data_bickerdike'=>array('db'=>'bickerdike', 'query'=>
            'SELECT Users.User_ID, First_Name, Last_Name, Height_Feet, Height_Inches, Weight, 
                BMI, Date, Gender, Age, Address_Number,
                Address_Street_Direction, Address_Street_Name, Address_Street_Type
                FROM User_Health_Data INNER JOIN Users ON 
                Users.User_ID=User_Health_Data.User_ID',
            'titles'=>array("User ID", "First Name", "Last Name", "Height in Feet", 
                "Remaining Height in Inches", "Weight", "BMI", "Date", 
                "Gender", "Age", "Address")),
        
        'health_data_bickerdike_deid'=>array('db'=>'bickerdike', 'query'=>
            'SELECT Users.User_ID, Height_Feet, Height_Inches, Weight, 
                BMI, Date, Gender, Age
                FROM User_Health_Data INNER JOIN Users ON 
                Users.User_ID=User_Health_Data.User_ID',
            'titles'=>array("User ID", "Height in Feet", "Remaining Height in Inches",
                "Weight", "BMI", "Date", "Gender", "Age")),
        
        'all_participants_bickerdike'=>array('db'=>'bickerdike', 'query'=>
            'SELECT * FROM Users',
            'titles'=>array("User ID", "First Name", "Last Name", "Zipcode", 
                "Date of Birth", "Gender", "Age", "Race", "Adult?",
                "Parent?", "Youth?", "Email", "Notes", "Street Number", 
                "Address Street Name", "Street Direction", "Street Type", 
                "Phone Number", "Block Group")),
        
        'all_participants_bickerdike_deid'=>array('db'=>'bickerdike', 'query'=>
            'SELECT User_ID, Zipcode, Gender, Age, Race, Adult, '
            . 'Parent, Child, Block_Group FROM Users',
            'titles'=>array("User ID", "Zipcode", "Gender", "Age", "Race", "Adult?",
                "Parent?", "Youth?", "Block Group")),
        
        'walkability_bickerdike'=>array('db'=>'bickerdike', 'query'=>
            'SELECT * FROM Walkability_Assessment',
            'titles'=>array("ID", "Date", "Do Cars Stop?", "Intersection Assessed",
                "Speed Limit Obeyed?", "Gaps in Sidewalk?", "Crosswalk Painted?")),
        
        'addresses_bickerdike'=>array('db'=>'bickerdike', 'query'=>
            'SELECT User_ID, Address_Number, Address_Street_Direction, 
                Address_Street_Name, Address_Street_Type, Zipcode, Gender, Age
                FROM Users',
            'titles'=>array("User ID", "Address Number", "Street Direction", 
                "Street Name", "Street Type", "Zipcode", "Gender", "Age")),
        
        'addresses_bickerdike_deid'=>array('db'=>'bickerdike', 'query'=>
            'SELECT User_ID, Block_Group, Zipcode, Gender, Age
                FROM Users',
            'titles'=>array("User ID", "Block Group", "Zipcode", "Gender", "Age")),
        
        'grouped_surveys_bickerdike'=>array('db'=>'bickerdike', 'query'=>
            'SELECT First_Name, Last_Name, Pre_Responses.*,
                Mid_Responses.*,
                Post_Responses.*
                FROM Participant_Survey_Responses AS Pre_Responses
                LEFT JOIN Participant_Survey_Responses AS Mid_Responses
                    ON Pre_Responses.User_ID=Mid_Responses.User_ID
                LEFT JOIN Participant_Survey_Responses AS Post_Responses
                    ON Pre_Responses.User_ID=Post_Responses.User_ID
                LEFT JOIN Users ON Pre_Responses.User_ID=Users.User_ID
                    WHERE Pre_Responses.Participant_Survey_ID!=
                        Mid_Responses.Participant_Survey_ID
                    AND Pre_Responses.Pre_Post_Late=1
                    AND Mid_Responses.Pre_Post_Late=2
                    AND Post_Responses.Pre_Post_Late=3',
            'titles'=>array("First Name", "Last Name", "Pre Survey ID Number", 
                "User ID", "Question 2 -- (1) Very important to (4) "
                . "Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", 
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Participant Type", "Child ID",
                "Post Survey ID Number", "User ID", "Question 2 -- (1) "
                . "Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", 
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Participant Type", "Child ID",
                "Followup Survey ID Number", "User ID", "Question 2 -- (1)"
                . " Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", "9b -- "
                . "(1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes",
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Participant Type", "Child ID")),
        
        'grouped_surveys_bickerdike_deid'=>array('db'=>'bickerdike', 'query'=>
            'SELECT Pre_Responses.*,
                Mid_Responses.*,
                Post_Responses.*
                FROM Participant_Survey_Responses AS Pre_Responses
                LEFT JOIN Participant_Survey_Responses AS Mid_Responses
                ON Pre_Responses.User_ID=Mid_Responses.User_ID
                LEFT JOIN Participant_Survey_Responses AS Post_Responses
                ON Pre_Responses.User_ID=Post_Responses.User_ID
                WHERE Pre_Responses.Participant_Survey_ID!=Mid_Responses.Participant_Survey_ID
                AND Pre_Responses.Pre_Post_Late=1
                AND Mid_Responses.Pre_Post_Late=2
                AND Post_Responses.Pre_Post_Late=3',
            'titles'=>array("Pre Survey ID Number", "User ID", "Question 2 -- (1)"
                . " Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes",
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Participant Type", "Child ID",
                "Post Survey ID Number", "User ID", "Question 2 -- (1) "
                . "Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes", 
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Participant Type", "Child ID",
                "Followup Survey ID Number", "User ID", "Question 2 -- (1) "
                . "Very important to (4) Not at all important", "3", "4a",
                "4b", "5a","5b", "Question 6", "7", "8",
                "9a -- (1) Strongly Agree to (4) Strongly Disagree", 
                "9b -- (1) Strongly Agree to (4) Strongly Disagree",
                "Question 11 -- (0) No to (1) Yes", "12 -- (0) No to (1) Yes",
                "13 -- (0) No to (1) Yes",
                "10 (1) Not at all Satisfied to (4) Very satisfied", "Date", 
                "Survey Timing (Pre[1], Post[2], or Late[3])", "Program ID",
                "Participant Type", "Child ID")),
        
        'institutions_lsna'=>array('db'=>'LSNA', 'query'=>
            'SELECT Institution_ID, Institution_Name, Street_Num, Street_Direction,
                Street_Name, Street_Type, Institution_Type_Name FROM Institutions 
                INNER JOIN Institution_Types ON 
                Institutions.Institution_Type=Institution_Types.Institution_Type_ID',
            'titles'=>array("Institution ID", "Institution Name", "Street Number", 
                "Street Direction", "Street Name", 
                "Street Type", "Institution Type")),
            
        'institutions_lsna_deid'=>array('db'=>'LSNA', 'query'=>
            'SELECT Institution_ID, Institution_Name,
                Institution_Type_Name FROM Institutions INNER JOIN 
                Institution_Types ON Institutions.Institution_Type=
                Institution_Types.Institution_Type_ID',
            'titles'=>array("Institution ID", "Institution Name", 
                "Institution Type")),
        
        'pm_attendance_lsna'=>array('db'=>'LSNA', 'query'=>
            'SELECT Parent_Mentor_ID, Num_Days_Attended, Month, Year, 
                Max_Days_Possible, Institution_Name
                FROM PM_Actual_Attendance INNER JOIN PM_Possible_Attendance 
                ON PM_Actual_Attendance.Possible_Attendance_ID=
                PM_Possible_Attendance.PM_Possible_Attendance_ID
                LEFT JOIN Institutions_Participants ON 
                PM_Actual_Attendance.Parent_Mentor_ID=
                Institutions_Participants.Participant_ID
                LEFT JOIN Institutions ON Institutions_Participants.Institution_ID=
                Institutions.Institution_ID WHERE Is_PM=1',
            'titles'=>array("Parent Mentor ID", "Number of Days Attended", 
                "Month", "Year", "Maximum Days Possible", "Institution Name")),
        
        'pm_children_lsna'=>array('db'=>'LSNA', 'query'=>
            'SELECT  child_table.Participant_ID, Quarter, Reading_Grade, Math_Grade,
                Num_Suspensions, Num_Office_Referrals, Days_Absent, 
                child_table.Name_First, child_table.Name_Last, child_table.Age,
                child_table.Gender, child_table.Date_of_Birth,
                child_table.Grade_Level, parent_table.Name_First as parent_name, 
                parent_table.Name_Last as parent_surname,
                spouse_table.Name_First as spouse_name, spouse_table.Name_Last 
                as spouse_surname, PM_Children_Info.* 
                FROM Parent_Mentor_Children 
                LEFT JOIN Participants as child_table ON 
                Parent_Mentor_Children.Child_ID=child_table.Participant_ID
                LEFT JOIN PM_Children_Info ON 
                Parent_Mentor_Children.Child_ID=PM_Children_Info.Child_ID 
                LEFT JOIN Participants as parent_table ON 
                Parent_Mentor_Children.Parent_ID=parent_table.Participant_ID
                LEFT JOIN Participants as spouse_table ON 
                Parent_Mentor_Children.Spouse_ID=spouse_table.Participant_ID',
            'titles'=>array("Child ID", "Quarter", "Reading Grade", "Math Grade",
                "Number of Suspensions", "Number of Office Referrals", 
                "Days Absent", "Child First Name", "Child Last Name", 
                "Child Age", "Child Gender", "Child Date of Birth", 
                "Child Grade Level", "Parent First Name", "Parent Last Name", 
                "Spouse First Name", "Spouse Last Name")),
        
        'pm_children_lsna_deid'=>array('db'=>'LSNA', 'query'=>
            'SELECT  child_table.Participant_ID,  child_table.Ward, 
                child_table.Age, child_table.Gender, child_table.Grade_Level,
                parent_table.Participant_ID as parent_id, PM_Children_Info.* 
                FROM Parent_Mentor_Children LEFT JOIN Participants as child_table 
                ON Parent_Mentor_Children.Child_ID=child_table.Participant_ID
                LEFT JOIN PM_Children_Info ON Parent_Mentor_Children.Child_ID=
                PM_Children_Info.Child_ID 
                LEFT JOIN Participants as parent_table ON 
                Parent_Mentor_Children.Parent_ID=parent_table.Participant_ID;',
            'titles'=>array("Child ID", "Ward", "Age", 
                "Gender", "Grade Level", "Parent ID", "Link ID", 
                "Child ID (repeat)", "Quarter", "Reading Grade", "Math Grade", 
                "Number of Suspensions", "Number of Office Referrals", 
                "Days Absent", "School Year")),
        
        'lsna_teacher_pre_surveys'=>array('db'=>'LSNA', 'query'=>
            'SELECT PM_Teacher_Survey.*, Participants.Name_First, 
                Participants.Name_Last, Institutions.Institution_Name 
                FROM PM_Teacher_Survey INNER JOIN Participants 
                ON PM_Teacher_Survey.Parent_Mentor_ID=Participants.Participant_ID
                LEFT JOIN Institutions ON Institutions.Institution_ID=
                PM_Teacher_Survey.School_Name',
            'titles'=>array("Teacher Survey ID", "School ID", "Teacher Name", 
                "Grade", "Classroom Language", "Years in PM Program", "Languages", 
                "Years as a Teacher", "Years at School", "Number of Students", 
                "Number of English Language Learners" , "Number of IEP Students",
                "Number of students below grade level", "PM Activities Training",
                "Teacher Activities Training", "grade papers",
                "tutor students one on one",
                "lead part of the class in an activity",
                "take children to the washroom etc",
                "help with discipline/disruptions",
                "check homework", "work with small groups of students",
                "lead the whole class in an activity",
                "help organize the classroom", "other", "Task Text",
                'A. Have another teacher or paraprofessional working with you '
                . 'in your classroom?', 
                'B.Have a parent volunteer or parent mentor in your classroom '
                . 'working with students?',
                'C.Talk with at least one school parent face-to-face?',
                'D.Have a conversation with a school parent about something '
                . 'besides their child\'s progress or behavior?', 
                'E.Have time for YOU to work with at least one of your struggling '
                . 'students one-on-one for 10 minutes or more?',
                'F.Have another adult (volunteer or staff) to work with at least'
                . ' one of your struggling students one-on-one for 10 minutes or more?',
                'G.Have time for YOU to work with 4 or more of your struggling '
                . 'students one-on-one for 10 minutes or more?', 
                'H.Have another adult (volunteer or staff) to work with 4 or more '
                . 'of your struggling students one-on-one for 10 minutes or more?',
                'I.Learn something new about the community in which your school '
                . 'is located?',
                'J.Ask a school parent for advice?', 'K.How many school parents '
                . 'did you greet by name?',
                'L.How many school parents do you have phone numbers or emails '
                . 'for besides a school directory?',
                "Parent Mentor ID", "Date Survey Entered",
                "Parent Mentor First Name", "Parent Mentor Last Name", "School Name")),
        
        'lsna_pre_teacher_surveys_deid'=>array('db'=>'LSNA', 'query'=>
            'SELECT PM_Teacher_Survey.*, Institutions.Institution_Name 
                FROM PM_Teacher_Survey INNER JOIN Participants 
                ON PM_Teacher_Survey.Parent_Mentor_ID=Participants.Participant_ID
                LEFT JOIN Institutions ON Institutions.Institution_ID=
                PM_Teacher_Survey.School_Name',
            'titles'=>array("Teacher Survey ID", "School ID", "Teacher ID", 
                "Grade", "Classroom Language", "Years in PM Program", "Languages", 
                "Years as a Teacher", "Years at School", "Number of Students", 
                "Number of English Language Learners" , "Number of IEP Students",
                "Number of students below grade level", "PM Activities Training", 
                "Teacher Activities Training", "grade papers",
                "tutor students one on one", "lead part of the class in an activity",
                "take children to the washroom etc", "help with discipline/disruptions",
                "check homework", "work with small groups of students",
                "lead the whole class in an activity", "help organize the classroom",
                "other", "Task Text",
                'A. Have another teacher or paraprofessional working with you '
                . 'in your classroom?', 
                'B.Have a parent volunteer or parent mentor in your classroom '
                . 'working with students?',
                'C.Talk with at least one school parent face-to-face?',
                'D.Have a conversation with a school parent about something '
                . 'besides their child\'s progress or behavior?', 
                'E.Have time for YOU to work with at least one of your struggling'
                . ' students one-on-one for 10 minutes or more?',
                'F.Have another adult (volunteer or staff) to work with at least'
                . ' one of your struggling students one-on-one for 10 minutes or more?',
                'G.Have time for YOU to work with 4 or more of your struggling '
                . 'students one-on-one for 10 minutes or more?', 
                'H.Have another adult (volunteer or staff) to work with 4 or more'
                . ' of your struggling students one-on-one for 10 minutes or more?',
                'I.Learn something new about the community in which your school '
                . 'is located?',
                'J.Ask a school parent for advice?', 'K.How many school parents '
                . 'did you greet by name?',
                'L.How many school parents do you have phone numbers or emails '
                . 'for besides a school directory?',
                "Parent Mentor ID", "Date Survey Entered",  "School Name")),
        
        'lsna_post_teacher_surveys'=>array('db'=>'LSNA', 'query'=>
            'SELECT PM_Teacher_Survey_Post.*, Participants.Name_First, 
                Participants.Name_Last, Institutions.Institution_Name 
                FROM PM_Teacher_Survey_Post INNER JOIN Participants 
                ON PM_Teacher_Survey_Post.Parent_Mentor_ID=Participants.Participant_ID
                LEFT JOIN Institutions ON Institutions.Institution_ID=
                PM_Teacher_Survey_Post.School_Name',
            'titles'=>array("Teacher Survey ID", "School ID", "Teacher Name", 
                "Grade", "Classroom Language", "Attendance", "grade papers",
                "tutor students one on one", "lead part of the class in an activity",
                "take children to the washroom etc", "help with discipline/disruptions",
                "check homework", "work with small groups of students",
                "lead the whole class in an activity", "help organize the classroom",
                "other", "Task Text", "Majority Task",
                "Having the support of a Parent Mentor helps me achieve or "
                . "maintain good classroom management.",
                " Having the support of a Parent Mentor helps me improve homework"
                . " completion and helps me maintain a high expectatin for homework in my classroom.",
                "Having the support of a Parent Mentor helps me improve students"
                . " in reading and/or math.",
                "Having a Parent Mentor strengthens my understanding of or "
                . "connection to the community.",
                "Having a Parent Mentor strengthens student social-emotional "
                . "development.",
                "The Parent Mentor Program helps our school create a welcoming "
                . "and communicative environment for all parents.",
                "The Parent Mentor Program helps our school build parent-teacher"
                . " trust.",
                "The Parent Mentor Program helps teachers and parents to think "
                . "of each other as partners in educating.",
                "PM Activities Training", "Teacher Activities Training", 
                "Comments",
                'A. Have another teacher or paraprofessional working with you '
                . 'in your classroom?', 
                'B.Have a parent volunteer or parent mentor in your classroom '
                . 'working with students?',
                'C.Talk with at least one school parent face-to-face?',
                'D.Have a conversation with a school parent about something '
                . 'besides their child\'s progress or behavior?', 
                'E.Have time for YOU to work with at least one of your struggling'
                . ' students one-on-one for 10 minutes or more?',
                'F.Have another adult (volunteer or staff) to work with at least'
                . ' one of your struggling students one-on-one for 10 minutes '
                . 'or more?',
                'G.Have time for YOU to work with 4 or more of your struggling '
                . 'students one-on-one for 10 minutes or more?', 
                'H.Have another adult (volunteer or staff) to work with 4 or '
                . 'more of your struggling students one-on-one for 10 minutes or more?',
                'I.Learn something new about the community in which your school '
                . 'is located?',
                'J.Ask a school parent for advice?', 'K.How many school parents'
                . ' did you greet by name?',
                'L.How many school parents do you have phone numbers or emails '
                . 'for besides a school directory?',
                "Parent Mentor ID", "Date Survey Entered", "Explanation for 8", 
                "Explanation for 9", "Explanation for 10",
                "Explanation for 11", "Explanation for 12", "Explanation for 13", 
                "Explanation for 14", "Explanation for 15",
                "Parent Mentor First Name", "Parent Mentor Last Name", "School Name")),
        
         'lsna_post_teacher_surveys_deid'=>array('db'=>'LSNA', 'query'=>
             'SELECT PM_Teacher_Survey_Post.*, Institutions.Institution_Name 
                FROM PM_Teacher_Survey_Post INNER JOIN Participants 
                ON PM_Teacher_Survey_Post.Parent_Mentor_ID=Participants.Participant_ID
                LEFT JOIN Institutions ON Institutions.Institution_ID=
                PM_Teacher_Survey_Post.School_Name',
             'titles'=>array("Teacher Survey ID", "School ID", "Teacher ID", 
                 "Grade", "Classroom Language", "Attendance", "grade papers",
                    "tutor students one on one", "lead part of the class in an activity",
                    "take children to the washroom etc", "help with discipline/disruptions",
                    "check homework", "work with small groups of students",
                    "lead the whole class in an activity", "help organize the classroom",
                    "other", "Task Text", "Majority Task",
                    "Having the support of a Parent Mentor helps me achieve or "
                 . "maintain good classroom management.",
                    " Having the support of a Parent Mentor helps me improve "
                 . "homework completion and helps me maintain a high expectation"
                 . " for homework in my classroom.",
                    "Having the support of a Parent Mentor helps me improve "
                 . "students in reading and/or math.",
                    "Having a Parent Mentor strengthens my understanding of or "
                 . "connection to the community.",
                    "Having a Parent Mentor strengthens student social-emotional"
                 . " development.",
                    "The Parent Mentor Program helps our school create a "
                 . "welcoming and communicative environment for all parents.",
                    "The Parent Mentor Program helps our school build "
                 . "parent-teacher trust.",
                    "The Parent Mentor Program helps teachers and parents to "
                 . "think of each other as partners in educating.",
                    "PM Activities Training", "Teacher Activities Training", 
                    "Comments",
                    'A. Have another teacher or paraprofessional working with you'
                 . ' in your classroom?', 
                    'B.Have a parent volunteer or parent mentor in your classroom'
                 . ' working with students?',
                    'C.Talk with at least one school parent face-to-face?',
                    'D.Have a conversation with a school parent about something '
                 . 'besides their child\'s progress or behavior?', 
                    'E.Have time for YOU to work with at least one of your '
                 . 'struggling students one-on-one for 10 minutes or more?',
                    'F.Have another adult (volunteer or staff) to work with at '
                 . 'least one of your struggling students one-on-one for 10 minutes or more?',
                    'G.Have time for YOU to work with 4 or more of your struggling'
                 . ' students one-on-one for 10 minutes or more?', 
                    'H.Have another adult (volunteer or staff) to work with 4 or '
                 . 'more of your struggling students one-on-one for 10 minutes or more?',
                    'I.Learn something new about the community in which your '
                 . 'school is located?',
                    'J.Ask a school parent for advice?', 'K.How many school parents'
                 . ' did you greet by name?',
                    'L.How many school parents do you have phone numbers or emails'
                 . ' for besides a school directory?',
                    "Parent Mentor ID", "Date Survey Entered", "Explanation for 8", 
                    "Explanation for 9", "Explanation for 10",
                    "Explanation for 11", "Explanation for 12", "Explanation for 13",
                    "Explanation for 14", "Explanation for 15", "School Name")),
        
        'lsna_parent_mentor_surveys'=>array('db'=>'LSNA', 'query'=>
            'SELECT Parent_Mentor_Survey.*, Participants.Name_First, 
                Participants.Name_Last, Institutions.Institution_Name 
                FROM Parent_Mentor_Survey INNER JOIN Participants 
                ON Parent_Mentor_Survey.Participant_ID=Participants.Participant_ID
                LEFT JOIN Institutions ON Institutions.Institution_ID=
                Parent_Mentor_Survey.School',
            'titles'=>array("Survey ID", "Participant ID", "Date", "School ID", 
                "Grade", "Room Number", "First Year Parent Mentor", "Number of Children",
                "Marital Status", "Place of Birth", "Years in IL", 
                "Classes Currently Enrolled In", "Currently Working", 
                "Current Job", "Monthly Income", "On Food Stamps",
                "Rent or Own", "Rent Payment", 'A.Ask your child about school?',
                'B.Talk with your child’s teacher?', 
                'C.Talk with the school principal?',
                'D. Talk with other parents from the school?', 
                'E.Spend time inside the school building?', 
                'F.Spend time inside a classroom?',
                'G.Help your child with schoolwork at home?', 
                'H.Read with your child at home?', 
                'I.How many other parents from the school did you greet by name?',
                'J.How many teachers in the school did you greet by name?', 
                'K.How many school parents do you have phone numbers or emails for?',
                'L.How many teachers do you have phone numbers or emails for?', 
                'M.Attend parent committee meetings?', 'N.Help lead a school committee?',
                'O.Help plan school events activities or initiatives?', 
                'P.Attend a meeting or get involved in a community activity outside of the school?',
                'Q.Share information about the school or the community with '
                . 'other parents in the neighborhood?', 
                'R.Attend a class for yourself?', 'Pre or Post?',
                'Q. I will be able to achieve most of the goals that I have '
                . 'set for myself.', 'R. When facing difficult task I am certain '
                . 'that I will accomplish them.',
                'S. In general I think that I can obtain outcomes that are important '
                . 'to me.', 'T. I believe I can succeed at most any endeavor to which I set my mind.',
                'U. I will be able to successfully overcome many challenges.', 
                'V. I am confident that I can perform effectively on many different tasks.',
                'W. Compared to other people I can do most tasks very well.', 
                'X. Even when things are tough I can perform quite well.', 
                "PM First Name", "PM Last Name", "School Name")),
        
        'lsna_parent_mentor_surveys_deid'=>array('db'=>'LSNA', 'query'=>
            'SELECT Parent_Mentor_Survey.*, Institutions.Institution_Name 
                FROM Parent_Mentor_Survey INNER JOIN Participants 
                ON Parent_Mentor_Survey.Participant_ID=Participants.Participant_ID
                LEFT JOIN Institutions ON Institutions.Institution_ID=
                Parent_Mentor_Survey.School',
            'titles'=>array("Survey ID", "PM ID", "Date", "School ID", "Grade", 
                "Room Number", "First Year Parent Mentor", "Number of Children",
                "Marital Status", "Place of Birth", "Years in IL", 
                "Classes Currently Enrolled In", "Currently Working", 
                "Current Job", "Monthly Income", "On Food Stamps",
                "Rent or Own", "Rent Payment", 'A.Ask your child about school?', 
                'B.Talk with your child’s teacher?', 'C.Talk with the school principal?',
                'D. Talk with other parents from the school?', 
                'E.Spend time inside the school building?', 
                'F.Spend time inside a classroom?',
                'G.Help your child with schoolwork at home?', 
                'H.Read with your child at home?', 
                'I.How many other parents from the school did you greet by name?',
                'J.How many teachers in the school did you greet by name?', 
                'K.How many school parents do you have phone numbers or emails for?',
                'L.How many teachers do you have phone numbers or emails for?',
                'M.Attend parent committee meetings?', 'N.Help lead a school committee?',
                'O.Help plan school events activities or initiatives?', 
                'P.Attend a meeting or get involved in a community activity outside of the school?',
                'Q.Share information about the school or the community with other '
                . 'parents in the neighborhood?', 'R.Attend a class for yourself?',
                'Q. I will be able to achieve most of the goals that I have set '
                . 'for myself.', 'R. When facing difficult task I am certain that '
                . 'I will accomplish them.',
                'S. In general I think that I can obtain outcomes that are '
                . 'important to me.', 'T. I believe I can succeed at most any '
                . 'endeavor to which I set my mind.',
                'U. I will be able to successfully overcome many challenges.', 
                'V. I am confident that I can perform effectively on many different tasks.',
                'W. Compared to other people I can do most tasks very well.', 
                'X. Even when things are tough I can perform quite well.', 
                "School Name")),
        
        'lsna_parent_mentor_years'=>array('db'=>'LSNA', 'query'=>
            'SELECT PM_Year_ID, PM_Years.Participant, PM_Years.School,
                Name_First, Name_Last, Institution_Name, Year FROM PM_Years 
                INNER JOIN Participants ON Participant=Participant_ID
                INNER JOIN Institutions ON School=Institution_ID ORDER BY Name_Last',
            'titles'=>array("ID", "Participant ID", "School ID", 
                "Parent Mentor First Name", "Parent Mentor Last Name", 
                "School Name", "School Year")),
        
        'lsna_parent_mentor_years_deid'=>array('db'=>'LSNA', 'query'=>
            'SELECT PM_Year_ID, PM_Years.Participant, PM_Years.School,
               Institution_Name, Year FROM PM_Years 
               INNER JOIN Participants ON Participant=Participant_ID
               INNER JOIN Institutions ON School=Institution_ID ORDER BY Name_Last',
            'titles'=>array("ID", "Participant ID", "School ID", "School Name", 
                "School Year")),
        
        'lsna_participants'=>array('db'=>'LSNA', 'query'=>
            'SELECT * FROM Participants', 
            'titles'=>array("Participant_ID", "First Name", "Middle Name", 
                "Last Name", "Address Street Name", "Address Street Number", 
                "Address Street Direction", "Address Street Type", "City", "State", 
                "Zipcode", "Daytime Phone", "Evening Phone", "Education Level",
                "Email", "Age", "Gender", "Date of Birth", "Grade Level", 
                "Is Parent Mentor?", "Is a child?", "Notes")),
        
        'lsna_participants_deid'=>array('db'=>'LSNA', 'query'=>
            'SELECT Participant_ID, Education_Level, Age, Gender, Grade_Level, 
                Is_PM, Is_Child FROM Participants',
            'titles'=>array("Participant_ID", "Education Level", "Age", "Gender", 
                "Grade Level", "Is Parent Mentor?", "Child=1; Youth=2; Adult=3 (or blank)")),
        
        'lsna_all_programs_campaigns'=>array('db'=>'LSNA', 'query'=>
            'SELECT Subcategories.Subcategory_ID, Subcategory_Name, 
                Campaign_or_Program, Category_Name FROM Subcategories INNER JOIN
                (Category_Subcategory_Links, Categories) ON (Subcategories.Subcategory_ID
                =Category_Subcategory_Links.Subcategory_ID AND 
                Category_Subcategory_Links.Category_ID=Categories.Category_ID)',
            'titles'=>array("Subcategory_ID", "Subcategory_Name", 
                "Campaign_or_Program", "Category_Name")),
        
        'lsna_young_satisfaction_surveys'=>array('db'=>'LSNA', 'query'=>
            'SELECT Satisfaction_Surveys.*, Name_First, Name_Last, Age, Gender, 
                Subcategory_Name FROM Satisfaction_Surveys INNER JOIN 
                (Subcategories, Participants)ON (Satisfaction_Surveys.Program_ID=
                Subcategories.Subcategory_ID AND Satisfaction_Surveys.Participant_ID=
                Participants.Participant_ID) WHERE Version=3',
            'titles'=>array("Survey ID", "Participant ID", "Program ID", 
                "Question 1", "Question 2", "Question 3", "Question 4", 
                "Question 5", "Question 6", "Question 7", "Question 8", 
                "Question 9", "Question 10", "Question 11", "Ignore this column",
                "Date", "Version", "First Name", "Last Name", "Age", "Gender", 
                "Program Name")),
        
        'lsna_young_satisfaction_surveys_deid'=>array('db'=>'LSNA', 'query'=>
            'SELECT Satisfaction_Surveys.*, Age, Gender, Subcategory_Name FROM 
                Satisfaction_Surveys INNER JOIN (Subcategories, Participants)
                ON (Satisfaction_Surveys.Program_ID=Subcategories.Subcategory_ID
                AND Satisfaction_Surveys.Participant_ID=Participants.Participant_ID)
                WHERE Version=3',
            'titles'=>array("Survey ID", "Participant ID", "Program ID", 
                "Question 1", "Question 2", "Question 3", "Question 4", 
                "Question 5", "Question 6", "Question 7", "Question 8", 
                "Question 9", "Question 10", "Question 11", "Ignore this column",
                "Date", "Version", "Age", "Gender", "Program Name")),
        
        'lsna_older_satisfaction_surveys'=>array('db'=>'LSNA', 'query'=>
            'SELECT Satisfaction_Surveys.*, Name_First, Name_Last, Age, Gender, 
                Subcategory_Name FROM Satisfaction_Surveys INNER JOIN 
                (Subcategories, Participants) ON (Satisfaction_Surveys.Program_ID=
                Subcategories.Subcategory_ID AND Satisfaction_Surveys.Participant_ID
                =Participants.Participant_ID) WHERE Version=4',
            'titles'=>array("Survey ID", "Participant ID", "Program ID", 
                "Question 1", "Question 2", "Question 3", "Question 4", 
                "Question 5", "Question 6", "Question 7", "Question 8", 
                "Question 9", "Question 10", "Question 11", "Question 12", "Date",
                "Version", "First Name", "Last Name", "Age", "Gender", "Program Name")),
        
        'lsna_older_satisfaction_surveys_deid'=>array('db'=>'LSNA', 'query'=>
            'SELECT Satisfaction_Surveys.*, Age, Gender, Subcategory_Name FROM 
                Satisfaction_Surveys INNER JOIN (Subcategories, Participants)
                ON (Satisfaction_Surveys.Program_ID=Subcategories.Subcategory_ID
                AND Satisfaction_Surveys.Participant_ID=Participants.Participant_ID)
                WHERE Version=4',
            'titles'=>array("Survey ID", "Participant ID", "Program ID", 
                "Question 1", "Question 2", "Question 3", "Question 4", "Question 5",
                "Question 6", "Question 7", "Question 8", "Question 9", "Question 10",
                "Question 11", "Question 12", "Date", "Version", "Age", "Gender",
                "Program Name")),
        
        'lsna_campaign_attendance'=>array('db'=>'LSNA', 'query'=>
            'SELECT Subcategory_Attendance.Participant_ID, Type_of_Participation,
                Date, Activity_Name, Activity_Type, Subcategory_Name, 
                Campaign_or_Program, Name_First, Name_Last FROM Subcategory_Attendance
                INNER JOIN (Subcategory_Dates, Subcategories, Participants) ON 
                (Subcategory_Attendance.Subcategory_Date=
                Subcategory_Dates.Wright_College_Program_Date_ID
                AND Subcategory_Dates.Subcategory_ID=Subcategories.Subcategory_ID
                AND Subcategory_Attendance.Participant_ID=
                Participants.Participant_ID)',
            'titles'=>array("Participant ID", "Type of Participation", "Date", 
                "Activity Name", "Activity Type", "Program/Campaign Name", 
                "Campaign or Program",  "First Name", "Last Name")),
        
        'lsna_campaign_attendance_deid'=>array('db'=>'LSNA', 'query'=>
            'SELECT Subcategory_Attendance.Participant_ID, Type_of_Participation,
                Date, Activity_Name, Activity_Type,
                Subcategory_Name, Campaign_or_Program  FROM Subcategory_Attendance
                INNER JOIN (Subcategory_Dates, Subcategories, Participants) ON 
                (Subcategory_Attendance.Subcategory_Date=Subcategory_Dates.Wright_College_Program_Date_ID
                AND Subcategory_Dates.Subcategory_ID=Subcategories.Subcategory_ID
                AND Subcategory_Attendance.Participant_ID=Participants.Participant_ID)',
            'titles'=>array("Participant ID", "Type of Participation", "Date", 
                "Activity Name", "Activity Type", "Program/Campaign Name", 
                "Campaign or Program")),
        
        'lsna_campaign_events'=>array('db'=>'LSNA', 'query'=>
            'SELECT Date, Activity_Name, Activity_Type,
                Subcategory_Name FROM Subcategory_Dates INNER JOIN (Subcategories)
                ON Subcategory_Dates.Subcategory_ID=Subcategories.Subcategory_ID
                WHERE Campaign_or_Program="Campaign"',
            'titles'=>array("Date", "Event Name", "Event Type", "Campaign Name")),
        
        'lsna_school_records'=>array('db'=>'LSNA', 'query'=>
            'SELECT PM_Children_Info.*, Name_First, Name_Last, Gender, Age, 
                Grade_Level FROM PM_Children_Info INNER JOIN Participants ON 
                Participants.Participant_ID=PM_Children_Info.Child_ID',
            'titles'=>array("Information ID", "Child ID", "Quarter", "Reading Grade",
                "Math Grade", "Number of Suspensions", "Number of Office Referrals",
                "Days Absent", "School Year", "First Name", "Last Name", "Gender",
                "Age", "Grade Level")),
        
        'lsna_school_records_deid'=>array('db'=>'LSNA', 'query'=>
            'SELECT PM_Children_Info.*, Gender, Age, 
                Grade_Level FROM PM_Children_Info INNER JOIN Participants
                ON Participants.Participant_ID=PM_Children_Info.Child_ID',
            'titles'=>array("Information ID", "Child ID", "Quarter", 
                "Reading Grade", "Math Grade", "Number of Suspensions", 
                "Number of Office Referrals", "Days Absent", "School Year",
                "Gender", "Age", "Grade Level")),
        
        'lsna_event_attendance'=>array('db'=>'LSNA', 'query'=>
            'SELECT Issue_Attendance_ID, Name_First, Name_Last, Phone_Day, 
                Phone_Evening, Month, Year, Issue_Area FROM Issue_Attendance 
                LEFT JOIN Issue_Areas ON Issue_Attendance.Issue_ID=Issue_Areas.Issue_ID
                LEFT JOIN Participants ON Issue_Attendance.Participant_ID=
                Participants.Participant_ID',
            'titles'=>array("Information ID", "Person Name", "", "Person Contact",
                "", "Month", "Year", "Issue Area Event Type")),
        
        'lsna_event_attendance_deid'=>array('db'=>'LSNA', 'query'=>
            'SELECT Issue_Attendance_ID, Participant_ID, Month, Year, Issue_Area
                FROM Issue_Attendance LEFT JOIN Issue_Areas ON 
                Issue_Attendance.Issue_ID=Issue_Areas.Issue_ID',
            'titles'=>array("Information ID", "Person ID", "Month", "Year", 
                "Issue Area Event Type"))
        
        );
    $db_array=array(2=>'LSNA', 3=>'bickerdike', 4=>'TRP', 5=>'SWOP', 6=>'enlace');
    if (array_key_exists($download_name, $download_list_array)){
    if (isset($_COOKIE['user'])){
        //add a couple lines here to check the privileges, so we know whether
        //this person is authorized to view given exports
        
        /* ALERT: This query depends on the user cookie having single quotes already
         * saved inside it.  This was a bug which has already been fixed on master,
         * I believe.
         * In this branch, it hasn't been fixed (apparently?), and this query 
         * will need to be fixed when we merge. 
         */
        $get_privileges_sqlsafe="SELECT Privilege_ID FROM Users_Privileges"
                . " LEFT JOIN Users ON Users_Privileges.User_ID=Users.User_ID WHERE "
                . "User_Email=" . $_COOKIE['user'] . "";
        include "dbconnopen.php";
        $privilege_set=mysqli_query($cnnLISC, $get_privileges_sqlsafe);
        $accesses=array();
        while ($privilege=mysqli_fetch_row($privilege_set)){
            $accesses[]=$privilege[0];
        }
        $get_db_id=array_search($download_list_array[$download_name]['db'], $db_array);
        echo "This is the DB ID: " . $get_db_id; //testing output
        $has_permission=array_search($get_db_id, $accesses);
        //if their permissions include the db for this download 
        if ($has_permission){       
        
        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$download_name . '.csv');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // output the column headings
        fputcsv($output, $download_list_array[$download_name]['titles']);

        // fetch the data
        $conn_file='../' . $download_list_array[$download_name]['db']
                . '/include/dbconnopen.php';
        include $conn_file;
        $db_name= 'cnn' . ucfirst($download_list_array[$download_name]['db']);
        $database_conn=$$db_name;
        $query_sqlsafe=$download_list_array[$download_name]['query'];
        $rows = mysqli_query($database_conn, $query_sqlsafe);
        
        // loop over the rows, outputting them
        while ($row = mysqli_fetch_row($rows)) {
            fputcsv($output, $row);}
        

        exit;
        }
        else{
            echo "You do not have permission to download this file.";
            exit;
        }
    }
    else{
        include "error.html";
        exit;
    }
    }
    {
        echo "This key does not exist.";
        //create a new error page?  This should only happen when someone has
        //done something nefarious.
    }
}
generalized_download($_GET['download_name']);
//generalized_download('aldermans_records');
?>