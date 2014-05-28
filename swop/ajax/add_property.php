<?php
/* first, calculate the block group of the new property: */

/* include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
  $this_address=$_POST['num'] . " " .$_POST['dir'] . " " .$_POST['name'] . " " .$_POST['type'] .
  " " .$_POST['zipcode'];
  $block_group=do_it_all($this_address, $map);
 */
//echo 'got response';
/* set disposition if it's not set (joins to another table, so disposition should be set to something).   */
if ($_POST['disposition'] == '' || !isset($_POST['disposition'])) {
    $disposition = 4;
} else {
    $disposition = $_POST['disposition'];
}
$create_new_property_query = "INSERT INTO Properties (
                                Address_Street_Num,
                                Address_Street_Name,
                                Address_Street_Direction,
                                Address_Street_Type,
                                Zipcode,
                                Block_Group,
                                PIN,
                                Disposition,
                                Construction_Type,
                                Home_Size,
                                Property_Type) VALUES ('" . $_POST['num'] . "',
                                        '" . $_POST['name'] . "',
                                        '" . $_POST['dir'] . "',
                                        '" . $_POST['type'] . "',
                                            '" . $_POST['zipcode'] . "',
                                                '$block_group',
                                        '" . $_POST['pin'] . "',
                                            '" . $disposition . "',
                                        '" . $_POST['construction_type'] . "',
                                        '" . $_POST['home_size'] . "',
                                        '" . $_POST['prop_type'] . "')";

//echo $create_new_property_query;
include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $create_new_property_query);
$id = mysqli_insert_id($cnnSWOP);
if ($_POST['vacant'] == 1) {
    $vacant_status = 'Vacant';
} elseif ($_POST['vacant'] == 2) {
    $vacant_status = 'Not vacant';
} else {
    $vacant_status = '';
}
$add_vacant = "INSERT INTO Property_Progress (Marker, Addtl_Info_1, Property_ID) VALUES (8, '$vacant_status', $id)";
//echo $add_vacant;
if ($vacant_status != '') {
    mysqli_query($cnnSWOP, $add_vacant);
}
include "../include/dbconnclose.php";

if ($id != '') {
    /*  if property creation was successful: */
    if ($_POST['link_from_event'] == 1) {
        /* if this property was added when someone was linked to an event, then it is their address: */
        $link_prop = "INSERT INTO Participants_Properties (Participant_ID, Property_ID, Primary_Residence)
		VALUES ('" . $_POST['person'] . "', '" . $id . "', '1')";
        // echo $link_prop;
        include "../include/dbconnopen.php";
        mysqli_query($cnnSWOP, $link_prop);
        include "../include/dbconnclose.php";
    }
    ?>
    <span style='color:#990000; font-weight:bold;'>Thank you for adding this property to the database.</span><br/>
    <a href='javascript:;' onclick="$.post(
                                            '../ajax/set_property_id.php',
                                            {
                                                page: 'profile',
                                                id: '<?echo $id;?>'
                                            },
                                    function(response) {
                                        window.location = '../properties/profile.php';
                                    })">View property profile</a>

    <?php
    if ($_POST['action'] == 'link_to_new') {
        /* links property to a newly created person: */
        $link_prop = "INSERT INTO Participants_Properties (Participant_ID, Property_ID)
                    VALUES ('" . $_POST['person'] . "', '" . $id . "')";
        //echo $link_prop;
        include "../include/dbconnopen.php";
        mysqli_query($cnnSWOP, $link_prop);
        include "../include/dbconnclose.php";
        ?>
        <br>Or, <a href="javascript:;" onclick="
                    $.post(
                            '../ajax/set_participant_id.php',
                            {
                                page: 'profile',
                                participant_id:'<?echo $_POST['person'];?>'
                            },
                            function(response) {
                                window.location = response;

                            }
                    );
                   ">view participant profile</a>.
        <?php
    }
} else {
    echo '<span style="color:#990000; font-weight:bold; font-size:.9em;">An error occurred.  Please try again.  Note that you must choose a value for "Disposition" (it may be "N/A").</span>';
}
?>
