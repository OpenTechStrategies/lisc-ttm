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

include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
include "../include/survey_entry_point.php";

$anonymous_entry = false;
include "../include/dbconnopen.php";
$person_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_GET['person']);
include "../include/dbconnclose.php";

if (isset($_GET['code'])) {
    include "../include/dbconnopen.php";
    $code_sqlsafe = mysqli_real_escape_string($cnnEnlace, $_GET['code']);
    include "../include/dbconnclose.php";
    $lookup_result = lookup_and_validate_survey_entry_code($code_sqlsafe, 1);

    $session_id_safe = $lookup_result['Session_ID'];
    $person_sqlsafe = $lookup_result['Participant_ID'];
    $anonymous_entry = true;
}


include "../../header.php";
if (!$anonymous_entry) {
    include "../header.php";
    user_enforce_has_access($Enlace_id);
}
?>

<div style="display:none;"><?php include "../include/datepicker_wtw.php"; ?></div>
<?php
$editable = true;
if(!$anonymous_entry) {

    /* so allow them in if it's a new survey OR if they have access to all
     * programs ('a') or if they have access to a program that is linked
     * to this...person? or this survey?: */

    $access_array = $USER->program_access($Enlace_id);

    include "../include/dbconnopen.php";
    $get_program_list = "SELECT Session_Names.Program_ID FROM Participants_Programs INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_ID WHERE Participant_ID = '" . $person_sqlsafe . "'";
    $program_connected = mysqli_query($cnnEnlace, $get_program_list);
    $program_array = array();
    while ($program_id = mysqli_fetch_row($program_connected)){
        $program_array[] = $program_id[0];
    }

    $USER->enforce_access_program_array($Enlace_id, $program_array);


    /*
     * This file is either a new intake survey, an editable intake survey, or a view for the intake survey.
     * The responses to questions are shown if they have been answered, and are always editable.
     */

    //get participant info
    include_once "../classes/participant.php";

    include "../include/dbconnopen.php";
    $id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_GET['assessment']);
    /* if the assessment is not new, then Get['assessment'] exists, and this query returns the entered responses. */
    $get_assessment_info = "SELECT * FROM Assessments 
                LEFT JOIN Participants_Caring_Adults ON Caring_Id=Caring_Adults_ID
                LEFT JOIN Participants_Future_Expectations ON Future_Id=Future_Expectations_ID
                LEFT JOIN Participants_Interpersonal_Violence ON Violence_Id=Interpersonal_Violence_ID
                LEFT JOIN Participants_Baseline_Assessments ON Baseline_Id=Baseline_Assessment_ID
                LEFT JOIN Session_Names ON Assessments.Session_ID = Session_Names.Session_ID
                LEFT JOIN Programs ON Session_Names.Program_ID=Programs.Program_ID
                WHERE Assessment_ID = '" . $id_sqlsafe . "'";
    $get_assessment = mysqli_query($cnnEnlace, $get_assessment_info);
    $assessment_info = mysqli_fetch_array($get_assessment);
    $caring_id = $assessment_info['Caring_ID'];
    $baseline_id = $assessment_info['Baseline_ID'];
    $future_id = $assessment_info['Future_ID'];
    $violence_id = $assessment_info['Violence_ID'];
    $person = new Participant();
    $person->load_with_participant_id($assessment_info[1]);

    $editable = $USER->has_site_access($Enlace_id, $AdminAccess) || $assessment_info['Draft'] != '0';

}
/* if it IS a new assessment, then we get the person from the get[person]: */
if (!isset($_GET['assessment'])) {
    $person = new Participant();
    $person->load_with_participant_id($person_sqlsafe);
    $edit = 0;
} else {
    $edit = 1;
}

if (!$anonymous_entry) {
    /* create a dropdown of the programs/sessions that the person is involved in. */
    $get_programs = "SELECT * FROM Participants_Programs" .
                " INNER JOIN Session_Names ON Participants_Programs.Program_ID = Session_Names.Session_ID " .
                " INNER JOIN Programs ON Session_Names.Program_ID = Programs.Program_ID" .
                " WHERE Participants_Programs.Participant_ID = '" . $person->participant_id . "'";
    include "../include/dbconnopen.php";
    $programs = mysqli_query($cnnEnlace, $get_programs);
}
?>

<h4>Baseline Assessment -
    <?php
        if($anonymous_entry) {
            echo "Participant #$person_sqlsafe";
        } else {
            echo $person->first_name . " " . $person->last_name;
        }
   ?>
</h4>
<?php $person->pre_surveys(); ?>
<div style="text-align:center;"><span class="helptext">Program: </span>
    <?php
        if ($anonymous_entry) {
            $get_program = "SELECT Name, Session_Name FROM Session_Names " .
                "LEFT JOIN Programs ON Programs.Program_ID = Session_Names.Program_ID " .
                "WHERE Session_ID = '$session_id_safe'";
            include "../include/dbconnopen.php";
            $program_info = mysqli_fetch_array(mysqli_query($cnnEnlace, $get_program));

            echo $program_info["Name"] . " -- " . $program_info["Session_Name"];
        } else if (isset($_GET['assessment'])) {
            $session_id_safe = $assessment_info["Session_ID"];
            echo $assessment_info["Name"] . " -- " . $assessment_info["Session_Name"];
        } else {
    ?>
        <select id="program">
            <option value="">-------</option>
            <?php
            while ($program = mysqli_fetch_array($programs)) {
                ?>
                <option value="<?php echo $program['Session_ID']; ?>" <?php echo($person->program_caring == $program['Session_ID'] ? 'selected="selected"' : null); ?>><?php echo $program['Name'] . " -- " . $program['Session_Name']; ?></option>
                <?php
            }
            include "../include/dbconnclose.php";
            ?>
        </select>
    <?php } ?>
    <br/><br/>
</div>

<!--
Show tables of survey questions and response options.  The chosen response is selected if one is saved.
-->

