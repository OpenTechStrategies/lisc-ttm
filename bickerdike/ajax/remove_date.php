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

user_enforce_has_access($Bickerdike_id, $AdminAccess);

/*
 * Deletes a date from a program.  Presumably the attendance is left intact, but with nowhere
 * to be displayed.  Problematic that the attendance isn't deleted, though, for export purposes.
 */
include "../include/dbconnopen.php";
$program_date_id_sqlsafe=  mysqli_real_escape_string($cnnBickerdike, $_POST['program_date_id']);
$remove_date_sqlsafe = "DELETE FROM Program_Dates WHERE
                            Program_Date_ID='". $program_date_id_sqlsafe."'";
mysqli_query($cnnBickerdike, $remove_date_sqlsafe);
include "../include/dbconnclose.php";

?>
