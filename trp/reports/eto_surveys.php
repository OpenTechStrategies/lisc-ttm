<?include "../../header.php";
include "../header.php";

/* this page is irrelevant at the moment.  ETO surveys are the ones collected by the Gads Hill program (I think?)
 * and are not currently being entered in the system. */
?> 
        <?include "report_menu.php";?>
<h3>Early Childhood Pre/Post Parent Engagement</h3>

<!--This is the report table, with all the numbers-->
                <table style="font-size: .8em;
				padding: 7px;
				border: 2px solid #696969;
				border-collapse: collapse;
				width:100%;">
        <tr>
            <th>Question</th>
            <th>Number of each response</th>
            <th> Average response</th>
        </tr>
<?
//this array holds all the names of the columns I want to pull
    $question_array=array('Question_1',
        'Question_2',
        'Question_3',
        'Question_4',
        'Question_5',
        'Question_6',
        'Question_7',
        'Question_8',
        'Question_9',
        'Question_10',
        'Question_11',
        'Question_12');
    //This array holds the names of those columns as they should be shown.
    $text_array_grade_3=array('You are the (mother, father, grandparent):',
        'Do you ever read with your child?',
        'In what language do you read with your child?',
        'How long do you read to your child at each sitting?',
        'How frequently do you read with your child?',
        'How do you get the books you use to read with your child?',
        'How do you prioritize reading with your child compared to other things you do each day?',
        'What are the reasons you do not read with your child?');
    
    
    //the question_count keeps track of where we are in the arrays above.
    $question_count=0;
    
    //this loop traverses the columns above
    foreach($question_array as $question){
        ?><tr>
        <td class="all_projects"  style="text-align:left;width:200px"><?
        if ($version==4){
            echo $text_array_grade_4[$question_count];
        }else{
        echo $text_array_grade_3[$question_count];}?></td><?
            $array_lngth_counter=0;
            $script_str='';
            $date_reformat=explode('-', $_POST['start_date']);
                $start_date=$date_reformat[2] . '-'. $date_reformat[0] . '-'. $date_reformat[1];
                $date_reformat=explode('-', $_POST['end_date']);
                $end_date=$date_reformat[2] . '-'. $date_reformat[0] . '-'. $date_reformat[1];
            if (isset($_POST['satisfaction_program']) && $_POST['satisfaction_program'] !=''){
                
                $call_for_arrays="CALL get_count_satisfaction_surveys_by_program('" .$question . "', 
                    '" . $chosen_program . "', '" . $start_date . "', '" . $end_date . "')";
            }
            else{
                $call_for_arrays="CALL get_count_satisfaction_surveys('" .$question . "', '" . $start_date  . "', '" . $end_date . "')";
            }
            //echo $call_for_arrays;
            include "../include/dbconnopen.php";
            $questions=mysqli_query($cnnTRP, $call_for_arrays);
            ?><td class="all_projects" style="text-align:left;"><?
            /*$num_options = mysqli_num_rows($questions);
            while ($survey = mysqli_fetch_row($questions)){
            foreach($survey as $key => $value)
                {
               //creates the correct arrays for legends, below
                    if ($key==0){
                            if ($value==1){
                                $string.= "Agree: " ;
                               $script_str.='["Agree",';
                            }
                            if($value==0){
                                $string.= "N/A: ";
                               $script_str.='["N/A",';
                            }
                            if ($value==2){
                                $string.= "Somewhat Agree: " ;
                               $script_str.='["Somewhat Agree",';
                            }
                            if($value==3){
                                $string.= "Disagree: ";
                               $script_str.='["Disagree",';
                            }
                    }
                    if ($key==1){
                        $string.=  $value . "<br>";
                        $script_str.= '"'. $value . '"]';
                    }
                
                echo $string; 
                   $string='';
                   
                }
                $array_lngth_counter++;
                if ($array_lngth_counter<$num_options && $key==1){
                    $script_str.=', ';
                }
        }
                ${$question.'_'.$i}=$script_str;
        if ($i==1){echo "<br>average: " . number_format($pre[$question_count], 2);}
        if ($i==2){echo "<br>average: " . number_format($post[$question_count], 2);}*/
        ?>
            
            <?//echo "question count: " . $question_count;?>
            </td>
            <td class="all_projects"></td> 
        
    </tr>
	
	<?
    $question_count++;
}
     ?>
    </table>