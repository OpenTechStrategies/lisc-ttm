<?php
/* search campaigns, though really just on name.  Not much to see here. */
if ($_POST['name']==''){$name='';}else{$name='  AND Campaign_Name LIKE "%' . $_POST['name'] .'%"';};

$search_campaigns="SELECT * FROM Campaigns WHERE Campaign_ID!=''" . $name;

include "../include/dbconnopen.php";
$results = mysqli_query($cnnSWOP, $search_campaigns);

?>
<br/><h4>Search Results</h4>
    <table class="program_table" width="70%">
    <tr>
        <th>Matching Campaigns</th>
    </tr>
    <?
while ($prop=mysqli_fetch_array($results)){
    ?>
    <tr>
        <td class="all_projects" style="text-align:left;"><a href="javascript:;" onclick="$.post(
            '../ajax/set_campaign_id.php',
            {
                id: '<?echo $prop['Campaign_ID'];?>'
            },
            function (response){
            window.location='campaign_profile.php';})">
            <?echo $prop['Campaign_Name'];?></a></td>
       
    </tr>
	
        <?
}
include "../include/dbconnclose.php";
?>