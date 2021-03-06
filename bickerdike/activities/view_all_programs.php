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
/*
 * This page shows a list of all programs that have been entered in the system.  It also has the ability to search these programs and 
 * a link to create a new program.
 */
include "../../header.php";

include "../../bickerdike/header.php";
?>
<!--The document.ready highlights the "Programs" option in the header menu and adds shadow on the "Create New Program" link
when the mouse hovers over it.-->
<script>
    $(document).ready(function() {
        $('#program_selector').addClass('selected');
        $("a.add_new").hover(function() {
            $(this).addClass("selected");
        }, function() {
            $(this).removeClass("selected");
        });
    });
</script>

<div class="content_wide">
    <h3>Programs</h3>
    <hr/><br/>
    <table id="all_programs">
        <tr>
            <td width="50%"><h4>Search Programs</h4>
                <table class="program_table">
                    <tr><td class="all_projects"><strong>Program Name (or part of name):</strong></td>
                        <td class="all_projects"><input type="text" id="name"></td></tr>
                    <tr><td class="all_projects"><strong>Program Organization:</strong></td>
                        <td class="all_projects"><select id="org">
                                <option value="">-----</option>
                                <?php
                                //get all the organizations that currently host programs
                                $program_query_sqlsafe = "SELECT * FROM Programs GROUP BY Program_Organization";
                                include "../include/dbconnopen.php";
                                $programs = mysqli_query($cnnBickerdike, $program_query_sqlsafe);
                                while ($program = mysqli_fetch_array($programs)) {
                                    ?>
                                    <option value="<?php echo $program['Program_Organization']; ?>"><?php
                                        $find_org_sqlsafe = "SELECT * FROM Org_Partners WHERE Partner_ID='" . $program['Program_Organization'] . "'";
                                        include "../include/dbconnopen.php";
                                        $org = mysqli_query($cnnBickerdike, $find_org_sqlsafe);
                                        if ($partner = mysqli_fetch_array($org)) {
                                            echo $partner['Partner_Name'];
                                        }
                                        include "../include/dbconnclose.php";
                                        ?></option>
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                            </select></td></tr>
                    <tr><td class="all_projects"><strong>Program Type:</strong></td>
                        <td class="all_projects"><select id="type">
                                <option value="">-----</option>
                                <?php
                                //get list of program types for search
                                $program_query_sqlsafe = "SELECT * FROM Program_Types ORDER BY Program_Type_Name";
                                include "../include/dbconnopen.php";
                                $programs = mysqli_query($cnnBickerdike, $program_query_sqlsafe);
                                while ($program = mysqli_fetch_array($programs)) {
                                    ?>
                                    <option value="<?php echo $program['Program_Type_ID']; ?>"><?php echo $program['Program_Type_Name'] ?></option>
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                            </select></td></tr>
                    <tr><th colspan="2">
                            <!--Search results will show up below search box.  Search results
                            include the option to delete a given program, as well as other basic information (org and type).-->
                            <input type="button" value="Search" onclick="
                                    $.post(
                                            '../ajax/search_programs.php',
                                            {
                                                name: document.getElementById('name').value,
                                                org: document.getElementById('org').value,
                                                type: document.getElementById('type').value
                                            },
                                    function(response) {
                                        document.getElementById('show_results').innerHTML = response;
                                    }
                                    ).fail(failAlert);"></th></tr>
                </table><br/>
                <div id="show_results"></div>
            </td>
            <!--Link here to new_program.php-->
            <td style="padding-left: 100px;">
<?php
                                    if ($USER->site_access_level($Bickerdike_id) <= $DataEntryAccess){
?>
<a href="new_program.php"class="add_new "><span class="add_new_button">Create New Program</span></a>
<?php
                                    } //end access check
?>
<br/><br/>
                <strong><em>Click on a category to see programs / details:</em></strong><br />
                <br />
                    <?php
                    //get number of total records
                    $number_of_programs_query_sqlsafe = "SELECT COUNT(*) AS Record_Count FROM Programs";
                    include "../include/dbconnopen.php";
                    $number_of_programs = mysqli_query($cnnBickerdike, $number_of_programs_query_sqlsafe);
                    $number_of_programs = mysqli_fetch_array($number_of_programs);
                    $number_of_programs = $number_of_programs['Record_Count'];
                    include "../include/dbconnclose.php";
                    
                    $year_add = 0;
                    //loop through, until programs are all accounted for
                    while ($number_of_programs > 1) {
                        $year_add++;
                        
                        //alphabetical list of all programs, each of which links to its own profile page
                        //$program_query = "SELECT * FROM Programs ORDER BY Program_Name";
                        $program_query_sqlsafe = "SELECT * FROM Programs "
                                        . "WHERE Program_Created_Date BETWEEN '" . (2011 + $year_add) . "-09-01' AND '" . (2012 + $year_add) . "-08-31' "
                                        . "ORDER BY Program_Name";
                        include "../include/dbconnopen.php";
                        $programs = mysqli_query($cnnBickerdike, $program_query_sqlsafe);
                        
                        //header
                        echo "<a href=\"javascript:;\" onclick=\"$('#category_div_" . $year_add . "').slideToggle('slow');\">Year "
                                . $year_add . " Programs - September " . (2011 + $year_add) . "-August " . (2012 + $year_add) . "</a><br />";
                        echo "<div id=\"category_div_" . $year_add . "\" style=\"display: none;\">";
                        
                        //if more than one row deduct first record
                        if ($programs->num_rows > 0) {
                            $number_of_programs--;
                        }
                        
                        //loop through year's programs
                        while ($program = mysqli_fetch_array($programs)) {
                            //reduce number of programs count
                            $number_of_programs--;
                            ?>
                            &nbsp; &bull; <a href="program_profile.php?program=<?php echo $program['Program_ID']; ?>"><?php echo $program['Program_Name']; ?></a><br />
                        <?php
                        }
                        echo "</div>";
                        include "../include/dbconnclose.php";
                    }
                    ?>
            </td>
        </tr>
    </table>
</div>
<?php include "../../footer.php"; ?>
