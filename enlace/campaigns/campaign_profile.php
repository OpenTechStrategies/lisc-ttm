<?php
/* profile for campaign.  Campaign class is loaded with the campaign cookie that was set after the click on whatever link brought
 * the user here.
 */

include "../../header.php";
include "../header.php";
include "../classes/campaign.php";
$campaign = new Campaign();
$campaign->load_with_id($_COOKIE['campaign']);
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#campaigns_selector').addClass('selected');
        //$('#add_new_campaign').hide();
        //$('#search_all_campaigns').hide();
        $('#campaign_profile').show();
        $('.attendee_role_edit').hide();
        $('#add_date').hide();
    });
</script>
<div class="content_block">
    <h3>Campaign Profile: <?php echo $campaign->name; ?></h3><hr/><br/>
    <table class="profile_table">
        <tr>
            <td>

                <!--Add new campaign event:-->
                <h4>New Event</h4>

                <table class="inner_table">
                    <tr><td><strong>Event Name: </strong></td><td><input type="text" id="new_event" ></td></tr>
                    <tr><td><strong>Date: </strong></td><td><?include "../include/datepicker_wtw.php";?><input type="text" id="new_date" class="addDP" /></td></tr>
                    <tr><td><strong>Address: </strong></td><td><input id="st_num_new" style="width:40px;"/> 
                            <input id="st_dir_new" style="width:20px;"/> 
                            <input id="st_name_new"  style="width:100px;"/> 
                            <input id="st_type_new" style="width:35px;"/> <br>
                            <span class="helptext">e.g. 2756 S Harding Ave</span></td></tr>
                    <tr><td><strong>Type: </strong></td><td><select id="new_event_type">
                                <option value="">-----</option>
                                <?php
                                $all_events = "SELECT * FROM Event_Types ORDER BY Type";
                                include "../include/dbconnopen.php";
                                $events = mysqli_query($cnnEnlace, $all_events);
                                while ($type = mysqli_fetch_row($events)) {
                                    ?>
                                    <option value="<?php echo $type[0] ?>"><?php echo $type[1]; ?></option>
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>

                            </select></td></tr>
                    <tr><td colspan="2"><input type="button" value="Add Event" onclick="
                            $.post(
                                    '../ajax/add_event.php',
                                    {
                                        campaign_id: '<?php echo $campaign->campaign_id; ?>',
                                        date: document.getElementById('new_date').value,
                                        event_name: document.getElementById('new_event').value,
                                        address_num: document.getElementById('st_num_new').value,
                                        address_dir: document.getElementById('st_dir_new').value,
                                        address_street: document.getElementById('st_name_new').value,
                                        address_suffix: document.getElementById('st_type_new').value,
                                        event_type: document.getElementById('new_event_type').value
                                    },
                            function(response) {
                                //document.write(response);
                                //document.getElementById('show_ok').innerHTML += 'Thank you for adding '+document.getElementById('event').value + ' <br>';
                                window.location = 'campaign_profile.php';
                            }
                            );">&nbsp;&nbsp;&nbsp;<span class="helptext">Dates must be entered in the format YYYY-MM-DD.</span>
                            <div id="show_ok"></div></td></tr>
                </table>

            </td>
            <td>
                <!--see all associated institutions: -->
                <h4>Associated Institutions</h4>
                <table class="inner_table">
                    <tr><th>Institution Name</th></tr>
                    <?php
                    $get_associated_institutions = "SELECT * FROM Campaigns_Institutions
    INNER JOIN Institutions ON Institutions.Inst_ID=Campaigns_Institutions.Institution_ID
    WHERE Campaigns_Institutions.Campaign_ID='" . $campaign->campaign_id . "'";
                    include "../include/dbconnopen.php";
                    $institutions = mysqli_query($cnnEnlace, $get_associated_institutions);
                    while ($institution = mysqli_fetch_array($institutions)) {
                        ?>
                        <tr><td class="all_projects"><a href="../institutions/inst_profile.php?inst=<?php echo $institution['Inst_ID']; ?>"><?php echo $institution['Institution_Name']; ?></a></td></tr>
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?>
                </table><br/>
                <!--and link another institution: -->
                Add Institution: <select id="choose_inst">
                    <option value="">-----</option>
                    <?php
                    $get_institutions = "SELECT * FROM Institutions ORDER BY Institution_Name";
                    include "../include/dbconnopen.php";
                    $institutions = mysqli_query($cnnEnlace, $get_institutions);
                    while ($institution = mysqli_fetch_array($institutions)) {
                        ?>
                        <option value="<?php echo $institution['Inst_ID']; ?>"><?php echo $institution['Institution_Name']; ?></option>
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?>
                </select>
                <input type="button" value="Add Institution" onclick="
                        $.post(
                                '../ajax/link_inst.php',
                                {
                                    type: 'campaign',
                                    campaign: '<?php echo $campaign->campaign_id; ?>',
                                    inst: document.getElementById('choose_inst').value
                                },
                        function(response) {
                            //document.write(response);
                            window.location = 'campaign_profile.php';
                        }
                        )"></td>
        </tr>	
        <tr>
            <!--List of events associated with this campaign:
            shows event name, any notes associated with it, the date of the event, all attendees (with roles),
            the address, and event type
            -->
            <td colspan="2"><h4>Associated Events</h4>
                <table class="inner_table" style="border: 2px solid #696969;">
                    <tr style="font-size:.9em;"><th>Name</th><th> Date</th><th>Attendees</th><th>Address</th><th>Type</th></tr>
                    <?php
                    $get_associated_events = "SELECT * FROM Campaigns_Events WHERE Campaign_ID='" . $campaign->campaign_id . "' ORDER BY Event_Date DESC";
                    include "../include/dbconnopen.php";
                    $events = mysqli_query($cnnEnlace, $get_associated_events);
                    while ($event = mysqli_fetch_array($events)) {
                        ?><tr><td class="all_projects"><?php echo $event['Event_Name']; ?><br/><br/>
                                <strong>Notes </strong><span class="helptext">(.pdf, .doc, .docx, .xls, or .xlsx files)</span>
                                <div style="padding-left:20px;">
                                    <?php
                                    //showing files from database.
                                    /* Note that only one file can be added per event
                                     * 
                                     */
                                    $query = "SELECT Campaign_Event_ID, Note_File_Name 
    FROM Campaigns_Events
    WHERE Campaign_Event_ID='" . $event['Campaign_Event_ID'] . "'
    ORDER BY Note_File_Name;";
                                    $result = mysqli_query($cnnEnlace, $query);
                                    if (mysqli_num_rows($result) == 0) {
                                        echo "No notes have been uploaded <br>";
                                    } else {
                                        while (list($id, $name) = mysqli_fetch_array($result)) {
                                            ?>
                                            <a href="/enlace/ajax/download.php?id=<?php echo $id; ?>" style="font-size:.8em;"><?php echo $name; ?></a>
                                            <br />
                                            <?php
                                        }
                                    }
                                    ?>

                                    <!--Add a new file (will overwrite any existing file!)-->
                                    <form id="file_upload_form" action="/enlace/ajax/upload_file.php" method="post" enctype="multipart/form-data">
                                        <input type="file" name="file" id="file" style="font-size:.7em; padding-top:4px;"/> 
                                        <input type="hidden" name="event_id" value="<?php echo $event['Campaign_Event_ID']; ?>">
                                        <br />
                                        <input type="submit" name="submit" value="Upload" style="font-size:.7em; padding-top:4px;"/>
                                        <iframe id="upload_target" name="upload_target" src="" style="width:0;height:0;border:0px solid #fff;"></iframe>
                                    </form></div>
                            </td>


                            <td class="all_projects">
                                <?php
                                $this_date = explode('-', $event['Event_Date']);
                                date_default_timezone_set('America/Chicago');
                                $show_date = mktime(0, 0, 0, $this_date[1], $this_date[2], $this_date[0]);
                                $display_date = date('n/j/Y', $show_date);
                                echo $display_date;
                                ?></td>
                            <td class="all_projects">
                                <?php
                                /* get the attendees, with their roles. */
                                $get_event_attendees = "SELECT * FROM Participants_Events INNER JOIN Participants ON Participants_Events.Participant_ID=
            Participants.Participant_ID WHERE Event_ID='" . $event['Campaign_Event_ID'] . "'";
                                //echo $get_event_attendees;
                                $attendees = mysqli_query($cnnEnlace, $get_event_attendees);
                                while ($attendee = mysqli_fetch_array($attendees)) {
                                    ?>
                                    <a href="/enlace/participants/participant_profile.php?id=<?php echo $attendee['Participant_ID']; ?>"><?php echo $attendee['First_Name'] . " " . $attendee['Last_Name']; ?></a>
                                    <span class="attendee_role_display role_<?php echo $attendee['Participants_Events_ID']; ?>"><?php
                                        if ($attendee['Role_Type'] == 1) {
                                            echo ' - Attendee<br/>&nbsp;&nbsp;&nbsp;&nbsp;';
                                        } elseif ($attendee['Role_Type'] == 2) {
                                            echo ' - Speaker<br/>&nbsp;&nbsp;&nbsp;&nbsp;';
                                        } elseif ($attendee['Role_Type'] == 3) {
                                            echo ' - Chairperson<br/>&nbsp;&nbsp;&nbsp;&nbsp;';
                                        } elseif ($attendee['Role_Type'] == 4) {
                                            echo ' - Prep work<br/>&nbsp;&nbsp;&nbsp;&nbsp;';
                                        } elseif ($attendee['Role_Type'] == 5) {
                                            echo ' - Staff<br/>&nbsp;&nbsp;&nbsp;&nbsp;';
                                        } elseif ($attendee['Role_Type'] == 6) {
                                            echo ' - Point Person<br/>&nbsp;&nbsp;&nbsp;&nbsp;';
                                        }
                                        ?>
                                    </span>
                                    <!--
                                    Can edit or add role here too.  Saves onchange.
                                    -->
                                    <select class="attendee_role_edit role_<?php echo $attendee['Participants_Events_ID']; ?> no_view"
                                            id="attendee_role" onchange="$.post(
                                                                    '../ajax/add_participant.php',
                                                                    {
                                                                        action: 'update_role',
                                                                        role: this.value,
                                                                        link: '<?php echo $attendee['Participants_Events_ID']; ?>'
                                                                    },
                                                            function(response) {
                                                                //document.write(response);
                                                                window.location = 'campaign_profile.php';
                                                            }
                                                            )" style="margin:0;">
                                        <option value="">----------</option>
                                        <option value="1" <?php echo ($attendee['Role_Type'] == '1' ? 'selected="selected"' : null); ?>>Attendee</option>
                                        <option value="2" <?php echo ($attendee['Role_Type'] == '2' ? 'selected="selected"' : null); ?>>Speaker</option>
                                        <option value="3" <?php echo ($attendee['Role_Type'] == '3' ? 'selected="selected"' : null); ?>>Chairperson</option>
                                        <option value="4" <?php echo ($attendee['Role_Type'] == '4' ? 'selected="selected"' : null); ?>>Prep work</option>
                                        <option value="5" <?php echo ($attendee['Role_Type'] == '5' ? 'selected="selected"' : null); ?>>Staff</option>
                                        <option value="6" <?php echo ($attendee['Role_Type'] == '6' ? 'selected="selected"' : null); ?>>Point Person</option>
                                    </select><a class="helptext" href="javascript:;" onclick="
                                                    $('.role_<?php echo $attendee['Participants_Events_ID']; ?>').toggle();

                                                "><em class="no_view" >add role...</em></a><br>
                                                <?php
                                            }
                                            ?>
                                <br/>
                                <!--
                                At some point they'll probably want a search here, instead of a dropdown of all participants.
                                Add attendees:
                                -->

                                <select id="all_participants_<?php echo $event['Campaign_Event_ID'] ?>">
                                    <option value="">-----</option>
                                    <?php
                                    $get_parts = "SELECT * FROM Participants ORDER BY Last_Name";
                                    $people = mysqli_query($cnnEnlace, $get_parts);
                                    while ($person = mysqli_fetch_array($people)) {
                                        ?>
                                        <option value="<?php echo $person['Participant_ID']; ?>"><?php echo $person['First_Name'] . " " . $person['Last_Name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select><br>
                                <input type="button" value="Add Attendee" onclick="
                                            $.post(
                                                    '../ajax/add_participant.php',
                                                    {
                                                        action: 'link_event',
                                                        participant: document.getElementById('all_participants_<?php echo $event['Campaign_Event_ID'] ?>').value,
                                                        event: '<?php echo $event['Campaign_Event_ID']; ?>'
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                window.location = 'campaign_profile.php';
                                            }
                                            )">
                            </td>
                            <td class="all_projects"><?php echo $event[Address_Num] . " " . $event['Address_Dir'] . " " . $event['Address_Street'] . " " . $event['Address_Suffix']; ?></td>
                            <td class="all_projects"><?php
                                if ($event['Type'] == 1) {
                                    echo "Leadership Meeting";
                                } else if ($event['Type'] == 2) {
                                    echo "Board Meeting";
                                } else if ($event['Type'] == 3) {
                                    echo "Rally/March";
                                } else if ($event['Type'] == 4) {
                                    echo "Press Conference";
                                } else if ($event['Type'] == 5) {
                                    echo "Doorknocking";
                                } else if ($event['Type'] == 6) {
                                    echo "Aldermanic Meeting";
                                } else if ($event['Type'] == 7) {
                                    echo "City Council Meeting";
                                } else if ($event['Type'] == 8) {
                                    echo "Legislative Meeting";
                                } else if ($event['Type'] == 11) {
                                    echo "Meeting/Assembly";
                                } else if ($event['Type'] == 9) {
                                    echo "Petitions/Postcards";
                                } else if ($event['Type'] == 10) {
                                    echo "Other";
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?>
                </table><br/><br/>
            </td></tr>
    </table>
</div><br/><br/>
<?php include "../../footer.php"; ?>