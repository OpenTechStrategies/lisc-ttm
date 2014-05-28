<?php
/*
 * The onchange save from the program profile directs here.  Notes save into the 
 * Programs table, so only one can be saved per program.
 */
if ($_POST['type']=='program'){
    $query = "UPDATE Programs SET Notes='" . $_POST['note'] . "' WHERE Program_ID='" . $_POST['id'] . "'";
    echo $query;
    include "../include/dbconnopen.php";
    mysqli_query($cnnBickerdike, $query);
    include "../include/dbconnclose.php";
}


?>
