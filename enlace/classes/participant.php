<?php

class Participant {

    public $participant_id; //contact id.

    /**
     * Enlace participant empty constructor.
     *
     * @return Empty participant object.
     */

    public function __construct() {
        
    }

    /**
     * Load participant by participant id.
     *
     * @param int participant_id The participant_id of the participant that is being loaded.
     * @return array Loaded participant object array.
     */
    public function load_with_participant_id($participant_id) {
        include "../include/dbconnopen.php";
        $participant_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $participant_id);
        $this->participant_id = $participant_id_sqlsafe;
        $get_participant_info = "SELECT * FROM Participants WHERE Participant_ID='$participant_id_sqlsafe'";
        $participant_info = mysqli_query($cnnEnlace, $get_participant_info);
        $temp_participant = mysqli_fetch_array($participant_info);
        include "../include/dbconnclose.php";

        $this->first_name = $temp_participant['First_Name'];
        $this->last_name = $temp_participant['Last_Name'];
        $this->day_phone = $temp_participant['Day_Phone'];
        $this->evening_phone = $temp_participant['Evening_Phone'];
        $this->role = $temp_participant['Role'];
        $this->full_address = $temp_participant['Address_Num'] . " " . $temp_participant['Address_Dir'] . " " .
                $temp_participant['Address_Street'] . " " . $temp_participant['Address_Street_Type'] . "<br> " .
                $temp_participant['Address_City'] . ", " . $temp_participant['Address_State'] . " " . $temp_participant['Address_ZIP'];
        $this->streetnum = $temp_participant['Address_Num'];
        $this->streetdir = $temp_participant['Address_Dir'];
        $this->street = $temp_participant['Address_Street'];
        $this->streettype = $temp_participant['Address_Street_Type'];
        $this->city = $temp_participant['Address_City'];
        $this->state = $temp_participant['Address_State'];
        $this->zip = $temp_participant['Address_ZIP'];
        $this->dob = $temp_participant['DOB'];
        $this->age = $temp_participant['Age'];
        $this->gender = $temp_participant['Gender'];
        $this->grade = $temp_participant['Grade'];
        $this->grade_entered = $temp_participant['Grade_Entered'];
        $this->date_entered = $temp_participant['Date_Entered'];
        $this->email = $temp_participant['Email'];
        $this->schoolid = $temp_participant['School'];
        $this->absences = $temp_participant['Early_Warning_Absences'];
        $this->failed = $temp_participant['Early_Warning_Failed'];
        $this->discipline = $temp_participant['Early_Warning_Discipline'];
        $this->teacher = $temp_participant['Referring_Teacher'];
    }

    /*
     * Find the name of the school that the participant is linked to.
     */

    public function get_school() {
        $find_school = "SELECT Institution_Name FROM Institutions WHERE Inst_ID='$this->schoolid'";
        include "../include/dbconnopen.php";
        $school_info = mysqli_query($cnnEnlace, $find_school);
        $school = mysqli_fetch_row($school_info);
        include "../include/dbconnclose.php";

        return $school[0];
    }

    /*
     * Check if the participant is enrolled in any programs.
     */

    public function is_enrolled() {
        $get_num_programs = "SELECT COUNT(*)
        FROM Participants_Programs WHERE Participant_ID='$this->participant_id'";
        include "../include/dbconnopen.php";
        $program_info = mysqli_query($cnnEnlace, $get_num_programs);
        $num_programs = mysqli_fetch_row($program_info);
        if ($num_programs[0] > 0) {
            return 'Yes';
        } else {
            return 'No';
        }
        include "../include/dbconnclose.php";
    }

    /*
     * Get baseline assessment results (deprecated since the baseline is now included in pre-surveys)
     */

    public function baseline() {
        $select_baseline = "SELECT * FROM Participants_Baseline_Assessments "
                . "WHERE Participant_ID = '$this->participant_id' "
                . "ORDER BY Date_Logged DESC";

        include "../include/dbconnopen.php";
        $baseline_info = mysqli_query($cnnEnlace, $select_baseline);
        $baseline = mysqli_fetch_array($baseline_info);
        include "../include/dbconnclose.php";

        $this->baseline_date = $baseline['Date_Logged'];
        $this->home_lang = $baseline['Home_Language'];
        $this->country_origin = $baseline['US_Born'];
        $this->race_base = $baseline['Race'];
        $this->bys1 = $baseline['BYS_1'];
        $this->bys2 = $baseline['BYS_2'];
        $this->bys3 = $baseline['BYS_3'];
        $this->bys4 = $baseline['BYS_4'];
        $this->bys5 = $baseline['BYS_5'];
        $this->bys6 = $baseline['BYS_6'];
        $this->bys7 = $baseline['BYS_7'];
        $this->bys8 = $baseline['BYS_8'];
        $this->bys9 = $baseline['BYS_9'];
        $this->bysT = $baseline['BYS_T'];
        $this->bysE = $baseline['BYS_E'];

        $this->jvq1 = $baseline['JVQ_1'];
        $this->jvq2 = $baseline['JVQ_2'];
        $this->jvq3 = $baseline['JVQ_3'];
        $this->jvq4 = $baseline['JVQ_4'];
        $this->jvq5 = $baseline['JVQ_5'];
        $this->jvq6 = $baseline['JVQ_6'];
        $this->jvq7 = $baseline['JVQ_7'];
        $this->jvq8 = $baseline['JVQ_8'];
        $this->jvq9 = $baseline['JVQ_9'];
        $this->jvqT = $baseline['JVQ_T'];
        $this->jvqE = $baseline['JVQ_E'];
        $this->jvqscore = $baseline['JVQ_1'] + $baseline['JVQ_2'] + $baseline['JVQ_3'] + $baseline['JVQ_4'] + $baseline['JVQ_5'] +
                $baseline['JVQ_6'] + $baseline['JVQ_7'] + $baseline['JVQ_8'] + $baseline['JVQ_9'] + $baseline['JVQ_T'] + $baseline['JVQ_E'];
    }

    /*
     * Get survey results from pre surveys
     */

    public function pre_surveys() {
        $get_caring_adults = "SELECT * FROM Participants_Caring_Adults WHERE Participant_ID='$this->participant_id' AND Pre_Post=1
                ORDER BY Date_Logged DESC LIMIT 1";
        //echo $get_caring_adults;
        include "../include/dbconnopen.php";
        $caring_adults = mysqli_query($cnnEnlace, $get_caring_adults);
        $care_adult = mysqli_fetch_array($caring_adults);
        include "../include/dbconnclose.php";

        $this->attn = $care_adult['Pay_Attention'];
        $this->check = $care_adult['Check_In'];
        $this->compliment = $care_adult['Compliment'];
        $this->upset = $care_adult['Upset_Discussion'];
        $this->crisis = $care_adult['Crisis_Help'];
        $this->advice = $care_adult['Personal_Advice'];
        $this->familiar = $care_adult['Know_You'];
        $this->importance_know = $care_adult['KnowImportance'];
        $this->date_caring = $care_adult['Date_Logged'];
        $this->program_caring = $care_adult['Program'];

        $get_future = "SELECT * FROM Participants_Future_Expectations WHERE Participant_ID='$this->participant_id' AND Pre_Post=1
                ORDER BY Date_Logged DESC LIMIT 1";
        //echo $get_future;
        include "../include/dbconnopen.php";
        $future_ex = mysqli_query($cnnEnlace, $get_future);
        $future = mysqli_fetch_array($future_ex);
        include "../include/dbconnclose.php";

        $this->solutions = $future['Solve_Problems'];
        $this->safe = $future['Stay_Safe'];
        $this->living = $future['Alive_Well'];
        $this->work_mgmt = $future['Manage_Work'];
        $this->friends_have = $future['Friends'];
        $this->happy_life = $future['Happy_Life'];
        $this->int_life = $future['Interesting_Life'];
        $this->parents_proud = $future['Proud_Parents'];
        $this->finish_hs = $future['Finish_HS'];
        $this->future_date = $future['Date_Logged'];
        $this->future_program = $future['Program'];

        $get_violence = "SELECT * FROM Participants_Interpersonal_Violence WHERE Participant_ID='$this->participant_id' AND Pre_Post=1
                ORDER BY Date_Logged DESC LIMIT 1";
        //echo $get_violence;
        include "../include/dbconnopen.php";
        $violence_ex = mysqli_query($cnnEnlace, $get_violence);
        $violence = mysqli_fetch_array($violence_ex);
        include "../include/dbconnclose.php";

        $this->coward = $violence['Cowardice'];
        $this->prevent_teasing = $violence['Teasing_Prevention'];
        $this->anger_mgmt = $violence['Anger_Mgmt'];
        $this->self_def = $violence['Self_Defense'];
        $this->coping = $violence['Coping'];
        $this->manage_others = $violence['Handle_Others'];
        $this->negotiation = $violence['Negotiation'];
        $this->parent_dis = $violence['Parent_Disapproval'];
        $this->parent_aff = $violence['Parent_Approval'];
        $this->self_aware = $violence['Self_Awareness'];
        $this->self_care = $violence['Self_Care'];
        $this->violence_date = $violence['Date_Logged'];
        $this->violence_program = $violence['Program'];
    }

    /*
     * Get survey results from post surveys
     */

    public function post_surveys() {
        $get_caring_adults = "SELECT * FROM Participants_Caring_Adults WHERE Participant_ID='$this->participant_id' AND Pre_Post=2
                ORDER BY Date_Logged DESC LIMIT 1";
        //echo $get_caring_adults;
        include "../include/dbconnopen.php";
        $caring_adults = mysqli_query($cnnEnlace, $get_caring_adults);
        $care_adult = mysqli_fetch_array($caring_adults);
        include "../include/dbconnclose.php";

        $this->post_attn = $care_adult['Pay_Attention'];
        $this->post_check = $care_adult['Check_In'];
        $this->post_compliment = $care_adult['Compliment'];
        $this->post_upset = $care_adult['Upset_Discussion'];
        $this->post_crisis = $care_adult['Crisis_Help'];
        $this->post_advice = $care_adult['Personal_Advice'];
        $this->post_familiar = $care_adult['Know_You'];
        $this->post_importance_know = $care_adult['KnowImportance'];
        $this->post_date_caring = $care_adult['Date_Logged'];
        $this->post_program_caring = $care_adult['Program'];

        $get_future = "SELECT * FROM Participants_Future_Expectations WHERE Participant_ID='$this->participant_id' AND Pre_Post=2
                ORDER BY Date_Logged DESC LIMIT 1";
        //echo $get_future;
        include "../include/dbconnopen.php";
        $future_ex = mysqli_query($cnnEnlace, $get_future);
        $future = mysqli_fetch_array($future_ex);
        include "../include/dbconnclose.php";

        $this->post_solutions = $future['Solve_Problems'];
        $this->post_safe = $future['Stay_Safe'];
        $this->post_living = $future['Alive_Well'];
        $this->post_work_mgmt = $future['Manage_Work'];
        $this->post_friends_have = $future['Friends'];
        $this->post_happy_life = $future['Happy_Life'];
        $this->post_int_life = $future['Interesting_Life'];
        $this->post_parents_proud = $future['Proud_Parents'];
        $this->post_finish_hs = $future['Finish_HS'];
        $this->post_future_date = $future['Date_Logged'];
        $this->post_future_program = $future['Program'];

        $get_violence = "SELECT * FROM Participants_Interpersonal_Violence WHERE Participant_ID='$this->participant_id' AND Pre_Post=2
                ORDER BY Date_Logged DESC LIMIT 1";
        //echo $get_violence;
        include "../include/dbconnopen.php";
        $violence_ex = mysqli_query($cnnEnlace, $get_violence);
        $violence = mysqli_fetch_array($violence_ex);
        include "../include/dbconnclose.php";

        $this->post_coward = $violence['Cowardice'];
        $this->post_prevent_teasing = $violence['Teasing_Prevention'];
        $this->post_anger_mgmt = $violence['Anger_Mgmt'];
        $this->post_self_def = $violence['Self_Defense'];
        $this->post_coping = $violence['Coping'];
        $this->post_manage_others = $violence['Handle_Others'];
        $this->post_negotiation = $violence['Negotiation'];
        $this->post_parent_dis = $violence['Parent_Disapproval'];
        $this->post_parent_aff = $violence['Parent_Approval'];
        $this->post_self_aware = $violence['Self_Awareness'];
        $this->post_self_care = $violence['Self_Care'];
        $this->post_violence_date = $violence['Date_Logged'];
        $this->post_violence_program = $violence['Program'];
    }

}

?>