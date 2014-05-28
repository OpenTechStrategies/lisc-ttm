<?php
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

$save_rehab_steps="INSERT INTO Property_Rehab_Progress (Property_ID, Interest_Date, Interest_Reason,
    Acquisition_Date, Acquisition_Cost, Construction_Date, Construction_Cost, Occupancy_Date, For_Sale_Date,
    Num_Contacts, Sold_Date, Sale_Price, Purchaser, Days_on_Market, Subsidy_Amount, Possession_Date) VALUES 
    ('". $_POST['property_id'] . "',
    '". $interest_date . "',
    '". $_POST['interest_reason'] . "',
    '". $acquisition_date . "',
    '". $_POST['acquisition_cost'] . "',
    '". $construction_date . "',
    '". $_POST['construction_cost'] . "',
    '". $occupancy_date . "',
    '". $listed_date . "',
    '". $_POST['contacts_num'] . "',
    '". $sale_date . "',
    '". $_POST['sale_price'] . "',
    '". $_POST['purchaser'] . "',
    '". $_POST['sale_days'] . "',
    '". $_POST['subsidy_amount'] . "',
    '". $possession_date . "')
    ON DUPLICATE KEY UPDATE 
    Interest_Date='". $interest_date . "',
    Interest_Reason='". $_POST['interest_reason'] . "',
    Acquisition_Date='". $acquisition_date . "',
    Acquisition_Cost='". $_POST['acquisition_cost'] . "',
    Construction_Date='". $construction_date . "',
    Construction_Cost='". $_POST['construction_cost'] . "',
    Occupancy_Date='". $occupancy_date . "',
    For_Sale_Date='". $listed_date . "',
    Num_Contacts='". $_POST['contacts_num'] . "',
    Sold_Date='". $sale_date . "',
    Sale_Price='". $_POST['sale_price'] . "',
    Purchaser='". $_POST['purchaser'] . "',
    Days_on_Market='". $_POST['sale_days'] . "',
    Subsidy_Amount='". $_POST['subsidy_amount'] . "',
    Possession_Date='". $possession_date . "'";
echo $save_rehab_steps;
include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $save_rehab_steps);
include "../include/dbconnclose.php";


?>
