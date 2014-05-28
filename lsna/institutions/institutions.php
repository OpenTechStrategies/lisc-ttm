<?php
include "../../header.php";
include "../header.php";
//print_r($_COOKIE);
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#ajax_loader').hide();
    });

    $(document).ajaxStart(function() {
        $('#ajax_loader').fadeIn('slow');
    });

    $(document).ajaxStop(function() {
        $('#ajax_loader').fadeOut('slow');
    });
</script>

<?php
/* these ifs are left over from when the institution pages were divs that were hidden or shown depending
 * on the cookie of the moment.  This is now always the institutions home page, so the second
 * script is correct:
 */
if ($_COOKIE['inst_page'] == 'profile') {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#institutions_selector').addClass('selected');
            $("a.add_new").hover(function() {
                $(this).addClass("selected");
            }, function() {
                $(this).removeClass("selected");
            });
            $('#search_all_institutions').hide();
            $('#add_new_institution').hide();
            $('#institution_profile_div').show();
            $('.show_edit_space').hide();
            $('.edit').hide();
        });
    </script>
    <?php
} elseif ($_COOKIE['inst_page'] == 'search' || !isset($_COOKIE['inst_page'])) {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#institutions_selector').addClass('selected');
            $("a.add_new").hover(function() {
                $(this).addClass("selected");
            }, function() {
                $(this).removeClass("selected");
            });
            $('#search_all_institutions').show();
            $('#add_new_institution').hide();
            $('#institution_profile_div').hide();
            $('.show_edit_space').hide();
        });
    </script>
    <?php
}
//      print_r($_COOKIE);
?>

<div class="content" id="search_all_institutions">
    <h3>Search All Institutions</h3><hr/><br/>
    <!--Link to add a new institution: -->
    <div style="text-align:center;"  class="no_view" ><a class="add_new" href="new_institution.php">
            <span class="add_new_button">Add New Institution</span></a></div><br>
    <!-- Search institutions by name and/or type: -->
    <table class="search_table">
        <tr><td><strong>Name:</strong></td><td><input type="text" id="search_inst_name"></td>
            <td><strong>Type:</strong></td><td><select id="search_inst_type">
                    <option value="">----------</option>
                    <?php
                    $get_types = "SELECT * FROM Institution_Types ORDER BY Institution_Type_Name";
                    include "../include/dbconnopen.php";
                    $types = mysqli_query($cnnLSNA, $get_types);
                    while ($type = mysqli_fetch_array($types)) {
                        ?>
                        <option value="<?php echo $type['Institution_Type_ID']; ?>"><?php echo $type['Institution_Type_Name']; ?></option>
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?>
                </select>
            </td>
        </tr>
        <tr><td><input type="button" value="Search" onclick="
            $.post(
                    '../ajax/search_institutions.php',
                    {
                        name: document.getElementById('search_inst_name').value,
                        type: document.getElementById('search_inst_type').options[document.getElementById('search_inst_type').selectedIndex].value
                    },
            function(response) {
                document.getElementById('show_inst_search_results').innerHTML = response;
            }
            )
                       "></td></tr>
    </table>
    <div id="show_inst_search_results"></div>
</div>
<?php
//include "new_institution.php";
//include "institution_profile.php";
include "../../footer.php";
?>