<?php
/* save new or edited assessments. */
/*escape all posted variables:*/
include "../include/dbconnopen.php";
$person_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['person']);
$attn_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['attn']);
$check_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['check']);
$praise_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['praise']);
$upset_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['upset']);
$crisis_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['crisis']);
$advice_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['advice']);
$know_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['know']);
$important_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['important']);
$program_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['program']);
$pre_post_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['pre_post']);

$fear_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['fear']);
$prevent_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['prevent']);
$manage_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['manage']);
$defense_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['defense']);
$coping_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['coping']);
$others_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['others']);
$negotiation_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['negotiation']);
$disapproval_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['disapproval']);
$approval_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['approval']);
$awareness_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['awareness']);
$care_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['care']);

$solutions_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['solutions']);
$safety_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['safety']);
$living_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['living']);
$manage_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['manage']);
$friends_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['friends']);
$happy_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['happy']);
$interesting_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['interesting']);
$parents_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['parents']);
$finish_hs_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['finish_hs']);

$home_lang_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['home_lang']);
$pays_origin_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['pays_origin']);
$ethnicity_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['ethnicity']);
$race_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['race']);
$bys_1_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['bys_1']);
$bys_2_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['bys_2']);
$bys_3_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['bys_3']);
$bys_4_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['bys_4']);
$bys_5_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['bys_5']);
$bys_6_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['bys_6']);
$bys_7_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['bys_7']);
$bys_8_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['bys_8']);
$bys_9_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['bys_9']);
$bys_10_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['bys_10']);
$bys_11_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['bys_11']);

$jvq_1_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['jvq_1']);
$jvq_2_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['jvq_2']);
$jvq_3_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['jvq_3']);
$jvq_4_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['jvq_4']);
$jvq_5_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['jvq_5']);
$jvq_6_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['jvq_6']);
$jvq_7_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['jvq_7']);
$jvq_8_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['jvq_8']);
$jvq_9_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['jvq_9']);
$jvq_10_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['jvq_10']);
$jvq_11_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['jvq_11']);
$jvq_12_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['jvq_12']);
$base_date_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['base_date'] . ' 00:00:00');
$baseline_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['baseline_id']);
$caring_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['caring_id']);
$violence_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['violence_id']);
$future_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['future_id']);

