<div id="teacher_surveys">
    <!--This jqplot stuff is actually irrelevant, since we didn't end up making a chart for the teacher surveys: -->
    
        <!--[if IE]>
<script src="/include/excanvas_r3/excanvas.js"></script>
<![endif]-->
<!--<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.min.js"></script>-->
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.css" />
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.pointLabels.min.js"></script>

<!--Since the pre and post surveys ask some different questions, the responses are separated here. -->
<h4>Pre-Program Surveys</h4>
<div style="text-align:center;"><span class="helptext">Total number of pre-program surveys:</span>
<?
	$get_surveys="SELECT * FROM PM_Teacher_Survey";
	include "../include/dbconnopen.php";
	$surveys=mysqli_query($cnnLSNA, $get_surveys);
	$num_surveys=mysqli_num_rows($surveys);
	echo $num_surveys;
	include "../include/dbconnclose.php";
?></div>
<br/>
<?/*get columns that should be answered with percentages: */
$percent_questions_arr=array(
    'Classroom_Language',
            'Years_In_Program',
    'Languages',
        'Years_As_Teacher',
        'Years_At_School');
foreach($percent_questions_arr as $question){
            /*get responses to each of these questions: */
            $call_for_arrays="CALL get_count_teacher_surveys('" .$question . "')";
            
            include "../include/dbconnopen.php";
            $questions=mysqli_query($cnnLSNA, $call_for_arrays);
            $num_options = mysqli_num_rows($questions);
            $total_responses=0;
            while ($survey = mysqli_fetch_row($questions)){
            foreach($survey as $key => $value)
                {
                //creates the correct arrays for results, below
                if ($key==0){
                                $array_key=$value;
                        }
                elseif ($key==1){
                            $array_value=$value;
                            $total_responses+=$value;
                        }
                    ${$question.'_arr'}[$array_key]=$array_value;
                }
            }
}

/* get columns that should be answered with averages/totals. */
$averages_questions_arr=array('Num_Students',
        'Num_ELL_Students',
        'Num_IEP_Students',
        'Num_Students_Below_Grade_Level');
foreach($averages_questions_arr as $question){
            $call_for_arrays="CALL get_sum_teacher_surveys('" .$question . "')";
            //echo $call_for_arrays;
            include "../include/dbconnopen.php";
            $questions=mysqli_query($cnnLSNA, $call_for_arrays);
            $num_options = mysqli_num_rows($questions);
            
          while ($survey = mysqli_fetch_row($questions)){
                ${$question.'_total'}=$survey[0];
          }
}

/*task responses are shown below, with the post responses.*/
$task_questions_arr=array(
    'Task_1',    'Task_2',    'Task_3',    'Task_4',
    'Task_5',    'Task_6',    'Task_7',    'Task_8',
    'Task_9',    'Task_10');
foreach($task_questions_arr as $question){
            $call_for_arrays="CALL get_count_teacher_surveys('" .$question . "')";
            //echo $call_for_arrays;
            include "../include/dbconnopen.php";
            $questions=mysqli_query($cnnLSNA, $call_for_arrays);
          while ($survey = mysqli_fetch_row($questions)){
              if ($survey[0]==1){
                  ${$question.'_num'}=$survey[1];
              }
            }
}


?>
<table>
<tr>
    <!-- The arrays were created above with the compound variables.  Column name+arr. -->
	<td width="50%"><strong>Question 4: </strong>Is your classroom bilingual? <!--show % for each response-->
		<div class="question_summary">
			Bilingual: <?echo number_format(($Classroom_Language_arr[1]/$total_responses)*100) . '%';?><br/>
			Regular:  <?echo number_format(($Classroom_Language_arr[2]/$total_responses)*100) . '%';?><br/>
			Other: <?echo number_format(($Classroom_Language_arr[3]/$total_responses)*100) . '%';?> <br/>
		</div></td>
	<td><strong>Question 5: </strong>How many years have you participated in the Parent Mentor program? <!--show % for each response-->
		<div class="question_summary">
			First year:  <?echo number_format(($Years_In_Program_arr[1]/$total_responses)*100) . '%';?><br/>
			Second year: <?echo number_format(($Years_In_Program_arr[2]/$total_responses)*100) . '%';?><br/>
			Third year (or more): <?echo number_format(($Years_In_Program_arr[3]/$total_responses)*100) . '%';?><br/>
		</div></td>
