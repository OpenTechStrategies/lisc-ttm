<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

//custom query submission response
//submitted from: /reports/custom_query.php
//

//header('Content-type: text/csv');
header("Content-type: application/octet-stream");

header("Pragma: no-cache");
header("Expires: 0");

$csv_data = fopen('php://output', 'w');

header('Content-Disposition: attachment; filename="Export_Custom_Query.csv"');

$exports = "SELECT Users.*, Participant_Survey_Responses.*, Org_Partners.Partner_ID, Org_Partners.Partner_Name
            FROM Users
            JOIN Participant_Survey_Responses ON Users.User_ID = Participant_Survey_Responses.User_ID
            JOIN Programs ON Participant_Survey_Responses.Program_ID = Programs.Program_ID
            LEFT JOIN Org_Partners ON Org_Partners.Partner_ID = Programs.Program_Organization
            WHERE ";

include "../include/dbconnopen.php";
if ($_POST['first_name'] != '') {
    $first_name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['first_name']);
    $exports .= "First_Name = '" . $first_name_sqlsafe . "' AND ";
}
if ($_POST['last_name'] != '') {
    $last_name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['last_name']);
    $exports .= "Last_Name = '" . $last_name_sqlsafe . "' AND ";
}
if ($_POST['participant_type'] != '') {
    $participant_type_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['participant_type']);
    $exports .= "Participant_Type = '" . $participant_type_sqlsafe . "' AND ";
}
if ($_POST['gender'] != '') {
    $gender_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['gender']);
    $exports .= "Gender = '" . $gender_sqlsafe . "' AND ";
}
if ($_POST['age'] != '') {
    $age_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['age']);
    $exports .= "Age = '" . $age_sqlsafe . "' AND ";
}
if ($_POST['race'] != '') {
    $race_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['race']);
    $exports .= "Race = '" . $race_sqlsafe . "' AND ";
}
if ($_POST['survey_type'] != '') {
    $survey_type_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['survey_type']);
    $exports .= "Pre_Post_Late = '" . $survey_type_sqlsafe . "' AND ";
}
if ($_POST['address_number'] != '') {
    $address_number_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['address_number']);
    $exports .= "Address_Number LIKE '%" . $address_number_sqlsafe . "%' AND ";
}
if ($_POST['address_street_direction'] != '') {
    $address_street_direction_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['address_street_direction']);
    $exports .= "Address_Street_Direction LIKE '%" . $address_street_direction_sqlsafe . "%' AND ";
}
if ($_POST['address_street_name'] != '') {
    $address_street_name_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['address_street_name']);
    $exports .= "Address_Street_Name LIKE '%" . $address_street_name_sqlsafe . "%' AND ";
}
if ($_POST['address_street_type'] != '') {
    $address_street_type_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['address_street_type']);
    $exports .= "Address_Street_Type LIKE '%" . $address_street_type_sqlsafe . "%' AND ";
}
if ($_POST['zipcode'] != '') {
    $zipcode_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['zipcode']);
    $exports .= "Zipcode = '" . $zipcode_sqlsafe . "' AND ";
}
if ($_POST['program_id'] != '') {
    $program_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['program_id']);
    $exports .= "Program_ID = '" . $program_id_sqlsafe . "' AND ";
}

if ($_POST['question_2'] != '') {
    $question_2_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_2']);
    $exports .= "Question_2 = '" . $question_2_sqlsafe . "' AND ";
}
if ($_POST['question_3'] != '') {
    $question_3_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_3']);
    $exports .= "Question_3 = '" . $question_3_sqlsafe . "' AND ";
}
if ($_POST['question_4_a'] != '') {
    $question_4_a_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_4_a']);
    $exports .= "Question_4_A = '" . $question_4_a_sqlsafe . "' AND ";
}
if ($_POST['question_4_b'] != '') {
    $question_4_b_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_4_b']);
    $exports .= "Question_4_B = '" . $question_4_b_sqlsafe . "' AND ";
}
if ($_POST['question_5_a'] != '') {
    $question_5_a_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_5_a']);
    $exports .= "Question_5_A = '" . $question_5_a_sqlsafe . "' AND ";
}
if ($_POST['question_5_b'] != '') {
    $question_5_b_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_5_b']);
    $exports .= "Question_5_B = '" . $question_5_b_sqlsafe . "' AND ";
}
if ($_POST['question_6'] != '') {
    $question_6_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_6']);
    $exports .= "Question_6 = '" . $question_6_sqlsafe . "' AND ";
}
if ($_POST['question_7'] != '') {
    $question_7_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_7']);
    $exports .= "Question_7 = '" . $question_7_sqlsafe . "' AND ";
}
if ($_POST['question_8'] != '') {
    $question_8_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_8']);
    $exports .= "Question_8 = '" . $question_8_sqlsafe . "' AND ";
}
if ($_POST['question_9_a'] != '') {
    $question_9_a_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_9_a']);
    $exports .= "Question_9_A = '" . $question_9_a_sqlsafe . "' AND ";
}
if ($_POST['question_9_b'] != '') {
    $question_9_b_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_9_b']);
    $exports .= "Question_9_B = '" . $question_9_b_sqlsafe . "' AND ";
}
if ($_POST['question_14'] != '') {
    $question_14_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_14']);
    $exports .= "Question_14 = '" . $question_14_sqlsafe . "' AND ";
}
if ($_POST['question_11'] != '') {
    $question_11_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_11']);
    $exports .= "Question_11 = '" . $question_11_sqlsafe . "' AND ";
}
if ($_POST['question_12'] != '') {
    $question_12_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_12']);
    $exports .= "Question_12 = '" . $question_12_sqlsafe . "' AND ";
}
if ($_POST['question_13'] != '') {
    $question_13_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['question_13']);
    $exports .= "Question_13 = '" . $question_13_sqlsafe . "' AND ";
}

if ($_POST['partner_id'] != '') {
    $partner_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['partner_id']);
    $exports .= "Partner_ID = '" . $partner_id_sqlsafe . "' AND ";
}
if ($_POST['date_survey_administered'] != '') {
    $date_survey_administered_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['date_survey_administered']);
    $date_formatted = explode('/', $_POST['date_survey_administered']);
    $date_formatted = $date_formatted[2] . "-" . $date_formatted[0] . "-" . $date_formatted[1];
    $exports .= "Date_Survey_Administered = '" . $date_formatted . "' AND ";
}

//if there weren't any fields filled out, remove the "WHERE "
// otherwise remove that last AND
if (substr($exports, -6, 6) == "WHERE ") {
    $exports = substr($exports, 0, -6);
} else {
    $exports = substr($exports, 0, -4);
}

$exports = mysqli_query($cnnBickerdike, $exports);
include "../include/dbconnclose.php";

//add column names
$columns = mysqli_fetch_fields($exports);
$column_names = array();

//add columns (but don't add duplicates)
foreach ($columns as $column) {
    if (!in_array($column->name, $column_names)) {
        array_push($column_names, $column->name);
    }
}

fputcsv($csv_data, $column_names);

//add data
while($export = mysqli_fetch_assoc($exports)) {
    fputcsv($csv_data, $export);
}
fclose($csv_data);

?>