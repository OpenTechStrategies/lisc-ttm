<?php
include "../../header.php";
include "../header.php";

include "../include/dbconnopen.php";
$inst_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_GET['inst']);
$get_inst_info = "SELECT Institutions.*, First_Name, Last_Name, Type FROM Institutions LEFT JOIN Institution_Types ON Institution_Type=Inst_Type_ID
    LEFT JOIN Participants ON Point_Person=Participant_ID
    WHERE Inst_ID='" . $inst_sqlsafe . "'";
$inst_info = mysqli_query($cnnEnlace, $get_inst_info);
$inst = mysqli_fetch_array($inst_info);
include "../include/dbconnclose.php";
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#institutions_selector').addClass('selected');
        $('.inst_edit').hide();
        $('#add_point_person').hide();
    });

</script>

<!--
Shows basic institution information
-->

<h3>Institution Profile: <?php echo $inst['Institution_Name']; ?></h3><hr/><br/>
<table class="profile_table" >
    <tr><td width="50%">
            <table class="inner_table" style="border: 2px solid #696969;">
                <tr><td>Type:</td><td><span class="inst_display"><?php echo $inst['Type']; ?></span>
                        <select id="new_inst_type" class="inst_edit">
                            <option value="">-----</option>
                            <?php
                            $get_types = "SELECT * FROM Institution_Types ORDER BY Type";
                            include "../include/dbconnopen.php";
                            $types = mysqli_query($cnnEnlace, $get_types);
                            while ($type = mysqli_fetch_array($types)) {
                                ?>
                                <option value="<?php echo $type['Inst_Type_ID']; ?>" <?php echo($type['Inst_Type_ID'] == $inst['Institution_Type'] ? "selected='selected'" : null); ?>><?php echo $type['Type']; ?></option>
                                <?php
                            }
                            include "../include/dbconnclose.php";
                            ?>
                        </select></td></tr>
                <tr><td>Address:</td><td><span class="inst_display"><?php echo $inst['Address_Num'] . " " . $inst['Address_Dir'] . " " . $inst['Address_Street']
                            . " " . $inst['Address_Street_Type'];
                            ?></span><span class="inst_edit"><input id="st_num_new" style="width:40px;" value="<?php echo $inst['Address_Num']; ?>"/> 
                            <input id="st_dir_new" style="width:20px;"  value="<?php echo $inst['Address_Dir']; ?>"/> 
                            <input id="st_name_new"  style="width:100px;" value="<?php echo $inst['Address_Street']; ?>"/> 
                            <input id="st_type_new" style="width:35px;" value="<?php echo $inst['Address_Street_Type']; ?>"/> <br>
                            <span class="helptext">e.g. 2756 S Harding Ave</span></span></td></tr>
                <tr><td>Point Person:</td><td>
                        <!--Search here for a point person.  This person must already exist in the database!
                        -->
                        <span><?php echo $inst['First_Name'] . " " . $inst['Last_Name']; ?></span>
                        <br>  <a href="javascript:;" onclick="$('#add_point_person').toggle();" class="helptext inst_edit">Search for point person</a>
                        <div id="add_point_person" style="border:1px solid #696969;">
                            <table id="search_parti_table" style="font-size:.9em;">
                                <tr>
                                    <td><strong>First Name: </strong></td>
                                    <td><input type="text" id="first_name_search" style="width:80px;"/></td>
                                    <td><strong>Last Name: </strong></td>
                                    <td><input type="text" id="last_name_search" style="width:80px;" /></td>
                                </tr>
                                <tr>
                                    <td><strong>Date of Birth: </strong></td>
                                    <td><input type="text" id="dob_search" class="addDP" style="width:80px;" /></td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align:center;" class="blank">
                                        <input type="button" value="Search" onclick="
                            $.post(
                                    '/enlace/ajax/search_participants.php',
                                    {
                                        result: 'dropdown',
                                        first: document.getElementById('first_name_search').value,
                                        last: document.getElementById('last_name_search').value,
                                        dob: document.getElementById('dob_search').value
                                                //grade: document.getElementById('grade_search').value
                                    },
                            function(response) {
                                document.getElementById('show_results').innerHTML = response;
                            });"/><div id="show_results"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td></tr>
                <tr><td>Contact Phone:</td><td><span class="inst_display"><?php echo $inst['Phone']; ?></span>
                        <input type="text" class="inst_edit" id="new_phone" value="<?php echo $inst['Phone']; ?>"></td></tr>
                <tr><td>Contact Email:</td><td><span class="inst_display"><?php echo $inst['Email']; ?></span>
                        <input type="text" class="inst_edit" id="new_email" value="<?php echo $inst['Email']; ?>"></td></tr>
                <tr><td><a href="javascript:;" onclick="$('.inst_edit').toggle();
            $('.inst_display').toggle();">Edit</a></td>
                    <td><a href="javascript:;" class="inst_edit" onclick="
                if (document.getElementById('relative_search')) {
                    var pointee = document.getElementById('relative_search').value;
                }
                else {
                    var pointee = '<?php echo $inst['Point_Person'] ?>';
                }
                $.post(
                        '../ajax/edit_inst.php',
                        {
                            inst_id: '<?php echo $inst['Inst_ID']; ?>',
                            type: document.getElementById('new_inst_type').value,
                            num: document.getElementById('st_num_new').value,
                            dir: document.getElementById('st_dir_new').value,
                            street: document.getElementById('st_name_new').value,
                            suffix: document.getElementById('st_type_new').value,
                            point: pointee,
                            phone: document.getElementById('new_phone').value,
                            email: document.getElementById('new_email').value
                        },
                function(response) {
                    //document.write(response);
                    window.location = 'inst_profile.php?inst=<?php echo $inst['Inst_ID']; ?>';
                }
                )">Save</a></td></tr>
            </table>   

            <!--
            List of all related programs.  can't add new programs here.
            -->

        </td><td><div style="margin-left:50px;"><h4>Related Programs</h4>
                <?php
                //get all programs administered by this institution
                include "../include/dbconnopen.php";
                $get_progs = "SELECT Program_ID, Name FROM Programs WHERE Host='" . $inst['Inst_ID'] . "'";
                $programs = mysqli_query($cnnEnlace, $get_progs);
                while ($prog = mysqli_fetch_row($programs)) {
                    ?><a href="javascript:;" onclick="$.post(
                        '../ajax/set_program_id.php',
                        {
                            page: 'profile',
                            id: '<?php echo $prog[0]; ?>'
                        },
                function(response) {
                    window.location = '../programs/profile.php';
                }
                )"><?php echo $prog[1]; ?></a><br><?php
                   }
                   include "../include/dbconnclose.php";
                   ?><br/><br/>

                <!--
                List of all related campaigns.  can't add new campaigns here.
                -->

                <h4>Associated Campaigns</h4>
                <?php
                $get_campaigns = "SELECT * FROM Campaigns_Institutions INNER JOIN Campaigns ON Campaigns_Institutions.Campaign_ID=Campaigns.Campaign_ID WHERE Campaigns_Institutions.Institution_ID='" . $inst['Inst_ID'] . "'";
                include "../include/dbconnopen.php";
                $campaigns = mysqli_query($cnnEnlace, $get_campaigns);
                while ($camp = mysqli_fetch_array($campaigns)) {
                    ?>
                    <a href="javascript:;" onclick="$.post(
                                            '../ajax/set_campaign_id.php',
                                            {
                                                id: '<?php echo $camp['Campaign_ID']; ?>'
                                            },
                                    function(response) {
                                        window.location = 'campaign_profile.php';
                                    })"><?php echo $camp['Campaign_Name']; ?></a><br/>
                       <?php
                   }
                   include "../include/dbconnclose.php";
                   ?></div>
        </td></tr>
</table>
<br/><br/>
<?php
include "../../footer.php";
?>
