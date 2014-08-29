<?php
include "../../header.php";
include "../header.php";

/* Uses a get to load the $program variable with all the information about
 * the given program (participants, dates).  See the class file for more information
 * on the program class.
 */

$_GET['program'];
include "../classes/program.php";
$program = new Program();
$program->load_with_program_id($_GET['program']);
//print_r($_GET);
if ($_GET['schedule'] == 1) {
    ?><script type="text/javascript">
        $(document).ready(function() {
            window.location.hash = "schedule";
        });
    </script>
    <?php
}
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#program_selector').addClass('selected');
        $('.show_edit_space').hide();
        //obviously I didn't understand classes at this point.  Hides 
        //the dates attended by the program participants
        $('.prog_1').hide();
        $('.prog_2').hide();
        $('.prog_3').hide();
        $('.prog_4').hide();
        $('.prog_5').hide();
        $('.prog_6').hide();
        $('.prog_7').hide();
        $('.prog_8').hide();
        $('.prog_9').hide();
        $('.prog_10').hide();
        $('.prog_11').hide();
        $('.prog_12').hide();
        $('.prog_13').hide();
        $('.prog_14').hide();
        $('.prog_15').hide();
        $('.prog_16').hide();
        $('.prog_17').hide();
        $('.prog_18').hide();
        $('.prog_19').hide();
        $('.prog_20').hide();
        $('.prog_21').hide();
        $('.prog_22').hide();
        $('.prog_23').hide();
        $('.prog_24').hide();
        $('.prog_25').hide();
        $('.prog_26').hide();
        $('.prog_27').hide();
        $('.prog_28').hide();
        $('.prog_29').hide();
        $('.prog_30').hide();
        $('.attendance_list').hide();

        //$('.hide_on_view').hide();
    });
</script>

