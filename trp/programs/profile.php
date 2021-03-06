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

include "../../header.php";
include "../header.php";
include "../include/dbconnopen.php";
$get_program_info_sqlsafe = "SELECT * FROM Programs WHERE Program_ID='" . mysqli_real_escape_string($cnnTRP, $_GET['id']) . "'";
include "../include/datepicker_simple.php";
$program_info = mysqli_query($cnnTRP, $get_program_info_sqlsafe);
$program = mysqli_fetch_array($program_info);
?>
<script src="/include/jquery/1.9.1/development-bundle/ui/jquery-ui.custom.js" type="text/javascript"></script>
<!-- specific information about each program. -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#programs_selector').addClass('selected');
        $('#search_to_add_participant').hide();
        $('.attendee_list').hide();
        $('#create_and_add_participant').hide();
        $('#intern_hours').hide();
        $('#enrollee_list').hide();
    });
</script>

<div id="program_profile" class="content_block">

    <h3>Program Profile - <?php echo $program['Program_Name']; ?></h3><hr/><br/>
    
    <table width="100%" border="1">
            <tr>
                <td class="trp_add_table" width="40%">
                    <h4>Add Participants to Program</h4>
                    <!-- list of people in this program, with links to their profiles. -->
                    <div class="add_participant">
                        <a href="javascript:;" onclick="
                                $('#search_to_add_participant').slideToggle();
                           " style="font-size:.8em;" class="no_view" >Add 
                            an existing participant to this program...</a>
                        <div id="search_to_add_participant">

                            <!--- search area.  Search here for people to add to this program.
                            Note that people must be added in the participants section.  There is no "quick add" on the program
                            page.
                            -->
                            <table class="search_table">
                                <tr>
                                    <td class="trp_add_table"><strong>First Name:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="name_search" style="width:100px;"/></td>
                                    <td class="trp_add_table"><strong>Last Name:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="surname_search" style="width:100px;" /></td>
                                </tr>
                                <tr>
                                    <td class="trp_add_table"><strong>DOB:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="dob_search" style="width:70px;" /></td>
                                    <td class="trp_add_table"><strong>Gender:</strong></td>
                                    <td class="trp_add_table"><select id="gender_search">
                                            <option value="">---------</option>
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="trp_add_table" colspan="4" style="text-align:center;"><input type="button" value="Search" onclick="
                                            $.post(
                                                    '../ajax/search_users.php',
                                                    {
                                                        first: document.getElementById('name_search').value,
                                                        last: document.getElementById('surname_search').value,
                                                        dob: document.getElementById('dob_search').value,
                                                        gender: document.getElementById('gender_search').value,
                                                        program_id: <?php echo $program['Program_ID']; ?>,
                                                        program_add: 1
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                document.getElementById('search_results').innerHTML = response;
                                            }
                                            )"/></td>
                                </tr>
                            </table>
                            <!-- choose person and add to program here. -->
                            <div id="search_results"></div>
                        </div>
                        <br><a href="javascript:;" onclick="
                                $('#create_and_add_participant').slideToggle();
                           " style="font-size:.8em;" class="no_view" >Create a new 
                            participant and add him/her to this program...</a>
                        <div id="create_and_add_participant">
                            <table class="trp_add_table">
                                <tr>
                                    <td class="trp_add_table"><strong>First Name:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="name_add" style="width:100px;"/></td>
                                    <td class="trp_add_table"><strong>Last Name:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="surname_add" style="width:100px;" /></td>
                                    <td class="trp_add_table"><strong>DOB:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="dob_add" class="hasDatepickers" style="width:70px;" /></td>
                                    <td class="trp_add_table"><strong>Gender:</strong></td>
                                    <td class="trp_add_table"><select id="gender_add">
                                            <option value="">---------</option>
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                     <td class="trp_add_table"><strong>Race:</strong></td>
                                    <td class="trp_add_table"><select id="race_add">
                <option value="0">N/A</option>
                <option value="1">African-American</option>
                <option value="2">Asian-American</option>
                <option value="3">Latin@</option>
                <option value="4">White</option>
                <option value="5">Other</option>
            </select></td>
                                    <td class="trp_add_table" colspan="6"></td>
                                </tr>
                                <tr>
                                    <td class="trp_add_table"><strong>Email 1</strong></td>
                                    <td class="trp_add_table"><input type="text" id="email1_add"></td>
                                    <td class="trp_add_table"><strong>Mailing Address</strong></td>
                                    <td class="trp_add_table"><input type="text" id=""></td>
                                    <td class="trp_add_table"><strong>Mailing City</strong></td>
                                    <td class="trp_add_table"><input type="text" id="city_add"></td>
                                    <td class="trp_add_table"><strong>Mailing State</strong></td>
                                    <td class="trp_add_table"><input type="text" id="state_add"></td>
                                </tr>
                                <tr>
                                    <td class="trp_add_table"><strong>Zipcode</strong></td>
                                    <td class="trp_add_table"><input type="text" id="zip_add"></td>
                                    <td class="trp_add_table"><strong>Home Phone</strong></td>
                                    <td class="trp_add_table"><input type="text" id="phone_add"></td>
                                    <td class="trp_add_table"><strong>Email 2</strong></td>
                                    <td class="trp_add_table"><input type="text" id="email2_add"></td>
                                    <td class="trp_add_table"><strong>Mobile Phone </strong></td>
                                    <td class="trp_add_table"><input type="text" id="mobile_add"></td>
                                </tr>
                                <tr>
                                    <td class="trp_add_table" colspan="8"><strong>For La Casa Residents</strong></td></tr>
<tr>
 <td class="trp_add_table"><strong>Household size (per La Casa application)</strong></td>
<td class="trp_add_table"><input type="text" id="household_add"></td>
 <td class="trp_add_table"><strong>Parent 1 AGI</strong></td>
<td class="trp_add_table"><input type="text" id="par1agi_add"></td>
<td class="trp_add_table"><strong>Parent 2 AGI</strong></td>
<td class="trp_add_table"><input type="text" id="par2agi_add"></td>
<td class="trp_add_table"><strong>Student AGI</strong></td>
<td class="trp_add_table"><input type="text" id="stntagi_add"></td>
                                </tr>    
    <tr>
    <td class="trp_add_table"><strong>School Year</strong></td>
    <td class="trp_add_table">
    <select id = "new_school_year">
    <option value = "0">-----</option>
    <option value = "2014" > 2014 </option>
    <option value = "2015" > 2015 </option>
    <option value = "2016" > 2016 </option>
    <option value = "2017" > 2017 </option>
    </select>
    
    </td>
    <td class="trp_add_table"><strong>College</strong></td>
    <td class="trp_add_table">
    <select id = "new_college_id">
    <option value = "0">-----</option>
<?php 
    $get_college_list_sqlsafe = "SELECT * FROM Colleges";
include "../include/dbconnopen.php";
$college_list = mysqli_query($cnnTRP, $get_college_list_sqlsafe);
while ($college = mysqli_fetch_row($college_list)){
?>
    <option value = "<?php echo $college[0]; ?>" > <?php echo $college[1]; ?> </option>
<?php
}
?>
</select><br>
Or add a new college: <input type = "text" id = "new_college_name">
<select id = "new_college_type">
<option value = "">----</option>
<option>2-year</option>
<option>4-year</option>
</select>
</td>
<td class="trp_add_table"><strong>Term Type</strong></td>
<td class="trp_add_table">
<select id = "new_term_type">
    <option value = "0">-----</option>
    <option value = "1"> Semester </option>
    <option value = "2"> Quarter </option>
    <option value = "3"> Other </option>    <!-- Need to document this properly -->
    </select>
    </td>
    <td class="trp_add_table"><strong>Term</strong></td>
    <td class="trp_add_table">
    <select id = "new_term_id">
    <option value = "0">-----</option>
    <option value = "1"> Fall </option>
    <option value = "2"> Winter </option>
    <option value = "3"> Spring </option>
    <option value = "4"> Summer </option>
    </select>
    </td>
    </tr>
    <tr>
    <td class="trp_add_table"><strong>Number of Credits</strong</td>
    <td class="trp_add_table"><input type="text" id="new_credits"></td>
    <td class="trp_add_table"><strong>Number of Loan Applications</strong></td>
    <td class="trp_add_table">
    <input type="text" class = "show_loans_edit_<?php echo $loandata[4]; ?>" id="new_loan_apps"></td>
    <td class="trp_add_table"><strong>Volume of Loan Applications</strong></td>
    <td class="trp_add_table">
    <input type="text" class = "show_loans_edit_<?php echo $loandata[4]; ?>" id="new_loan_volume"></td>
    <td class="trp_add_table"><strong>Volume of Loans Received</strong></td>
    <td class="trp_add_table">
    <input type="text" class = "show_loans_edit_<?php echo $loandata[4]; ?>" id="new_loans_received"></td>
    </tr>
<tr>
    <td class="trp_add_table"><strong>Number of Scholarship Applications</strong></td>
    <td class="trp_add_table">
    <input type="text" class = "show_scholarships_edit_<?php echo $scholarshipdata[4]; ?>" id="new_scholarship_apps"></td>
    <td class="trp_add_table"><strong>Number of Scholarships Offered</strong></td>
    <td class="trp_add_table">
    <input type="text" class = "show_scholarships_edit_<?php echo $scholarshipdata[4]; ?>" id="new_scholarship_num"></td>
    <td class="trp_add_table"><strong>Volume of Scholarship Funding Offered</strong></td>
    <td class="trp_add_table">
    <input type="text" class = "show_scholarships_edit_<?php echo $scholarshipdata[4]; ?>" id="new_scholarship_volume"></td>
    <td class="trp_add_table"><strong>Volume of Scholarship Funding Received</strong></td>
    <td class="trp_add_table">
    <input type="text" class = "show_scholarships_edit_<?php echo $scholarshipdata[4]; ?>" id="new_scholarships_received"></td>

</tr>
<tr>
    <td class="trp_add_table"><strong>Total household income</strong></td>
    <td class="trp_add_table">
    <input type="text" id="new_household_income"></td>

    <td class="trp_add_table"><strong>AMI</strong></td>
    <td class="trp_add_table">
    <input type="text" id="new_AMI"></td>

    <td class="trp_add_table"><strong>Move in date</strong></td>
    <td class="trp_add_table">
    <input type="text" id="new_move_in_date" class="hasDatepickers"></td>

    <td class="trp_add_table"><strong>Move out date</strong></td>
    <td class="trp_add_table">
    <input type="text" id="new_move_out_date" class="hasDatepickers"></td>

</tr>
<tr>

    <td class="trp_add_table"><strong>Age 24 or older?</strong></td>
    <td class="trp_add_table">
    <select id="new_24_or_older">
    <option value = "">-----</option>
    <option value = "1">Yes</option>
    <option value = "2">No</option>
    </select>
    </td>

    <td class="trp_add_table"><strong>Masters degree or above?</strong></td>
    <td class="trp_add_table">
    <select id="new_masters_degree">
    <option value = "">-----</option>
    <option value = "1">Yes</option>
    <option value = "2">No</option>
    </select>
    </td>

    <td class="trp_add_table"><strong>Married?</strong></td>
    <td class="trp_add_table">
    <select id="new_married">
    <option value = "">-----</option>
    <option value = "1">Yes</option>
    <option value = "2">No</option>
    </select>
    </td>

    <td class="trp_add_table"><strong>Has Children?</strong></td>
    <td class="trp_add_table">
    <select id="new_has_children">
    <option value = "">-----</option>
    <option value = "1">Yes</option>
    <option value = "2">No</option>
    </select>
</td>
</tr>
<tr>
    <td class="trp_add_table"><strong>Homeless?</strong></td>
    <td class="trp_add_table">
    <select id="new_homeless">
    <option value = "">-----</option>
    <option value = "1">Yes</option>
    <option value = "2">No</option>
    </select>
    </td>
    <td class="trp_add_table"><strong>Self sustaining?</strong></td>
    <td class="trp_add_table">
    <select id="new_self_sustaining">
    <option value = "">-----</option>
    <option value = "1">Yes</option>
    <option value = "2">No</option>
    </select>
    </td>
    <td class="trp_add_table"><strong>Dependency Status</strong></td>
    <td class="trp_add_table">
    <select id="new_dependency_status">
    <option value = "">-----</option>
    <option value = "1">Yes</option>
    <option value = "2">No</option>
    </select>
    </td>
    <td class="trp_add_table"><strong>Has Internship?</strong></td>
    <td class="trp_add_table">
    <select id="new_internship_status" onchange="$(#new_intern_hours).show();">
    <option value = "">-----</option>
    <option value = "1">Yes</option>
    <option value = "2">No</option>
    </select>
    <span id="new_intern_hours">Hours per week: <input type="text" id="new_internship_hours"></span>
    </td>
</tr>
    <tr>
                                  