</tr>
<tr>
	<td><strong>Question 6: </strong>Which languages do you speak? <!--show % for each response-->
		<div class="question_summary">
			English: <?echo number_format(($Languages_arr[1]/$total_responses)*100) . '%';?><br/>
			Spanish: <?echo number_format(($Languages_arr[2]/$total_responses)*100) . '%';?><br/>
			Other: <?echo number_format(($Languages_arr[3]/$total_responses)*100) . '%';?><br/>
                        Both English and Spanish: <?echo number_format(($Languages_arr[4]/$total_responses)*100) . '%';?><br/>
		</div></td>
	<td><strong>Question 7: </strong>How many years have you been a teacher? <!--pie chart of responses-->
		<div class="question_summary">
		<?
                foreach ($Years_As_Teacher_arr as $key=>$value){
                    echo $key . " years: " . number_format(($value/$total_responses)*100) . '%' . "<br>";
                }
                ?>
		</div></td>
</tr>
<tr>
	<td><strong>Question 8: </strong>How many years have you worked at this school? <!--pie chart of responses-->
		<div class="question_summary">
		<?
                foreach ($Years_At_School_arr as $key=>$value){
                    echo $key . " years: " . number_format(($value/$total_responses)*100) . '%' . "<br>";
                }
                ?>
		</div></td>
	<td><strong>Question 9: </strong>How many students do you have in your classroom?
		<div class="question_summary">
			Average: <?echo $Num_Students_total/$total_responses;?><br/>
			Total: <?echo $Num_Students_total;?><br/>
		</div></td>
</tr>
<tr>
	<td><strong>Question 10: </strong>How many of your students are ELL?
		<div class="question_summary"><!--grand total and percentage of all students (from q 9 above)-->
			Total: <?echo $Num_ELL_Students_total;?><br/>
                        Percent of total: <?echo number_format(($Num_ELL_Students_total/$Num_Students_total)*100) . '%';?><br/>
		</div></td>
	<td><strong>Question 11: </strong>How many of your students have IEPs or special needs?
		<div class="question_summary">
			<!--grand total and percentage of all students (from q 9 above)-->
                        Total: <?echo $Num_IEP_Students_total;?><br/>
                        Percent of total: <?echo number_format(($Num_IEP_Students_total/$Num_Students_total)*100) . '%';?><br/>
		</div></td>
</tr>
<tr>
	<td><strong>Question 12: </strong>How many of your students started the year below grade level?
		<div class="question_summary">
			 <!--grand total and percentage of all students (from q 9 above)-->
                        Total: <?echo $Num_Students_Below_Grade_Level_total;?><br/>
                        Percent of total: <?echo number_format(($Num_Students_Below_Grade_Level_total/$Num_Students_total)*100) . '%';?><br/>
		</div></td>
	<td></td>
</tr>
</table>

	<!--questions 14 and 15 are free text...not clear how/if we'll be reporting on these... -->
	<!--<li><strong>Question 14: </strong>What kind of activities or training do you think would be most helpful for Parent Mentors?
		<div class="question_summary">
		
		</div>
	</li>
	<li><strong>Question 15: </strong>What kind of activities or training do you think would be helpful for teachers who host Parent Mentors?
		<div class="question_summary">
		
		</div>
	</li>-->

<? /* I'm not sure where this shows up. */
$percent_questions_arr=array(
    'Attendance',
    'Classroom_Benefits_8',
    'Classroom_Benefits_9',
    'Classroom_Benefits_10',
    'Classroom_Benefits_11',
    'Classroom_Benefits_12',
            'School_Benefits_13',
    'School_Benefits_14',
    'School_Benefits_15',
    );
