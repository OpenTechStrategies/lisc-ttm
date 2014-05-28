<?php
/*create a new institution*/
include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
$this_address=$_POST['num'] . " " .$_POST['dir'] . " " .$_POST['street'] . " " .$_POST['suff'] . 
                " Chicago IL";
/*also get its block group, so that we can add it to the DB*/
        $block_group=do_it_all($this_address, $map);
$new_inst="INSERT INTO Institutions (Institution_Name, Institution_Type, Address_Num, Address_Dir, Address_Street,
    Address_Street_Type, Block_Group, Point_Person, Phone, Email) VALUES 
    ('".$_POST['name']."',
    '".$_POST['type']."',
    '".$_POST['num']."',
    '".$_POST['dir']."',
    '".$_POST['street']."',
    '".$_POST['suff']."',
        $block_group,
    '".$_POST['person']."',
    '".$_POST['phone']."',
    '".$_POST['email']."'
    )";
//echo $new_inst;
include "../include/dbconnopen.php";
mysqli_query($cnnEnlace, $new_inst);
$id=mysqli_insert_id($cnnEnlace);
include "../include/dbconnclose.php";
?>
<span style="color:#990000; font-weight:bold;">Thank you for adding  <?echo $_POST['name'];?> to the database.</span><br/>
<a href="inst_profile.php?inst=<?echo $id;?>">View profile</a>