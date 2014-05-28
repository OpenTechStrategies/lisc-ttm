<?php
/* save new or edited assessments. */

//find whether this person already has an assessment
if ($_POST['edited'] != 1) {
    /* so this is a new assessment: */

    /* add each part to its own table.  (we had to change the appearance midway through) */
    if ($_POST['action_2'] == 'caring') {
        $new_survey = "INSERT INTO Participants_Caring_Adults (Participant_ID, Pay_Attention, Check_In,
        Compliment, Upset_Discussion, Crisis_Help, Personal_Advice, Know_You, KnowImportance, Program, Pre_Post) VALUES (
        '" . $_POST['person'] . "',
        '" . $_POST['attn'] . "',
        '" . $_POST['check'] . "',
        '" . $_POST['praise'] . "',
        '" . $_POST['upset'] . "',
        '" . $_POST['crisis'] . "',
        '" . $_POST['advice'] . "',
        '" . $_POST['know'] . "',
        '" . $_POST['important'] . "',
		'" . $_POST['program'] . "',
                    '" . $_POST['pre_post'] . "')";
        //echo $new_survey;
        include "../include/dbconnopen.php";
        mysqli_query($cnnEnlace, $new_survey);
        $caring_id = mysqli_insert_id($cnnEnlace);
        include "../include/dbconnclose.php";
    }
    if ($_POST['action_4'] == 'violence') {
        $add_peers = "INSERT INTO Participants_Interpersonal_Violence (Participant_ID, Cowardice, Teasing_Prevention, Anger_Mgmt,
        Self_Defense, Coping, Handle_Others, Negotiation, Parent_Disapproval, Parent_Approval, Self_Awareness,
        Self_Care, Program, Pre_Post) VALUES (
        '" . $_POST['person'] . "',
        '" . $_POST['fear'] . "',
        '" . $_POST['prevent'] . "',
        '" . $_POST['manage'] . "',
        '" . $_POST['defense'] . "',
        '" . $_POST['coping'] . "',
        '" . $_POST['others'] . "',
        '" . $_POST['negotiation'] . "',
        '" . $_POST['disapproval'] . "',
        '" . $_POST['approval'] . "',
        '" . $_POST['awareness'] . "',
        '" . $_POST['care'] . "',
        '" . $_POST['program'] . "',
                    '" . $_POST['pre_post'] . "')";
        // echo $add_peers;
        include "../include/dbconnopen.php";
        mysqli_query($cnnEnlace, $add_peers);
        $violence_id = mysqli_insert_id($cnnEnlace);
        include "../include/dbconnopen.php";
    }
    if ($_POST['action_3'] == 'future') {
        $add_future = "INSERT INTO Participants_Future_Expectations (Participant_ID, Solve_Problems, Stay_Safe,
        Alive_Well, Manage_Work, Friends, Happy_Life, Interesting_Life, Proud_Parents, Finish_HS, Program, Pre_Post) VALUES (
        '" . $_POST['person'] . "',
        '" . $_POST['solutions'] . "',
        '" . $_POST['safety'] . "',
        '" . $_POST['living'] . "',
        '" . $_POST['manage'] . "',
        '" . $_POST['friends'] . "',
        '" . $_POST['happy'] . "',
        '" . $_POST['interesting'] . "',
        '" . $_POST['parents'] . "',
        '" . $_POST['finish_hs'] . "',
		'" . $_POST['program'] . "',
                    '" . $_POST['pre_post'] . "')";
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
    '" . $_POST['person'] . "',
		'" . $_POST['program'] . "',
    '" . $_POST['home_lang'] . "',
        '" . $_POST['pays_origin'] . "',
'" . $_POST['ethnicity'] . "',
    '" . $_POST['race'] . "',
'" . $_POST['bys_1'] . "',
'" . $_POST['bys_2'] . "',
'" . $_POST['bys_3'] . "',
'" . $_POST['bys_4'] . "',
'" . $_POST['bys_5'] . "',
'" . $_POST['bys_6'] . "',
'" . $_POST['bys_7'] . "',
'" . $_POST['bys_8'] . "',
'" . $_POST['bys_9'] . "',
'" . $_POST['bys_10'] . "',
'" . $_POST['bys_11'] . "',

