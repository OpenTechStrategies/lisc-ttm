<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id, $AdminAccess);

/*delete various elements from places in the system (relatively self-explanatory).*/
include "../include/dbconnopen.php";
$id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['id']);

if ($_POST['action']=='program'){
    $delete_query="DELETE FROM Subcategories WHERE Subcategory_ID='".$id_sqlsafe."'";
}
elseif($_POST['action']=='institution'){
    $delete_query="DELETE FROM Institutions WHERE Institution_ID='".$id_sqlsafe."'";
}
elseif($_POST['action']=='institution_affiliation'){
    $delete_query="DELETE FROM Institutions_Participants WHERE Institutions_Participants_ID='".$id_sqlsafe."'";
}
elseif($_POST['action']=='participant'){
    $delete_query="DELETE FROM Participants WHERE Participant_ID='".$id_sqlsafe."'";
}
elseif($_POST['action']=='event'){
    $delete_query="DELETE FROM Subcategory_Dates WHERE Wright_College_Program_Date_ID='".$id_sqlsafe."'";
}
elseif($_POST['action']=='family'){
    $delete_query="DELETE FROM Parent_Mentor_Children WHERE Parent_Mentor_Children_Link_ID='".$id_sqlsafe."'";
}
elseif($_POST['action']=='subcategory'){
    $delete_query="DELETE FROM Participants_Subcategories WHERE Participant_Subcategory_ID='".$id_sqlsafe."'";
}
elseif ($_POST['action'] == 'pm_year'){
    $delete_query="DELETE FROM PM_Years WHERE PM_Year_ID='".$id_sqlsafe."'";
}

echo $delete_query;
mysqli_query($cnnLSNA, $delete_query);
include "../include/dbconnopen.php";
?>
