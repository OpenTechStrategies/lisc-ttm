<?
/* add role - people can have more than one */
if ($_POST['action']=='add'){
    $add_role = "INSERT INTO Participants_Roles (Participant_ID, Role_ID) VALUES ('" . $_POST['user_id'] . "', '" . $_POST['role'] . "')";
    echo $add_role;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $add_role);
    include "../include/dbconnclose.php";
}
/* remove participant role */
elseif ($_POST['action']=='remove'){
    $remove_role = "DELETE FROM Participants_Roles WHERE Participant_ID='" . $_POST['user_id'] . "' AND Role_ID='" . $_POST['role'] . "'";
    echo $remove_role;
    include "../include/dbconnopen.php";
    mysqli_query($cnnLSNA, $remove_role);
    include "../include/dbconnclose.php";
}
?>
