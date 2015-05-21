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

/* add or update the rehabilitation steps for properties. */

$reformat = explode('/', $_POST['interest_date']);
$interest_date = $reformat[2] . "-" . $reformat[0] . "-" . $reformat[1];
$reformat = explode('/', $_POST['acquisition_date']);
$acquisition_date = $reformat[2] . "-" . $reformat[0] . "-" . $reformat[1];
$reformat = explode('/', $_POST['construction_date']);
$construction_date = $reformat[2] . "-" . $reformat[0] . "-" . $reformat[1];
$reformat = explode('/', $_POST['occupancy_date']);
$occupancy_date = $reformat[2] . "-" . $reformat[0] . "-" . $reformat[1];
$reformat = explode('/', $_POST['listed_date']);
$listed_date = $reformat[2] . "-" . $reformat[0] . "-" . $reformat[1];
$reformat = explode('/', $_POST['sale_date']);
$sale_date = $reformat[2] . "-" . $reformat[0] . "-" . $reformat[1];
$reformat = explode('/', $_POST['possession_date']);
$possession_date = $reformat[2] . "-" . $reformat[0] . "-" . $reformat[1];

include "../include/dbconnopen.php";
$save_rehab_steps_sqlsafe="INSERT INTO Property_Rehab_Progress (Property_ID, Interest_Date, Interest_Reason,
    Acquisition_Date, Acquisition_Cost, Construction_Date, Construction_Cost, Occupancy_Date, For_Sale_Date,
    Num_Contacts, Sold_Date, Sale_Price, Purchaser, Days_on_Market, Subsidy_Amount, Possession_Date) VALUES 
    ('" . mysqli_real_escape_string($cnnSWOP, $_POST['property_id']) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $interest_date) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $_POST['interest_reason']) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $acquisition_date) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $_POST['acquisition_cost']) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $construction_date) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $_POST['construction_cost']) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $occupancy_date) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $listed_date) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $_POST['contacts_num']) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $sale_date) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $_POST['sale_price']) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $_POST['purchaser']) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $_POST['sale_days']) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $_POST['subsidy_amount']) . "',
    '" . mysqli_real_escape_string($cnnSWOP, $possession_date) . "')
    ON DUPLICATE KEY UPDATE 
    Interest_Date='" . mysqli_real_escape_string($cnnSWOP, $interest_date) . "',
    Interest_Reason='" . mysqli_real_escape_string($cnnSWOP, $_POST['interest_reason']) . "',
    Acquisition_Date='" . mysqli_real_escape_string($cnnSWOP, $acquisition_date) . "',
    Acquisition_Cost='" . mysqli_real_escape_string($cnnSWOP, $_POST['acquisition_cost']) . "',
    Construction_Date='" . mysqli_real_escape_string($cnnSWOP, $construction_date) . "',
    Construction_Cost='" . mysqli_real_escape_string($cnnSWOP, $_POST['construction_cost']) . "',
    Occupancy_Date='" . mysqli_real_escape_string($cnnSWOP, $occupancy_date) . "',
    For_Sale_Date='" . mysqli_real_escape_string($cnnSWOP, $listed_date) . "',
    Num_Contacts='" . mysqli_real_escape_string($cnnSWOP, $_POST['contacts_num']) . "',
    Sold_Date='" . mysqli_real_escape_string($cnnSWOP, $sale_date) . "',
    Sale_Price='" . mysqli_real_escape_string($cnnSWOP, $_POST['sale_price']) . "',
    Purchaser='" . mysqli_real_escape_string($cnnSWOP, $_POST['purchaser']) . "',
    Days_on_Market='" . mysqli_real_escape_string($cnnSWOP, $_POST['sale_days']) . "',
    Subsidy_Amount='" . mysqli_real_escape_string($cnnSWOP, $_POST['subsidy_amount']) . "',
    Possession_Date='" . mysqli_real_escape_string($cnnSWOP, $possession_date ). "'";
echo $save_rehab_steps;
mysqli_query($cnnSWOP, $save_rehab_steps_sqlsafe);
include "../include/dbconnclose.php";


?>
