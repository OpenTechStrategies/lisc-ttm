<?php
/*
 * Even this simple search uses the query format.  They can search on all or none
 * of the offered fields.
 */

/*
 * If any of the fields is blank, then it isn't included in the search query.  If it is filled in, then
 * the search includes it (organization is equal to the selected org).
 */
if ($_POST['name']==''){$first='';}else{$first=' AND Program_Name LIKE "%' . $_POST['name'] . '%"';};
if ($_POST['org']==''){$last='';}else{$last=" AND Program_Organization='" . $_POST['org'] . "'";}
if ($_POST['type']==''){$zip='';}else{$zip=" AND Program_Type='" .$_POST['type'] . "'";}


$uncertain_search_query = "SELECT * FROM Programs WHERE Program_ID!='' " . $first . $last .  $zip . "ORDER BY Program_Name";
//echo $uncertain_search_query;

include "../include/dbconnopen.php";
$results =mysqli_query($cnnBickerdike, $uncertain_search_query);
?>

<!--Show search results:-->
    <table class="program_table">
        <tr><th colspan="5"><h4>Search Results</h4></th></tr>
    <tr>
        <th>Name</th>
        <th>Organization</th>
        <th>Type</th>
        <th></th>
    </tr>
    <?
while ($program=mysqli_fetch_array($results)){
    ?>
    <tr>
        <td class="all_projects"><a href="/bickerdike/activities/program_profile.php?program=<?echo $program['Program_ID'];?>"><?echo $program['Program_Name'];?></a></td>
        <td class="all_projects">
            <!--Get the organization name (I didn't know how to use joins at this point, which is why I did this so inefficiently).-->
            <?$find_org = "SELECT * FROM Org_Partners WHERE Partner_ID='" . $program['Program_Organization'] . "'";
							include "../include/dbconnopen.php";
							$org = mysqli_query($cnnBickerdike, $find_org);
							if ($partner = mysqli_fetch_array($org)) {
							echo $partner['Partner_Name'];
							}
							//include "../include/dbconnclose.php";?></td>
        <td class="all_projects">
            <!--Get the type text-->
            <?$find_org = "SELECT * FROM Program_Types WHERE Program_Type_ID='" . $program['Program_Type'] . "'";
                                include "../include/dbconnopen.php";
                                $org = mysqli_query($cnnBickerdike, $find_org);
                                if ($partner = mysqli_fetch_array($org)) {
                                    echo $partner['Program_Type_Name'];
                                }
                                //include "../include/dbconnclose.php";?></td>
        <td class="all_projects hide_on_view">
            <!--See /ajax/delete_program for more this.  Deletes program.-->
            <input type="button" value="Delete Program" onclick="
                                                     $.post(
                                                     '../ajax/delete_program.php',
                                                     {
                                                         id: '<?echo $program['Program_ID'];?>'
                                                     },
                                                     function (response){
                                                         window.location='view_all_programs.php';
                                                     }
                                                 )"></td>
    </tr>
        <?
}
include "../include/dbconnclose.php";
?>
