<?php
include "../../header.php";
include "../header.php";

//make sure the user has access to the program
//
// *First determine the program that the logged-in user has access to.  Usually this will be a program ID number,
// *but sometimes it will be 'a' (all) or 'n' (none).
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
$user_sqlsafe=mysqli_real_escape_string($cnnLISC, $_COOKIE['user']);
$get_program_access = "SELECT Program_Access FROM Users_Privileges INNER JOIN Users ON Users.User_Id = Users_Privileges.User_ID
    WHERE User_Email = '" . $user_sqlsafe . "'";
//echo $get_program_access;
$program_access = mysqli_query($cnnLISC, $get_program_access);
$prog_access = mysqli_fetch_row($program_access);
$access = $prog_access[0];
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");

?><div style="display:none"><?php include "../include/datepicker_wtw.php"; ?></div>

<!--
List of all programs, and, at the bottom, a place to add a new program.
-->

<script type="text/javascript">
    $(document).ready(function() {
        $('#programs_selector').addClass('selected');
        $('#ajax_loader').hide();
        $('#add_new').hide();
        $('#add_new_program').hide();
    });

    $(document).ajaxStart(function() {
        $('#ajax_loader').fadeIn('slow');
    });

    $(document).ajaxStop(function() {
        $('#ajax_loader').fadeOut('slow');
    });
</script>

<div class="content_block">
    <h3>Programs</h3><hr/><br/>
    <table class="inner_table" style="margin-left:auto;margin-right:auto;width:60%;">
        <!--List of programs.  Each name links to the program it refers to.  -->
        <tr>
            <td>
                <h4>Program</h4>
            </td>
            <td>
                <h4>Host Organization</h4>
            </td>
            <?php
            //if an administrator
            if ($access == 'a') {
                //show delete area
                ?>
                <td>
                    <h4>Delete</h4>
                </td>
                <?php
            }
            ?>
        </tr>
        <?php
        $get_program_info = "SELECT * FROM Programs LEFT JOIN Institutions ON Host = Inst_ID ORDER BY Name";
        include "../include/dbconnopen.php";
        $program_info = mysqli_query($cnnEnlace, $get_program_info);
        while ($temp_program = mysqli_fetch_array($program_info)) {
            ?><tr>
                <td><a href="javascript:;" onclick="$.post(
                                '../ajax/set_program_id.php',
                                {
                                    page: 'profile',
                                    id: '<?php echo $temp_program['Program_ID']; ?>'
                                },
                        function(response) {
                            window.location = 'profile.php';
                        }
                        )"><?php echo $temp_program['Name']; ?></a>
                </td>
                <td>
                    <?php echo $temp_program['Institution_Name']; ?>
                </td>
                <?php
                //if an administrator
                if ($access == 'a') {
                    //show delete area
                    ?>
                    <td style="text-align: center;">
                        <a href="javascript:;" onclick="
                                            if (confirm('ARE YOU SURE YOU WANT TO DELETE THIS PROGRAM?')) {
                                                if (confirm('ARE YOU SURE YOU WANT TO DELETE THIS PROGRAM?\r\nNOTE: This will remove all session data as well.')) {
                                                    $.post(
                                                            '../ajax/delete_program.php',
                                                            {
                                                                action: 'delete_program',
                                                                program_id: '<?php echo $temp_program['Program_ID']; ?>'
                                                            },
                                                    function(response) {
                                                        //document.write(response);
                                                        window.location='programs.php';
                                                    }
                                                    )
                                                }
                                            }" style="font-size: .8em; color: #f00; font-weight: bold;">X</a>
                    </td>
                    <?php
                }
                ?>
            </tr><?php
        }
        include "../include/dbconnclose.php";
        ?>
    </table>
    <br/><br/>

    <!--
    Add new program here.
    -->

    <h4 onclick="$('#add_new_program').slideToggle();" style="cursor:pointer;">Add New Program...</h4>
    <div id="add_new_program"><table class="search_table"  style="border:2px solid #696969;font-size:.8em;">
            <tr>
                <td><strong>Program Name:</strong></td>
                <td><input type="text" id="new_name"/></td>
            </tr>
            <tr>
                <td><strong>Host Organization:</strong></td>
                <td><select id="new_host">
                        <option value="">-----------</option>
                        <?php
                        $get_orgs = "SELECT * FROM Institutions ORDER BY Institution_Name";
                        include "../include/dbconnopen.php";
                        $orgs = mysqli_query($cnnEnlace, $get_orgs);
                        while ($org = mysqli_fetch_array($orgs)) {
                            ?>
                            <option value="<?php echo $org['Inst_ID']; ?>"><?php echo $org['Institution_Name']; ?></option>
                            <?php
                        }
                        include "../include/dbconnclose.php";
                        ?>
                    </select>
                </td>
            </tr>
            <!--Each new program must have a session, because people and dates are linked to sessions, not programs.
            -->
            <tr><td><strong>Name a session:</strong><br>
                    <span class="helptext">You must include a first session name<br> or the program will not display correctly</span></td>
                <td><input type="text" id="new_session_name"></td></tr>
            <tr><td><strong>Session Start:</strong></td><td><input type="text" id="new_session_start" class="addDP"></td></tr>
            <tr><td><strong>Session End:</strong></td><td><input type="text" id="new_session_end" class="addDP"></td></tr>
            <tr><td><strong>Session Surveys Due:</strong></td><td><span class="helptext">Surveys will be due one week before the entered end date for this session.</span>

                </td></tr>
            <tr><td colspan="2"><input type="button" value="Save"
                                       onclick="
                                               var sesh = document.getElementById('new_session_name').value;
                                               if (sesh == '') {
                                                   alert('Please name a session of this program.');
                                                   return false;
                                               }
                                               $.post(
                                                       '../ajax/add_program.php',
                                                       {
                                                           name: document.getElementById('new_name').value,
                                                           host: document.getElementById('new_host').value,
                                                           session: document.getElementById('new_session_name').value,
                                                           start: document.getElementById('new_session_start').value,
                                                           end: document.getElementById('new_session_end').value
                                                                   // survey: document.getElementById('new_session_surveys_due').value
                                                       },
                                               function(response) {
                                                   document.getElementById('add_new_program_confirm').innerHTML = response;
                                               }
                                               )"/>
                    <div id="add_new_program_confirm"></div>
                </td></tr>
        </table></div>
</div>
<br/></br>
<?php
include "../../footer.php";
?>