<?php
if ($_POST['action'] == 'add_to_pool') {
    /* add an existing person to the housing pool */
    include "../include/dbconnopen.php";
    $is_in_pool_sqlsafe = "SELECT * FROM Participants_Pool WHERE Participant_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['person']);
    //echo $is_in_pool;
    $in_pool = mysqli_query($cnnSWOP, $is_in_pool_sqlsafe);
    include "../include/dbconnclose.php";
    $pool = mysqli_num_rows($in_pool);
    if ($pool > 0) {
        /* in this case, they're already in the housing pool.  their member type may have changed. */
        include "../include/dbconnopen.php";
        $new_pool_sqlsafe = "UPDATE Participants_Pool SET Active=1 WHERE Participant_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['person']) . "'";
        $new_pool_sqlsafe = "INSERT INTO Pool_Status_Changes (Active, Participant_ID, Activity_Type, Member_Type) VALUES (1, '" . mysqli_real_escape_string($cnnSWOP, $_POST['person']) . "', 4, '" . mysqli_real_escape_string($cnnSWOP, $_POST['member_type']) . "')";
        //echo $new_pool;
        date_default_timezone_set('America/Chicago');
        $expected_date_make = mktime(0, 0, 0, date('m'), date('d') + 30, date('Y'));
        $show_expected_date = date('Y-m-d', $expected_date_make);
        /* add the "added to the pool" to the activity history */
        $add_first_benchmark_sqlsafe = "INSERT INTO Pool_Progress (Participant_ID, Benchmark_Completed, Date_Completed, Activity_Type, Expected_Date) VALUES 
            ('" . mysqli_real_escape_string($cnnSWOP, $_POST['person']) . "', (SELECT Pool_Benchmark_Id FROM Pool_Benchmarks WHERE 
                    Pipeline_Type=(SELECT Pipeline FROM Pool_Member_Types WHERE Type_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['member_type']) . "') AND Step_Number=1), '0000-00-00',
                    1, '" . mysqli_real_escape_string($cnnSWOP, $show_expected_date) . "')";
        echo $add_first_benchmark_sqlsafe;
        mysqli_query($cnnSWOP, $new_pool_sqlsafe);
        $id = mysqli_insert_id($cnnSWOP);
        mysqli_query($cnnSWOP, $add_first_benchmark_sqlsafe);
        include "../include/dbconnclose.php";
    } else {
        /* in this case, the person hasn't been in the pool:  */
        include "../include/dbconnopen.php";
        $new_pool_sqlsafe = "INSERT INTO Participants_Pool (Participant_ID)
            VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['person']) . "')";
        $new_pool_status_sqlsafe = "INSERT INTO Pool_Status_Changes (Active, Participant_ID, Activity_Type, Member_Type) VALUES (1, '" . mysqli_real_escape_string($cnnSWOP, $_POST['person']) . "', 4, '" . mysqli_real_escape_string($cnnSWOP, $_POST['member_type']) . "')";
        //echo $new_pool;
        date_default_timezone_set('America/Chicago');
        $expected_date_make = mktime(0, 0, 0, date('m'), date('d') + 30, date('Y'));
        $show_expected_date_sqlsafe = date('Y-m-d', $expected_date_make);
        /* show "added to pool" in the activity history: */
        $add_first_benchmark_sqlsafe = "INSERT INTO Pool_Progress (Participant_ID, Benchmark_Completed, Activity_Type, Expected_Date) VALUES 
            ('" . mysqli_real_escape_string($cnnSWOP, $_POST['person']) . "', (SELECT Pool_Benchmark_Id FROM Pool_Benchmarks WHERE 
                    Pipeline_Type=(SELECT Pipeline FROM Pool_Member_Types WHERE Type_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['member_type']) . "') AND Step_Number=1), '0000-00-00',
                    1, '" . mysqli_real_escape_string($cnnSWOP, $show_expected_date) . "')";
        echo $add_first_benchmark_sqlsafe;
        mysqli_query($cnnSWOP, $new_pool_sqlsafe);
        mysqli_query($cnnSWOP, $new_pool_status_sqlsafe);
        $id = mysqli_insert_id($cnnSWOP);
        mysqli_query($cnnSWOP, $add_first_benchmark_sqlsafe);
        include "../include/dbconnclose.php";
        setcookie("new_pool", '', time() - 7200, '/');
        /* this cookie is meant to show text on the profile that says something about "new to the pool? add finances, etc" */
        $_COOKIE['new_pool'] = setcookie("new_pool", 1, time() + 7200, '/');
    }
} elseif ($_POST['action'] == 'deactivate') {
    /* deactivate a person from the pool. */
    include "../include/dbconnopen.php";
    $action_query_sqlsafe = "INSERT INTO Pool_Status_Changes (Active, Participant_ID, Activity_Type) VALUES (0, '" . mysqli_real_escape_string($cnnSWOP, $_POST['participant']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['type']) . "')";
    mysqli_query($cnnSWOP, $action_query_sqlsafe);
    include "../include/dbconnclose.php";
} elseif ($_POST['action'] == 'link_event') {
    /* add to a new event: */
    include "../include/dbconnopen.php";
    $new_event_sqlsafe = "INSERT INTO Participants_Events (Participant_ID, Event_ID, Role_Type)
        VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['participant']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['event']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['role']) . "')";
    echo $new_event_sqlsafe;
    mysqli_query($cnnSWOP, $new_event_sqlsafe);
    include "../include/dbconnclose.php";
} elseif ($_POST['action'] == 'new_person_link_event') {
    /* add a new person to the database from the event page.  adds them to the database, 
     * links them to the event, might even give them a primary institution if that was entered. */
    include "../include/dbconnopen.php";
    $create_person_sqlsafe = "INSERT INTO Participants (Name_First, Name_Last, Phone_Day, Phone_Evening, Email) VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['first']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['last']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['home_phone']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['cell_phone']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['email']) . "')";

    echo $create_person . "<br>";
    mysqli_query($cnnSWOP, $create_person_sqlsafe);
    $id = mysqli_insert_id($cnnSWOP);
    $new_event_sqlsafe = "INSERT INTO Participants_Events (Participant_ID, Event_ID, Role_Type)
        VALUES ('" . $id . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['event']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['role']) . "')";
    echo $new_event . "<br>";
    mysqli_query($cnnSWOP, $new_event_sqlsafe);
    $primary_inst_sqlsafe = "INSERT INTO Institutions_Participants (Participant_ID, Institution_ID, Is_Primary) VALUES ($id, '" . mysqli_real_escape_string($cnnSWOP, $_POST['inst']) . "', 1)";
    echo $primary_inst_sqlsafe . "<br>";
    mysqli_query($cnnSWOP, $primary_inst_sqlsafe);
    include "../include/dbconnclose.php";
} elseif ($_POST['action'] == 'link_event_leader') {
    /* Adds event role for a participant.  (obsolete?) */
    include "../include/dbconnopen.php";
    $new_event_sqlsafe = "INSERT INTO Participants_Events (Participant_ID, Event_ID, Role_Type)
        VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['participant']) . "','" . mysqli_real_escape_string($cnnSWOP, $_POST['event']) . "', 1)";
    echo $new_event_sqlsafe;
    mysqli_query($cnnSWOP, $new_event_sqlsafe);
    include "../include/dbconnclose.php";
} elseif ($_POST['action'] == 'update_role') {
    /* adds or edits role for a person at an event */
    include "../include/dbconnopen.php";
    $update_role_sqlsafe = "UPDATE Participants_Events SET Role_Type='" . mysqli_real_escape_string($cnnSWOP, $_POST['role']) . "' WHERE Participants_Events_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['link']) . "'";
    mysqli_query($cnnSWOP, $update_role_sqlsafe);
    include "../include/dbconnclose.php";
} elseif ($_POST['action'] == 'update_exceptional') {
    /* adds or edits "exceptional" for a person at an event (additional measure outside of role taken) */
    include "../include/dbconnopen.php";
    $update_role_sqlsafe = "UPDATE Participants_Events SET Exceptional='" . mysqli_real_escape_string($cnnSWOP, $_POST['exceptional']) . "' WHERE Participants_Events_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['link']) . "'";
    mysqli_query($cnnSWOP, $update_role_sqlsafe);
    include "../include/dbconnclose.php";
} else {
    /* the original: make a new person in the database! */
    include "../include/dbconnopen.php";
    $create_new_participant_query_sqlsafe = "INSERT INTO Participants (
                                    Name_First,
                                    Name_Last,
                                    Phone_Day,
                                    Email,
                                    Gender,
                                    Date_of_Birth,
                                    First_Interaction_Date,
                                    Primary_Organizer,
                                    Activity_Type
                                ) VALUES (
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['first_name']) . "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['last_name'] . "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['day_phone']) . "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['email']) . "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['gender']) . "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['dob']) . "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['first_date']) . "',
                                    '" . mysqli_real_escape_string($cnnSWOP, $_POST['primary_organizer']) . "',
									'7')";
    /* this is obsolete.  the Participants_Addresses table doesn't even exist anymore, I don't think. */
    $add_property_sqlsafe = "INSERT INTO Participants_Addresses (
        Participant_ID,
        Address_Num,
        Address_Dir,
        Address_Street,
        Street_Type,
        Address_City,
        Address_State,
        Address_Zip) VALUES (
            '" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "',
            '" . mysqli_real_escape_string($cnnSWOP, $_POST['address_num']) . "',
            '" . mysqli_real_escape_string($cnnSWOP, $_POST['address_dir']) . "',
            '" . mysqli_real_escape_string($cnnSWOP, $_POST['address_name']) . "',
            '" . mysqli_real_escape_string($cnnSWOP, $_POST['address_type']) . "',
            '" . mysqli_real_escape_string($cnnSWOP, $_POST['city']) . "',
            '" . mysqli_real_escape_string($cnnSWOP, $_POST['state']) . "',
            '" . mysqli_real_escape_string($cnnSWOP, $_POST['zip']) . "')";

