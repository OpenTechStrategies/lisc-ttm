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
            "Health Signage?", "Healthy Items in the Front?", "Date", "Store ID")),
        
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
                AND Programs.Program_Organization=Org_Partners.Partner_ID)
                 WHERE Participant_Type=`adult`',
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
                AND Programs.Program_Organization=Org_Partners.Partner_ID)
                 WHERE Participant_Type=`adult`',
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
                AND Programs.Program_Organization=Org_Partners.Partner_ID)
                 WHERE Participant_Type=`parent`',
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
            'SELECT Users.User_ID,  Gender, Age, 
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
                 WHERE Participant_Type=`parent`',
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
                AND Programs.Program_Organization=Org_Partners.Partner_ID)
                 WHERE Participant_Type=`youth`',
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
                AND Programs.Program_Organization=Org_Partners.Partner_ID)
                 WHERE Participant_Type=`youth`',
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
                "Child ID"))
        
        );
    if (array_key_exists($download_name, $download_list_array)){
    if (isset($_COOKIE['user'])){
        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$download_name . '.csv');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // output the column headings
        fputcsv($output, $download_list_array[$download_name]['titles']);

        // fetch the data
        $conn_file='../'.$download_list_array[$download_name]['db'].'/include/dbconnopen.php';
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