</tr>                                
                                <tr>
                                    <td class="trp_add_table" colspan="8" style="text-align:center;"><input type="button" value="Add" onclick="
                                    $.post(
                                        '../ajax/add_participant.php',
                                        {
                                            action: 'add_to_program',
                                            first_add: document.getElementById('name_add').value,
                                            last_add: document.getElementById('surname_add').value,
                                            dob_add: document.getElementById('dob_add').value,
                                            gender_add: document.getElementById('gender_add').value,
                                            race_add: document.getElementById('race_add').value,
                                            program: <?php echo $program['Program_ID']; ?>,
                                            email1: document.getElementById('email1_add').value,
                                            city_add: document.getElementById('city_add').value,
                                            state_add: document.getElementById('state_add').value,
                                            zip_add: document.getElementById('zip_add').value,
                                            phone_add: document.getElementById('phone_add').value,
                                            email2_add: document.getElementById('email2_add').value,
                                            mobile: document.getElementById('mobile_add').value,
                                            school_year: document.getElementById('new_school_year').value,
                                            loan_apps: document.getElementById('new_loan_apps').value,
                                            loan_volume: document.getElementById('new_loan_volume').value,
                                            loans_received: document.getElementById('new_loans_received').value,
                                            college_id: document.getElementById('new_college_id').value,
                                            college_name: document.getElementById('new_college_name').value,
                                            college_type: document.getElementById('new_college_type').value,
                                            term_type: document.getElementById('new_term_type').value,
                                            term_id: document.getElementById('new_term_id').value,
                                            credits: document.getElementById('new_credits').value,
                                            household_size: document.getElementById('household_add').value,
                                            parent1_agi: document.getElementById('par1agi_add').value,
                                            parent2_agi: document.getElementById('par2agi_add').value,
                                            student_agi: document.getElementById('stntagi_add').value,
                                            scholarship_apps: document.getElementById('new_scholarship_apps').value,
                                            scholarship_num: document.getElementById('new_scholarship_num').value,
                                            scholarship_volume: document.getElementById('new_scholarship_volume').value,
                                            scholarships_received: document.getElementById('new_scholarships_received').value,
                                            household_income: document.getElementById('new_household_income').value,
                                            AMI: document.getElementById('new_AMI').value,
                                            move_in_date: document.getElementById('new_move_in_date').value,
                                            move_out_date: document.getElementById('new_move_out_date').value,
                                            mid_twenties: document.getElementById('new_24_or_older').value,
                                            masters_degree: document.getElementById('new_masters_degree').value,
                                            married: document.getElementById('new_married').value,
                                            has_children: document.getElementById('new_has_children').value,
                                            homeless: document.getElementById('new_homeless').value,
                                            self_sustaining: document.getElementById('new_self_sustaining').value,
                                            dependency_status: document.getElementById('new_dependency_status').value,
                                            internship_status: document.getElementById('new_internship_status').value,
                                            intern_hours: document.getElementById('new_internship_hours').value
                                        },
                                    function(response) {
                                       document.getElementById('add_person_results').innerHTML = response;
                                    }
                                    )"/></td>
                                </tr>
                            </table>
                            <div id="add_person_results"></div>
                        </div>
                    </div>
                    <hr>
                    <h4><a href="javascript:;" onclick = "$('#enrollee_list').toggle()">Current Program Enrollment</a></h4>
                    <ul style="list-style-type:none;" id = "enrollee_list">
                        <?php
                        $get_participants_sqlsafe = "SELECT * FROM Participants_Programs INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID WHERE Program_ID='" . $program['Program_ID'] . "' ORDER BY Participants.Last_Name";
                        $participants = mysqli_query($cnnTRP, $get_participants_sqlsafe);
                        while ($participant = mysqli_fetch_array($participants)) {
                            ?>
                            <li><a href="../participants/profile.php?id=<?php echo $participant['Participant_ID']; ?>"><?php echo $participant['First_Name'] . " " . $participant['Last_Name']; ?></a></li>
                            <?php
                        }
                        ?>

                    </ul>

                    <br/>
                    <br/>
    
    <?php
    //Chicago Commons Early Childhood Program
    if ($program['Program_ID'] == 1) {
        ?>
        
                    <!-- program notes.  documents uploaded by program users (not participants, but system users) -->
                    <h4>Upload Notes</h4>
                    <span class="helptext">Uploaded information will be saved in the system as a supporting document for this program.
                    </span><br>


                    <?php
                    $get_uploads_sqlsafe = "SELECT Upload_Id, File_Name FROM Programs_Uploads WHERE Program_ID='" . mysqli_real_escape_string($cnnTRP, $_GET['id']) . "'";
                    $result = mysqli_query($cnnTRP, $get_uploads_sqlsafe);
                    if (mysqli_num_rows($result) == 0) {
                        echo "No notes have been uploaded <br>";
                    } else {
                        while (list($id, $name) = mysqli_fetch_array($result)) {
                            ?>

                            <a href="/trp/ajax/download.php?id=<?php echo $id; ?>"><?php echo $name; ?></a> <br>
                            <?php
                        }
                    }
                    ?>


                    <form id="file_upload_form" class="no_view" action="/trp/ajax/upload_file.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" id="file" /> 
                        <input type="hidden" name="event_id" value="<?php echo $_GET['id']; ?>">
                        <br />
                        <input type="submit" name="submit" value="Upload" />
                        <iframe id="upload_target" name="upload_target" src="" style="width:0;height:0;border:0px solid #fff;"></iframe>
                    </form>

                </td>
                <td class="trp_add_table">

                    <!-- aggregate GOLD scores for program participants: -->
                    <h4>GOLD Scores</h4>
    <?php
    //get averages
    $averages_1_sqlsafe = "SELECT AVG(Social_Emotional), AVG(Physical), AVG(Language), AVG(Cognitive), AVG(Literacy),
                                        AVG(Mathematics), AVG(Science_Tech), AVG(Social_Studies), AVG(Creative_Arts), AVG(English)
                                        FROM Gold_Score_Totals INNER JOIN
                                        (SELECT MAX(Date_Logged) as maxdate FROM Gold_Score_Totals GROUP BY Participant) lastdate
                                                ON Gold_Score_Totals.Date_Logged=lastdate.maxdate
                                        WHERE Gold_Score_Totals.Year=1
                                        AND (Social_Emotional!='' OR Physical!='' OR Language!='' OR Cognitive!='' OR Literacy!='' OR Mathematics!='' OR Science_Tech!=''
                                        OR Social_Studies!='' OR Creative_Arts!='' OR English!='');";
    $averages_2_sqlsafe = "SELECT AVG(Social_Emotional), AVG(Physical), AVG(Language), AVG(Cognitive), AVG(Literacy),
                                        AVG(Mathematics), AVG(Science_Tech), AVG(Social_Studies), AVG(Creative_Arts), AVG(English)
                                        FROM Gold_Score_Totals INNER JOIN
                                        (SELECT MAX(Date_Logged) as maxdate FROM Gold_Score_Totals GROUP BY Participant) lastdate
                                                ON Gold_Score_Totals.Date_Logged=lastdate.maxdate
                                        WHERE Gold_Score_Totals.Year=2
                                        AND (Social_Emotional!='' OR Physical!='' OR Language!='' OR Cognitive!='' OR Literacy!='' OR Mathematics!='' OR Science_Tech!=''
                                        OR Social_Studies!='' OR Creative_Arts!='' OR English!='');";
    $averages_3_sqlsafe = "SELECT AVG(Social_Emotional), AVG(Physical), AVG(Language), AVG(Cognitive), AVG(Literacy),
                                        AVG(Mathematics), AVG(Science_Tech), AVG(Social_Studies), AVG(Creative_Arts), AVG(English)
                                        FROM Gold_Score_Totals INNER JOIN
                                        (SELECT MAX(Date_Logged) as maxdate FROM Gold_Score_Totals GROUP BY Participant) lastdate
                                                ON Gold_Score_Totals.Date_Logged=lastdate.maxdate
                                        WHERE Gold_Score_Totals.Year=3
                                        AND (Social_Emotional!='' OR Physical!='' OR Language!='' OR Cognitive!='' OR Literacy!='' OR Mathematics!='' OR Science_Tech!=''
                                        OR Social_Studies!='' OR Creative_Arts!='' OR English!='');";
    $averages_yr_1 = mysqli_query($cnnTRP, $averages_1_sqlsafe);
    $averages1 = mysqli_fetch_row($averages_yr_1);
    $averages_yr_2 = mysqli_query($cnnTRP, $averages_2_sqlsafe);
    $averages2 = mysqli_fetch_row($averages_yr_2);
    $averages_yr_3 = mysqli_query($cnnTRP, $averages_3_sqlsafe);
    $averages3 = mysqli_fetch_row($averages_yr_3);
    ?>
                    <table id="gold_scores_table">
                        <tr>
                            <th></th><th>Year 1 Avg. Score</th><th>Year 2 Avg. Score</th><th>Year 3 Avg. Score</th>
                        </tr>
                        <tr>
                            <td class="trp_add_table" class="gold_category">Social-Emotional</td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages1[0], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages2[0], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages3[0], 1); ?></td>
                        </tr>
                        <tr>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                        </tr>

                        <!-- these commented areas are for the scores for individual questions.
                        we're just showing the aggregate score for each section for now, but wanted to leave
                        the option to save individual responses too.
                        -->

    <!--<tr>
            <td class="trp_add_table"><strong>1a.</strong> Manages feelings</td>
            <td class="trp_add_table"></td>
    </tr>
    <tr>
            <td class="trp_add_table"><strong>1b.</strong> Follows limits and expectations</td>
            <td class="trp_add_table"></td>
    </tr>
    <tr>
            <td class="trp_add_table"><strong>1c.</strong> Takes care of own needs appropriately</td>
            <td class="trp_add_table"></td>
    </tr>
    <tr>
            <td class="trp_add_table"><strong>2a.</strong> Forms relationships with adults</td>
            <td class="trp_add_table"></td>
    </tr>
    <tr>
            <td class="trp_add_table"><strong>2b.</strong> Responds to emotional cues</td>
            <td class="trp_add_table"></td>
    </tr>
    <tr>
            <td class="trp_add_table"><strong>2c.</strong> Interacts with peers</td>
            <td class="trp_add_table"></td>
    </tr>
    <tr>
            <td class="trp_add_table"><strong>2d.</strong> Makes friends</td>
            <td class="trp_add_table"></td>
    </tr>
    <tr>
            <td class="trp_add_table"><strong>3a.</strong> Balances needs and rights of self and others</td>
            <td class="trp_add_table"></td>
    </tr>
    <tr>
            <td class="trp_add_table"><strong>3b.</strong> Solves social problems</td>
            <td class="trp_add_table"></td>
    </tr>-->
                        <tr>
                            <td class="trp_add_table" class="gold_category">Physical</td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages1[1], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages2[1], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages3[1], 1); ?></td>
                        </tr>
                        <tr>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                        </tr>
                        <!--<tr>
                                <td class="trp_add_table"><strong>4.</strong> Demonstrates traveling skills</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>5.</strong> Demonstrates balancing skills</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>6.</strong> Demonstrates gross motor manipulative skills</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>7a.</strong> Uses fingers and hands</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>7b.</strong> Uses writing and drawing tools</td>
                                <td class="trp_add_table"></td>
                        </tr>-->
                        <tr>
                            <td class="trp_add_table" class="gold_category">Language</td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages1[2], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages2[2], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages3[2], 1); ?></td>
                        </tr>
                        <tr>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                        </tr>
                        <!--<tr>
                                <td class="trp_add_table"><strong>8a.</strong> Comprehends language</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>8b.</strong> Follows directions</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>9a.</strong> Uses an expanding expressive vocabulary</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>9b.</strong> Speaks clearly</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>9c.</strong> Uses conventional grammar</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>9d.</strong> Tells about another time or place</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>10a.</strong> Engages in conversations</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>10b.</strong> Uses social rules of language</td>
                                <td class="trp_add_table"></td>
                        </tr>-->
                        <tr>
                            <td class="trp_add_table" class="gold_category">Cognitive</td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages1[3], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages2[3], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages3[3], 1); ?></td>
                        </tr>
                        <tr>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                        </tr>
                        <!--<tr>
                                <td class="trp_add_table"><strong>11a.</strong> Attends and engages</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>11b.</strong> Persists</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>11c.</strong> Solves problems</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>11d.</strong> Shows curiosity and motivation</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>11e.</strong> Shows flexibility and inventiveness in thinking</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>12a.</strong> Recognizes and recalls</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>12b.</strong> Makes connections</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>13.</strong> Classifies</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>14a.</strong> Thinks symbolically</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>14b.</strong> Engages in sociodramatic play</td>
                                <td class="trp_add_table"></td>
                        </tr>-->
                        <tr>
                            <td class="trp_add_table" class="gold_category">Literacy</td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages1[4], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages2[4], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages3[4], 1); ?></td>
                        </tr>
                        <tr>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                        </tr>
                        <!--<tr>
                                <td class="trp_add_table"><strong>15a.</strong> Notices and discriminates rhyme</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>15b.</strong> Notices and discriminates alliteration</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>15c.</strong> Notices and discriminates smaller and smaller units of sound</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>16a.</strong> Identifies and names letters</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>16b.</strong> Uses letter-sound knowledge</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>17a.</strong> Uses and appreciates books</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>17b.</strong> Uses print concepts</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>18a.</strong> Interacts during read-alouds and book conversations</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>18b.</strong> Uses emergent reading skills</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>18c.</strong> Retells stories</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>19a.</strong> Writes name</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>19b.</strong> Writes to convey meaning</td>
                                <td class="trp_add_table"></td>
                        </tr>-->
                        <tr>
                            <td class="trp_add_table" class="gold_category">Mathematics</td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages1[5], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages2[5], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages3[5], 1); ?></td>
                        </tr>
                        <tr>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                        </tr>
                        <!--<tr>
                                <td class="trp_add_table"><strong>20a.</strong> Counts</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>20b.</strong> Quantifies</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>20c.</strong> Connects numerals with their quantities</td>
                                <td class="trp_add_table"></td>
                        </tr><tr>
                                <td class="trp_add_table"><strong>21a.</strong> Understands spatial relationships</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>21b.</strong> Understands shapes</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>22.</strong> Compares and measures</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>23.</strong> Demonstrates knowledge of patterns</td>
                                <td class="trp_add_table"></td>
                        </tr>-->
                        <tr>
                            <td class="trp_add_table" class="gold_category">Science and Technology</td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages1[6], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages2[6], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages3[6], 1); ?></td>
                        </tr>
                        <tr>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                        </tr>
                        <!--<tr>
                                <td class="trp_add_table"><strong>24.</strong> Uses scientific inquiry skills</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>25.</strong> Demonstrates knowledge of the physical properties of objects and materials</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>26.</strong> Demonstrates knowledge of the physical properties of objects and materials</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>27.</strong> Demonstrates knowledge of the Earth's environment</td>
                                <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                                <td class="trp_add_table"><strong>28.</strong> Uses tools and other technology to perform tasks</td>
                                <td class="trp_add_table"></td>
                        </tr>-->
                        <tr>
                            <td class="trp_add_table" class="gold_category">Social Studies</td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages1[7], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages2[7], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages3[7], 1); ?></td>
                        </tr>
                        <tr>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                        </tr>
                        <!--<tr>
                                <td class="trp_add_table"><strong>29.</strong> Demonstrates knowledge about self</td>
                                <td class="trp_add_table"></td>
                        </tr>-->
                        <tr>
                            <td class="trp_add_table" class="gold_category">Creative Arts Expression</td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages1[8], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages2[8], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages3[8], 1); ?></td>
                        </tr>
                        <tr>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                        </tr>
                        <tr>
                            <td class="trp_add_table" class="gold_category">English Language Development</td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages1[9], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages2[9], 1); ?></td>
                            <td class="trp_add_table" class="gold_category"><?php echo number_format($averages3[9], 1); ?></td>
                        </tr>
                        <tr>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                            <td class="trp_add_table"></td>
                        </tr>
                    </table>
                    <table>
                        <tr><th>Classroom Number</th><th>Test Time</th><th>Question</th><th>Classroom Average</th><th></th></tr>
                        <?php
                        //show all existing classroom info
                        $get_class_avgs_sqlsafe="SELECT * FROM Class_Avg_Gold_Scores LEFT JOIN Gold_Score_Sections ON Question_ID=Gold_Question_ID";
                       // echo $get_class_avgs;
                        $class_avgs=mysqli_query($cnnTRP, $get_class_avgs_sqlsafe);
                        while ($class_avg=mysqli_fetch_array($class_avgs)){
                            ?>
                        <tr><td class="trp_add_table"><?php echo $class_avg['Classroom_ID'];?></td><td class="trp_add_table"><?php if($class_avg['Test_Year']==1){ echo 'First Year';}
                        elseif($class_avg['Test_Year']==2){ echo 'Second Year';}
                        elseif($class_avg['Test_Year']==3){ echo 'Third Year';}
                        if($class_avg['Test_Time']==1){ echo ' Pre Test';}
                        if($class_avg['Test_Time']==2){ echo ' Mid Test';}
                        if($class_avg['Test_Time']==3){ echo ' Post Test';}
                            ?></td>
                            <td class="trp_add_table"><?php echo $class_avg['Gold_Section_Name'];?></td>
                            <td class="trp_add_table"> <?php echo $class_avg['Class_Avg']; ?> </td>
                        </tr>
                                <?php
                        }
                        ?>
                        <tr><td class="trp_add_table"><input type="text" id="new_class_num"></td>
                        <td class="trp_add_table"><select id="new_class_year">
                                            <option value="1">First Year</option>
                                            <option value="2">Second Year</option>
                                            <option value="3">Third Year</option>
                                        </select> <select id="new_class_time">
                                            <option value="1">Pre Test</option>
                                            <option value="2">Mid Test</option>
                                            <option value="3">Post Test</option>
                                        </select></td>
                                                <td class="trp_add_table"><select id="new_class_question">
                                            <?php 
                                            $section_query_sqlsafe="SELECT * FROM Gold_Score_Sections";
                                            $sections=mysqli_query($cnnTRP, $section_query_sqlsafe);
                                            while ($sec=  mysqli_fetch_array($sections)){
                                                ?>
                                                        <option value="<?php echo $sec[0];?>"><?php echo $sec[1];?></option>
                                                    <?php
                                            }
                                            ?>
                                            </select>
                                        </td>
                        <td class="trp_add_table"><input type="text" id="new_class_avg"></td>
                        <td class="trp_add_table"><input type="button" value="Save" onclick="
                                   $.post(
                                       '../ajax/edit_gold_avgs.php',
                                   {
                                       action: 'new',
                                       classroom: document.getElementById('new_class_num').value,
                                       test_year: document.getElementById('new_class_year').value,
                                       test_time: document.getElementById('new_class_time').value,
                                       class_avg: document.getElementById('new_class_avg').value,
                                       question: document.getElementById('new_class_question').value
                                   },
                                   function(response){
                                      // document.write(response);
                                       window.location = 'profile.php?id=<?php echo $_GET['id']; ?>';
                                   });"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr> <td class="trp_add_table">  <!--Finally, Early Childhood Attendance-->
                    <h4>Early Childhood Attendance</h4>

                    <table class="inner_table">
    <?php
    //get dates
    $date_query_sqlsafe = "SELECT Date_ID, Date FROM Program_Dates WHERE Program_Id='" . mysqli_real_escape_string($cnnTRP, $_GET['id']) . "'";
    $program_dates = mysqli_query($cnnTRP, $date_query_sqlsafe);
    while ($date = mysqli_fetch_row($program_dates)) {
        $format_date = explode('-', $date[1]);
        $date_formatted = $format_date[1] . '/' . $format_date[2] . '/' . $format_date[0];
        ?>
                            <tr><td class="trp_add_table"><?php echo $date_formatted; ?></td><td class="trp_add_table"><a class="helptext" href="javascript:;" onclick="$('#today_attendees_<?php echo $date[0] ?>').toggle();">Show/hide attendees</a>
                                    <div id="today_attendees_<?php echo $date[0] ?>" class="attendee_list"> <?php
                    ////get attendees
                    $attendance_query_sqlsafe = "SELECT First_Name, Last_Name FROM Program_Attendance 
                                INNER JOIN Participants ON Participants.Participant_Id=Program_Attendance.Participant_ID 
                                INNER JOIN Program_Dates ON Program_Attendance.Date_ID=Program_Dates.Date_ID
                                WHERE Program_Dates.Date_ID=$date[0]";
                    //echo $attendance_query;
                    $attendance = mysqli_query($cnnTRP, $attendance_query_sqlsafe);
                    while ($attendee = mysqli_fetch_row($attendance)) {
                        echo $attendee[0] . " " . $attendee[1] . "<br>";
                    }
        ?>
                                        <!-- people need to be enrolled in the program before they can attend a session.  Don't see the person you want to 
                                        add?  Make sure they're enrolled at the top left. -->
                                        Add attendee: <?php
                                           $get_members_sqlsafe = "SELECT Participants_Programs.Participant_Id, First_Name, Last_Name FROM Participants_Programs
                                    INNER JOIN Participants ON Participants.Participant_Id=Participants_Programs.Participant_Id WHERE Program_ID='" . mysqli_real_escape_string($cnnTRP, $_GET['id']) . "'";
                                //echo $get_members_sqlsafe; 
        ?><select id="new_attendee_<?php echo $date[0] ?>" class="no_view"  onchange="
                                            var attendee = this.value;
                                            $.post(
                                                    '../ajax/new_date.php',
                                                    {
                                                        action: 'attendance',
                                                        date: '<?php echo $date[0]; ?>',
                                                        person: attendee
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                window.location = 'profile.php?id=<?php echo $_GET['id']; ?>';
                                            }
                                            )">
                                            <option value="">-----</option>
                                            <?php
                                            $members = mysqli_query($cnnTRP, $get_members_sqlsafe);
                                            while ($member = mysqli_fetch_row($members)) {
                                                ?>
                                                <option value="<?php echo $member[0] ?>"><?php echo $member[1] . " " . $member[2]; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div></td></tr>

                            <?php
                        }
                        ?> <tr>
                            <!-- add a new program date: -->
                            <td class="trp_add_table">Add Date: <input type="text" id="new_early_childhood_date" class="hasDatepickers no_view"></td>
                            <td class="trp_add_table"><input type="button" value="Save Date" class="no_view" onclick="
                                    $.post(
                                            '../ajax/new_date.php',
                                            {
                                                action: 'new_date',
                                                date: document.getElementById('new_early_childhood_date').value,
                                                program: '<?php echo $_GET['id']; ?>'
                                            },
                                    function(response) {
                                        // document.write(response);
                                        window.location = 'profile.php?id=<?php echo $_GET['id']; ?>';
                                    }
                                    )"><br/>
                                <span class="helptext">Dates must be entered in MM/DD/YYYY format to save correctly.</span></td>
                        </tr>
                    </table>

                </td>
            </tr>
        

        <?php
    }
    else if ($program['Program_ID'] == 6){

//handle filtering
if ( isset($_POST['filter_submit']) ) {
    include "../include/dbconnopen.php";
    $term_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['term_filter']);
    $year_filter_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['year_filter']);
    if ($term_sqlsafe = 'Fall'){
        $move_in_date = $_POST['year_filter'] . '-08-01';
        $move_out_date = $_POST['year_filter'] . '-12-31';
    }
    elseif ($term_sqlsafe = 'Winter'){
        $move_in_date = $_POST['year_filter'] . '-01-01';
        $move_out_date = $_POST['year_filter'] . '-03-31';
    }
    elseif ($term_sqlsafe = 'Spring'){
        $move_in_date = $_POST['year_filter'] . '-04-01';
        $move_out_date = $_POST['year_filter'] . '-06-30';
    }
    elseif ($term_sqlsafe = 'Summer'){
        $move_in_date =  $_POST['year_filter'] . '-07-01';
        $move_out_date =  $_POST['year_filter'] . '-07-31';
    }
    
    $lc_terms_string = " WHERE Term = '$term_sqlsafe' AND School_Year = '" . $_POST['year_filter'] . "'";
    $basics_string = " WHERE Move_In_Date <= $move_in_date AND Move_Out_Date >= $move_out_date ";
    echo "<h3> Results for " . $term_sqlsafe . " " . $_POST['year_filter'] . "</h3>";
}



