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

/* Begin redeclaration-protection wrapper:

   Nested includes seem to cause this file to be included multiple
   times from somewhere.  While we should trace that down, it may
   turn out to be unavoidable or at least very difficult to avoid,
   so we just protect against redeclaration with this wrapper.  
   See issue #34 and issue #35 for more details. */
if(!function_exists("calculate_dosage")) {

/* This takes a session ID and, optionally, a participant ID.  If
 * participant id is *not* provided, then start and end dates *must* be
 * provided.  If a participant ID is provided, then start and end dates
 * are unnecessary.  In fact, please *don't* provide them, since they
 * would affect the dosage percentage in unexpected ways.
 *
 * If a participant is provided, it returns the number of days that this
 * student attended the session, the sum of hours this student spent in
 * this program (if available), and the dosage percentage. 
 *
 * If not, then it returns the number of days that all participants
 * spent in this program, the sum of hours that all students spent in
 * this program, and the total dosage percentage across all
 * students. (Only the sum of hours is used, but the others are included
 * for compatibility with the existing structure of the function).
 *
 * Also takes boolean "exclude_dropped."  If it is true, then for a
 * session-wide dosage calculation only count those participants who had
 * not dropped before the provided end date.
 */

    function calculate_dosage ( $session, $participant, $start_date, $end_date, $exclude_dropped=false ) {
        include $_SERVER['DOCUMENT_ROOT'] . "/enlace/include/dbconnopen.php";
        $session_sqlsafe=mysqli_real_escape_string($cnnEnlace, $session);
        $participant_sqlsafe=mysqli_real_escape_string($cnnEnlace, $participant);
        $start_sqlsafe = mysqli_real_escape_string($cnnEnlace, $start_date);
        $end_sqlsafe = mysqli_real_escape_string($cnnEnlace, $end_date);
    
        // raise some errors if we get an unexpected combination of inputs
        if (! $participant_sqlsafe && ! $start_sqlsafe && ! $end_sqlsafe) {
            // "<br> Please provide start and end dates.";
            return null;
        }
        if ( (! $start_sqlsafe && $end_sqlsafe ) || ( $start_sqlsafe && ! $end_sqlsafe) ) {
            // "<br> Please provide both a start and an end date.";
            return null;
        }
        if ( $participant_sqlsafe &&  ($start_sqlsafe || $end_sqlsafe) ) {
            // "<br> WARNING: Start and end dates are not considered when finding an individual's dosage.";
        }
    

        /* This select finds the total number of days that this program was 
         * offered. */
        if ($start_sqlsafe && $end_sqlsafe) {
            $get_max_days = "SELECT COUNT(*) FROM Program_Dates WHERE Program_ID='$session_sqlsafe' AND Date_Listed > '$start_sqlsafe' AND Date_Listed < '$end_sqlsafe'";
        }
        else {
            $get_max_days = "SELECT COUNT(*) FROM Program_Dates WHERE Program_ID='$session_sqlsafe'";
        }
        $max_days_obj = mysqli_query($cnnEnlace, $get_max_days);
        $max = mysqli_fetch_row($max_days_obj);
        $max_days = $max[0];

        /* This select finds the number of days that the student attended this
         * program. */
        $total_num_days_attended = 0;
        if ($participant) {
            $num_days_attended = "SELECT COUNT(Program_Date_ID) FROM 
        Participants_Programs
        INNER JOIN Program_Dates ON Participants_Programs.Program_ID=Program_Dates.Program_ID
        INNER JOIN Session_Names ON Participants_Programs.Program_ID=Session_Names.Session_ID
        INNER JOIN Programs ON Session_Names.Program_Id=Programs.Program_ID
        INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID
        LEFT JOIN Absences ON ( Program_Date_ID = Program_Date AND Participants_Programs.Participant_ID=
        Absences.Participant_ID)
            WHERE Absence_ID IS NULL AND Participants_Programs.Participant_ID='$participant_sqlsafe'
            AND Session_ID='$session_sqlsafe';";
            $attended_days=mysqli_query($cnnEnlace, $num_days_attended);
            $num_attended=mysqli_fetch_row($attended_days);
            $total_num_days_attended = $num_attended[0];
            $enrollees = null;
        }
        else {
            // num participants in session
            if (! $exclude_dropped ) {
                $num_participants_query = "SELECT COUNT(*) FROM Participants_Programs WHERE
                    Program_ID='$session_sqlsafe' AND Participant_ID > 0";
            }
            else {
                $num_participants_query = "SELECT COUNT(*) FROM Participants_Programs WHERE
                    Program_ID='$session_sqlsafe' AND Participant_ID > 0
                    AND (Date_Dropped IS NULL OR Date_Dropped >
                    '$end_sqlsafe')";
            }
            $participants_found = mysqli_query($cnnEnlace, $num_participants_query);
            $num_participants_array=mysqli_fetch_row($participants_found);
            $num_session_participants = $num_participants_array[0];
            $enrollees = $num_session_participants;
            // num absences
            if ( $exclude_dropped ) {
                // then do include drops, so be sure that you don't
                // count the absences of people who've dropped the
                // program
                $session_absences_query = "SELECT COUNT( DISTINCT Absence_ID) FROM Absences LEFT JOIN Program_Dates
                    ON Program_Date = Program_Date_ID LEFT JOIN
                    Participants_Programs on (Program_Dates.Program_ID =
                    Participants_Programs.Program_ID and
                    Absences.Participant_ID =
                    Participants_Programs.Participant_ID) WHERE
                    Program_Dates.Program_ID = '$session_sqlsafe' and
                    Date_Listed > '$start_sqlsafe' AND Date_Listed <
                    '$end_sqlsafe' and
                    (Participants_Programs.Date_Dropped is null or
                    Participants_Programs.Date_Dropped > '$end_sqlsafe')";
            }
            else {
                $session_absences_query = "SELECT COUNT( DISTINCT
                    Absence_ID) FROM Absences LEFT JOIN Program_Dates
                    ON Program_Date = Program_Date_ID LEFT JOIN
                    Participants_Programs on (Program_Dates.Program_ID =
                    Participants_Programs.Program_ID and
                    Absences.Participant_ID =
                    Participants_Programs.Participant_ID) WHERE
                    Program_Dates.Program_ID = '$session_sqlsafe' and
                    Date_Listed > '$start_sqlsafe' AND Date_Listed <
                    '$end_sqlsafe'";
            }
            // count all dates after a person dropped as if they were absences?
            $session_absences_obj = mysqli_query($cnnEnlace, $session_absences_query);
            $session_absences_array=mysqli_fetch_row($session_absences_obj);
            $num_session_absences = $session_absences_array[0];
            $total_num_days_attended = ($max_days * $num_session_participants) - $num_session_absences;
        }
        /* Find the hours this person spent in the program. */
        /* Get daily hours: */
        $program_daily_hours="SELECT Start_Hour, Start_Suffix, End_Hour, End_Suffix,"
            . " Max_Hours FROM Programs INNER JOIN Session_Names "
            . " ON Session_Names.Program_ID=Programs.Program_ID WHERE Session_ID='$session_sqlsafe'";
        $program_hours_per_day = mysqli_query($cnnEnlace, $program_daily_hours);
        $program_hours = mysqli_fetch_array($program_hours_per_day);
        if ($program_hours['Start_Hour'] != '' && $program_hours['Start_Hour'] != 0  && $program_hours['End_Hour'] != '' && $program_hours['End_Hour'] != 0){
            if ($program_hours['End_Suffix'] == 'pm'){
                $program_hours['End_Hour'] += 12;
            }
            if ($program_hours['Start_Suffix'] == 'pm'){
                $program_hours['Start_Hour'] += 12;
            }
            $daily_hours = $program_hours['End_Hour'] - $program_hours['Start_Hour'];
        }
        elseif ($program_hours['Max_Hours'] != '' && $program_hours['Max_Hours'] != 0){
            $daily_hours = $program_hours['Max_Hours'];
        }
        else {
            // the default is two hours
            $daily_hours = 2;
        }

        //final test
        if ($daily_hours == 0 || $daily_hours == ''){
            $daily_hours = 2;
        }
        $sum_hours=$total_num_days_attended*$daily_hours;
  
        include "dbconnclose.php";
        /* Calculate the dosage percentage based on days attended and total days: */
        if ($max_days != 0) {
            $percentage = number_format(($total_num_days_attended / $max_days) * 100, 2) . '%';
        } else {
            $percentage = 'N/A';
        }
        return array($total_num_days_attended, $sum_hours, $percentage, $enrollees);
    }

/* End redeclaration-protection wrapper: */
}

//echo "test without participant <br>";
//echo calculate_dosage ( 39, null, '2015-01-01', '2015-06-05' );
//echo "<br> expect 4 hrs for session 39 with 1/1/15 - 6/5/15";