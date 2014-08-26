<?php
/* search all programs and campaigns:
 * 
 * any search terms that are filled in are included in the search:
 */

include "../include/dbconnopen.php";
$name_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['name']);
$type_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['type']);
if ($_POST['name'] == '') {
    $name = '';
} else {
    $name = ' AND Subcategories.Subcategory_Name LIKE "%' . $name_sqlsafe . '%"';
};
if ($_POST['type'] == '') {
    $type = '';
} else {
    $type = " AND Category_Subcategory_Links.Category_ID='" . $type_sqlsafe . "'";
}

if ($_POST['type'] != '') {
    $uncertain_search_query = "SELECT * FROM Subcategories INNER JOIN Category_Subcategory_Links ON
        Subcategories.Subcategory_ID=Category_Subcategory_Links.Subcategory_ID
        WHERE Subcategories.Subcategory_ID!='' " . $name . $type . " ORDER BY Subcategories.Subcategory_Name";
} else {
    $uncertain_search_query = "SELECT * FROM Subcategories 
        WHERE Subcategories.Subcategory_ID!='' " . $name . " ORDER BY Subcategories.Subcategory_Name";
}


//echo $uncertain_search_query;

$results = mysqli_query($cnnLSNA, $uncertain_search_query);

if ($_POST['result'] == 'dropdown') {
    /* show results as dropdown, especially for satisfaction surveys. */
    ?>
    <form action="../programs/new_satisfaction_survey.php" method="post">
        <select id="program_search" name="program_search">
            <option value="">-----</option>
               <?php while ($program = mysqli_fetch_array($results)) {
                   ?><option value="<?php echo $program['Subcategory_ID'] ?>"><?php echo $program['Subcategory_Name']; ?></option><?php
               }
               ?>
        </select>
        <input type="submit" value="Choose Program" 
               onclick="
    //    alert('something happened');
    //            $.post(
    //                '../programs/new_satisfaction_survey.php',
    //                {
    //                    program_id: document.getElementById('program_search').options[document.getElementById('program_search').options].value
    //                },
    //                function (response){
    //                    alert('yea');
    //                }
    //        )
               "

               ></form>
        <?php
    } elseif ($_POST['report_search'] == 'dropdown') {
        /* non-report dropdown results: */
        ?>
    Then select the program from this list and click "Choose Program."<br>
    <select id="program_search" name="program_search">
        <option value="">-----</option>
           <?php while ($program = mysqli_fetch_array($results)) {
               ?><option value="<?php echo $program['Subcategory_ID'] ?>"><?php echo $program['Subcategory_Name']; ?></option><?php
           }
           ?>
    </select>
    <input type="submit" value="Choose Program" 
           onclick="
                   $.post(
                           '../ajax/get_program_involvement.php',
                           {
                               program_id: document.getElementById('program_search').options[document.getElementById('program_search').selectedIndex].value
                           },
                   function(response) {
                       document.getElementById('show_program_report').innerHTML = response;
                   }
                   )
           ">
    <div id="show_program_report"></div>
    <?php
} else {
    ?>
    <!--Table of search results: -->

    <table class="program_table">
        <tr><th colspan="5">Search Results</th></tr>
        <tr>
            <th>Name</th>
            <th>Issue Area</th>
        </tr>
                <?php
                while ($program = mysqli_fetch_array($results)) {
                    ?>
            <tr>
                <td class="all_projects" style="text-align:left;"><a href="javascript:;" onclick="
                        $.post(
                                '../ajax/set_program_id.php',
                                {
                                    id: '<?php echo $program['Subcategory_ID']; ?>'
                                },
                        function(response) {
                            //alert(response);
                            if (response != '1') {
                                document.getElementById('show_error').innerHTML = response;
                            }
                            window.location = 'program_profile.php';
                        }
                        )"><?php echo $program['WC_Program_Name']; ?></a>
                    <a href="javascript:;" onclick="
                        $.post(
                                '../ajax/set_program_id.php',
                                {
                                    id: '<?php echo $program['Subcategory_ID']; ?>'
                                },
                        function(response) {
                            if (response != '1') {
                                document.getElementById('show_error').innerHTML = response;
                            }
                            window.location = 'program_profile.php';
                        }
                        )"><?php echo $program['Subcategory_Name']; ?></a></td>
                <td class="all_projects"><?php
                    $get_category = "SELECT * FROM Categories INNER JOIN (Category_Subcategory_Links)
                                    ON Categories.Category_ID=Category_Subcategory_Links.Category_ID
                                    WHERE Subcategory_ID='" . $program['Subcategory_ID'] . "'";
                    $org = mysqli_query($cnnLSNA, $get_category);
                    while ($partner = mysqli_fetch_array($org)) {
                        echo $partner['Category_Name'] . "<br>";
                    }
                    ?></td>

                <!--delete program or campaign: -->

                <td class="all_projects hide_on_view">
                    <input type="button" value="Delete" class="hide_on_view" onclick="
                            var double_check = confirm('Are you sure you want to delete this element from the database?  This action cannot be undone.');
                            if (double_check) {
                                $.post(
                                        '../ajax/delete_elements.php',
                                        {
                                            action: 'program',
                                            id: '<?php echo $program['Subcategory_ID']; ?>'
                                        },
                                function(response) {
                                    //document.write(response);
                                    alert('This program or campaign has been successfully deleted.');
                                }
                                );
                            }
                           ">
                </td>
            </tr>
            <?php
        }
    }
    include "../include/dbconnclose.php";
    ?>