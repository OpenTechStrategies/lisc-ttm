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
                                $program_query = "SELECT * FROM Programs GROUP BY Program_Organization";
                                include "../include/dbconnopen.php";
                                $programs = mysqli_query($cnnBickerdike, $program_query);
                                while ($program = mysqli_fetch_array($programs)) {
                                    ?>
                                    <option value="<?php echo $program['Program_Organization']; ?>"><?php
                                        $find_org = "SELECT * FROM Org_Partners WHERE Partner_ID='" . $program['Program_Organization'] . "'";
                                        include "../include/dbconnopen.php";
                                        $org = mysqli_query($cnnBickerdike, $find_org);
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
                                $program_query = "SELECT * FROM Program_Types ORDER BY Program_Type_Name";
                                include "../include/dbconnopen.php";
                                $programs = mysqli_query($cnnBickerdike, $program_query);
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
                                    )"></th></tr>
                </table><br/>
                <div id="show_results"></div>
            </td>
            <!--Link here to new_program.php-->
            <td style="padding-left: 100px;"><a href="new_program.php"class="add_new hide_on_view"><span class="add_new_button">Create New Program</span></a><br/><br/>
                <strong><em>Click on a category to see programs / details:</em></strong><br />
                <br />
                    <?php
                    //get number of total records
                    $number_of_programs_query = "SELECT COUNT(*) AS Record_Count FROM Programs";
                    include "../include/dbconnopen.php";
                    $number_of_programs = mysqli_query($cnnBickerdike, $number_of_programs_query);
                    $number_of_programs = mysqli_fetch_array($number_of_programs);
                    $number_of_programs = $number_of_programs['Record_Count'];
                    include "../include/dbconnclose.php";
                    
                    $year_add = 0;
                    //loop through, until programs are all accounted for
                    while ($number_of_programs > 1) {
                        $year_add++;
                        
                        //alphabetical list of all programs, each of which links to its own profile page
                        //$program_query = "SELECT * FROM Programs ORDER BY Program_Name";
                        $program_query = "SELECT * FROM Programs "
                                        . "WHERE Program_Created_Date BETWEEN '" . (2011 + $year_add) . "-09-01' AND '" . (2012 + $year_add) . "-08-31' "
                                        . "ORDER BY Program_Name";
                        /* echo "SELECT * FROM Programs "
                                        . "WHERE Program_Created_Date BETWEEN '" . (2011 + $year_add) . "-09-01' AND '" . (2012 + $year_add) . "-08-31' "
                                        . "ORDER BY Program_Name";
                         * 
                         */
                        include "../include/dbconnopen.php";
                        $programs = mysqli_query($cnnBickerdike, $program_query);
                        
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
                    <?php
                    /*
                    //alphabetical list of all programs, each of which links to its own profile page
                    //$program_query = "SELECT * FROM Programs ORDER BY Program_Name";
                    $program_query = "SELECT Programs.*, YEAR(Programs.Program_Created_Date) AS Program_Year, "
                                    . "Program_Types.Program_Type_Name "
                                    . "FROM Programs, Program_Types "
                                    . "WHERE "
                                    . "Program_Types.Program_Type_ID = Programs.Program_Type "
                                    . "ORDER BY "
                                    . "Program_Type_Name, YEAR(Program_Created_Date), Program_Name";
                    include "../include/dbconnopen.php";
                    $programs = mysqli_query($cnnBickerdike, $program_query);

                    //sort by program type (category), year, alphabetical
                    $category_div = '';
                    $category_flag = 0;
                    $year_div = '';
                    $countt = 0; // to disable first element </div>s
                    while ($program = mysqli_fetch_array($programs)) {
                        $countt++;
                        //category divs if different from the previous
                        if ($category_div != $program['Program_Type']) {
                            $category_flag = 1;
                            $category_div = $program['Program_Type'];
                            echo ($countt != 1) ? "</div></div><br />" : "";
                            echo "<a href=\"javascript:;\" onclick=\"$('#category_div_" . $program['Program_Type'] . "').slideToggle('slow');\">" . $program['Program_Type_Name'] . "</a>";
                            echo "<div id=\"category_div_" . $program['Program_Type'] . "\" style=\"display: none;\">";
                        }
                        //year divs if different from the previous or new category
                        if (($year_div != $program['Program_Year']) || ($category_flag == 1)) {
                            $year_div = $program['Program_Year'];
                            if ($category_flag == 0) {
                                echo ($countt != 1) ? "</div><br />\r\n" : "";
                            }
                            $category_flag = 0;
                            echo "&nbsp; <a href=\"javascript:;\" onclick=\"$('#year_div_" . $program['Program_Type'] . "_" . $program['Program_Year'] . "').slideToggle('slow');\">" . $program['Program_Year'] . "</a>";
                            echo "<div id=\"year_div_" . $program['Program_Type'] . "_" . $program['Program_Year'] . "\" style=\"display: none;\">";
                        }
                        ?>
                        &nbsp; &nbsp; &bull; <a href="program_profile.php?program=<?php echo $program['Program_ID']; ?>"><?php echo $program['Program_Name']; ?></a><br />
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?>
                    </div>
                </div>
                     <?php
                     * 
                     */
                ?>
            </td>
        </tr>
    </table>
</div>
<?php include "../../footer.php"; ?>
