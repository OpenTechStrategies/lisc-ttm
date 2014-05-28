<?php
/* edit properties */

/* get disposition in order to determine whether it changed in these edits: */
$get_current_disposition="SELECT Disposition FROM Properties WHERE Property_ID='" . $_POST['id'] . "'";
include "../include/dbconnopen.php";
$disp=mysqli_query($cnnSWOP, $get_current_disposition);
$disposition=mysqli_fetch_row($disp);
//testing whether the disposition has changed
//if it has, insert new disposition into activity history:
$new_disposition="INSERT INTO Property_Progress (Marker, Addtl_Info_1, Property_ID) VALUES (13, '".$_POST['disposition']."', '" . $_POST['id'] . "')";
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
$get_existing_address="SELECT Street_Num, Street_Direction, Street_Name, Street_Type, Zipcode, Block_Group
            FROM Institutions
            WHERE Institution_ID='".$_POST['id']."'";
        include "../include/dbconnopen.php";
        $existing_address=mysqli_query($cnnSWOP, $get_existing_address);
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
$edit_property_query="UPDATE Properties SET
                                Address_Street_Num='" . $_POST['num'] . "',
                                Address_Street_Name='" . $_POST['name'] . "',
                                Address_Street_Direction='" . $_POST['dir'] . "',
                                Address_Street_Type='" . $_POST['type'] . "',
                                    Zipcode='".$_POST['zipcode']."',
                                        Block_Group='$block_group',
                                PIN='" . $_POST['pin'] . "',
                                Rehabbed_Investment='" . $_POST['investment'] . "',
                                Disposition='" . $dispo . "',
                                    Construction_Type='" . $_POST['construction'] . "',
                                    Home_Size='" . $_POST['size'] . "',
                                        Property_Type='".$_POST['prop_type']."'
                                    WHERE Property_ID='" . $_POST['id'] . "'";
                                        
echo $edit_property_query;
//echo "acquisition alter id: " . $_POST['acquisition_alter_id'] . "<br>";
//echo "post acquisition: " . $_POST['acquisition'] . "<br>";

/* if there was an acquisition cost before this edit, then change it: */
if ($_POST['acquisition_alter_id']!=0 && $_POST['acquisition_alter_id']!=''){
    $change_acq="UPDATE Property_Progress SET Addtl_Info_1='" . $_POST['acquisition'] . "' WHERE Property_Progress_ID='" . $_POSTS['acquisition_alter_id'] . "'";
}
/* if there wasn't an acquisition cost before and now there is, add it: */
elseif($_POST['acquisition']!=0 && $_POST['acquisition']!=''){
    $change_acq="INSERT INTO Property_Progress (Marker, Addtl_Info_1, Property_ID) VALUES (1, '" . $_POST['acquisition'] . "', '" . $_POST['id'] . "')";
}
/* if there wasn't an acquisition cost and there still isn't, then do nothing: */
else{$change_acq="";}

/* if there was a construction cost before this edit, then change it: */
if ($_POST['const_alter_id']!=0 && $_POST['const_alter_id']!=''){
    $change_const="UPDATE Property_Progress SET Addtl_Info_1='" . $_POST['con_cost'] . "' WHERE Property_Progress_ID='" . $_POST['const_alter_id'] . "'";
}
/* if there wasn't a construction cost before and now there is, add it: */
elseif($_POST['con_cost']!=0 && $_POST['con_cost']!=''){
    $change_const="INSERT INTO Property_Progress (Marker, Addtl_Info_1, Property_ID) VALUES (2, '" . $_POST['con_cost'] . "', '" . $_POST['id'] . "')";
}
/* if there wasn't a construction cost and there still isn't, then do nothing: */
else{$change_const="";}

include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $edit_property_query);
mysqli_query($cnnSWOP, $change_acq);
mysqli_query($cnnSWOP, $change_const);
if ($disposition[0]!=$_POST['disposition']){
    mysqli_query($cnnSWOP, $new_disposition);
}
include "../include/dbconnclose.php";
?>
<!--
                               //Sale_Price='" . $_POST['price'] . "',
                                Is_Vacant= '" . $_POST['vacant'] . "',
                                Is_Acquired='" . $_POST['acquired'] . "',
                                Is_Rehabbed='" . $_POST['rehabbed'] . "',-->
