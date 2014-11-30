<?php
include "../include/dbconnopen.php";
if ($_POST['include_address']==1){ $address_sqlsafe=" Participants.Address_Street_Num as Participant_Num, Participants.Address_Street_Direction as Participant_Direction,"
        . " Participants.Address_Street_Name as Participant_Street_Name, Participants.Address_Street_Type as Participant_Street_Type, "; }
if ($_POST['include_day_phone']==1){ $day_phone_sqlsafe=" Participants.Phone_Day as Participant_Day, ";}
if ($_POST['include_evening']==1){ $evening_phone_sqlsafe=" Participants.Phone_Evening as Participant_Evening, ";}
if ($_POST['include_inst']==1){$inst_join_sqlsafe = " LEFT JOIN Institutions_Participants ON Leaders.Participant_ID=Institutions_Participants.Participant_ID AND Is_Primary=1 "
        . " LEFT JOIN Institutions ON Institutions_Participants.Institution_ID=Institutions.Institution_ID ";
    $inst_sqlsafe = " Institutions.Institution_Name, ";}
if ($_POST['include_organizer']==1){ $organizer_join_sqlsafe = " LEFT JOIN Participants as Organizer_Info ON Participants.Primary_Organizer=Organizer_Info.Participant_ID ";
    $organizer_sqlsafe= " Organizer_Info.Name_First as organizer_first, Organizer_Info.Name_Last as organizer_last, ";}
if ($_POST['include_leader']==1){ $leader_sqlsafe = "Leaders.Leader_Type, "; }
if ($_POST['include_name']==1){ $name_sqlsafe = " Participants.Name_First as participant_first, Participants.Name_Last as participant_last, "; }

if ($_POST['action']=='num_events'){   
    $initial_query="SELECT COUNT(Event_ID) as event_count, Leaders.Participant_ID, ". $name_sqlsafe . $address_sqlsafe . $day_phone_sqlsafe . $evening_phone_sqlsafe . 
            $inst_sqlsafe . $organizer_sqlsafe . $leader_sqlsafe ." NULL FROM (SELECT * FROM Participants_Leaders WHERE Leader_Type!=4 AND Leader_Type!=0 GROUP BY Participant_ID) Leaders
INNER JOIN (SELECT * FROM Participants_Events WHERE Event_ID!=0 AND Event_ID IS NOT NULL) Events
ON Leaders.Participant_ID=Events.Participant_ID 
LEFT JOIN Participants ON Leaders.Participant_ID=Participants.Participant_ID 
". $inst_join_sqlsafe . $organizer_join_sqlsafe ."
GROUP BY Leaders.Participant_ID;";
    
    }
elseif($_POST['action']=='events_dates'){
    
    $initial_query_sqlsafe="SELECT COUNT(Event_ID)as event_count, Leaders.Participant_ID, ". $name_sqlsafe . $address_sqlsafe . $day_phone_sqlsafe . $evening_phone_sqlsafe . 
            $inst_sqlsafe . $organizer_sqlsafe . $leader_sqlsafe . " NULL FROM (SELECT * FROM Participants_Leaders WHERE Leader_Type!=4 GROUP BY Participant_ID) Leaders
INNER JOIN (SELECT * FROM Participants_Events WHERE Event_ID!=0 AND Event_ID IS NOT NULL) Events
ON Leaders.Participant_ID=Events.Participant_ID 
LEFT JOIN Participants ON Leaders.Participant_ID=Participants.Participant_ID 
INNER JOIN (SELECT * FROM Campaigns_Events WHERE Event_Date>='" . mysqli_real_escape_string($cnnSWOP, $_POST['start_date']) . "' AND Event_Date<='".mysqli_real_escape_string($cnnSWOP, $_POST['end_date'])."') Dates ON Campaign_Event_ID=Event_ID
    " . $inst_join_sqlsafe . $organizer_join_sqlsafe ."
GROUP BY Leaders.Participant_ID;";
    }
elseif($_POST['action']=='type'){
    $initial_query_sqlsafe="SELECT Leaders.Participant_ID, Latest_Date.Leader_Type, ". $name_sqlsafe . $address_sqlsafe . $day_phone_sqlsafe . $evening_phone_sqlsafe . 
            $inst_sqlsafe . $organizer_sqlsafe . $leader_sqlsafe ." NULL FROM Participants_Leaders AS Leaders
inner join (SELECT Participants_Leader_ID, max(Date_Logged), Leader_Type  FROM Participants_Leaders
        GROUP BY Participant_ID) Latest_Date
ON Leaders.Participants_Leader_ID=Latest_Date.Participants_Leader_ID 
LEFT JOIN Participants ON Leaders.Participant_ID=Participants.Participant_ID 
". $inst_join_sqlsafe . $organizer_join_sqlsafe ."WHERE Leaders.Leader_Type='" . mysqli_real_escape_string($cnnSWOP, $_POST['leader_type']) . "'";
}
elseif($_POST['action']=='institution'){
    $initial_query_sqlsafe="SELECT Leaders.Participant_ID, Latest_Date.Leader_Type, Institutions_Participants.Institution_ID, Institution_Name, ". $name_sqlsafe
            . $address_sqlsafe . $day_phone_sqlsafe . $evening_phone_sqlsafe . 
          $organizer_sqlsafe . $leader_sqlsafe ." NULL  FROM Participants_Leaders as Leaders
inner join (SELECT Participants_Leader_ID, max(Date_Logged), Leader_Type  FROM Participants_Leaders WHERE Leader_Type!=0 AND Leader_Type!=4
        GROUP BY Participant_ID) Latest_Date ON Leaders.Participants_Leader_ID=Latest_Date.Participants_Leader_ID
LEFT JOIN Participants ON Leaders.Participant_ID=Participants.Participant_ID 
INNER JOIN Institutions_Participants ON Institutions_Participants.Participant_ID=Leaders.Participant_ID
LEFT JOIN Institutions ON Institutions_Participants.Institution_ID=Institutions.Institution_ID
". $organizer_join_sqlsafe ."
WHERE Institutions_Participants.Institution_ID='" . mysqli_real_escape_string($cnnSWOP, $_POST['institution']) . "';";
}

