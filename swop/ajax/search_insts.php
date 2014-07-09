<?php
/* search institutions by name and type. */
include "../include/dbconnopen.php";
if ($_POST['name']==''){$name_sqlsafe='';}else{$name_sqlsafe=' AND Institution_Name LIKE "%' . mysqli_real_escape_string($cnnSWOP, $_POST['name']) . '%"';};
if ($_POST['type']==''){$type_sqlsafe='';}else{$type_sqlsafe=" AND Institution_Type LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['type']) . "%'";}

$uncertain_search_query_sqlsafe = "SELECT * FROM Institutions WHERE Institution_ID!='' " . $name_sqlsafe . $type_sqlsafe;
//echo $uncertain_search_query;

$results =mysqli_query($cnnSWOP, $uncertain_search_query_sqlsafe);
?>
<br/><h4>Search Results</h4>
    <table class="program_table" width="70%">
    <tr>
        <th>Matching Institutions</th>
    </tr>
    <?
while ($prop=mysqli_fetch_array($results)){
    ?>
    <tr>
        <td class="all_projects" style="text-align:left;"><a href="javascript:;" onclick="$.post(
            '../ajax/set_institution_id.php',
            {
                id: '<?echo $prop['Institution_ID'];?>'
            },
            function (response){
            window.location='inst_profile.php';})">
            <?echo $prop['Institution_Name'];?></a></td>
       
    </tr>
	
        <?
}
include "../include/dbconnclose.php";
?>