//echo $create_new_participant_query;
    mysqli_query($cnnSWOP, $create_new_participant_query_sqlsafe);
//mysqli_query($cnnSWOP, $add_property);
    $id = mysqli_insert_id($cnnSWOP);
    $add_pool_status_sqlsafe = "INSERT INTO Pool_Status_Changes (Active, Participant_ID, Activity_Type, Member_Type) VALUES ('" . $mysqli_real_escape_string($cnnSWOP, $_POST['pool']) . "', '" . $id . "', 4, '" . mysqli_real_escape_string($cnnSWOP, $_POST['pool_type']) . "')";
    mysqli_query($cnnSWOP, $add_pool_status_sqlsafe);
    if ($_POST['primary_inst'] != '') {
        $link_to_inst_sqlsafe = "INSERT INTO Institutions_Participants (Institution_ID, Participant_ID, Is_Primary, Activity_Type) VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['primary_inst']) . "', $id, 1, 6)";
        //echo $link_to_inst;
        mysqli_query($cnnSWOP, $link_to_inst_sqlsafe);
    }

    include "../include/dbconnclose.php";
    ?>

    <span style="color:#990000; font-weight:bold;">Thank you for adding  <?php echo $_POST['first_name'] . " " . $_POST['last_name']; ?> to the database.<br/><br/>
        Now, either </span>
    <a href="javascript:;" onclick="

            $.post(
                    '../ajax/set_participant_id.php',
                    {
                        page: 'profile',
                        participant_id: '<?php echo $id; ?>'
                    },
            function(response) {
                window.location = response;

            }
            );

       ">view <?php if ($_POST['gender'] == 'f') {
        echo "her";
    } else {
        echo "his";
    } ?> profile</a>
    <span style="color:#990000; font-weight:bold;"> or add an address for <?php if ($_POST['gender'] == 'f') {
        echo "her";
    } else {
        echo "him";
    } ?>.<br/><br/>

        <!--Connect to property.  This is adding the new person's address: -->
        Search for <?php if ($_POST['gender'] == 'f') {
        echo "her";
    } else {
        echo "his";
    } ?> address in our property search, and if the property
        isn't already in the database, add it below.</span><br/>
    <div id="property_search_div">
        <table class="search_table" style="border:2px solid #696969;">
            <tr>
                <td><strong>Street Name:</strong></td>
                <td><input type="text" id="prop_name_search" /></td>
                <td><strong>PIN:</strong></td>
                <td><input type="text" id="pin_search" /></td>
            </tr>
            <tr>
                <td><strong>Vacant?</strong></td>
                <td><select id="vacant_search">
                        <option value="">---------</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select></td>
                <td><strong>SWOP-Acquired?</strong></td>
                <td><select id="acquired_search">
                        <option value="">---------</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong>Rehabbed?</strong></td>
                <td><select id="rehabbed_search">
                        <option value="">---------</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select></td>
                <td><strong>Disposition:</strong></td>
                <td><select id="disposition_search">
                        <option value="">---------</option>
                        <?php
                        $get_disps_sqlsafe = "SELECT * FROM Property_Dispositions";
                        include "../include/dbconnopen.php";
                        $disps = mysqli_query($cnnSWOP, $get_disps_sqlsafe);
                        while ($disp = mysqli_fetch_row($disps)) {
                            ?>
                            <option value="<?php echo $disp[0] ?>"><?php echo $disp[1]; ?></option>
    <?php }
    include "../include/dbconnclose.php";
    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="4"><input type="button" value="Search" onclick="
                                            $('#link_button').show();
                                            $.post(
                                                    '../ajax/search_props.php',
                                                    {
                                                        name: document.getElementById('prop_name_search').value,
                                                        pin: document.getElementById('pin_search').value,
                                                        vacant: document.getElementById('vacant_search').value,
                                                        acquired: document.getElementById('acquired_search').value,
                                                        rehabbed: document.getElementById('rehabbed_search').value,
                                                        disposition: document.getElementById('disposition_search').value,
                                                        dropdown: 1
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                document.getElementById('show_swop_results').innerHTML = response;
                                            }
                                            )"/></td>
            </tr>
        </table>
        <div id="show_swop_results"></div><span><input type="button" value="Link This Property" onclick="
                                    $.post(
                                            '../ajax/link_property.php',
                                            {
                                                property: document.getElementById('choose_property').value,
                                                person: '<?php echo $id ?>'
                                            },
                                    function(response) {
                                        alert('Thank you for linking this property.');
                                    }
                                    )" id="link_button" style="display:none;"></span>
    </div><br/><br/>
    <span class="helptext">Can't find the property you're looking for?  Add it here:</span>
    <table class="search_table">

        <tr>
            <td><strong>Street Address:</strong></td>
            <!-- Borrowing IDs here from Bickerdike so they'll format correctly, sorry they're a little clumsy. -MW -->
            <td><input type="text" id="new_user_address_number" /> <select id="new_user_address_direction">
                    <option value="N">N</option>
                    <option value="S">S</option>
                    <option value="E">E</option>
                    <option value="W">W</option>
                </select> <input type="text" id="new_user_address_street" /> <select id="new_user_address_street_type">
                    <option value="ST">ST</option>
                    <option value="AVE">AVE</option>
                    <option value="RD">RD</option>
                    <option value="PL">PL</option>
                    <option value="CT">CT</option>
                    <option value="BLVD">BLVD</option>
                </select><br/>
                <span class="helptext">e.g. 1818 S Paulina St</span>
            </td>
            <td><strong>PIN:</strong></td>
            <td><input type="text" id="pin_new" maxlength="10"/></td>
        </tr>
        <tr>
            <td><strong>Vacant?</strong></td>
            <td><select id="vacant_new">
                    <option value="">---------</option>
                    <option value="1">Yes</option>
                    <option value="2">No</option>
                </select></td>

        </tr>
        <tr>
            <td><strong>Construction Type</strong></td>
            <td>
                <select id="construction_new">
                    <option value="">-----</option>
                    <option value="4" >Brick/masonry</option>
                    <option value="5" >Frame</option>
                </select>
            </td>
            <td><strong>Home Size</strong></td>
            <td> <select id="size_new">
                    <option value="">-----</option>
                    <option value="1" >Single-family</option>
                    <option value="2" >2/3 flat</option>
                    <option value="3" >Multi-unit</option>
                </select></td>
        </tr>
        <tr>
            <td><strong>Property Type:</strong></td>
            <td><select id="prop_type_new">
                    <option value="">-----</option>
                    <option value="1" >Residential</option>
                    <option value="2" >Commercial</option>
                    <option value="3" >Mixed Use</option>
                </select></td>
        </tr>
        <tr>
            <td colspan="2"><input type="button" value="Save" onclick="
                                    $.post(
                                            '../ajax/add_property.php',
                                            {
                                                action: 'link_to_new',
                                                num: document.getElementById('new_user_address_number').value,
                                                dir: document.getElementById('new_user_address_direction').value,
                                                name: document.getElementById('new_user_address_street').value,
                                                type: document.getElementById('new_user_address_street_type').value,
                                                pin: document.getElementById('pin_new').value,
                                                vacant: document.getElementById('vacant_new').value,
                                                disposition: '4',
                                                construction_type: document.getElementById('construction_new').value,
                                                home_size: document.getElementById('size_new').value,
                                                prop_type: document.getElementById('prop_type_new').value,
                                                person: '<?php echo $id ?>'
                                            },
                                    function(response) {
                                        document.getElementById('confirmation').innerHTML = response;
                                    }
                                    )
                                            ;"/></td>
        </tr>
    </table>
    <div id="confirmation"></div>
    <br/>
<?php
}?>