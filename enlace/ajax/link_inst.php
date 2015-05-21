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

user_enforce_has_access($Enlace_id, $DataEntryAccess);

/* link institution to campaign*/
if ($_POST['type']=='campaign'){
    include "../include/dbconnopen.php";
    $campaign_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['campaign']);
    $inst_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['inst']);
    $camp_link="INSERT INTO Campaigns_Institutions (Campaign_ID, Institution_ID)
        VALUES ('".$campaign_sqlsafe."', '".$inst_sqlsafe."')";
    echo $camp_link;
    mysqli_query($cnnEnlace, $camp_link);
    include "../include/dbconnclose.php";
}
/*or to participant.*/
elseif ($_POST['type']=='participant'){
    include "../include/dbconnopen.php";
    $inst_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['inst']);
    $person_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['person']);
    $camp_link="INSERT INTO Institutions_Participants (Institution_ID, Participant_ID)
        VALUES ('".$inst_sqlsafe."', '".$person_sqlsafe."')";
    echo $camp_link;
    mysqli_query($cnnEnlace, $camp_link);
    include "../include/dbconnclose.php";
}
?>
