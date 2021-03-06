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

/* save elev8 aggregate data.  The "Element" is the 
 * piece of data that is being saved. */

/* or, delete elements: */
if ($_POST['action']=='delete'){
    user_enforce_has_access($TRP_id, $AdminAccess);
    include "../include/dbconnopen.php";
    $query_sqlsafe="DELETE FROM Elev8_Data WHERE Elev8_ID='" . mysqli_real_escape_string($cnnTRP, $_POST['id']) . "'";
    mysqli_query($cnnTRP, $query_sqlsafe);
    include "../include/dbconnclose.php";
}
else{
    include "../include/dbconnopen.php";
    $query_sqlsafe="INSERT INTO Elev8_Data (Month, Year, Element, Value) VALUES ('" . mysqli_real_escape_string($cnnTRP, $_POST['month']) . "',
    '" . mysqli_real_escape_string($cnnTRP, $_POST['year']) . "',
        '" . mysqli_real_escape_string($cnnTRP, $_POST['element']) . "',
            '" . mysqli_real_escape_string($cnnTRP, $_POST['value']) . "' )";
    mysqli_query($cnnTRP, $query_sqlsafe);
    include "../include/dbconnclose.php";
}
?>
