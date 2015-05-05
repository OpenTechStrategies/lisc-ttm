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

?>
<?php
include "../../header.php";
include "../header.php";
include "../include/datepicker_simple.php";

/* participants home page: */
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#participants_selector').addClass('selected');
        $('#participant_search').show();
        $('#add_participant').hide();
        $("a.add_new").hover(function() {
            $(this).addClass("selected");
        }, function() {
            $(this).removeClass("selected");
        });
    });
</script>

<h3>Participants</h3><hr/><br/>
<div id="participant_search" class="content_block">
    <!-- Link to add a new participant: -->
<?php
    if ($USER->has_site_access($TRP_id, $DataEntryAccess)) {
?>
    <div style="text-align:center;font-size:.9em;"><a class="add_new" onclick="
            $('#participant_search').hide();
            $('#add_participant').show();
                                                      ">
<span class="add_new_button">Add New Participant</span></a></div><br/>
<?php
} // end access level check
?>
    <?php
    /* this was a list of all participants but is no longer available.  Too many people. */
    $get_participants = "SELECT * FROM Participants ORDER BY Last_Name";
    include "../include/dbconnopen.php";
    $participants = mysqli_query($cnnTRP, $get_participants);
    while ($participant = mysqli_fetch_array($participants)) {
        //echo "<a href='profile.php?id=" . $participant['Participant_ID'] . "'>" . $participant['First_Name'] . " " . $participant['Last_Name'] . "</a><br/>";
    }
    include "../include/dbconnclose.php";
    ?>
    <!-- Table of search terms for Enlace participants: -->
    <h4>Search Participants</h4>
    <table class="search_table">
        <tr>
            <td><strong>First Name:</strong></td>
            <td><input type="text" id="name_search" /></td>
            <td><strong>Last Name:</strong></td>
            <td><input type="text" id="surname_search" /></td>
        </tr>
        <tr>
            <td><strong>Date of Birth:</strong></td>
            <td><input type="text" id="dob_search" /></td>
            <td><strong>Gender:</strong></td>
            <td><select id="gender_search">
                    <option value="">---------</option>
                    <option value="m">Male</option>
                    <option value="f">Female</option>
                </select>
            </td>
        </tr>
        <!-- CPS ID is only for CPS students -->
        <tr><td><strong>CPS ID:</strong></td>
            <td><input type="text" id="cps_id_search" /></td>
<?php
    if ($USER->has_site_access($TRP_id, $DataEntryAccess)) {
?>
            <td><strong>Program:</strong></td>
            <td><select id="person_program_search">
            <option value="">-----</option>
<?php
$get_programs = "SELECT * FROM Programs";
include "../include/dbconnopen.php";
$programs = mysqli_query($cnnTRP, $get_programs);
while ($prog = mysqli_fetch_row($programs)) {
    ?>
    <option value="<?php echo $prog[0]; ?>"><?php echo $prog[1]; ?></option>
    <?php
}
include "../include/dbconnopen.php";
?>
        </select></td>
<?php
    } //end access check
?>
        </tr>
        <tr>
            <td colspan="4" style="text-align:center;"><input type="button" value="Search" onclick="
                    $('#ajax_loader').fadeIn('slow');
                    $.post(
                            '../ajax/search_users.php',
                            {
                                first: document.getElementById('name_search').value,
                                last: document.getElementById('surname_search').value,
                                dob: document.getElementById('dob_search').value,
                                gender: document.getElementById('gender_search').value,
                                cps_id: document.getElementById('cps_id_search').value,
                                program: document.getElementById('person_program_search').value
                            },
                    function(response) {
                       //document.write(response);
                        document.getElementById('show_trp_results').innerHTML = response;
                    }
                    ).fail(failAlert);
                    $('#ajax_loader').fadeOut('slow');
            "/></td>
        </tr>
    </table>
    <div id="show_trp_results"></div>
</div>

<div id="add_participant" class="content_block">
    <?php
    include "add_participant.php";
    ?>
</div>

<br/><br/>

<?php
include "../../footer.php";
?>
