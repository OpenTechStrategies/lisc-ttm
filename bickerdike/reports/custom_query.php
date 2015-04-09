<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Bickerdike_id);

include "../../header.php";
include "../header.php";
?>

<!--
custom query
-->

<script type="text/javascript">
	$(document).ready(function(){
		$('#data_selector').addClass('selected');
		$('#adult_selector').addClass('selected');
                for (var i=0; i<50; i++){
                    $('#names_of_people_measured_'+i).hide();
                }
	});
</script>
<div class="content_wide">

<h3>Custom Query:</h3><br/>
<style>
.all_projects tr td {
  border-bottom: 1pt solid #cccccc;
}    
</style>
<form method="post" action="./custom_query_submit.php">
<table class="all_projects" style="bor">
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <td>
                        First Name:
                    </td>
                    <td>
                        <input type="text" name="first_name" id="first_name" />
                    </td>
                    <td>&nbsp; &nbsp;</td>
                    <td>
                        Last Name:
                    </td>
                    <td>
                        <input type="text" name="last_name" id="last_name" />
                    </td>
                    <td>&nbsp; &nbsp;</td>
                    <td>
                        Participant Type:
                    </td>
                    <td>
                        <select name="participant_type" id="participant_type">
                            <option value="">-----</option>
                            <option value="adult">Adult</option>
                            <option value="parent">Parent</option>
                            <option value="youth">Youth</option>
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <td>
                        Gender:
                    </td>
                    <td>
                        <select name="gender" id="gender">
                            <option value="">-----</option>
                            <option value="F">Female</option>
                            <option value="M">Male</option>
                        </select>
                    </td>
                    <td>&nbsp; &nbsp;</td>
                    <td>
                        Age:
                    </td>
                    <td>
                        <select name="age" id="age">
                            <option value="">-----</option>
                            <option value="12">10-19</option>
                            <option value="20">20-34</option>
                            <option value="35">35-44</option>
                            <option value="45">45-59</option>
                            <option value="60">60 or over</option>
                        </select>
                    </td>
                    <td>&nbsp; &nbsp;</td>
                    <td>
                        Race/Ethnicity:
                    </td>
                    <td>
                        <select name="race" id="race">
                            <option value="">-----</option>
                            <option value="b">Black</option>
                            <option value="l">Latino</option>
                            <option value="a">Asian</option>
                            <option value="w">White</option>
                            <option value="o">Other</option>
                        </select>
                    </td>
                    <td>&nbsp; &nbsp;</td>
                    <td>
                        Survey Type:
                    </td>
                    <td>
                        <select name="survey_type" id="survey_type">
                            <option value="">----</option>
                            <option value="1">Pre</option>
                            <option value="2">Post</option>
                            <option value="3">Late</option>
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <td>
                        Address Number:
                    </td>
                    <td>
                        <input type="text" name="address_number" id="address_number" />
                    </td>
                    <td>&nbsp; &nbsp;</td>
                    <td>
                        Street Direction:
                    </td>
                    <td>
                        <input type="text" name="address_street_direction" id="address_street_direction" />
                    </td>
                    <td>&nbsp; &nbsp;</td>
                    <td>
                        Street Name:
                    </td>
                    <td>
                        <input type="text" name="address_street_name" id="address_street_name" />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
   <tr>
        <td colspan="2">
            <table>
                <tr>
                    <td>
                        Street Type:
                    </td>
                    <td>
                        <input type="text" name="address_street_type" id="address_street_type" />
                    </td>
                    <td>&nbsp; &nbsp;</td>
                    <td>
                        Zipcode:
                    </td>
                    <td>
                        <select name="zipcode" id="zipcode">
                            <option value="">-----</option>
                            <?php
                            $get_zips_sqlsafe = "SELECT Zipcode FROM Users WHERE Zipcode !=0 GROUP BY Zipcode";
                            include "../include/dbconnopen.php";
                            $zips = mysqli_query($cnnBickerdike, $get_zips_sqlsafe);
                            while ($zip = mysqli_fetch_row($zips)) {
                                ?>
                                <option value="<?php echo $zip[0]; ?>"><?php echo $zip[0]; ?></option>
                                <?php
                            }
                            include "../include/dbconnclose.php";
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td>
            Program Name:
        </td>
        <td>
            <select name="program_id" id="program_id">
                <option value="">-----</option>
                <?php
                $get_programs_sqlsafe = "SELECT * FROM Programs";
                include "../include/dbconnopen.php";
                $programs = mysqli_query($cnnBickerdike, $get_programs_sqlsafe);
                while ($program = mysqli_fetch_array($programs)) {
                    ?>
                    <option value="<?php echo $program['Program_ID']; ?>"><?php echo $program['Program_Name']; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            2: How important is diet and nutrition to you personally?
        </td>
        <td>
            <select name="question_2" id="question_2">
                <option value="">----</option>
                <option value="4">Not at all important</option>
                <option value="3">Not too important</option>
                <option value="2">Somewhat important</option>
                <option value="1">Very important</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            3: How many servings of fruits and vegetables do you eat in an average day?
        </td>
        <td>
            <input type="text" name="question_3" id="question_3" size="7" /> servings
        </td>
    </tr>
    <tr>
        <td>
            4a: How many days per week do you do strenuous physical activity for at least 10 minutes at a time?
        </td>
        <td>
            <input type="text" name="question_4_a" id="question_4_a" size="7" /> days
        </td>
    </tr>
    <tr>
        <td>
            4b: How many minutes on those days?
        </td>
        <td>
            <input type="text" name="question_4_b" id="question_4_b" size="7" /> minutes
        </td>
    </tr>
    <tr>
        <td>
            5a: How many days per week do you do light to moderate physical activity for at least 10 minutes at a time?
        </td>
        <td>
            <input type="text" name="question_5_a" id="question_5_a" size="7" /> days
    </tr>
    <tr>
        <td>
            5b: How many minutes on those days?
        </td>
        <td>
            <input type="text" name="question_5_b" id="question_5_b" size="7" /> minutes
        </td>
    </tr>
    <tr>
        <td>
            6: Do you have at least one child between the ages of 0-18 that lives with you at least 3 days per week? <em>If no, skip to Question 9.</em>
        </td>
        <td>
            <select name="question_6" id="question_6">
                <option value="">----</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            7: On an average day, how many servings of fruits and vegetables does your child eat?
        </td>
        <td>
            <input type="text" name="question_7" id="question_7" size="7" /> servings (or leave blank if not applicable)
        </td>
    </tr>
    <tr>
        <td>
            8: On an average day, how many hours and minutes does your child spend in active play?
        </td>
        <td>
            <input type="text" name="question_8" id="question_8" size="7" /> [in total minutes]
        </td>
    </tr>
    <tr>
        <td>
            9a: I would walk more often if I felt safer in my community.
        </td>
        <td>
            <select name="question_9_a" id="question_9_a">
                <option value="">----</option>
                <option value="4">Strongly Disagree</option>
                <option value="3">Disagree</option>
                <option value="2">Agree</option>
                <option value="1">Strongly Agree</option>
            </select>
        </td>
    </tr>
      
    <tr>
        <td>
            9b: I feel comfortable with my child playing outside in my community.
        </td>
        <td>
            <select name="question_9_b" id="question_9_b">
                <option value="">----</option>
                <option value="4">Strongly Disagree</option>
                <option value="3">Disagree</option>
                <option value="2">Agree</option>
                <option value="1">Strongly Agree</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            10: How satisfied or dissatisfied are you with the selection of fruits and vegetables available at the store where you usually shop for food?
        </td>
        <td>
            <select name="question_14" id="question_14">
                <option value="">----</option>
                <option value="1">Not at all satisfied</option>
                <option value="2">Not too satisfied</option>
                <option value="3">Somewhat satisfied</option>
                <option value="4">Very satisfied</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            11: Have you seen signs, fliers, programs, or local billboards in your community that address the importance of eating healthy and exercising regularly?
        </td>
        <td>
            <select name="question_11" id="question_11">
                <option value="">-----</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            12: Are you aware of free or low-cost fitness opportunities in Humboldt Park?
        </td>
        <td>
            <select name="question_12" id="question_12">
                <option value="">----</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </td>
    </tr>
    
    <tr>
        <td>
            13: Are you aware of free or low-cost nutrition opportunities in Humboldt Park?
        </td>
        <td>
            <select name="question_13" id="question_13">
                <option value="">----</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            Date of survey:
        </td>
        <td>
            <input type="text" name="date_survey_administered" id="date_survey_administered" />
            <link href="/include/jquery/1.9.1/css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css" />
            <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.core.js" type="text/javascript"></script>
            <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.widget.js" type="text/javascript"></script>
            <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.datepicker.js" type="text/javascript"></script>
            <script>
                $(function() {
                    $("#date_survey_administered").datepicker({dateFormat: "mm/dd/yy",
                    changeYear: true,
                    yearRange: "1920:2030"});
                });
        </script>
        </td>
    </tr>
    <tr>
        <td>
            Program Organization:
        </td>
        <td>
            <select name="partner_id" id="partner_id">
                <option value="">-----</option>
                <?php
                $get_organizations_sqlsafe = "SELECT * FROM Org_Partners";
                include "../include/dbconnopen.php";
                $organizations = mysqli_query($cnnBickerdike, $get_organizations_sqlsafe);
                while ($organization = mysqli_fetch_array($organizations)) {
                    ?>
                    <option value="<?php echo $organization['Partner_ID']; ?>"><?php echo $organization['Partner_Name']; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="center" colspan="2">
            <input type="submit" value="Export" />
        </td>
    </tr>
</table>
</form>
</div>
<?php include "../../footer.php"; ?>