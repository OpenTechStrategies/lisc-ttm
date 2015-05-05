<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
//takes as arguments the query, database connection and database connection
//file, column headers, and file name.

//code drawn from tutorial at:
// http://code.stephenmorley.org/php/creating-downloadable-csv-files/

function generalized_download($download_name, $permissions){
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
                as spouse_surname
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
        
        'lsna_teacher_pre_surveys_deid'=>array('db'=>'LSNA', 'query'=>
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
        
        'lsna_teacher_post_surveys'=>array('db'=>'LSNA', 'query'=>
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
        
         'lsna_teacher_post_surveys_deid'=>array('db'=>'LSNA', 'query'=>
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
            'SELECT Participant_ID, Name_First, Name_Middle, Name_Last, '
            . 'Address_Street_Name, Address_Street_Num, Address_Street_Direction, '
            . 'Address_Street_Type, Address_City, Address_State, Address_Zip, '
            . 'Phone_Day, Phone_Evening, Education_Level, Email, Age, Gender, '
            . 'Date_of_Birth, Consent_2013_14, Consent_2014_15, Consent_2015_16, '
            . 'Grade_Level, Is_PM, Is_Child, Notes FROM Participants', 
            'titles'=>array("Participant_ID", "First Name", "Middle Name", 
                "Last Name", "Address Street Name", "Address Street Number", 
                "Address Street Direction", "Address Street Type", "City", "State", 
                "Zipcode", "Daytime Phone", "Evening Phone", "Education Level",
                "Email", "Age", "Gender", "Date of Birth", 
                "Consent 2013-14?", "Consent 2014-15?", "Consent 2015-16?",
                "Grade Level", "Is Parent Mentor?", "Is a child?", "Notes")),
        
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
                "Issue Area Event Type")),
        
        'enlace_events'=>array('db'=>'enlace', 'query'=>
            'SELECT Event_Name, Event_Date, Address_Num, Address_Dir, Address_Street,
                Address_Suffix, Event_Types.Type, Note_File_Name, Campaign_Name
                FROM Campaigns_Events LEFT JOIN Campaigns ON Campaigns.Campaign_ID
                = Campaigns_Events.Campaign_ID
                LEFT JOIN Event_Types ON Campaigns_Events.Type = Event_Type_ID',
            'titles'=>array("Event_Name", "Event_Date", "Address_Num", 
                "Address_Dir", "Address_Street", "Address_Suffix", "Event Type",
                "File_Name of upload", "Campaign_Name")),
        
        'enlace_inst_campaigns'=>array('db'=>'enlace', 'query'=>
            'SELECT Campaign_Name, Institution_Name FROM Campaigns_Institutions
                INNER JOIN Campaigns ON Campaigns_Institutions.Campaign_ID = 
                Campaigns.Campaign_ID
                INNER JOIN Institutions ON Institution_ID = Inst_ID',
            'titles'=>array("Campaign_Name", "Institution Name")),
        
        'enlace_campaigns'=>array('db'=>'enlace', 'query'=>
            'SELECT * FROM Campaigns',
        'titles'=>array("Campaign ID", "Campaign_Name")), //what about access bit??
        
        'enlace_institutions_deid'=>array('db'=>'enlace', 'query'=>
            'SELECT Institution_Name, Type, Block_Group, Phone, Email 
            FROM Institutions INNER JOIN Institution_Types
            ON Institution_Type = Inst_Type_ID',
            'titles'=>array("Institution Name", "Institution Type", "Block Group",
            "Phone", "Email")),

        
        'enlace_participants'=>array('db'=>'enlace', 'query'=>
        'SELECT Participants.Participant_ID, First_Name, Last_Name, Day_Phone, Evening_Phone, Participants.Address_Num, Participants.Address_Dir, Participants.Address_Street, Participants.Address_Street_Type, Address_City, Address_State, Address_ZIP, DOB, Age, Gender, Grade, Institution_Name, Roles.Role, Participants.Email FROM Participants LEFT JOIN Roles ON Participants.Role = Roles.Role_ID LEFT JOIN Institutions ON School = Inst_ID', 
        'non_admin_string' => ' LEFT JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID WHERE Programs.Program_ID = ',
        'add_access' => '1',
        'titles' => array("Participant ID", "First_Name", "Last_Name", "Day_Phone", "Evening_Phone", "Address Number", "Address Direction", "Address Street Name", "Address Street Type", "Address_City", "Address_State", "Address_ZIP", "DOB", "Age", "Gender", "Grade", "School", "Role", "Email")), 

        'enlace_participants_deid'=>array('db'=>'enlace', 'query'=>
        'SELECT Participants.Participant_ID,  Address_City, Address_State, Address_ZIP,
                            Age, Gender, Grade, Institution_Name, Roles.Role
                            FROM Participants
                            LEFT JOIN Roles ON Participants.Role = Roles.Role_ID
                            LEFT JOIN Institutions ON School = Inst_ID',
        'non_admin_string' => ' LEFT JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID WHERE Programs.Program_ID = ',
        'add_access' => '1',
        'titles' => array("Participant ID",  "Address_City", "Address_State", "Address_ZIP",
            "Age", "Gender", "Grade", "School", "Role")),
        
        
        'enlace_intake_assessments'=>array('db'=>'enlace', 'query'=>
        'SELECT Assessment_ID, Assessments.Participant_ID, Participants.First_Name, Participants.Last_Name, Assessments.Pre_Post, Assessments.Date_Logged, BYS_1, BYS_2, BYS_3, BYS_4, BYS_5, BYS_6, BYS_7, BYS_8, BYS_9, BYS_E, BYS_T, JVQ_1, JVQ_2, JVQ_3, JVQ_4, JVQ_5, JVQ_6, JVQ_7, JVQ_8, JVQ_9, JVQ_E, JVQ_T, JVQ_12, US_Born, Check_In, Know_You, Compliment, Crisis_Help, Pay_Attention, KnowImportance, Personal_Advice, Upset_Discussion, Friends, Finish_HS, Stay_Safe, Alive_Well, Happy_Life, Manage_Work, Proud_Parents, Solve_Problems, Interesting_Life, Coping, Cowardice, Self_Care, Anger_Mgmt, Negotiation, Self_Defense, Handle_Others, Self_Awareness, Parent_Approval, Parent_Disapproval, Teasing_Prevention FROM Assessments LEFT JOIN Participants_Baseline_Assessments ON Baseline_Assessment_ID = Baseline_ID LEFT JOIN Participants_Caring_Adults ON Caring_ID = Caring_Adults_ID LEFT JOIN Participants_Future_Expectations ON Future_Id = Future_Expectations_ID LEFT JOIN Participants_Interpersonal_Violence ON Violence_ID = Interpersonal_Violence_ID LEFT JOIN Participants ON Assessments.Participant_Id = Participants.Participant_ID ', 
        'non_admin_string' => 'LEFT JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID',
        'non_admin_string2' => ' AND Session_Names.Program_ID = ',
        'add_access' => 1,
        'query2' => ' WHERE Assessments.Pre_Post = 1 ',
        'titles' => array("Assessment ID", "Participant ID", "First_Name", "Last_Name", "Pre or Post", "Date Logged"),
        'legend' => array("(id)", "(id)", "(name)", "(name)", "(pre or post)", "(date)")),

        'enlace_intake_assessments_deid'=>array('db'=>'enlace', 'query'=>
        'SELECT Assessment_ID, Assessments.Participant_ID, Assessments.Pre_Post, Assessments.Date_Logged, BYS_1, BYS_2, BYS_3, BYS_4, BYS_5, BYS_6, BYS_7, BYS_8, BYS_9, BYS_E, BYS_T, JVQ_1, JVQ_2, JVQ_3, JVQ_4, JVQ_5, JVQ_6, JVQ_7, JVQ_8, JVQ_9, JVQ_E, JVQ_T, JVQ_12, US_Born, Check_In, Know_You, Compliment, Crisis_Help, Pay_Attention, KnowImportance, Personal_Advice, Upset_Discussion, Friends, Finish_HS, Stay_Safe, Alive_Well, Happy_Life, Manage_Work, Proud_Parents, Solve_Problems, Interesting_Life, Coping, Cowardice, Self_Care, Anger_Mgmt, Negotiation, Self_Defense, Handle_Others, Self_Awareness, Parent_Approval, Parent_Disapproval, Teasing_Prevention FROM Assessments LEFT JOIN Participants_Baseline_Assessments ON Baseline_Assessment_ID = Baseline_ID LEFT JOIN Participants_Caring_Adults ON Caring_ID = Caring_Adults_ID LEFT JOIN Participants_Future_Expectations ON Future_Id = Future_Expectations_ID LEFT JOIN Participants_Interpersonal_Violence ON Violence_ID = Interpersonal_Violence_ID LEFT JOIN Participants ON Assessments.Participant_Id = Participants.Participant_ID ',        
        'non_admin_string' => 'LEFT JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID',
        'non_admin_string2' => ' AND Session_Names.Program_ID = ',
        'add_access' => 1,
        'query2' => ' WHERE Assessments.Pre_Post = 1 ',
        'titles' => array("Assessment ID", "Participant ID", "Pre or Post", "Date Logged"),
        'legend' => array("(id)", "(id)", "(pre or post)", "(date)")),


        'enlace_impact_surveys'=>array('db'=>'enlace', 'query'=>
        'SELECT Assessment_ID, Assessments.Participant_ID, Participants.First_Name, Participants.Last_Name, Assessments.Pre_Post, Assessments.Date_Logged, Check_In, Know_You, Compliment, Crisis_Help, Pay_Attention, KnowImportance, Personal_Advice, Upset_Discussion, Friends, Finish_HS, Stay_Safe, Alive_Well, Happy_Life, Manage_Work, Proud_Parents, Solve_Problems, Interesting_Life, Coping, Cowardice, Self_Care, Anger_Mgmt, Negotiation, Self_Defense, Handle_Others, Self_Awareness, Parent_Approval, Parent_Disapproval, Teasing_Prevention FROM Assessments LEFT JOIN Participants_Caring_Adults ON Caring_ID = Caring_Adults_ID LEFT JOIN Participants_Future_Expectations ON Future_Id = Future_Expectations_ID LEFT JOIN Participants_Interpersonal_Violence ON Violence_ID = Interpersonal_Violence_ID LEFT JOIN Participants ON Assessments.Participant_Id = Participants.Participant_ID ',
        'non_admin_string' => ' LEFT JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID',
        'non_admin_string2' => ' AND Session_Names.Program_ID = ',
        'add_access' => 1,
        'query2' => ' WHERE Assessments.Pre_Post = 2 ',
        'titles' => array("Assessment ID", "Participant ID", "First Name", "Last Name", "Pre or Post", "Date Logged"),
        'legend' => array("(id)", "(id)", "(name)", "(name)", "(pre or post)", "(date)")),

        'enlace_impact_surveys_deid'=>array('db'=>'enlace', 'query'=>
        'SELECT Assessment_ID, Assessments.Participant_ID, Assessments.Pre_Post, Assessments.Date_Logged, Check_In, Know_You, Compliment, Crisis_Help, Pay_Attention, KnowImportance, Personal_Advice, Upset_Discussion, Friends, Finish_HS, Stay_Safe, Alive_Well, Happy_Life, Manage_Work, Proud_Parents, Solve_Problems, Interesting_Life, Coping, Cowardice, Self_Care, Anger_Mgmt, Negotiation, Self_Defense, Handle_Others, Self_Awareness, Parent_Approval, Parent_Disapproval, Teasing_Prevention FROM Assessments LEFT JOIN Participants_Caring_Adults ON Caring_ID = Caring_Adults_ID LEFT JOIN Participants_Future_Expectations ON Future_Id = Future_Expectations_ID LEFT JOIN Participants_Interpersonal_Violence ON Violence_ID = Interpersonal_Violence_ID LEFT JOIN Participants ON Assessments.Participant_Id = Participants.Participant_ID ',
        'non_admin_string' => ' LEFT JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID ',
        'non_admin_string2' => ' AND Session_Names.Program_ID = ',
        'add_access' => 1,
        'query2' => ' WHERE Assessments.Pre_Post = 2 ',
        'titles' => array("Assessment ID", "Participant ID", "Pre or Post", "Date Logged"),
        'legend' => array("(id)", "(id)", "(pre or post)", "(date)")),



        'enlace_consent_records'=>array('db'=>'enlace', 'query'=>
            'SELECT Participants_Consent.Participant_ID, First_Name, Last_Name, School_Year, Consent_Given, Institution_Name FROM Participants_Consent INNER JOIN Participants ON Participants.Participant_ID=Participants_Consent.Participant_ID INNER JOIN Institutions ON School=Inst_ID',
        'titles' => array("Participant_ID", "First_Name", "Last_Name", "School_Year", "Consent_Given (1=Yes, 0=No)", "School")),

        'enlace_consent_records_deid'=>array('db'=>'enlace', 'query'=>
        'SELECT Participants_Consent.Participant_ID, School_Year, Consent_Given, Institution_Name FROM Participants_Consent INNER JOIN Participants ON Participants.Participant_ID=Participants_Consent.Participant_ID INNER JOIN Institutions ON School=Inst_ID',
        'titles' => array("Participant_ID", "School_Year", "Consent_Given (1=Yes, 0=No)", "School")),

        'enlace_event_attendance'=>array('db'=>'enlace', 'query'=>
        'SELECT Event_Name, Event_Date, Participants_Events.Participant_ID, First_Name, Last_Name, Event_Roles.Role FROM Participants_Events INNER JOIN Participants ON Participants.Participant_ID=Participants_Events.Participant_ID INNER JOIN Event_Roles ON Role_Type=Event_Role_ID INNER JOIN Campaigns_Events ON Event_ID=Campaign_Event_ID',
        'titles' => array("Event Name", "Event Date", "Participant ID", "First_Name", "Last_Name", "Role")),

        'enlace_event_attendance_deid'=>array('db'=>'enlace', 'query'=>
        'SELECT Event_ID, Event_Name, Event_Date, Participants.Participant_ID, Event_Roles.Role FROM Participants_Events INNER JOIN Participants ON Participants.Participant_ID=Participants_Events.Participant_ID INNER JOIN Event_Roles ON Role_Type=Event_Role_ID INNER JOIN Campaigns_Events ON Event_ID=Campaign_Event_ID',
        'titles' => array("Event ID", "Event Name", "Event Date", "Participant ID", "Role")),

        'enlace_mentorship_hours'=>array('db'=>'enlace', 'query'=>        
        'SELECT Participant_ID, Mentorship_Date, Mentorship_Hours_Logged, First_Name, Last_Name, Name FROM Participants_Mentorship INNER JOIN Participants ON Participant_ID=Mentee_ID INNER JOIN Programs ON Program_Id=Mentorship_Program',
        'titles' => array("Participant ID", "Mentorship Date", "Mentorship Hours", "First_Name", "Last_Name", "Program")),

        'enlace_mentorship_hours_deid'=>array('db'=>'enlace', 'query'=>        
        'SELECT Participant_ID, Mentorship_Date, Mentorship_Hours_Logged, Name FROM Participants_Mentorship INNER JOIN Participants ON Participant_ID=Mentee_ID INNER JOIN Programs ON Program_Id=Mentorship_Program',
        'titles' => array("Participant ID", "Mentorship Date", "Mentorship Hours", "Program")),

        'enlace_programs'=>array('db'=>'enlace', 'query'=> 
        'SELECT Programs.*, Institution_Name FROM Programs LEFT JOIN Institutions ON Host=Inst_ID',
        'titles' => array("Program ID", "Program Name", "Host Organization ID", "Start Date", "End Date", "Start Hour", "Start am/pm", "End Hour", "End am/pm", "Maximum Hours", "Classwork?", "Clinic?", "Referrals?", "Community?", "Counseling?", "Sports?", "Mentorship?", "Service?", "Mondays?", "Tuesdays?", "Wednesdays?", "Thursdays?", "Fridays?", "Saturdays?", "Sundays?", "Host Institution Name")),

        'enlace_program_participation'=>array('db'=>'enlace', 'query'=> 
        'SELECT DISTINCT Participant_Program_ID, Participants_Programs.Participant_ID, First_Name, Last_Name, Session_Name, Name, Date_Dropped FROM Participants_Programs INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_Names.Session_ID INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID',
        'titles' => array("Participant_Program Link ID", "Participant ID", "First_Name", "Last_Name", "Session", "Program", "Date Dropped")),

        'enlace_program_participation_deid'=>array('db'=>'enlace', 'query'=> 
        'SELECT DISTINCT Participant_Program_ID, Participants_Programs.Participant_ID,  Session_Name, Name, Date_Dropped FROM Participants_Programs INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_Names.Session_ID INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID',
        'titles' => array("Participant_Program Link ID", "Participant ID", "Session", "Program", "Date Dropped")),

        'enlace_session_attendance'=>array('db'=>'enlace', 'query'=> 
        'SELECT Participants_Programs.Participant_ID, First_Name, Last_Name, Date_Listed, Session_Name, Name, Absence_ID FROM Participants_Programs INNER JOIN Program_Dates ON Participants_Programs.Program_ID=Program_Dates.Program_ID INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_Names.Session_ID INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID LEFT JOIN Absences ON ( Program_Date_ID=Program_Date AND Participants_Programs.Participant_ID= Absences.Participant_ID)',
        'non_admin_string' => '  ',
        'non_admin_string2' => ' AND Session_Names.Program_ID = ',
        'query2' => ' WHERE Participants_Programs.Participant_Program_ID IS NOT NULL ',
        'add_access' => 1,
        'titles' => array("Participant ID", "First_Name", "Last_Name", "Date_Listed", "Session_Name", "Program", "Present (NULL) or Absent (some number)")),

        'enlace_session_attendance_deid'=>array('db'=>'enlace', 'query'=> 
        'SELECT Participants_Programs.Participant_ID, Date_Listed, Session_Name, Name, Absence_ID FROM Participants_Programs INNER JOIN Program_Dates ON Participants_Programs.Program_ID=Program_Dates.Program_ID INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_Names.Session_ID INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID LEFT JOIN Absences ON ( Program_Date_ID=Program_Date AND Participants_Programs.Participant_ID= Absences.Participant_ID)', 
        'non_admin_string' => '  ',
        'non_admin_string2' => ' AND Session_Names.Program_ID = ',
        'query2' => ' WHERE Participants_Programs.Participant_Program_ID IS NOT NULL ',
        'add_access' => 1,
        'titles' => array("Participant ID", "Date_Listed", "Session_Name", "Program", "Present (NULL) or Absent (some number)")), 

        'enlace_session_surveys'=>array('db'=>'enlace', 'query'=> 
'SELECT Program_Surveys.*, Session_Name, Name FROM Program_Surveys inner join Session_Names ON Program_Surveys.Session_ID=Session_Names.Session_ID INNER JOIN Programs ON Programs.Program_ID=Session_Names.Program_ID', 
        'non_admin_string' => '  ',
        'non_admin_string2' => ' AND Session_Names.Program_ID = ',
        'query2' => ' WHERE Program_Surveys.Program_Survey_ID IS NOT NULL ',
        'add_access' => 1,
        'titles' => array("Participant_Program Link ID", "Program ID", "Question 1", "Question 2", "Question 3", "Question 4", "Question 5", "Question 6", "Question 7", "Question 8", "Question 9", "Question 10", "Question 11", "Question 12", "Question 13", "Question 14", "Question 15", "Question 16", "Date Added", "Session ID", "Session", "Program")),

        'enlace_sessions'=>array('db'=>'enlace', 'query'=> 
'SELECT Session_Names.*, Name FROM Session_Names
INNER JOIN Programs ON Programs.Program_Id=Session_Names.Program_ID',
        'non_admin_string' => '  ',
        'non_admin_string2' => ' AND Session_Names.Program_ID = ',
        'query2' => ' WHERE Program_Surveys.Program_Survey_ID IS NOT NULL ',
        'add_access' => 1,
        'titles' => array("Session ID", "Session Name", "Program  ID", "Start Date", "End Date", "Survey Due Date", "Program")),
        
        'enlace_referrals'=>array('db'=>'enlace', 'query'=> 
'SELECT Referral_ID, Referrals.Participant_ID, referrees.First_Name, referrees.Last_Name, referrers.First_Name, referrers.Last_Name, Institution_Name, origin.Name, destination.Name, Referrals.Date_Logged FROM Referrals LEFT JOIN Participants AS referrees ON Referrals.Participant_Id=referrees.Participant_ID LEFT JOIN Participants AS referrers ON Referrals.Referrer_Person=referrers.Participant_ID LEFT JOIN Institutions ON Referrer_Institution=Inst_ID LEFT JOIN Programs as origin ON Referrer_Program=origin.Program_ID LEFT JOIN Programs as destination ON Program_Referred=destination.Program_ID', 
'titles' => array("Referral ID", "ID of referred person", "First name of referred person", "Last name of referred person", "Referrer First Name", "Referrer Last Name", "Referring Institution", "Referring Program", "Program referred to", "Date Logged")),

        'enlace_referrals_deid'=>array('db'=>'enlace', 'query'=>
        'SELECT Referral_ID, Referrals.Participant_ID, referrers.Participant_ID, Institution_Name, origin.Name, destination.Name, Referrals.Date_Logged FROM Referrals LEFT JOIN Participants AS referrees ON Referrals.Participant_Id=referrees.Participant_ID LEFT JOIN Participants AS referrers ON Referrals.Referrer_Person=referrers.Participant_ID LEFT JOIN Institutions ON Referrer_Institution=Inst_ID LEFT JOIN Programs as origin ON Referrer_Program=origin.Program_ID LEFT JOIN Programs as destination ON Program_Referred=destination.Program_ID',
        'titles' => array("Referral ID", "ID of referred person", "Referrer (person) ID", "Referring Institution", "Referring Program", "Program referred to", "Date Logged")),

        'enlace_participant_dosage' => array('db'=>'enlace', 'query'=> 
        'SELECT Participants_Programs.Participant_ID, Session_ID, First_Name, Last_Name, Programs.Program_ID, Name, Session_Name FROM Participants_Programs INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_Names.Session_ID INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID',
        'non_admin_string' => 'WHERE Session_Names.Program_ID = ',
        'add_access' => '1',
        'query2' => ' GROUP BY Session_ID, Participants.Participant_ID',
        'titles' => array("Participant ID", "Session ID", "First Name", "Last Name", "Program ID", "Program Name", "Session Name", "Number of days attended", "Sum of hours for this session", "Dosage percentage for this session")),

        'enlace_participant_dosage_deid' => array('db'=>'enlace', 'query'=> 
        'SELECT Participants_Programs.Participant_ID,  Session_ID, Programs.Program_ID, Name, Session_Name FROM Participants_Programs INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_Names.Session_ID INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID',
        'query2' => ' GROUP BY Session_ID, Participants.Participant_ID',
        'titles' => array("Participant ID", "Session ID", "Program ID", "Program Name",  "Session Name",
                "Number of days attended",
        "Sum of hours for this session", "Dosage percentage for this session")),

        'enlace_total_dosage' => array('db' => 'enlace', 'query' => 'SELECT Participant_ID, First_Name, Last_Name FROM Participants', 
        'non_admin_string' => ' LEFT JOIN Participants_Programs on Participants.Participant_ID = Participants_Programs.Participant_ID INNER JOIN Session_Names on Participants_Programs.Program_ID = Session_Names.Session_ID ',
        'non_admin_string2' => ' AND Session_Names.Program_ID = ',
        'query2' => ' WHERE Participants.Participant_ID IS NOT NULL ',
        'add_access' => 1,
        'titles' => array("Participant ID", "First Name", "Last Name", "Total Dosage Hours")),

        'enlace_total_dosage_deid' => array('db' => 'enlace', 'query' => 'SELECT Participant_ID FROM Participants', 
        'non_admin_string' => ' LEFT JOIN Participants_Programs on Participants.Participant_ID = Participants_Programs.Participant_ID INNER JOIN Session_Names on Participants_Programs.Program_ID = Session_Names.Session_ID ',
        'non_admin_string2' => ' AND Session_Names.Program_ID = ',
        'query2' => ' WHERE Participants.Participant_ID IS NOT NULL ',
        'add_access' => 1,
        'titles' => array("Participant ID", "Total Dosage Hours")),


        'enlace_new_surveys' => array('db'=>'enlace', 'query'=> 
        'SELECT  Pre_Assessments.Participant_ID, First_Name, Last_Name, Pre_Caring.Program, Session_Names.Session_Name, Programs.Name, Pre_Assessments.Date_Logged, Post_Assessments.Date_Logged, Home_Language, Ethnicity, Race, BYS_1, BYS_2, BYS_3, BYS_4, BYS_5, BYS_6, BYS_7, BYS_8, BYS_9, BYS_E, BYS_T, JVQ_1, JVQ_2, JVQ_3, JVQ_4, JVQ_5, JVQ_6, JVQ_7, JVQ_8, JVQ_9, JVQ_E, JVQ_T, JVQ_12, US_Born, Pre_Caring.Check_In, Pre_Caring.Know_You, Pre_Caring.Compliment, Pre_Caring.Crisis_Help, Pre_Caring.Pay_Attention, Pre_Caring.KnowImportance, Pre_Caring.Personal_Advice, Pre_Caring.Upset_Discussion, Pre_Future.Friends, Pre_Future.Finish_HS, Pre_Future.Stay_Safe,  Pre_Future.Alive_Well, Pre_Future.Happy_Life, Pre_Future.Manage_Work, Pre_Future.Proud_Parents, Pre_Future.Solve_Problems, Pre_Future.Interesting_Life, Pre_Violence.Coping, Pre_Violence.Cowardice, Pre_Violence.Self_Care, Pre_Violence.Anger_Mgmt, Pre_Violence.Negotiation, Pre_Violence.Self_Defense, Pre_Violence.Handle_Others, Pre_Violence.Self_Awareness, Pre_Violence.Parent_Approval, Pre_Violence.Parent_Disapproval, Pre_Violence.Teasing_Prevention, Post_Caring.Check_In, Post_Caring.Know_You, Post_Caring.Compliment, Post_Caring.Crisis_Help, Post_Caring.Pay_Attention, Post_Caring.KnowImportance, Post_Caring.Personal_Advice, Post_Caring.Upset_Discussion, Post_Future.Friends, Post_Future.Finish_HS, Post_Future.Stay_Safe, Post_Future.Alive_Well, Post_Future.Happy_Life, Post_Future.Manage_Work, Post_Future.Proud_Parents, Post_Future.Solve_Problems, Post_Future.Interesting_Life, Post_Violence.Coping, Post_Violence.Cowardice, Post_Violence.Self_Care, Post_Violence.Anger_Mgmt, Post_Violence.Negotiation, Post_Violence.Self_Defense, Post_Violence.Handle_Others, Post_Violence.Self_Awareness, Post_Violence.Parent_Approval, Post_Violence.Parent_Disapproval, Post_Violence.Teasing_Prevention FROM Assessments AS Pre_Assessments LEFT JOIN Assessments as Post_Assessments ON (Pre_Assessments.Participant_ID=Post_Assessments.Participant_ID AND Pre_Assessments.Assessment_ID!=Post_Assessments.Assessment_ID AND Post_Assessments.Session_ID = Pre_Assessments.Session_ID) LEFT JOIN Participants_Baseline_Assessments ON (Pre_Assessments.Baseline_ID=Baseline_Assessment_ID) LEFT JOIN Participants_Caring_Adults AS Pre_Caring ON (Pre_Caring.Caring_Adults_ID=Pre_Assessments.Caring_ID) LEFT JOIN Participants_Caring_Adults AS Post_Caring ON (Post_Caring.Caring_Adults_ID=Post_Assessments.Caring_ID) LEFT JOIN Participants_Future_Expectations AS Pre_Future ON (Pre_Future.Future_Expectations_ID=Pre_Assessments.Future_ID) LEFT JOIN Participants_Future_Expectations AS Post_Future ON (Post_Future.Future_Expectations_ID=Post_Assessments.Future_ID) LEFT JOIN Participants_Interpersonal_Violence AS Pre_Violence ON (Pre_Violence.Interpersonal_Violence_ID=Pre_Assessments.Violence_ID) LEFT JOIN Participants_Interpersonal_Violence AS Post_Violence ON (Post_Violence.Interpersonal_Violence_ID=Post_Assessments.Violence_ID) LEFT JOIN Participants ON Pre_Assessments.Participant_ID=Participants.Participant_ID  LEFT JOIN Session_Names ON Pre_Assessments.Session_ID = Session_Names.Session_ID LEFT JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID ',
        'non_admin_string' => ' ',
        'non_admin_string2' => ' AND Session_Names.Program_ID = ',
        'add_access' => '1',
        'query2' => ' WHERE  Pre_Assessments.Pre_Post=1 AND Post_Caring.Caring_Adults_ID IS NOT NULL AND Post_Assessments.Pre_Post=2 AND Pre_Assessments.Date_Logged IN ( SELECT  MAX(Date_Logged) FROM Assessments WHERE Pre_Post =1 GROUP BY Session_ID, Participant_ID) AND  Post_Assessments.Date_Logged IN ( SELECT  MAX(Date_Logged) FROM Assessments WHERE Pre_Post =2 GROUP BY Session_ID, Participant_ID)  ',
        'query3' => ' GROUP BY Pre_Assessments.Assessment_ID ',
        'titles' => array("Participant ID", "First Name", "Last Name", "Session ID (of program)", "Session Name",  "Program Name", "Date Entered, Pre Survey", "Date Entered, Post Survey", "Home Language", "Ethnicity", "Race"),
        'legend' => array("(id)", "(name)", "(name)", "(id)", "session", "(program)", "date entered, pre survey", "date entered, post survey", "0=N/A; 1=Spanish; 2=Other", "0=N/A; 1=Not Hispanic/Latino/Spanish; 2=Yes, Mexican, Mexican-American, Chicago; 3=Yes, Puerto Rican; 4=Yes, Cuban; 5=Yes, Other Hispanic/Latino/Spanish", "0=N/A; 1=White; 2=Black, African-American; 3=American Indian; 4=Asian Indian; 5=Chinese; 6=Filipino; 7=Japanese; 8=Korean; 9=Vietnamese; 10=Other Asian; 11=Native Hawaiian; 12=Guamanian or Chamorro; 13=Samoan; 14=Other Pacific Islander; 15=Some other race")), 

        'enlace_new_surveys_deid' => array('db'=>'enlace', 'query'=> 
        'SELECT  Pre_Assessments.Participant_ID, Pre_Caring.Program, Session_Name, Name, Pre_Assessments.Date_Logged, Post_Assessments.Date_Logged, Home_Language, Ethnicity, Race, BYS_1, BYS_2, BYS_3, BYS_4, BYS_5, BYS_6, BYS_7, BYS_8, BYS_9, BYS_E, BYS_T, JVQ_1, JVQ_2, JVQ_3, JVQ_4, JVQ_5, JVQ_6, JVQ_7, JVQ_8, JVQ_9, JVQ_E, JVQ_T, JVQ_12, US_Born, Pre_Caring.Check_In, Pre_Caring.Know_You, Pre_Caring.Compliment, Pre_Caring.Crisis_Help, Pre_Caring.Pay_Attention, Pre_Caring.KnowImportance, Pre_Caring.Personal_Advice, Pre_Caring.Upset_Discussion, Pre_Future.Friends, Pre_Future.Finish_HS, Pre_Future.Stay_Safe,  Pre_Future.Alive_Well, Pre_Future.Happy_Life, Pre_Future.Manage_Work, Pre_Future.Proud_Parents, Pre_Future.Solve_Problems, Pre_Future.Interesting_Life, Pre_Violence.Coping, Pre_Violence.Cowardice, Pre_Violence.Self_Care, Pre_Violence.Anger_Mgmt, Pre_Violence.Negotiation, Pre_Violence.Self_Defense, Pre_Violence.Handle_Others, Pre_Violence.Self_Awareness, Pre_Violence.Parent_Approval, Pre_Violence.Parent_Disapproval, Pre_Violence.Teasing_Prevention, Post_Caring.Check_In, Post_Caring.Know_You, Post_Caring.Compliment, Post_Caring.Crisis_Help, Post_Caring.Pay_Attention, Post_Caring.KnowImportance, Post_Caring.Personal_Advice, Post_Caring.Upset_Discussion, Post_Future.Friends, Post_Future.Finish_HS, Post_Future.Stay_Safe, Post_Future.Alive_Well, Post_Future.Happy_Life, Post_Future.Manage_Work, Post_Future.Proud_Parents, Post_Future.Solve_Problems, Post_Future.Interesting_Life, Post_Violence.Coping, Post_Violence.Cowardice, Post_Violence.Self_Care, Post_Violence.Anger_Mgmt, Post_Violence.Negotiation, Post_Violence.Self_Defense, Post_Violence.Handle_Others, Post_Violence.Self_Awareness, Post_Violence.Parent_Approval, Post_Violence.Parent_Disapproval, Post_Violence.Teasing_Prevention FROM Assessments AS Pre_Assessments LEFT JOIN Assessments as Post_Assessments ON (Pre_Assessments.Participant_ID=Post_Assessments.Participant_ID AND Pre_Assessments.Assessment_ID!=Post_Assessments.Assessment_ID AND Pre_Assessments.Session_ID = Post_Assessments.Session_ID) LEFT JOIN Participants_Baseline_Assessments ON (Pre_Assessments.Baseline_ID=Baseline_Assessment_ID) LEFT JOIN Participants_Caring_Adults AS Pre_Caring ON (Pre_Caring.Caring_Adults_ID=Pre_Assessments.Caring_ID) LEFT JOIN Participants_Caring_Adults AS Post_Caring ON (Post_Caring.Caring_Adults_ID=Post_Assessments.Caring_ID) LEFT JOIN Participants_Future_Expectations AS Pre_Future ON (Pre_Future.Future_Expectations_ID=Pre_Assessments.Future_ID) LEFT JOIN Participants_Future_Expectations AS Post_Future ON (Post_Future.Future_Expectations_ID=Post_Assessments.Future_ID) LEFT JOIN Participants_Interpersonal_Violence AS Pre_Violence ON (Pre_Violence.Interpersonal_Violence_ID=Pre_Assessments.Violence_ID) LEFT JOIN Participants_Interpersonal_Violence AS Post_Violence ON (Post_Violence.Interpersonal_Violence_ID=Post_Assessments.Violence_ID) LEFT JOIN Participants ON Pre_Assessments.Participant_ID=Participants.Participant_ID  LEFT JOIN Session_Names ON Pre_Assessments.Session_ID = Session_Names.Session_ID LEFT JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID ',
        'non_admin_string' => ' ',
        'non_admin_string2' => ' AND Session_Names.Program_ID = ',
        'add_access' => '1',
        'query2' => ' WHERE  Pre_Assessments.Pre_Post=1 AND Post_Caring.Caring_Adults_ID IS NOT NULL AND Post_Assessments.Pre_Post=2 AND Pre_Assessments.Date_Logged IN ( SELECT  MAX(Date_Logged) FROM Assessments WHERE Pre_Post =1 GROUP BY Session_ID, Participant_ID) AND  Post_Assessments.Date_Logged IN ( SELECT  MAX(Date_Logged) FROM Assessments WHERE Pre_Post =2 GROUP BY Session_ID, Participant_ID) ',
        'query3' => ' GROUP BY Pre_Assessments.Assessment_ID ',
        'titles' => array("Participant ID", "Session ID (of program)", "Session Name", "Program Name", "Date Entered, Pre Survey", "Date Entered, Post Survey", "Home Language", "Ethnicity", "Race"),
        'legend' => array("(id)", "(id)", "session", "(program)", "date entered, pre survey", "date entered, post survey", "0=N/A; 1=Spanish; 2=Other", "0=N/A; 1=Not Hispanic/Latino/Spanish; 2=Yes, Mexican, Mexican-American, Chicago; 3=Yes, Puerto Rican; 4=Yes, Cuban; 5=Yes, Other Hispanic/Latino/Spanish", "0=N/A; 1=White; 2=Black, African-American; 3=American Indian; 4=Asian Indian; 5=Chinese; 6=Filipino; 7=Japanese; 8=Korean; 9=Vietnamese; 10=Other Asian; 11=Native Hawaiian; 12=Guamanian or Chamorro; 13=Samoan; 14=Other Pacific Islander; 15=Some other race")), 

        
        'swop_campaigns_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT * FROM Campaigns',
            'titles'=>array("Campaign Id", "Campaign Name")),
        
        'swop_events'=>array('db'=>'SWOP', 'query'=>
            'SELECT Campaigns_Events.*, Campaigns.Campaign_Name FROM 
                Campaigns_Events INNER JOIN Campaigns ON 
                Campaigns_Events.Campaign_ID=Campaigns.Campaign_ID',
            'titles'=>array("Event Id", "Event Name", "Event Date", "Campaign ID",
                "Subcampaign", "Location", "Campaign Name")),
        
        'swop_campaigns_institutions'=>array('db'=>'SWOP', 'query'=>
            'SELECT Campaigns_Institutions.*, Campaign_Name, Institution_Name
                FROM Campaigns_Institutions
                INNER JOIN Campaigns ON Campaigns_Institutions.Campaign_Id = 
                Campaigns.Campaign_ID
                INNER JOIN Institutions ON Campaigns_Institutions.Institution_Id
                = Institutions.Institution_ID',
            'titles'=>array("Campaign/Institution Id", "Institution ID", 
                "Campaign ID", "Campaign Name", "Institution Name")),
        
        'swop_households'=>array('db'=>'SWOP', 'query'=>
            'SELECT * FROM Households',
            'titles'=>array("Household Id", "Household Name")),
        
        'swop_households_people'=>array('db'=>'SWOP', 'query'=>
            'SELECT Household_Name, Name_First, Name_Last FROM Households 
                INNER JOIN Households_Participants 
                ON New_Household_ID=Household_ID
                INNER JOIN Participants ON
                Households_Participants.Participant_ID=Participants.Participant_ID',
            'titles'=>array("Household Name", "First Name", "Last Name")),
        
        'swop_households_people_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT * FROM Households_Participants',
            'titles'=>array("Link Id", "Household ID", "Participant ID", 
                "Head of Household (1=Y, 2=No)")),
        
        'swop_institutions_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT Institution_ID, Institution_Name, Block_Group, Type_Name,
                Contact_Person, Date_Added FROM Institutions
                LEFT JOIN Institution_Types ON Institution_Type = Type_ID',
            'titles'=>array("Institution Id", "Institution Name", "Block Group", 
                "Institution Type", "Contact Person (Database ID)", "Date Added")),
        
        'swop_institutions'=>array('db'=>'SWOP', 'query'=>
            'SELECT Institutions.*, (Institution_Types.Type_Name) AS Institution_Type_Name, Name_First, Name_Last
                FROM Institutions
                LEFT JOIN Participants ON Contact_Person = Participant_ID
                LEFT JOIN Institution_Types ON Institution_Types.Type_ID = 
                Institutions.Institution_Type',
            'titles'=>array("Institution Id", "Institution Name", "Street Number",
                "Street Direction", "Street Name", "Street Type", "Block Group",
                "Institution Type", "Phone", "Contact Person (Database ID)", 
                "Date Added", "Institution Type Name", "Contact Person (First Name)",
                "Contact Person (Last Name)")),
        
        'swop_institutions_people_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT * FROM Institutions_Participants',
            'titles'=>array("Link ID", "Institution ID", "Participant ID", 
                "Is Primary? (1=Yes, 0=No)", "Individual Connection (Participant ID)",
                "Connection Reason", "Date Added", "Activity Type")),
        
        'swop_institutions_people'=>array('db'=>'SWOP', 'query'=>
            'SELECT Institutions_Participants_ID, Institutions.Institution_ID, 
                Institutions.Institution_Name, person.Participant_ID, 
                person.Name_First, person.Name_Last, Is_Primary, 
                connection.Participant_ID, connection.Name_First, 
                connection.Name_Last, Connection_Reason
                FROM Institutions_Participants
                INNER JOIN Institutions ON Institutions.Institution_ID=
                Institutions_Participants.Institution_ID
                INNER JOIN Participants AS person ON person.Participant_ID=
                Institutions_Participants.Participant_ID
                LEFT JOIN Participants AS connection ON connection.Participant_ID=
                Individual_Connection',
            'titles'=>array("Link ID", "Institution ID", "Institution Name",
                "Connected Participant ID", "Connected Person First Name", 
                "Connected Person Last Name", "Is Primary? (1=Yes, 0=No)", 
                "Individual Connection (Participant ID)",
                "Individual Connection First Name", "Individual Connection Last Name",
                "Connection Reason")),
        
        'swop_leadership_development_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT Leadership_Development_ID, Participant_ID, Date, 
                Leadership_Detail_Name FROM Leadership_Development
                INNER JOIN Leadership_Development_Details
                ON Detail_ID= Leadership_Development_Detail_ID',
            'titles'=>array("Leadership Development ID", "Participant ID", 
                "Date", "Leadership Detail Achieved")),
        
        'swop_leadership_development'=>array('db'=>'SWOP', 'query'=>
            'SELECT Leadership_Development_ID, Leadership_Development.Participant_ID,
                Name_First, Name_Last, Date, Leadership_Detail_Name
                FROM Leadership_Development
                INNER JOIN Leadership_Development_Details
                ON Detail_ID= Leadership_Development_Detail_ID
                INNER JOIN Participants ON Leadership_Development.Participant_ID=
                Participants.Participant_ID',
            'titles'=>array("Leadership Development ID", "Participant ID", 
                "First Name", "Last Name", "Date", "Leadership Detail Achieved")),
        
        'swop_participants_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT Participants.Participant_ID, Education_Level, Gender, 
                Lang_Eng, Lang_Span, Lang_Other, Ward, Other_Lang_Specify, 
                Primary_Organizer, First_Interaction_Date, ITIN, Date_Added, 
                Properties.Property_ID, Properties.Block_Group   
                FROM Participants LEFT JOIN Participants_Properties ON 
                (Participants.Participant_ID=
                Participants_Properties.Participant_ID AND Primary_Residence=1)
                LEFT JOIN Properties ON Properties.Property_Id=
                Participants_Properties.Property_ID
                GROUP BY Participants.Participant_ID ORDER BY Name_Last',
            'titles'=>array("Participant ID", "Education_Level", " Gender", 
                "Speaks English? (1=Yes 0=No)", "Speaks Spanish? (1=Yes 0=No)",
                "Speaks Other? (1=Yes 0=No)", "Ward", "Other_Lang_Specify",
                "Primary_Organizer ID", " First_Interaction_Date", "ITIN Yes/No",
                "Date_Added", "Property ID", "Block Group")),
        
        'swop_participants'=>array('db'=>'SWOP', 'query'=>
            'SELECT Participants.Participant_ID, Participants.Name_First, 
                Participants.Name_Last, Participants.Phone_Day, 
                Participants.Phone_Evening, Participants.Education_Level, 
                Participants.Email, Participants.Gender, Participants.Date_of_Birth,
                Participants.Lang_Eng, Participants.Lang_Span, Participants.Lang_Other, 
                Participants.Ward, Participants.Other_Lang_Specify, 
                Participants.Notes, Participants.Primary_Organizer, 
                Participants.First_Interaction_Date, Participants.ITIN, 
                Participants.Date_Added, organizer.Name_First, organizer.Name_Last, 
                Properties.Property_ID, Properties.Address_Street_Num, 
                Properties.Address_Street_Direction, Properties.Address_Street_Name, 
                Properties.Address_Street_Type
                FROM Participants
                LEFT JOIN Participants AS organizer ON Participants.Primary_Organizer=organizer.Participant_ID
                LEFT JOIN Participants_Properties ON (Participants.Participant_ID=
                Participants_Properties.Participant_ID AND Primary_Residence=1)
                LEFT JOIN Properties ON Properties.Property_Id=Participants_Properties.Property_ID
                GROUP BY Participants.Participant_ID ORDER BY Participants.Name_Last',
            'titles'=>array("Participant ID", "First Name", "Last Name", 
                "Phone - Home", "Phone - Cell", "Education Level", "Email", "Gender",
                "Date of Birth", "Speaks English? (1=Yes 0=No)",
                "Speaks Spanish? (1=Yes 0=No)", "Speaks Other? (1=Yes 0=No)", "Ward",
                "Other Language Spoken", "Notes", "Primary Organizer ID", 
                "First Interaction Date", "ITIN yes/no", "Date Added", 
                "Primary Organizer First Name", "Primary Organizer Last Name", 
                "Property ID", "Street Number", "Street Direction", "Street Name",
                "Street Type")),
        
        'swop_pool_status_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT Pool_Status_Changes.Pool_Status_Change_ID,
                Reports__Active.Value AS Active,
                Pool_Status_Changes.Participant_ID,
                Pool_Status_Changes.Date_Changed,
                Reports__Activity_Type.Value AS Activity_Type,
                Pool_Member_Types.Type_Name AS Member_Type,
                Pool_Status_Changes.Expected_Date
                FROM Pool_Status_Changes
                LEFT JOIN Participants ON Pool_Status_Changes.Participant_ID = 
                Participants.Participant_ID
                LEFT JOIN Reports__Activity_Type ON Pool_Status_Changes.Activity_Type
                = Reports__Activity_Type.ID
                LEFT JOIN Pool_Member_Types ON Pool_Status_Changes.Member_Type
                = Pool_Member_Types.Type_ID
                LEFT JOIN Reports__Active ON Pool_Status_Changes.Active
                = Reports__Active.ID',
            'titles'=>array("Pool Status Change ID", "Active", "Participant ID", 
                "Date Changed", "Activity Type", "Member Type", "Expected Date")),
        
        'swop_pool_status'=>array('db'=>'SWOP', 'query'=>
            'SELECT Pool_Status_Changes.Pool_Status_Change_ID,
                Reports__Active.Value AS Active,
                Pool_Status_Changes.Participant_ID,
                Participants.Name_First,
                Participants.Name_Last,
                Pool_Status_Changes.Date_Changed,
                Reports__Activity_Type.Value AS Activity_Type,
                Pool_Member_Types.Type_Name AS Member_Type,
                Pool_Status_Changes.Expected_Date
                FROM Pool_Status_Changes
                LEFT JOIN Participants ON Pool_Status_Changes.Participant_ID = 
                Participants.Participant_ID
                LEFT JOIN Reports__Activity_Type ON Pool_Status_Changes.Activity_Type
                = Reports__Activity_Type.ID
                LEFT JOIN Pool_Member_Types ON Pool_Status_Changes.Member_Type =
                Pool_Member_Types.Type_ID
                LEFT JOIN Reports__Active ON Pool_Status_Changes.Active = Reports__Active.ID',
            'titles'=>array("Pool Status Change ID", "Active", "Participant ID",
                "First Name", "Last Name", "Date Changed", "Activity Type", 
                "Member Type", "Expected Date")),
        
        'swop_pool_movement_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT Pool_Progress.Pool_Progress_ID,
                Pool_Progress.Participant_ID,
                Pool_Benchmarks.Benchmark_Name,
                Pool_Benchmarks.Benchmark_Info,
                Pool_Progress.Date_Completed,
                Reports__Activity_Type.Value AS Activity_Type,
                Pool_Progress.Expected_Date,
                Pool_Progress.More_Info
                FROM Pool_Progress
                LEFT JOIN Participants ON Pool_Progress.Participant_ID =
                Participants.Participant_ID
                LEFT JOIN Participants AS Participants_More_Info ON Pool_Progress.More_Info
                = Participants_More_Info.Participant_ID
                LEFT JOIN Reports__Activity_Type ON Pool_Progress.Activity_Type
                = Reports__Activity_Type.ID
                LEFT JOIN Pool_Benchmarks ON Pool_Progress.Benchmark_Completed
                = Pool_Benchmarks.Pool_Benchmark_ID',
            'titles'=>array("Pool Progress ID", "Participant ID", "Benchmark Name",
                "Benchmark Info", "Date Completed", "Activity Type", "Expected Date",
                "More Info")),
        
        'swop_pool_movement'=>array('db'=>'SWOP', 'query'=>
            'SELECT Pool_Progress.Pool_Progress_ID,
                Pool_Progress.Participant_ID,
                Participants.Name_First,
                Participants.Name_Last,
                Pool_Benchmarks.Benchmark_Name,
                Pool_Benchmarks.Benchmark_Info,
                Pool_Progress.Date_Completed,
                Reports__Activity_Type.Value AS Activity_Type,
                Pool_Progress.Expected_Date,
                CONCAT(Participants_More_Info.Name_First, " ", Participants_More_Info.Name_Last) AS More_Info
                FROM Pool_Progress
                LEFT JOIN Participants ON Pool_Progress.Participant_ID 
                = Participants.Participant_ID
                LEFT JOIN Participants AS Participants_More_Info ON Pool_Progress.More_Info 
                = Participants_More_Info.Participant_ID
                LEFT JOIN Reports__Activity_Type ON Pool_Progress.Activity_Type 
                = Reports__Activity_Type.ID
                LEFT JOIN Pool_Benchmarks ON Pool_Progress.Benchmark_Completed 
                = Pool_Benchmarks.Pool_Benchmark_ID',
            'titles'=>array("Pool Progress ID", "Participant ID", "First Name", 
                "Last Name", "Benchmark Name", "Benchmark Info", "Date Completed",
                "Activity Type", "Expected Date", "More Info")),
        
        'swop_event_attendance_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT * FROM Participants_Events',
            'titles'=>array("Link ID", "Event ID", "Participant ID",
                "Role Type (1=Attendee; 2=Speaker; 3=Chairperson; 4=Prep work; 5=Staff)",
                "Exceptional")),
        
        'swop_event_attendance'=>array('db'=>'SWOP', 'query'=>
            'SELECT Participants_Events.*, Name_First, Name_Last
                FROM Participants_Events
                INNER JOIN Participants ON Participants_Events.Participant_ID =
                Participants.Participant_ID',
            'titles'=>array("Link ID", "Event ID", "Participant ID", "Role Type (1=Attendee; 2=Speaker; 3=Chairperson; 4=Prep work; 5=Staff)", "Exceptional (1=Yes)",
                            "Attendee First Name", "Attendee Last Name")),
        
        'swop_leader_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT * FROM Participants_Leaders',
            'titles'=>array("Link ID", "Participant ID", "Leader Type", 
                "Date Logged", "Activity Type")),
        
        'swop_leader'=>array('db'=>'SWOP', 'query'=>
            'SELECT Participants_Leaders.*, Name_First, Name_Last FROM '
            . 'Participants_Leaders INNER JOIN Participants ON '
            . 'Participants_Leaders.Participant_Id=Participants.Participant_ID',
            'titles'=>array("Link ID", "Participant ID", "Leader Type", 
                "Date Logged", "Activity Type", "First Name", "Last Name")),
        
        'swop_pool_members_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT Participant_Pool_ID, Participants_Pool.Participant_ID, Date_Logged, Type_Name, 
                Properties.Block_Group
                FROM Participants_Pool LEFT JOIN Pool_Member_Types ON Type=Type_ID
                LEFT JOIN Participants_Properties ON (Participants_Pool.Participant_ID=
                Participants_Properties.Participant_ID AND Primary_Residence=1)
                LEFT JOIN Properties ON Properties.Property_Id=Participants_Properties.Property_ID
                GROUP BY Participants_Pool.Participant_ID',
            'titles'=>array("Pool ID", "Participant ID", "Date Logged", 
                "Pool Member Type", "Block Group")),
        
        'swop_pool_members'=>array('db'=>'SWOP', 'query'=>
            'SELECT Participant_Pool_ID, Participants_Pool.Participant_ID, 
                Name_First, Name_Last, Date_Logged, Type_Name
                FROM Participants_Pool INNER JOIN Pool_Member_Types
                ON Type=Type_ID
                INNER JOIN Participants ON Participants_Pool.Participant_Id=
                Participants.Participant_ID',
            'titles'=>array("Pool ID", "Participant ID", "Date Logged", 
                "Pool Member Type", "Date Logged", "Type Name")),
        
        'swop_people_properties_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT Participants_Properties.*,  Properties.Block_Group FROM 
                Participants_Properties LEFT JOIN Properties ON 
                Properties.Property_Id=Participants_Properties.Property_ID',
            'titles'=>array("Link ID", "Participant ID", "Property ID", 
                "Date Linked", "Unit Number", "Rent or Own", "Start Date",
                "End Date", "Primary Residence", "Start as Primary", "End as Primary",
                "Reason Ended", "Block Group")),
        
        'swop_people_properties'=>array('db'=>'SWOP', 'query'=>
            'SELECT Participants_Properties.*, Name_First, Name_Last, 
                Properties.Address_Street_Num, Properties.Address_Street_Direction,
                Properties.Address_Street_Name, Properties.Address_Street_Type 
                FROM Participants_Properties 
                INNER JOIN Participants on Participants_Properties.Participant_Id=
                Participants.PARTICIPANT_ID
                INNER JOIN Properties on Properties.Property_Id=
                Participants_Properties.Property_ID',
            'titles'=>array("Link ID", "Participant ID", "Property ID", 
                "Date Linked", "Unit Number", "Rent or Own", "Start Date",
                "End Date", "Primary Residence", "Start as Primary", 
                "End as Primary", "Reason Ended", "First Name", "Last Name",
                "Address Number", "Address Direction", "Address Street", 
                "Address Street Type")),
        
        'swop_pool_employment_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT * FROM Pool_Employers',
            'titles'=>array("Link ID", "Participant ID", "Employer Name", 
                "Work Time", "Date Logged")),
        
        'swop_pool_employment'=>array('db'=>'SWOP', 'query'=>
            'SELECT Name_First, Name_Last, Pool_Employers.* FROM Pool_Employers
                INNER JOIN Participants ON Participants.Participant_ID = 
                Pool_Employers.Participant_ID',
            'titles'=>array("First Name", "Last Name", "Link ID (Pool Employer ID)",
                "Participant ID", "Employer Name", "Work Time", "Date Logged")),
        
        'swop_pool_finances_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT * FROM Pool_Finances',
            'titles'=>array("Finance ID", "Participant ID", "Credit Score", 
                "Income", "Current Housing (add meaning here)",
                "Household Location (1=In TTM Area; 2=Outside TTM but in SWOP; "
                . "3=Outside TTM and SWOP; 4=N/A)", "Housing Cost", "Employment",
                "Assets", "Date Logged")),
        
        'swop_pool_finances'=>array('db'=>'SWOP', 'query'=>
            'SELECT Pool_Finances.*, Name_First, Name_Last FROM Pool_Finances
                INNER JOIN Participants ON Participants.Participant_ID=
                Pool_Finances.Participant_ID',
            'titles'=>array("Finance ID", "Participant ID", "Credit Score", "Income",
                "Current Housing (add meaning here)",
                "Household Location (1=In TTM Area; 2=Outside TTM but in SWOP; "
                . "3=Outside TTM and SWOP; 4=N/A)", "Housing Cost", "Employment",
                "Assets", "Date Logged", "First Name", "Last Name")),
        
        'swop_pool_outcomes_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT Participant_ID, Outcome_Name, Date_Exited,  Outcome_Location_Name
                FROM Pool_Outcomes INNER JOIN Outcomes_for_Pool
                ON Pool_Outcomes.Outcome_ID=Outcomes_for_Pool.Outcome_ID
                INNER JOIN Outcome_Locations 
                ON Outcome_Location=Outcome_Location_ID',
            'titles'=>array("Participant ID", "Outcome Name", "Date Exited", 
                "Outcome Location")),
        
        'swop_pool_outcomes'=>array('db'=>'SWOP', 'query'=>
            'SELECT Pool_Outcomes.Participant_ID, Name_First, Name_Last, 
                Outcome_Name, Date_Exited, Outcome_Location_Name
                FROM Pool_Outcomes 
                INNER JOIN Outcomes_for_Pool ON Pool_Outcomes.Outcome_ID=
                Outcomes_for_Pool.Outcome_ID
                INNER JOIN Outcome_Locations ON Outcome_Location=Outcome_Location_ID
                INNER JOIN Participants ON Participants.Participant_Id=
                Pool_Outcomes.Participant_ID',
            'titles'=>array("Participant ID", "First Name", "Last Name", 
                "Outcome Name", "Date Exited", "Outcome Location")),
        
        'swop_pool_progress_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT Participant_ID, Date_Completed, Activity_Type,
                Benchmark_Name FROM Pool_Progress INNER JOIN Pool_Benchmarks ON 
                Benchmark_Completed=Pool_Benchmark_ID',
            'titles'=>array("Participant ID", "Date Completed", "Activity Type",
                "Benchmark Name")),
        
        'swop_pool_progress'=>array('db'=>'SWOP', 'query'=>
            'SELECT MONTH(Pool_Progress.Date_Completed), DAY(Pool_Progress.Date_Completed),
                YEAR(Pool_Progress.Date_Completed),
                Participants.Name_First, Participants.Name_Last, 
                Pool_Benchmarks.Benchmark_Name,
                organizer.Name_First, organizer.Name_Last
                FROM Pool_Progress INNER JOIN Participants ON Pool_Progress.Participant_ID=
                Participants.Participant_ID
                INNER JOIN Pool_Benchmarks ON Pool_Benchmark_ID=Benchmark_Completed
                INNER JOIN Participants AS organizer ON Participants.Primary_Organizer=
                organizer.Participant_ID',
            'titles'=>array("Month", "Day", "Year", "First Name", "Last Name", 
                "Benchmark Completed", "Organizer First Name", "Organizer Last Name")),
        
        'swop_pool_activity_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT * FROM Pool_Status_Changes',
            'titles'=>array("Change ID", "1=Active; 0=Inactive", "Participant ID",
                "Date Changed", "Activity Type", "Member Type", "Expected Date")),
        
        'swop_pool_activity'=>array('db'=>'SWOP', 'query'=>
            'SELECT * FROM Pool_Status_Changes INNER JOIN Participants ON '
            . 'Participants.Participant_Id = Pool_Status_Changes.Participant_ID',
            'titles'=>array("Change ID", "1=Active; 0=Inactive", "Participant ID",
                "Date Changed", "Activity Type",
                "Member_Type", "Expected_Date", "Participant_ID", "Name_First",
                "Name_Middle", "Name_Last",
                "Address_Street_Name", "Address_Street_Num", "Address_Street_Direction",
                "Address_Street_Type",
                "Phone_Day", "Phone_Evening", "Education_Level", "Email", "Gender",
                "Date_of_Birth",
                "Lang_Eng", "Lang_Span", "Lang_Other", "Ward", "Other_Lang_Specify",
                "Notes", "Next Step Notes", "Primary_Organizer",
                "First_Interaction_Date", "ITIN", "Date_Added", "Activity_Type")),
        
        'swop_properties_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT Property_ID, Disposition, Disposition_Name, Construction_Type,
                Home_Size, Date_Entered, Property_Type, Block_Group FROM 
                Properties LEFT JOIN Property_Dispositions ON Disposition=Disposition_ID',
            'titles'=>array("Property ID", "Disposition ID", "Disposition Name",
                "Construction Type (4=Brick/Masonry; 5=Frame)",
                "Home Size (1=Single-family; 2=2/3 flat; 3=Multi-unit)", 
                "Date Entered", "Property Type (1=Residential; 2=Commercial; 3=Mixed-use)",
                "Block Group")),
        
        'swop_properties'=>array('db'=>'SWOP', 'query'=>
            'SELECT Property_ID, Address_Street_Num,  Address_Street_Direction,
                Address_Street_Name, Address_Street_Type, PIN, Construction_Type,
                Home_Size, Date_Entered, Property_Type, Disposition_Name
                FROM Properties LEFT JOIN Property_Dispositions ON Disposition=
                Disposition_ID',
            'titles'=>array("Property ID", "Street Number", "Street Direction", 
                "Street Name", "Street Type", "PIN",
                "Construction Type (4=Brick/Masonry; 5=Frame)",
                "Home Size (1=Single-family; 2=2/3 flat; 3=Multi-unit)", 
                "Date Entered", "Property Type  (1=Residential; 2=Commercial; 3=Mixed-use)",
                "Disposition Name")),
        
        'swop_property_progress_deid'=>array('db'=>'SWOP', 'query'=>
            'SELECT Property_Progress.*, Property_Marker_Name, Block_Group
                FROM Property_Progress
                LEFT JOIN Property_Marker_Names ON Marker=Property_Marker_Name_ID
                LEFT JOIN Properties ON Property_Progress.Property_Id=
                Properties.Property_ID',
            'titles'=>array("Progress ID", "Date Added", "Marker ID", "Additional 1",
                "Additional 2", "Additional 3", "Additional 4", "Property ID", 
                "Notes", "Property Marker Name", "Block Group")),
        
        'swop_property_progress'=>array('db'=>'SWOP', 'query'=>
            'SELECT Property_Progress.*, Property_Marker_Name, 
                Properties.Address_Street_Num, Properties.Address_Street_Direction,
                Properties.Address_Street_Name, Properties.Address_Street_Type
                FROM Property_Progress  LEFT JOIN Property_Marker_Names ON
                Marker=Property_Marker_Name_ID
                INNER JOIN Properties ON Property_Progress.Property_ID=
                Properties.Property_ID',
            'titles'=>array("Progress ID", "Date Added", "Marker ID", "Additional 1",
                "Additional 2", "Additional 3", "Additional 4", "Property ID", 
                "Notes", "Property Marker Name", "Street Number", "Street Direction", 
                "Street Name", "Street Type")),

	'trp_academic_info' => array('db'=>'TRP', 'query'=>
            'SELECT First_Name, Last_Name, Academic_Info.*,
                School_Name FROM Academic_Info LEFT JOIN Schools ON
                School=School_ID LEFT JOIN Participants ON
                Academic_Info.Participant_ID=Participants.Participant_ID',
            'titles'=>array("Participant First Name", "Last Name",
                "Academic Information ID", "Participant ID",  "Program
                ID", "School Year", "Quarter", "GPA", "ISAT Math Score",
                "ISAT Reading Score", "ISAT Total Score", "Grade in
                School", "Math Grade", "Language Arts Grade", "Date
                Information Logged", "School ID (6=No School Selected)",
                "School Name")),

        'trp_academic_info_deid' => array('db'=>'TRP', 'query'=>
            'SELECT * FROM Academic_Info', 
            'titles'=>array("Academic
                Information ID", "Participant ID", "Program ID", "School
                Year", "Quarter", "GPA", "ISAT Math Score", "ISAT Reading
                Score", "ISAT Total Score", "Grade in School", "Math
                Grade", "Language Arts Grade", "Date Information Logged",
                "School ID (6=No School Selected)")),

        'trp_events_deid' => array('db'=>'TRP', 'query'=>
            'SELECT * FROM Events',
            'titles'=>array("Event ID", "Event Name", "Event Goal
                Attendance", "Event Actual Attendance", "Event Date",
            "Active[1]/Inactive[0]")),
         
        'trp_event_attendance' => array('db'=>'TRP', 'query'=>
            'SELECT Event_Name, Event_Date, First_Name, Last_Name FROM 
                Events_Participants INNER JOIN Events ON Events_Participants.Event_ID=  
                Events.Event_ID INNER JOIN Participants ON
                Events_Participants.Participant_ID=Participants.Participant_ID',
             'titles' => array("Event Name", "Event Date", "Attendee First Name", 
                 "Attendee Last Name")),
         
        'trp_event_attendance_deid' => array('db'=>'TRP', 'query'=>
            'SELECT Event_Name, Event_Date, Participant_ID FROM Events_Participants 
                INNER JOIN Events ON Events_Participants.Event_ID=Events.Event_ID',
            'titles' => array("Link ID", "Event ID", "Participant ID")),

        'trp_school_records' => array('db'=>'TRP', 'query'=>
            'SELECT First_Name, Last_Name, MS_to_HS_Over_Time.*, School_Name FROM 
                MS_to_HS_Over_Time LEFT JOIN Participants ON Participants.Participant_ID
                =MS_to_HS_Over_Time.Participant_ID LEFT JOIN Schools ON Schools.School_ID
                =MS_to_HS_Over_Time.School_ID',
            'titles' => array("First Name", "Last Name", "Link ID", "Participant ID", 
                "Number of Tardies", "Number of Excused Absences", "Number of Unexcused
                 Absences", "Number of In-school Suspensions", "Number of out of school
                  suspensions", "Office Referrals", "Quarter", "Grade in School", 
                  "School Year", "Program ID", "School ID", "School Name")),

         'trp_school_records_deid' => array('db'=>'TRP', 'query'=>
             'SELECT * FROM MS_to_HS_Over_Time',
             'titles' => array("Link ID", "Participant ID", "Number of Tardies", "Number
                  of Excused Absences", "Number of Unexcused Absences", "Number of In-school
                  Suspensions", "Number of out of school suspensions", "Office Referrals", 
                  "Quarter", "Grade in School")),

         'trp_explore_scores' => array('db'=>'TRP', 'query'=>
             'SELECT First_Name, Last_Name, Explore_Scores.*, School_Name FROM Explore_Scores
                 LEFT JOIN Participants on Explore_Scores.Participant_ID=Participants.Participant_ID
                 LEFT JOIN Schools ON School=School_ID',
             'titles' => array("First Name", "Last Name", "Link ID", "Participant ID",
                 "Explore Score Pre", "Explore Score Mid", "Explore Score Post", 
                 "Explore Score Fall of 9th Grade", "Reading ISAT", "Math ISAT", "CPS Consent", 
                 "Program ID", "School ID", "School Year", "School Name")),

         'trp_explore_scores_deid' => array('db'=>'TRP', 'query'=>
             'SELECT * FROM Explore_Scores',
             'titles' => array("Link ID", "Participant ID", "Explore Score Pre", "Explore Score 
                 Mid", "Explore Score Post", "Explore Score Fall of 9th Grade", "Reading
                 ISAT", "Math ISAT", "CPS Consent", "Program ID", "School ID", "School Year")),

          'trp_community_outcomes' => array('db'=>'TRP', 'query'=>
              'SELECT Outcome_Name, Month, Goal_Outcome, Actual_Outcome FROM
                   Outcomes_Months INNER JOIN Outcomes ON Outcomes_Months.Outcome_ID=
                   Outcomes.Outcome_ID',
              'titles' => array("Outcome", "Month", "Goal", "Actual Result")),

          'trp_families'  => array('db'=>'TRP', 'query'=>
              'SELECT Children.First_Name, Children.Last_Name, Parents.First_Name, 
                  Parents.Last_Name FROM Parents_Children INNER JOIN Participants as 
                  Parents ON Parents.Participant_ID=Parent_ID INNER JOIN Participants
                  AS Children ON Children.Participant_ID=Child_ID',
              'titles' => array("Child First Name", "Child Last Name", "Parent First
                   Name", "Parent Last Name")),

          'trp_families_deid'  => array('db'=>'TRP', 'query'=>
              'SELECT * FROM Parents_Children',
              'titles' => array("Linking ID", "Parent ID", "Child ID")),

        'trp_participants'  => array('db'=>'TRP', 'query'=>
              'SELECT * FROM Participants',
              'titles' => array("Participant ID", "First Name", "Last Name", "Address
                   Street Name", "Address Street Number", "Street Direction",
              "Street Type", "State", "City", "Zipcode", "Block Group", "Phone", "Email", 
                   "Gender", "Date of Birth", "Race", "Grade Level", "Classroom", 
                   "Lunch Price  (0=No Answer; 1=Free; 2=Reduced Price; 3=None)",
                   "Neighborhood", "Eval ID", "CPS ID")),

          'trp_participants_deid'  => array('db' => 'TRP', 'query'=>
              'SELECT Participant_ID, Block_Group, Gender,
                  Grade_Level, Classroom, Lunch_Price, Neighborhood FROM
                  Participants', 
              'titles' => array("Participant_ID", "Block Group",
                  "Gender", "Grade_Level", "Classroom", "Lunch_Price (0=No
                  Answer; 1=Free; 2=Reduced Price; 3=None)",
                  "Neighborhood")), 

          'trp_participants_programs'  => array('db' => 'TRP', 'query'=>
              'SELECT First_Name, Last_Name, Program_Name FROM
                  Participants_Programs INNER JOIN Participants ON
                  Participants.Participant_ID=Participants_Programs.Participant_ID
                  INNER JOIN Programs ON
                  Participants_Programs.Program_ID=Programs.Program_ID',
              'titles' => array( "First Name", "Last Name", "Program
                  Name")),

          'trp_participants_programs_deid'  => array('db' => 'TRP', 'query'=>
              'SELECT * FROM Participants_Programs',
          'titles' => array("Linking ID", "Participant ID", "Program ID")),

          'trp_programs'  => array('db' => 'TRP', 'query'=>
              'SELECT * FROM Programs',
              'titles' => array("Program ID", "Program Name", "Program
                  Organization")),

          'trp_gold_scores'  => array('db' => 'TRP', 'query'=>
          'SELECT Gold_Score_Pre1.Participant, First_Name, Last_Name, Gold_Score_Pre1.Social_Emotional, Gold_Score_Pre2.Social_Emotional, Gold_Score_Pre3.Social_Emotional, Gold_Score_Mid1.Social_Emotional, Gold_Score_Mid2.Social_Emotional, Gold_Score_Mid3.Social_Emotional, Gold_Score_Post1.Social_Emotional, Gold_Score_Post2.Social_Emotional, Gold_Score_Post3.Social_Emotional, Gold_Score_Pre1.Physical, Gold_Score_Pre2.Physical, Gold_Score_Pre3.Physical, Gold_Score_Mid1.Physical, Gold_Score_Mid2.Physical, Gold_Score_Mid3.Physical, Gold_Score_Post1.Physical,  Gold_Score_Post2.Physical,  Gold_Score_Post3.Physical, Gold_Score_Pre1.Language, Gold_Score_Pre2.Language, Gold_Score_Pre3.Language, Gold_Score_Mid1.Language, Gold_Score_Mid2.Language, Gold_Score_Mid3.Language, Gold_Score_Post1.Language,  Gold_Score_Post2.Language,  Gold_Score_Post3.Language, Gold_Score_Pre1.Cognitive, Gold_Score_Pre2.Cognitive, Gold_Score_Pre3.Cognitive, Gold_Score_Mid1.Cognitive, Gold_Score_Mid2.Cognitive, Gold_Score_Mid3.Cognitive, Gold_Score_Post1.Cognitive,  Gold_Score_Post2.Cognitive,  Gold_Score_Post3.Cognitive, Gold_Score_Pre1.Literacy, Gold_Score_Pre2.Literacy,        Gold_Score_Pre3.Literacy, Gold_Score_Mid1.Literacy, Gold_Score_Mid1.Literacy, Gold_Score_Mid3.Literacy, Gold_Score_Post1.Literacy,  Gold_Score_Post2.Literacy,  Gold_Score_Post3.Literacy, Gold_Score_Pre1.Mathematics, Gold_Score_Pre2.Mathematics, Gold_Score_Pre3.Mathematics, Gold_Score_Mid1.Mathematics, Gold_Score_Mid2.Mathematics, Gold_Score_Mid3.Mathematics, Gold_Score_Post1.Mathematics, Gold_Score_Post2.Mathematics, Gold_Score_Post3.Mathematics, Gold_Score_Pre1.Science_Tech, Gold_Score_Pre2.Science_Tech, Gold_Score_Pre3.Science_Tech, Gold_Score_Mid1.Science_Tech, Gold_Score_Mid2.Science_Tech, Gold_Score_Mid3.Science_Tech, Gold_Score_Post1.Science_Tech, Gold_Score_Post2.Science_Tech, Gold_Score_Post3.Science_Tech, Gold_Score_Pre1.Social_Studies, Gold_Score_Pre2.Social_Studies, Gold_Score_Pre3.Social_Studies, Gold_Score_Mid1.Social_Studies, Gold_Score_Mid2.Social_Studies, Gold_Score_Mid3.Social_Studies, Gold_Score_Post1.Social_Studies, Gold_Score_Post2.Social_Studies, Gold_Score_Post3.Social_Studies, Gold_Score_Pre1.Creative_Arts, Gold_Score_Pre2.Creative_Arts, Gold_Score_Pre3.Creative_Arts, Gold_Score_Mid1.Creative_Arts, Gold_Score_Mid2.Creative_Arts, Gold_Score_Mid3.Creative_Arts, Gold_Score_Post1.Creative_Arts, Gold_Score_Post2.Creative_Arts, Gold_Score_Post3.Creative_Arts, Gold_Score_Pre1.English, Gold_Score_Pre2.English, Gold_Score_Pre3.English, Gold_Score_Mid1.English, Gold_Score_Mid2.English, Gold_Score_Mid3.English, Gold_Score_Post1.English, Gold_Score_Post2.English, Gold_Score_Post3.English, Address_Street_Num, Address_Street_Direction, Address_Street_Name, Address_Street_Type, Address_City, Address_State, Address_Zipcode, Phone, Email, DOB, Gender, CPS_ID FROM Gold_Score_Totals LEFT JOIN Participants ON Gold_Score_Totals.Participant=Participants.Participant_ID LEFT JOIN Gold_Score_Totals AS Gold_Score_Pre1 ON Gold_Score_Totals.Participant=Gold_Score_Pre1.Participant AND Gold_Score_Pre1.Test_Time=1 AND Gold_Score_Pre1.Year=1 LEFT JOIN Gold_Score_Totals AS Gold_Score_Pre2 ON Gold_Score_Totals.Participant=Gold_Score_Pre2.Participant AND Gold_Score_Pre2.Test_Time=1 AND Gold_Score_Pre2.Year=2 LEFT JOIN Gold_Score_Totals AS Gold_Score_Pre3 ON Gold_Score_Totals.Participant=Gold_Score_Pre3.Participant AND Gold_Score_Pre3.Test_Time=1 AND Gold_Score_Pre3.Year = 3 LEFT JOIN Gold_Score_Totals AS Gold_Score_Mid1 ON Gold_Score_Totals.Participant=Gold_Score_Mid1.Participant AND Gold_Score_Mid1.Test_Time=2 AND Gold_Score_Mid1.Year= 1 LEFT JOIN Gold_Score_Totals AS Gold_Score_Mid2 ON Gold_Score_Totals.Participant=Gold_Score_Mid2.Participant AND Gold_Score_Mid2.Test_Time=2 AND Gold_Score_Mid2.Year=2 LEFT JOIN Gold_Score_Totals AS Gold_Score_Mid3 ON Gold_Score_Totals.Participant=Gold_Score_Mid3.Participant AND Gold_Score_Mid3.Test_Time=2 AND Gold_Score_Mid3.Year=3 LEFT JOIN Gold_Score_Totals AS Gold_Score_Post1 ON Gold_Score_Totals.Participant=Gold_Score_Post1.Participant AND Gold_Score_Post1.Test_Time=3 AND Gold_Score_Post1.Year=1 LEFT JOIN Gold_Score_Totals AS Gold_Score_Post2 ON Gold_Score_Totals.Participant=Gold_Score_Post2.Participant AND Gold_Score_Post2.Test_Time=3 AND Gold_Score_Post2.Year=2 LEFT JOIN Gold_Score_Totals AS Gold_Score_Post3 ON Gold_Score_Totals.Participant=Gold_Score_Post3.Participant AND Gold_Score_Post3.Test_Time=3 AND Gold_Score_Post3.Year=3 GROUP BY Gold_Score_Totals.Participant',
          'titles' => array( "Participant ID", "Participant First Name", "Participant Last Name", "Social Emotional - Pre Year 1", "Social Emotional - Pre: Year 2", "Social Emotional - Pre: Year 3", "Social Emotional - Mid Year 1", "Social Emotional - Mid: Year 2", "Social Emotional - Mid: Year 3", "Social Emotional - Post Year 1", "Social Emotional - Post: Year 2", "Social Emotional - Post: Year 3", "Physical - Pre Year 1", "Physical - Pre: Year 2", "Physical - Pre: Year 3", "Physical - Mid Year 1", "Physical - Mid: Year 2", "Physical - Mid: Year 3", "Physical - Post Year 1", "Physical - Post: Year 2", "Physical - Post: Year 3", "Language - Pre Year 1", "Language - Pre: Year 2", "Language - Pre: Year 3", "Language - Mid Year 1", "Language - Mid: Year 2", "Language - Mid: Year 3", "Language - Post Year 1", "Language - Post: Year 2", "Language - Post: Year 3", "Cognitive - Pre Year 1", "Cognitive - Pre: Year 2", "Cognitive - Pre: Year 3", "Cognitive - Mid Year 1", "Cognitive - Mid: Year 2", "Cognitive - Mid: Year 3", "Cognitive - Post Year 1", "Cognitive - Post: Year 2", "Cognitive - Post: Year 3", "Literacy - Pre Year 1", "Literacy - Pre: Year 2", "Literacy - Pre: Year 3", "Literacy - Mid Year 1", "Literacy - Mid: Year 2", "Literacy - Mid: Year 3", "Literacy - Post Year 1", "Literacy - Post: Year 2", "Literacy - Post: Year 3", "Mathematics - Pre Year 1", "Mathematics - Pre: Year 2", "Mathematics - Pre: Year 3", "Mathematics - Mid Year 1", "Mathematics - Mid: Year 2", "Mathematics - Mid: Year 3", "Mathematics - Post Year 1", "Mathematics - Post: Year 2", "Mathematics - Post: Year 3", "Science and Technology - Pre Year 1", "Science and Technology - Pre: Year 2", "Science and Technology - Pre: Year 3", "Science and Technology - Mid Year 1", "Science and Technology - Mid: Year 2", "Science and Technology - Mid: Year 3", "Science and Technology - Post Year 1", "Science and Technology - Post: Year 2", "Science and Technology - Post: Year 3", "Social Studies - Pre Year 1", "Social Studies - Pre: Year 2", "Social Studies - Pre: Year 3", "Social Studies - Mid Year 1", "Social Studies - Mid: Year 2", "Social Studies - Mid: Year 3", "Social Studies - Post Year 1", "Social Studies - Post: Year 2", "Social Studies - Post: Year 3", "Creative Arts - Pre Year 1", "Creative Arts - Pre: Year 2", "Creative Arts - Pre: Year 3", "Creative Arts - Mid Year 1", "Creative Arts - Mid: Year 2", "Creative Arts - Mid: Year 3", "Creative Arts - Post Year 1", "Creative Arts - Post: Year 2", "Creative Arts - Post: Year 3", "English - Pre Year 1", "English - Pre: Year 2", "English - Pre: Year 3", "English - Mid Year 1", "English - Mid: Year 2", "English - Mid: Year 3", "English - Post Year 1", "English - Post: Year 2", "English - Post: Year 3",  "Address Street Number", "Address Street Direction", "Address Street Name", "Address Street Type", "City", "State", "Zipcode", "Phone", "Email", "DOB", "Gender", "CPS ID"), 
          'legend' => array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation","1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation")), 

        'trp_gold_scores_deid'  => array('db' => 'TRP', 'query' =>           
        'SELECT Gold_Score_Pre1.Participant, Gold_Score_Pre1.Social_Emotional, Gold_Score_Pre2.Social_Emotional, Gold_Score_Pre3.Social_Emotional, Gold_Score_Mid1.Social_Emotional, Gold_Score_Mid2.Social_Emotional, Gold_Score_Mid3.Social_Emotional, Gold_Score_Post1.Social_Emotional, Gold_Score_Post2.Social_Emotional, Gold_Score_Post3.Social_Emotional, Gold_Score_Pre1.Physical, Gold_Score_Pre2.Physical, Gold_Score_Pre3.Physical, Gold_Score_Mid1.Physical, Gold_Score_Mid2.Physical, Gold_Score_Mid3.Physical, Gold_Score_Post1.Physical,  Gold_Score_Post2.Physical,  Gold_Score_Post3.Physical, Gold_Score_Pre1.Language, Gold_Score_Pre2.Language, Gold_Score_Pre3.Language, Gold_Score_Mid1.Language, Gold_Score_Mid2.Language, Gold_Score_Mid3.Language, Gold_Score_Post1.Language,  Gold_Score_Post2.Language,  Gold_Score_Post3.Language, Gold_Score_Pre1.Cognitive, Gold_Score_Pre2.Cognitive, Gold_Score_Pre3.Cognitive, Gold_Score_Mid1.Cognitive, Gold_Score_Mid2.Cognitive, Gold_Score_Mid3.Cognitive, Gold_Score_Post1.Cognitive,  Gold_Score_Post2.Cognitive,  Gold_Score_Post3.Cognitive, Gold_Score_Pre1.Literacy, Gold_Score_Pre2.Literacy,        Gold_Score_Pre3.Literacy, Gold_Score_Mid1.Literacy, Gold_Score_Mid1.Literacy, Gold_Score_Mid3.Literacy, Gold_Score_Post1.Literacy,  Gold_Score_Post2.Literacy,  Gold_Score_Post3.Literacy, Gold_Score_Pre1.Mathematics, Gold_Score_Pre2.Mathematics, Gold_Score_Pre3.Mathematics, Gold_Score_Mid1.Mathematics, Gold_Score_Mid2.Mathematics, Gold_Score_Mid3.Mathematics, Gold_Score_Post1.Mathematics, Gold_Score_Post2.Mathematics, Gold_Score_Post3.Mathematics, Gold_Score_Pre1.Science_Tech, Gold_Score_Pre2.Science_Tech, Gold_Score_Pre3.Science_Tech, Gold_Score_Mid1.Science_Tech, Gold_Score_Mid2.Science_Tech, Gold_Score_Mid3.Science_Tech, Gold_Score_Post1.Science_Tech, Gold_Score_Post2.Science_Tech, Gold_Score_Post3.Science_Tech, Gold_Score_Pre1.Social_Studies, Gold_Score_Pre2.Social_Studies, Gold_Score_Pre3.Social_Studies, Gold_Score_Mid1.Social_Studies, Gold_Score_Mid2.Social_Studies, Gold_Score_Mid3.Social_Studies, Gold_Score_Post1.Social_Studies, Gold_Score_Post2.Social_Studies, Gold_Score_Post3.Social_Studies, Gold_Score_Pre1.Creative_Arts, Gold_Score_Pre2.Creative_Arts, Gold_Score_Pre3.Creative_Arts, Gold_Score_Mid1.Creative_Arts, Gold_Score_Mid2.Creative_Arts, Gold_Score_Mid3.Creative_Arts, Gold_Score_Post1.Creative_Arts, Gold_Score_Post2.Creative_Arts, Gold_Score_Post3.Creative_Arts, Gold_Score_Pre1.English, Gold_Score_Pre2.English, Gold_Score_Pre3.English, Gold_Score_Mid1.English, Gold_Score_Mid2.English, Gold_Score_Mid3.English, Gold_Score_Post1.English, Gold_Score_Post2.English, Gold_Score_Post3.English, Address_Street_Num, Address_Street_Direction, Address_Street_Name, Address_Street_Type, Address_City, Address_State, Address_Zipcode, Phone, Email, DOB, Gender, CPS_ID FROM Gold_Score_Totals LEFT JOIN Participants ON Gold_Score_Totals.Participant=Participants.Participant_ID LEFT JOIN Gold_Score_Totals AS Gold_Score_Pre1 ON Gold_Score_Totals.Participant=Gold_Score_Pre1.Participant AND Gold_Score_Pre1.Test_Time=1 AND Gold_Score_Pre1.Year=1 LEFT JOIN Gold_Score_Totals AS Gold_Score_Pre2 ON Gold_Score_Totals.Participant=Gold_Score_Pre2.Participant AND Gold_Score_Pre2.Test_Time=1 AND Gold_Score_Pre2.Year=2 LEFT JOIN Gold_Score_Totals AS Gold_Score_Pre3 ON Gold_Score_Totals.Participant=Gold_Score_Pre3.Participant AND Gold_Score_Pre3.Test_Time=1 AND Gold_Score_Pre3.Year = 3 LEFT JOIN Gold_Score_Totals AS Gold_Score_Mid1 ON Gold_Score_Totals.Participant=Gold_Score_Mid1.Participant AND Gold_Score_Mid1.Test_Time=2 AND Gold_Score_Mid1.Year= 1 LEFT JOIN Gold_Score_Totals AS Gold_Score_Mid2 ON Gold_Score_Totals.Participant=Gold_Score_Mid2.Participant AND Gold_Score_Mid2.Test_Time=2 AND Gold_Score_Mid2.Year=2 LEFT JOIN Gold_Score_Totals AS Gold_Score_Mid3 ON Gold_Score_Totals.Participant=Gold_Score_Mid3.Participant AND Gold_Score_Mid3.Test_Time=2 AND Gold_Score_Mid3.Year=3 LEFT JOIN Gold_Score_Totals AS Gold_Score_Post1 ON Gold_Score_Totals.Participant=Gold_Score_Post1.Participant AND Gold_Score_Post1.Test_Time=3 AND Gold_Score_Post1.Year=1 LEFT JOIN Gold_Score_Totals AS Gold_Score_Post2 ON Gold_Score_Totals.Participant=Gold_Score_Post2.Participant AND Gold_Score_Post2.Test_Time=3 AND Gold_Score_Post2.Year=2 LEFT JOIN Gold_Score_Totals AS Gold_Score_Post3 ON Gold_Score_Totals.Participant=Gold_Score_Post3.Participant AND Gold_Score_Post3.Test_Time=3 AND Gold_Score_Post3.Year=3 GROUP BY Gold_Score_Totals.Participant',
          'titles' => array( "Participant ID", "Social Emotional - Pre Year 1", "Social Emotional - Pre: Year 2", "Social Emotional - Pre: Year 3", "Social Emotional - Mid Year 1", "Social Emotional - Mid: Year 2", "Social Emotional - Mid: Year 3", "Social Emotional - Post Year 1", "Social Emotional - Post: Year 2", "Social Emotional - Post: Year 3", "Physical - Pre Year 1", "Physical - Pre: Year 2", "Physical - Pre: Year 3", "Physical - Mid Year 1", "Physical - Mid: Year 2", "Physical - Mid: Year 3", "Physical - Post Year 1", "Physical - Post: Year 2", "Physical - Post: Year 3", "Language - Pre Year 1", "Language - Pre: Year 2", "Language - Pre: Year 3", "Language - Mid Year 1", "Language - Mid: Year 2", "Language - Mid: Year 3", "Language - Post Year 1", "Language - Post: Year 2", "Language - Post: Year 3", "Cognitive - Pre Year 1", "Cognitive - Pre: Year 2", "Cognitive - Pre: Year 3", "Cognitive - Mid Year 1", "Cognitive - Mid: Year 2", "Cognitive - Mid: Year 3", "Cognitive - Post Year 1", "Cognitive - Post: Year 2", "Cognitive - Post: Year 3", "Literacy - Pre Year 1", "Literacy - Pre: Year 2", "Literacy - Pre: Year 3", "Literacy - Mid Year 1", "Literacy - Mid: Year 2", "Literacy - Mid: Year 3", "Literacy - Post Year 1", "Literacy - Post: Year 2", "Literacy - Post: Year 3", "Mathematics - Pre Year 1", "Mathematics - Pre: Year 2", "Mathematics - Pre: Year 3", "Mathematics - Mid Year 1", "Mathematics - Mid: Year 2", "Mathematics - Mid: Year 3", "Mathematics - Post Year 1", "Mathematics - Post: Year 2", "Mathematics - Post: Year 3", "Science and Technology - Pre Year 1", "Science and Technology - Pre: Year 2", "Science and Technology - Pre: Year 3", "Science and Technology - Mid Year 1", "Science and Technology - Mid: Year 2", "Science and Technology - Mid: Year 3", "Science and Technology - Post Year 1", "Science and Technology - Post: Year 2", "Science and Technology - Post: Year 3", "Social Studies - Pre Year 1", "Social Studies - Pre: Year 2", "Social Studies - Pre: Year 3", "Social Studies - Mid Year 1", "Social Studies - Mid: Year 2", "Social Studies - Mid: Year 3", "Social Studies - Post Year 1", "Social Studies - Post: Year 2", "Social Studies - Post: Year 3", "Creative Arts - Pre Year 1", "Creative Arts - Pre: Year 2", "Creative Arts - Pre: Year 3", "Creative Arts - Mid Year 1", "Creative Arts - Mid: Year 2", "Creative Arts - Mid: Year 3", "Creative Arts - Post Year 1", "Creative Arts - Post: Year 2", "Creative Arts - Post: Year 3", "English - Pre Year 1", "English - Pre: Year 2", "English - Pre: Year 3", "English - Mid Year 1", "English - Mid: Year 2", "English - Mid: Year 3", "English - Post Year 1", "English - Post: Year 2", "English - Post: Year 3",  "Address Street Number", "Address Street Direction", "Address Street Name", "Address Street Type", "City", "State", "Zipcode", "Phone", "Email", "DOB", "Gender", "CPS ID"), 
          'legend' => array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation","1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation", "1=No Evidence Yet; 2=Emerging; 3=Meets Program Expectation")), 

        'trp_teacher_exchange'  => array('db' => 'TRP', 'query' => 
             'SELECT Teacher_Exchange_Rooms.*, First_Name, Last_Name FROM Teacher_Exchange_Rooms 
LEFT JOIN
                Participants ON Teacher_Exchange_Rooms.Participant_ID=Participants.Participant_ID', 
             'titles' => array("Teacher Exchange ID", "Participant ID", "Classroom", "Home Teacher", 
                 "Exchange Teacher", "Participant First Name", "Participant Last Name")),            

        'trp_teacher_exchange_deid'  => array('db' => 'TRP', 'query' => 
             'SELECT Teacher_Exchange_Rooms.* FROM Teacher_Exchange_Rooms',
             'titles' => array("Teacher Exchange ID", "Participant ID", "Classroom", 
                 "Home Teacher", "Exchange Teacher")),



                 );
    $db_array=array(2=>'LSNA', 3=>'bickerdike', 4=>'TRP', 5=>'SWOP', 6=>'enlace');
    if (array_key_exists($download_name, $download_list_array)){
        if ( isLoggedIn()){
        //add a couple lines here to check the privileges, so we know whether
        //this person is authorized to view given exports
        $accesses=array();
        $programs = array();
        foreach ($permissions as $site_id => $site_info) {
            $accesses[] = $site_id;
            $programs[$site_id] = $site_info[1];
        }
        $get_db_id=array_search($download_list_array[$download_name]['db'], $db_array);
        $has_permission=in_array($get_db_id, $accesses);
        //if their permissions include the db for this download 
        if ($has_permission){       
        
        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$download_name . '.csv');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');


        // fetch the data
        $conn_file='../' . strtolower($download_list_array[$download_name]['db'])
                . '/include/dbconnopen.php';
        include $conn_file;
        $db_name= 'cnn' . ucfirst($download_list_array[$download_name]['db']);
        $database_conn=$$db_name;

        //create legends for certain enlace exports 
        $title_array = $download_list_array[$download_name]['titles'];
        $legend_array = $download_list_array[$download_name]['legend'];

        if ($download_name == 'enlace_new_surveys_deid' || $download_name == 'enlace_new_surveys' || $download_name == 'enlace_intake_assessments_deid' || $download_name == 'enlace_intake_assessments'){
        $get_pre_questions = "SELECT Baseline_Assessment_Question_ID, Question FROM Baseline_Assessment_Questions ORDER BY In_Table";
        $all_pre_questions = mysqli_query($cnnEnlace, $get_pre_questions);
        while ($q = mysqli_fetch_row($all_pre_questions)) {
            $title_array[] = "Pre: " . $q[1];
            $get_response_text_sqlsafe="SELECT Response_Select, Response_Text FROM Assessment_Responses WHERE Question_ID='$q[0]'";
            $response_text=mysqli_query($cnnEnlace, $get_response_text_sqlsafe);
            $legend_cell="";
            while ($response=mysqli_fetch_row($response_text)){
                $legend_cell.= $response[0] . "=" . $response[1] . "; ";
            }
            $legend_array[]=$legend_cell;
        }
        }
        if ($download_name == 'enlace_new_surveys_deid' || $download_name == 'enlace_new_surveys' || $download_name == 'enlace_impact_surveys_deid' || $download_name == 'enlace_impact_surveys'){
        $get_questions = "SELECT Baseline_Assessment_Question_ID, Question FROM Baseline_Assessment_Questions WHERE In_Table!='Participants_Baseline_Assessments' ORDER BY In_Table";
        $all_questions = mysqli_query($cnnEnlace, $get_questions);
        while ($q = mysqli_fetch_row($all_questions)) {
            $title_array[] = "Post: " . $q[1];
            $get_response_text_post_sqlsafe="SELECT Response_Select, Response_Text FROM Assessment_Responses WHERE Question_ID='$q[0]'";
            $response_text_post=mysqli_query($cnnEnlace, $get_response_text_post_sqlsafe);
            $legend_cell_post="";
            while ($response_post=mysqli_fetch_row($response_text_post)){
                $legend_cell_post.= $response_post[0] . "=" . $response_post[1] . "; ";
            }
            $legend_array[]=$legend_cell_post;
        }
        }

        // output the column headings
        fputcsv($output, $title_array);

        //output the legends where appropriate
        fputcsv($output, $legend_array);
        


        //get program access if relevant
        $program_access = $programs[$get_db_id];

        if ($program_access == 'a'){ //plain query for users with full access
            $query_sqlsafe = $download_list_array[$download_name]['query'] . $download_list_array[$download_name]['query2'] . $download_list_array[$download_name]['query3'];
        }
        else{ //for non-admin users, add limitations to query
            if (isset( $download_list_array[$download_name]['non_admin_string2'])){
                if ($download_list_array[$download_name]['add_access']==1){ 
                    $query_sqlsafe = $download_list_array[$download_name]['query'] .  $download_list_array[$download_name]['non_admin_string'] .  $download_list_array[$download_name]['query2'] .  $download_list_array[$download_name]['non_admin_string2'] .  $program_access . $download_list_array[$download_name]['query3'];
                }
                else{
                    $query_sqlsafe = $download_list_array[$download_name]['query'] .  $download_list_array[$download_name]['non_admin_string'] .  $download_list_array[$download_name]['query2'] .  $download_list_array[$download_name]['non_admin_string2'] . $download_list_array[$download_name]['query3'];
                }
            }
            else{
                if ($download_list_array[$download_name]['add_access']==1){ 
                    $query_sqlsafe = $download_list_array[$download_name]['query'] . $download_list_array[$download_name]['non_admin_string'] . $program_access . $download_list_array[$download_name]['query2'] . $download_list_array[$download_name]['query3'];
                }
                else{
                    $query_sqlsafe = $download_list_array[$download_name]['query'] . $download_list_array[$download_name]['non_admin_string'] . $download_list_array[$download_name]['query2'] . $download_list_array[$download_name]['query3'];
                }
            }
        }

        $rows = mysqli_query($database_conn, $query_sqlsafe);
    if ($download_name == 'enlace_participant_dosage' || $download_name == 'enlace_participant_dosage_deid' || $download_name == 'enlace_total_dosage' || $download_name == 'enlace_total_dosage_deid'){
        include_once("../enlace/include/dosage_percentage.php");
        include_once("../enlace/include/total_dosage_sum.php"); //only included for Enlace dosage calculation
    }

        // loop over the rows, outputting them
        while ($row = mysqli_fetch_row($rows)) {
            // if this is the Enlace dosage export, we need to calculate dosage
            if ($download_name == 'enlace_participant_dosage' || $download_name == 'enlace_participant_dosage_deid'){
                $dosage=calculate_dosage($row[1], $row[0]);
                array_push($row, $dosage[0]);
                array_push($row, $dosage[1]);
                array_push($row, $dosage[2]);
            }
            elseif ($download_name == 'enlace_total_dosage' || $download_name == 'enlace_total_dosage_deid'){
                $dosage_sum = calculate_dosage_sum($row[0]);
                array_push($row, $dosage_sum);
            }
            fputcsv($output, $row);
            
        }
        

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
generalized_download($_GET['download_name'], $USER->site_permissions);
//generalized_download('enlace_total_dosage', $USER->site_permissions);
?>