foreach($percent_questions_arr as $question){
            $call_for_arrays="CALL get_count_teacher_post_surveys('" .$question . "')";
           // echo $call_for_arrays;
            include "../include/dbconnopen.php";
            $questions=mysqli_query($cnnLSNA, $call_for_arrays);
            $num_options = mysqli_num_rows($questions);
            $total_post_responses=0;
          while ($survey = mysqli_fetch_row($questions)){
             // print_r($survey);
           foreach($survey as $key => $value)
                {
               //creates the correct arrays for results, below
               if ($key==0){
                            $array_key=$value;
                    }
               elseif ($key==1){
                        $array_value=$value;
                        $total_post_responses+=$value;
                    }
                ${$question.'_arr'}[$array_key]=$array_value;
               }
          }
}

foreach($task_questions_arr as $question){
            $call_for_arrays="CALL get_count_teacher_post_surveys('" .$question . "')";
            //echo $call_for_arrays;
            include "../include/dbconnopen.php";
            $questions=mysqli_query($cnnLSNA, $call_for_arrays);
          while ($survey = mysqli_fetch_row($questions)){
              if ($survey[0]==1){
                  ${$question.'_post_num'}=$survey[1];
              }
            }
}
?>
<h4>Post-Program Surveys</h4>
<div style="text-align:center;"><span class="helptext">Total number of post-program surveys:</span>
<?
	$get_surveys="SELECT * FROM PM_Teacher_Survey_Post";
	include "../include/dbconnopen.php";
	$surveys=mysqli_query($cnnLSNA, $get_surveys);
	$num_surveys=mysqli_num_rows($surveys);
	echo $num_surveys;
	include "../include/dbconnclose.php";
?></div>
<br/>
<table>
<tr>
	<td width="50%"><strong>Question 5: </strong>My Parent Mentor... <!--show % for each category-->
		<div class="question_summary">
			never missed a day  of work: <?echo number_format(($Attendance_arr[5]/$total_post_responses)*100) . '%';?><br>
                        missed occasionally but always found a way to communicate with me: <?echo number_format(($Attendance_arr[4]/$total_post_responses)*100) . '%';?><br>
                        missed occasionally without notice or explanation: <?echo number_format(($Attendance_arr[3]/$total_post_responses)*100) . '%';?><br>
                        had irregular attendance and made it difficult for me to count on him or her: <?echo number_format(($Attendance_arr[2]/$total_post_responses)*100) . '%';?><br>
                        left mid-semester without notice and I have not heard from her/him since: <?echo number_format(($Attendance_arr[1]/$total_post_responses)*100) . '%';?><br>

		</div></td>
	<td><strong>Question 8: </strong>Having the support of a Parent Mentor helps me achieve or maintain good classroom management. <!--show % for each response-->
		<div class="question_summary">
                    Strongly Agree: <?echo number_format(($Classroom_Benefits_8_arr[5]/$total_post_responses)*100) . '%';?><br>
                    Agree:  <?echo number_format(($Classroom_Benefits_8_arr[4]/$total_post_responses)*100) . '%';?><br>
                    Neutral:  <?echo number_format(($Classroom_Benefits_8_arr[3]/$total_post_responses)*100) . '%';?><br>
                    Disagree:  <?echo number_format(($Classroom_Benefits_8_arr[2]/$total_post_responses)*100) . '%';?><br>
                    Strongly Disagree:  <?echo number_format(($Classroom_Benefits_8_arr[1]/$total_post_responses)*100) . '%';?><br>
                    N/A:  <?echo number_format(($Classroom_Benefits_8_arr[0]/$total_post_responses)*100) . '%';?><br>
		</div></td>