//choose a year for reports:
        $year = '2014';
        $bachelors_id_sqlsafe = "SELECT Education_ID FROM Educational_Levels WHERE Education_Level_Name = 'Bachelors'";
        $bachelors = mysqli_query($cnnTRP, $bachelors_id_sqlsafe);
        $bachelor = mysqli_fetch_row($bachelors);
        $bachelors_id = $bachelor[0];
        $high_schools_id_sqlsafe = "SELECT Education_ID FROM Educational_Levels WHERE Education_Level_Name = 'High School Diploma'";
        $high_schools = mysqli_query($cnnTRP, $high_schools_id_sqlsafe);
        $high_school = mysqli_fetch_row($high_schools);
        $high_school_id = $high_school[0];
        $la_casa_count_sqlsafe = "SELECT * FROM Participants_Programs WHERE Program_ID = 6;";
        include "../include/dbconnopen.php";
        $lc_count = mysqli_query($cnnTRP, $la_casa_count_sqlsafe);
        $students_denominator = mysqli_num_rows($lc_count);
        $lc_terms_count_sqlsafe = "SELECT * FROM LC_Terms " . $lc_terms_string;
        $lc_terms_count = mysqli_query($cnnTRP, $lc_terms_count_sqlsafe);
        $lc_terms_denominator = mysqli_num_rows($lc_terms_count);
/*
Inputs: CURSOR = result of mysqli_query() 
        REPORT_SUBJECT is the string that will be printed in the
              highest/lowest explanation rows.
        VAL_DENOMINATOR is the denominator for the percentages.
              Usually this is $students_denominator, calculated above.  It
              is the number of people linked to the La Casa program (note
              that not all of these people have information in the
              La_Casa_Basics table).
        IS_INCOME is a flag that determines whether this is the
        household income report.  By default it is set to false, but in the
        income call to the function it is set to true.
        COUNTINDEX is the index of the count in the cursor.
        DESCRIPTION_INDEX is the index of the result (e.g., "African-American")
              in the cursor.
        
Outputs: The result is a string that is a set of html table rows (see below).

Call this to provide rows to be inserted into a La Casa table,
including a highest row, lowest row, and average row.  For example:

    Race                      | Percent | Count
    Hispanic or Latino        | 25%     | 2
    Black or African-American | 25%     | 2
    Asian or Asian-American   | 13%     | 1
    Lowest <Race>                       | Asian or Asian-American
    Highest <Race>                      | Hispanic or Latino
    Average <Race>                      | (this example fails here)


This function returns the rows of information from "Hispanic or
Latino" to ...fails here).

Reports that display the highest/lowest value and average are: Race/Ethnicity (not average),
 Household Size, Household Income,
Credit Accrual, College GPA, ACT Score, High School GPA.
Other than Race/Ethnicity, all of these reports also include an average row.
 */
        function la_casa_report_high_low_gen_html($cursor, $report_subject, $val_denominator, $is_income = false, $countindex = 0, $description_index = 1)
{
    $lowest_val = null;
    $highest_val = null;
    $result = "";
    $reporting_number = 0;
    $avg_numerator = 0;
    $null_count = 0;
    if ($is_income){
        $below15 = 0;
        $below25 = 0;
        $below50 = 0;
    }
    while ($val = mysqli_fetch_row($cursor)) {
        $reporting_number += $val[$countindex];
        if ($lowest_val == null) {
            $lowest_val = $val[$description_index];
        }
        elseif ($val[$description_index] < $lowest_val){
            $lowest_val = $val[$description_index];
        }
        if ($highest_val == null) {
            $highest_val = $val[$description_index];
        }
        elseif ($val[$description_index] > $highest_val){
            $highest_val = $val[$description_index];
        }
        if ($val[$description_index] != null){
            if ($is_income) {
                if ($val[$description_index] < 50000){
                    $below50 += $val[$countindex];
                }
                if ($val[$description_index] < 25000){
                    $below25 += $val[$countindex];
                }
                if ($val[$description_index] < 15000){
                    $below15 += $val[$countindex];
                }
            }
            $result .= "<tr>
        <td>". $val[$description_index] . "</td>
        <td>" . number_format($val[$countindex]/$val_denominator*100) . "%</td>
        <td>" . $val[$countindex] . "</td>
        </tr>";
            $avg_numerator += ($val[$description_index] * $val[$countindex]);
        }
        else{
            $null_count += $val[$countindex];
        }
    }
    $result .= "<tr>
<td> Unknown </td>
<td>" . number_format((($val_denominator + $null_count) - $reporting_number)/$val_denominator * 100 ) .  "%</td>
<td> " . (($val_denominator + $null_count) - $reporting_number) . "</td>
</tr>";
    $result .= "<tr>
        <td colspan = 2><strong> Lowest " . $report_subject
    . " </strong></td>
        <td> " . $lowest_val . "</td></tr>";
    $result .= "<tr>
        <td colspan = 2><strong> Highest " . $report_subject
    . " </strong></td>
    <td> " . $highest_val . "</td></tr>";
    $result .= "<tr><td colspan = 2><strong> Average " . $report_subject . " </strong></td>
<td> " . round($avg_numerator/$val_denominator, 2) . " </td></tr>";
    if ($is_income){
        $result .= "<tr>
        <td colspan = 2><strong> Below $50,000 Annual Income 
</strong></td><td> " . number_format($below50/$val_denominator * 100) . "%</td></tr>";
        $result .= "<tr>
        <td colspan = 2><strong> Below $25,000 Annual Income 
</strong></td><td> " . number_format($below25/$val_denominator * 100) . "%</td></tr>";
        $result .= "<tr>
        <td colspan = 2><strong> Below $15,000 Annual Income 
</strong></td><td> " . number_format($below15/$val_denominator * 100) . "%</td></tr>";

    }
    return $result;
}
/*
Inputs: CURSOR = result of mysqli_query() 
        VAL_DENOMINATOR is the denominator for the percentages.
              Usually this is $students_denominator, calculated above.  It
              is the number of people linked to the La Casa program (note
              that not all of these people have information in the
              La_Casa_Basics table).
        ED_ACHIEVEMENT is a flag marking whether this call is from an
        educational achievement report.
        COUNTINDEX is the index of the count in the cursor.
        DESCRIPTION_INDEX is the column number of the result (e.g., the race)
              in CURSOR.  It is always 1.
        EDUCATION_INDEX is the column number of the education type in CURSOR.
              It is always 2. 
Outputs: The result is a string that is a set of html table rows (see below).

Call this to provide rows to be inserted into a La Casa table.  For example:

    Race                      | Percent | Count
    Hispanic or Latino        | 25%     | 2
    Black or African-American | 25%     | 2
    Asian or Asian-American   | 13%     | 1

This function returns the rows of information from "Hispanic or Latino" to the final "1."

Reports that display a list include: Race/Ethnicity, Major, College, Hometown
 */
