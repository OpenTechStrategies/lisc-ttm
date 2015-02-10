<?php
/* edit properties */

/* get disposition in order to determine whether it changed in these edits: */
include "../include/dbconnopen.php";
$get_current_disposition_sqlsafe="SELECT Disposition FROM Properties WHERE Property_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";
include "../include/dbconnopen.php";
$disp=mysqli_query($cnnSWOP, $get_current_disposition_sqlsafe);
$disposition=mysqli_fetch_row($disp);
//testing whether the disposition has changed
//if it has, insert new disposition into activity history:
$new_disposition_sqlsafe="INSERT INTO Property_Progress (Marker, Addtl_Info_1, Property_ID) VALUES (13, '" . mysqli_real_escape_string($cnnSWOP, $_POST['disposition']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "')";
include "../include/dbconnclose.php";

//managing the need to include a disposition
if ($_POST['disposition']==''){
    $dispo=4;
}
else{
    $dispo=$_POST['disposition'];
}
//echo $dispo . "<br>";

/* find block group based on edited address: */
include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
include "../include/dbconnopen.php";
$get_existing_address_sqlsafe="SELECT Street_Num, Street_Direction, Street_Name, Street_Type, Zipcode, Block_Group
            FROM Institutions
            WHERE Institution_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";
        $existing_address=mysqli_query($cnnSWOP, $get_existing_address_sqlsafe);
        $address_now=mysqli_fetch_row($existing_address);
        include "../include/dbconnclose.php";
         if ($address_now[0]!=$_POST['num'] || $address_now[1]!=$_POST['dir'] || $address_now[2]!=$_POST['name'] ||
                $address_now[3]!=$_POST['type'] ||$address_now[4]!=$_POST['zipcode']){
        $this_address=$_POST['num'] . " " .$_POST['dir'] . " " .$_POST['name'] . " " .$_POST['type'] . 
                " " . $_POST['zipcode'];
        $block_group=do_it_all($this_address, $map);
        echo $block_group;
        }
        else{$block_group=$address_now[5]; echo "Same block group";}
        
        /* edit actual property info: */
$edit_property_query_sqlsafe="UPDATE Properties SET
                                Address_Street_Num='" . mysqli_real_escape_string($cnnSWOP, $_POST['num']) . "',
                                Address_Street_Name='" . mysqli_real_escape_string($cnnSWOP, $_POST['name']) . "',
                                Address_Street_Direction='" . mysqli_real_escape_string($cnnSWOP, $_POST['dir']) . "',
                                Address_Street_Type='" . mysqli_real_escape_string($cnnSWOP, $_POST['type']) . "',
                                    Zipcode='" . mysqli_real_escape_string($cnnSWOP, $_POST['zipcode']) . "',
                                        Block_Group='" . mysqli_real_escape_string($cnnSWOP, $block_group) . "',
                                PIN='" . mysqli_real_escape_string($cnnSWOP, $_POST['pin']) . "',
                                Rehabbed_Investment='" . mysqli_real_escape_string($cnnSWOP, $_POST['investment']) . "',
                                Disposition='" . mysqli_real_escape_string($cnnSWOP, $dispo) . "',
                                    Construction_Type='" . mysqli_real_escape_string($cnnSWOP, $_POST['construction']) . "',
                                    Home_Size='" . mysqli_real_escape_string($cnnSWOP, $_POST['size']) . "',
                                        Property_Type='" . mysqli_real_escape_string($cnnSWOP, $_POST['prop_type']) . "'
                                    WHERE Property_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "'";
                                        
echo $edit_property_query_sqlsafe;
//echo "acquisition alter id: " . $_POST['acquisition_alter_id'] . "<br>";
//echo "post acquisition: " . $_POST['acquisition'] . "<br>";
include "../include/dbconnopen.php";
/* if there was an acquisition cost before this edit, then change it: */
if ($_POST['acquisition_alter_id']!=0 && $_POST['acquisition_alter_id']!=''){
    $change_acq_sqlsafe="UPDATE Property_Progress SET Addtl_Info_1='" . mysqli_real_escape_string($cnnSWOP, $_POST['acquisition']) . "' WHERE Property_Progress_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['acquisition_alter_id']). "'";
}
/* if there wasn't an acquisition cost before and now there is, add it: */
elseif($_POST['acquisition']!=0 && $_POST['acquisition']!=''){
    $change_acq_sqlsafe="INSERT INTO Property_Progress (Marker, Addtl_Info_1, Property_ID) VALUES (1, '" . mysqli_real_escape_string($cnnSWOP, $_POST['acquisition']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "')";
}
/* if there wasn't an acquisition cost and there still isn't, then do nothing: */
else{$change_acq_sqlsafe="";}

/* if there was a construction cost before this edit, then change it: */
if ($_POST['const_alter_id']!=0 && $_POST['const_alter_id']!=''){
    $change_const_sqlsafe="UPDATE Property_Progress SET Addtl_Info_1='" . mysqli_real_escape_string($cnnSWOP, $_POST['con_cost']) . "' WHERE Property_Progress_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['const_alter_id']) . "'";
}
/* if there wasn't a construction cost before and now there is, add it: */
elseif($_POST['con_cost']!=0 && $_POST['con_cost']!=''){
    $change_const_sqlsafe="INSERT INTO Property_Progress (Marker, Addtl_Info_1, Property_ID) VALUES (2, '" . mysqli_real_escape_string($cnnSWOP, $_POST['con_cost']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['id']) . "')";
}
/* if there wasn't a construction cost and there still isn't, then do nothing: */
else{$change_const_sqlsafe="";}

include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $edit_property_query_sqlsafe);
mysqli_query($cnnSWOP, $change_acq_sqlsafe);
mysqli_query($cnnSWOP, $change_const_sqlsafe);
if ($disposition[0]!=$_POST['disposition']){
    mysqli_query($cnnSWOP, $new_disposition_sqlsafe);
}
include "../include/dbconnclose.php";
?>
<!--
                               //Sale_Price='" . $_POST['price'] . "',
                                Is_Vacant= '" . $_POST['vacant'] . "',
                                Is_Acquired='" . $_POST['acquired'] . "',
                                Is_Rehabbed='" . $_POST['rehabbed'] . "',-->
