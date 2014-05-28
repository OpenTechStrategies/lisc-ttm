<?php
include "../../header.php";
include "../../bickerdike/header.php";

$_GET['activity'];
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#events_selector').addClass('selected');
        $('.edit').hide();
        $('#add_button').hide();
    });
</script>

<div class="content_narrow">
    <h3>Event Profile</h3>
    <table>
        <?php
        $get_activity_info = "SELECT * FROM User_Established_Activities WHERE User_Established_Activities_ID='" . $_GET['activity'] . "'";
        include "../include/dbconnopen.php";
        $activity_info = mysqli_query($cnnBickerdike, $get_activity_info);
        $count = 0;
        include "../include/datepicker.php";
        while ($info = mysqli_fetch_array($activity_info)) {
            //$count=$count+1;
            ?>
            <tr><td><b>Name:</b></td><td> <?php echo $info['Activity_Name']; ?><br></td><td><input type="text" class="edit" id="name_<?php echo $count; ?>" value="<?php echo $info['Activity_Name']; ?>"></td><td><input type="button" value="Edit" onclick="$('.edit').toggle();"</td></tr>
            <tr><td><b>Date:</b></td><td> <?php echo $info['Activity_Date']; ?><br></td><td><input type="text" class="edit" id="date_<?php echo $count; ?>" value="<?php echo $info['Activity_Date']; ?>"></td></tr>
            <tr><td><b>Type:</b></td><td> <?php echo $info['Activity_Type']; ?><br></td><td><select class="edit" id="activity_type_<?php echo $count; ?>">
                        <option value="">-----</option>
                        <option value="volunteer">Volunteer Opportunity</option>
                        <option value="fundraising">Fundraising Event</option>
                        <option value="other">Other</option>
                    </select></td></tr>
            <tr><td><b>Organization:</b></td><td> <?php echo $info['Activity_Org']; ?><br></td><td><select class="edit" id="activity_organization_<?php echo $count; ?>">
                        <option value="">-----</option>
                        <option value="bickerdike">Bickerdike</option>
                        <option value="clocc">CLOCC</option>
                    </select></td></tr>
            <tr>
                <td><strong>Notes:</strong><br>(only 400 characters will be saved in the database)</td>
                <td><textarea id="program_notes"><?php echo $info['Notes']; ?></textarea></td>
            </tr>
            <tr><th colspan="3">
                    <input type="button" value="Save" class="edit" onclick="
                                $.post(
                                        '../ajax/edit_event.php',
                                        {
                                            name: document.getElementById('name_<?php echo $count; ?>').value,
                                            date: document.getElementById('date_<?php echo $count; ?>').value,
                                            type: document.getElementById('activity_type_<?php echo $count; ?>').value,
                                            org: document.getElementById('activity_organization_<?php echo $count; ?>').value,
                                            note: document.getElementById('program_notes').value,
                                            event_id: '<?php echo $info['User_Established_Activities_ID']; ?>'
                                        },
                                function(response) {
                                    //document.write(response);
                                    window.location = 'activity_profile.php?activity=<?php echo $_GET['activity'] ?>';
                                }
                                )">
                </th></tr>
            <p></p>
            <tr><td><b>Attendees:</b><br></td></tr><tr>
                <?php
                $get_users = "SELECT * FROM Users LEFT JOIN (Activities_Users)ON (Activities_Users.User_ID=Users.User_ID) WHERE Activities_Users.User_Established_Activity_ID='" . $_GET['activity'] . "'";
                $users = mysqli_query($cnnBickerdike, $get_users);
                while ($name = mysqli_fetch_array($users)) {
                    ?>
                    <td><a href="../users/user_profile.php?id=<?php echo $name['User_ID']; ?>">
                            <?php echo $name['First_Name'] . " " . $name['Last_Name']; ?></a></td><td>
                        <input type="button" value="Remove" onclick="
                                        $.post(
                                                '../ajax/delete_event_attendee.php',
                                                {
                                                    event_id: '<?php echo $_GET['activity'] ?>',
                                                    user_id: '<?php echo $name['User_ID']; ?>'
                                                },
                                        function(response) {
                                            //document.write(response);
                                            window.location = 'activity_profile.php?activity=<?php echo $_GET['activity'] ?>';
                                        }
                                        )"><br></td></tr>
                    <?php
                }
                ?>


            </tr>
            <?php
        }
        ?>
    </table>
    <br>
    <table class="inner_table">
        <tr><th colspan="4">Search for Users:
            </th></tr>
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
                    $get_zips = "SELECT Zipcode FROM Users WHERE Zipcode !=0 GROUP BY Zipcode";
                    include "../include/dbconnopen.php";
                    $zips = mysqli_query($cnnBickerdike, $get_zips);
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
            <th colspan="4"><input type="button" value="Search" onclick="
                    $.post(
                            '../ajax/search_users_to_add.php',
                            {
                                first: document.getElementById('first_n').value,
                                last: document.getElementById('last_n').value,
                                zip: document.getElementById('zip').value,
                                age: document.getElementById('age').value,
                                gender: document.getElementById('user_gender').value,
                                race: document.getElementById('user_race').value,
                                type: document.getElementById('type').value
                            },
                    function(response) {
                        //document.write(response);
                        document.getElementById('show_results').innerHTML = response;
                        $('#add_button').show();
                    }
                    )"></th>
        </tr>
    </table>
    <br>

    <div id="show_results">
    </div>
    <p></p>

    <div id="add_button">
        <input type="button" value="Add Participant" onclick="
                $.post(
                        '../ajax/link_user_to_activity.php',
                        {
                            activity_id: '<?php echo $_GET['activity']; ?>',
                            user_id: document.getElementById('choose_from_all_adults').options[document.getElementById('choose_from_all_adults').selectedIndex].value
                        },
                function(response) {
                    window.location = 'activity_profile.php?activity=<?php echo $_GET['activity']; ?>';
                }
                )">
        <p></p></div>
</div>

<?php include "../../footer.php"; ?>