<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *   Copyright (C) 2018 Open Tech Strategies, LLC
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
include_once("settings.php");
include_once("../classes/participant.php");

if (!function_exists("find_survey_entry_code_in_db")) {

    function find_survey_entry_code_in_db ( $participant_id, $session_id, $pre_post ) {
        $lookup = "SELECT Code FROM Assessments_Codes " .
            " WHERE Participant_ID = $participant_id " .
            "       AND Session_ID = $session_id " .
            "       AND Pre_Post = $pre_post ";

        include "../include/dbconnopen.php";
        $lookup_result = mysqli_query($cnnEnlace, $lookup);
        include "../include/dbconnclose.php";

        return (mysqli_num_rows($lookup_result) > 0) ? mysqli_fetch_row($lookup_result)[0] : false;
    }

    function generate_new_survey_entry_code ( $participant_id, $session_id, $pre_post ) {
        $code = [];

        // Base 32 for readability: https://en.wikipedia.org/wiki/Base32
        foreach(range(1, 8) as $idx) {
           $val = rand(0, 32);
           if($val < 26) {
               $val = chr(ord('A') + $val);
           } else {
               $val = $val - 24;
           }
           $code[] = $val;
        }
        $code_str = join('', $code);

        include "../include/dbconnopen.php";
        //Check to see if in db, if so, recurse.  Potentially infinitely.
        //But, only after 32^6 or so codes have been generated do I think we'll see problems.
        if(mysqli_num_rows(mysqli_query($cnnEnlace, "SELECT * FROM Assessments_Codes WHERE Code = '$code_str'")) > 0) {
            return generate_new_survey_entry_code ($participant_id, $session_id, $pre_post);
        } else {
            $insert_code = "INSERT INTO Assessments_Codes (Participant_ID, Session_ID, Pre_Post, Code) " .
                " VALUES ($participant_id, $session_id, $pre_post, '$code_str')";
    
            mysqli_query($cnnEnlace, $insert_code);
            include "../include/dbconnclose.php";
    
            return $code_str;
        }
    }

    function generate_survey_entry_code( $participant_id, $session_id, $pre_post ) {
        $possible_code = find_survey_entry_code_in_db($participant_id, $session_id, $pre_post);
        return $possible_code ? $possible_code : generate_new_survey_entry_code($participant_id, $session_id, $pre_post);
    }

    function lookup_survey_code_pre_post( $code ) {
        $lookup = "SELECT Pre_Post FROM Assessments_Codes WHERE Code = '" . strtoupper($code) . "'";

        include "../include/dbconnopen.php";
        $lookup_result = mysqli_query($cnnEnlace, $lookup);

        if (mysqli_num_rows($lookup_result) == 0) {
            $die_unauthorized();
        }

        return mysqli_fetch_row($lookup_result)[0];
    }

    // Not only validates the hash, but ensures the survey is available for using
    function lookup_and_validate_survey_entry_code( $code, $expected_pre_post ) {
        global $die_unauthorized;

        $lookup = "SELECT * FROM Assessments_Codes WHERE Code = '" . strtoupper($code) . "'";

        include "../include/dbconnopen.php";
        $lookup_result = mysqli_query($cnnEnlace, $lookup);

        if (mysqli_num_rows($lookup_result) == 0) {
            $die_unauthorized();
        }

        $lookup_row = mysqli_fetch_array($lookup_result);

        if($expected_pre_post != $lookup_row['Pre_Post']) {
            $die_unauthorized();
        }

        $participant_id = $lookup_row['Participant_ID'];
        $session_id = $lookup_row['Session_ID'];
        $pre_post = $lookup_row['Pre_Post'];

        $assessment_sql = "SELECT * FROM Assessments " .
            "WHERE Session_ID = '$session_id' " .
            "AND Participant_ID = '$participant_id' " .
            "AND Pre_Post = $pre_post;";
        $assessment_result = mysqli_query($cnnEnlace, $assessment_sql);

        if(mysqli_num_rows($assessment_result) > 0) {
            $die_unauthorized();
        }

        $in_program_sql = "SELECT * FROM Participants_Programs " .
            "WHERE Program_ID = '$session_id' " .
            "AND Participant_ID = '$participant_id'";
        $in_program_result = mysqli_query($cnnEnlace, $in_program_sql);
        if(mysqli_num_rows($in_program_result) == 0) {
            $die_unauthorized();
        }
        include "../include/dbconnclose.php";

        return $lookup_row;
    }
}
?>
