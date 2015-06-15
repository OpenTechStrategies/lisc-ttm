<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id);

?>
<?php

//make arrays for selector functions


$school_year_array = array(2013 => '2013', 2014 => '2014', 2015 => '2015', 2016 => '2016', 2017 => '2017'); 
$get_college_list_sqlsafe = "SELECT * FROM Colleges ORDER BY College_Name";
include "../include/dbconnopen.php";
$college_list = mysqli_query($cnnTRP, $get_college_list_sqlsafe);
$college_array = array();
while ($college = mysqli_fetch_row($college_list)){
    $college_array[$college[0]] = $college[1];
}
$term_type_array = array(1 => 'Semester', 2 => 'Quarter', 3 => 'Trimester');
$season_array = array(1 => 'Fall', 2 => 'Winter', 3 => 'Spring', 4 => 'Summer');
$get_major_list_sqlsafe = "SELECT DISTINCT Major FROM LC_Terms ORDER BY Major";
$major_list = mysqli_query($cnnTRP, $get_major_list_sqlsafe);
$major_array = array();
while ($major = mysqli_fetch_row($major_list)){
    $major_array[$major[0]] = $major[0];
}
$get_minor_list_sqlsafe = "SELECT DISTINCT Minor FROM LC_Terms ORDER BY Minor";
$minor_list = mysqli_query($cnnTRP, $get_minor_list_sqlsafe);
$minor_array = array();
while ($minor = mysqli_fetch_row($minor_list)){
    $minor_array[$minor[0]] = $minor[0];
}
$get_selectivity_list_sqlsafe = "SELECT DISTINCT Selectivity FROM Colleges";
$selectivity_list = mysqli_query($cnnTRP, $get_selectivity_list_sqlsafe);
$selectivity_array = array();
while ($selectivity = mysqli_fetch_row($selectivity_list)){
    $selectivity_array[] = $selectivity[0];
}
$match_array = array(1 => 'Above Match', 2 => 'Match', 3 => 'Below Match');
$yn_array = array(1 => 'Yes', 2 => 'No');

// when they start adding new cohorts, we'll use this:
//$get_cohort_list_sqlsafe = "SELECT DISTINCT Cohort FROM LC_Basics";
//$cohort_list = mysqli_query($cnnTRP, $get_cohort_list_sqlsafe);
$cohort_array = array( 'ChiSem' => 'Chicago Semester', 'CM' => 'Casa Norte', 'ACM' => 'Associated Colleges of the Midwest', 'NONE' => 'Does not have one', 'Blank' => 'Missing/Not reported', 'ARCH' => 'ARCHEWORKS');

$status_array = array('S' => 'Signed', 'S*' => 'Scheduled to Sign', 'MS' => 'May Sign', 'OUT' => 'Moved Out', 'HOLD' => 'Pending App', 'DENIED' => 'Not Admitted', 'N' => 'Not Interested');
$get_participant_list_sqlsafe = "SELECT Participant_ID, First_Name, Last_Name FROM Participants INNER JOIN Participants_Programs WHERE Program_ID = 6";
$participant_list = mysqli_query($cnnTRP, $get_participant_list_sqlsafe);
$participant_array = array();
while ($participant = mysqli_fetch_row($participant_list)){
    $participant_array[$participant[0]] = $participant[1] . " " . $participant[2];
}
$grade_array = array(1 => 'Freshman', 2 => 'Sophomore', 3 => 'Junior', 4 => 'Senior');
$get_education_levels_sqlsafe = "SELECT * FROM Educational_Levels";
$education_levels = mysqli_query($cnnTRP, $get_education_levels_sqlsafe);
$education_levels_array = array();
while ($education = mysqli_fetch_row($education_levels)) {
    $education_levels_array[$education[0]] = $education[1];
}



/* Creates a select object for data entry
 * Takes:
 * $array_of_options: the array of possible values represented in this select
 * $existing_value: the stored value for this field, if any
 * $id_string: the desired id for this select object
 * $class_string: the class(es) to be attached to this select object
 *
 * Returns:
 * A string that can be inserted as html.
*/
function la_casa_edit_data_gen_selector($array_of_options, $existing_value, $id_string, $class_string){
    $result = "<select id = " . $id_string;
    $result .= " style = 'width:100px' class = '" . $class_string . "'>";
    $result .= "<option value = 0>----</option>"; 
    foreach ($array_of_options as $val => $display){
        $result .= "<option value = '" . $val . "' ";
        $result .= ($existing_value == $val ? 'selected="selected"' : null) . ">";
        $result .= $display . " </option>"; 
    }
    $result .= "</select>";
    
    return $result;
}

/* Creates an input object for data entry
 * Takes:
 * $existing_value: the stored value for this field, if any
 * $id_string: the desired id for this input object
 * $class_string: the class(es) to be attached to this input object
 *
 * Returns:
 * A string that can be inserted as html.
*/
function la_casa_edit_data_gen_input($existing_value, $id_string, $class_string, $helptext=null){
    $result = "<input type=text id=" . $id_string;
    $result .= " class='" . $class_string . "'";
    $result .= " size=5px ";
    $result .= " value='" . $existing_value;
    $result .= "'>";
    if ($helptext){
        $result .= "<span class='helptext'> " . $helptext . "</span>";
    }
    return $result;
}

/* Creates an html object for data display
 * Takes:
 * $array_of_options: the array of possible values for this field
 * $stored_value: the stored value for this field, if any
 *
 * Returns:
 * A string that displays the value of the field in human-readable format
*/
function display_selected($select_array, $stored_value){
    if ( array_key_exists($stored_value, $select_array)) {
        return $select_array[$stored_value];
    }
}

/*
 * Shows the date in a US format
 * Takes:
 * $date: a date string in YYYY-MM-DD format
 * Returns:
 * A date string in MM/DD/YYYY format
 */
function display_date ($date){
    $date_pieces = explode('-', $date);
    if ($date_pieces[2]){
        $display_date = $date_pieces[1] . "/" . $date_pieces[2] . "/" . $date_pieces[0];
    }
    else{
        $display_date = "";
    }
    return $display_date;
}


?>