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

include "../include/dbconnopen.php";

$get_school_year_list_sqlsafe = "SELECT DISTINCT School_Year FROM LC_Terms ORDER BY School_Year";
$school_year_list = mysqli_query($cnnTRP, $get_school_year_list_sqlsafe);
$school_year_array = array();
while ($school_year = mysqli_fetch_row($school_year_list)){
    $school_year_array[$school_year[0]] = $school_year[0];
}
$get_college_list_sqlsafe = "SELECT College_ID, College_Name FROM Colleges GROUP BY College_Name ORDER BY College_Name";
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
$get_cohort_list_sqlsafe = "SELECT * FROM Cohorts";
$cohort_list = mysqli_query($cnnTRP, $get_cohort_list_sqlsafe);
$cohort_array = array();
while ($cohort = mysqli_fetch_row($cohort_list)){
    $cohort_array[$cohort[0]] = $cohort[1];
}
$get_status_list_sqlsafe = "SELECT * FROM Statuses";
$status_list = mysqli_query($cnnTRP, $get_status_list_sqlsafe);
$status_array = array();
while ($status = mysqli_fetch_row($status_list)){
    $status_array[$status[0]] = $status[1];
}

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
$dependency_array = array('Dependent', 'Independent');


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

/* Creates a select object for data entry along with an input element in case
 * the user wants to add a new member to the array 
 *
 * Takes:
 * $array_of_options: the array of possible values represented in this select
 * $existing_value: the stored value for this field, if any
 * $id_string: the desired id for this select object
 * $class_string: the class(es) to be attached to this select object
 *
 * Returns: 
 * A string that can be inserted as html to form a select element and an
 * input element 
*/

function la_casa_edit_data_gen_selector_plus($array_of_options, $existing_value, $id_string, $class_string){
    $result = "<select id = " . $id_string;
    $result .= " style = 'width:100px' class = '" . $class_string . "'>";
    $result .= "<option value = 0>----</option>"; 
    foreach ($array_of_options as $val => $display){
        $result .= "<option value = '" . $val . "' ";
        $result .= ($existing_value == $val ? 'selected="selected"' : null) . ">";
        $result .= $display . " </option>"; 
    }
    $result .= "</select>";
    $result.= "<br /><span class='helptext " . $class_string .  "'>Or add a new value:</span>";
    $result .= "<input type=text id='" . $id_string . "_new";
    $result .= "' class='" . $class_string . "'";
    $result .= " size=5px ";
    $result .= ">";
    
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
        $result .= "<span class='helptext edit_term'> " . $helptext . "</span>";
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


/*
 * Catch cases where we are adding a new element to an array of choices
 * (e.g. majors) instead of selecting an element from that array
 *
 * Takes:
 * $posted_array: The variable that represents one element selected from an
 * array of possibilities (like majors)
 * $posted_new: A variable representing a new element to be inserted into that
 * array (via being inserted into the database)
 * Returns:
 * The value to be inserted into the database.
 */

function array_add_or_select($posted_array, $posted_new){
    if ($posted_new != ""){
        return $posted_new;
    }
    else{
        return $posted_array;
    }
}

?>