<?
	include "../../header.php";
	include "../header.php";
	include "../include/dbconnopen.php";
        include "../include/datepicker_simple.php";
	$get_parent_info_sqlsafe = "SELECT * FROM Participants WHERE Participant_ID='" . mysqli_real_escape_string($cnnTRP, $_GET['origin']) . "'";
	$parent_info = mysqli_query($cnnTRP, $get_parent_info_sqlsafe);
	$parent = mysqli_fetch_array($parent_info);
        
        /* show responses to the Gads Hill parent survey: */
?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#participants_selector').addClass('selected');
		});
</script>

<h3>Gads Hill Survey - <?echo $parent['First_Name'] . " " . $parent['Last_Name'];?></h3><hr/><br/>
<a href="profile.php?id=<?echo $_GET['origin'];?>">Return to participant profile</a>
<div id="gads_hill_parent_survey">
<table class="pm_survey">
    
    <?$get_survey_sqlsafe="SELECT * FROM Gads_Hill_Parent_Survey WHERE Gads_Hill_Parent_Survey_ID='" . mysqli_real_escape_string($cnnTRP, $_GET['id']) . "'";
    $survey=mysqli_query($cnnTRP, $get_survey_sqlsafe);
    $info=mysqli_fetch_array($survey);
    include "../include/dbconnclose.php";?>

    <tr><td class="pm_survey question">Grade</td>
        <td class="pm_survey response"><?echo $info['Child_Grade'];?></td></tr>
    <tr><td class="pm_survey question">Date</td>
        <td class="pm_survey response"><?echo $info['Date_Surveyed'];?></td></tr>
    
    <tr><td class="pm_survey question"><strong>Since August, how often have you done the following activities with your child? </strong></td>
        <td class="pm_survey response"></td></tr>
    <tr><td class="pm_survey question">1. Talked to my child about his/her school work. </td>
        <td class="pm_survey response"><?if ($info['First_Part_1']==1){echo 'Not at all';}
                                         elseif($info['First_Part_1']==2){echo 'Once or twice';}
                                         elseif($info['First_Part_1']==3){echo 'About once a week';}
                                         elseif($info['First_Part_1']==4){echo '2 to 3 days a week';}
                                         elseif($info['First_Part_1']==5){echo '4 or more days a week';}?></td></tr>
    <tr><td class="pm_survey question">2. Helped my child with his/her homework. </td>
        <td class="pm_survey response"><?if ($info['First_Part_2']==1){echo 'Not at all';}
                                         elseif($info['First_Part_2']==2){echo 'Once or twice';}
                                         elseif($info['First_Part_2']==3){echo 'About once a week';}
                                         elseif($info['First_Part_2']==4){echo '2 to 3 days a week';}
                                         elseif($info['First_Part_2']==5){echo '4 or more days a week';}?></td></tr>
    <tr><td class="pm_survey question">3.	Helped my child find a tutor or other support for his /her school work. </td>
        <td class="pm_survey response"><?if ($info['First_Part_3']==1){echo 'Not at all';}
                                         elseif($info['First_Part_3']==2){echo 'Once or twice';}
                                         elseif($info['First_Part_3']==3){echo 'About once a week';}
                                         elseif($info['First_Part_3']==4){echo '2 to 3 days a week';}
                                         elseif($info['First_Part_3']==5){echo '4 or more days a week';}?></td></tr>
    <tr><td class="pm_survey question">4.	Talked to my child about the importance of graduating from high school.</td>
        <td class="pm_survey response"><?if ($info['First_Part_4']==1){echo 'Not at all';}
                                         elseif($info['First_Part_4']==2){echo 'Once or twice';}
                                         elseif($info['First_Part_4']==3){echo 'About once a week';}
                                         elseif($info['First_Part_4']==4){echo '2 to 3 days a week';}
                                         elseif($info['First_Part_4']==5){echo '4 or more days a week';}?></td></tr>
    <tr><td class="pm_survey question">5.	Talked with my child about a book he/she is reading.</td>
        <td class="pm_survey response"><?if ($info['First_Part_5']==1){echo 'Not at all';}
                                         elseif($info['First_Part_5']==2){echo 'Once or twice';}
                                         elseif($info['First_Part_5']==3){echo 'About once a week';}
                                         elseif($info['First_Part_5']==4){echo '2 to 3 days a week';}
                                         elseif($info['First_Part_5']==5){echo '4 or more days a week';}?></td></tr>
    <tr><td class="pm_survey question">6.	Encouraged my child to go to the library to check out books. </td>
        <td class="pm_survey response"><?if ($info['First_Part_6']==1){echo 'Not at all';}
                                         elseif($info['First_Part_6']==2){echo 'Once or twice';}
                                         elseif($info['First_Part_6']==3){echo 'About once a week';}
                                         elseif($info['First_Part_6']==4){echo '2 to 3 days a week';}
                                         elseif($info['First_Part_6']==5){echo '4 or more days a week';}?></td></tr>
    <tr><td class="pm_survey question">7.	Gone with my child to a museum.</td>
        <td class="pm_survey response"><?if ($info['First_Part_7']==1){echo 'Not at all';}
                                         elseif($info['First_Part_7']==2){echo 'Once or twice';}
                                         elseif($info['First_Part_7']==3){echo 'About once a week';}
                                         elseif($info['First_Part_7']==4){echo '2 to 3 days a week';}
                                         elseif($info['First_Part_7']==5){echo '4 or more days a week';}?></td></tr>
    <tr><td class="pm_survey question">8.	Gone with my child to a community event (like a farmer's market or community celebration). </td>
        <td class="pm_survey response"><?if ($info['First_Part_8']==1){echo 'Not at all';}
                                         elseif($info['First_Part_8']==2){echo 'Once or twice';}
                                         elseif($info['First_Part_8']==3){echo 'About once a week';}
                                         elseif($info['First_Part_8']==4){echo '2 to 3 days a week';}
                                         elseif($info['First_Part_8']==5){echo '4 or more days a week';}?></td></tr>
    <tr><td class="pm_survey question">9.	Met with my child's teacher or teachers to talk about his/her progress at school. </td>
        <td class="pm_survey response"><?if ($info['First_Part_9']==1){echo 'Not at all';}
                                         elseif($info['First_Part_9']==2){echo 'Once or twice';}
                                         elseif($info['First_Part_9']==3){echo 'About once a week';}
                                         elseif($info['First_Part_9']==4){echo '2 to 3 days a week';}
                                         elseif($info['First_Part_9']==5){echo '4 or more days a week';}?></td></tr>
   
    <tr><td class="pm_survey question"><strong>How much do you agree or disagree with the following statements? </strong></td>
        <td class="pm_survey response"></td></tr>
    
    <tr><td class="pm_survey question">1. I think it is important to talk to my child about his/her school work.</td>
        <td class="pm_survey response"><?if ($info['Second_Part_1']==1){echo 'Strongly disagree';}
                                         elseif($info['Second_Part_1']==2){echo 'Disagree';}
                                         elseif($info['Second_Part_1']==3){echo 'Neither disagree nor agree';}
                                         elseif($info['Second_Part_1']==4){echo 'Agree';}
                                         elseif($info['Second_Part_1']==5){echo 'Strongly agree';}?></td></tr>
    <tr><td class="pm_survey question">2. I feel confident in my ability to help my child with his/her homework.</td>
        <td class="pm_survey response"><?if ($info['Second_Part_2']==1){echo 'Strongly disagree';}
                                         elseif($info['Second_Part_2']==2){echo 'Disagree';}
                                         elseif($info['Second_Part_2']==3){echo 'Neither disagree nor agree';}
                                         elseif($info['Second_Part_2']==4){echo 'Agree';}
                                         elseif($info['Second_Part_2']==5){echo 'Strongly agree';}?></td></tr>
    <tr><td class="pm_survey question">3. I think it is important to talk to my child about his/her plans for the future. </td>
        <td class="pm_survey response"><?if ($info['Second_Part_3']==1){echo 'Strongly disagree';}
                                         elseif($info['Second_Part_3']==2){echo 'Disagree';}
                                         elseif($info['Second_Part_3']==3){echo 'Neither disagree nor agree';}
                                         elseif($info['Second_Part_3']==4){echo 'Agree';}
                                         elseif($info['Second_Part_3']==5){echo 'Strongly agree';}?></td></tr>
    <tr><td class="pm_survey question">4. I feel confident in my ability to help my child prepare for his/her future.</td>
        <td class="pm_survey response"><?if ($info['Second_Part_4']==1){echo 'Strongly disagree';}
                                         elseif($info['Second_Part_4']==2){echo 'Disagree';}
                                         elseif($info['Second_Part_4']==3){echo 'Neither disagree nor agree';}
                                         elseif($info['Second_Part_4']==4){echo 'Agree';}
                                         elseif($info['Second_Part_4']==5){echo 'Strongly agree';}?></td></tr>
    
    
    
    <tr><td class="pm_survey question">Comments:</td>
        <td class="pm_survey response"><?echo $info['Comments'];?></td></tr>
    
    
</table>

</div>
<br/><br/>

<?
	//include "../include/dbconnclose.php";
	include "../../footer.php";
?>