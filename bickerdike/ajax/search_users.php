<?php
/*
 * Query-type search for users, too.
 */

/* No point in going through with the query if there's only one person it can be: */
if ($_POST['id'] != '') {
    include "../include/dbconnopen.php";
    $id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['id']);
    $uncertain_search_query = "SELECT * FROM Users WHERE User_ID='" . $id_sqlsafe . "'";

    $results = mysqli_query($cnnBickerdike, $uncertain_search_query);
}
/* if the ID isn't specified:
 * If any of the fields is blank, then it isn't included in the search query.  If it is filled in, then
 * the search includes it (zipcode is equal to the selected zip).
 */ else {
    include "../include/dbconnopen.php";
    $first_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['first']);
    $last_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['last']);
    $zip_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['zip']);
    $age_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['age']);
    $gender_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['gender']);
    $race_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['race']);
    $type_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['type']);
    if ($_POST['first'] == '') {
        $first = '';
    } else {
        $first = ' AND First_Name LIKE "%' . $first_sqlsafe . '%"';
    };
    if ($_POST['last'] == '') {
        $last = '';
    } else {
        $last = " AND Last_Name LIKE '%" . $last_sqlsafe . "%'";
    }
    if ($_POST['zip'] == '') {
        $zip = '';
    } else {
        $zip = " AND Zipcode='" . $zip_sqlsafe . "'";
    }
    if ($_POST['age'] == '') {
        $age = '';
    } else {
        $age = " AND Age='" . $age_sqlsafe . "'";
    }
    if ($_POST['gender'] == '') {
        $gender = '';
    } else {
        $gender = " AND Gender='" . $gender_sqlsafe . "'";
    }
    if ($_POST['race'] == '') {
        $race = '';
    } else {
        $race = " AND Race='" . $race_sqlsafe . "'";
    }
    if ($_POST['type'] == '') {
        $type = '';
    } else {
        if ($_POST['type'] == 1) {
            $type = " AND Adult='1'";
        } elseif ($_POST['type'] == 2) {
            $type = " AND Parent='1'";
        } elseif ($_POST['type'] == 3) {
            $type = " AND Child='1'";
        }
    }

    $uncertain_search_query = "SELECT * FROM Users WHERE User_ID!='' " . $first . $last . $zip . $age . $gender . $race . $type . "ORDER BY Last_Name";
//echo $uncertain_search_query;

    include "../include/dbconnopen.php";
    $results = mysqli_query($cnnBickerdike, $uncertain_search_query);
}

/*
 * In plenty of cases, we want the results to show up as a dropdown (e.g. adding new participants to a program).
 */