</tr>
<tr>
	<td><strong>Question 9: </strong>Having the support of a Parent Mentor helps me improve homework completion and helps me maintain a high expectatin for homework in my classroom. <!--show % for each response-->
		<div class="question_summary">
			Strongly Agree: <?echo number_format(($Classroom_Benefits_9_arr[5]/$total_post_responses)*100) . '%';?><br>
                    Agree:  <?echo number_format(($Classroom_Benefits_9_arr[4]/$total_post_responses)*100) . '%';?><br>
                    Neutral:  <?echo number_format(($Classroom_Benefits_9_arr[3]/$total_post_responses)*100) . '%';?><br>
                    Disagree:  <?echo number_format(($Classroom_Benefits_9_arr[2]/$total_post_responses)*100) . '%';?><br>
                    Strongly Disagree:  <?echo number_format(($Classroom_Benefits_9_arr[1]/$total_post_responses)*100) . '%';?><br>
                    N/A:  <?echo number_format(($Classroom_Benefits_9_arr[0]/$total_post_responses)*100) . '%';?><br>
		</div></td>
	<td><strong>Question 10: </strong>Having the support of a Parent Mentor helps me improve students in reading and/or math. <!--show % for each response-->
		<div class="question_summary">
			Strongly Agree: <?echo number_format(($Classroom_Benefits_10_arr[5]/$total_post_responses)*100) . '%';?><br>
                    Agree:  <?echo number_format(($Classroom_Benefits_10_arr[4]/$total_post_responses)*100) . '%';?><br>
                    Neutral:  <?echo number_format(($Classroom_Benefits_10_arr[3]/$total_post_responses)*100) . '%';?><br>
                    Disagree:  <?echo number_format(($Classroom_Benefits_10_arr[2]/$total_post_responses)*100) . '%';?><br>
                    Strongly Disagree:  <?echo number_format(($Classroom_Benefits_10_arr[1]/$total_post_responses)*100) . '%';?><br>
                    N/A:  <?echo number_format(($Classroom_Benefits_10_arr[0]/$total_post_responses)*100) . '%';?><br>
		</div></td>
</tr>
<tr>
	<td><strong>Question 11: </strong>Having a Parent Mentor strengthens my understanding of or connection to the community. <!--show % for each response-->
		<div class="question_summary">
			Strongly Agree: <?echo number_format(($Classroom_Benefits_11_arr[5]/$total_post_responses)*100) . '%';?><br>
                    Agree:  <?echo number_format(($Classroom_Benefits_11_arr[4]/$total_post_responses)*100) . '%';?><br>
                    Neutral:  <?echo number_format(($Classroom_Benefits_11_arr[3]/$total_post_responses)*100) . '%';?><br>
                    Disagree:  <?echo number_format(($Classroom_Benefits_11_arr[2]/$total_post_responses)*100) . '%';?><br>
                    Strongly Disagree:  <?echo number_format(($Classroom_Benefits_11_arr[1]/$total_post_responses)*100) . '%';?><br>
                    N/A:  <?echo number_format(($Classroom_Benefits_11_arr[0]/$total_post_responses)*100) . '%';?><br>
		</div></td>
	<td><strong>Question 12: </strong>Having a Parent Mentor strengthens student social-emotional development. <!--show % for each response-->
		<div class="question_summary">
			Strongly Agree: <?echo number_format(($Classroom_Benefits_12_arr[5]/$total_post_responses)*100) . '%';?><br>
                    Agree:  <?echo number_format(($Classroom_Benefits_12_arr[4]/$total_post_responses)*100) . '%';?><br>
                    Neutral:  <?echo number_format(($Classroom_Benefits_12_arr[3]/$total_post_responses)*100) . '%';?><br>
                    Disagree:  <?echo number_format(($Classroom_Benefits_12_arr[2]/$total_post_responses)*100) . '%';?><br>
                    Strongly Disagree:  <?echo number_format(($Classroom_Benefits_12_arr[1]/$total_post_responses)*100) . '%';?><br>
                    N/A:  <?echo number_format(($Classroom_Benefits_12_arr[0]/$total_post_responses)*100) . '%';?><br>
		</div></td>
