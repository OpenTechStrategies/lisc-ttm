<?php
/* searching institutions: */

include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['name']);
$type_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['type']);
if ($_POST['name'] == '') {
    $name = '';
} else {
    $name = ' AND Institution_Name LIKE "%' . $name_sqlsafe . '%"';
};
if ($_POST['type'] == '') {
    $type = '';
} else {
    $type = " AND Institution_Type LIKE '%" . $type_sqlsafe . "%'";
}

$inst_search_query = "SELECT * FROM Institutions WHERE Institution_ID!='' " . $name . $type
                    . " ORDER BY Institution_Name";
//echo $uncertain_search_query;
//echo $inst_search_query;
$inst_results = mysqli_query($cnnLSNA, $inst_search_query);
include "../include/dbconnclose.php";
?>
<!--Table of institution results: -->
<h4>Search Results</h4>
<table class="program_table">
    <tr><th>Institution Name</th></tr>
               <?php
               while ($inst = mysqli_fetch_array($inst_results)) {
                   ?><tr><td><a href="javascript:;"
                   onclick="
                               $('#institution_search_div').hide();
                               $('#new_institution_div').hide();
                               $('#institution_profile_div').show();
                               $.post(
                                       '/lsna/ajax/set_institution_id.php',
                                       {
                                           page: 'profile',
                                           id: '<?php echo $inst['Institution_ID']; ?>'
                                       },
                               function(response) {
                                   if (response != '1') {
                                       document.getElementById('show_error').innerHTML = response;
                                   }
                                   document.write(response);
                                   window.location = '/lsna/institutions/institution_profile.php';
                               }
                               );"
                   ><?php echo $inst['Institution_Name']; ?></a></td>
            <td class="hide_on_view">
                <!--option to delete institutions if necessary: -->
                <input type="button" value="Delete This Institution" class="hide_on_view" onclick="
                        var double_check = confirm('Are you sure you want to delete this institution from the database?  This action cannot be undone.');
                        if (double_check) {
                            $.post(
                                    '../ajax/delete_elements.php',
                                    {
                                        action: 'institution',
                                        id: '<?php echo $inst['Institution_ID']; ?>'
                                    },
                            function(response) {
                                //document.write(response);
                                alert('This institution has been successfully deleted.');
                            }
                            );
                        }
                       ">
            </td></tr><?php
               }
               ?>
</table><br/>