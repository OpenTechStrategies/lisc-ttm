<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
user_enforce_has_access($SWOP_id);

include "../../header.php";
include "../header.php";
include "reports_menu.php";

?>

<!--- Not often used.  Counts the number of institutions in the system. -->

<h4>Number of Institutions</h4>
<br/>
<table class="all_projects">
    <tr><th>Quarter</th><th>Number of Institutions</th><th>Change from previous quarter</th></tr>
    <?php
    //find current quarter, then back up from there
    date_default_timezone_set('America/Chicago');
    $this_year=date('Y');
    $this_month=date('m');
    if ($this_month>=1 && $this_month<=3){ $this_qtr=1; }
    elseif ($this_month>=4 && $this_month<=6){ $this_qtr=2;}
    elseif ($this_month>=7 && $this_month<=9){ $this_qtr=3; }
    elseif ($this_month>=10 && $this_month<=12){ $this_qtr=4; }
    
    /* show this year and previous 2 years. */
    for ($i=0; $i<3; $i++){
    $year_shown=$this_year-$i;}
    for ($j=$this_qtr; $j>0; $j--){
        if ($j==1){ $end_of_quarter='03-31';}
    elseif ($j==2){$end_of_quarter='06-30';}
    elseif ($j==3){ $end_of_quarter='09-30';}
    elseif ($j==4){ $end_of_quarter='12-31';}
    ?>
    <tr><td class="all_projects"><?echo $year_shown?> - Quarter <?echo $j?></td><td class="all_projects">
        <?
        /* count institutions at a given time. */
        $count_insts_sqlsafe = "SELECT COUNT(*) FROM Institutions WHERE Date_Added<='$year_shown-$end_of_quarter'";
    //echo $count_insts_sqlsafe;
    include "../include/dbconnopen.php";
    $inst_ct=mysqli_query($cnnSWOP, $count_insts_sqlsafe);
    $inst=mysqli_fetch_row($inst_ct);
    echo $inst[0];
    include "../include/dbconnclose.php";
    ?></td>
        <td class="all_projects"></td></tr>
    <?}
    $this_qtr=4;
    }?>
</table>
<br/><br/>

<?php
	include "../../footer.php";
close_all_dbconn();
?>