</tr>
<tr>
	<td><strong>Question 13: </strong>The Parent Mentor Program helps our school create a welcoming and communicative environment for all parents. <!--show % for each response-->
		<div class="question_summary">
			Strongly Agree: <?echo number_format(($School_Benefits_13_arr[5]/$total_post_responses)*100) . '%';?><br>
                    Agree:  <?echo number_format(($School_Benefits_13_arr[4]/$total_post_responses)*100) . '%';?><br>
                    Neutral:  <?echo number_format(($School_Benefits_13_arr[3]/$total_post_responses)*100) . '%';?><br>
                    Disagree:  <?echo number_format(($School_Benefits_13_arr[2]/$total_post_responses)*100) . '%';?><br>
                    Strongly Disagree:  <?echo number_format(($School_Benefits_13_arr[1]/$total_post_responses)*100) . '%';?><br>
                    N/A:  <?echo number_format(($School_Benefits_13_arr[0]/$total_post_responses)*100) . '%';?><br>
		</div></td>
	<td><strong>Question 14: </strong>The Parent Mentor Program helps our school build parent-teacher trust. <!--show % for each response-->
		<div class="question_summary">
			Strongly Agree: <?echo number_format(($School_Benefits_14_arr[5]/$total_post_responses)*100) . '%';?><br>
                    Agree:  <?echo number_format(($School_Benefits_14_arr[4]/$total_post_responses)*100) . '%';?><br>
                    Neutral:  <?echo number_format(($School_Benefits_14_arr[3]/$total_post_responses)*100) . '%';?><br>
                    Disagree:  <?echo number_format(($School_Benefits_14_arr[2]/$total_post_responses)*100) . '%';?><br>
                    Strongly Disagree:  <?echo number_format(($School_Benefits_14_arr[1]/$total_post_responses)*100) . '%';?><br>
                    N/A:  <?echo number_format(($School_Benefits_14_arr[0]/$total_post_responses)*100) . '%';?><br>
		</div></td>
</tr>
<tr>
	<td><strong>Question 15: </strong>The Parent Mentor Program helps teachers and parents to think of each other as partners in educating. <!--show % for each response-->
		<div class="question_summary">
			Strongly Agree: <?echo number_format(($School_Benefits_15_arr[5]/$total_post_responses)*100) . '%';?><br>
                    Agree:  <?echo number_format(($School_Benefits_15_arr[4]/$total_post_responses)*100) . '%';?><br>
                    Neutral:  <?echo number_format(($School_Benefits_15_arr[3]/$total_post_responses)*100) . '%';?><br>
                    Disagree:  <?echo number_format(($School_Benefits_15_arr[2]/$total_post_responses)*100) . '%';?><br>
                    Strongly Disagree:  <?echo number_format(($School_Benefits_15_arr[1]/$total_post_responses)*100) . '%';?><br>
                    N/A:  <?echo number_format(($School_Benefits_15_arr[0]/$total_post_responses)*100) . '%';?><br>
		</div></td>
	<td></td>
</tr>
</table>

	<!--Q7 is a free text field, not sure how/if we'll report on it-->
	<!--<li><strong>Question 7: </strong>My Parent Mentor spent the majority of his or her time: 
		<div class="question_summary">
		
		</div>
	</li>-->

<!-- 16-18 are free text; not sure how we'll report on these-->
	<!--<li><strong>Question 16: </strong>What kind of activities or training do you think would be most helpful for Parent Mentors?
		<div class="question_summary">
		
		</div>
	</li>
	<li><strong>Question 17: </strong>What kind of activities or training do you think would be helpful for teachers who host Parent Mentors?
		<div class="question_summary">
		
		</div>
	</li>
	<li><strong>Question 18: </strong>Overall comments and suggestions for the Parent Mentor Program:
		<div class="question_summary">
		
		</div>
	</li>-->


<h4>All Surveys</h4> <!--Questions included on both surveys. For questions A-J, show mean and median; for questions K-L, show % in each category-->
	
