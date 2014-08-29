<?php
/*
 * The onchange save from the program profile directs here.  Notes save into the 
 * Programs table, so only one can be saved per program.
 */
if ($_POST['type']=='program'){
    include "../include/dbconnopen.php";
    $note_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['note']);
    $id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $_POST['id']);
    $query_sqlsafe = "UPDATE Programs SET Notes='" . $note_sqlsafe . "' WHERE Program_ID='" . $id_sqlsafe . "'";
    echo $query_sqlsafe;
    mysqli_query($cnnBickerdike, $query_sqlsafe);
    include "../include/dbconnclose.php";
}


?>
