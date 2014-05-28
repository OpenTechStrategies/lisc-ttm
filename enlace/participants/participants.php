<?php
include "../../header.php";
include "../header.php";
?>
<!--Search participants and add a new participant (at bottom).-->

<div style="display:none"><?php include "../include/datepicker_wtw.php"; ?></div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#participants_selector').addClass('selected');
        $('#ajax_loader').hide();
        $('#add_new').hide();
        $('#first_name_search').focus();
    });

    $(document).ajaxStart(function() {
        $('#ajax_loader').fadeIn('slow');
    });

    $(document).ajaxStop(function() {
        $('#ajax_loader').fadeOut('slow');
    });
</script>

<div class="content_block">
    <h3>Participants</h3><hr/><br/>

    <div id="enlace_participants">

        <!--basic search table.  see /ajax/search_participants.-->
        <h4>Search Participants</h4>
        <table class="search_table">
            <tr>
                <td class="all_projects"><strong>First Name: </strong></td>
                <td class="all_projects"><input type="text" id="first_name_search" style="width:125px;"/></td>
                <td class="all_projects"><strong>Last Name: </strong></td>
                <td class="all_projects"><input type="text" id="last_name_search" style="width:125px;" /></td>
            </tr>
            <tr>
                <td class="all_projects"><strong>Role: </strong></td>
                <td class="all_projects"><select id="role_search">
                        <option value="">--------</option>
                        <?php
                        $get_roles = "SELECT * FROM Roles";
                        include "../include/dbconnopen.php";
                        $roles = mysqli_query($cnnEnlace, $get_roles);
                        while ($role = mysqli_fetch_array($roles)) {
                            ?>
                            <option value="<?php echo $role['Role_ID']; ?>"><?php echo $role['Role']; ?></option>
                            <?php
                        }
                        include "../include/dbconnclose.php";
                        ?>
                    </select>
                </td>
                <td class="all_projects"><strong>Gender: </strong></td>
                <td class="all_projects"><select id="gender_search">
                        <option value="">--------</option>
                        <option value="m">Male</option>
                        <option value="f">Female</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="all_projects"><strong>Date of Birth: </strong></td>
                <td class="all_projects"><input type="text" id="dob_search" class="addDP" /></td>
                <td class="all_projects"><strong>Grade Level: </strong></td>
                <td class="all_projects"><select id="grade_search">
                        <option value="">--------</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </td>
            </tr>
            <tr>
                <!--Searches on program, NOT on session.-->
                <td class="all_projects"><strong>Program Enrolled In:</strong></td><td class="all_projects"><select id="program_search">
                        <option value="0">-----</option>
                        <?php
                        $get_all_programs = "SELECT Program_ID, Name FROM Programs ORDER BY Name";
                        include "../include/dbconnopen.php";
                        $all_programs = mysqli_query($cnnEnlace, $get_all_programs);
                        while ($program = mysqli_fetch_row($all_programs)) {
                            ?>
                            <option value="<?php echo $program[0];?>"><?php echo $program[1]; ?></option>
                            <?php
                        }
                        include "../include/dbconnclose.php";
                        ?>
                    </select></td>
                <td class="all_projects"><strong>Database ID: </strong></td>
                <td class="all_projects">
                    <input type="text" id="search_id">
                </td>
            </tr>
            <tr>
                <td class="all_projects" colspan="4" style="text-align:center;">
                    <input type="button" value="Search" onclick="
                            $.post(
                                    '/enlace/ajax/search_participants.php',
                                    {
                                        first: document.getElementById('first_name_search').value,
                                        last: document.getElementById('last_name_search').value,
                                        dob: document.getElementById('dob_search').value,
                                        grade: document.getElementById('grade_search').value,
                                        gender: document.getElementById('gender_search').options[document.getElementById('gender_search').selectedIndex].value,
                                        role: document.getElementById('role_search').options[document.getElementById('role_search').selectedIndex].value,
                                        program: document.getElementById('program_search').value,
                                        id: document.getElementById('search_id').value
                                                //inst: document.getElementById('institution_search').value
                                    },
                            function(response) {
                                document.getElementById('show_results').innerHTML = response;
                            });"/>
                </td>
            </tr>
        </table>
        <!--Shows results and makes them sortable.  See /ajax/search_participants -->
        <div id="show_results"></div>
        <br/><br/>

        <!--Add a new person: 
        Needs a correctly-formatted date of birth or no DOB.
        Role is required.
        -->
        <h4 onclick="$('#add_new').slideToggle();" style="cursor:pointer;">Add New Participant...</h4>
        <div id="add_new">
            <table class="search_table" style="border:2px solid #696969;">
                <tr>
                    <td><strong>First Name: </strong></td>
                    <td><input type="text" id="name_new"  style="width:125px;"/></td>
                    <td><strong>Last Name: </strong></td>
                    <td><input type="text" id="surname_new"  style="width:125px;"/></td>
                </tr>
                <tr>
                    <td><strong>Date of Birth: </strong></td>
                    <td><input type="text" id="dob_new" class="addDP" /></td>
                    <td><strong>Age: </strong></td>
                    <td><input type="text" id="age_new"  style="width:25px;"/>&nbsp;&nbsp;<span class="helptext">If date of birth is not available</span></td>
                </tr>
                <tr>
                    <td><strong>Daytime Phone: </strong></td>
                    <td><input type="text" id="day_phone_new"  style="width:100px;"/></td>
                    <td><strong>Evening Phone: </strong></td>
                    <td><input type="text" id="evening_phone_new"  style="width:100px;"/></td>
                </tr>
                <tr>
                    <td><strong>Grade Level: </strong></td>
                    <td><select id="grade_new">
                            <option value="">----</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </td>
                    <td><strong>Gender: </strong></td>
                    <td><select id="gender_new">
                            <option value="">----</option>
                            <option value="m">Male</option>
                            <option value="f">Female</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>School: </strong></td>
                    <td><select id="school_new">
                            <option value="">--------</option>
                            <?php
                            $get_schools = "SELECT * FROM Institutions WHERE Institution_Type='1' ORDER BY Institution_Name";
                            include "../include/dbconnopen.php";
                            $schools = mysqli_query($cnnEnlace, $get_schools);
                            while ($school = mysqli_fetch_array($schools)) {
                                ?>
                                <option value="<?php echo $school['Inst_ID'];?>"><?php echo $school['Institution_Name']; ?></option>
                                <?php
                            }
                            include "../include/dbconnclose.php";
                            ?>
                        </select>
                    </td>
                    <td><strong>Role: </strong><span class="helptext">(required)</span></td>
                    <td><select id="role_new">
                            <option value="">--------</option>
                            <?php
                            $get_roles = "SELECT * FROM Roles";
                            include "../include/dbconnopen.php";
                            $roles = mysqli_query($cnnEnlace, $get_roles);
                            while ($role = mysqli_fetch_array($roles)) {
                                ?>
                                <option value="<?php echo $role['Role_ID']; ?>"><?php echo $role['Role']; ?></option>
                                <?php
                            }
                            include "../include/dbconnclose.php";
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:center;"><input type="button" onclick="
                            var x = document.getElementById('dob_new').value;
                            if (x != '') {
                                var firstslash = x.indexOf('/');
                                var lastslash = x.lastIndexOf('/');
                                var firstdash = x.indexOf('-');
                                var lastdash = x.lastIndexOf('-');
                                // alert('open: '+firstdash+' close: '+lastdash);
                                if ((firstslash != 2 && lastslash != 5) && (firstdash != 4 && lastdash != 7))
                                {
                                    alert('Not a valid date of birth');
                                    return false;
                                }
                            }
                            var role = document.getElementById('role_new').value;
                            if (role == '') {
                                alert('You have not entered a role for this participant.  Please enter a role for this participant and then hit Save again.');
                                return false;
                            }
                            $.post(
                                    '../ajax/add_participant.php',
                                    {
                                        first_name: document.getElementById('name_new').value,
                                        last_name: document.getElementById('surname_new').value,
                                        dob: document.getElementById('dob_new').value,
                                        age: document.getElementById('age_new').value,
                                        day_phone: document.getElementById('day_phone_new').value,
                                        evening_phone: document.getElementById('evening_phone_new').value,
                                        grade: document.getElementById('grade_new').value,
                                        gender: document.getElementById('gender_new').value,
                                        school: document.getElementById('school_new').value,
                                        role: document.getElementById('role_new').value
                                    },
                            function(response) {
                                document.getElementById('confirmation').innerHTML = response;
                            }
                            );" value="Save" /></td>
                </tr>
            </table>
            <div id="confirmation" style="text-align:center;"></div>
        </div>
    </div>

</div>
<br/><br/>
<?php
include "../../footer.php";
?>