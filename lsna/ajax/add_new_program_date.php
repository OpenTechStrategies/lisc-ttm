<?php
if ($_POST['action'] == 'save_note') {
    /* add notes to the program/campaign date: */
    $update_query = "UPDATE Subcategory_Dates SET Meeting_Note='" . $_POST['note'] . "' WHERE Wright_College_Program_Date_ID='" . $_POST['event'] . "'";
    echo $update_query;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $update_query);
    include "../include/dbconnclose.php";
} else {
    /* save a new date (program session or campaign event) */
    $date_reformat = explode('-', $_POST['date']);
    $save_date = $date_reformat[2] . '-' . $date_reformat[0] . '-' . $date_reformat[1];
    $add_date_to_program = "INSERT INTO Subcategory_Dates (
                            Subcategory_ID,
                            Date,
                            Activity_Name,
                            Activity_Type, 
                            Meeting_Note) VALUES (
                            '" . $_POST['program_id'] . "',
                            '" . $save_date . "',
                            '" . $_POST['name'] . "',
                            '" . $_POST['type'] . "',
                            '" . $_POST['note'] . "'
                            )";
//echo $add_date_to_program;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $add_date_to_program);
    include "../include/dbconnclose.php";
}

if ($_POST['quick_add'] == 1) {
    /* link to add an event from the homepage. */
    ?>
    <span style="color:#990000; font-weight:bold;">Thank you for adding this event to the database. <br/>
        Go to the <a href="javascript:;" onclick="
                    $.post(
                            'ajax/set_program_id.php',
                            {
                                id:'<?echo $_POST['program_id'];?>'
                            },
                            function(response) {
                                if (response != '1') {
                                    document.getElementById('show_error').innerHTML = response;
                                }
                                window.location = 'programs/program_profile.php?schedule=1';
                            }
                    );
                     ">campaign schedule</a> to add attendance or additional information.</span>
    <?php
}
?>
