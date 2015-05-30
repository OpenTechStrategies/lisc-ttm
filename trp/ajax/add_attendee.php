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
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($TRP_id, $DataEntryAccess);


/* add or remove people from an event. */

if ($_POST['action']=='add'){
    include "../include/dbconnopen.php";
    $make_event_sqlsafe="INSERT INTO Events_Participants (
                        Event_ID,
                        Participant_ID) VALUES(
                        '" . mysqli_real_escape_string($cnnTRP, $_POST['event']) ."',
                        '" . mysqli_real_escape_string($cnnTRP, $_POST['person']) ."'
                        )";
    //echo $make_event_sqlsafe;
    mysqli_query($cnnTRP, $make_event_sqlsafe);
    $id=mysqli_insert_id($cnnTRP);
    include "../include/dbconnclose.php";
}

elseif($_POST['action']=='remove'){
user_enforce_has_access($TRP_id, $AdminAccess);
    include "../include/dbconnopen.php";
    $make_event_sqlsafe="DELETE FROM Events_Participants WHERE
                    Events_Participants_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['id']) ."'
                    ";
    //echo $make_event_sqlsafe;
    mysqli_query($cnnTRP, $make_event_sqlsafe);
    $id=mysqli_insert_id($cnnTRP);
    include "../include/dbconnclose.php";
}
?>

