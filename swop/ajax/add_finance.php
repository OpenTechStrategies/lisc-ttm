<?php
if ($_POST['housing']==''){
    /*5 is n/a, or something of the sort.  Current housing links to another table, so it's
     * useful to have SOMETHING entered there.
     */
    $housing=5;
}else{$housing=$_POST['housing'];}
/* add new finances.  There's no option to edit finances, only add new ones (possible weakness). */
$new_finance_checkin="INSERT INTO Pool_Finances (Participant_ID,
                    Credit_Score,
                    Income,
                    Current_Housing,
                    Household_Location,
                    Housing_Cost,
                    Assets)
                    VALUES
                    ('".$_POST['person'] ."',
                    '".$_POST['credit'] ."',
                     '".$_POST['income'] ."',
                     '".$housing ."',
                     '".$_POST['location'] ."',
                     '".$_POST['cost'] ."',
                     '".$_POST['assets'] ."')";
/* since finance table includes employment, there is also an employers table to show where people work. */
$new_employer="INSERT INTO Pool_Employers (Participant_ID, Employer_Name, Work_Time) VALUES ('".$_POST['person'] ."',
                    '".$_POST['employer'] ."',
                     '".$_POST['work_time'] ."')";
echo $new_finance_checkin . "<br>";
echo $new_employer;
include "../include/dbconnopen.php";
mysqli_query($cnnSWOP, $new_finance_checkin);
mysqli_query($cnnSWOP, $new_employer);
$id = mysqli_insert_id($cnnSWOP);
include "../include/dbconnclose.php";
?>
