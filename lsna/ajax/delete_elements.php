<?php
/*delete various elements from places in the system (relatively self-explanatory).*/
if ($_POST['action']=='program'){
    $delete_query="DELETE FROM Subcategories WHERE Subcategory_ID='".$_POST['id']."'";
}
elseif($_POST['action']=='institution'){
    $delete_query="DELETE FROM Institutions WHERE Institution_ID='".$_POST['id']."'";
}
elseif($_POST['action']=='institution_affiliation'){
    $delete_query="DELETE FROM Institutions_Participants WHERE Institutions_Participants_ID='".$_POST['id']."'";
}
elseif($_POST['action']=='participant'){
    $delete_query="DELETE FROM Participants WHERE Participant_ID='".$_POST['id']."'";
}
elseif($_POST['action']=='event'){
    $delete_query="DELETE FROM Subcategory_Dates WHERE Wright_College_Program_Date_ID='".$_POST['id']."'";
}
elseif($_POST['action']=='family'){
    $delete_query="DELETE FROM Parent_Mentor_Children WHERE Parent_Mentor_Children_Link_ID='".$_POST['id']."'";
}
elseif($_POST['action']=='subcategory'){
    $delete_query="DELETE FROM Participants_Subcategories WHERE Participant_Subcategory_ID='".$_POST['id']."'";
}

echo $delete_query;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $delete_query);
include "../include/dbconnopen.php";
?>