//echo $initial_query;
    $event_num=mysqli_query($cnnSWOP, $initial_query_sqlsafe);
    
    /* create file for export of results: */
date_default_timezone_set('America/Chicago');
$infile = "export_holder/search_individuals_" . date('M-d-Y') . ".csv";
//echo $infile;
$fp = fopen($infile, "w") or die('can\'t open file');
$columns = array('Database ID', 'First Name', 'Last Name', 'Gender', 'Date of Birth', 'Grade Level', 'Role(s)');

if ($_POST['include_address'] == '1') array_push($columns, "Address");
if ($_POST['include_ward'] == '1') array_push($columns, "Ward");
if ($_POST['include_daytime_phone'] == '1') array_push($columns, "Daytime Phone");
if ($_POST['include_evening_phone'] == '1') array_push($columns, "Evening Phone");
if ($_POST['include_languages_spoken'] == '1') array_push($columns, "Languages Spoken");
if ($_POST['include_email'] == '1') array_push($columns, "Email");
fputcsv($fp, $columns);
       ?>

<p></p>
<table  class="all_projects">
    <tr><th>Participant ID</th>
     <?php if ($_POST['action']=='num_events' || $_POST['action']=='events_dates'){ ?>    <th>Number of events</th><?php }  ?>
     <?php if ($_POST['include_name']=='1'){ ?> <th>Name</th> <?php }  ?>
    <?php if($_POST['include_address']==1){ ?> <th>Address</th> <?php  } ?>
    <?php if ($_POST['include_day_phone']==1){ ?> <th>Daytime Phone </th> <?php }  ?>
    <?php if ($_POST['include_evening']==1){ ?> <th>Evening Phone</th> <?php }  ?>
    <?php if ($_POST['include_inst']==1 || $_POST['action']=='institution'){ ?> <th>Primary Institution</th> <?php }  ?>
    <?php if ($_POST['include_organizer']==1){ ?> <th>Primary Organizer</th> <?php }  ?>
    <?php if ($_POST['include_leader']==1){ ?> <th>Leadership Type</th> <?php }  ?>
    </tr>
        <?php
        $n;
    while ($atts=  mysqli_fetch_array($event_num)){
       // echo "in while";
        $x++;
        if ($atts['event_count']>=$_POST['num_events']){
           
            ?>
    <tr><td><?php echo $atts['Participant_ID'];?></td>
        <?php if ($_POST['action']=='num_events' || $_POST['action']=='events_dates'){ ?> <td><?php echo $atts['event_count']; ?></td><?php }?>
        <?php if ($_POST['include_name']=='1'){ ?> <td><?php echo $atts['participant_first'] . " " . $atts['participant_last']; ?></td> <?php }  ?>
    <?php if($_POST['include_address']==1){ ?> <td><?php echo $atts['Participant_Num'] . " " .
              $atts['Participant_Direction'] ." ". $atts['Participant_Street_Name'] ." " . $atts['Participant_Street_Type'];?></td> <?php  } ?>
    <?php if ($_POST['include_day_phone']==1){ ?> <td><?php echo $atts['Participant_Day']; ?></td> <?php }  ?>
    <?php if ($_POST['include_evening']==1){ ?> <td><?php echo $atts['Participant_Evening']; ?></td> <?php }  ?>
    <?php if ($_POST['include_inst']==1 || $_POST['action']=='institution'){ ?> <td><?php echo $atts['Institution_Name']; ?></td> <?php }  ?>
    <?php if ($_POST['include_organizer']==1){ ?> <td><?php echo $atts['organizer_first']. " " . $atts['organizer_last'];  ?></td> <?php }  ?>
    <?php if ($_POST['include_leader']==1){ ?> <td><?php echo $atts['Leader_Type']; ?></td> <?php }  ?>
    
    </tr>
                <?php
             $n++;
        }
    }
    ?>
</table>
        <?php
    echo "<b>Total number of leaders: </b>" . $n;
    include "../include/dbconnclose.php";


?>