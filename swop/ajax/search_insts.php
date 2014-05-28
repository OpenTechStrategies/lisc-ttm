<?php
/* search institutions by name and type. */
if ($_POST['name']==''){$name='';}else{$name=' AND Institution_Name LIKE "%' . $_POST['name'] . '%"';};
if ($_POST['type']==''){$type='';}else{$type=" AND Institution_Type LIKE '%" . $_POST['type'] . "%'";}

$uncertain_search_query = "SELECT * FROM Institutions WHERE Institution_ID!='' " . $name . $type;
//echo $uncertain_search_query;

include "../include/dbconnopen.php";
$results =mysqli_query($cnnSWOP, $uncertain_search_query);
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

