<?php
include "../include/dbconnopen.php";

if ($_POST['action']=='edit' && $_POST['subject'] == 'college'){
   $edit_college_data_sqlsafe = "UPDATE La_Casa_Basics SET 
         College_ID = '" . mysqli_real_escape_string($cnnTRP, $_POST['college_id']) . "',
         Term_Type  = '" . mysqli_real_escape_string($cnnTRP, $_POST['term_type']) . "',
         Term  = '" . mysqli_real_escape_string($cnnTRP, $_POST['term_id']) . "',
         School_Year  = '" . mysqli_real_escape_string($cnnTRP, $_POST['school_year']) . "',
         Credits = '" . mysqli_real_escape_string($cnnTRP, $_POST['credits']) . "',
         Loan_Applications = '" . mysqli_real_escape_string($cnnTRP, $_POST['loan_apps']) . "',
         Loan_Volume  = '" . mysqli_real_escape_string($cnnTRP, $_POST['loan_volume']) . "',
         Loans_Received = '" . mysqli_real_escape_string($cnnTRP, $_POST['loans_received']) . "'
WHERE Student_ID = '" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
   echo $edit_college_data_sqlsafe;
   mysqli_query($cnnTRP, $edit_college_data_sqlsafe);
                              
}
elseif ($_POST['action'] == 'new' && $_POST['subject'] == 'college'){
       $add_college_data_sqlsafe = "INSERT INTO La_Casa_Basics
       (Participant_ID_Students,  College_ID, Term_Type, Term,
       School_Year, Credits, Loan_Applications, Loan_Volume,
       Loans_Received)
       VALUES
       ( '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['college_id']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['term_type']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['term_id']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['school_year']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['credits']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['loan_apps']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['loan_volume']) . "',
'" . mysqli_real_escape_string($cnnTRP, $_POST['loans_received']) . "'

)";
       echo $add_college_data_sqlsafe;
   mysqli_query($cnnTRP, $add_college_data_sqlsafe);
}

?>