'" . $_POST['jvq_1'] . "',
'" . $_POST['jvq_2'] . "',
'" . $_POST['jvq_3'] . "',
'" . $_POST['jvq_4'] . "',
'" . $_POST['jvq_5'] . "',
'" . $_POST['jvq_6'] . "',
'" . $_POST['jvq_7'] . "',
'" . $_POST['jvq_8'] . "',
'" . $_POST['jvq_9'] . "',
'" . $_POST['jvq_10'] . "',
'" . $_POST['jvq_11'] . "',
'" . $_POST['jvq_12'] . "', '" . $_POST['base_date'] . "')";

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
            Pre_Post) VALUES ('" . $_POST['person'] . "', '$baseline_id', '$caring_id', '$future_id', '$violence_id', '" . $_POST['pre_post'] . "')";
    //echo $insert_as_assessment;
    include "../include/dbconnopen.php";
    mysqli_query($cnnEnlace, $insert_as_assessment);
    include "../include/dbconnclose.php";
} else {
    //this is an edited assessment
    $save_these = "UPDATE Participants_Baseline_Assessments
                          Participants_Baseline_Assessments SET
Participant_ID='" . $_POST['person'] . "',
    Program='" . $_POST['program'] . "',
    Home_Language='" . $_POST['home_lang'] . "',
        US_Born='" . $_POST['pays_origin'] . "',
    Race='" . $_POST['race'] . "',
    BYS_1='" . $_POST['bys_1'] . "', BYS_2='" . $_POST['bys_2'] . "', BYS_3='" . $_POST['bys_3'] . "',
    BYS_4='" . $_POST['bys_4'] . "', BYS_5='" . $_POST['bys_5'] . "', BYS_6='" . $_POST['bys_6'] . "',
    BYS_7='" . $_POST['bys_7'] . "', BYS_8='" . $_POST['bys_8'] . "', BYS_9='" . $_POST['bys_9'] . "',
    BYS_T='" . $_POST['bys_10'] . "', BYS_E='" . $_POST['bys_11'] . "',
    JVQ_1='" . $_POST['jvq_1'] . "', JVQ_2='" . $_POST['jvq_2'] . "',
    JVQ_3='" . $_POST['jvq_3'] . "', JVQ_4='" . $_POST['jvq_4'] . "',
    JVQ_5='" . $_POST['jvq_5'] . "', JVQ_6='" . $_POST['jvq_6'] . "',
    JVQ_7='" . $_POST['jvq_7'] . "', JVQ_8='" . $_POST['jvq_8'] . "',
    JVQ_9='" . $_POST['jvq_9'] . "', JVQ_T='" . $_POST['jvq_10'] . "',
    JVQ_E='" . $_POST['jvq_11'] . "',
    JVQ_12='" . $_POST['jvq_12'] . "'
            WHERE Baseline_Assessment_Id='" . $_POST['baseline_id'] . "'";
            
//echo $save_these. " <br>";
    $update_adults = "UPDATE Participants_Caring_Adults SET 
        Participant_ID='" . $_POST['person'] . "',
        Pay_Attention='" . $_POST['attn'] . "',
        Check_In= '" . $_POST['check'] . "',
        Compliment='" . $_POST['praise'] . "', 
        Upset_Discussion= '" . $_POST['upset'] . "',
        Crisis_Help='" . $_POST['crisis'] . "',
        Personal_Advice='" . $_POST['advice'] . "',
        Know_You='" . $_POST['know'] . "',
        KnowImportance='" . $_POST['important'] . "',
        Program='" . $_POST['program'] . "',
        Pre_Post='" . $_POST['pre_post'] . "',
        Date_Logged = '" . $_POST['base_date'] . "'
            WHERE Caring_Adults_ID='" . $_POST['caring_id'] . "'";
//echo $update_adults . "<br>";

    $update_violence = "UPDATE Participants_Interpersonal_Violence SET
    Participant_ID='" . $_POST['person'] . "',
    Cowardice='" . $_POST['fear'] . "',
    Teasing_Prevention='" . $_POST['prevent'] . "',
    Anger_Mgmt='" . $_POST['manage'] . "',
        Self_Defense= '" . $_POST['defense'] . "',
        Coping='" . $_POST['coping'] . "',
        Handle_Others='" . $_POST['others'] . "',
        Negotiation='" . $_POST['negotiation'] . "',
        Parent_Disapproval='" . $_POST['disapproval'] . "',
        Parent_Approval='" . $_POST['approval'] . "',
        Self_Awareness='" . $_POST['awareness'] . "',
        Self_Care= '" . $_POST['care'] . "',
        Program='" . $_POST['program'] . "',
        Pre_Post='" . $_POST['pre_post'] . "',
        Date_Logged = '" . $_POST['base_date'] . "'
            WHERE Interpersonal_Violence_ID='" . $_POST['violence_id'] . "'";
//echo $update_violence . "<br>";

    $update_future = "UPDATE Participants_Future_Expectations SET
    Participant_ID= '" . $_POST['person'] . "',
    Solve_Problems= '" . $_POST['solutions'] . "',
    Stay_Safe= '" . $_POST['safety'] . "',
        Alive_Well=  '" . $_POST['living'] . "',
        Manage_Work= '" . $_POST['manage'] . "',
        Friends= '" . $_POST['friends'] . "',
        Happy_Life= '" . $_POST['happy'] . "',
        Interesting_Life= '" . $_POST['interesting'] . "',
        Proud_Parents= '" . $_POST['parents'] . "',
        Finish_HS= '" . $_POST['finish_hs'] . "',
        Program= '" . $_POST['program'] . "',
        Pre_Post='" . $_POST['pre_post'] . "',
        Date_Logged = '" . $_POST['base_date'] . "'
            WHERE Future_Expectations_ID='" . $_POST['future_id'] . "'";
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
