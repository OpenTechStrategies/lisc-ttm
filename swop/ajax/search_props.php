<?php
/* search properties.  This is the search backend for the properties home page, not for the query search.
 * Same idea, but fewer moving parts. */
//print_r($_POST);
include "../include/dbconnopen.php";
if ($_POST['name'] == '') {
    $name_sqlsafe = '';
} else {
    $name_sqlsafe = ' AND ((Address_Street_Name LIKE "%' . mysqli_real_escape_string($cnnSWOP, $_POST['name']) . '%" OR'
            . ' Address_Street_Num LIKE "%' . mysqli_real_escape_string($cnnSWOP, $_POST['name']) . '%" OR'
            . ' Address_Street_Direction LIKE "%' . mysqli_real_escape_string($cnnSWOP, $_POST['name']) . '%" OR'
            . ' Address_Street_Type LIKE "%' . mysqli_real_escape_string($cnnSWOP, $_POST['name']) . '%") OR'
            . ' CONCAT(Address_Street_Num, " ", Address_Street_Direction, " ",'
            . ' Address_Street_Name, " ",'
            . ' Address_Street_Type) LIKE "%' . mysqli_real_escape_string($cnnSWOP, $_POST['name']) . '%")';
};
if ($_POST['pin'] == '') {
    $pin_sqlsafe = '';
} else {
    $pin_sqlsafe = " AND PIN LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['pin']) . "%'";
}
if ($_POST['vacant'] == 1) {
    $vacant_sqlsafe = " AND Property_Progress.Marker=8 AND Addtl_Info_1='Vacant'
        ";
    $vacant_join_sqlsafe = " INNER JOIN Property_Progress ON Properties.Property_Id=Property_Progress.Property_ID 
INNER JOIN ( SELECT Property_ID as prop_id, Marker, MAX(Date_Added) as latest_date 
FROM Property_Progress WHERE Marker=8 GROUP BY Property_Progress.Property_ID) vacant_progress 
ON Property_Progress.Date_Added = vacant_progress.latest_date ";
} elseif ($_POST['vacant'] == 2) {
    $vacant_sqlsafe = " AND Property_Progress.Marker=8 AND Addtl_Info_1='Not vacant'";
    $vacant_join_sqlsafe = " INNER JOIN Property_Progress ON Properties.Property_Id=Property_Progress.Property_ID 
INNER JOIN ( SELECT Property_ID as prop_id, Marker, MAX(Date_Added) as latest_date 
FROM Property_Progress WHERE Marker=8 GROUP BY Property_Progress.Property_ID) vacant_progress 
ON Property_Progress.Date_Added = vacant_progress.latest_date ";
} else {
    $vacant_sqlsafe = "";
    $vacant_join_sqlsafe = "";
}
if ($_POST['acquired'] == '') {
    $acquired_sqlsafe = '';
} else {
    $acquired_sqlsafe = " AND Is_Acquired='" . mysqli_real_escape_string($cnnSWOP, $_POST['acquired']) . "'";
}
if ($_POST['rehabbed'] == '') {
    $rehabbed_sqlsafe = '';
} else {
    $rehabbed_sqlsafe = " AND Is_Rehabbed='" . mysqli_real_escape_string($cnnSWOP, $_POST['rehabbed']) . "'";
}
if ($_POST['disposition'] == '') {
    $disposition_sqlsafe = '';
} else {
    $disposition_sqlsafe = " AND Disposition='" . mysqli_real_escape_string($cnnSWOP, $_POST['disposition']) . "'";
}

$uncertain_search_query_sqlsafe = "SELECT * FROM Properties " . $vacant_join_sqlsafe . " WHERE Properties.Property_ID!='' " . $name_sqlsafe . $pin_sqlsafe . $vacant_sqlsafe .
        $acquired_sqlsafe . $rehabbed_sqlsafe . $disposition_sqlsafe . " GROUP BY Properties.Property_ID ORDER BY Address_Street_Name, Address_Street_Direction, Address_Street_Num";
//echo $uncertain_search_query;

$results = mysqli_query($cnnSWOP, $uncertain_search_query_sqlsafe);
if ($_POST['dropdown'] == 1) {
    ?>
    <select id="choose_property">
        <option value="">-----</option>
        <?php while ($prop = mysqli_fetch_array($results)) {
            ?><option value="<?php echo $prop['Property_ID']; ?>"><?php
                echo $prop['Property_ID'] . ": " . $prop['Address_Street_Num'] . " " . $prop['Address_Street_Direction'] . " "
                . $prop['Address_Street_Name'] . " " . $prop['Address_Street_Type'];
                ?></option>
            <?php
        }
        ?>
    </select>
    <?php
} else {
    ?>
    <br/><h4>Search Results</h4>
    <table class="program_table" width="70%">
        <tr>
            <th>Address</th>
            <th></th>
            <!--<th>Gender</th>-->
        </tr>
        <?php
        while ($prop = mysqli_fetch_array($results)) {
            ?>
            <tr>
                <td class="all_projects" style="text-align:left;"><a href="javascript:;" onclick="$.post(
                                        '../ajax/set_property_id.php',
                                        {
                                            page: 'profile',
                                            id: '<?php echo $prop['Property_ID']; ?>'
                                        },
                                function(response) {
                                    // document.write(response);
                                    window.location = 'profile.php';
                                })">
                                                                         <?php
                        echo $prop['Address_Street_Num'] . " " . $prop['Address_Street_Direction'] . " "
                        . $prop['Address_Street_Name'] . " " . $prop['Address_Street_Type'];
                        ?></a></td>

        <?php if (!isset($_COOKIE['view_restricted']) && !isset($_COOKIE['view_only'])) { ?>  
                    <!--Delete property: -->
                    <td class="all_projects hide_on_view">
                        <input type="button" value="Delete" onclick="
                                            $.post(
                                                    '../ajax/delete_elements.php',
                                                    {
                                                        action: 'property',
                                                        id: <?php echo $prop['Property_ID']; ?>
                                                    },
                                            function(response) {
                                                document.getElementById('prop_delete_<?php echo $prop['Property_ID'] ?>').innerHTML = 'Property deleted.';
                                            }
                                            )">
                        <div id="prop_delete_<?php echo $prop['Property_ID'] ?>"></div>
                    </td>
                    <?php
                }
                ?>
        <!--     <td class="all_projects"><?//echo $user['Gender'];?></td>-->
            </tr>
            <?php
        }
        ?>
    </table>
    <br/><br/>
    <?php
}
include "../include/dbconnclose.php";
?>

