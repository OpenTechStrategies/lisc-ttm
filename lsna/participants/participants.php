<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id);

include "../../header.php";
include "../header.php";
include "../include/datepicker.php";

/* participant home page, includes search and link to add new participants */
?> 

<script type="text/javascript">
    $(document).ready(function() {
        $('#participants_selector').addClass('selected');
        $("a.add_new").hover(function() {
            $(this).addClass("selected");
        }, function() {
            $(this).removeClass("selected");
        });
        $('#participant_search_div').show();
        $('#new_participant_div').hide();
        $('#participant_profile_div').hide();
        $('#add_buttons').hide();
    });
    $(document).ready(function() {
        $('#ajax_loader').hide();
    });

    $(document).ajaxStart(function() {
        $('#ajax_loader').fadeIn('slow');
    });

    $(document).ajaxStop(function() {
        $('#ajax_loader').fadeOut('slow');
    });
</script>

<div class="content_block" id="participant_search_div">
    <h3>Participants</h3><hr/><br/>

    
<?php
        if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<div style="text-align:center;" ><a class="add_new" href="new_participant.php"><span class="add_new_button">Add New Participant</span></a></div><br/>
<?php
        }
?>
    <!--search participants: -->
    <h4>Search All Participants</h4>
    <table class="search_table">
        <tr>
            <td class="all_projects"><strong>First Name: </strong></td>
            <td class="all_projects"><input type="text" id="first_name" /></td>
            <td class="all_projects"><strong>Role: </strong></td>
            <td class="all_projects"><select id="role">
                    <option value="">--------</option>
                    <?php
                    $get_roles = "SELECT * FROM Roles";
                    include "../include/dbconnopen.php";
                    $roles = mysqli_query($cnnLSNA, $get_roles);
                    while ($role = mysqli_fetch_array($roles)) {
                        ?>
                        <option value="<?php echo $role['Role_ID']; ?>"><?php echo $role['Role_Title']; ?></option>
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="all_projects"><strong>Last Name: </strong></td>
            <td class="all_projects"><input type="text" id="last_name" /></td>
            <td class="all_projects"><strong>Gender: </strong></td>
            <td class="all_projects"><select id="gender">
                    <option value="">--------</option>
                    <option value="m">Male</option>
                    <option value="f">Female</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="all_projects"><strong>Date of Birth: </strong></td>
            <td class="all_projects"><input type="text" id="dob" class="hadDatepicker" /></td>
            <td class="all_projects"><strong>Grade Level: </strong></td>
            <td class="all_projects"><select id="grade">
                    <option value="">--------</option>
                    <option value="k">Kindergarten</option>
                    <option value="1">1st Grade</option>
                    <option value="2">2nd Grade</option>
                    <option value="3">3rd Grade</option>
                    <option value="4">4th Grade</option>
                    <option value="5">5th Grade</option>
                    <option value="6">6th Grade</option>
                </select>
            </td>
        </tr>
        <tr><td class="all_projects"><strong>Is Parent Mentor:</strong></td><td class="all_projects"><select id="pm_check"><option value="">-----</option>
                    <option value="1">Yes</option>
                    <option value="2">No</option>
                </select></td>
            <!-- Note that selecting a parent mentor year will select only parent mentors.  That is,
            selecting any parent mentor year and is parent mentor (yes) will yield the same results
            as selecting any parent mentor year and leaving is_parent_mentor blank. -->

            <td class="all_projects"><strong>Parent Mentor Year:</strong></td>
            <td class="all_projects"><select id="search_year"><option value="">------</option>

                    <option value="1011" >2010-11</option>
                    <option value="1112" >2011-12</option>
                    <option value="1213" >2012-13</option>
                    <option value="1314" >2013-14</option>
                    <option value="1415" >2014-15</option>
                    <option value="1516" >2015-16</option>
                    <option value="1617" >2016-17</option>
                </select></td>
        </tr>
        <tr>
            <td colspan="4">
                
            </td>
        </tr>
        <tr>
            <td class="all_projects" colspan="4">
                <input type="button" value="Search" onclick="
                                $.post(
                                        '/lsna/ajax/search_participants.php',
                                        {
                                            first: document.getElementById('first_name').value,
                                            last: document.getElementById('last_name').value,
                                            dob: document.getElementById('dob').value,
                                            grade: document.getElementById('grade').value,
                                            gender: document.getElementById('gender').options[document.getElementById('gender').selectedIndex].value,
                                            role: document.getElementById('role').options[document.getElementById('role').selectedIndex].value,
                                            pm: document.getElementById('pm_check').value,
                                            year: document.getElementById('search_year').value
                                        },
                                function(response) {
                                    document.getElementById('show_results').innerHTML = response;
                                }
                                ).fail(failAlert);
                       "/>
            </td>
        </tr>
    </table>
    <div id="show_results"></div>

</div>

<?php
//include "new_participant.php";
//include "participant_profile.php"; 
?>
<br/><br/>
<?php include "../../footer.php"; ?>