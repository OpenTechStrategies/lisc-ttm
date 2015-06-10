<?php
include "../../header.php";
include "../header.php";
?>
<script type = "text/javascript">
    $(document).ready(function(){
        $('.save_form').hide();
        $('form').live('submit', function(){
            $.post($(this).attr('action'), $(this).serialize(), function(response){
                window.location = "issue_events_report.php";
            },'json');
            return false;
        });
    });
</script>
<!--Query search for people who attended some of the Issue Area Events (e.g. signed up for SNAP)-->
    <h3>Services Rendered Report</h3>
<table class="all_projects">
    <tr><th class="all_projects">Service Type</th><th class="all_projects">YTD Total Participants Served</th><th class="all_projects">YTD Unique Participants Served</th><th>YTD Number of non-participants served</th><th>YTD Total number served</th><th class="all_projects">Choose Month</th><th class="all_projects">Choose Year</th>
    <th class="all_projects"></th></tr>
<?php
    $get_areas="SELECT * FROM Issue_Areas ORDER BY Issue_Area";
include "../include/dbconnopen.php";
$areas=mysqli_query($cnnLSNA, $get_areas);
while ($area=mysqli_fetch_row($areas)){
?>
    <tr><th class="all_projects"><?php echo $area[1];?></th>
    <td class="all_projects">
<?php
    date_default_timezone_set('America/Chicago');
    $get_year=date('Y');
    $ytd_num="SELECT * FROM Issue_Attendance WHERE Issue_ID=$area[0] AND Year=$get_year";
// echo $ytd_num;
    $ytd_num_call=mysqli_query($cnnLSNA, $ytd_num);
    echo $num_participants_served = mysqli_num_rows($ytd_num_call);
?>
    </td>
    <td class="all_projects">
<?php
    date_default_timezone_set('America/Chicago');
    $get_year=date('Y');
    $ytd_num="SELECT DISTINCT Participant_ID FROM Issue_Attendance WHERE Issue_ID=$area[0] AND Year=$get_year";
    $ytd_num_call=mysqli_query($cnnLSNA, $ytd_num);
    echo  mysqli_num_rows($ytd_num_call);
?>
    </td>
<td class="all_projects"><b>
<?php
    date_default_timezone_set('America/Chicago');
    $get_year=date('Y');
    $ytd_num_manual="SELECT SUM(Number_Served) FROM Issue_Service WHERE Issue_ID=$area[0] AND Year=$get_year";
    $ytd_num_nonpart=mysqli_query($cnnLSNA, $ytd_num_manual);
    echo $number_nonparticipants = mysqli_fetch_array($ytd_num_nonpart)[0];

?></b>
<br><a href = "javascript:;" onclick = "$('#save_form_<?php echo $area[0]; ?>').toggle()">Add number of non-participants</a>
<form method = "post" action = "add_issue_attendance.php" id = "save_form_<?php echo $area[0]; ?>" class = "save_form"">
<input type="text" name="num_served" size = "5">
<input type = "hidden" name = "save_number">
<input type = "hidden" name = "issue" value = "<?php echo $area[0]; ?>">
<select name = "month_served">
    <option value="">-----</option>
    <option value="1">January</option>
    <option value="2">February</option>
    <option value="3">March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
    </select>
<select name = "year_served"
    <option value="">-----</option>
    <option>2012</option>
    <option>2013</option>
    <option>2014</option>
    <option>2015</option>
    <option>2016</option>
    </select>
<input type="submit" name="Save_number_manually" value="Save">
</form>
</td>
<td class="all_projects">
<?php
    echo $num_participants_served + $number_nonparticipants;
?>
</td>
    <td class="all_projects"><select id="issue_month_<?php echo $area[0]; ?>">
    <option value="">-----</option>
    <option value="1">January</option>
    <option value="2">February</option>
    <option value="3">March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
    </select></td>
    <td class="all_projects"><select id="issue_year_<?php echo $area[0]; ?>">
    <option value="">-----</option>
    <option>2012</option>
    <option>2013</option>
    <option>2014</option>
    <option>2015</option>
    <option>2016</option>
    </select></td>
    <td class="all_projects" ><input type="button" value="Filter" onclick="$.post(
'add_issue_attendance.php',
{
action: 'filter',
issue: <?php echo $area[0];?>,
issue_month: document.getElementById('issue_month_<?php echo $area[0]; ?>').value,
issue_year: document.getElementById('issue_year_<?php echo $area[0]; ?>').value
},
function (response){
document.getElementById('filter_response_<?php echo $area[0];?>').innerHTML = response;
}
)">
                                                                      <span id="filter_response_<?php echo $area[0];?>"></span>
    </td>
    </tr>
<?php
}
include "../include/dbconnclose.php";
?>
</table>
<p></p>
<h4>Search by Service, Month, and Year</h4>
    <p></p>
    <table class="all_projects">
    <tr><th>Service:</th><td><select id="issue_area">
    <option value="">-----</option>
<?php
    $get_areas="SELECT * FROM Issue_Areas";
include "../include/dbconnopen.php";
$areas=mysqli_query($cnnLSNA, $get_areas);
while ($area=mysqli_fetch_row($areas)){
?>
    <option value="<?php echo $area[0];?>"><?php echo $area[1];?></option>
<?php
}
include "../include/dbconnclose.php";
?>
</select></td></tr>
<tr>
<th>Month:</th><td><select id="issue_month">
    <option value="">-----</option>
    <option value="1">January</option>
    <option value="2">February</option>
    <option value="3">March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
    </select></td> </tr>
    <tr><th>Year:</th>
    <td><select id="issue_year">
    <option value="">-----</option>
    <option>2012</option>
    <option>2013</option>
    <option>2014</option>
    <option>2015</option>
    <option>2016</option>
    </select>
    </tr>
    <tr><th colspan="2"><input type="button" value="Search" onclick="
$.post(
'add_issue_attendance.php',
{
action: 'search',
issue: document.getElementById('issue_area').value,
issue_month: document.getElementById('issue_month').value,
issue_year: document.getElementById('issue_year').value
},
function (response){
document.getElementById('get_issue_response').innerHTML = response;
}
)
"</th></tr>
    </table>
    <p></p>
    <h4>Add a New Service</h4>
    <table class="all_projects">
    <tr><th>New Service Name</th><th></th></tr>
    <tr><td class="all_projects"><input type="text" id="new_service_rendered"></td><td><input type="button" value="Save" onclick="
$.post(
'add_issue_attendance.php',
{
action: 'new_service',
service_name: document.getElementById('new_service_rendered').value
},
function (response){
// document.write(response);
alert('You have successfully saved a new service.');
window.location='issue_events_report.php';
}
)" ></td></tr>
    </table>
    <span id="get_issue_response"></span>
<?php include "../../footer.php";?>