<table class="inner_table" style="font-size:.8em;margin-left:auto;margin-right:auto;width:60%;">
	<tr>
		<th></th>
		<th>Pre-Survey: I would like my Parent Mentor to...</th>
		<th>Post-Survey: My Parent Mentor spent his or her time...</th>
	</tr>
	<tr>
		<td>grade papers:</td>
		<td style="text-align:center;"><?echo number_format(($Task_1_num/$total_responses)*100) . '%';?></td>
		<td style="text-align:center;"><?echo number_format(($Task_1_post_num/$total_responses)*100) . '%';?></td>
	</tr>
	<tr>
		<td>tutor students one on one:</td>
		<td style="text-align:center;"><?echo number_format(($Task_2_num/$total_responses)*100) . '%';?></td>
		<td style="text-align:center;"><?echo number_format(($Task_2_post_num/$total_responses)*100) . '%';?></td>
	</tr>
	<tr>
		<td>lead part of the class in an activity:</td>
		<td style="text-align:center;"><?echo number_format(($Task_3_num/$total_responses)*100) . '%';?></td>
		<td style="text-align:center;"><?echo number_format(($Task_3_post_num/$total_responses)*100) . '%';?></td>
	</tr>
	<tr>
		<td>take children to the washroom, etc:</td>
		<td style="text-align:center;"><?echo number_format(($Task_4_num/$total_responses)*100) . '%';?></td>
		<td style="text-align:center;"><?echo number_format(($Task_4_post_num/$total_responses)*100) . '%';?></td>
	</tr>
	<tr>
		<td>help with discipline/disruptions:</td>
		<td style="text-align:center;"><?echo number_format(($Task_5_num/$total_responses)*100) . '%';?></td>
		<td style="text-align:center;"><?echo number_format(($Task_5_post_num/$total_responses)*100) . '%';?></td>
	</tr>
	<tr>
		<td>check homework:</td>
		<td style="text-align:center;"><?echo number_format(($Task_6_num/$total_responses)*100) . '%';?></td>
		<td style="text-align:center;"><?echo number_format(($Task_6_post_num/$total_responses)*100) . '%';?></td>
	</tr>
	<tr>
		<td>work with small groups of students:</td>
		<td style="text-align:center;"><?echo number_format(($Task_7_num/$total_responses)*100) . '%';?></td>
		<td style="text-align:center;"><?echo number_format(($Task_7_post_num/$total_responses)*100) . '%';?></td>
	</tr>
	<tr>
		<td>lead the whole class in an activity:</td>
		<td style="text-align:center;"><?echo number_format(($Task_8_num/$total_responses)*100) . '%';?></td>
		<td style="text-align:center;"><?echo number_format(($Task_8_post_num/$total_responses)*100) . '%';?></td>
	</tr>
	<tr>
		<td>help organize the classroom:</td>
		<td style="text-align:center;"><?echo number_format(($Task_8_num/$total_responses)*100) . '%';?></td>
		<td style="text-align:center;"><?echo number_format(($Task_8_post_num/$total_responses)*100) . '%';?></td>
	</tr>
	<tr>
		<td>other:</td>
		<td style="text-align:center;"><?echo number_format(($Task_10_num/$total_responses)*100) . '%';?></td>
		<td style="text-align:center;"><?echo number_format(($Task_10_post_num/$total_responses)*100) . '%';?></td>
	</tr>
</table>

<br/><br/>

<!-- This is the table that contains the real elements, and makes them slide next to each other. -->

    <table style="margin-left:auto;margin-right:auto;">
        <tr>
            <td style="vertical-align:top;">   
                <!--This is the report table, with all the numbers for the questions that appear in both the pre and post surveys. -->
                <table style="font-size: .8em;
	padding: 7px;
	border: 2px solid #696969;
    border-collapse: collapse;
    width: 700px;margin-left:auto;margin-right:auto;">
        <tr>
            <th>Question</th>
            <th>Pre-Survey</th>
            <th> Post-Survey</th>
        </tr>
