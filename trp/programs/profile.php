<?php
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
    });
</script>

<div id="program_profile" class="content_block">

    <h3>Program Profile - <?php echo $program['Program_Name']; ?></h3><hr/><br/>
    
    <table width="100%" border="1">
            <tr>
                <td width="40%">
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
                                    <td><strong>First Name:</strong></td>
                                    <td><input type="text" id="name_search" style="width:100px;"/></td>
                                    <td><strong>Last Name:</strong></td>
                                    <td><input type="text" id="surname_search" style="width:100px;" /></td>
                                </tr>
                                <tr>
                                    <td><strong>DOB:</strong></td>
                                    <td><input type="text" id="dob_search" style="width:70px;" /></td>
                                    <td><strong>Gender:</strong></td>
                                    <td><select id="gender_search">
                                            <option value="">---------</option>
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align:center;"><input type="button" value="Search" onclick="
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
                                    <td><strong>First Name:</strong></td>
                                    <td><input type="text" id="name_add" style="width:100px;"/></td>
                                    <td><strong>Last Name:</strong></td>
                                    <td><input type="text" id="surname_add" style="width:100px;" /></td>
                                    <td><strong>DOB:</strong></td>
                                    <td><input type="text" id="dob_add" style="width:70px;" /></td>
                                    <td><strong>Gender:</strong></td>
                                    <td><select id="gender_add">
                                            <option value="">---------</option>
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                     <td><strong>Race:</strong></td>
                                    <td><input type="text" id="race_add" style="width:100px;"/></td>
                                    <td colspan="6"></td>
                                </tr>
                                <tr>
                                    <td><strong>Email 1</strong></td>
                                    <td><input type="text" id="email1_add"></td>
                                    <td><strong>Mailing Address</strong></td>
                                    <td><input type="text" id=""></td>
                                    <td><strong>Mailing City</strong></td>
                                    <td><input type="text" id="city_add"></td>
                                    <td><strong>Mailing State</strong></td>
                                    <td><input type="text" id="state_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Zipcode</strong></td>
                                    <td><input type="text" id="zip_add"></td>
                                    <td><strong>Home Phone</strong></td>
                                    <td><input type="text" id="phone_add"></td>
                                    <td><strong>Email 2</strong></td>
                                    <td><input type="text" id="email2_add"></td>
                                    <td><strong>Mobile Phone </strong></td>
                                    <td><input type="text" id="mobile_add"></td>
                                </tr>
                                <tr>
                                    <td colspan="8"><strong>For La Casa Residents</strong></td>
                                </tr>    
                                <tr>
                                    <td><strong>Group</strong></td>
                                    <td><input type="text" id="group_add"></td>
                                    <td><strong>Handbook</strong></td>
                                    <td><input type="text" id="hndbk_add"></td>
                                    <td><strong>Status</strong></td>
                                    <td><input type="text" id="status_add"></td>
                                    <td><strong>Floor</strong></td>
                                    <td><input type="text" id="floor_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Pod</strong></td>
                                    <td><input type="text" id="pod_add"></td>
                                    <td><strong>Room Number</strong></td>
                                    <td><input type="text" id="rm_add"></td>
                                    <td><strong>Key Card Number</strong></td>
                                    <td><input type="text" id="keynum_add"></td>
                                    <td><strong>Application Received</strong></td>
                                    <td><input type="text" id="apprec_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Application Completed</strong></td>
                                    <td><input type="text" id="appcom_add"></td>
                                    <td><strong>Roommate</strong></td>
                                    <td><input type="text" id="rmmate_add"></td>
                                    <td><strong>Roommate Move In Date</strong></td>
                                    <td><input type="text" id="rmmate_date_add"></td>
                                    <td><strong>LCRC Username</strong></td>
                                    <td><input type="text" id="username_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>LCRC Password</strong></td>
                                    <td><input type="text" id="pword_add"></td>
                                    <td><strong>LCRC Print Code</strong></td>
                                    <td><input type="text" id="print_add"></td>
                                    <td><strong>High School</strong></td>
                                    <td><input type="text" id="hs_add"></td>
                                    <td><strong>ACT Score</strong></td>
                                    <td><input type="text" id="act_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>HS GPA (Unweighted)</strong></td>
                                    <td><input type="text" id="gpaun_add"></td>
                                    <td><strong>HS GPA (weighted)</strong></td>
                                    <td><input type="text" id="gpaweight_add"></td>
                                    <td><strong>Highest level of education completed by Mother</strong></td>
                                    <td><input type="text" id="mother_ed_add"></td>
                                    <td><strong>Highest level of education completed by Father</strong></td>
                                    <td><input type="text" id="father_ed_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>First Generation College Student</strong></td>
                                    <td><input type="text" id="firstgen_add"></td>
                                    <td><strong>24 or older?</strong></td>
                                    <td><input type="text" id="age_add"></td>
                                    <td><strong>Master or above?</strong></td>
                                    <td><input type=text" id="masters_add"></td>
                                    <td><strong>Married?</strong></td>
                                    <td><input type="text" id="married_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Military?</strong></td>
                                    <td><input type="text" id="military_add"></td>
                                    <td><strong>Has children?</strong></td>
                                    <td><input type="text" id="children_add"></td>
                                    <td><strong>Homeless?</strong></td>
                                    <td><input type="text" id="homeless_add"></td>
                                    <td><strong>Self Sustaining (if student income >=$12,510</strong></td>
                                    <td><input type="text" id="selfsust_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Tax Exemptions</strong></td>
                                    <td><input type="text" id="taxex_add"></td>
                                    <td><strong>Household size (per La Casa application)</strong></td>
                                    <td><input type="text" id="household_add"></td>
                                    <td><strong>Parent 1 AGI</strong></td>
                                    <td><input type="text" id="par1agi_add"></td>
                                    <td><strong>Parent 2 AGI</strong></td>
                                    <td><input type="text" id="par2agi_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Student AGI</strong></td>
                                    <td><input type="text" id="stntagi_add"></td>
                                    <td><strong>Actual AMI</strong></td>
                                    <td><input type="text" id="ami_add"></td>
                                    <td><strong>Application Source</strong></td>
                                    <td><input type="text" id="appsource_add"></td>
                                    <td><strong>Notes</strong></td>
                                    <td><input type="text" id="notes_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Email: Pack This!</strong></td>
                                    <td><input type="text" id="pack_email_add"></td>
                                    <td><strong>Email: Move-in and Orientation</strong></td>
                                    <td><input type="text" id="orient_email_add"></td>
                                    <td><strong>Email: Roommate</strong></td>
                                    <td><input type="text" id="rmmate_email_add"></td>
                                    <td><strong>Move-In</strong></td>
                                    <td><input type="text" id="move_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Move-In Registration</strong></td>
                                    <td><input type="text" id="registration_add"></td>
                                    <td><strong>Move-In Address</strong></td>
                                    <!-- What is this? -->
                                    <td><input type="text" id=""></td>
                                    <td><strong>Move-In Note</strong></td>
                                    <td><input type="text" id="move_note_add"></td>
                                    <td><strong>Orientation Date</strong></td>
                                    <td><input type="text" id="orient_date_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Orientation Time</strong></td>
                                    <td><input type="text" id="orient_time_add"></td>
                                    <td><strong>Emergency Contact (First Name)</strong></td>
                                    <td><input type="text" id="ec1first_add"></td>
                                    <td><strong>Emergency Contact (Last Name)</strong></td>
                                    <td><input type="text" id="ec1last_add"></td>
                                    <td><strong>Emergency Contact Phone</strong></td>
                                    <td><input type="text" id="ec1phone_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Emergency Contact Relationship</strong></td>
                                    <td><input type="text" id="ec1rel_add"></td>
                                    <td><strong>Emergency Contact 2 (First Name)</strong></td>
                                    <td><input type="text" id="ec2first_add"></td>
                                    <td><strong>Emergency Contact 2 (Last Name)</strong></td>
                                    <td><input type="text" id="ec2last_add"></td>
                                    <td><strong>Emergency Contact 2 Phone</strong></td>
                                    <td><input type="text" id="ec2phone_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Emergency Contact 2 Relationship</strong></td>
                                    <td><input type="text" id="ec2rel_add"></td>
                                    <td><strong>La Casa Scholarship (Annual Award)</strong></td>
                                    <td><input type="text" id="lcschol_add"></td>
                                    <td><strong>College Grade Level</strong></td>
                                    <td><input type="text" id="grade_add"></td>
                                    <td><strong>Major</strong></td>
                                    <td><input type="text" id="major_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Minor</strong></td>
                                    <td><input type="text" id="minor_add"></td>
                                    <td><strong>Community College</strong></td>
                                    <td><input type="text" id="commcol_add"></td>
                                    <td><strong>Four Year College</strong></td>
                                    <td><input type="text" id="fourcol_add"></td>
                                    <td><strong>Selectivity (of Current College)</strong></td>
                                    <td><input type="text" id="selectivity_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Student's Expected Match Level</strong></td>
                                    <td><input type=text" id="matchexp_add"></td>
                                    <td><strong>Student's Actual Match Level</strong></td>
                                    <td><input type=text" id="matchact_add"></td>
                                    <td><strong>Credits Accrued (by Fall)</strong></td>
                                    <td><input type="text" id="fall_credits_add"></td>
                                    <td><strong> Credits Accrued (by Spring)</strong></td>
                                    <td><input type="text" id="spring_credits_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Spring GPA</strong></td>
                                    <td><input type="text" id="spring_gpa_add"></td>
                                    <td><strong>Summer GPA</strong></td>
                                    <td><input type="text" id="summer_gpa_add"></td>
                                    <td><strong>Fall GPA</strong></td>
                                    <td><input type="text" id="fall_gpa_add"></td>
                                    <td><strong>School Year</strong></td>
                                    <td><input type="text" id="schoolyr_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Highest Level of Education - Goal</strong></td>
                                    <td><input type="text" id="goaled_add"></td>
                                    <td><strong>Tuition</strong></td>
                                    <td><input type="text" id="tuition_add"></td>
                                    <td><strong>Mandatory Fees (do not include loan fees)</strong></td>
                                    <td><input type="text" id="fees_add"></td>
                                    <td><strong>Food, Transportation, and Books</strong></td>
                                    <td><input type="text" id="othercost_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>La Casa Rent</strong></td>
                                    <td><input type="text" id="rent_add"></td>
                                    <td><strong>Cost of Attendance according to college</strong></td>
                                    <td><input type="text" id="colcost_add"></td>
                                    <td><strong>Pell Grant</strong></td>
                                    <td><input type="text" id="pell_add"></td>
                                    <td><strong>MAP Grant</strong></td>
                                    <td><input type="text" id="map_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>University Scholarships</strong></td>
                                    <td><input type="text" id="uschol_add"></td>
                                    <td><strong>Federal Subsidized Loan</strong></td>
                                    <td><input type="text" id="subloan_add"></td>
                                    <td><strong>Federal Unsubsidized Loan</strong></td>
                                    <td><input type="text" id="unsubloan_add"></td>
                                    <td><strong>Work-Study or other Self-Help
                                        (enter $3,500 for all)</strong></td>
                                    <td><input type="text" id="selfhelp_add"></td>
                                </tr>
                                <tr>
                                    <td><strong>Savings</strong></td>
                                    <td><input type="text" id="savings_add"></td>
                                    <td><strong>Family Assistance/Sponsor/Other</strong></td>
                                    <td><input type="text" id="moneyhelp_add"></td>
                                    <td><strong></strong></td>
                                    <td><strong></strong></td>
                                    <td><strong></strong></td>
                                    <td><strong></strong></td>
                                </tr>
                                
                                <tr>
                                    <td colspan="8" style="text-align:center;"><input type="button" value="Add" onclick="
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
                                            group_add: document.getElementById('group_add').value,
                                            handbook_add: document.getElementById('hndbk_add').value,
                                            status_add: document.getElementById('status_add').value,
                                            floor_add: document.getElementById('floor_add').value,
                                            pod_add: document.getElementById('pod_add').value,
                                            rmnum_add: document.getElementById('rm_add').value, 
                                            keynum_add: document.getElementById('keynum_add').value,
                                            apprec_add: document.getElementById('apprec_add').value,
                                            appcom_add: document.getElementById('appcom_add').value,
                                            rmmate_add: document.getElementById('rmmate_add').value,
                                            rmmate_date_add: document.getElementById('rmmate_date_add').value,
                                            username_add: document.getElementById('username_add').value,
                                            pword_add: document.getElementById('pword_add').value,
                                            print_add: document.getElementById('print_add').value,
                                            hs_add: document.getElementById('hs_add').value,
                                            act_add: document.getElementById('act_add').value,
                                            gpaun_add: document.getElementById('gpaun_add').value,
                                            gpaweight_add: document.getElementById('gpaweight_add').value,
                                            mother_ed_add: document.getElementById('mother_ed_add').value,
                                            father_ed_add: document.getElementById('father_ed_add').value,
                                            firstgen_add: document.getElementById('firstgen_add').value,
                                            age_add: document.getElementById('age_add').value,
                                            masters_add: document.getElementById('masters_add').value,
                                            married_add: document.getElementById('married_add').value,
                                            military_add: document.getElementById('military_add').value,
                                            children_add: document.getElementById('children_add').value,
                                            homeless_add: document.getElementById('homeless_add').value,
                                            selfsust_add: document.getElementById('selfsust_add').value,
                                            taxex_add: document.getElementById('taxex_add').value,
                                            household_add: document.getElementById('household_add').value,
                                            par1agi_add: document.getElementById('par1agi_add').value,
                                            par2agi_add: document.getElementById('par2agi_add').value,
                                            stdtagi_add: document.getElementById('stntagi_add').value,
                                            ami_add: document.getElementById('ami_add').value,
                                            appsource_add: document.getElementById('appsource_add').value,
                                            notes_add: document.getElementById('notes_add').value,
                                            pack_email_add: document.getElementById('pack_email_add').value,
                                            orient_email_add: document.getElementById('orient_email_add').value,
                                            rmmate_email_add: document.getElementById('rmmate_email_add').value,
                                            move_add: document.getElementById('move_add').value,
                                            registration_add: document.getElementById('registration_add').value,
                                            move_note_add: document.getElementById('move_note_add').value,
                                            orient_date_add: document.getElementById('orient_date_add').value,
                                            orient_time_add: document.getElementById('orient_time_add').value,
                                            ec1first_add: document.getElementById('ec1first_add').value,
                                            ec1last_add: document.getElementById('ec1last_add').value,
                                            ec1phone_add: document.getElementById('ec1phone_add').value,
                                            ec1rel_add: document.getElementById('ec1rel_add').value,
                                            ec2first_add: document.getElementById('ec2first_add').value,
                                            ec2last_add: document.getElementById('ec2last_add').value,
                                            ec2phone_add: document.getElementById('ec2phone_add').value,
                                            ec2rel_add: document.getElementById('ec2rel_add').value,
                                            lcschol_add: document.getElementById('lcschol_add').value,
                                            grade_add: document.getElementById('grade_add').value,
                                            major_add: document.getElementById('major_add').value,
                                            minor_add: document.getElementById('minor_add').value,
                                            commcol_add: document.getElementById('commcol_add').value,
                                            fourcol_add: document.getElementById('fourcol_add').value,
                                            selectivity_add: document.getElementById('selectivity_add').value,
                                            matchexp_add: document.getElementById('matchexp_add').value,
                                            matchact_add: document.getElementById('matchact_add').value,
                                            fall_credits_add: document.getElementById('fall_credits_add').value,
                                            spring_credits_add: document.getElementById('spring_credits_add').value,
                                            spring_gpa_add: document.getElementById('spring_gpa_add').value,
                                            summer_gpa_add: document.getElementById('summer_gpa_add').value,
                                            fall_gpa_add: document.getElementById('fall_gpa_add').value,
                                            schoolyr_add: document.getElementById('schoolyr_add').value,
                                            goaled_add: document.getElementById('goaled_add').value,
                                            tuition_add: document.getElementById('tuition_add').value,
                                            fees_add: document.getElementById('fees_add').value,
                                            othercosts_add: document.getElementById('othercost_add').value,
                                            rent_add: document.getElementById('rent_add').value,
                                            colcost_add: document.getElementById('colcost_add').value,
                                            pell_add: document.getElementById('pell_add').value,
                                            map_add: document.getElementById('map_add').value,
                                            uschol_add: document.getElementById('uschol_add').value,
                                            subloan_add: document.getElementById('subloan_add').value,
                                            unsubload_add: document.getElementById('unsubloan_add').value,
                                            selfhelp_add: document.getElementById('selfhelp_add').value,
                                            savings_add: document.getElementById('savings_add').value,
                                            moneyhelp_add: document.getElementById('moneyhelp_add').value

                                        },
                                    function(response) {
                                        //document.write(response);
                                        document.getElementById('add_person_results').innerHTML = response;
                                    }
                                    )"/></td>
                                </tr>
                            </table>
                            <div id="add_person_results"></div>
                        </div>
                    </div>
                    <hr>
                    <h4>Current Program Enrollment</h4>
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
                    $get_uploads_sqlsafe = "SELECT Upload_Id, File_Name FROM Programs_Uploads WHERE Program_ID='" . mysqli_real_escape_string($_GET['id']) . "'";
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
                <td>

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
    include "../include/dbconnopen.php";
    $averages_yr_1 = mysqli_query($cnnTRP, $averages_1_sqlsafe);
    $averages1 = mysqli_fetch_row($averages_yr_1);
    $averages_yr_2 = mysqli_query($cnnTRP, $averages_2_sqlsafe);
    $averages2 = mysqli_fetch_row($averages_yr_2);
    $averages_yr_3 = mysqli_query($cnnTRP, $averages_3_sqlsafe);
    $averages3 = mysqli_fetch_row($averages_yr_3);
    include "../include/dbconnclose.php";
    ?>
                    <table id="gold_scores_table">
                        <tr>
                            <th></th><th>Year 1 Avg. Score</th><th>Year 2 Avg. Score</th><th>Year 3 Avg. Score</th>
                        </tr>
                        <tr>
                            <td class="gold_category">Social-Emotional</td>
                            <td class="gold_category"><?php echo number_format($averages1[0], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages2[0], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages3[0], 1); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <!-- these commented areas are for the scores for individual questions.
                        we're just showing the aggregate score for each section for now, but wanted to leave
                        the option to save individual responses too.
                        -->

    <!--<tr>
            <td><strong>1a.</strong> Manages feelings</td>
            <td></td>
    </tr>
    <tr>
            <td><strong>1b.</strong> Follows limits and expectations</td>
            <td></td>
    </tr>
    <tr>
            <td><strong>1c.</strong> Takes care of own needs appropriately</td>
            <td></td>
    </tr>
    <tr>
            <td><strong>2a.</strong> Forms relationships with adults</td>
            <td></td>
    </tr>
    <tr>
            <td><strong>2b.</strong> Responds to emotional cues</td>
            <td></td>
    </tr>
    <tr>
            <td><strong>2c.</strong> Interacts with peers</td>
            <td></td>
    </tr>
    <tr>
            <td><strong>2d.</strong> Makes friends</td>
            <td></td>
    </tr>
    <tr>
            <td><strong>3a.</strong> Balances needs and rights of self and others</td>
            <td></td>
    </tr>
    <tr>
            <td><strong>3b.</strong> Solves social problems</td>
            <td></td>
    </tr>-->
                        <tr>
                            <td class="gold_category">Physical</td>
                            <td class="gold_category"><?php echo number_format($averages1[1], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages2[1], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages3[1], 1); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <!--<tr>
                                <td><strong>4.</strong> Demonstrates traveling skills</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>5.</strong> Demonstrates balancing skills</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>6.</strong> Demonstrates gross motor manipulative skills</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>7a.</strong> Uses fingers and hands</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>7b.</strong> Uses writing and drawing tools</td>
                                <td></td>
                        </tr>-->
                        <tr>
                            <td class="gold_category">Language</td>
                            <td class="gold_category"><?php echo number_format($averages1[2], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages2[2], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages3[2], 1); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <!--<tr>
                                <td><strong>8a.</strong> Comprehends language</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>8b.</strong> Follows directions</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>9a.</strong> Uses an expanding expressive vocabulary</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>9b.</strong> Speaks clearly</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>9c.</strong> Uses conventional grammar</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>9d.</strong> Tells about another time or place</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>10a.</strong> Engages in conversations</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>10b.</strong> Uses social rules of language</td>
                                <td></td>
                        </tr>-->
                        <tr>
                            <td class="gold_category">Cognitive</td>
                            <td class="gold_category"><?php echo number_format($averages1[3], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages2[3], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages3[3], 1); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <!--<tr>
                                <td><strong>11a.</strong> Attends and engages</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>11b.</strong> Persists</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>11c.</strong> Solves problems</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>11d.</strong> Shows curiosity and motivation</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>11e.</strong> Shows flexibility and inventiveness in thinking</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>12a.</strong> Recognizes and recalls</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>12b.</strong> Makes connections</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>13.</strong> Classifies</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>14a.</strong> Thinks symbolically</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>14b.</strong> Engages in sociodramatic play</td>
                                <td></td>
                        </tr>-->
                        <tr>
                            <td class="gold_category">Literacy</td>
                            <td class="gold_category"><?php echo number_format($averages1[4], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages2[4], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages3[4], 1); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <!--<tr>
                                <td><strong>15a.</strong> Notices and discriminates rhyme</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>15b.</strong> Notices and discriminates alliteration</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>15c.</strong> Notices and discriminates smaller and smaller units of sound</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>16a.</strong> Identifies and names letters</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>16b.</strong> Uses letter-sound knowledge</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>17a.</strong> Uses and appreciates books</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>17b.</strong> Uses print concepts</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>18a.</strong> Interacts during read-alouds and book conversations</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>18b.</strong> Uses emergent reading skills</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>18c.</strong> Retells stories</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>19a.</strong> Writes name</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>19b.</strong> Writes to convey meaning</td>
                                <td></td>
                        </tr>-->
                        <tr>
                            <td class="gold_category">Mathematics</td>
                            <td class="gold_category"><?php echo number_format($averages1[5], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages2[5], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages3[5], 1); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <!--<tr>
                                <td><strong>20a.</strong> Counts</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>20b.</strong> Quantifies</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>20c.</strong> Connects numerals with their quantities</td>
                                <td></td>
                        </tr><tr>
                                <td><strong>21a.</strong> Understands spatial relationships</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>21b.</strong> Understands shapes</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>22.</strong> Compares and measures</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>23.</strong> Demonstrates knowledge of patterns</td>
                                <td></td>
                        </tr>-->
                        <tr>
                            <td class="gold_category">Science and Technology</td>
                            <td class="gold_category"><?php echo number_format($averages1[6], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages2[6], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages3[6], 1); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <!--<tr>
                                <td><strong>24.</strong> Uses scientific inquiry skills</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>25.</strong> Demonstrates knowledge of the physical properties of objects and materials</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>26.</strong> Demonstrates knowledge of the physical properties of objects and materials</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>27.</strong> Demonstrates knowledge of the Earth's environment</td>
                                <td></td>
                        </tr>
                        <tr>
                                <td><strong>28.</strong> Uses tools and other technology to perform tasks</td>
                                <td></td>
                        </tr>-->
                        <tr>
                            <td class="gold_category">Social Studies</td>
                            <td class="gold_category"><?php echo number_format($averages1[7], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages2[7], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages3[7], 1); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <!--<tr>
                                <td><strong>29.</strong> Demonstrates knowledge about self</td>
                                <td></td>
                        </tr>-->
                        <tr>
                            <td class="gold_category">Creative Arts Expression</td>
                            <td class="gold_category"><?php echo number_format($averages1[8], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages2[8], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages3[8], 1); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="gold_category">English Language Development</td>
                            <td class="gold_category"><?php echo number_format($averages1[9], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages2[9], 1); ?></td>
                            <td class="gold_category"><?php echo number_format($averages3[9], 1); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    <table>
                        <tr><th>Classroom Number</th><th>Test Time</th><th>Question</th><th>Classroom Average</th><th></th></tr>
                        <?php
                        //show all existing classroom info
                        $get_class_avgs_sqlsafe="SELECT * FROM Class_Avg_Gold_Scores LEFT JOIN Gold_Score_Sections ON Question_ID=Gold_Question_ID";
                       // echo $get_class_avgs;
                        include "../include/dbconnopen.php";
                        $class_avgs=mysqli_query($cnnTRP, $get_class_avgs_sqlsafe);
                        while ($class_avg=mysqli_fetch_array($class_avgs)){
                            ?>
                        <tr><td><?php echo $class_avg['Classroom_ID'];?></td><td><?php if($class_avg['Test_Year']==1){ echo 'First Year';}
                        elseif($class_avg['Test_Year']==2){ echo 'Second Year';}
                        elseif($class_avg['Test_Year']==3){ echo 'Third Year';}
                        if($class_avg['Test_Time']==1){ echo ' Pre Test';}
                        if($class_avg['Test_Time']==2){ echo ' Mid Test';}
                        if($class_avg['Test_Time']==3){ echo ' Post Test';}
                            ?></td>
                            <td><?php echo $class_avg['Gold_Section_Name'];?></td>
                            <td> <?php echo $class_avg['Class_Avg']; ?> </td>
                        </tr>
                                <?php
                        }
                        include "../include/dbconnclose.php";
                        ?>
                        <tr><td><input type="text" id="new_class_num"></td>
                        <td><select id="new_class_year">
                                            <option value="1">First Year</option>
                                            <option value="2">Second Year</option>
                                            <option value="3">Third Year</option>
                                        </select> <select id="new_class_time">
                                            <option value="1">Pre Test</option>
                                            <option value="2">Mid Test</option>
                                            <option value="3">Post Test</option>
                                        </select></td>
                                                <td><select id="new_class_question">
                                            <?php 
                                            $section_query_sqlsafe="SELECT * FROM Gold_Score_Sections";
                                            include "../include/dbconnopen.php";
                                            $sections=mysqli_query($cnnTRP, $section_query_sqlsafe);
                                            while ($sec=  mysqli_fetch_array($sections)){
                                                ?>
                                                        <option value="<?php echo $sec[0];?>"><?php echo $sec[1];?></option>
                                                    <?php
                                            }
                                            include "../include/dbconnclose.php";
                                            ?>
                                            </select>
                                        </td>
                        <td><input type="text" id="new_class_avg"></td>
                        <td><input type="button" value="Save" onclick="
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
            <tr> <td>  <!--Finally, Early Childhood Attendance-->
                    <h4>Early Childhood Attendance</h4>

                    <table class="inner_table">
    <?php
    //get dates
    $date_query_sqlsafe = "SELECT Date_ID, Date FROM Program_Dates WHERE Program_Id='" . mysqli_real_escape_string($_GET['id']) . "'";
    include "../include/dbconnopen.php";
    $program_dates = mysqli_query($cnnTRP, $date_query_sqlsafe);
    while ($date = mysqli_fetch_row($program_dates)) {
        $format_date = explode('-', $date[1]);
        $date_formatted = $format_date[1] . '/' . $format_date[2] . '/' . $format_date[0];
        ?>
                            <tr><td><?php echo $date_formatted; ?></td><td><a class="helptext" href="javascript:;" onclick="$('#today_attendees_<?php echo $date[0] ?>').toggle();">Show/hide attendees</a>
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
                                        Add attendee: <?php $get_members_sqlsafe = "SELECT Participants_Programs.Participant_Id, First_Name, Last_Name FROM Participants_Programs
                                    INNER JOIN Participants ON Participants.Participant_Id=Participants_Programs.Participant_Id WHERE Program_ID='" . mysqli_real_escape_string($_GET['id']) . "'";
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
                            <td>Add Date: <input type="text" id="new_early_childhood_date" class="hasDatepickers no_view"></td>
                            <td><input type="button" value="Save Date" class="no_view" onclick="
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
    ?>
        <tr><td>Test.  This is where aggregated data would go.</td></tr>
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
                <td width="35%">
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
                                    <td><strong>First Name:</strong></td>
                                    <td><input type="text" id="name_search" style="width:100px;"/></td>
                                    <td><strong>Last Name:</strong></td>
                                    <td><input type="text" id="surname_search" style="width:100px;" /></td>
                                </tr>
                                <tr>
                                    <td><strong>DOB:</strong></td>
                                    <td><input type="text" id="dob_search" style="width:70px;" /></td>
                                    <td><strong>Gender:</strong></td>
                                    <td><select id="gender_search">
                                            <option value="">---------</option>
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align:center;"><input type="button" value="Search" onclick="
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
                <td colspan="2">

                    <!-- shows GPA and test scores: -->
                    <h4>Academic Records</h4>
                    <?php
                    $get_scores_sqlsafe = "SELECT AVG(Explore_Score_Pre) AS pre, AVG(Explore_Score_Mid) AS mid, AVG(Explore_Score_Post) AS post,
                                    AVG(Explore_Score_Fall) AS fall, AVG(Reading_ISAT) as reading, AVG(Math_ISAT) as math, School, School_Year FROM Explore_Scores
                                    WHERE Program_ID='" . mysqli_real_escape_string($_GET['id']) . "' GROUP BY School, School_Year";
                    // echo $get_scores_sqlsafe;
                    $scores = mysqli_query($cnnTRP, $get_scores_sqlsafe);
                    ?>
                    <table  class="gpa_isat_table">
                        <tr style="text-align:center;"><td></td><td colspan="4"><strong>Explore Scores</strong></td><td colspan="2"><strong>ISAT Scores</strong></td></tr>
                        <tr class="divider">
                            <td width="15%"><strong>Year</strong></td>
                            <td><strong>Pre-program average</strong></td>
                            <td><strong>Mid-program average</strong></td>
                            <td><strong>Post-program average</strong></td>
                            <td><strong>9th grade average</strong></td>
                            <td><strong>Reading</strong></td>
                            <td><strong>Math</strong></td>
                            <td><strong>Quarter</strong></td><td><strong>Average GPA</strong></td>
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
                                <td><?php $years = str_split($score['School_Year'], 2);
                            echo '20' . $years[0] . '-20' . $years[1];
                            ?></td>
                                <td><?php echo number_format($score['pre'], 2); ?></td>
                                <td><?php echo number_format($score['mid'], 2); ?></td>
                                <td><?php echo number_format($score['post'], 2); ?></td>
                                <td><?php echo number_format($score['fall'], 2); ?></td>
                                <td><?php echo number_format($score['reading'], 2); ?></td>
                                <td><?php echo number_format($score['math'], 2); ?></td>

                                <?php
                                $format_school_year = str_split($score['School_Year'], 2);
                                $format_year = '20' . $format_school_year[0] . '-' . $format_school_year[1];
                                $get_academic_info_by_program_sqlsafe = "SELECT AVG(GPA),  Quarter, School_Year, School
                                    FROM Academic_Info WHERE Program_ID='" . $program['Program_ID'] . "' AND School='" . $score['School'] . "'
                                        AND School_Year='" . $format_year . "' GROUP BY Quarter";
                                //  echo $get_academic_info_by_program_sqlsafe;
                                $academic_program = mysqli_query($cnnTRP, $get_academic_info_by_program_sqlsafe);

                                $current_school = 0;
                                ?><td><?php
                                    while ($acade = mysqli_fetch_array($academic_program)) {
                                        echo $acade['Quarter'];
                                        ?><br>
            <?php }
        ?></td><?php
        $academic_program = mysqli_query($cnnTRP, $get_academic_info_by_program_sqlsafe);
        ?>
                                <!-- quarters will stay with the year, which is why this while has to be nested.
                                --> 
                                <td><?php
                                    while ($acade = mysqli_fetch_array($academic_program)) {
                                        echo number_format($acade['AVG(GPA)'], 2);
                                        ?>
                                        <!--<td><?php
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
            <tr><td></td>
                <td style="padding:15px;">

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
                        <tr class="divider"><td><strong>Quarter/Year</strong></td><td><strong>Average Tardies</strong></td><td><strong>Average Excused Absences</strong></td><td><strong>Average Unexcused Absences</strong></td></tr>

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
                            <tr><td><?php echo $acade['Quarter'] . '/' . $acade['School_Year']; ?></td>
                                <td><?php echo number_format($acade['tardies'], 2); ?></td>
                                <td><?php echo number_format($acade['excused'], 2); ?></td>
                                <td><?php echo number_format($acade['skipped'], 2); ?></td>
                            </tr>
        <?php
    }
    ?></table><br/><br/>
                </td>
            </tr>
            <tr><td colspan="3">

                    <!-- upload space for program notes: -->
                    <h4>Upload Notes</h4>
                    <div style="margin-left:auto;margin-right:auto;width:50%;"><span class="helptext">Uploaded information will be saved in the system as a supporting document for this program.
                        </span><br>


                        <?php
                        $get_uploads_sqlsafe = "SELECT Upload_Id, File_Name FROM Programs_Uploads WHERE Program_ID='" . mysqli_real_escape_string($_GET['id']) . "'";
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
        WHERE Program_Id='" . mysqli_real_escape_string($_GET['id']) . "'  ORDER BY School_Name";
                        include "../include/dbconnopen.php";
                        $notes = mysqli_query($cnnTRP, $get_notes_sqlsafe);
                        while ($note = mysqli_fetch_row($notes)) {
                            ?>
                            <tr><td><?php echo $note[0] . '/' . $note[1] . '/' . $note[2]; ?></td>
                                <td><?php echo $note[3]; ?></td>
                                <td><?php echo $note[5]; ?></td>
                                <td><?php echo $note[4]; ?></td>
                            </tr>
        <?php
    }
    // include "../include/dbconnclose.php";
    ?>
                        <!--Add new note-->
                        <tr><td colspan="2">New note:<br>
                                <span class="helptext">Note will save automatically once you click away from the text entry box.  <br>
                                    You must choose a school before entering the note for the school to save correctly.</span>
                            </td>
                            <td><select id="school_new_note">
                                    <option value="">-----</option>
                                    <?php
                                    $select_schools_sqlsafe = "SELECT * FROM Schools ORDER BY School_Name";
                                    include "../include/dbconnopen.php";
                                    $schools = mysqli_query($cnnTRP, $select_schools_sqlsafe);
                                    while ($school = mysqli_fetch_row($schools)) {
                                        ?>
                                        <option value="<?php echo $school[0]; ?>"><?php echo $school[1]; ?></option>
                                    <?php
                                }
                                ?>
                                </select></td>
                            <td><textarea onblur="
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
                <td>
                    <!-- list of people enrolled in this program: -->
                    <h4>Program Enrollment</h4>
                    <div class="add_participant">
                        <a href="javascript:;" onclick="
                                $('#search_to_add_participant').slideToggle();
                           " style="font-size:.8em;" class="no_view">Add a new participant...</a>
                        <div id="search_to_add_participant">
                            <table class="search_table">
                                <tr>
                                    <td><strong>First Name:</strong></td>
                                    <td><input type="text" id="name_search" style="width:100px;"/></td>
                                    <td><strong>Last Name:</strong></td>
                                    <td><input type="text" id="surname_search" style="width:100px;" /></td>
                                </tr>
                                <tr>
                                    <td><strong>DOB:</strong></td>
                                    <td><input type="text" id="dob_search" style="width:70px;" /></td>
                                    <td><strong>Gender:</strong></td>
                                    <td><select id="gender_search">
                                            <option value="">---------</option>
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align:center;"><input type="button" value="Search" onclick="
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
                <td>
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
    include "../include/dbconnopen.php";
    $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
    while ($enroll = mysqli_fetch_row($enrollment)) {
        ?>
                <tr><td><?php echo $enroll[0]; ?></td><td><?php echo $enroll[1]; ?></td>
                    <td><?php echo $enroll[2]; ?></td>
                    <td><input type="button" value="Delete"
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
    include "../include/dbconnclose.php";
    ?>
            <tr>
                <td><select id="month_elev8_select">
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
                <td><select id="year_elev8_select">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td><input type="text" id="enrollment_elev8_new" style="width:100px;">
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
                                                            include "../include/dbconnopen.php";
                                                            $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
                                                            while ($enroll = mysqli_fetch_row($enrollment)) {
                                                                ?>
                <tr><td><?php echo $enroll[0]; ?></td><td><?php echo $enroll[1]; ?></td>
                    <td><?php echo $enroll[2]; ?></td><td><input type="button" value="Delete"
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
    include "../include/dbconnclose.php";
    ?>
            <tr>
                <td><select id="month_elev8_select_2">
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
                <td><select id="year_elev8_select_2">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td><input type="text" id="enrollment_elev8_new_2" style="width:100px;">
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
                                                            include "../include/dbconnopen.php";
                                                            $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
                                                            while ($enroll = mysqli_fetch_row($enrollment)) {
                                                                ?>
                <tr><td><?php echo $enroll[0]; ?></td><td><?php echo $enroll[1]; ?></td>
                    <td><?php echo $enroll[2]; ?></td><td><input type="button" value="Delete"
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
    include "../include/dbconnclose.php";
    ?>
            <tr>
                <td><select id="month_elev8_select_3">
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
                <td><select id="year_elev8_select_3">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td><input type="text" id="enrollment_elev8_new_3" style="width:100px;">
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
                                                            include "../include/dbconnopen.php";
                                                            $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
                                                            while ($enroll = mysqli_fetch_row($enrollment)) {
                                                                ?>
                <tr><td><?php echo $enroll[0]; ?></td><td><?php echo $enroll[1]; ?></td>
                    <td><?php echo $enroll[2]; ?></td><td><input type="button" value="Delete"
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
    include "../include/dbconnclose.php";
    ?>
            <tr>
                <td><select id="month_elev8_select_4">
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
                <td><select id="year_elev8_select_4">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td><input type="text" id="enrollment_elev8_new_4" style="width:100px;">
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
                                                            include "../include/dbconnopen.php";
                                                            $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
                                                            while ($enroll = mysqli_fetch_row($enrollment)) {
                                                                ?>
                <tr><td><?php echo $enroll[0]; ?></td><td><?php echo $enroll[1]; ?></td>
                    <td><?php echo $enroll[2]; ?></td><td><input type="button" value="Delete"
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
    include "../include/dbconnclose.php";
    ?>
            <tr>
                <td><select id="month_elev8_select_5">
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
                <td><select id="year_elev8_select_5">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td><input type="text" id="enrollment_elev8_new_5" style="width:100px;">
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
                                                            include "../include/dbconnopen.php";
                                                            $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
                                                            while ($enroll = mysqli_fetch_row($enrollment)) {
                                                                ?>
                <tr><td><?php echo $enroll[0]; ?></td><td><?php echo $enroll[1]; ?></td>
                    <td><?php echo $enroll[2]; ?></td><td><input type="button" value="Delete"
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
    include "../include/dbconnclose.php";
    ?>
            <tr>
                <td><select id="month_elev8_select_6">
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
                <td><select id="year_elev8_select_6">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td><input type="text" id="enrollment_elev8_new_6" style="width:100px;">
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
                                                            include "../include/dbconnopen.php";
                                                            $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
                                                            while ($enroll = mysqli_fetch_row($enrollment)) {
                                                                ?>
                <tr><td><?php echo $enroll[0]; ?></td><td><?php echo $enroll[1]; ?></td>
                    <td><?php echo $enroll[2]; ?></td><td><input type="button" value="Delete"
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
    include "../include/dbconnclose.php";
    ?>
            <tr>
                <td><select id="month_elev8_select_7">
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
                <td><select id="year_elev8_select_7">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td><input type="text" id="enrollment_elev8_new_7" style="width:100px;">
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
                                                            include "../include/dbconnopen.php";
                                                            $enrollment = mysqli_query($cnnTRP, $enrollment_query_sqlsafe);
                                                            while ($enroll = mysqli_fetch_row($enrollment)) {
                                                                ?>
                <tr><td><?php echo $enroll[0]; ?></td><td><?php echo $enroll[1]; ?></td>
                    <td><?php echo $enroll[2]; ?></td><td><input type="button" value="Delete"
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
    include "../include/dbconnclose.php";
    ?>
            <tr>
                <td><select id="month_elev8_select_8">
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
                <td><select id="year_elev8_select_8">
                        <option value="">-----</option>
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                    </select></td>
                <td><input type="text" id="enrollment_elev8_new_8" style="width:100px;">
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
                <td width="35%">
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
                                    <td><strong>First Name:</strong></td>
                                    <td><input type="text" id="name_search" style="width:100px;"/></td>
                                    <td><strong>Last Name:</strong></td>
                                    <td><input type="text" id="surname_search" style="width:100px;" /></td>
                                </tr>
                                <tr>
                                    <td><strong>DOB:</strong></td>
                                    <td><input type="text" id="dob_search" style="width:70px;" /></td>
                                    <td><strong>Gender:</strong></td>
                                    <td><select id="gender_search">
                                            <option value="">---------</option>
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align:center;"><input type="button" value="Search" onclick="
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
                                    $date_query_sqlsafe = "SELECT Date_ID, Date FROM Program_Dates WHERE Program_Id='" . mysqli_real_escape_string($_GET['id']) . "'";
                                    $program_dates = mysqli_query($cnnTRP, $date_query_sqlsafe);
                                    while ($date = mysqli_fetch_row($program_dates)) {
                                        $format_date = explode('-', $date[1]);
                                        $date_formatted = $format_date[1] . '/' . $format_date[2] . '/' . $format_date[0];
                                        ?>
                            <tr><td><?php echo $date_formatted; ?></td><td><a class="helptext" href="javascript:;" onclick="$('#today_attendees_<?php echo $date[0] ?>').toggle();">Show/hide attendees</a>
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
                                    INNER JOIN Participants ON Participants.Participant_Id=Participants_Programs.Participant_Id WHERE Program_ID='" . mysqli_real_escape_string($_GET['id']) . "'";
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
                            <td>Add Date: <input type="text" id="new_early_childhood_date" class="hasDatepickers no_view"></td>
                            <td><input type="button" value="Save Date" class="no_view" onclick="
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
                <td>

                    <!-- test scores for people in this program. -->	
                    <h4>GPA and ISAT Scores</h4>
    <?php
    $get_academic_info_by_program_sqlsafe = "SELECT AVG(GPA), AVG(ISAT_Math), AVG(ISAT_Reading), Quarter, School_Year
                                    FROM Academic_Info WHERE Program_ID='" . $program['Program_ID'] . "' GROUP BY Quarter";
    // echo $get_academic_info_by_program_sqlsafe;
    $academic_program = mysqli_query($cnnTRP, $get_academic_info_by_program_sqlsafe);
    ?><table class="gpa_isat_table">
                        <tr class="divider"><td><strong>Quarter/Year</strong></td><td><strong>Average GPA/<strong></td><td><strong>Average ISAT Math</strong></td>
                            <td><strong>Average ISAT Reading</strong></td><td><strong>Average ISAT Total</strong></td><!--<th>Number of Participants Counted</th>--></tr>

                                            <?php
                                            while ($acade = mysqli_fetch_array($academic_program)) {
                                                ?>
                                            <tr><td><?php echo $acade['Quarter'] . '/' . $acade['School_Year']; ?></td>
                                                <td><?php echo number_format($acade['AVG(GPA)'], 2); ?></td>
                                                <td><?php echo number_format($acade['AVG(ISAT_Math)']); ?></td>
                                                <td><?php echo number_format($acade['AVG(ISAT_Reading)']); ?></td>
                                                <td></td>
                                                <!--<td><?php
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
                                    include "../include/dbconnopen.php";
                                    $surveys = mysqli_query($cnnTRP, $get_surveys_sqlsafe);
                                        ?><table class="inner_table">
                                            <tr><th>Pre or Post</th><th>Date Completed</th><th>Participant?<br>(do we want to show this?)</th></tr>
                                        <?php
                                        while ($survey = mysqli_fetch_array($surveys)) {
                                            ?>
                                                <tr><td><?php echo $survey['Pre_Post']; ?></td><td><?php echo $survey['Date']; ?></td><td></td></tr>
                                            <?php
                                        }
                                        ?></table><?php include "../include/dbconnclose.php"; ?>
                                        <br/><br/>
                                        <h4>Cultural Identity Surveys</h4>
                                        <?php
                                        $get_pre_surveys_sqlsafe = "SELECT AVG(Q1), AVG(Q2), AVG(Q3), AVG(Q4), AVG(Q5), AVG(Q6), AVG(Q7),
                                    AVG(Q8), AVG(Q9), AVG(Q10), AVG(Q11)
                                    FROM NMMA_Identity_Survey
                                    WHERE Pre_Post='pre';";
                                        include "../include/dbconnopen.php";
                                        $pre_surveys = mysqli_query($cnnTRP, $get_pre_surveys_sqlsafe);
                                        $pre = mysqli_fetch_row($pre_surveys);
                                        $get_post_surveys_sqlsafe = "SELECT AVG(Q1), AVG(Q2), AVG(Q3), AVG(Q4), AVG(Q5), AVG(Q6), AVG(Q7),
                                    AVG(Q8), AVG(Q9), AVG(Q10), AVG(Q11)
                                    FROM NMMA_Identity_Survey
                                    WHERE Pre_Post='post';";
                                        include "../include/dbconnopen.php";
                                        $post_surveys = mysqli_query($cnnTRP, $get_post_surveys_sqlsafe);
                                        $post = mysqli_fetch_row($post_surveys);
                                        ?>-->

                                        <br/><br/>
                                        <h4>Surveys</h4>
                                        <table id="nmma_survey_summary">
                                            <tr><th></th><th width="15%">Pre-Program Average</th><th width="15%">Post-Program Average</th></tr>
                                            <tr class="divider"><td colspan="3"><strong>Cultural Identity Survey</strong></td></tr>
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
                                                    <td class="q">
                                                        <strong><?php echo $question_number; ?>: </strong> <?php echo $id_questions[$q]; ?>
                                                    </td>
                                                    <td>
                                                <?php echo number_format($pre[$q], 1); ?>
                                                    </td>
                                                    <td>
                                                <?php echo number_format($post[$q], 1); ?>
                                                    </td>
                                                </tr>	
                                                <?php
                                            }
                                            ?>
                                                    <!--<tr class="divider"><td colspan="3"><strong>Cultural Traditions Survey</strong><br/> <span style="color:#990000;font-weight:bold;">Need to determine how to show this in the aggregate (responses are text-based).</span></td></tr>
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
                                                        <td class="q"><strong><?php echo $question_number; ?>: </strong> <?php echo $traditions_questions[$q]; ?></td>
                                                        <td>
                                                                
                                                        </td>
                                                        <td>
                                                                
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
                    <td style="width: 400px;">
                    <!-- Sessions -->
                    <h4>Add New Session</h4>
                    <table class="inner_table" style="width: 250px;">
                        <tr>
                            <td>
                                <strong>Name:</strong>
                            </td>
                            <td>
                                <input name="new_session_name" id="new_session_name" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Start Date:</strong>
                            </td>
                            <td>
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
                            <td>
                                <strong>End Date:</strong>
                            </td>
                            <td>
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
                            <td colspan="2" style="text-align: center;">
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
        <td>
                    
                    <h4>Sessions</h4>
                    <script>
                        var programParticipants = [
                        <?php
                        include '../include/dbconnopen.php';
                        $program_participants = mysqli_query($cnnTRP, "SELECT * FROM Participants_Programs
                                                                INNER JOIN Participants ON Participants_Programs.Participant_ID = Participants.Participant_ID
                                                                WHERE Program_ID = '" . $program['Program_ID'] . "'
                                                                ORDER BY Participants.Last_Name");
                        include '../include/dbconnclose.php';

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
                                                Program_ID = " . mysqli_real_escape_string($_GET['id']) . ";";
                    include "../include/dbconnopen.php";
                    $all_program_sessions = mysqli_query($cnnTRP, $all_program_sessions_sqlsafe);
                    include "../include/dbconnclose.php";
                    
                    while($program_session = mysqli_fetch_assoc($all_program_sessions)) {
                        ?>
                        <table class="inner_table" style="width: 80%;">
                            <tr>
                                <td style="font-size: 13px;">
                                    <?php echo $program_session['Session_Name']; ?>
                                </td>
                                <td style="font-size: 13px;">
                                    (<?php echo $program_session['Start_Date']; ?> -
                                    <?php echo $program_session['End_Date']; ?>)
                                </td>
                                <td>
                                    <a href="javascript:;" onclick="$('#program_session_edit_<?php echo $program_session['Session_ID']; ?>').toggle();" style="font-size: 13px;">Edit Session</a>
                                </td>
                                <td>
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
                                <td style="font-size: 13px;">
                                    <input name="session_name_<?php echo $program_session['Session_ID']; ?>" id="session_name_<?php echo $program_session['Session_ID']; ?>" value="<?php echo $program_session['Session_Name']; ?>" />
                                </td>
                                <td style="font-size: 13px;">
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
                                <td>
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
                            include "../include/dbconnopen.php";
                            $all_session_participants = mysqli_query($cnnTRP, $all_session_participants_sqlsafe);
                            include "../include/dbconnclose.php";

                            while($session_participant = mysqli_fetch_assoc($all_session_participants)) {
                                ?>
                                <tr id="session_participant_<?php echo $program_session['Session_ID']; ?>_<?php echo $session_participant['Participant_ID']; ?>">
                                    <td style="font-size: 13px;" colspan="2">
                                        <a href="../participants/profile.php?id=<?php echo $session_participant['Participant_ID']; ?>"><?php echo $session_participant['Last_Name']; ?>, <?php echo $session_participant['First_Name']; ?></a>
                                    </td>
                                    <td style="font-size: 13px;">
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
                                    <td>
                                        
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
//include "../include/dbconnclose.php";
include "../../footer.php";
?>
	