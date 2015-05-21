<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($SWOP_id, $DataEntryAccess);

/* add, expand, and edit households. */

if ($_POST['action']=='new'){
    /* entirely new household, and add its first member: */
    include "../include/dbconnopen.php";
    $make_household_sqlsafe="INSERT INTO Households (Household_Name) VALUES ('".mysqli_real_escape_string($cnnSWOP, $_POST['household'])."')";
    mysqli_query($cnnSWOP, $make_household_sqlsafe);
    $last_id= mysqli_insert_id($cnnSWOP);
    $add_to_household_sqlsafe="INSERT INTO Households_Participants(Household_ID, Participant_ID, Head_of_Household) 
        VALUES ('".$last_id."', '".mysqli_real_escape_string($cnnSWOP, $_POST['participant'])."', '".mysqli_real_escape_string($cnnSWOP, $_POST['head'])."')";
    echo $add_to_household_sqlsafe;
    mysqli_query($cnnSWOP, $add_to_household_sqlsafe);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='add'){
    /* add a new person to an existing household: */
    include "../include/dbconnopen.php";
    $add_to_household_sqlsafe="INSERT INTO Households_Participants(Household_ID, Participant_ID, Head_of_Household) 
        VALUES ('".mysqli_real_escape_string($cnnSWOP, $_POST['household'])."', '".mysqli_real_escape_string($cnnSWOP, $_POST['participant'])."', '".mysqli_real_escape_string($cnnSWOP, $_POST['head'])."')";
    echo $add_to_household_sqlsafe;
    mysqli_query($cnnSWOP, $add_to_household_sqlsafe);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='edit'){
    /* change household name. */
    include "../include/dbconnopen.php";
    $change_name_sqlsafe="UPDATE Households SET Household_Name='".mysqli_real_escape_string($cnnSWOP, $_POST['name'])."' WHERE New_Household_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['id'])."'";
    echo $change_name_sqlsafe;
    mysqli_query($cnnSWOP, $change_name_sqlsafe);
    include "../include/dbconnclose.php";
}
elseif($_POST['action']=='delete'){
    user_enforce_has_access($SWOP_id, $AdminAccess);
    /* remove a person from a household */
    $remove_household_sqlsafe="DELETE FROM Households_Participants WHERE Households_Participants_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['id'])."'";
    echo $remove_household_sqlsafe;
    include "../include/dbconnopen.php";
    mysqli_query($cnnSWOP, $remove_household_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
