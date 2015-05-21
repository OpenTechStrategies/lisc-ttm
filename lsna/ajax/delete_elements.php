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

mysqli_query($cnnLSNA, $delete_query);
include "../include/dbconnopen.php";
?>