//find whether this person already has an assessment
if ($_POST['edited'] != 1) {
    /* so this is a new assessment: */

    /* add each part to its own table.  (we had to change the appearance midway through) */
    if ($_POST['action_2'] == 'caring') {
        $new_survey = "INSERT INTO Participants_Caring_Adults (Participant_ID, Pay_Attention, Check_In,
        Compliment, Upset_Discussion, Crisis_Help, Personal_Advice, Know_You, KnowImportance, Program, Pre_Post, Date_Logged) VALUES (
        '" . $person_sqlsafe . "',
        '" . $attn_sqlsafe . "',
        '" . $check_sqlsafe . "',
        '" . $praise_sqlsafe . "',
        '" . $upset_sqlsafe . "',
        '" . $crisis_sqlsafe . "',
        '" . $advice_sqlsafe . "',
        '" . $know_sqlsafe . "',
        '" . $important_sqlsafe . "',
		'" . $program_sqlsafe . "',
        '" . $pre_post_sqlsafe . "',
        '" . $base_date_sqlsafe . "')";
        //echo $new_survey;
        mysqli_query($cnnEnlace, $new_survey);
        $caring_id = mysqli_insert_id($cnnEnlace);
        include "../include/dbconnclose.php";
    }
    if ($_POST['action_4'] == 'violence') {
        $add_peers = "INSERT INTO Participants_Interpersonal_Violence (Participant_ID, Cowardice, Teasing_Prevention, Anger_Mgmt,
        Self_Defense, Coping, Handle_Others, Negotiation, Parent_Disapproval, Parent_Approval, Self_Awareness,
        Self_Care, Program, Pre_Post, Date_Logged) VALUES (
        '" . $person_sqlsafe . "',
        '" . $fear_sqlsafe . "',
        '" . $prevent_sqlsafe . "',
        '" . $manage_sqlsafe . "',
        '" . $defense_sqlsafe . "',
        '" . $coping_sqlsafe . "',
        '" . $others_sqlsafe . "',
        '" . $negotiation_sqlsafe . "',
        '" . $disapproval_sqlsafe . "',
        '" . $approval_sqlsafe . "',
        '" . $awareness_sqlsafe . "',
        '" . $care_sqlsafe . "',
        '" . $program_sqlsafe . "',
        '" . $pre_post_sqlsafe . "',
        '" . $base_date_sqlsafe . "')";
        // echo $add_peers;
        include "../include/dbconnopen.php";
        mysqli_query($cnnEnlace, $add_peers);
        $violence_id = mysqli_insert_id($cnnEnlace);
        include "../include/dbconnopen.php";
    }
    if ($_POST['action_3'] == 'future') {
        $add_future = "INSERT INTO Participants_Future_Expectations (Participant_ID, Solve_Problems, Stay_Safe,
        Alive_Well, Manage_Work, Friends, Happy_Life, Interesting_Life, Proud_Parents, Finish_HS, Program, Pre_Post, Date_Logged) VALUES (
        '" . $person_sqlsafe . "',
        '" . $solutions_sqlsafe . "',
        '" . $safety_sqlsafe . "',
        '" . $living_sqlsafe . "',
        '" . $manage_sqlsafe . "',
        '" . $friends_sqlsafe . "',
        '" . $happy_sqlsafe . "',
        '" . $interesting_sqlsafe . "',
        '" . $parents_sqlsafe . "',
        '" . $finish_hs_sqlsafe . "',
		'" . $program_sqlsafe . "',
        '" . $pre_post_sqlsafe . "',
        '" . $base_date_sqlsafe . "')";
        //  echo $add_future;
        include "../include/dbconnopen.php";
        mysqli_query($cnnEnlace, $add_future);
        $future_id = mysqli_insert_id($cnnEnlace);
        include "../include/dbconnopen.php";
        ?>
        <!--<span style="font-weight:bold;color:#990000;">Thank you for adding this assessment!</span>-->
        <?php
    }
    if ($_POST['action'] == 'baseline') {
        $save_these = "INSERT INTO Participants_Baseline_Assessments (Participant_ID, Program, Home_Language, US_Born,
    Ethnicity, Race, BYS_1, BYS_2, BYS_3, BYS_4, BYS_5, BYS_6, BYS_7, BYS_8, BYS_9, BYS_T, BYS_E,
    JVQ_1, JVQ_2, JVQ_3, JVQ_4, JVQ_5, JVQ_6, JVQ_7, JVQ_8, JVQ_9, JVQ_T, JVQ_E, JVQ_12, Date_Logged) VALUES (
    '" . $person_sqlsafe . "',
    '" . $program_sqlsafe . "',
    '" . $home_lang_sqlsafe . "',
    '" . $pays_origin_sqlsafe . "',
    '" . $ethnicity_sqlsafe . "',
    '" . $race_sqlsafe . "',
    '" . $bys_1_sqlsafe . "',
    '" . $bys_2_sqlsafe . "',
    '" . $bys_3_sqlsafe . "',
    '" . $bys_4_sqlsafe . "',
    '" . $bys_5_sqlsafe . "',
    '" . $bys_6_sqlsafe . "',
    '" . $bys_7_sqlsafe . "',
    '" . $bys_8_sqlsafe . "',
    '" . $bys_9_sqlsafe . "',
    '" . $bys_10_sqlsafe . "',
    '" . $bys_11_sqlsafe . "',
    '" . $jvq_1_sqlsafe . "',
    '" . $jvq_2_sqlsafe . "',
    '" . $jvq_3_sqlsafe . "',
    '" . $jvq_4_sqlsafe . "',
    '" . $jvq_5_sqlsafe . "',
    '" . $jvq_6_sqlsafe . "',
    '" . $jvq_7_sqlsafe . "',
    '" . $jvq_8_sqlsafe . "',
    '" . $jvq_9_sqlsafe . "',
    '" . $jvq_10_sqlsafe . "',
    '" . $jvq_11_sqlsafe . "',
    '" . $jvq_12_sqlsafe . "',
    '" . $base_date_sqlsafe . "')";

