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

user_enforce_has_access($Enlace_id);

include "../../header.php";
include "../header.php";

include "../include/settings.php";

?>
<div style="display:none"><?php include "../include/datepicker_wtw.php"; ?></div>

<!--
List of all programs, and, at the bottom, a place to add a new program.
-->

<script type="text/javascript">
    $(document).ready(function() {
        $('#programs_selector').addClass('selected');
        $('#ajax_loader').hide();
        $('#add_new').hide();
        $('#add_new_program').hide();
        $('#inactive_programs').hide();
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
    <h4>Active Programs</h4>
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
        if ($USER->has_site_access($Enlace_id, $AdminAccess)) {
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
        $num_days_hidden = get_setting($NumDaysHiddenSetting);

        $get_active_program_info = "SELECT Programs.Program_ID, Name, Institution_Name, MAX(Session_Names.End_Date) AS max_end_date FROM Programs " .
            "LEFT JOIN Institutions ON Host = Inst_ID " .
            "INNER JOIN Session_Names ON Session_Names.Program_ID = Programs.Program_ID " .
            "           AND Session_Names.End_Date > NOW() - INTERVAL $num_days_hidden DAY " .
            "GROUP BY Programs.Program_ID " .
            "ORDER BY Name";

        include "../include/dbconnopen.php";
        $program_info = mysqli_query($cnnEnlace, $get_active_program_info);
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
                        ).fail(failAlert);"><?php echo $temp_program['Name']; ?></a>
                </td>
                <td>
                    <?php echo $temp_program['Institution_Name']; ?>
                </td>
                <?php
                //if an administrator
            if ($USER->has_site_access($Enlace_id, $AdminAccess)) {
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
                                                    ).fail(failAlert);
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
    <h4 onclick="$('#inactive_programs').slideToggle();" style="cursor:pointer;">Inactive Programs</h4>
    <div id="inactive_programs">
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
        if ($USER->has_site_access($Enlace_id, $AdminAccess)) {
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
        $get_inactive_program_info = "SELECT Programs.Program_ID, Name, Institution_Name, MAX(Session_Names.End_Date) AS max_end_date FROM Programs " .
            "LEFT JOIN Institutions ON Host = Inst_ID " .
            "INNER JOIN Session_Names ON Session_Names.Program_ID = Programs.Program_ID " .
            "           AND Session_Names.End_Date <= NOW() - INTERVAL $num_days_hidden DAY " .
            "GROUP BY Programs.Program_ID " .
            "ORDER BY Name";

        include "../include/dbconnopen.php";
        $program_info = mysqli_query($cnnEnlace, $get_inactive_program_info);
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
                        ).fail(failAlert);"><?php echo $temp_program['Name']; ?></a>
                </td>
                <td>
                    <?php echo $temp_program['Institution_Name']; ?>
                </td>
                <?php
                //if an administrator
            if ($USER->has_site_access($Enlace_id, $AdminAccess)) {
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
                                                    ).fail(failAlert);
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
    </div>
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
                <td>
                    <select id="new_session_name_year">
                        <?php
                            $last_year = (int)date('Y') - 1;
                            for($i = 0 ; $i < 5 ; $i++) {
                                $year = $i + $last_year;
                                echo "<option value=\"$year\">$year</option>";
                            }
                        ?>
                        <option value="">N/A</option>
                    </select>
                    <select id="new_session_name_type">
                        <option value="School">School</option>
                        <option value="Summer">Summer</option>
                        <option value="">N/A</option>
                    </select>
                    <input type="text" id="new_session_name"></td></tr>
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
                                                           session_year: document.getElementById('new_session_name_year').value,
                                                           session_type: document.getElementById('new_session_name_type').value,
                                                           start: document.getElementById('new_session_start').value,
                                                           end: document.getElementById('new_session_end').value
                                                                   // survey: document.getElementById('new_session_surveys_due').value
                                                       },
                                               function(response) {
                                                   document.getElementById('add_new_program_confirm').innerHTML = response;
                                               }
                                               ).fail(failAlert);"/>
                    <div id="add_new_program_confirm"></div>
                </td></tr>
        </table></div>
</div>
<br/></br>
<?php
include "../../footer.php";
?>