<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);

/* save elev8 aggregate data.  The "Element" is the 
 * piece of data that is being saved. */

/* or, delete elements: */
if ($_POST['action']=='delete'){
    user_enforce_has_access($TRP_id, $AdminAccess);
    include "../include/dbconnopen.php";
    $query_sqlsafe="DELETE FROM Elev8_Data WHERE Elev8_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
    echo $query_sqlsafe;
    mysqli_query($cnnTRP, $query_sqlsafe);
    include "../include/dbconnclose.php";
}
else{
    include "../include/dbconnopen.php";
    $query_sqlsafe="INSERT INTO Elev8_Data (Month, Year, Element, Value) VALUES ('" . mysqli_real_escape_string($cnnTRP, $_POST['month']) . "',
    '" . mysqli_real_escape_string($cnnTRP, $_POST['year']) . "',
        '" . mysqli_real_escape_string($cnnTRP, $_POST['element']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['value']) . "' )";
    echo $query_sqlsafe;
    mysqli_query($cnnTRP, $query_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