//echo $save_these;
        include "../include/dbconnopen.php";
        mysqli_query($cnnEnlace, $save_these);
        $baseline_id = mysqli_insert_id($cnnEnlace);
        include "../include/dbconnclose.php";
        ?>
        <span style="font-weight:bold;color:#990000;">Thank you for adding this assessment!</span>
        <?php
    }

    $insert_as_assessment = "INSERT INTO Assessments (Participant_ID, Baseline_ID, Caring_ID, Future_ID, Violence_ID, 
            Pre_Post) VALUES ('" . $person_sqlsafe . "', '$baseline_id', '$caring_id', '$future_id', '$violence_id', '" . $pre_post_sqlsafe . "')";
    //echo $insert_as_assessment;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $insert_as_assessment);
    include "../include/dbconnclose.php";
} else {
    //this is an edited assessment
    $save_these = "UPDATE Participants_Baseline_Assessments
                          Participants_Baseline_Assessments SET
Participant_ID='" . $person_sqlsafe . "',
    Program='" . $program_sqlsafe . "',
    Home_Language='" . $home_lang_sqlsafe . "',
        US_Born='" . $pays_origin_sqlsafe . "',
    Race='" . $race_sqlsafe . "',
    BYS_1='" . $bys_1_sqlsafe . "', BYS_2='" . $bys_2_sqlsafe . "', BYS_3='" . $bys_3_sqlsafe . "',
    BYS_4='" . $bys_4_sqlsafe . "', BYS_5='" . $bys_5_sqlsafe . "', BYS_6='" . $bys_6_sqlsafe . "',
    BYS_7='" . $bys_7_sqlsafe . "', BYS_8='" . $bys_8_sqlsafe . "', BYS_9='" . $bys_9_sqlsafe . "',
    BYS_T='" . $bys_10_sqlsafe . "', BYS_E='" . $bys_11_sqlsafe . "',
    JVQ_1='" . $jvq_1_sqlsafe . "', JVQ_2='" . $jvq_2_sqlsafe . "',
    JVQ_3='" . $jvq_3_sqlsafe . "', JVQ_4='" . $jvq_4_sqlsafe . "',
    JVQ_5='" . $jvq_5_sqlsafe . "', JVQ_6='" . $jvq_6_sqlsafe . "',
    JVQ_7='" . $jvq_7_sqlsafe . "', JVQ_8='" . $jvq_8_sqlsafe . "',
    JVQ_9='" . $jvq_9_sqlsafe . "', JVQ_T='" . $jvq_10_sqlsafe . "',
    JVQ_E='" . $jvq_11_sqlsafe . "',
    JVQ_12='" . $jvq_12_sqlsafe . "'
            WHERE Baseline_Assessment_Id='" . $baseline_id_sqlsafe . "'";
            
//echo $save_these. " <br>";
    $update_adults = "UPDATE Participants_Caring_Adults SET 
        Participant_ID='" . $person_sqlsafe . "',
        Pay_Attention='" . $attn_sqlsafe . "',
        Check_In= '" . $check_sqlsafe . "',
        Compliment='" . $praise_sqlsafe . "', 
        Upset_Discussion= '" . $upset_sqlsafe . "',
        Crisis_Help='" . $crisis_sqlsafe . "',
        Personal_Advice='" . $advice_sqlsafe . "',
        Know_You='" . $know_sqlsafe . "',
        KnowImportance='" . $important_sqlsafe . "',
        Program='" . $program_sqlsafe . "',
        Pre_Post='" . $pre_post_sqlsafe . "',
        Date_Logged = '" . $base_date_sqlsafe . "'
            WHERE Caring_Adults_ID='" . $caring_id_sqlsafe . "'";
//echo $update_adults . "<br>";

    $update_violence = "UPDATE Participants_Interpersonal_Violence SET
    Participant_ID='" . $person_sqlsafe . "',
    Cowardice='" . $fear_sqlsafe . "',
    Teasing_Prevention='" . $prevent_sqlsafe . "',
    Anger_Mgmt='" . $manage_sqlsafe . "',
        Self_Defense= '" . $defense_sqlsafe . "',
        Coping='" . $coping_sqlsafe . "',
        Handle_Others='" . $others_sqlsafe . "',
        Negotiation='" . $negotiation_sqlsafe . "',
        Parent_Disapproval='" . $disapproval_sqlsafe . "',
        Parent_Approval='" . $approval_sqlsafe . "',
        Self_Awareness='" . $awareness_sqlsafe . "',
        Self_Care= '" . $care_sqlsafe . "',
        Program='" . $program_sqlsafe . "',
        Pre_Post='" . $pre_post_sqlsafe . "',
        Date_Logged = '" . $base_date_sqlsafe . "'
            WHERE Interpersonal_Violence_ID='" . $violence_id_sqlsafe . "'";
//echo $update_violence . "<br>";

    $update_future = "UPDATE Participants_Future_Expectations SET
    Participant_ID= '" . $person_sqlsafe . "',
    Solve_Problems= '" . $solutions_sqlsafe . "',
    Stay_Safe= '" . $safety_sqlsafe . "',
        Alive_Well=  '" . $living_sqlsafe . "',
        Manage_Work= '" . $manage_sqlsafe . "',
        Friends= '" . $friends_sqlsafe . "',
        Happy_Life= '" . $happy_sqlsafe . "',
        Interesting_Life= '" . $interesting_sqlsafe . "',
        Proud_Parents= '" . $parents_sqlsafe . "',
        Finish_HS= '" . $finish_hs_sqlsafe . "',
        Program= '" . $program_sqlsafe . "',
        Pre_Post='" . $pre_post_sqlsafe . "',
        Date_Logged = '" . $base_date_sqlsafe . "'
            WHERE Future_Expectations_ID='" . $future_id_sqlsafe . "'";
//echo $update_future . "<br>";
//EDITED QUERIES
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $save_these);
    mysqli_query($cnnEnlace, $update_adults);
    mysqli_query($cnnEnlace, $update_violence);
    mysqli_query($cnnEnlace, $update_future);
    include "../include/dbconnclose.php";
    ?>
    <span style="font-weight:bold;color:#990000;">Thank you for editing this assessment!</span>
    <?php
}
?>