if ($_POST['dropdown'] == 'yes') {
    ?>
    <select id="child_to_link">
        <option value="">-----</option>
                <?php while ($user = mysqli_fetch_array($results)) {
                    ?><option value="<?php echo $user['User_ID']; ?>"><?php echo $user['First_Name'] . " " . $user['Last_Name']; ?></option><?php
           }
                ?>
    </select>
                <?php
            }

            /* This is the response to a search ONLY for the merge option for participants.
             * Returns a list of people to be merged/deleted.
             */ else if ($_POST['remove'] == 1) {
                ?><table class="inner_table"><?php
               while ($user1 = mysqli_fetch_array($results)) {
                    ?>
            <tr><td>Remove <a href="javascript:;" onclick="$('#remove_2').show();">participant #<?php echo $user1['User_ID']; ?></a> (<?php echo $user1['First_Name'] . " " . $user1['Last_Name']; ?>)</td>
                <td><a href="javascript:;" onclick="$.post(
                                    '../ajax/merge_users.php',
                                    {
                                        user_id: '<?php echo $user1['User_ID']; ?>'
                                    },
                            function(response) {
                                document.getElementById('show_merge_<?php echo $user1['User_ID'] ?>').innerHTML = response;
                            }
                            )">Yes, merge with another profile</a><br/>
                    <a href="javascript:;" onclick="
                                $.post(
                                        '../ajax/delete_user.php',
                                        {
                                            user_id: '<?php echo $user1['User_ID']; ?>'
                                        },
                                function(response) {
                                    document.getElementById('show_merge_<?php echo $user1['User_ID'] ?>').innerHTML = 'This profile has been deleted.';
                                }
                                )">No, delete all information associated with this profile</a></td>
                <td id="show_merge_<?php echo $user1['User_ID'] ?>"></td></tr>
        <?php
    }
    ?><div class="remove_step" id="remove_2">

            <br/><br/><span class="helptext">Would you like to transfer surveys or program attendance from this profile to another profile?</span><br/><br/>
        </div>
    </table>

    <?php
}/* This is the response to a search ONLY for the merge option for participants.
 * Returns a list of people to merge the chosen person into.
 */ else if ($_POST['remove'] == 2) {
    ?><select id="choose_for_merge"><?php
           while ($user2 = mysqli_fetch_array($results)) {
               ?>
            <option value="<?php echo $user2['User_ID']; ?>"><?php echo $user2['First_Name'] . " " . $user2['Last_Name']; ?></option>
               <?php
           }
           ?></select>
    <input type="button" value="Merge Profiles" onclick="
                        $.post(
                                '../ajax/merge_users.php',
                                {
                                    action: 'merge',
                                    origin_id: '<?php echo $_POST['original_id']; ?>',
                                    new_id: document.getElementById('choose_for_merge').value
                                },
                        function(response) {
                            //document.write(response);
                            document.getElementById('thanks_merge').innerHTML = 'Thank you for merging these two profiles.';
                        }
                        )"><div id="thanks_merge"></div>
    <?php
}
/* Here are the general search results (the table).
 */ else {
    ?>
    <br/><h4>Search Results</h4>
    <table class="program_table" width="70%">
        <tr>
            <th>Name</th>
            <th>Zipcode</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Race/Ethnicity</th>
        </tr>
                <?php
                while ($user = mysqli_fetch_array($results)) {
                    ?>
            <tr>
                <td class="all_projects" style="text-align:left;"><a href="/bickerdike/users/user_profile.php?id=<?php echo $user['User_ID']; ?>"><?php echo $user['First_Name'] . " " . $user['Last_Name']; ?></a></td>
                <td class="all_projects"><?php echo $user['Zipcode']; ?></td>
                <td class="all_projects">
                    <!--I saved all the age ranges as their lowest member, so 12 stands for 12-19 and so on.-->
                    <?php
                    if ($user['Age'] == '12') {
                        echo "12-19";
                    } else if ($user['Age'] == '20') {
                        echo "20-34";
                    } else if ($user['Age'] == '35') {
                        echo "35-44";
                    } else if ($user['Age'] == '45') {
                        echo "45-59";
                    } else if ($user['Age'] == '60') {
                        echo "60 or over";
                    }
                    ?></td>
                <td class="all_projects"><?php echo $user['Gender']; ?></td>
                <td class="all_projects"><?php
            if ($user['Race'] == 'a') {
                echo 'Asian-American';
            } elseif ($user['Race'] == 'b') {
                echo 'African-American';
            } elseif ($user['Race'] == 'l') {
                echo 'Latin@';
            } elseif ($user['Race'] == 'w') {
                echo 'White';
            }
            ?></td>
                <td class="all_projects">
        <!--            <a href="../include/enter_data.php?user=<?php echo $user['User_ID']; ?>" class="add_new"><span class="add_new_button">Add a survey for this user</span></a><br/><br/>-->

                    <!--Quick add survey for user, without having to go to their profile:-->

                    <a href="/bickerdike/include/enter_data.php?user=<?php echo $user['User_ID']; ?>" style="font-size:12px;">Add a Survey for this participant</a>
                </td>
            </tr>

        <?php
    }
}
include "../include/dbconnclose.php";
?>

