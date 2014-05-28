<?php
/* add, expand, and edit households. */

if ($_POST['action']=='new'){
    /* entirely new household, and add its first member: */
    $make_household="INSERT INTO Households (Household_Name) VALUES ('".$_POST['household']."')";
    include "../include/dbconnopen.php";
    mysqli_query($cnnSWOP, $make_household);
    $last_id= mysqli_insert_id($cnnSWOP);
    $add_to_household="INSERT INTO Households_Participants(Household_ID, Participant_ID, Head_of_Household) 
        VALUES ('".$last_id."', '".$_POST['participant']."', '".$_POST['head']."')";
    echo $add_to_household;
    mysqli_query($cnnSWOP, $add_to_household);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='add'){
    /* add a new person to an existing household: */
    $add_to_household="INSERT INTO Households_Participants(Household_ID, Participant_ID, Head_of_Household) 
        VALUES ('".$_POST['household']."', '".$_POST['participant']."', '".$_POST['head']."')";
    echo $add_to_household;
    include "../include/dbconnopen.php";
    mysqli_query($cnnSWOP, $add_to_household);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='edit'){
    /* change household name. */
    $change_name="UPDATE Households SET Household_Name='".$_POST['name']."' WHERE New_Household_ID='".$_POST['id']."'";
    echo $change_name;
    include "../include/dbconnopen.php";
    mysqli_query($cnnSWOP, $change_name);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='delete'){
    /* remove a person from a household */
    $remove_household="DELETE FROM Households_Participants WHERE Households_Participants_ID='".$_POST['id']."'";
    echo $remove_household;
    include "../include/dbconnopen.php";
    mysqli_query($cnnSWOP, $remove_household);
    include "../include/dbconnclose.php";
}
?>
