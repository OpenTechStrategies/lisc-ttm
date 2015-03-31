<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
user_enforce_has_access($SWOP_id);

setcookie("new_pool", '', time() - 7200, '/');
include "../../header.php";
include "../header.php";
include "../include/datepicker_simple.php";
?>

<!-- 
Homepage for participants.  Link to add a new participant, search for participants.
-->

<script type="text/javascript">
    $(document).ready(function() {
        var has_organizer = '0';
        $('#participants_selector').addClass('selected');
<?php
if ($_GET['new'] == 1) {
    ?>
            $('#participant_search').hide();
            $('#add_participant').show();
    <?php
} else {
    ?>
            $('#participant_search').show();
            $('#add_participant').hide();
    <?php
}
?>
        $('#participants_selector').addClass('selected');
        $('#participant_profile').hide();
        $('#pool_member_profile').hide();
        $("a.add_new").hover(function() {
            $(this).addClass("selected");
        }, function() {
            $(this).removeClass("selected");
        });
    });</script>


<div class="content_block">


    <div id="participant_search" class="content_block">
        <h3>Participants</h3><hr/><br/>

        <!-- Link to show the add new person div: -->
        <div style="text-align:center;font-size:.9em;">
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
<a class="add_new" onclick="
                $('#participant_search').hide();
                $('#add_participant').show();">
<span class="add_new_button">Add New Participant</span></a>
<?php
} //end access check
?>
</div><br/>


        <!-- find people: -->
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
                <td><input type="text" id="dob_search" class="hasDatepickers"/></td>
                <td><strong>Gender:</strong></td>
                <td><select id="gender_search">
                        <option value="">---------</option>
                        <option value="m">Male</option>
                        <option value="f">Female</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong>Primary Organizer:</strong></td>
                <td><select id="organizer_search">
                        <option value="">-----</option>
                        <?php
                        $get_primarys_sqlsafe = "SELECT 
                                Organizer_Info.Participant_ID, Organizer_Info.Name_First, Organizer_Info.Name_Last
                                FROM Participants INNER JOIN 
                                Participants AS Organizer_Info ON Participants.Primary_Organizer = Organizer_Info.Participant_ID
                                GROUP BY Organizer_Info.Participant_ID ORDER BY Organizer_Info.Name_Last;";
                        include "../include/dbconnopen.php";
                        $primarys = mysqli_query($cnnSWOP, $get_primarys_sqlsafe);
                        while ($primary = mysqli_fetch_array($primarys)) {
                            ?>
                            <option value="<?php echo $primary['Participant_ID']; ?>"><?php echo $primary['Name_First'] . " " . $primary['Name_Last']; ?></option>
                            <?php
                        }
                        include "../include/dbconnclose.php";
                        ?>

                    </select></td>
                <td><strong>Primary Institution:</strong></td>
                <td><select id="institution_search">
                        <option value="">-----</option>
                        <?php
                        $get_institutions_sqlsafe = "SELECT * FROM Institutions ORDER BY Institution_Name";
                        include "../include/dbconnopen.php";
                        $institutions = mysqli_query($cnnSWOP, $get_institutions_sqlsafe);
                        while ($institution = mysqli_fetch_array($institutions)) {
                            ?>
                            <option value="<?php echo $institution['Institution_ID']; ?>"><?php echo $institution['Institution_Name']; ?></option>
                            <?php
                        }
                        include "../include/dbconnclose.php";
                        ?>
                    </select></td>

            </tr>
            <tr><td><strong>Active Pool Member:</strong></td>
                <td><select id="pool_active_search">
                        <option value="">-----</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select></td>
            </tr>
            <tr>
                <td colspan="4"><input type="button" value="Search" onclick="
                        $.post(
                                '../ajax/search_users.php',
                                {
                                    first: document.getElementById('name_search').value,
                                    last: document.getElementById('surname_search').value,
                                    dob: document.getElementById('dob_search').value,
                                    gender: document.getElementById('gender_search').value,
                                    organizer: document.getElementById('organizer_search').value,
                                    inst: document.getElementById('institution_search').value,
                                    active_pool: document.getElementById('pool_active_search').value
                                },
                        function(response) {
                            //document.write(response);
                            document.getElementById('show_trp_results').innerHTML = response;
                        }
                        ).fail(failAlert);"/></td>
            </tr>
        </table>
        <!-- Participant search results: -->
        <div id="show_trp_results"></div>
    </div>

</div>


<div id="add_participant" class="content_block">
    <?php
    include "add_participant.php";
    ?>
</div>

<?php //include "participant_profile.php"; ?>
<?php //include "pool_profile.php"; ?>

<br/><br/>

<?php
include "../../footer.php";
?>
