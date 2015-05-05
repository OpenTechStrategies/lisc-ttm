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
user_enforce_has_access($SWOP_id);

include "../../header.php";
include "../header.php";
include "../include/datepicker_simple.php";
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#reports_selector').addClass('selected');

    });

    $(document).ajaxStart(function() {
        $('#ajax_loader').fadeIn('slow');
    });

    $(document).ajaxComplete(function() {
        $('#ajax_loader').fadeOut('slow');
    });
</script>

<!-- Reports home and set of options for both the individual and property query reports. -->

<div class="content_block">
    <?php include "reports_menu.php"; ?>

    <!-- search on these options to find people: -->
    <h4>Generate Leadership Report</h4>
    <table class="inner_table" style="font-size:.9em;width:90%;margin-left:auto;margin-right:auto;border:2px solid #696969;">
        <tr><th>Number of events attended:</th><td><input type="text" id="num_events_plain"></td><td><input type="button" value="Search" onclick="
                            if (document.getElementById('include_address').checked==true){ var include_address=1; } else{ var include_address=0;}
                            if (document.getElementById('include_daytime_phone').checked==true){ var include_daytime_phone=1; } else{ var include_daytime_phone=0;}
                            if (document.getElementById('include_evening_phone').checked==true){ var include_evening_phone=1; } else{ var include_evening_phone=0;}
                            if (document.getElementById('include_primary_institution').checked==true){ var include_institution=1; } else{ var include_institution=0;}
                            if (document.getElementById('include_primary_organizer').checked==true){ var include_organizer=1; } else{ var include_organizer=0;}
                            if (document.getElementById('include_leader_type').checked==true){ var include_leader=1; } else{ var include_leader=0;}
                            if (document.getElementById('include_name').checked==true){ var include_name=1; } else{ var include_name=0;}
                                    $.post(
                                            'leadership_search.php',
                                    {
                                        action: 'num_events',
                                        num_events: document.getElementById('num_events_plain').value,
                                        include_address: include_address,
                                        include_day_phone: include_daytime_phone,
                                        include_evening: include_evening_phone,
                                        include_inst: include_institution,
                                        include_organizer: include_organizer,
                                        include_leader: include_leader,
                                        include_name: include_name
                                    },
                                    function (response){
                                        document.getElementById('show_response_here').innerHTML=response;
                                    }
                                            ).fail(failAlert);"></td></tr>
        <tr><th>Attended 1 or more events in this date range:</th><td><input type="text" class="hasDatepickers" id="pre_date"><br>
                <input type="text" class="hasDatepickers" id="post_date"></td><td><input type="button" value="Search" onclick="
                            if (document.getElementById('include_address').checked==true){ var include_address=1; } else{ var include_address=0;}
                            if (document.getElementById('include_daytime_phone').checked==true){ var include_daytime_phone=1; } else{ var include_daytime_phone=0;}
                            if (document.getElementById('include_evening_phone').checked==true){ var include_evening_phone=1; } else{ var include_evening_phone=0;}
                            if (document.getElementById('include_primary_institution').checked==true){ var include_institution=1; } else{ var include_institution=0;}
                            if (document.getElementById('include_primary_organizer').checked==true){ var include_organizer=1; } else{ var include_organizer=0;}
                            if (document.getElementById('include_leader_type').checked==true){ var include_leader=1; } else{ var include_leader=0;}
                            if (document.getElementById('include_name').checked==true){ var include_name=1; } else{ var include_name=0;}                
                                $.post(
                                        'leadership_search.php',
                                {
                                    action: 'events_dates',
                                    start_date: document.getElementById('pre_date').value,
                                    end_date: document.getElementById('post_date').value,
                                        include_address: include_address,
                                        include_day_phone: include_daytime_phone,
                                        include_evening: include_evening_phone,
                                        include_inst: include_institution,
                                        include_organizer: include_organizer,
                                        include_leader: include_leader,
                                        include_name: include_name
                                },
                                function (response){
                                    document.getElementById('show_response_here').innerHTML=response;
                                }
                                        ).fail(failAlert);"></td></tr>
                    <tr><th>Leader Type:</th><td><select id="leader_type">
                                <option value="">-----</option>
                                <option value="1">Primary</option>
                                <option value="2">Secondary</option>
                                <option value="3">Tertiary</option>
                </select></td><td><input type="button" value="Search" onclick=" if (document.getElementById('include_address').checked==true){ var include_address=1; } else{ var include_address=0;}
                            if (document.getElementById('include_daytime_phone').checked==true){ var include_daytime_phone=1; } else{ var include_daytime_phone=0;}
                            if (document.getElementById('include_evening_phone').checked==true){ var include_evening_phone=1; } else{ var include_evening_phone=0;}
                            if (document.getElementById('include_primary_institution').checked==true){ var include_institution=1; } else{ var include_institution=0;}
                            if (document.getElementById('include_primary_organizer').checked==true){ var include_organizer=1; } else{ var include_organizer=0;}
                            if (document.getElementById('include_leader_type').checked==true){ var include_leader=1; } else{ var include_leader=0;}
                            if (document.getElementById('include_name').checked==true){ var include_name=1; } else{ var include_name=0;}                
                               $.post(
                                                                                                  'leadership_search.php',
                                                                                          {
                                                                                              action: 'type',
                                                                                             leader_type: document.getElementById('leader_type').value,
                                        include_address: include_address,
                                        include_day_phone: include_daytime_phone,
                                        include_evening: include_evening_phone,
                                        include_inst: include_institution,
                                        include_organizer: include_organizer,
                                        include_leader: include_leader,
                                        include_name: include_name
                                                                                          },
                                                                                          function (response){
                                                                                              document.getElementById('show_response_here').innerHTML=response;
                                                                                          }
                                                                                                  ).fail(failAlert);"></td></tr>
                                <tr><th>Institutional  Leaders</th><td><select id="institution_link">
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
                            </select></td><td><input type="button" value="Search" onclick=" if (document.getElementById('include_address').checked==true){ var include_address=1; } else{ var include_address=0;}
                            if (document.getElementById('include_daytime_phone').checked==true){ var include_daytime_phone=1; } else{ var include_daytime_phone=0;}
                            if (document.getElementById('include_evening_phone').checked==true){ var include_evening_phone=1; } else{ var include_evening_phone=0;}
                            if (document.getElementById('include_primary_institution').checked==true){ var include_institution=1; } else{ var include_institution=0;}
                            if (document.getElementById('include_primary_organizer').checked==true){ var include_organizer=1; } else{ var include_organizer=0;}
                            if (document.getElementById('include_leader_type').checked==true){ var include_leader=1; } else{ var include_leader=0;}
                            if (document.getElementById('include_name').checked==true){ var include_name=1; } else{ var include_name=0;}                
                               $.post(
                                                                                                  'leadership_search.php',
                                                                                          {
                                                                                              action: 'institution',
                                                                                              institution: document.getElementById('institution_link').value,
                                        include_address: include_address,
                                        include_day_phone: include_daytime_phone,
                                        include_evening: include_evening_phone,
                                        include_inst: include_institution,
                                        include_organizer: include_organizer,
                                        include_leader: include_leader,
                                        include_name: include_name
                                                                                          },
                                                                                          function (response){
                                                                                              document.getElementById('show_response_here').innerHTML=response;
                                                                                          }
                                                                                                  ).fail(failAlert);"></td></tr>
        
    </table>
    <h4>Include in Results</h4>
        <table style="text-align: right;">
                    <tr>
                        <td>
                            <label for="include_address">Address:</label>
                        </td>
                        <td>
                            <input type="checkbox" id="include_address" />
                        </td>
                        
                       
                        <td>
                            <label for="include_daytime_phone">Daytime Phone:</label>
                        </td>
                        <td>
                            <input type="checkbox" id="include_daytime_phone" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="include_evening_phone">Evening Phone:</label>
                        </td>
                        <td>
                            <input type="checkbox" id="include_evening_phone" />
                        </td>
                        <td>
                            <label for="include_languages_spoken">Primary Institution:</label>
                        </td>
                        <td>
                            <input type="checkbox" id="include_primary_institution" />
                        </td></tr><tr>
                         <td>
                            <label for="include_languages_spoken">Primary Organizer:</label>
                        </td>
                        <td>
                            <input type="checkbox" id="include_primary_organizer" />
                        </td>
                         <td>
                            <label for="include_languages_spoken">Leader Type:</label>
                        </td>
                        <td>
                            <input type="checkbox" id="include_leader_type" />
                        </td></tr><tr>
                        <td>
                            <label for="include_name">Name:</label>
                        </td>
                        <td>
                            <input type="checkbox" id="include_name" />
                        </td>
                    </tr>
    </table> 
    
    <span id="show_response_here">
        
    </span>
<?php
close_all_dbconn();
?>