<table class="inner_table" style="border: 2px solid #696969;font-size:.85em;" id="baseline_table">
    <?php $person->baseline(); ?>                        
    <caption>Date completed:
        <?php
            if($anonymous_entry) {
                date_default_timezone_set('America/Chicago');
                $date = date("Y-m-d");
            ?>
                <input type="hidden" id="admin_date" value="<?php echo $date; ?>" <?php if(!$editable) {?> disabled='disabled'<?php } ?>>
            <?php
                echo $date;
            } else {
            ?>
                <input type="text" id="admin_date" class="addDP" value="<?php $print_date = explode(" ", $assessment_info[20]); echo $print_date[0]; ?>">
            <?php
            }
        ?>
    </caption>
    <tr style="background-color:#F2F2F2;"><td colspan="2"><strong style="font-size:1em;">From the 2008 Boston Youth Survey:</strong></td>
        <td colspan="2"><strong style="font-size:1em;">JVQ-R2, Reduced Item Version, Youth Lifetime Form</strong></td>
    </tr>
    <tr><td>I live in a neighborhood where people know and like each other.</td><td><select id="BYS_1"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0"  <?php echo($assessment_info['BYS_1'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['BYS_1'] == 1 ? 'selected=="selected"' : null); ?>>Strongly disagree</option>
                <option value="2" <?php echo($assessment_info['BYS_1'] == 2 ? 'selected=="selected"' : null); ?>>Disagree</option>
                <option value="3" <?php echo($assessment_info['BYS_1'] == 3 ? 'selected=="selected"' : null); ?>>Agree</option>
                <option value="4" <?php echo($assessment_info['BYS_1'] == 4 ? 'selected=="selected"' : null); ?>>Strongly agree</option>
            </select></td>
        <td>At any time in your life, did anyone steal something from you and 
            never give it back?  Things like a backpack, money, watch, clothing, bike, stereo, or anything else?
        </td>
        <td><input type="radio" value="1" name="JVQ_1"  <?php echo($assessment_info['JVQ_1'] == 1 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>Yes<br>
            <input type="radio" value="2" name="JVQ_1" <?php echo($assessment_info['JVQ_1'] == 2 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>No
        </td>
    </tr>
    <tr><td>People in my neighborhood are willing to help their neighbors</td><td><select id="BYS_2"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['BYS_2'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['BYS_2'] == 1 ? 'selected=="selected"' : null); ?>>Strongly disagree</option>
                <option value="2" <?php echo($assessment_info['BYS_2'] == 2 ? 'selected=="selected"' : null); ?>>Disagree</option>
                <option value="3" <?php echo($assessment_info['BYS_2'] == 3 ? 'selected=="selected"' : null); ?>>Agree</option>
                <option value="4" <?php echo($assessment_info['BYS_2'] == 4 ? 'selected=="selected"' : null); ?>>Strongly agree</option>
            </select></td>
        <td>Sometimes people are attacked <em>with</em> sticks, rocks, guns, knives, or other things that would
            hurt.  At any time in your life, did anyone hit or attack you on purpose <em>with</em> an object
            or weapon?  Somewhere like: at home, at school, at at a store, in a car, on the street, or anywhere else?</td>
        <td><input type="radio" value="1" name="JVQ_2" <?php echo($assessment_info['JVQ_2'] == 1 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>Yes<br>
            <input type="radio" value="2" name="JVQ_2" <?php echo($assessment_info['JVQ_2'] == 2 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>No
        </td>
    </tr>
    <tr><td>People in my neighborhood generally get along with each other</td><td><select id="BYS_3"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0"  <?php echo($assessment_info['BYS_3'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1"  <?php echo($assessment_info['BYS_3'] == 1 ? 'selected=="selected"' : null); ?>>Strongly disagree</option>
                <option value="2" <?php echo($assessment_info['BYS_3'] == 2 ? 'selected=="selected"' : null); ?>>Disagree</option>
                <option value="3" <?php echo($assessment_info['BYS_3'] == 3 ? 'selected=="selected"' : null); ?>>Agree</option>
                <option value="4" <?php echo($assessment_info['BYS_3'] == 4 ? 'selected=="selected"' : null); ?>>Strongly agree</option>
            </select></td>
        <td>At any time in your life, did anyone hit or attack you <em>without</em> using an object or weapon?</td>
        <td><input type="radio" value="1" name="JVQ_3" <?php echo($assessment_info['JVQ_3'] == 1 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>Yes<br>
            <input type="radio" value="2" name="JVQ_3" <?php echo($assessment_info['JVQ_3'] == 2 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>No
        </td>
    </tr>
    <tr><td>People in my neighborhood generally share the same beliefs about what is right and wrong.</td><td><select id="BYS_4"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['BYS_4'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['BYS_4'] == 1 ? 'selected=="selected"' : null); ?>>Strongly disagree</option>
                <option value="2" <?php echo($assessment_info['BYS_4'] == 2 ? 'selected=="selected"' : null); ?>>Disagree</option>
                <option value="3" <?php echo($assessment_info['BYS_4'] == 3 ? 'selected=="selected"' : null); ?>>Agree</option>
                <option value="4" <?php echo($assessment_info['BYS_4'] == 4 ? 'selected=="selected"' : null); ?>>Strongly agree</option>
            </select></td>
        <td>At any time in your life, did you get scared or feel really bad because grown-ups in  your life called
            you names, said mean things to you, or said they didn't want you?</td>
        <td><input type="radio" value="1" name="JVQ_4" <?php echo($assessment_info['JVQ_4'] == 1 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>Yes<br>
            <input type="radio" value="2" name="JVQ_4" <?php echo($assessment_info['JVQ_4'] == 2 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>No
        </td>
    </tr>
    <tr><td>People in my neighborhood can be trusted.</td><td><select id="BYS_5"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['BYS_5'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['BYS_5'] == 1 ? 'selected=="selected"' : null); ?>>Strongly disagree</option>
                <option value="2" <?php echo($assessment_info['BYS_5'] == 2 ? 'selected=="selected"' : null); ?>>Disagree</option>
                <option value="3" <?php echo($assessment_info['BYS_5'] == 3 ? 'selected=="selected"' : null); ?>>Agree</option>
                <option value="4" <?php echo($assessment_info['BYS_5'] == 4 ? 'selected=="selected"' : null); ?>>Strongly agree</option>
            </select></td>
        <td>Sometimes group of kids or gangs attack people.  At any time in your life, did a group of kids or a 
            gang hit, jump, or attack you?</td>
        <td><input type="radio" value="1" name="JVQ_5" <?php echo($assessment_info['JVQ_5'] == 1 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>Yes<br>
            <input type="radio" value="2" name="JVQ_5" <?php echo($assessment_info['JVQ_5'] == 2 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>No
        </td>
    </tr>
    <tr><td>In the past 12 months, how would you describe your grades in school?</td>
        <td><select id="BYS_6"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['BYS_6'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['BYS_6'] == 1 ? 'selected=="selected"' : null); ?>>Mostly A's</option>
                <option value="2" <?php echo($assessment_info['BYS_6'] == 2 ? 'selected=="selected"' : null); ?>>Mostly B's</option>
                <option value="3" <?php echo($assessment_info['BYS_6'] == 3 ? 'selected=="selected"' : null); ?>>Mostly C's</option>
                <option value="4" <?php echo($assessment_info['BYS_6'] == 4 ? 'selected=="selected"' : null); ?>>Mostly D's</option>
                <option value="5" <?php echo($assessment_info['BYS_6'] == 5 ? 'selected=="selected"' : null); ?>>Mostly F's</option>
            </select></td>
        <td>At any time in your life, did any kid, even a brother or sister, hit you? Somewhere like: at home, at school, 
            out playing, in a store, or anywhere else?</td><td>
            <input type="radio" value="1" name="JVQ_6" <?php echo($assessment_info['JVQ_6'] == 1 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>Yes<br>
            <input type="radio" value="2" name="JVQ_6" <?php echo($assessment_info['JVQ_6'] == 2 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>No
        </td>
    </tr>
    <tr><td>Are you receiving special education services (IEP)?</td><td>
            <select id="BYS_7"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['BYS_7'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['BYS_7'] == 1 ? 'selected=="selected"' : null); ?>>Yes</option>
                <option value="2" <?php echo($assessment_info['BYS_7'] == 2 ? 'selected=="selected"' : null); ?>>No</option>
                <option value="3" <?php echo($assessment_info['BYS_7'] == 3 ? 'selected=="selected"' : null); ?>>Not Sure</option>
            </select>
        </td>
        <td>At any time in your life, did you get scared or feel really bad because kids were calling you names, saying
            mean things to you, or saying they didn't want you around?</td><td>
            <input type="radio" value="1" name="JVQ_7" <?php echo($assessment_info['JVQ_7'] == 1 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>Yes<br>
            <input type="radio" value="2" name="JVQ_7" <?php echo($assessment_info['JVQ_7'] == 2 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>No
        </td>
    </tr>
    <tr><td>About how much time do you spend working on homework on an average shool day?</td>
        <td>
            <select id="BYS_8"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['BYS_8'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['BYS_8'] == 1 ? 'selected=="selected"' : null); ?>>More than 3 hours</option>
                <option value="2" <?php echo($assessment_info['BYS_8'] == 2 ? 'selected=="selected"' : null); ?>>Between 1-3 hours</option>
                <option value="3" <?php echo($assessment_info['BYS_8'] == 3 ? 'selected=="selected"' : null); ?>>An hour or less</option>
            </select>
        </td>
        <td>At any time in your life, did a <em>grown-up you  know</em> touch your private parts when they shouldn't
            have or makr you touch their private parts?  Or did a <em>grown-up you know</em> force you to have sex?</td>
        <td><input type="radio" value="1" name="JVQ_8" <?php echo($assessment_info['JVQ_8'] == 1 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>Yes<br>
            <input type="radio" value="2" name="JVQ_8" <?php echo($assessment_info['JVQ_8'] == 2 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>No
        </td>
    </tr>

    <tr><td></td>
        <td>

        </td>
        <td>At any time in your life, did a <em>grown-up you did not know</em> touch your private parts when they shouldn't
            have, make you touch their private parts or force you to have sex?</td>
        <td><input type="radio" value="1" name="JVQ_12" <?php echo($assessment_info['JVQ_12'] == 1 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>Yes<br>
            <input type="radio" value="2" name="JVQ_12" <?php echo($assessment_info['JVQ_12'] == 2 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>No
        </td>
    </tr>

    <tr><td>In the past 30 days, how many times did you skip school when you were not sick?</td><td>
            <select id="BYS_9"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['BYS_9'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['BYS_9'] == 1 ? 'selected=="selected"' : null); ?>>Never</option>
                <option value="2" <?php echo($assessment_info['BYS_9'] == 2 ? 'selected=="selected"' : null); ?>>Once or twice</option>
                <option value="3" <?php echo($assessment_info['BYS_9'] == 3 ? 'selected=="selected"' : null); ?>>3 or more days</option>
            </select>
        </td>
        <td>At any time in your life, did you <em>see</em> a parent get pushed, slapped, hit, punched, or beat up
            by another parent, or their boyfriend or girlfriend?</td>
        <td><input type="radio" value="1" name="JVQ_9" <?php echo($assessment_info['JVQ_9'] == 1 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>Yes<br>
            <input type="radio" value="2" name="JVQ_9" <?php echo($assessment_info['JVQ_9'] == 2 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>No
        </td>
    </tr>
    <tr><td>How important is getting good grades to you?</td><td><select id="BYS_10"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['BYS_T'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['BYS_T'] == 1 ? 'selected=="selected"' : null); ?>>Very important</option>
                <option value="2" <?php echo($assessment_info['BYS_T'] == 2 ? 'selected=="selected"' : null); ?>>Somewhat important</option>
                <option value="3" <?php echo($assessment_info['BYS_T'] == 3 ? 'selected=="selected"' : null); ?>>Not at all important</option>
            </select></td>
        <td>At any time in your life, in real life, did you <em>see</em> anyone get attacked on purpose 
            <em>with</em> a stick, rock, gun, knife, or other thing that would hurt?  Somewhere like: at home,
            at school, at a store, in a car, on the street, or anywhere else?</td>
        <td><input type="radio" value="1" name="JVQ_10" <?php echo($assessment_info['JVQ_T'] == 1 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>Yes<br>
            <input type="radio" value="2" name="JVQ_10" <?php echo($assessment_info['JVQ_T'] == 2 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>No
        </td>
    </tr>
    <tr><td>How important is it to your family that you continue your education after high school?</td><td>
            <select id="BYS_11"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['BYS_E'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['BYS_E'] == 1 ? 'selected=="selected"' : null); ?>>Very important</option>
                <option value="2" <?php echo($assessment_info['BYS_E'] == 2 ? 'selected=="selected"' : null); ?>>Somewhat important</option>
                <option value="3" <?php echo($assessment_info['BYS_E'] == 3 ? 'selected=="selected"' : null); ?>>Not at all important</option>
            </select>
        </td>
        <td>At any time in your life, were in you in any place in real life where you could see or hear people being shot,
            bombs going off, or street riots?</td>
        <td><input type="radio" value="1" name="JVQ_11" <?php echo($assessment_info['JVQ_E'] == 1 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>Yes<br>
            <input type="radio" value="2" name="JVQ_11" <?php echo($assessment_info['JVQ_E'] == 2 ? 'checked=true' : null); ?><?php if(!$editable) {?> disabled='disabled'<?php } ?>>No
        </td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td><b>Total JVQ score:</b></td><td><?php echo $person->jvqscore; ?></td></tr>
    <tr><td colspan="2"></td>
        <td colspan="2"></td></tr>
</table>

<h4>Caring Adults Survey</h4><hr/><br/>

<table class="inner_table" style="border: 2px solid #696969;font-size:.9em;width:70%;margin-left:auto;margin-right:auto;" id="caring_adults_table">
    <tr><td><strong>How many adults in your life:</strong></td><td></td></tr>
    <tr><td>Pay attention to what's going on in your life?</td><td><select id="pay_attention"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Pay_Attention'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['Pay_Attention'] == 1 ? 'selected=="selected"' : null); ?>>None</option>
                <option value="2" <?php echo($assessment_info['Pay_Attention'] == 2 ? 'selected=="selected"' : null); ?>>One</option>
                <option value="3" <?php echo($assessment_info['Pay_Attention'] == 3 ? 'selected=="selected"' : null); ?>>2-3</option>
                <option value="4" <?php echo($assessment_info['Pay_Attention'] == 4 ? 'selected=="selected"' : null); ?>>More than 3</option>
            </select></td></tr>
    <tr><td>Would say something to you if something in your life wasn't going right?</td>
        <td><select id="check_in"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Check_In'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['Check_In'] == 1 ? 'selected=="selected"' : null); ?>>None</option>
                <option value="2" <?php echo($assessment_info['Check_In'] == 2 ? 'selected=="selected"' : null); ?>>One</option>
                <option value="3" <?php echo($assessment_info['Check_In'] == 3 ? 'selected=="selected"' : null); ?>>2-3</option>
                <option value="4" <?php echo($assessment_info['Check_In'] == 4 ? 'selected=="selected"' : null); ?>>More than 3</option>
            </select></td></tr>
    <tr><td>Say something nice to you when you do something good?</td><td><select id="praise"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Compliment'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['Compliment'] == 1 ? 'selected=="selected"' : null); ?>>None</option>
                <option value="2" <?php echo($assessment_info['Compliment'] == 2 ? 'selected=="selected"' : null); ?>>One</option>
                <option value="3" <?php echo($assessment_info['Compliment'] == 3 ? 'selected=="selected"' : null); ?>>2-3</option>
                <option value="4" <?php echo($assessment_info['Compliment'] == 4 ? 'selected=="selected"' : null); ?>>More than 3</option>
            </select></td></tr>
    <tr><td>Could you talk to if you are upset or mad about something?</td><td><select id="upset"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Upset_Discussion'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['Upset_Discussion'] == 1 ? 'selected=="selected"' : null); ?>>None</option>
                <option value="2" <?php echo($assessment_info['Upset_Discussion'] == 2 ? 'selected=="selected"' : null); ?>>One</option>
                <option value="3" <?php echo($assessment_info['Upset_Discussion'] == 3 ? 'selected=="selected"' : null); ?>>2-3</option>
                <option value="4" <?php echo($assessment_info['Upset_Discussion'] == 4 ? 'selected=="selected"' : null); ?>>More than 3</option>
            </select></td></tr>
    <tr><td>Could you go to for help in a crisis?</td><td><select id="crisis"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Crisis_Help'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['Crisis_Help'] == 1 ? 'selected=="selected"' : null); ?>>None</option>
                <option value="2" <?php echo($assessment_info['Crisis_Help'] == 2 ? 'selected=="selected"' : null); ?>>One</option>
                <option value="3" <?php echo($assessment_info['Crisis_Help'] == 3 ? 'selected=="selected"' : null); ?>>2-3</option>
                <option value="4" <?php echo($assessment_info['Crisis_Help'] == 4 ? 'selected=="selected"' : null); ?>>More than 3</option>
            </select></td></tr>
    <tr><td>Could you go to if you need advice about personal problems?</td><td><select id="advice"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Personal_Advice'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['Personal_Advice'] == 1 ? 'selected=="selected"' : null); ?>>None</option>
                <option value="2" <?php echo($assessment_info['Personal_Advice'] == 2 ? 'selected=="selected"' : null); ?>>One</option>
                <option value="3" <?php echo($assessment_info['Personal_Advice'] == 3 ? 'selected=="selected"' : null); ?>>2-3</option>
                <option value="4" <?php echo($assessment_info['Personal_Advice'] == 4 ? 'selected=="selected"' : null); ?>>More than 3</option>
            </select></td></tr>
    <tr><Td>Know a lot about you?</td><td><select id="know_you"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Know_You'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['Know_You'] == 1 ? 'selected=="selected"' : null); ?>>None</option>
                <option value="2" <?php echo($assessment_info['Know_You'] == 2 ? 'selected=="selected"' : null); ?>>One</option>
                <option value="3" <?php echo($assessment_info['Know_You'] == 3 ? 'selected=="selected"' : null); ?>>2-3</option>
                <option value="4" <?php echo($assessment_info['Know_You'] == 4 ? 'selected=="selected"' : null); ?>>More than 3</option>
            </select></td></tr>
    <tr><td>Know what is important to you?</td><td><select id="important"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['KnowImportance'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['KnowImportance'] == 1 ? 'selected=="selected"' : null); ?>>None</option>
                <option value="2" <?php echo($assessment_info['KnowImportance'] == 2 ? 'selected=="selected"' : null); ?>>One</option>
                <option value="3" <?php echo($assessment_info['KnowImportance'] == 3 ? 'selected=="selected"' : null); ?>>2-3</option>
                <option value="4" <?php echo($assessment_info['KnowImportance'] == 4 ? 'selected=="selected"' : null); ?>>More than 3</option>
            </select></td></tr>
    <tr><td colspan="2"></td></tr>
</table>
<br/><br/>
<hr /><hr />

<h4>Future Expectations Questionnaire </h4><hr/><br/>


<table class="inner_table" style="border: 2px solid #696969;font-size:.9em;width:70%;margin-left:auto;margin-right:auto;" id="future_table">
    <tr><td><b>When I think about the future...</b></td><td></td></tr>
    <tr><td>I am sure I can handle the problems that might come up.</td><td><select id="solve_probs"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Solve_Problems'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>\
                <option value="1" <?php echo($assessment_info['Solve_Problems'] == 1 ? 'selected=="selected"' : null); ?>>Not likely at all</option>
                <option value="2" <?php echo($assessment_info['Solve_Problems'] == 2 ? 'selected=="selected"' : null); ?>>May be likely but probably not</option>
                <option value="3" <?php echo($assessment_info['Solve_Problems'] == 3 ? 'selected=="selected"' : null); ?>>Could go either way</option>
                <option value="4" <?php echo($assessment_info['Solve_Problems'] == 4 ? 'selected=="selected"' : null); ?>>Very likely, not absolute</option>
                <option value="5" <?php echo($assessment_info['Solve_Problems'] == 5 ? 'selected=="selected"' : null); ?>>Definitely will</option>
            </select></td></tr>
    <tr><td>I will be able to stay safe and out of danger.</td><td><select id="stay_safe"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Stay_Safe'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>\
                <option value="1" <?php echo($assessment_info['Stay_Safe'] == 1 ? 'selected=="selected"' : null); ?>>Not likely at all</option>
                <option value="2" <?php echo($assessment_info['Stay_Safe'] == 2 ? 'selected=="selected"' : null); ?>>May be likely but probably not</option>
                <option value="3" <?php echo($assessment_info['Stay_Safe'] == 3 ? 'selected=="selected"' : null); ?>>Could go either way</option>
                <option value="4" <?php echo($assessment_info['Stay_Safe'] == 4 ? 'selected=="selected"' : null); ?>>Very likely, not absolute</option>
                <option value="5" <?php echo($assessment_info['Stay_Safe'] == 5 ? 'selected=="selected"' : null); ?>>Definitely will</option>
            </select></td></tr>
    <tr><td>I will be alive and well.</td><td><select id="alive_well"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Alive_Well'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>\
                <option value="1" <?php echo($assessment_info['Alive_Well'] == 1 ? 'selected=="selected"' : null); ?>>Not likely at all</option>
                <option value="2" <?php echo($assessment_info['Alive_Well'] == 2 ? 'selected=="selected"' : null); ?>>May be likely but probably not</option>
                <option value="3" <?php echo($assessment_info['Alive_Well'] == 3 ? 'selected=="selected"' : null); ?>>Could go either way</option>
                <option value="4" <?php echo($assessment_info['Alive_Well'] == 4 ? 'selected=="selected"' : null); ?>>Very likely, not absolute</option>
                <option value="5" <?php echo($assessment_info['Alive_Well'] == 5 ? 'selected=="selected"' : null); ?>>Definitely will</option>
            </select></td></tr>
    <tr><td>I am sure that I can handle work or school.</td><td><select id="manage_work"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Manage_Work'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>\
                <option value="1" <?php echo($assessment_info['Manage_Work'] == 1 ? 'selected=="selected"' : null); ?>>Not likely at all</option>
                <option value="2" <?php echo($assessment_info['Manage_Work'] == 2 ? 'selected=="selected"' : null); ?>>May be likely but probably not</option>
                <option value="3" <?php echo($assessment_info['Manage_Work'] == 3 ? 'selected=="selected"' : null); ?>>Could go either way</option>
                <option value="4" <?php echo($assessment_info['Manage_Work'] == 4 ? 'selected=="selected"' : null); ?>>Very likely, not absolute</option>
                <option value="5" <?php echo($assessment_info['Manage_Work'] == 5 ? 'selected=="selected"' : null); ?>>Definitely will</option>
            </select></td></tr>
    <tr><td>I think I will have friends and people that care about me.</td><td><select id="have_friends"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Friends'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>\
                <option value="1" <?php echo($assessment_info['Friends'] == 1 ? 'selected=="selected"' : null); ?>>Not likely at all</option>
                <option value="2" <?php echo($assessment_info['Friends'] == 2 ? 'selected=="selected"' : null); ?>>May be likely but probably not</option>
                <option value="3" <?php echo($assessment_info['Friends'] == 3 ? 'selected=="selected"' : null); ?>>Could go either way</option>
                <option value="4" <?php echo($assessment_info['Friends'] == 4 ? 'selected=="selected"' : null); ?>>Very likely, not absolute</option>
                <option value="5" <?php echo($assessment_info['Friends'] == 5 ? 'selected=="selected"' : null); ?>>Definitely will</option>
            </select></td></tr>
    <tr><td>I will have a happy life.</td><td><select id="happy_life"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Happy_Life'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>\
                <option value="1" <?php echo($assessment_info['Happy_Life'] == 1 ? 'selected=="selected"' : null); ?>>Not likely at all</option>
                <option value="2" <?php echo($assessment_info['Happy_Life'] == 2 ? 'selected=="selected"' : null); ?>>May be likely but probably not</option>
                <option value="3" <?php echo($assessment_info['Happy_Life'] == 3 ? 'selected=="selected"' : null); ?>>Could go either way</option>
                <option value="4" <?php echo($assessment_info['Happy_Life'] == 4 ? 'selected=="selected"' : null); ?>>Very likely, not absolute</option>
                <option value="5" <?php echo($assessment_info['Happy_Life'] == 5 ? 'selected=="selected"' : null); ?>>Definitely will</option>
            </select></td></tr>
    <tr><td>My life will be interesting.</td><td><select id="interesting_life"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Interesting_Life'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>\
                <option value="1" <?php echo($assessment_info['Interesting_Life'] == 1 ? 'selected=="selected"' : null); ?>>Not likely at all</option>
                <option value="2" <?php echo($assessment_info['Interesting_Life'] == 2 ? 'selected=="selected"' : null); ?>>May be likely but probably not</option>
                <option value="3" <?php echo($assessment_info['Interesting_Life'] == 3 ? 'selected=="selected"' : null); ?>>Could go either way</option>
                <option value="4" <?php echo($assessment_info['Interesting_Life'] == 4 ? 'selected=="selected"' : null); ?>>Very likely, not absolute</option>
                <option value="5" <?php echo($assessment_info['Interesting_Life'] == 5 ? 'selected=="selected"' : null); ?>>Definitely will</option>
            </select></td></tr>
    <tr><td>My parents will be proud of me.</td><td><select id="proud_parents"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Proud_Parents'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>\
                <option value="1" <?php echo($assessment_info['Proud_Parents'] == 1 ? 'selected=="selected"' : null); ?>>Not likely at all</option>
                <option value="2" <?php echo($assessment_info['Proud_Parents'] == 2 ? 'selected=="selected"' : null); ?>>May be likely but probably not</option>
                <option value="3" <?php echo($assessment_info['Proud_Parents'] == 3 ? 'selected=="selected"' : null); ?>>Could go either way</option>
                <option value="4" <?php echo($assessment_info['Proud_Parents'] == 4 ? 'selected=="selected"' : null); ?>>Very likely, not absolute</option>
                <option value="5" <?php echo($assessment_info['Proud_Parents'] == 5 ? 'selected=="selected"' : null); ?>>Definitely will</option>
            </select></td></tr>
    <tr><td>Thinking about yourself and when you get older, how likely do you think it is that you will finish high school?</td>
        <td><select id="finish_hs"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Finish_HS'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>\
                <option value="1" <?php echo($assessment_info['Finish_HS'] == 1 ? 'selected=="selected"' : null); ?>>Not likely at all</option>
                <option value="2" <?php echo($assessment_info['Finish_HS'] == 2 ? 'selected=="selected"' : null); ?>>May be likely but probably not</option>
                <option value="3" <?php echo($assessment_info['Finish_HS'] == 3 ? 'selected=="selected"' : null); ?>>Could go either way</option>
                <option value="4" <?php echo($assessment_info['Finish_HS'] == 4 ? 'selected=="selected"' : null); ?>>Very likely, not absolute</option>
                <option value="5" <?php echo($assessment_info['Finish_HS'] == 5 ? 'selected=="selected"' : null); ?>>Definitely will</option>
            </select></td></tr>
    <tr><td colspan="2"></td></tr>
</table>
<div id="show_future_response"></div>
<br/><br/>

<hr><hr>

<h4>Attitude Toward Interpersonal Peer Violence</h4><hr/><br/>

<table class="inner_table" style="border: 2px solid #696969;font-size:.9em;width:70%;margin-left:auto;margin-right:auto;" id="peer_violence_table">
    <tr><td>If I walked away from a fight, I'd be a coward ("chicken").</td><td><select id="chicken"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Cowardice'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="4" <?php echo($assessment_info['Cowardice'] == 4 ? 'selected=="selected"' : null); ?>>Disagree a lot</option>
                <option value="3" <?php echo($assessment_info['Cowardice'] == 3 ? 'selected=="selected"' : null); ?>>Disagree a little</option>
                <option value="2" <?php echo($assessment_info['Cowardice'] == 2 ? 'selected=="selected"' : null); ?>>Agree a little</option>
                <option value="1" <?php echo($assessment_info['Cowardice'] == 1 ? 'selected=="selected"' : null); ?>>Agree a lot</option>
            </select></td></tr>
    <tr><td>Anyone who won't fight is going to be picked on even more.</td><td><select id="prevention"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Teasing_Prevention'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="4" <?php echo($assessment_info['Teasing_Prevention'] == 4 ? 'selected=="selected"' : null); ?>>Disagree a lot</option>
                <option value="3" <?php echo($assessment_info['Teasing_Prevention'] == 3 ? 'selected=="selected"' : null); ?>>Disagree a little</option>
                <option value="2" <?php echo($assessment_info['Teasing_Prevention'] == 2 ? 'selected=="selected"' : null); ?>>Agree a little</option>
                <option value="1" <?php echo($assessment_info['Teasing_Prevention'] == 1 ? 'selected=="selected"' : null); ?>>Agree a lot</option>
            </select></td></tr>
    <tr><td>I don't need to fight because there are other ways to deal with being mad.</td><td><select id="other_ways"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Anger_Mgmt'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['Anger_Mgmt'] == 1 ? 'selected=="selected"' : null); ?>>Disagree a lot</option>
                <option value="2" <?php echo($assessment_info['Anger_Mgmt'] == 2 ? 'selected=="selected"' : null); ?>>Disagree a little</option>
                <option value="3" <?php echo($assessment_info['Anger_Mgmt'] == 3 ? 'selected=="selected"' : null); ?>>Agree a little</option>
                <option value="4" <?php echo($assessment_info['Anger_Mgmt'] == 4 ? 'selected=="selected"' : null); ?>>Agree a lot</option>
            </select></td></tr>
    <tr><td>It's okay to hit someone who hits you first.</td><td><select id="self_defense"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Self_Defense'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="4" <?php echo($assessment_info['Self_Defense'] == 4 ? 'selected=="selected"' : null); ?>>Disagree a lot</option>
                <option value="3" <?php echo($assessment_info['Self_Defense'] == 3 ? 'selected=="selected"' : null); ?>>Disagree a little</option>
                <option value="2" <?php echo($assessment_info['Self_Defense'] == 2 ? 'selected=="selected"' : null); ?>>Agree a little</option>
                <option value="1" <?php echo($assessment_info['Self_Defense'] == 1 ? 'selected=="selected"' : null); ?>>Agree a lot</option>
            </select></td></tr>
    <tr><td>When actions of others make me angry, I can usually deal with it without getting into a physical fight.</td><td>
            <select id="coping_strategies"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Coping'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['Coping'] == 1 ? 'selected=="selected"' : null); ?>>Disagree a lot</option>
                <option value="2" <?php echo($assessment_info['Coping'] == 2 ? 'selected=="selected"' : null); ?>>Disagree a little</option>
                <option value="3" <?php echo($assessment_info['Coping'] == 3 ? 'selected=="selected"' : null); ?>>Agree a little</option>
                <option value="4" <?php echo($assessment_info['Coping'] == 4 ? 'selected=="selected"' : null); ?>>Agree a lot</option>
            </select></td></tr>
    <tr><Td>If a kid teases me or disses me, I usually cannot get them to stop unless I hit them.</td><td><select id="act_out"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Handle_Others'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="4" <?php echo($assessment_info['Handle_Others'] == 4 ? 'selected=="selected"' : null); ?>>Disagree a lot</option>
                <option value="3" <?php echo($assessment_info['Handle_Others'] == 3 ? 'selected=="selected"' : null); ?>>Disagree a little</option>
                <option value="2" <?php echo($assessment_info['Handle_Others'] == 2 ? 'selected=="selected"' : null); ?>>Agree a little</option>
                <option value="1" <?php echo($assessment_info['Handle_Others'] == 1 ? 'selected=="selected"' : null); ?>>Agree a lot</option>
            </select></td></tr>
    <tr><td>If I really want to, I can usually talk someone out of trying to fight with me.</td><td><select id="negotiation"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Negotiation'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['Negotiation'] == 1 ? 'selected=="selected"' : null); ?>>Disagree a lot</option>
                <option value="2" <?php echo($assessment_info['Negotiation'] == 2 ? 'selected=="selected"' : null); ?>>Disagree a little</option>
                <option value="3" <?php echo($assessment_info['Negotiation'] == 3 ? 'selected=="selected"' : null); ?>>Agree a little</option>
                <option value="4" <?php echo($assessment_info['Negotiation'] == 4 ? 'selected=="selected"' : null); ?>>Agree a lot</option>
            </select></td></tr>
    <tr><td>My family would be mad at me if I got in a fight with another student, no matter what the reason.</td><td>
            <select id="disapproval"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Parent_Disapproval'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['Parent_Disapproval'] == 1 ? 'selected=="selected"' : null); ?>>Disagree a lot</option>
                <option value="2" <?php echo($assessment_info['Parent_Disapproval'] == 2 ? 'selected=="selected"' : null); ?>>Disagree a little</option>
                <option value="3" <?php echo($assessment_info['Parent_Disapproval'] == 3 ? 'selected=="selected"' : null); ?>>Agree a little</option>
                <option value="4" <?php echo($assessment_info['Parent_Disapproval'] == 4 ? 'selected=="selected"' : null); ?>>Agree a lot</option>
            </select></td></tr>
    <tr><td>If a student hits me first, my family would want me to hit them back.</td><td><select id="approval"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Parent_Approval'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="4" <?php echo($assessment_info['Parent_Approval'] == 4 ? 'selected=="selected"' : null); ?>>Disagree a lot</option>
                <option value="3" <?php echo($assessment_info['Parent_Approval'] == 3 ? 'selected=="selected"' : null); ?>>Disagree a little</option>
                <option value="2" <?php echo($assessment_info['Parent_Approval'] == 2 ? 'selected=="selected"' : null); ?>>Agree a little</option>
                <option value="1" <?php echo($assessment_info['Parent_Approval'] == 1 ? 'selected=="selected"' : null); ?>>Agree a lot</option>
            </select></td></tr>
    <Tr><td>I usually can tell when things are bothering me or getting on my nerves.</td><td><select id="self_awareness"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Self_Awareness'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['Self_Awareness'] == 1 ? 'selected=="selected"' : null); ?>>Disagree a lot</option>
                <option value="2" <?php echo($assessment_info['Self_Awareness'] == 2 ? 'selected=="selected"' : null); ?>>Disagree a little</option>
                <option value="3" <?php echo($assessment_info['Self_Awareness'] == 3 ? 'selected=="selected"' : null); ?>>Agree a little</option>
                <option value="4" <?php echo($assessment_info['Self_Awareness'] == 4 ? 'selected=="selected"' : null); ?>>Agree a lot</option>
            </select></td></tr>
    <tr><td>If things are bothering me or getting on my nerves, I do things to relax.</td><td><select id="self_care"<?php if(!$editable) {?> disabled='disabled'<?php } ?>>
                <option value="0" <?php echo($assessment_info['Self_Care'] == 0 ? 'selected=="selected"' : null); ?>>N/A</option>
                <option value="1" <?php echo($assessment_info['Self_Care'] == 1 ? 'selected=="selected"' : null); ?>>Disagree a lot</option>
                <option value="2" <?php echo($assessment_info['Self_Care'] == 2 ? 'selected=="selected"' : null); ?>>Disagree a little</option>
                <option value="3" <?php echo($assessment_info['Self_Care'] == 3 ? 'selected=="selected"' : null); ?>>Agree a little</option>
                <option value="4" <?php echo($assessment_info['Self_Care'] == 4 ? 'selected=="selected"' : null); ?>>Agree a lot</option>
            </select></td></tr>
    <tr><td colspan="2"></td></tr>
</table>
<div id="show_violent_response"></div>
<br/><br/>
<?php
?>
<!--Save all.  New and edited surveys are differentiated in save_assessments.php:-->


<?php
    if ($editable) {
?>
    <div id="draftcontainer" class="floating_draft" style="float:left">
        <input type="button" value="Save Draft" onclick="saveSurvey(1);">
    </div>
    <input type="button" value="Save" onclick="saveSurvey(0);">
<?php
    }
?>

<div id="show_intake_response"></div>
<br />
<br />
<script type="text/javascript">
    $(document).ready(function() {
        $(window).scroll(function() {
            var bottom = $(document).height() - $(window).scrollTop() - $(window).height();
            if(bottom < 100) {
                $("#draftcontainer").attr("class", "unfloating_draft");
            } else {
                $("#draftcontainer").attr("class", "floating_draft");
            }
        });
    });

    function saveSurvey(draftValue) {
        <?php if(!$anonymous_entry && !isset($_GET['assessment'])) { ?>
            var chosen_program = document.getElementById('program').value;
            if (chosen_program == '') {
                alert('Please choose a program and then hit Save again.');
                return false;
            }
        <?php } ?>
            var jvq_1 = '';
            var selected = $('input[type=radio][name=JVQ_1]:checked');
            if (selected.length > 0) {
                jvq_1 = selected.val();
            }
            var jvq_2 = '';
            var selected = $('input[type=radio][name=JVQ_2]:checked');
            if (selected.length > 0) {
                jvq_2 = selected.val();
            }
            var jvq_3 = '';
            var selected = $('input[type=radio][name=JVQ_3]:checked');
            if (selected.length > 0) {
                jvq_3 = selected.val();
            }
            var jvq_4 = '';
            var selected = $('input[type=radio][name=JVQ_4]:checked');
            if (selected.length > 0) {
                jvq_4 = selected.val();
            }
            var jvq_5 = '';
            var selected = $('input[type=radio][name=JVQ_5]:checked');
            if (selected.length > 0) {
                jvq_5 = selected.val();
            }
    
            var jvq_6 = '';
            var selected = $('input[type=radio][name=JVQ_6]:checked');
            if (selected.length > 0) {
                jvq_6 = selected.val();
            }
            var jvq_7 = '';
            var selected = $('input[type=radio][name=JVQ_7]:checked');
            if (selected.length > 0) {
                jvq_7 = selected.val();
            }
            var jvq_8 = '';
            var selected = $('input[type=radio][name=JVQ_8]:checked');
            if (selected.length > 0) {
                jvq_8 = selected.val();
            }
            var jvq_9 = '';
            var selected = $('input[type=radio][name=JVQ_9]:checked');
            if (selected.length > 0) {
                jvq_9 = selected.val();
            }
            var jvq_10 = '';
            var selected = $('input[type=radio][name=JVQ_10]:checked');
            if (selected.length > 0) {
                jvq_10 = selected.val();
            }
    
            var jvq_11 = '';
            var selected = $('input[type=radio][name=JVQ_11]:checked');
            if (selected.length > 0) {
                jvq_11 = selected.val();
            }
            var jvq_12 = '';
            var selected = $('input[type=radio][name=JVQ_12]:checked');
            if (selected.length > 0) {
                jvq_12 = selected.val();
            }
            //alert(jvq_12);
    
            $.post(
                    '../ajax/save_assessments.php',
                    {
                        <?php if ($anonymous_entry) { echo "code: '" . $_GET['code'] . "',"; } ?>
                        action: 'baseline',
                        person: '<?php echo $person->participant_id ?>',
                        base_date: document.getElementById('admin_date').value,
                        bys_1: document.getElementById('BYS_1').value,
                        bys_2: document.getElementById('BYS_2').value,
                        bys_3: document.getElementById('BYS_3').value,
                        bys_4: document.getElementById('BYS_4').value,
                        bys_5: document.getElementById('BYS_5').value,
                        bys_6: document.getElementById('BYS_6').value,
                        bys_7: document.getElementById('BYS_7').value,
                        bys_8: document.getElementById('BYS_8').value,
                        bys_9: document.getElementById('BYS_9').value,
                        bys_10: document.getElementById('BYS_10').value,
                        bys_11: document.getElementById('BYS_11').value,
                        jvq_1: jvq_1,
                        jvq_2: jvq_2,
                        jvq_3: jvq_3,
                        jvq_4: jvq_4,
                        jvq_5: jvq_5,
                        jvq_6: jvq_6,
                        jvq_7: jvq_7,
                        jvq_8: jvq_8,
                        jvq_9: jvq_9,
                        jvq_10: jvq_10,
                        jvq_11: jvq_11,
                        jvq_12: jvq_12,
                        baseline_id: '<?php echo $baseline_id; ?>',
                        action_2: 'caring',
                        person: '<?php echo $person->participant_id; ?>',
                                attn: document.getElementById('pay_attention').value,
                        check: document.getElementById('check_in').value,
                        praise: document.getElementById('praise').value,
                        upset: document.getElementById('upset').value,
                        crisis: document.getElementById('crisis').value,
                        advice: document.getElementById('advice').value,
                        know: document.getElementById('know_you').value,
                        important: document.getElementById('important').value,
                        program: <?php if ($anonymous_entry || isset($_GET['assessment'])) {
                                      echo "'$session_id_safe'";
                                 } else { ?> document.getElementById('program').value <?php } ?>,
                        pre_post: 1,
                        caring_id: '<?php echo $caring_id ?>',
                        action_3: 'future',
                        person: '<?php echo $person->participant_id; ?>',
                                solutions: document.getElementById('solve_probs').value,
                        safety: document.getElementById('stay_safe').value,
                        living: document.getElementById('alive_well').value,
                        manage: document.getElementById('manage_work').value,
                        friends: document.getElementById('have_friends').value,
                        happy: document.getElementById('happy_life').value,
                        interesting: document.getElementById('interesting_life').value,
                        parents: document.getElementById('proud_parents').value,
                        finish_hs: document.getElementById('finish_hs').value,
                        future_id: '<?php echo $future_id ?>',
                        action_4: 'violence',
                        person: '<?php echo $person->participant_id; ?>',
                                fear: document.getElementById('chicken').value,
                        prevent: document.getElementById('prevention').value,
                        manage: document.getElementById('other_ways').value,
                                defense: document.getElementById('self_defense').value,
                        coping: document.getElementById('coping_strategies').value,
                        others: document.getElementById('act_out').value,
                        negotiation: document.getElementById('negotiation').value,
                        disapproval: document.getElementById('disapproval').value,
                        approval: document.getElementById('approval').value,
                        awareness: document.getElementById('self_awareness').value,
                        care: document.getElementById('self_care').value,
                        violence_id: '<?php echo $violence_id; ?>',
                        assessment_id: '<?php echo $id_sqlsafe; ?>',
                        draft: draftValue,
                        edited: '<?php echo $edit; ?>'
                    },
            function(response) {
                document.getElementById('show_intake_response').innerHTML += response;
            }).fail(function(response) {
                if(response.responseText == 'bad_date') {
                    alert('Please enter a date completed within last six weeks.');
                } else {
                    alert('You do not have permission to perform this action.');
                }
            });
        }
</script>
<?php

if (!$anonymous_entry) {
    include "../../footer.php";
}
?>