<?
//this array holds all the names of the columns I want to pull
    $question_array=array(
        'Teacher_Involvement_A', 'Teacher_Involvement_B',
    'Teacher_Involvement_C',
    'Teacher_Involvement_D',
    'Teacher_Involvement_E',
    'Teacher_Involvement_F',
    'Teacher_Involvement_G',
    'Teacher_Involvement_H',
    'Teacher_Involvement_I',
    'Teacher_Involvement_J',
    'Teacher_Parent_Network_K',
    'Teacher_Parent_Network_L');
    
    $question_array=array(
        'Teacher_Involvement_A', 'Teacher_Involvement_B',
    'Teacher_Involvement_C',
    'Teacher_Involvement_D',
    'Teacher_Involvement_E',
    'Teacher_Involvement_F',
    'Teacher_Involvement_G',
    'Teacher_Involvement_H',
    'Teacher_Parent_Network_K',
    'Teacher_Parent_Network_L');
    //This array holds the names of those columns as they should be shown.
    $text_array=array(
        'A. Have another teacher or paraprofessional working with you in your classroom?', 'B.	Have a parent volunteer or parent mentor in your classroom, working with students?',
        'C.	Talk with at least one school parent face-to-face?',
        'D.	Have a conversation with a school parent about something besides their child\'s progress or behavior?', 
        'E.	Have time for YOU to work with at least one of your struggling students one-on-one for 10 minutes or more?',
        'F.	Have another adult (volunteer or staff) to work with at least one of your struggling students one-on-one for 10 minutes or more?',
        'G.	Have time for YOU to work with 4 or more of your struggling students one-on-one for 10 minutes or more?', 
        'H.	Have another adult (volunteer or staff) to work with 4 or more of your struggling students one-on-one for 10 minutes or more?',
        'I.	Learn something new about the community in which your school is located?',
        'J.	Ask a school parent for advice?', 'K.	How many school parents did you greet by name?',
        'L.	How many school parents do you have phone numbers or emails for, besides a school directory?'
        
        );
    
    $text_array=array(
        'A. Have another teacher or paraprofessional working with you in your classroom?', 'B.	Have a parent volunteer or parent mentor in your classroom, working with students?',
        'C.	Talk with at least one school parent face-to-face?',
        'D.	Have a conversation with a school parent about something besides their child\'s progress or behavior?', 
        'E.	Learn something new about the community in which your school is located? ',
        'F.	Ask a school parent for advice?',
        'G.     How many of your students did YOU have time to work with one-on-one for 10 minutes or more, during school hours? (Not counting test administration.)',
        'H.     How many of your students did another adult (staff, volunteer or parent mentor) work with one-on-one for 10 minutes or more, during school hours? (Not counting test administration.)',
        'I.	How many school parents did you greet by name?',
        'J.	How many school parents do you have phone numbers or emails for, besides a school directory?'
        
        );
    //the question_count keeps track of where we are in the arrays above.
    $question_count=0;
    
    //this loop traverses the columns above
    foreach($question_array as $question){
        //echo $question_count;
        //the following set of 'if's adds the breaks between sections
        if ($question_count==0){
            ?><tr>
        <td class="all_projects" colspan="3"><strong>Think about the last WEEK.  On how many <em>days</em> did you...</strong> </td>
        </tr>
        <?
        }
        if ($question_count==6){
            ?><tr>
        <td class="all_projects" colspan="3"><strong>Answer these questions thinking about the last WEEK.</strong> </td>
        </tr><?
        }
        ?><tr>
        <td class="all_projects"  style="text-align:left;width:200px"><?echo $text_array[$question_count];?></td><?

            $array_lngth_counter=0;
            $script_str='';
            if ($question!='Teacher_Parent_Network_K' && $question!='Teacher_Parent_Network_L'){
                $call_for_arrays="CALL get_sum_teacher_surveys('" .$question . "')";
            }
            else{
                $call_for_arrays="CALL get_count_teacher_surveys('" .$question . "')";
            }
            include "../include/dbconnopen.php";
            $questions=mysqli_query($cnnLSNA, $call_for_arrays);
            ?><td class="all_projects" style="text-align:left;"><?
            /* get pre-survey responses: */
            
            $num_options = mysqli_num_rows($questions);
            while ($survey = mysqli_fetch_row($questions)){
                if ($question!='Teacher_Parent_Network_K' && $question!='Teacher_Parent_Network_L'){
                    echo 'mean: ' . number_format($survey[0]/$total_responses, 2) . "<br>";
                    $get_median = "SELECT Teacher_Involvement_A FROM PM_Teacher_Survey 
                        ORDER BY Teacher_Involvement_A LIMIT ".floor($total_responses/2).", 1;";
                    //echo $get_median;
                    include "../include/dbconnopen.php";
                    $median=mysqli_query($cnnLSNA, $get_median);
                    //print_r($median);
                    $med=mysqli_fetch_row($median);
                    echo 'median: ' . $med[0] . "<br>";
                }
                else{             
                    foreach($survey as $key => $value)
                        {
                        //creates the correct arrays for legends, below
                        if ($key==0){
                                    $string.= '' . $value . ' : ';
                        }
                        if($key==1){
                                    $string.= number_format(($value/$total_responses)*100) . '%'. ' teacher(s)<br>';
                        }
                        echo $string; 
                        $string='';

                        }
                        $array_lngth_counter++;
                        if ($array_lngth_counter<$num_options && $key==1){
                            $script_str.=', ';
                        }
                    }
        }
                ${$question.'_'.$i}=$script_str;
               // echo $script_str;
        if ($i==1){echo "<br>mean: " . number_format($pre[$question_count], 2);}
         if ($i==2){echo "<br>average: " . number_format($post[$question_count], 2);}
        ?>
            
            </td>
            <td class="all_projects"> 
                <?
                /*get post-survey responses*/
                $array_lngth_counter=0;
            $script_str='';
            if ($question!='Teacher_Parent_Network_K' && $question!='Teacher_Parent_Network_L'){
                $call_for_arrays="CALL get_sum_teacher_post_surveys('" .$question . "')";
            }
            else{
                $call_for_arrays="CALL get_count_teacher_post_surveys('" .$question . "')";
            }
            include "../include/dbconnopen.php";
            $questions=mysqli_query($cnnLSNA, $call_for_arrays);
            $num_options = mysqli_num_rows($questions);
            while ($survey = mysqli_fetch_row($questions)){
                if ($question!='Teacher_Parent_Network_K' && $question!='Teacher_Parent_Network_L'){
                    echo 'mean: ' . $survey[0]/$total_post_responses . "<br>";
                    $get_median = "SELECT Teacher_Involvement_A FROM PM_Teacher_Survey ORDER BY Teacher_Involvement_A LIMIT ".floor($total_post_responses/2).", 1;";
                    //echo $get_median;
                    include "../include/dbconnopen.php";
                    $median=mysqli_query($cnnLSNA, $get_median);
                    //print_r($median);
                    $med=mysqli_fetch_row($median);
                    echo 'median: ' . $med[0] . "<br>";
                }
                else{             
                    foreach($survey as $key => $value)
                        {
                    //creates the correct arrays for legends, below
                        
                            if ($key==0){
                                $string.= '' . $value . ' : ';
                            }
                            if($key==1){
                                $string.= number_format(($value/$total_post_responses)*100) . '%'. ' teacher(s)<br>';
                            }
                        
                        echo $string; 
                        $string='';

                        }
                        $array_lngth_counter++;
                        if ($array_lngth_counter<$num_options && $key==1){
                            $script_str.=', ';
                        }
                    }
        }
                ${$question.'_'.$i}=$script_str;
               // echo $script_str;
        if ($i==1){echo "<br>mean: " . number_format($pre[$question_count], 2);}
         if ($i==2){echo "<br>average: " . number_format($post[$question_count], 2);}
        ?></td> 
        
    </tr><?
    $question_count++;
}
     ?>
    </table>
    
        </td>
    <td style="vertical-align:top; text-align:left;">




    </td>
        </tr>
    </table>
    
</div>
