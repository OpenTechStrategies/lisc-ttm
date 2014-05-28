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

if ($_POST['first_name'] != '') {
    $exports .= "First_Name = '" . $_POST['first_name'] . "' AND ";
}
if ($_POST['last_name'] != '') {
    $exports .= "Last_Name = '" . $_POST['last_name'] . "' AND ";
}
if ($_POST['participant_type'] != '') {
    $exports .= "Participant_Type = '" . $_POST['participant_type'] . "' AND ";
}
if ($_POST['gender'] != '') {
    $exports .= "Gender = '" . $_POST['gender'] . "' AND ";
}
if ($_POST['age'] != '') {
    $exports .= "Age = '" . $_POST['age'] . "' AND ";
}
if ($_POST['race'] != '') {
    $exports .= "Race = '" . $_POST['race'] . "' AND ";
}
if ($_POST['survey_type'] != '') {
    $exports .= "Pre_Post_Late = '" . $_POST['survey_type'] . "' AND ";
}
if ($_POST['address_number'] != '') {
    $exports .= "Address_Number LIKE '%" . $_POST['address_number'] . "%' AND ";
}
if ($_POST['address_street_direction'] != '') {
    $exports .= "Address_Street_Direction LIKE '%" . $_POST['address_street_direction'] . "%' AND ";
}
if ($_POST['address_street_name'] != '') {
    $exports .= "Address_Street_Name LIKE '%" . $_POST['address_street_name'] . "%' AND ";
}
if ($_POST['address_street_type'] != '') {
    $exports .= "Address_Street_Type LIKE '%" . $_POST['address_street_type'] . "%' AND ";
}
if ($_POST['zipcode'] != '') {
    $exports .= "Zipcode = '" . $_POST['zipcode'] . "' AND ";
}
if ($_POST['program_id'] != '') {
    $exports .= "Program_ID = '" . $_POST['program_id'] . "' AND ";
}

if ($_POST['question_2'] != '') {
    $exports .= "Question_2 = '" . $_POST['question_2'] . "' AND ";
}
if ($_POST['question_3'] != '') {
    $exports .= "Question_3 = '" . $_POST['question_3'] . "' AND ";
}
if ($_POST['question_4_a'] != '') {
    $exports .= "Question_4_A = '" . $_POST['question_4_a'] . "' AND ";
}
if ($_POST['question_4_b'] != '') {
    $exports .= "Question_4_B = '" . $_POST['question_4_b'] . "' AND ";
}
if ($_POST['question_5_a'] != '') {
    $exports .= "Question_5_A = '" . $_POST['question_5_a'] . "' AND ";
}
if ($_POST['question_5_b'] != '') {
    $exports .= "Question_5_B = '" . $_POST['question_5_b'] . "' AND ";
}
if ($_POST['question_6'] != '') {
    $exports .= "Question_6 = '" . $_POST['question_6'] . "' AND ";
}
if ($_POST['question_7'] != '') {
    $exports .= "Question_7 = '" . $_POST['question_7'] . "' AND ";
}
if ($_POST['question_8'] != '') {
    $exports .= "Question_8 = '" . $_POST['question_8'] . "' AND ";
}
if ($_POST['question_9_a'] != '') {
    $exports .= "Question_9_A = '" . $_POST['question_9_a'] . "' AND ";
}
if ($_POST['question_9_b'] != '') {
    $exports .= "Question_9_B = '" . $_POST['question_9_b'] . "' AND ";
}
if ($_POST['question_14'] != '') {
    $exports .= "Question_14 = '" . $_POST['question_14'] . "' AND ";
}
if ($_POST['question_11'] != '') {
    $exports .= "Question_11 = '" . $_POST['question_11'] . "' AND ";
}
if ($_POST['question_12'] != '') {
    $exports .= "Question_12 = '" . $_POST['question_12'] . "' AND ";
}
if ($_POST['question_13'] != '') {
    $exports .= "Question_13 = '" . $_POST['question_13'] . "' AND ";
}

if ($_POST['partner_id'] != '') {
    $exports .= "Partner_ID = '" . $_POST['partner_id'] . "' AND ";
}
if ($_POST['date_survey_administered'] != '') {
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

include "../include/dbconnopen.php";
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