<?php
/* add notes to a program or campaign */
if ($_POST['type']=='program'){
    $query = "UPDATE Subcategories SET Notes='" . $_POST['note'] . "' WHERE Subcategory_ID='" . $_POST['id'] . "'";
    echo $query;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $query);
    include "../include/dbconnclose.php";
}

/* add or edit notes for a participant */
if ($_POST['type']=='participant'){
    $query = "UPDATE Participants SET Notes='" . $_POST['note'] . "' WHERE Participant_ID='" . $_POST['id'] . "'";
    echo $query;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $query);
    include "../include/dbconnclose.php";
}


?>