function la_casa_report_list_gen_html($cursor, $val_denominator, $ed_achievement = false, $ed_aspiration = false, $countindex = 0, $description_index = 1, $education_index = 2)
{
    $result = "";
    $reporting_number = 0;
    $null_count = 0;
    $count_distinct_results = 0;
    include "../include/dbconnopen.php";
    $hs_diploma_id_sqlsafe = "SELECT Education_ID FROM Educational_Levels WHERE Education_Level_Name = 'High School Diploma'";
    $hs_diploma_id = mysqli_query($cnnTRP, $hs_diploma_id_sqlsafe);
    $diploma_id = mysqli_fetch_row($hs_disploma_id);
    $hs_diploma = $diploma_id[0];
    $bachelors_id_sqlsafe = "SELECT Education_ID FROM Educational_Levels WHERE Education_Level_Name = 'Bachelors Degree'";
    $bachelors_id = mysqli_query($cnnTRP, $bachelors_id_sqlsafe);
    $bach_id = mysqli_fetch_row($bachelors_id);
    $bachelors = $bach_id[0];
    $masters_id_sqlsafe = "SELECT Education_ID FROM Educational_Levels WHERE Education_Level_Name = 'Masters Degree'";
    $masters_id = mysqli_query($cnnTRP, $masters_id_sqlsafe);
    $mas_id = mysqli_fetch_row($masters_id);
    $masters = $mas_id[0];
    $bachelors_plus = 0;
    $hs_less = 0;
    $masters_plus = 0;

    $race_array = array("0" => "N/A", "1" => "African-American", "2" => "Asian-American", "3" => "Latin@", "4" => "White", "5" => "Other");
    $gender_array = array("f" => "Female", "m" => "Male");
    $yn_array = array(1 => "Yes", 2 => "No");
    $match_array = array(1 => "Above Match", 2 => "Match", 3 => "Below Match");
    while ($val = mysqli_fetch_array($cursor)) {
        $reporting_number += $val[$countindex];
        if ($val[$description_index] != null){
            if ($ed_achievement){
                if ($val[$education_index] < $hs_diploma){
                    $hs_less += $val[$countindex];
                }
                if ($val[$education_index] >= $bachelors){
                    $bachelors_plus += $val[$countindex];
                }
            }
            if ($ed_aspiration){
                if ($val[$education_index] >= $masters){
                    $masters_plus += $val[$countindex];
                }
            }

            $count_distinct_results++;
            $result .= "<tr> <td>";
            if ( array_key_exists('Race', $val)){
                $result .= $race_array[$val[$description_index]];
            }
            elseif ( array_key_exists('Gender', $val)){
                $result .= $gender_array[$val[$description_index]];
            }
            elseif ( array_key_exists('Dependency_Status', $val) || array_key_exists('First_Generation_College_Student', $val)){
                $result .= $yn_array[$val[$description_index]];
            }
            elseif ( array_key_exists('College_Match', $val)){
                $result .= $match_array[$val[$description_index]];
            }
            else{
                $result .= $val[$description_index];
            }
                $result .= "</td>
        <td>" . number_format($val[$countindex]/$val_denominator*100) . "%</td>
        <td>" . $val[$countindex] . "</td>
        </tr>";
        }
        else{
            $null_count += $val[$countindex];
        }
    }
    $result .= "<tr>
<td> Unknown </td>
<td>" . number_format((($val_denominator + $null_count) - $reporting_number)/$val_denominator * 100 ) .  "%</td>
<td> " . (($val_denominator + $null_count) - $reporting_number) . "</td>
</tr>
<tr><td colspan = 2><strong> Unique results </strong></td>
<td>" . $count_distinct_results . "</td>";
    if ($ed_achievement){
        $result .= "<tr><td> Percent who have earned a bachelor's or above </td>
<td> " . number_format($bachelors_plus/$val_denominator * 100) . "% </td></tr>";
        $result .= "<tr><td> Percent who have earned less than a high school diploma </td>
<td> " . number_format($hs_less/$val_denominator * 100) . "% </td></tr>";
    }
    if ($ed_aspiration){
        $result .= "<tr><td> Percent who aspire to a Master's degree or more </td>
<td> " . number_format($masters_plus/$val_denominator * 100) . "% </td></tr>";
    }
    return $result;
}
        
    ?>
        <tr><td>
<table align = "left">
        <form action="<?php echo $_SERVER['PHP_SELF'] . "?id=6"; ?>" method="post" name="termFilter">
<tr><th>Term: 
        <select name = "term_filter">
            <option value = "">-----</option>
            <option > Fall</option>
            <option > Winter</option>
            <option > Spring</option>
            <option > Summer</option>
        </select>
</tr>
<tr>
    </th><th>Year: 
        <select name = "year_filter">
            <option value = "">-----</option>
            <option> 2013</option>
            <option> 2014</option>
            <option> 2015</option>
            <option> 2016</option>
            <option> 2017</option>
        </select>
    </th>
</tr>
<tr>
    <th>
        <input type = "submit" value = "Filter" name="filter_submit">
    </th>
        </form>
</tr>
</table>
<p></p>
<?php
if ( isset($_POST['filter_submit']) ) {
    include "../include/dbconnopen.php";
    $term_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['term_filter']);
    $year_filter_sqlsafe = mysqli_real_escape_string($cnnLSNA, $_POST['year_filter']);
    if ($term_sqlsafe = 'Fall'){
        $move_in_date = $_POST['year_filter'] . '-08-01';
        $move_out_date = $_POST['year_filter'] . '-12-31';
    }
    elseif ($term_sqlsafe = 'Winter'){
        $move_in_date = $_POST['year_filter'] . '-01-01';
        $move_out_date = $_POST['year_filter'] . '-03-31';
    }
    elseif ($term_sqlsafe = 'Spring'){
        $move_in_date = $_POST['year_filter'] . '-04-01';
        $move_out_date = $_POST['year_filter'] . '-06-30';
    }
    elseif ($term_sqlsafe = 'Summer'){
        $move_in_date =  $_POST['year_filter'] . '-07-01';
        $move_out_date =  $_POST['year_filter'] . '-07-31';
    }
    
    $lc_terms_string = " WHERE Term = '$term_sqlsafe' AND School_Year = '" . $_POST['year_filter'] . "'";
    $basics_string = " WHERE Move_In_Date <= $move_in_date AND Move_Out_Date >= $move_out_date ";
    echo "<h3> Results for " . $term_sqlsafe . " " . $_POST['year_filter'] . "</h3>";
}

?>
 
<table class = "inner_table">
        <caption> Race and Ethnicity </caption>
<tr><th>Description</th><th>Percent</th><th>Count</th></tr>
<?php
//get the total number of people at La Casa (unique participants in
//the La Casa Basics table), the number of people of each
//race/ethnicity, and calculate the percentages.

        $lc_race_join_sqlsafe = "SELECT COUNT(*), Race FROM Participants INNER JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID WHERE Participants_Programs.Program_ID = 6 GROUP BY Race;";
        $race_counts = mysqli_query($cnnTRP, $lc_race_join_sqlsafe);
        echo la_casa_report_list_gen_html($race_counts, $students_denominator);
?>
</table>
<p></p>
<table class = "inner_table">
<caption> Household Size </caption>
<tr><th>Household Size</th><th>Percent</th><th>Count</th></tr>
<?php 
        $get_household_sizes_sqlsafe = "SELECT Count(*), Household_Size FROM La_Casa_Basics  $basics_string GROUP BY Household_Size;";
        $household_sizes = mysqli_query($cnnTRP, $get_household_sizes_sqlsafe);
        echo la_casa_report_high_low_gen_html($household_sizes, "Household Size", $students_denominator);
?>
</table>

<p></p>

<table class = "inner_table">
<caption> Household Income </caption>
<tr><th>Income</th><th>Percent</th><th>Count</th></tr>

<?php 
$income_sum_sqlsafe = "SELECT COUNT(*), Parent1_AGI + Parent2_AGI +  Student_AGI AS Sum_AGI FROM La_Casa_Basics $basics_string GROUP BY Sum_AGI;";
$income_counts = mysqli_query($cnnTRP, $income_sum_sqlsafe);
$incomeflag = true;
echo la_casa_report_high_low_gen_html($income_counts, "Household Income", $students_denominator, $incomeflag);
?>
</table>

<table class = "inner_table">
<caption> Major/Program of Study </caption>
<tr><th> Major </th><th>Percent</th><th>Count</th></tr>
<?php 
$get_majors_sqlsafe = "SELECT Count(*), Major FROM LC_Terms $lc_terms_string GROUP BY Major;";
$majors = mysqli_query($cnnTRP, $get_majors_sqlsafe);
echo la_casa_report_list_gen_html($majors, $lc_terms_denominator);
?>
</table>
<p></p>
<table class = "inner_table">
<caption> College </caption>
<tr><th> College Name </th><th>Percent</th><th>Count</th></tr>
<?php
$num_linked_colleges_sqlsafe = "SELECT COUNT(*), College_Name FROM LC_Terms LEFT JOIN Colleges ON Colleges.College_ID = LC_Terms.College_ID $lc_terms_string GROUP BY College_Name;";
$num_colleges = mysqli_query($cnnTRP, $num_linked_colleges_sqlsafe);
echo la_casa_report_list_gen_html($num_colleges, $lc_terms_denominator);
?>
</table>
<p></p>
<table class = "inner_table">
<caption> Total Credit Accrual To Date </caption>
<tr><th> Credits Completed </th><th>Percent</th><th>Count</th></tr>
<?php
$sum_of_credits_sqlsafe = "SELECT Count(*), Credit_Range FROM LC_Terms INNER JOIN (SELECT  Participant_ID, SUM(Credits) AS Credit_Range FROM LC_Terms GROUP BY Participant_ID) Result_Table ON Result_Table.Participant_ID = LC_Terms.Participant_ID $lc_terms_string GROUP BY Credit_Range;";
$sum_credits = mysqli_query($cnnTRP, $sum_of_credits_sqlsafe);
echo la_casa_report_high_low_gen_html($sum_credits, "Credit Accrual", $lc_terms_denominator);
?>
</table>
<table class = "inner_table">
<caption> College GPA </caption>
<tr><th>College GPA</th><th>Percent</th><th>Count</th></tr>
<?php
$college_gpa_sqlsafe = "SELECT Count(*), College_GPA FROM LC_Terms $lc_terms_string GROUP BY College_GPA;";
$college_gpa = mysqli_query($cnnTRP, $college_gpa_sqlsafe);
echo la_casa_report_high_low_gen_html($college_gpa, "College GPA", $lc_terms_denominator);
?>
</table>
<table class = "inner_table">
<caption> ACT Score </caption>
<tr><th>Score</th><th>Percent</th><th>Count</th></tr>
<?php
$act_score_sqlsafe = "SELECT  Count(*), ACT_Score FROM La_Casa_Basics $basics_string GROUP BY ACT_Score;";
$act_score = mysqli_query($cnnTRP, $act_score_sqlsafe);
echo la_casa_report_high_low_gen_html($act_score, "ACT Score", $students_denominator);

?>
</table>
<table class = "inner_table">
<caption> High School GPA </caption>
<tr><th>High School GPA</th><th>Percent</th><th>Count</th></tr>
<?php
$high_school_gpa_sqlsafe = "SELECT Count(*), High_School_GPA FROM La_Casa_Basics $basics_string GROUP BY High_School_GPA;";
$high_school_gpa = mysqli_query($cnnTRP, $high_school_gpa_sqlsafe);
echo la_casa_report_high_low_gen_html($high_school_gpa, "High School GPA", $students_denominator);
?>
</table>
<table class = "inner_table">
<caption> Dependency Status </caption>
<tr><th>Status</th><th>Percent</th><th>Count</th></tr>
<?php
$dependency_status_sqlsafe = "SELECT Count(*), Dependency_Status FROM La_Casa_Basics $basics_string GROUP BY Dependency_Status;";
$dependency_status = mysqli_query($cnnTRP, $dependency_status_sqlsafe);
echo la_casa_report_list_gen_html($dependency_status, $students_denominator);
?>
</table>
<table class = "inner_table">
<caption> Gender </caption>
<tr><th>Gender</th><th>Percent</th><th>Count</th></tr>
<?php
$gender_sqlsafe = "SELECT Count(*), Gender FROM Participants INNER JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID WHERE Program_ID = 6 GROUP BY Gender;";
$gender = mysqli_query($cnnTRP, $gender_sqlsafe);
echo la_casa_report_list_gen_html($gender, $students_denominator);
?>
</table>
<table class = "inner_table">
<caption> Father\'s Highest Level of Education </caption>
<tr><th>Description</th><th>Percent</th><th>Count</th></tr>
<?php
$lc_father_ed_join_sqlsafe = "SELECT COUNT(*), Education_Level_Name, Education_ID FROM Participants INNER JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID LEFT JOIN La_Casa_Basics ON Participants.Participant_ID = La_Casa_Basics.Participant_ID_Students LEFT JOIN Educational_Levels ON La_Casa_Basics.Father_Highest_Level_Education = Education_ID WHERE Participants_Programs.Program_ID = 6 GROUP BY Father_Highest_Level_Education;";
$father_ed_counts = mysqli_query($cnnTRP, $lc_father_ed_join_sqlsafe);
$educational_achievement_flag = true;
echo la_casa_report_list_gen_html($father_ed_counts, $students_denominator, $educational_achievement_flag);
?>
</table>
<table class = "inner_table">
<caption> Mother\'s Highest Level of Education</caption>
<tr><th>Description</th><th>Percent</th><th>Count</th></tr>
<?php
$lc_mother_ed_join_sqlsafe = "SELECT COUNT(*), Education_Level_Name, Education_ID FROM Participants INNER JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID LEFT JOIN La_Casa_Basics ON Participants.Participant_ID = La_Casa_Basics.Participant_ID_Students LEFT JOIN Educational_Levels ON La_Casa_Basics.Mother_Highest_Level_Education = Education_ID WHERE Participants_Programs.Program_ID = 6 GROUP BY Mother_Highest_Level_Education;";
$mother_ed_counts = mysqli_query($cnnTRP, $lc_mother_ed_join_sqlsafe);
$educational_achievement_flag = true;
echo la_casa_report_list_gen_html($mother_ed_counts, $students_denominator, $educational_achievement_flag);
?>
</table>
<table class = "inner_table">
<caption>  Student\'s Aspiration </caption>
<tr><th>Description</th><th>Percent</th><th>Count</th></tr>
<?php
$lc_student_aspiration_join_sqlsafe = "SELECT COUNT(*), Education_Level_Name, Education_ID FROM Participants INNER JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID LEFT JOIN La_Casa_Basics ON Participants.Participant_ID = La_Casa_Basics.Participant_ID_Students LEFT JOIN Educational_Levels ON La_Casa_Basics.Student_Aspiration = Education_ID WHERE Participants_Programs.Program_ID = 6 GROUP BY Student_Aspiration;";
$student_aspiration_counts = mysqli_query($cnnTRP, $lc_student_aspiration_join_sqlsafe);
$education_aspiration_flag = true;
$educational_achivement_flag = false;
echo la_casa_report_list_gen_html($student_aspiration_counts, $students_denominator, $educational_achivement_flag, $education_aspiration_flag);
?>
</table>
<table class = "inner_table">
<caption> First Generation College Student </caption>
<tr><th>Yes/No</th><th>Percent</th><th>Count</th></tr>
<?php
$first_generation_check_sqlsafe = "SELECT COUNT(*), First_Generation_College_Student FROM La_Casa_Basics $basics_string GROUP BY First_Generation_College_Student";
$first_gen = mysqli_query($cnnTRP, $first_generation_check_sqlsafe);
echo la_casa_report_list_gen_html($first_gen, $students_denominator);
?>
</table>
<table class = "inner_table">
<caption> College Match </caption>
<tr><th> College Match  </th><th>Percent</th><th>Count</th></tr>
<?php
$college_match_list_sqlsafe = "SELECT COUNT(*), College_Match FROM LC_Terms $lc_terms_string GROUP BY College_Match";
$college_match = mysqli_query($cnnTRP, $college_match_list_sqlsafe);
echo la_casa_report_list_gen_html($college_match, $lc_terms_denominator);
?>

