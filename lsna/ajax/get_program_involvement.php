<div id="program_involvement_by_program">
    <?//echo $_POST['program_id'];
    include "../include/dbconnopen.php";
    $program_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_POST['program_id']);
    $get_sub_info = "SELECT * FROM Subcategories WHERE Subcategory_ID='" . $program_id_sqlsafe . "'";
    $sub_info = mysqli_query($cnnLSNA, $get_sub_info);
    $sub = mysqli_fetch_row($sub_info);
    
    include "../include/dbconnclose.php";
    ?>
       
    
    <h4>Extent of Involvement in <?echo $sub[2] . ": " . $sub[1];?></h4>

    
    <table class="all_projects">
        <tr>
            <th>Number of Participants</th>
            <th>Number of Adults</th>
            <th>Number of Parent-Mentors</th>
            <th>Number of Youth</th>
            <th>Number of Parent Mentor's Children</th>
        </tr>
        
        <tr>
            <td class="all_projects">
                <?
                $counter_num=0;
                $count_participants="SELECT COUNT(*) 
                    FROM Participants_Subcategories 
                    WHERE Subcategory_ID='" . $program_id_sqlsafe . "';";
                include "../include/dbconnopen.php";
                $ct_participants=mysqli_query($cnnLSNA, $count_participants);
                $count_partis = mysqli_fetch_row($ct_participants);
                    echo $count_partis[0];
                //$participants_array[$i]=$counter_num;
                include "../include/dbconnclose.php";
                ?>
            </td>
            <td class="all_projects">
                <?php
                $counter_num=0;
                $count_adults="SELECT COUNT(*) FROM Participants_Subcategories INNER JOIN Participants
                    ON Participants.Participant_Id=Participants_Subcategories.Participant_ID
                    WHERE (Is_Child IS NULL OR Is_Child=0 OR Is_Child=3)
                    AND Participants_Subcategories.Subcategory_ID='" . $program_id_sqlsafe . "';";
                include "../include/dbconnopen.php";
                $ct_adults=mysqli_query($cnnLSNA, $count_adults);
                $count_partis = mysqli_fetch_row($ct_adults);
                    echo $count_partis[0];
                $adults_array[$i]=$counter_num;
                include "../include/dbconnclose.php";
                ?>
            </td>
            <td class="all_projects">
                <?
                $counter_num=0;
                $count_pms="SELECT COUNT(*) 
                    FROM Participants_Subcategories INNER JOIN Participants
                    ON Participants.Participant_Id=Participants_Subcategories.Participant_ID
                    WHERE (Is_PM IS NOT NULL AND Is_PM=1)
                    AND Participants_Subcategories.Subcategory_ID='" . $program_id_sqlsafe . "';";
                //echo $count_pms;
                include "../include/dbconnopen.php";
                $ct_pms=mysqli_query($cnnLSNA, $count_pms);
                $count_partis = mysqli_fetch_row($ct_pms);
                    echo $count_partis[0];
                $pm_array[$i]=$counter_num;
                include "../include/dbconnclose.php";
                ?>
            </td>
            <td class="all_projects">
                <?php
                $counter_num=0;
                $count_youth="SELECT COUNT(*) 
                    FROM Participants_Subcategories INNER JOIN Participants
                    ON Participants.Participant_Id=Participants_Subcategories.Participant_ID
                    WHERE (Is_Child IS NOT NULL AND Is_Child=2)
                    AND Participants_Subcategories.Subcategory_ID='" . $program_id_sqlsafe . "';";
                include "../include/dbconnopen.php";
                $ct_youth=mysqli_query($cnnLSNA, $count_youth);
                $count_partis = mysqli_fetch_row($ct_youth);
                    echo $count_partis[0];
                $youth_array[$i]=$counter_num;
                include "../include/dbconnclose.php";
                ?>
            </td>
            <td class="all_projects">
                <?
                $counter_num=0;
                //this takes account of children who might have more than one parent in the PM program
                $count_youth="SELECT COUNT(*) FROM 
                    Participants_Subcategories INNER JOIN Parent_Mentor_Children 
                    ON Parent_Mentor_Children.Child_Id=Participants_Subcategories.Participant_ID 
                    WHERE Participants_Subcategories.Subcategory_Id='" . $program_id_sqlsafe . "'";
                include "../include/dbconnopen.php";
                $ct_youth=mysqli_query($cnnLSNA, $count_youth);
                $count_partis = mysqli_fetch_row($ct_youth);
                    echo $count_partis[0];
                $pm_children_array[$i]=$counter_num;
                include "../include/dbconnclose.php";
                ?>
            </td>
        </tr>
    </table>
        
    <?
/*I want to set up a set of arrays that show the number of each answer to each question.  Did most kids agree, disagree, or in between?
 * 

$array_of_arrays=array($participants_array, $adults_array, $pm_array, $youth_array, $pm_children_array);
$order=0;
foreach ($array_of_arrays as $each){
    $order++;
    $counter=0;
    foreach($each as $key=>$value){
        ${string_ . $order} .='[' . $key . ', ' . $value . ']';
        $counter++;
        if ($counter <count($each)){
            ${string_ . $order}.=',';
        }
    }
}
     */
//print_r(get_defined_vars());
?>
 <!--[if IE]>
<script src="/include/excanvas_r3/excanvas.js"></script>
<![endif]-->
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.css" />
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.pointLabels.min.js"></script>

<script type="text/javascript">
    var answers1 = [<?echo $string_1;?>];
    var answers2 = [<?echo $string_2;?>];
    var answers3 = [<?echo $string_3;?>];
    var answers4 = [<?echo $string_4;?>];
    var answers5 = [<?echo $string_5;?>];
$(document).ready(function(){
    var plot2 = $.jqplot('chart2', [answers1, answers2, answers3, answers4, answers5],
    {
        seriesDefaults: {
            renderer:$.jqplot.BarRenderer,
            pointLabels: { show: true, edgeTolerance: -15 },
            rendererOptions: {
                barDirection: 'vertical',
                barMargin: 10,
                barWidth: 10
            }
        },
        series:[
            {label:'Total Participants'},
            {label:'Adults'},
            {label:'Parent Mentors'},
            {label: 'Youth'},
            {label: 'Children of Parent Mentors'}
        ],
        // Show the legend and put it outside the grid, but inside the
        // plot container, shrinking the grid to accomodate the legend.
        // A value of "outside" would not shrink the grid and allow
        // the legend to overflow the container.
        legend: {
            show: true,
            placement: 'outsideGrid'
        },
        axes: {
            yaxis: {
                min: 0,
                max: 10
            },
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                min: 0,
                max: 12
            }
        }
    });
});

</script>
<!--<div id="chart2" style="height: 300px; width: 1000px; position: relative; margin-left:auto; margin-right:auto;"></div>-->
    
    
</div>
