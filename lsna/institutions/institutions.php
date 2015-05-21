<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($LSNA_id);

include "../../header.php";
include "../header.php";
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

<div class="content" id="search_all_institutions">
    <h3>Search All Institutions</h3><hr/><br/>
    <!--Link to add a new institution: -->
<?php
        if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
    <div style="text-align:center;"  ><a class="add_new" href="new_institution.php">
            <span class="add_new_button">Add New Institution</span></a></div><br>
<?php
}
?>
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
            ).fail(failAlert);
                       "></td></tr>
    </table>
    <div id="show_inst_search_results"></div>
</div>
<?php
//include "new_institution.php";
//include "institution_profile.php";
include "../../footer.php";
?>