</table>
<table class = "inner_table">
<caption> Persistence and Graduation </caption>
</table>
<table class = "inner_table">
<caption> Student Hometowns </caption>
<tr><th> Hometown </th><th>Percent</th><th>Count</th></tr>
<?php 
$get_hometowns_sqlsafe = "SELECT COUNT(*), Address_City FROM Participants INNER JOIN Participants_Programs ON Participants.Participant_ID = Participants_Programs.Participant_ID WHERE Program_ID = 6 GROUP BY Address_City";
$hometowns = mysqli_query($cnnTRP, $get_hometowns_sqlsafe);
echo la_casa_report_list_gen_html($hometowns, $students_denominator);
?>
</table>
<table class = "inner_table">
<caption> Student High Schools </caption>
<tr><th> High School </th><th>Percent</th><th>Count</th></tr>
<?php 
$get_high_schools_sqlsafe = "SELECT Count(*), Student_High_School FROM La_Casa_Basics $basics_string GROUP BY Student_High_School;";
$high_schools = mysqli_query($cnnTRP, $get_high_schools_sqlsafe);
echo la_casa_report_list_gen_html($high_schools, $students_denominator);
?>
</table>

</td></tr>

    <?php
}
?>
<!-- end table that holds all elements for La Casa and Early Childhood. -->
</table>
    <?php
    //Middle School to High School
    if ($program['Program_ID'] == 2) {
        ?>
        <table>
            <tr>
                <td class="trp_add_table" width="35%">
                    <br/><br/>
                    <!-- as in early childhood, these are people enrolled in the MS to HS transition.
                    Not sure whether all these students will be entered in the system.
                    -->
                    <h4>Program Enrollment</h4>
                    <ul style="list-style-type:none;">
                        <?php
                        $get_participants_sqlsafe = "SELECT * FROM Participants_Programs INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID WHERE Program_ID='" . $program['Program_ID'] . "' ORDER BY Participants.Last_Name";
                        $participants = mysqli_query($cnnTRP, $get_participants_sqlsafe);
                        while ($participant = mysqli_fetch_array($participants)) {
                            ?>
                            <li><a href="../participants/profile.php?id=<?php echo $participant['Participant_ID']; ?>"><?php echo $participant['First_Name'] . " " . $participant['Last_Name']; ?></a></li>
                            <?php
                        }
                        ?>

                    </ul>
                    <div class="add_participant">

                        <!-- add a new enrollee here (again, this person must already have a profile in the system): -->
                        <a href="javascript:;" onclick="
                                $('#search_to_add_participant').slideToggle();
                           " style="font-size:.8em;" class="no_view">Add a new participant...</a>
                        <div id="search_to_add_participant">
                            <table class="search_table">
                                <tr>
                                    <td class="trp_add_table"><strong>First Name:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="name_search" style="width:100px;"/></td>
                                    <td class="trp_add_table"><strong>Last Name:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="surname_search" style="width:100px;" /></td>
                                </tr>
                                <tr>
                                    <td class="trp_add_table"><strong>DOB:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="dob_search" style="width:70px;" /></td>
                                    <td class="trp_add_table"><strong>Gender:</strong></td>
                                    <td class="trp_add_table"><select id="gender_search">
                                            <option value="">---------</option>
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="trp_add_table" colspan="4" style="text-align:center;"><input type="button" value="Search" onclick="
                                            $.post(
                                                    '../ajax/search_users.php',
                                                    {
                                                        first: document.getElementById('name_search').value,
                                                        last: document.getElementById('surname_search').value,
                                                        dob: document.getElementById('dob_search').value,
                                                        gender: document.getElementById('gender_search').value,
                                                        program: <?php echo $program['Program_ID']; ?>,
                                                        program_add: 1
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                document.getElementById('search_results').innerHTML = response;
                                            }
                                            )"/></td>
                                </tr>
                            </table>
                            <div id="search_results"></div>
                        </div>
                    </div>





                </td>
                <td class="trp_add_table" colspan="2">

                    <!-- shows GPA and test scores: -->
                    <h4>Academic Records</h4>
                    <?php
                    $get_scores_sqlsafe = "SELECT AVG(Explore_Score_Pre) AS pre, AVG(Explore_Score_Mid) AS mid, AVG(Explore_Score_Post) AS post,
                                    AVG(Explore_Score_Fall) AS fall, AVG(Reading_ISAT) as reading, AVG(Math_ISAT) as math, School, School_Year FROM Explore_Scores
                                    WHERE Program_ID='" . mysqli_real_escape_string($cnnTRP, $_GET['id']) . "' GROUP BY School, School_Year";
                    // echo $get_scores_sqlsafe;
                    $scores = mysqli_query($cnnTRP, $get_scores_sqlsafe);
                    ?>
                    <table  class="gpa_isat_table">
                        <tr style="text-align:center;"><td class="trp_add_table"></td><td class="trp_add_table" colspan="4"><strong>Explore Scores</strong></td><td class="trp_add_table" colspan="2"><strong>ISAT Scores</strong></td></tr>
                        <tr class="divider">
                            <td class="trp_add_table" width="15%"><strong>Year</strong></td>
                            <td class="trp_add_table"><strong>Pre-program average</strong></td>
                            <td class="trp_add_table"><strong>Mid-program average</strong></td>
                            <td class="trp_add_table"><strong>Post-program average</strong></td>
                            <td class="trp_add_table"><strong>9th grade average</strong></td>
                            <td class="trp_add_table"><strong>Reading</strong></td>
                            <td class="trp_add_table"><strong>Math</strong></td>
                            <td class="trp_add_table"><strong>Quarter</strong></td><td class="trp_add_table"><strong>Average GPA</strong></td>
                        </tr>
                        <?php
                        $current_school = 0;
                        while ($score = mysqli_fetch_array($scores)) {
                            if ($score['School'] != $current_school) {
                                $current_school = $score['School'];
                                $get_school_name_sqlsafe = "SELECT School_Name FROM Schools WHERE School_ID=$current_school";
                                $school = mysqli_query($cnnTRP, $get_school_name_sqlsafe);
                                $school_name = mysqli_fetch_row($school);
                                ?>
                                <tr><th colspan="7"><?php echo $school_name[0]; ?></th></tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td class="trp_add_table"><?php $years = str_split($score['School_Year'], 2);
                            echo '20' . $years[0] . '-20' . $years[1];
                            ?></td>
                                <td class="trp_add_table"><?php echo number_format($score['pre'], 2); ?></td>
                                <td class="trp_add_table"><?php echo number_format($score['mid'], 2); ?></td>
                                <td class="trp_add_table"><?php echo number_format($score['post'], 2); ?></td>
                                <td class="trp_add_table"><?php echo number_format($score['fall'], 2); ?></td>
                                <td class="trp_add_table"><?php echo number_format($score['reading'], 2); ?></td>
                                <td class="trp_add_table"><?php echo number_format($score['math'], 2); ?></td>

                                <?php
                                $format_school_year = str_split($score['School_Year'], 2);
                                $format_year = '20' . $format_school_year[0] . '-' . $format_school_year[1];
                                $get_academic_info_by_program_sqlsafe = "SELECT AVG(GPA),  Quarter, School_Year, School
                                    FROM Academic_Info WHERE Program_ID='" . $program['Program_ID'] . "' AND School='" . $score['School'] . "'
                                        AND School_Year='" . $format_year . "' GROUP BY Quarter";
                                //  echo $get_academic_info_by_program_sqlsafe;
                                $academic_program = mysqli_query($cnnTRP, $get_academic_info_by_program_sqlsafe);

                                $current_school = 0;
                                ?><td class="trp_add_table"><?php
                                    while ($acade = mysqli_fetch_array($academic_program)) {
                                        echo $acade['Quarter'];
                                        ?><br>
            <?php }
        ?></td><?php
        $academic_program = mysqli_query($cnnTRP, $get_academic_info_by_program_sqlsafe);
        ?>
                                <!-- quarters will stay with the year, which is why this while has to be nested.
                                --> 
                                <td class="trp_add_table"><?php
                                    while ($acade = mysqli_fetch_array($academic_program)) {
                                        echo number_format($acade['AVG(GPA)'], 2);
                                        ?>
                                        <!--<td class="trp_add_table"><?php
                                        $count_people_with_academic_sqlsafe = "SELECT COUNT(*) FROM Academic_Info WHERE Program_ID='" . $program['Program_ID']
                                                . "' AND Quarter=" . $acade['Quarter'];
                                        $count_people = mysqli_query($cnnTRP, $count_people_with_academic_sqlsafe);
                                        $peoplenum = mysqli_fetch_row($count_people);
                                        //echo $peoplenum[0];
                                        ?></td>-->
            <?php }
        ?></td></tr>
        <?php }
    ?>
                    </table>


                    <br/><br/>

                </td>
            </tr>
            <tr><td class="trp_add_table"></td>
                <td class="trp_add_table" style="padding:15px;">

                    <!-- show discipline records for this program by school and year. -->
                    <h4>Discipline Records</h4>
                    <?php
                    $get_academic_info_by_program_sqlsafe = "SELECT AVG(School_Tardies) as tardy,
                            AVG(School_Absences_Excused) as excused, 
                            AVG(School_Absences_Unexcused) as skipped, 
                            Quarter, School_Year, School_ID
                                    FROM MS_to_HS_Over_Time WHERE Program_ID='" . $program['Program_ID'] . "' GROUP BY School_ID, School_Year, Quarter";
                    // echo $get_academic_info_by_program_sqlsafe;
                    $academic_program = mysqli_query($cnnTRP, $get_academic_info_by_program_sqlsafe);
                    ?><table class="gpa_isat_table">
                        <tr class="divider"><td class="trp_add_table"><strong>Quarter/Year</strong></td><td class="trp_add_table"><strong>Average Tardies</strong></td><td class="trp_add_table"><strong>Average Excused Absences</strong></td><td class="trp_add_table"><strong>Average Unexcused Absences</strong></td></tr>

                        <?php
                        $current_school = 0;
                        while ($acade = mysqli_fetch_array($academic_program)) {
                            if ($acade['School_ID'] != $current_school) {
                                $current_school = $acade['School_ID'];
                                $get_school_name_sqlsafe = "SELECT School_Name FROM Schools WHERE School_ID=$current_school";
                                $school = mysqli_query($cnnTRP, $get_school_name_sqlsafe);
                                $school_name = mysqli_fetch_row($school);
                                ?>
                                <tr><th colspan="2"><?php echo $school_name[0]; ?></th></tr>
                                <?php
                            }
                            ?>
                            <tr><td class="trp_add_table"><?php echo $acade['Quarter'] . '/' . $acade['School_Year']; ?></td>
                                <td class="trp_add_table"><?php echo number_format($acade['tardies'], 2); ?></td>
                                <td class="trp_add_table"><?php echo number_format($acade['excused'], 2); ?></td>
                                <td class="trp_add_table"><?php echo number_format($acade['skipped'], 2); ?></td>
                            </tr>
        <?php
    }
    ?></table><br/><br/>
                </td>
            </tr>
            <tr><td class="trp_add_table" colspan="3">

                    <!-- upload space for program notes: -->
                    <h4>Upload Notes</h4>
                    <div style="margin-left:auto;margin-right:auto;width:50%;"><span class="helptext">Uploaded information will be saved in the system as a supporting document for this program.
                        </span><br>


                        <?php
                        $get_uploads_sqlsafe = "SELECT Upload_Id, File_Name FROM Programs_Uploads WHERE Program_ID='" . mysqli_real_escape_string($cnnTRP, $_GET['id']) . "'";
                        $result = mysqli_query($cnnTRP, $get_uploads_sqlsafe);
                        if (mysqli_num_rows($result) == 0) {
                            echo "No notes have been uploaded <br>";
                        } else {
                            while (list($id, $name) = mysqli_fetch_array($result)) {
                                ?>

                                <a href="/trp/ajax/download.php?id=<?php echo $id; ?>"><?php echo $name; ?></a> <br>
            <?php
        }
    }
    ?>


                        <form id="file_upload_form" class="no_view" action="/trp/ajax/upload_file.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="file" id="file" /> 
                            <input type="hidden" name="event_id" value="<?php echo $_GET['id']; ?>">
                            <br />
                            <input type="submit" name="submit" value="Upload" />
                            <iframe id="upload_target" name="upload_target" src="" style="width:0;height:0;border:0px solid #fff;"></iframe>
                        </form></div>


                    <!--- they talked about wanting a blog-like space for teachers to share
                    thoughts on how the transition program was going.  This is the test version of
                    that.  It will probably have to change once (if) we get some feedback.
                    
                    this saves the author as the person who is currently logged in and 
                    allows the user to choose the school to associate with the note.
                    -->
                    <h4>Hand-entered Notes</h4>
                    <table class="inner_table">
                        <tr><th>Date</th><th>Author</th><th>School</th><th>Note</th></tr>
                        <!--Get existing notes-->
                        <?php
                        $get_notes_sqlsafe = "SELECT MONTH(Date_Entered), DAY(Date_Entered), YEAR(Date_Entered), Author, Note_Text, School_Name FROM Blog_Notes
        INNER JOIN Schools ON School=School_ID
        WHERE Program_Id='" . mysqli_real_escape_string($cnnTRP, $_GET['id']) . "'  ORDER BY School_Name";
                        $notes = mysqli_query($cnnTRP, $get_notes_sqlsafe);
                        while ($note = mysqli_fetch_row($notes)) {
                            ?>
                            <tr><td class="trp_add_table"><?php echo $note[0] . '/' . $note[1] . '/' . $note[2]; ?></td>
                                <td class="trp_add_table"><?php echo $note[3]; ?></td>
                                <td class="trp_add_table"><?php echo $note[5]; ?></td>
                                <td class="trp_add_table"><?php echo $note[4]; ?></td>
                            </tr>
        <?php
    }
    ?>
                        <!--Add new note-->
                        <tr><td class="trp_add_table" colspan="2">New note:<br>
                                <span class="helptext">Note will save automatically once you click away from the text entry box.  <br>
                                    You must choose a school before entering the note for the school to save correctly.</span>
                            </td>
                            <td class="trp_add_table"><select id="school_new_note">
                                    <option value="">-----</option>
                                    <?php
                                    $select_schools_sqlsafe = "SELECT * FROM Schools ORDER BY School_Name";
                                    $schools = mysqli_query($cnnTRP, $select_schools_sqlsafe);
                                    while ($school = mysqli_fetch_row($schools)) {
                                        ?>
                                        <option value="<?php echo $school[0]; ?>"><?php echo $school[1]; ?></option>
                                    <?php
                                }
                                ?>
                                </select></td>
                            <td class="trp_add_table"><textarea onblur="
                                    var school = document.getElementById('school_new_note').value;
                                    //alert(school);
                                    if (school === '') {
                                        school = 6;
                                    }
                                    $.post(
                                            '../ajax/new_date.php',
                                            {
                                                action: 'note_text',
                                                note: this.value,
                                                program: '<?php echo $_GET['id']; ?>',
                                                school: school
                                            },
                                    function(response) {
                                        // document.write(response);
                                        window.location = 'profile.php?id=<?php echo $_GET['id']; ?>';
                                    })"><?php echo $program['Notes'] ?></textarea></td></tr>
                    </table>

                </td></tr>
        </table>

    <?php
}
//Gads Hill New Horizons
else if ($program['Program_ID'] == 3) {
    /* see the note.  Most of this program is empty. */
    ?><h3>Note: this program is in progress, waiting for the Gads Hill ETO implementation.</h3><br><hr><br>
        <table width="100%">
            <tr>
                <td class="trp_add_table">
                    <!-- list of people enrolled in this program: -->
                    <h4>Program Enrollment</h4>
                    <div class="add_participant">
                        <a href="javascript:;" onclick="
                                $('#search_to_add_participant').slideToggle();
                           " style="font-size:.8em;" class="no_view">Add a new participant...</a>
                        <div id="search_to_add_participant">
                            <table class="search_table">
                                <tr>
                                    <td class="trp_add_table"><strong>First Name:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="name_search" style="width:100px;"/></td>
                                    <td class="trp_add_table"><strong>Last Name:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="surname_search" style="width:100px;" /></td>
                                </tr>
                                <tr>
                                    <td class="trp_add_table"><strong>DOB:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="dob_search" style="width:70px;" /></td>
                                    <td class="trp_add_table"><strong>Gender:</strong></td>
                                    <td class="trp_add_table"><select id="gender_search">
                                            <option value="">---------</option>
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="trp_add_table" colspan="4" style="text-align:center;"><input type="button" value="Search" onclick="
                                            $.post(
                                                    '../ajax/search_users.php',
                                                    {
                                                        first: document.getElementById('name_search').value,
                                                        last: document.getElementById('surname_search').value,
                                                        dob: document.getElementById('dob_search').value,
                                                        gender: document.getElementById('gender_search').value,
                                                        program: <?php echo $program['Program_ID']; ?>,
                                                        program_add: 1
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                document.getElementById('search_results').innerHTML = response;
                                            }
                                            )"/></td>
                                </tr>
                            </table>
                            <div id="search_results"></div>
                        </div>
                    </div>
                    <ul style="list-style-type:none;">
                        <?php
                        $get_participants_sqlsafe = "SELECT * FROM Participants_Programs INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID WHERE Program_ID='" . $program['Program_ID'] . "' ORDER BY Participants.Last_Name";
                        $participants = mysqli_query($cnnTRP, $get_participants_sqlsafe);
                        while ($participant = mysqli_fetch_array($participants)) {
                            ?>
                            <li><a href="../participants/profile.php?id=<?php echo $participant['Participant_ID']; ?>"><?php echo $participant['First_Name'] . " " . $participant['Last_Name']; ?></a></li>
        <?php
    }
    ?>

                    </ul><br/>
                    <h4>Attendance</h4>
                    <br/><br/>
                    <h4>Demographic Information</h4>
                    <br/><br/>

                </td>
                <td class="trp_add_table">
                    <h4>Academic Records</h4>
                    <br/><br/>
                    <h4>Parent Surveys</h4>
                    <br/><br/>
                    <h4>Development Assets Profiles</h4>
                    <br/><br/>
                </td>
            </tr>
        </table>
    <?php
}
//Elev8
else if ($program['Program_ID'] == 4) {
    ?>
        <!-- Elev8 elements.  Individual-level data for Elev8 is stored in Cityspan, so this page displays the aggregate
        results by month. -->

        <h4>After School Enrollment</h4>
        <table class="inner_table" style="width:50%;align:left;">
            <tr><th>Month</th><th>Year</th><th>Enrollment</th></tr>
    <?php
    $enrollment_query_sqlsafe = "SELECT Month, Year, Value, Elev8_ID FROM Elev8_Data WHERE Element=1";
    $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
    while ($enroll = mysqli_fetch_row($enrollment)) {
        ?>
                <tr><td class="trp_add_table"><?php echo $enroll[0]; ?></td><td class="trp_add_table"><?php echo $enroll[1]; ?></td>
                    <td class="trp_add_table"><?php echo $enroll[2]; ?></td>
                    <td class="trp_add_table"><input type="button" value="Delete"
                               onclick="
                                       $.post(
                                               '../ajax/elev8_save.php',
                                               {
                                                   action: 'delete',
                                                   id: '<?php echo $enroll[3]; ?>'
                                               },
                                       function(response) {
                                           //document.write(response);
                                           window.location = 'profile.php?id=4';
                                       }
                                       )
                               "></td>
                </tr>
        <?php
    }
    ?>
            <tr>
                <td class="trp_add_table"><select id="month_elev8_select">
                        <option value="">-----</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select></td>
                <td class="trp_add_table"><select id="year_elev8_select">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td class="trp_add_table"><input type="text" id="enrollment_elev8_new" style="width:100px;">
                    <input type="button" value="Save"  class="no_view" onclick="
                            $.post(
                                    '../ajax/elev8_save.php',
                                    {
                                        month: document.getElementById('month_elev8_select').value,
                                        year: document.getElementById('year_elev8_select').value,
                                        value: document.getElementById('enrollment_elev8_new').value,
                                        element: 1
                                    },
                            function(response) {
                                window.location = 'profile.php?id=4';
                            }
                            )"></td>
            </tr>
        </table>
        <br/>
        <h4>After School Attendance</h4>

        <table class="inner_table" style="width:50%;align:left;">
            <tr><th>Month</th><th>Year</th><th>Enrollment</th></tr>
                                                            <?php
                                                            $enrollment_query_sqlsafe = "SELECT Month, Year, Value, Elev8_ID FROM Elev8_Data WHERE Element=2";
                                                            $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
                                                            while ($enroll = mysqli_fetch_row($enrollment)) {
                                                                ?>
                <tr><td class="trp_add_table"><?php echo $enroll[0]; ?></td><td class="trp_add_table"><?php echo $enroll[1]; ?></td>
                    <td class="trp_add_table"><?php echo $enroll[2]; ?></td><td class="trp_add_table"><input type="button" value="Delete"
                                                                onclick="
                                                                        $.post(
                                                                                '../ajax/elev8_save.php',
                                                                                {
                                                                                    action: 'delete',
                                                                                    id: '<?php echo $enroll[3]; ?>'
                                                                                },
                                                                        function(response) {
                                                                            //document.write(response);
                                                                            window.location = 'profile.php?id=4';
                                                                        }
                                                                        )
                                                                "></td></tr>
        <?php
    }
    ?>
            <tr>
                <td class="trp_add_table"><select id="month_elev8_select_2">
                        <option value="">-----</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select></td>
                <td class="trp_add_table"><select id="year_elev8_select_2">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td class="trp_add_table"><input type="text" id="enrollment_elev8_new_2" style="width:100px;">
                    <input type="button" value="Save"  class="no_view" onclick="
                            $.post(
                                    '../ajax/elev8_save.php',
                                    {
                                        month: document.getElementById('month_elev8_select_2').value,
                                        year: document.getElementById('year_elev8_select_2').value,
                                        value: document.getElementById('enrollment_elev8_new_2').value,
                                        element: 2
                                    },
                            function(response) {
                                // document.write(response);
                                window.location = 'profile.php?id=4';
                            }
                            )"></td>
            </tr>
        </table>

        <br/><br/>
        <h4>Adult Programming Enrollment</h4>
        <table class="inner_table" style="width:50%;align:left;">
            <tr><th>Month</th><th>Year</th><th>Enrollment</th></tr>
                                                            <?php
                                                            $enrollment_query_sqlsafe = "SELECT Month, Year, Value, Elev8_ID FROM Elev8_Data WHERE Element=3";
                                                            $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
                                                            while ($enroll = mysqli_fetch_row($enrollment)) {
                                                                ?>
                <tr><td class="trp_add_table"><?php echo $enroll[0]; ?></td><td class="trp_add_table"><?php echo $enroll[1]; ?></td>
                    <td class="trp_add_table"><?php echo $enroll[2]; ?></td><td class="trp_add_table"><input type="button" value="Delete"
                                                                onclick="
                                                                        $.post(
                                                                                '../ajax/elev8_save.php',
                                                                                {
                                                                                    action: 'delete',
                                                                                    id: '<?php echo $enroll[3]; ?>'
                                                                                },
                                                                        function(response) {
                                                                            //document.write(response);
                                                                            window.location = 'profile.php?id=4';
                                                                        }
                                                                        )
                                                                "></td></tr>
        <?php
    }
    ?>
            <tr>
                <td class="trp_add_table"><select id="month_elev8_select_3">
                        <option value="">-----</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select></td>
                <td class="trp_add_table"><select id="year_elev8_select_3">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td class="trp_add_table"><input type="text" id="enrollment_elev8_new_3" style="width:100px;">
                    <input type="button" value="Save"  class="no_view" onclick="
                            $.post(
                                    '../ajax/elev8_save.php',
                                    {
                                        month: document.getElementById('month_elev8_select_3').value,
                                        year: document.getElementById('year_elev8_select_3').value,
                                        value: document.getElementById('enrollment_elev8_new_3').value,
                                        element: 3
                                    },
                            function(response) {
                                // document.write(response);
                                window.location = 'profile.php?id=4';
                            }
                            )"></td>
            </tr>
        </table>
        <br/><br/>
        <h4>Adult Programming Attendance</h4>
        <table class="inner_table" style="width:50%;align:left;">
            <tr><th>Month</th><th>Year</th><th>Enrollment</th></tr>
                                                            <?php
                                                            $enrollment_query_sqlsafe = "SELECT Month, Year, Value, Elev8_ID FROM Elev8_Data WHERE Element=4";
                                                            $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
                                                            while ($enroll = mysqli_fetch_row($enrollment)) {
                                                                ?>
                <tr><td class="trp_add_table"><?php echo $enroll[0]; ?></td><td class="trp_add_table"><?php echo $enroll[1]; ?></td>
                    <td class="trp_add_table"><?php echo $enroll[2]; ?></td><td class="trp_add_table"><input type="button" value="Delete"
                                                                onclick="
                                                                        $.post(
                                                                                '../ajax/elev8_save.php',
                                                                                {
                                                                                    action: 'delete',
                                                                                    id: '<?php echo $enroll[3]; ?>'
                                                                                },
                                                                        function(response) {
                                                                            //document.write(response);
                                                                            window.location = 'profile.php?id=4';
                                                                        }
                                                                        )
                                                                "></td></tr>
        <?php
    }
    ?>
            <tr>
                <td class="trp_add_table"><select id="month_elev8_select_4">
                        <option value="">-----</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select></td>
                <td class="trp_add_table"><select id="year_elev8_select_4">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td class="trp_add_table"><input type="text" id="enrollment_elev8_new_4" style="width:100px;">
                    <input type="button" value="Save"  class="no_view" onclick="
                            $.post(
                                    '../ajax/elev8_save.php',
                                    {
                                        month: document.getElementById('month_elev8_select_4').value,
                                        year: document.getElementById('year_elev8_select_4').value,
                                        value: document.getElementById('enrollment_elev8_new_4').value,
                                        element: 4
                                    },
                            function(response) {
                                // document.write(response);
                                window.location = 'profile.php?id=4';
                            }
                            )"></td>
            </tr>
        </table>

        <br/><br/>
        <h4>Total Enrollment</h4>
        <table class="inner_table" style="width:50%;align:left;">
            <tr><th>Month</th><th>Year</th><th>Enrollment</th></tr>
                                                            <?php
                                                            $enrollment_query_sqlsafe = "SELECT Month, Year, Value, Elev8_ID FROM Elev8_Data WHERE Element=5";
                                                            $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
                                                            while ($enroll = mysqli_fetch_row($enrollment)) {
                                                                ?>
                <tr><td class="trp_add_table"><?php echo $enroll[0]; ?></td><td class="trp_add_table"><?php echo $enroll[1]; ?></td>
                    <td class="trp_add_table"><?php echo $enroll[2]; ?></td><td class="trp_add_table"><input type="button" value="Delete"
                                                                onclick="
                                                                        $.post(
                                                                                '../ajax/elev8_save.php',
                                                                                {
                                                                                    action: 'delete',
                                                                                    id: '<?php echo $enroll[3]; ?>'
                                                                                },
                                                                        function(response) {
                                                                            //document.write(response);
                                                                            window.location = 'profile.php?id=4';
                                                                        }
                                                                        )
                                                                "></td></tr>
        <?php
    }
    ?>
            <tr>
                <td class="trp_add_table"><select id="month_elev8_select_5">
                        <option value="">-----</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select></td>
                <td class="trp_add_table"><select id="year_elev8_select_5">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td class="trp_add_table"><input type="text" id="enrollment_elev8_new_5" style="width:100px;">
                    <input type="button" value="Save"  class="no_view" onclick="
                            $.post(
                                    '../ajax/elev8_save.php',
                                    {
                                        month: document.getElementById('month_elev8_select_5').value,
                                        year: document.getElementById('year_elev8_select_5').value,
                                        value: document.getElementById('enrollment_elev8_new_5').value,
                                        element: 5
                                    },
                            function(response) {
                                // document.write(response);
                                window.location = 'profile.php?id=4';
                            }
                            )"></td>
            </tr>
        </table>
        <br/><br/>
        <h4>Total Attendance</h4>
        <table class="inner_table" style="width:50%;align:left;">
            <tr><th>Month</th><th>Year</th><th>Enrollment</th></tr>
                                                            <?php
                                                            $enrollment_query_sqlsafe = "SELECT Month, Year, Value, Elev8_ID FROM Elev8_Data WHERE Element=6";
                                                            $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
                                                            while ($enroll = mysqli_fetch_row($enrollment)) {
                                                                ?>
                <tr><td class="trp_add_table"><?php echo $enroll[0]; ?></td><td class="trp_add_table"><?php echo $enroll[1]; ?></td>
                    <td class="trp_add_table"><?php echo $enroll[2]; ?></td><td class="trp_add_table"><input type="button" value="Delete"
                                                                onclick="
                                                                        $.post(
                                                                                '../ajax/elev8_save.php',
                                                                                {
                                                                                    action: 'delete',
                                                                                    id: '<?php echo $enroll[3]; ?>'
                                                                                },
                                                                        function(response) {
                                                                            //document.write(response);
                                                                            window.location = 'profile.php?id=4';
                                                                        }
                                                                        )
                                                                "></td></tr>
        <?php
    }
    ?>
            <tr>
                <td class="trp_add_table"><select id="month_elev8_select_6">
                        <option value="">-----</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select></td>
                <td class="trp_add_table"><select id="year_elev8_select_6">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td class="trp_add_table"><input type="text" id="enrollment_elev8_new_6" style="width:100px;">
                    <input type="button" value="Save"  class="no_view" onclick="
                            $.post(
                                    '../ajax/elev8_save.php',
                                    {
                                        month: document.getElementById('month_elev8_select_6').value,
                                        year: document.getElementById('year_elev8_select_6').value,
                                        value: document.getElementById('enrollment_elev8_new_6').value,
                                        element: 6
                                    },
                            function(response) {
                                // document.write(response);
                                window.location = 'profile.php?id=4';
                            }
                            )"></td>
            </tr>
        </table>
        <br/><br/>

        <h4>Physical/Immunization Compliance</h4>
        <table class="inner_table" style="width:50%;align:left;">
            <tr><th>Month</th><th>Year</th><th>Enrollment</th></tr>
                                                            <?php
                                                            $enrollment_query_sqlsafe = "SELECT Month, Year, Value, Elev8_ID FROM Elev8_Data WHERE Element=7";
                                                            $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
                                                            while ($enroll = mysqli_fetch_row($enrollment)) {
                                                                ?>
                <tr><td class="trp_add_table"><?php echo $enroll[0]; ?></td><td class="trp_add_table"><?php echo $enroll[1]; ?></td>
                    <td class="trp_add_table"><?php echo $enroll[2]; ?></td><td class="trp_add_table"><input type="button" value="Delete"
                                                                onclick="
                                                                        $.post(
                                                                                '../ajax/elev8_save.php',
                                                                                {
                                                                                    action: 'delete',
                                                                                    id: '<?php echo $enroll[3]; ?>'
                                                                                },
                                                                        function(response) {
                                                                            //document.write(response);
                                                                            window.location = 'profile.php?id=4';
                                                                        }
                                                                        )
                                                                "></td></tr>
        <?php
    }
    ?>
            <tr>
                <td class="trp_add_table"><select id="month_elev8_select_7">
                        <option value="">-----</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select></td>
                <td class="trp_add_table"><select id="year_elev8_select_7">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td class="trp_add_table"><input type="text" id="enrollment_elev8_new_7" style="width:100px;">
                    <input type="button" value="Save"  class="no_view" onclick="
                            $.post(
                                    '../ajax/elev8_save.php',
                                    {
                                        month: document.getElementById('month_elev8_select_7').value,
                                        year: document.getElementById('year_elev8_select_7').value,
                                        value: document.getElementById('enrollment_elev8_new_7').value,
                                        element: 7
                                    },
                            function(response) {
                                // document.write(response);
                                window.location = 'profile.php?id=4';
                            }
                            )"></td>
            </tr>
        </table>

        <br/><br/>
        <h4>Health Center Visits</h4>

        <table class="inner_table" style="width:50%;align:left;">
            <tr><th>Month</th><th>Year</th><th>Total Visits</th></tr>
                                                            <?php
                                                            $enrollment_query_sqlsafe = "SELECT Month, Year, Value, Elev8_ID FROM Elev8_Data WHERE Element=8";
                                                            $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
                                                            while ($enroll = mysqli_fetch_row($enrollment)) {
                                                                ?>
                <tr><td class="trp_add_table"><?php echo $enroll[0]; ?></td><td class="trp_add_table"><?php echo $enroll[1]; ?></td>
                    <td class="trp_add_table"><?php echo $enroll[2]; ?></td><td class="trp_add_table"><input type="button" value="Delete"
                                                                onclick="
                                                                        $.post(
                                                                                '../ajax/elev8_save.php',
                                                                                {
                                                                                    action: 'delete',
                                                                                    id: '<?php echo $enroll[3]; ?>'
                                                                                },
                                                                        function(response) {
                                                                            //document.write(response);
                                                                            window.location = 'profile.php?id=4';
                                                                        }
                                                                        )
                                                                "></td></tr>
        <?php
    }
    ?>
            <tr>
                <td class="trp_add_table"><select id="month_elev8_select_8">
                        <option value="">-----</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select></td>
                <td class="trp_add_table"><select id="year_elev8_select_8">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td class="trp_add_table"><input type="text" id="enrollment_elev8_new_8" style="width:100px;">
                    <input type="button" value="Save"  class="no_view" onclick="
                            $.post(
                                    '../ajax/elev8_save.php',
                                    {
                                        month: document.getElementById('month_elev8_select_8').value,
                                        year: document.getElementById('year_elev8_select_8').value,
                                        value: document.getElementById('enrollment_elev8_new_8').value,
                                        element: 8
                                    },
                            function(response) {
                                // document.write(response);
                                window.location = 'profile.php?id=4';
                            }
                            )"></td>
            </tr>
        </table>

    <?php
}
//NMMA Artist in Residency (Mexican Museum of Art)
else if ($program['Program_ID'] == 5) {
    ?>
        <table width="100%">
            <tr>
                <td class="trp_add_table" width="35%">
                    <!-- list of people in this program.  Search for another person here.  Note that the new
                    participant must already be entered in the system. -->
                    <h4>Program Enrollment</h4>
                    <div class="add_participant">
                        <a href="javascript:;" onclick="
                                $('#search_to_add_participant').slideToggle();
                           " style="font-size:.8em;" class="no_view">Add a participant...</a>
                        <div id="search_to_add_participant">
                            <table class="search_table">
                                <tr>
                                    <td class="trp_add_table"><strong>First Name:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="name_search" style="width:100px;"/></td>
                                    <td class="trp_add_table"><strong>Last Name:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="surname_search" style="width:100px;" /></td>
                                </tr>
                                <tr>
                                    <td class="trp_add_table"><strong>DOB:</strong></td>
                                    <td class="trp_add_table"><input type="text" id="dob_search" style="width:70px;" /></td>
                                    <td class="trp_add_table"><strong>Gender:</strong></td>
                                    <td class="trp_add_table"><select id="gender_search">
                                            <option value="">---------</option>
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="trp_add_table" colspan="4" style="text-align:center;"><input type="button" value="Search" onclick="
                                            $.post(
                                                    '../ajax/search_users.php',
                                                    {
                                                        first: document.getElementById('name_search').value,
                                                        last: document.getElementById('surname_search').value,
                                                        dob: document.getElementById('dob_search').value,
                                                        gender: document.getElementById('gender_search').value,
                                                        program: <?php echo $program['Program_ID']; ?>,
                                                        program_add: 1
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                document.getElementById('search_results').innerHTML = response;
                                            }
                                            )"/></td>
                                </tr>
                            </table>
                            <div id="search_results"></div>
                        </div>
                    </div>
                    <ul style="list-style-type:none;">
                        <?php
                        $get_participants_sqlsafe = "SELECT * FROM Participants_Programs INNER JOIN Participants ON Participants_Programs.Participant_ID=Participants.Participant_ID
                                            WHERE Program_ID='" . $program['Program_ID'] . "' ORDER BY Participants.Last_Name";
                        $participants = mysqli_query($cnnTRP, $get_participants_sqlsafe);
                        while ($participant = mysqli_fetch_array($participants)) {
                            ?>
                            <li><a href="../participants/profile.php?id=<?php echo $participant['Participant_ID']; ?>"><?php echo $participant['First_Name'] . " " . $participant['Last_Name']; ?></a></li>
                            <?php
                        }
                        ?>

                    </ul><br/>

                    <!-- attendance dates for those people enrolled -->
                    <h4>Attendance</h4>
                    <table class="inner_table">
                                    <?php
                                    //get dates
                                    $date_query_sqlsafe = "SELECT Date_ID, Date FROM Program_Dates WHERE Program_Id='" . mysqli_real_escape_string($cnnTRP, $_GET['id']) . "'";
                                    $program_dates = mysqli_query($cnnTRP, $date_query_sqlsafe);
                                    while ($date = mysqli_fetch_row($program_dates)) {
                                        $format_date = explode('-', $date[1]);
                                        $date_formatted = $format_date[1] . '/' . $format_date[2] . '/' . $format_date[0];
                                        ?>
                            <tr><td class="trp_add_table"><?php echo $date_formatted; ?></td><td class="trp_add_table"><a class="helptext" href="javascript:;" onclick="$('#today_attendees_<?php echo $date[0] ?>').toggle();">Show/hide attendees</a>
                                    <div id="today_attendees_<?php echo $date[0] ?>" class="attendee_list"> <?php
                                //get attendees
                                $attendance_query_sqlsafe = "SELECT First_Name, Last_Name FROM Program_Attendance INNER JOIN Participants
                                ON Participants.Participant_Id=Program_Attendance.Participant_ID WHERE Date_ID=$date[0] ORDER BY Last_Name";
                                //echo $attendance_query;
                                $attendance = mysqli_query($cnnTRP, $attendance_query_sqlsafe);
                                while ($attendee = mysqli_fetch_row($attendance)) {
                                    echo $attendee[0] . " " . $attendee[1] . "<br>";
                                }
                                        ?>

                                        <!--- again, for someone to be an attendee s/he must already be enrolled in the program. -->
                                        <span class="helptext">Add attendee: </span><?php $get_members_sqlsafe = "SELECT Participants_Programs.Participant_Id, First_Name, Last_Name FROM Participants_Programs
                                    INNER JOIN Participants ON Participants.Participant_Id=Participants_Programs.Participant_Id WHERE Program_ID='" . mysqli_real_escape_string($cnnTRP, $_GET['id']) . "'";
                                //echo $get_members_sqlsafe;
                                        ?><select id="new_attendee_<?php echo $date[0] ?>" class="no_view" onchange="
                                            var attendee = this.value;
                                            $.post(
                                                    '../ajax/new_date.php',
                                                    {
                                                        action: 'attendance',
                                                        date: '<?php echo $date[0]; ?>',
                                                        person: attendee
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                window.location = 'profile.php?id=<?php echo $_GET['id']; ?>';
                                            }
                                            )">
                                            <option value="">-----</option>
                            <?php
                            $members = mysqli_query($cnnTRP, $get_members_sqlsafe);
                            while ($member = mysqli_fetch_row($members)) {
                                ?>
                                                <option value="<?php echo $member[0] ?>"><?php echo $member[1] . " " . $member[2]; ?></option>
                                        <?php
                                    }
                                    ?>
                                        </select>
                                    </div></td></tr>

                                    <?php
                                }
                                ?> <tr>
                            <td class="trp_add_table">Add Date: <input type="text" id="new_early_childhood_date" class="hasDatepickers no_view"></td>
                            <td class="trp_add_table"><input type="button" value="Save Date" class="no_view" onclick="
                                    $.post(
                                            '../ajax/new_date.php',
                                            {
                                                action: 'new_date',
                                                date: document.getElementById('new_early_childhood_date').value,
                                                program: '<?php echo $_GET['id']; ?>'
                                            },
                                    function(response) {
                                        //document.write(response);
                                        window.location = 'profile.php?id=<?php echo $_GET['id']; ?>';
                                    }
                                    )"><br/>
                                <span class="helptext">Dates must be entered in MM/DD/YYYY format to save correctly.</span></td>
                        </tr>
                    </table>
                </td>
                <td class="trp_add_table">

                    <!-- test scores for people in this program. -->	
                    <h4>GPA and ISAT Scores</h4>
    <?php
    $get_academic_info_by_program_sqlsafe = "SELECT AVG(GPA), AVG(ISAT_Math), AVG(ISAT_Reading), Quarter, School_Year
                                    FROM Academic_Info WHERE Program_ID='" . $program['Program_ID'] . "' GROUP BY Quarter";
    // echo $get_academic_info_by_program_sqlsafe;
    $academic_program = mysqli_query($cnnTRP, $get_academic_info_by_program_sqlsafe);
    ?><table class="gpa_isat_table">
                        <tr class="divider"><td class="trp_add_table"><strong>Quarter/Year</strong></td><td class="trp_add_table"><strong>Average GPA/<strong></td><td class="trp_add_table"><strong>Average ISAT Math</strong></td>
                            <td class="trp_add_table"><strong>Average ISAT Reading</strong></td><td class="trp_add_table"><strong>Average ISAT Total</strong></td><!--<th>Number of Participants Counted</th>--></tr>

                                            <?php
                                            while ($acade = mysqli_fetch_array($academic_program)) {
                                                ?>
                                            <tr><td class="trp_add_table"><?php echo $acade['Quarter'] . '/' . $acade['School_Year']; ?></td>
                                                <td class="trp_add_table"><?php echo number_format($acade['AVG(GPA)'], 2); ?></td>
                                                <td class="trp_add_table"><?php echo number_format($acade['AVG(ISAT_Math)']); ?></td>
                                                <td class="trp_add_table"><?php echo number_format($acade['AVG(ISAT_Reading)']); ?></td>
                                                <td class="trp_add_table"></td>
                                                <!--<td class="trp_add_table"><?php
                                    $count_people_with_academic_sqlsafe = "SELECT COUNT(*) FROM Academic_Info WHERE Program_ID='" . $program['Program_ID']
                                            . "' AND Quarter=" . $acade['Quarter'];
                                    $count_people = mysqli_query($cnnTRP, $count_people_with_academic_sqlsafe);
                                    $peoplenum = mysqli_fetch_row($count_people);
                                    //echo $peoplenum[0];
                                                ?></td>-->
                                            </tr>
                                            <?php
                                        }
                                        ?></table>
                                        <!-- because the traditions survey is short answer, not multiple choice, we struggled a little with
                                        how to display it. For now we're just showing the pre/post program average responses to the
                                        identity survey.  This may change with feedback. -->

                                        <!--<h4>Cultural Traditions Surveys</h4><?php
                                    $get_surveys_sqlsafe = "SELECT* FROM NMMA_Traditions_Survey";
                                    $surveys = mysqli_query($cnnTRP, $get_surveys_sqlsafe);
                                        ?><table class="inner_table">
                                            <tr><th>Pre or Post</th><th>Date Completed</th><th>Participant?<br>(do we want to show this?)</th></tr>
                                        <?php
                                        while ($survey = mysqli_fetch_array($surveys)) {
                                            ?>
                                                <tr><td class="trp_add_table"><?php echo $survey['Pre_Post']; ?></td><td class="trp_add_table"><?php echo $survey['Date']; ?></td><td class="trp_add_table"></td></tr>
                                            <?php
                                        }
                                        ?></table>
                                        <br/><br/>
                                        <h4>Cultural Identity Surveys</h4>
                                        <?php
                                        $get_pre_surveys_sqlsafe = "SELECT AVG(Q1), AVG(Q2), AVG(Q3), AVG(Q4), AVG(Q5), AVG(Q6), AVG(Q7),
                                    AVG(Q8), AVG(Q9), AVG(Q10), AVG(Q11)
                                    FROM NMMA_Identity_Survey
                                    WHERE Pre_Post='pre';";
                                        $pre_surveys = mysqli_query($cnnTRP, $get_pre_surveys_sqlsafe);
                                        $pre = mysqli_fetch_row($pre_surveys);
                                        $get_post_surveys_sqlsafe = "SELECT AVG(Q1), AVG(Q2), AVG(Q3), AVG(Q4), AVG(Q5), AVG(Q6), AVG(Q7),
                                    AVG(Q8), AVG(Q9), AVG(Q10), AVG(Q11)
                                    FROM NMMA_Identity_Survey
                                    WHERE Pre_Post='post';";
                                        $post_surveys = mysqli_query($cnnTRP, $get_post_surveys_sqlsafe);
                                        $post = mysqli_fetch_row($post_surveys);
                                        ?>-->

                                        <br/><br/>
                                        <h4>Surveys</h4>
                                        <table id="nmma_survey_summary">
                                            <tr><th></th><th width="15%">Pre-Program Average</th><th width="15%">Post-Program Average</th></tr>
                                            <tr class="divider"><td class="trp_add_table" colspan="3"><strong>Cultural Identity Survey</strong></td></tr>
                                            <?php
                                            $id_questions = array("Do you think you can explain what culture is?",
                                                "How much do you know about your home culture?",
                                                "Do you enjoy activities connected with your culture at home?",
                                                "Do you think you have a great understanding of your cultural background?",
                                                "Do you think that your family can support you when you need help?",
                                                "Do you think that your community can support you when you need help?",
                                                "Do you think of your culture as a source of strength when you need help?",
                                                "Do you think that you can make a difference in shaping your own future?",
                                                "Do you think that your cultural values help you make good decisions?",
                                                "Do you think that your cultural values will help you in the future?",
                                                "Do you think that you have great personal qualities?");
                                            for ($q = 0; $q <= 10; $q++) {
                                                $question_number = $q + 1;
                                                ?>
                                                <tr>
                                                    <td class="trp_add_table" class="q">
                                                        <strong><?php echo $question_number; ?>: </strong> <?php echo $id_questions[$q]; ?>
                                                    </td>
                                                    <td class="trp_add_table">
                                                <?php echo number_format($pre[$q], 1); ?>
                                                    </td>
                                                    <td class="trp_add_table">
                                                <?php echo number_format($post[$q], 1); ?>
                                                    </td>
                                                </tr>	
                                                <?php
                                            }
                                            ?>
                                                    <!--<tr class="divider"><td class="trp_add_table" colspan="3"><strong>Cultural Traditions Survey</strong><br/> <span style="color:#990000;font-weight:bold;">Need to determine how to show this in the aggregate (responses are text-based).</span></td></tr>
    <?php
    $traditions_questions = array("What makes up a person's culture?",
        "What is your cultural traditions?",
        "What does art tell you about someone's culture?",
        "What is the importance of this type of art?",
        "Describe the kinds of tools and materials used when creating this type of art.",
        "Please explain any special techniques or safety requirements required when using the tools and materials listed above.",
        "Name at least one artist associated with the documentation of cultural traditions through his or her artwork.",
        "Please tell me in your own words how to document cultural traditions through art.");
    for ($q = 0; $q <= 7; $q++) {
        $question_number = $q + 1;
        ?>
                                                <tr>
                                                        <td class="trp_add_table" class="q"><strong><?php echo $question_number; ?>: </strong> <?php echo $traditions_questions[$q]; ?></td>
                                                        <td class="trp_add_table">
                                                                
                                                        </td>
                                                        <td class="trp_add_table">
                                                                
                                                        </td>
                                                </tr>
                                            <?php
                                        }
                                        ?>-->
                                        </table>
                                        </td>
                                        </tr>
                                        </table>
    <?php
}

//if La Casa, do not show Sessions block.
if ($program['Program_ID'] != 6){
?>
        
        <div style="border: #ccc solid thin;">
            <br />
            <table>
                <tr>
                    <td class="trp_add_table" style="width: 400px;">
                    <!-- Sessions -->
                    <h4>Add New Session</h4>
                    <table class="inner_table" style="width: 250px;">
                        <tr>
                            <td class="trp_add_table">
                                <strong>Name:</strong>
                            </td>
                            <td class="trp_add_table">
                                <input name="new_session_name" id="new_session_name" />
                            </td>
                        </tr>
                        <tr>
                            <td class="trp_add_table">
                                <strong>Start Date:</strong>
                            </td>
                            <td class="trp_add_table">
                                <input name="new_session_start_date" id="new_session_start_date" />
                                <script>
                                    $(function() {
                                        $("#new_session_start_date").datepicker({dateFormat: "mm/dd/yy",
                                                                                changeYear: true,
                                                                                yearRange: "1920:2016"});
                                    });
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td class="trp_add_table">
                                <strong>End Date:</strong>
                            </td>
                            <td class="trp_add_table">
                                <input name="new_session_end_date" id="new_session_end_date" />
                                <script>
                                    $(function() {
                                        $("#new_session_end_date").datepicker({dateFormat: "mm/dd/yy",
                                                                                changeYear: true,
                                                                                yearRange: "1920:2016"});
                                    });
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td class="trp_add_table" colspan="2" style="text-align: center;">
                                <input type="button" onclick="
                                    //first check whether a session with this name already exists:
                                    $.post(
                                            '../ajax/save_session.php',
                                            {
                                                program_id: '<?php echo $_GET['id']; ?>',
                                                session_name: $('#new_session_name').val(),
                                                session_start_date: $('#new_session_start_date').val(),
                                                session_end_date: $('#new_session_end_date').val()
                                            },
                                    function(response) {
                                        // alert(response);
                                        if (response != '') {
                                            alert('An Error Occurred: ' + response);
                                            return false;
                                        } else {
                                            $('#new_session_name').val('');
                                            $('#new_session_start_date').val('');
                                            $('#new_session_end_date').val('');
                                            window.location.href = './profile.php?id=<?php echo $_GET['id']; ?>';
                                        }
                                    });" value="Add Session">

                            </td>
                        </tr>
                    </table>
        </td>
        <td class="trp_add_table">
                    
                    <h4>Sessions</h4>
                    <script>
                        var programParticipants = [
                        <?php
                        $program_participants = mysqli_query($cnnTRP, "SELECT * FROM Participants_Programs
                                                                INNER JOIN Participants ON Participants_Programs.Participant_ID = Participants.Participant_ID
                                                                WHERE Program_ID = '" . $program['Program_ID'] . "'
                                                                ORDER BY Participants.Last_Name");

                        $count = 0;
                        while ($program_participant = mysqli_fetch_assoc($program_participants)) {
                            if ($count > 0) {
                                echo ",";
                            }
                            $count++;
                            ?>
                            {"value": "<?php echo $program_participant['Last_Name'] . ', ' . $program_participant['First_Name']; ?>", "participant_id": "<?php echo $program_participant['Participant_ID']; ?>"}
                            <?php
                        }
                        ?>
                        ];
                    </script>

                    <?php
                    $all_program_sessions_sqlsafe = "SELECT * FROM Program_Sessions
                                            WHERE
                                                Program_ID = " . mysqli_real_escape_string($cnnTRP, $_GET['id']) . ";";
                    $all_program_sessions = mysqli_query($cnnTRP, $all_program_sessions_sqlsafe);
                    
                    while($program_session = mysqli_fetch_assoc($all_program_sessions)) {
                        ?>
                        <table class="inner_table" style="width: 80%;">
                            <tr>
                                <td class="trp_add_table" style="font-size: 13px;">
                                    <?php echo $program_session['Session_Name']; ?>
                                </td>
                                <td class="trp_add_table" style="font-size: 13px;">
                                    (<?php echo $program_session['Start_Date']; ?> -
                                    <?php echo $program_session['End_Date']; ?>)
                                </td>
                                <td class="trp_add_table">
                                    <a href="javascript:;" onclick="$('#program_session_edit_<?php echo $program_session['Session_ID']; ?>').toggle();" style="font-size: 13px;">Edit Session</a>
                                </td>
                                <td class="trp_add_table">
                                    <a href="javascript:;" onclick="$('#add_session_participant_<?php echo $program_session['Session_ID']; ?>').toggle();" style="font-size: 13px;">Add Participant</a>
                                    <div id="add_session_participant_<?php echo $program_session['Session_ID']; ?>" style="display: none;">
                                        <input type="text"
                                               name="add_session_participant_input_<?php echo $program_session['Session_ID']; ?>"
                                               id="add_session_participant_input_<?php echo $program_session['Session_ID']; ?>" />
                                        <input type="hidden"
                                               name="add_session_participant_input_id_<?php echo $program_session['Session_ID']; ?>"
                                               id="add_session_participant_input_id_<?php echo $program_session['Session_ID']; ?>" />
                                        <script>
                                            $(function() {
                                                $("#add_session_participant_input_<?php echo $program_session['Session_ID']; ?>").autocomplete({
                                                 source: programParticipants,
                                                 select: function(event, ui) {
                                                     $('#add_session_participant_input_id_<?php echo $program_session['Session_ID']; ?>').val(ui.item.participant_id);
                                                 }});
                                            });
                                        </script>
                                        <input type="button" onclick="
                                            if ($('#add_session_participant_input_id_<?php echo $program_session['Session_ID']; ?>').val() == '') {
                                                alert('Please enter / select a participant to add.');
                                                $('#add_session_participant_input_<?php echo $program_session['Session_ID']; ?>').focus();
                                            } else {
                                                $.post(
                                                        '../ajax/add_session_participant.php',
                                                        {
                                                            session_id: <?php echo $program_session['Session_ID']; ?>,
                                                            participant_id: $('#add_session_participant_input_id_<?php echo $program_session['Session_ID']; ?>').val()
                                                        },
                                                function(response) {
                                                    // alert(response);
                                                    if (response != '') {
                                                        alert('An Error Occurred: ' + response);
                                                        return false;
                                                    } else {
                                                        if (confirm('New participant added. Refresh screen?')) {
                                                            window.location.href = './profile.php?id=<?php echo $_GET['id']; ?>';
                                                        } else {
                                                            $('#add_session_participant_input_<?php echo $program_session['Session_ID']; ?>').val('');
                                                            $('#add_session_participant_input_id_<?php echo $program_session['Session_ID']; ?>').val('');
                                                        }
                                                    }
                                                });
                                                }" value="Add Participant" />
                                    </div>
                                </td>
                            </tr>
                            <tr id="program_session_edit_<?php echo $program_session['Session_ID']; ?>" style="display: none;">
                                <td class="trp_add_table" style="font-size: 13px;">
                                    <input name="session_name_<?php echo $program_session['Session_ID']; ?>" id="session_name_<?php echo $program_session['Session_ID']; ?>" value="<?php echo $program_session['Session_Name']; ?>" />
                                </td>
                                <td class="trp_add_table" style="font-size: 13px;">
                                    (<input name="session_start_date_<?php echo $program_session['Session_ID']; ?>" id="session_start_date_<?php echo $program_session['Session_ID']; ?>" value="<?php echo $program_session['Start_Date']; ?>" /> -
                                    <input name="session_end_date_<?php echo $program_session['Session_ID']; ?>" id="session_end_date_<?php echo $program_session['Session_ID']; ?>" value="<?php echo $program_session['End_Date']; ?>" />)
                                    <script>
                                    $(function() {
                                        $("#session_start_date_<?php echo $program_session['Session_ID']; ?>").datepicker({dateFormat: "mm/dd/yy",
                                                                                changeYear: true,
                                                                                yearRange: "1920:2016"});
                                        $("#session_end_date_<?php echo $program_session['Session_ID']; ?>").datepicker({dateFormat: "mm/dd/yy",
                                                                                changeYear: true,
                                                                                yearRange: "1920:2016"});
                                    });
                                </script>
                                </td>
                                <td class="trp_add_table">
                                    <input type="button" onclick="
                                            $.post(
                                                    '../ajax/save_session.php',
                                                    {
                                                        session_id: <?php echo $program_session['Session_ID']; ?>,
                                                        session_name: $('#session_name_<?php echo $program_session['Session_ID']; ?>').val(),
                                                        session_start_date: $('#session_start_date_<?php echo $program_session['Session_ID']; ?>').val(),
                                                        session_end_date: $('#session_end_date_<?php echo $program_session['Session_ID']; ?>').val()
                                                    },
                                            function(response) {
                                                // alert(response);
                                                if (response != '') {
                                                    alert('An Error Occurred: ' + response);
                                                    return false;
                                                } else {
                                                    window.location.href = './profile.php?id=<?php echo $_GET['id']; ?>';
                                                }
                                            });" value="Save Session">
                                </td>
                            </tr>
                            
                            <?php
                            $all_session_participants_sqlsafe = "SELECT Participants.*
                                                    FROM
                                                        Participants_Program_Sessions
                                                    LEFT JOIN Participants ON Participants.Participant_ID = Participants_Program_Sessions.Participant_ID
                                                    WHERE
                                                        Participants_Program_Sessions.Session_ID = " . $program_session['Session_ID'] . ";";
                            $all_session_participants = mysqli_query($cnnTRP, $all_session_participants_sqlsafe);

                            while($session_participant = mysqli_fetch_assoc($all_session_participants)) {
                                ?>
                                <tr id="session_participant_<?php echo $program_session['Session_ID']; ?>_<?php echo $session_participant['Participant_ID']; ?>">
                                    <td class="trp_add_table" style="font-size: 13px;" colspan="2">
                                        <a href="../participants/profile.php?id=<?php echo $session_participant['Participant_ID']; ?>"><?php echo $session_participant['Last_Name']; ?>, <?php echo $session_participant['First_Name']; ?></a>
                                    </td>
                                    <td class="trp_add_table" style="font-size: 13px;">
                                        <a href="javascript:;" onclick="
                                            if (confirm('Are you sure you want to remove this participant from this session?')) {
                                                $.post(
                                                        '../ajax/remove_session_participant.php',
                                                        {
                                                            session_id: <?php echo $program_session['Session_ID']; ?>,
                                                            participant_id: <?php echo $session_participant['Participant_ID']; ?>
                                                        },
                                                function(response) {
                                                    //alert(response);
                                                    if (response != '') {
                                                        alert('An Error Occurred: ' + response);
                                                        return false;
                                                    } else {
                                                        $('#session_participant_<?php echo $program_session['Session_ID']; ?>_<?php echo $session_participant['Participant_ID']; ?>').hide();
                                                        //window.location.href = './profile.php?id=<?php echo $_GET['id']; ?>';
                                                    }
                                                    });
                                                    }" style="color: #f00;" title="Remove Participant">X</a>
                                    </td>
                                    <td class="trp_add_table">
                                        
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <?php
                    }
                    ?>
        </td>
                </tr>
            </table>
        </div>
<?php
//end of sessions block, visible for all but La Casa
}
?>
                    
                                    </div>
                                    <br/><br/>
<?php
include "../include/dbconnclose.php";
include "../../footer.php";
?>