<div class="content_wide">
    <h3>Program Profile: <?php echo $program->program_name; ?></h3><hr/><br/>

    <!--Basic information table.  Holds the same information that was entered when the program was first created
    (host org, type) as well as notes. -->
    <table width="100%" class="profile_table">
        <tr>
            <td width="50%">
                <table class="inner_table" style="border:2px solid #696969;">
                    <tr>
                        <td><strong>Program Name:</strong></td>
                        <td><span class="displayed_info"><?php echo $program->program_name; ?></span>
                            <input style="width:100%;" type="text" value="<?php echo $program->program_name; ?>" id="edit_name" class="show_edit_space">
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Program Organization:</strong></td>
                        <td><span class="displayed_info"><?php
                                echo $program->organization . ": ";
                                $find_org_sqlsafe = "SELECT * FROM Org_Partners WHERE Partner_ID='" . $program->organization . "'";
                                include "../include/dbconnopen.php";
                                $org = mysqli_query($cnnBickerdike, $find_org_sqlsafe);
                                if ($partner = mysqli_fetch_array($org)) {
                                    echo $partner['Partner_Name'];
                                }
                                include "../include/dbconnclose.php";
                                ?></span>

                            <select id="edit_org" class="show_edit_space">
                                <option value="">-----</option>
                                <?php
                                $program_query_sqlsafe = "SELECT * FROM Org_Partners";
                                include "../include/dbconnopen.php";
                                $programs = mysqli_query($cnnBickerdike, $program_query_sqlsafe);
                                while ($prog = mysqli_fetch_array($programs)) {
                                    ?>
                                    <option value="<?php echo $prog['Partner_ID']; ?>" <?php echo($prog['Partner_ID'] == $partner['Partner_ID'] ? ' selected="selected"' : null) ?>><?php echo $prog['Partner_Name']; ?></option>
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Program Type:</strong></td>
                        <td><span class="displayed_info"><?php
                                echo $program->type . ": ";
                                $find_org_sqlsafe = "SELECT * FROM Program_Types WHERE Program_Type_ID='" . $program->type . "'";
                                include "../include/dbconnopen.php";
                                $org = mysqli_query($cnnBickerdike, $find_org_sqlsafe);
                                if ($partner = mysqli_fetch_array($org)) {
                                    echo $partner['Program_Type_Name'];
                                }
                                include "../include/dbconnclose.php";
                                ?></span>
                            <select id="edit_type" class="show_edit_space">
                                <option value="">-----</option>
                                <?php
                                $program_query_sqlsafe = "SELECT * FROM Program_Types";
                                include "../include/dbconnopen.php";
                                $programs = mysqli_query($cnnBickerdike, $program_query_sqlsafe);
                                while ($type = mysqli_fetch_array($programs)) {
                                    ?>
                                    <option value="<?php echo $type['Program_Type_ID']; ?>" <?php echo ($type['Program_Type_ID'] == $program->type ? 'selected="selected"' : null) ?>><?php echo $type['Program_Type_Name']; ?></option>
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td><strong>Number of Total Participants:</strong></td>
                        <td><?php
                            $get_participant_num_sqlsafe = "SELECT * FROM Programs_Users WHERE Program_Id='" . $program->program_id . "'";
                            include "../include/dbconnopen.php";
                            $get_num = mysqli_query($cnnBickerdike, $get_participant_num_sqlsafe);
                            $num = mysqli_num_rows($get_num);
                            echo $num;
                            include "../include/dbconnclose.php";
                            ?></td>
                    </tr>
                    <tr>

                        <!--Attn: notes save onchange, not when the save button is clicked.  -->

                        <td><strong>Notes:</strong><p class="helptext">(only 400 characters will be saved in the database)</p></td>
                        <td><textarea class="hide_on_view" id="program_notes" onchange="
                                $.post(
                                        '../ajax/save_notes.php',
                                        {
                                            type: 'program',
                                            id: '<?php echo $program->program_id; ?>',
                                            note: this.value
                                        },
                                function(response) {
                                    //document.write(response);
                                    window.location = 'program_profile.php?program=<?php echo $_GET['program']; ?>';
                                }
                                )"><?php echo $program->notes; ?></textarea></td>
                    </tr>
                    <tr>
                        <td><input class="hide_on_view" type="button" value="Edit Program Information" onclick="
                                $('.displayed_info').toggle();
                                $('.show_edit_space').toggle();
                                   "></td>
                        <td><input type="button" value="Save Changes" class="show_edit_space" onclick="
                                $.post(
                                        '../ajax/edit_program.php',
                                        {
                                            name: document.getElementById('edit_name').value,
                                            org: document.getElementById('edit_org').options[document.getElementById('edit_org').selectedIndex].value,
                                            type: document.getElementById('edit_type').options[document.getElementById('edit_type').selectedIndex].value,
                                            id: '<?php echo $_GET['program']; ?>'
                                        },
                                function(response) {
                                    //document.write(response);
                                    window.location = 'program_profile.php?program=<?php echo $program->program_id; ?>';
                                }
                                )"></td>
                    </tr>
                </table>
            </td>
            <td width="52%">
                <h4>Participants:</h4>
                <!--List of participants.  For Bickerdike, we set it up so that a person had to be added as a "participant" in a program
                BEFORE s/he could be an attendee at any given session of that program.  We thought that would make adding attendance data 
                quicker and easier.  It's not clear to me whether that worked, but all participants show up here, and then attendance is added 
                at the bottom of the page.
                -->
                <table class="inner_table">
                    <tr>
                        <th>Participant Name</th>
                        <th>Number of Times Attended</th>
                        <th></th>
                    </tr>
                    <?php
                    $users = $program->get_users();
                    $count = 0;
                    while ($user = mysqli_fetch_array($users)) {
                        $count = $count + 1;
                        ?>
                        <tr>
                            <td><a href="../users/user_profile.php?id=<?php echo $user['User_ID']; ?>"><?php echo $user['First_Name'] . " " . $user['Last_Name']; ?></a></td>
                            <td>
                                <?php
                                //calculates the number of days for which a person was present at a program.

                                $times_attended_sqlsafe = "SELECT * FROM Program_Dates_Users INNER JOIN
                                                    Program_Dates ON (Program_Dates_Users.Program_Date_ID=Program_Dates.Program_Date_ID)
                                                WHERE Program_Dates.Program_ID='" . $program->program_id . "'
                                                AND Program_Dates_Users.User_ID='" . $user['User_ID'] . "'";
                                //echo $times_attended_sqlsafe;
                                include "../include/dbconnopen.php";
                                $num = mysqli_query($cnnBickerdike, $times_attended_sqlsafe);
                                echo mysqli_num_rows($num);
                                include "../include/dbconnclose.php";
                                ?>&nbsp;&nbsp;
                                <a onclick="
                                            $('.prog_<?php echo $count; ?>').slideToggle();
                                   " class="helptext">Show/hide dates attended</a>
                                <div style="padding-left:30px;" class="prog_<?php echo $count; ?>"><?php
                                    date_default_timezone_set('America/Chicago');
                                    while ($date = mysqli_fetch_array($num)) {
                                        $datetime = new DateTime($date['Program_Date']);
                                        //echo $date . "<br>";
                                        echo date_format($datetime, 'M d, Y') . "<br>";
                                        //echo $date['Program_Date'] 
                                    }
                                    ?></div>
                            </td>
                            <td>
                                <!--This removes an entry from Participants_Programs and has a trickle-down effect on their attendance. -->
                                <input type="button" value="Delete Participant" onclick="
                                            $.post(
                                                    '../ajax/remove_participant.php',
                                                    {
                                                        id: '<?php echo $user['Program_User_ID']; ?>'
                                                    },
                                            function(response) {
                                                window.location = 'program_profile.php?program=<?php echo $program->program_id; ?>';
                                            }
                                            )"></td>
                        </tr>
                        <?php
                    }
                    ?>

                </table>
                <br/>
                <!--This is the slightly hidden link where you can actually add a person to this program.  Remember, people must be added to the 
                database, then added as participants, THEN added as attendees (still below, still haven't gotten there).  Yeah, I don't know why we 
                set it up this way either.-->
                <a class="search_toggle hide_on_view" onclick="
                        $('#user_search').toggle();
                   "><em>Add Participant: Search</em></a>

                <!--As you can see, this is just a search.  You can't add a brand-new person here.  You have to go back to the 
                participants or home screen and click "Add New Participant."
                This area that shows up after you click "Add Participant: Search" will simply search through the people
                who have already been entered into the database.  It looks at all of these lovely things.  I'm curious
                what people actually search on.  Presumably just name.
                -->

                <table class="inner_table" id="user_search" style="display:none;">
                    <tr><td>First Name:</td>
                        <td><input type="text" id="first_n"></td>
                        <td>Last Name:</td>
                        <td><input type="text" id="last_n"></td>
                    </tr>
                    <tr>
                        <td>Zipcode:</td>
                        <td><select id="zip">
                                <option value="">-----</option>
                                <?php
                                $get_zips_sqlsafe = "SELECT Zipcode FROM Users WHERE Zipcode !=0 GROUP BY Zipcode";
                                include "../include/dbconnopen.php";
                                $zips = mysqli_query($cnnBickerdike, $get_zips_sqlsafe);
                                while ($zip = mysqli_fetch_row($zips)) {
                                    ?>
                                    <option value="<?php echo $zip[0]; ?>"><?php echo $zip[0]; ?></option>
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                            </select></td>
                        <td>Age:</td>
                        <td><select id="age">
                                <option value="">-----</option>
                                <option value="12">12-19</option>
                                <option value="20">20-34</option>
                                <option value="35">35-44</option>
                                <option value="45">45-59</option>
                                <option value="60">60 or over</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td><select id="user_gender">
                                <option value="">-----</option>
                                <option value="F">Female</option>
                                <option value="M">Male</option>
                            </select></td>
                        <td>Race/Ethnicity:</td><td><select id="user_race">
                                <option value="">-----</option>
                                <option value="b">Black</option>
                                <option value="l">Latino</option>
                                <option value="a">Asian</option>
                                <option value="w">White</option>
                                <option value="o">Other</option>
                            </select></td>
                    </tr>
                    <tr><td>
                            Participant Type:
                        </td>
                        <td>
                            <select id="type">
                                <option value="">-----</option>
                                <option value="1">Adult</option>
                                <option value="2">Parent</option>
                                <option value="3">Youth</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="blank" colspan="4"><input type="button" value="Search" onclick="
                                $.post(
                                        '../ajax/search_users_to_add.php',
                                        {
                                            first: document.getElementById('first_n').value,
                                            last: document.getElementById('last_n').value,
                                            zip: document.getElementById('zip').value,
                                            age: document.getElementById('age').value,
                                            gender: document.getElementById('user_gender').value,
                                            race: document.getElementById('user_race').value,
                                            type: document.getElementById('type').value,
                                            program: <?php echo $_GET['program']; ?>
                                        },
                                function(response) {
                                    //document.write(response);
                                    document.getElementById('show_results').innerHTML = response;
                                }
                                )">&nbsp;&nbsp;&nbsp;
                            <!--This button refreshes the page, showing all the participants you added.  Originally the page
                            refreshed after each participant was added, but users decided that was slow and cumbersome.  They did,
                            however, want to see the fruits of their labor, and so the "Done Adding Participants" button was
                            born.
                            -->
                            <input type="button" value="Done Adding Participants" onclick="
                                    window.location = 'program_profile.php?program=<?php echo $program->program_id; ?>';
                                   "></td>
                    </tr>
                    <tr>
                        <td class="blank" colspan="4">
                            <div id="show_results">
                            </div>
                        </td>
                    </tr>
                </table>
                <br>
    </table>

    <br/><br/>
    <h4 id="schedule">Schedule:</h4>
    <!--The schedule shows all the dates of a given program, along with the attendees for that date.-->

    <table class="profile_table" id="program_schedule_table">
        <tr>
            <!--Add new program dates here.  A pop-up calendar will appear.  Dates must be in YYYY-MM-DD format to comply 
            with MySQL-->
            <td colspan="5" class="hide_on_view">  Add Date: <input class="hide_on_view" type="text" id="new_date">      <?include "../include/datepicker.php";?><input type="button" value="Save" onclick="
                    $.post(
                            '../ajax/add_new_program_date.php',
                            {
                                program_id: '<?php echo $program->program_id ?>',
                                date: document.getElementById('new_date').value
                            },
                    function(response) {
                        window.location = 'program_profile.php?program=<?php echo $program->program_id ?>';
                    }
                    )
                                                                                                                                                                        ">&nbsp;&nbsp;<span class="helptext">Dates must be entered in the format YYYY-MM-DD (or use the pop-up calendar).</span></td>
        </tr>
        <tr>
            <th></th><th>Date</th><th>Participants</th><th>Add/Remove Participants</th>
        </tr>
        <?php
        date_default_timezone_set('America/Chicago');
        $dates = $program->get_dates();
        $attendance_num_array = array();
        $array_of_dates = array();
        $program_length = 0;
        while ($date = mysqli_fetch_array($dates)) {
            $program_length = $program_length + 1;
            ?>
            <tr>
                <td> <!--Remove date (deletes date and all attendance for that date) -->
                    <input class="hide_on_view" type="button" value="Remove Date" onclick="
                                $.post(
                                        '../ajax/remove_date.php',
                                        {
                                            program_date_id: '<?php echo $date['Program_Date_ID'] ?>'
                                        },
                                function(response) {
                                    //document.write(response);
                                    window.location = 'program_profile.php?program=<?php echo $program->program_id; ?>&schedule=1';
                                }
                                )

                           "/>
                </td>
                <td> <!--Date-->
                    <?php
                    $array_of_dates[] = $date['Program_Date'];
                    $datetime = new DateTime($date['Program_Date']);
                    //echo $date . "<br>";
                    echo date_format($datetime, 'M d, Y');
                    //echo $date['Program_Date'];
                    ?></td>
                <td width="30%"> <!--Participant Names and Number of participants-->

                    <a onclick="
                                $('.attendance_<?php echo $date['Program_Date_ID']; ?>').slideToggle();
                       " class="helptext">Show/hide participant list</a>

                    <div style="padding-left:35px;" class="attendance_list attendance_<?php echo $date['Program_Date_ID']; ?>">
                        <?php
                        $find_attendance_by_date_sqlsafe = "SELECT * FROM Users LEFT JOIN (Program_Dates_Users)
                                ON (Program_Dates_Users.User_ID=Users.User_ID)
                                WHERE Program_Dates_Users.Program_Date_ID='" . $date['Program_Date_ID'] . "' ORDER BY Last_Name";
                        include "../include/dbconnopen.php";
                        $attendees = mysqli_query($cnnBickerdike, $find_attendance_by_date_sqlsafe);
                        $count = 0;

                        while ($attendee = mysqli_fetch_array($attendees)) {
                            $count = $count + 1;
                            ?>
                            <a href="../users/user_profile.php?id=<?php echo $attendee['User_ID']; ?>" style="font-size:.8em;"><?php echo $attendee['First_Name'] . " " . $attendee['Last_Name'] ?></a><br>
                            <?php
                        }
                        include "../include/dbconnclose.php";
                        ?>
                    </div><br><span>
                        <?php
                        $attendance_num_array[] = $count;
                        echo $count;
                        ?>&nbsp;&nbsp;
                    </span></td>
                <td>
                    <select id="choose_from_current_participants_<?php echo $date['Program_Date_ID'] ?>">
                        <option value="">-----</option>
                        <?php
                        $get_current_participants_sqlsafe = "SELECT * FROM Users LEFT JOIN (Programs_Users)
                                ON (Programs_Users.User_ID=Users.User_ID)
                                WHERE Program_ID='" . $program->program_id . "' ORDER BY Last_Name";
                        include "../include/dbconnopen.php";
                        $participants = mysqli_query($cnnBickerdike, $get_current_participants_sqlsafe);
                        while ($part = mysqli_fetch_array($participants)) {
                            ?>
                            <option value="<?php echo $part['User_ID'] ?>"><?php echo $part['First_Name'] . " " . $part['Last_Name']; ?></option>
                            <?php
                        }
                        include "../include/dbconnclose.php";
                        ?>
                    </select>

                    <!--The "hide_on_view" class is a permissions class.  View-only users cannot add or remove attendees, and so
                    cannot even see these items.-->

                    <input type="button" class="hide_on_view" value="Add Attendee" onclick="
                                //window.location = '#schedule';
                                //alert(document.getElementById('choose_from_current_participants').options[document.getElementById('choose_from_current_participants').selectedIndex].value);
                                $.post(
                                        '../ajax/add_attendee.php',
                                        {
                                            program_date_id: '<?php echo $date['Program_Date_ID'] ?>',
                                            user_id: document.getElementById('choose_from_current_participants_<?php echo $date['Program_Date_ID'] ?>').options[document.getElementById('choose_from_current_participants_<?php echo $date['Program_Date_ID'] ?>').selectedIndex].value
                                        },
                                function(response) {
                                    //document.write(response);
                                    window.location = 'program_profile.php?program=<?php echo $program->program_id; ?>&schedule=1';

                                }

                                );">     <input type="button" class="hide_on_view" value="Remove Attendee" onclick="
                                        //alert(document.getElementById('choose_from_current_participants').options[document.getElementById('choose_from_current_participants').selectedIndex].value);
                                        $.post(
                                                '../ajax/remove_attendee.php',
                                                {
                                                    program_date_id: '<?php echo $date['Program_Date_ID'] ?>',
                                                    user_id: document.getElementById('choose_from_current_participants_<?php echo $date['Program_Date_ID'] ?>').options[document.getElementById('choose_from_current_participants_<?php echo $date['Program_Date_ID'] ?>').selectedIndex].value
                                                },
                                        function(response) {
                                            //document.write(response);
                                            window.location = 'program_profile.php?program=<?php echo $program->program_id; ?>&schedule=1';
                                        }
                                        )">
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
    /*
     * This next set of code creates the download link that exports attendance data for this program.
     */


    $infile = "../data/downloads/attendance_" . $program->program_id . ".csv";
//echo $infile;
    echo "<br>";
    $fp = fopen($infile, "w") or die('can\'t open file');
    $title_array = array('Date', 'Number of Attendees', 'Attendees');
    fputcsv($fp, $title_array);
    $query_sqlsafe = "Call Program__Download_Attendance('" . $program->program_id . "')";
    include "../include/dbconnopen.php";
    $result = mysqli_query($cnnBickerdike, $query_sqlsafe);
    $num = 0;
    $count = 0;
    while ($row = mysqli_fetch_array($result)) {
        if ($date != $row['Program_Date'] && $count != 0) {
            $num = $num + 1;
//    $array=array($num, $row['Program_Date'], $date);
//    fputcsv($fp, $array);
        }
        if ($attendance_num_array[$num] == 0) {
            $put_array = array($array_of_dates[$num], $attendance_num_array[$num]);
            fputcsv($fp, $put_array);
            $num = $num + 1;
        }

        $put_array = array($row[Program_Date], $attendance_num_array[$num], $row['First_Name'], $row['Last_Name']);
        fputcsv($fp, $put_array);


        $date = $row['Program_Date'];
        $count = $count + 1;
    }
    fclose($fp);
    include "../include/dbconnclose.php";
    ?>
    <a href="<?php echo $infile; ?>" class="download">Download the CSV file of all attendance records.</a>

    <p></p>


    <?php
    /*
     * here I begin the process of making the graph appear at the bottom of the page.  It shows attendance, which is
     * controlled in the Schedule.
     */

//print_r($array_of_dates);
    echo "<br>";
    /*
     * This array ($attendance_num_array) was created above and is here converted to json so that it can be used as a set
     * of points for the graph you see below.
     */
    $attendance_to_json = json_encode((array) $attendance_num_array);
    $dates_to_json = json_encode((array) $array_of_dates);

    /*
     * This next commented section (leading to the creation of $plot), is obsolete.  I struggled with setting up this graph,
     * and this was a failed attempt.
     */

    /* $plot_var = '[';
      $count = 0;
      while ($count < count($array_of_dates)) {
      if ($count != (count($array_of_dates) - 1)) {
      $plot_var = $plot_var . "['" . $array_of_dates[$count] . "'," . $attendance_num_array[$count] . "], ";
      } else {
      $plot_var = $plot_var . "['" . $array_of_dates[$count] . "'," . $attendance_num_array[$count] . "]]";
      }
      $count = $count + 1;
      }
      echo "<p>";


      $plot = json_encode((array) $plot_var); */
    ?>
</div>

<!--This next commented section makes the graph appear properly in IE.-->

<!--[if IE]>
<script src="/include/excanvas_r3/excanvas.js"></script>
<![endif]-->
<!--<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.min.js"></script>-->
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.css" />
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript">
                                //thanks to http://stackoverflow.com/questions/2663443/need-to-loop-through-a-php-array-in-javascript
                                //  var plot_array = <?php echo $plot ?>;
                                var attendance =<?php echo $attendance_to_json ?>;
                                var dates =<?php echo $dates_to_json; ?>;
                                $(document).ready(function() {
                                    //    var plot_points = new Array();
                                    //    var count=0;
                                    //    while (count<dates.length){
                                    //        var point = new Array();
                                    //        point[0] = "'"+dates[count]+"'";
                                    //        point[1] = attendance[count];
                                    //        plot_points[count] = '['+point+']';
                                    //        count++;
                                    //    }
                                    //maybe just try to make a string:
                                    //    var plot_points = '[';
                                    //    var count=0;
                                    //    while (count<dates.length){
                                    //        if (count!=(dates.length-1)){
                                    //        plot_points += "['"+dates[count]+"',"+attendance[count]+'], ';}
                                    //        else{
                                    //            plot_points += "['"+dates[count]+"',"+attendance[count]+']]';
                                    //        }
                                    //        count++;
                                    //    }
                                    var Renderer = function() {
                                        var data = [[]];
                                        for (var i = 0; i < dates.length; i += .5) {
                                            data[0].push([i, attendance[i]]);
                                        }
                                        return data;
                                    };
                                    var plot1 = $.jqplot('chart1', [], {
                                        title: '<?php echo $program->program_name; ?>: Attendance',
                                        dataRenderer: Renderer
                                    });
                                    //document.getElementById('show_plot_point_array').innerHTML = plot_array;
                                    // var plot1 =$.jqplot ('chart1', [plot_array], {
                                    //      title: '<?php echo $program->program_name; ?>: Attendance',
                                    //      axes: {
                                    //        xaxis: {
                                    //            renderer: $.jqplot.DateAxisRenderer,
                                    //            min: dates[0],
                                    //            tickInterval:'1 week'
                                    //          
                                    //        },
                                    //        yaxis: {
                                    //          label: "Number of Attendees"
                                    //        }
                                    //      }
                                    //    });
                                });

</script>
<div id="chart1"  style="height: 300px; width: 800px; position: relative;" class="jqplot-target"></div>
<div id="show_plot_point_array"></div>

<script type="text/javascript">
    //$(document).ready(function(){
    //  var plot_points = [['2012-11-01',2], ['2012-11-08',2], ['2012-11-22',3], ['2012-11-29',1], ['2012-12-06',1]];
    //  var plot1 =$.jqplot ('chart2', [[['2012-11-01',2], ['2012-11-08',2], ['2012-11-22',3], ['2012-11-29',1], ['2012-12-06',1]]], {
    //      title: '<?php echo $program->program_name; ?> Attendance',
    //      axes: {
    //        xaxis: {
    //            renderer: $.jqplot.DateAxisRenderer,
    //            //tickOptions:{formatString:'%b %#d, %y'},
    //            min: plot_points[0][0],
    //            tickInterval:'1 week'
    //          
    //        },
    //        yaxis: {
    //          label: "Number of Attendees"
    //        }
    //      },
    //      series:[{lineWidth:4, markerOptions:{style:'square'}}]
    //    });
    //});

</script>
<div id="chart2" style="position: relative;" class="jqplot-target"></div>


<br/><br/>
<?php include "../../footer.php"; ?>