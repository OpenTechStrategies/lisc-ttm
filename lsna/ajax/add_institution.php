<?php
/*Create new institutions.*/

/*get the block group with the new institution's address: */
include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
$this_address=$_POST['num'] . " " .$_POST['dir'] . " " .$_POST['street_name'] . " " .$_POST['type'] . 
                " Chicago IL";
        $block_group=do_it_all($this_address, $map);
        
$new_inst_query = "INSERT INTO Institutions (
    Institution_Name,
	Institution_Type,
    Street_Num,
    Street_Direction,
    Street_Name,
    Street_Type, Block_Group) VALUES (
    '" . $_POST['name'] . "',
	'" . $_POST['inst_type'] . "',
    '" . $_POST['num'] . "',
    '" . $_POST['dir'] . "',
    '" . $_POST['street_name'] . "',
    '" . $_POST['type'] . "',
        '$block_group'
    )";
//echo $new_inst_query;
include "../include/dbconnopen.php";
mysqli_query($cnnLSNA, $new_inst_query);
$id = mysqli_insert_id($cnnLSNA);
include "../include/dbconnclose.php";
?>

<!--success message, with link to institution profile: -->
<span style="font-color:#006600; font-weight:bold">Thank you for adding <?echo $_POST['name'];?> to the database. </span> <a href="javascript:;" onclick="
		$('#institution_search_div').hide();
        $('#new_institution_div').hide();
        $('#institution_profile_div').show();
                   $.post(
                        '/lsna/ajax/set_institution_id.php',
                        {
                            page: 'profile',
                            institution_id:'<?echo $id; ?>'
                        },
                        function (response){
                            if (response!='1'){
                                document.getElementById('show_error').innerHTML = response;
                            }
                            document.write(response);
                            window.location='/lsna/institutions/institution_profile.php';
                       }
           );
"><em>View profile</em></a>