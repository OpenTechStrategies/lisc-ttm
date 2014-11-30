<?php
/* queries for people and properties.  Each is first sent to an ajax file (individual_search or property_search) to 
 * choose result columns, then comes here for actual results. */
if ($_POST['search_type'] == 'pool') {
    /* first get all the columns that the user has specified: */
    $very_start_sqlsafe = 'SELECT Participants.Participant_ID, ';
    $select_start_sqlsafe="";
    $props_start_sqlsafe="";
    for ($j = 0; $j < count($_POST['columns']); $j++) {
        //check if the participant has asked for address information.  If so, we need to get that from the properties table (by means of the 
        //property join)
        if ($_POST['columns'][$j] == 'Participants.Address_Street_Name'
                || $_POST['columns'][$j] == 'Participants.Address_Street_Num'
                || $_POST['columns'][$j] == 'Participants.Address_Street_Direction'
                || $_POST['columns'][$j] == 'Participants.Address_Street_Type'
               )
        {
          //  echo 'saw a street column';
            $zipcode = 1;
            $property_join_sqlsafe = " LEFT JOIN Properties ON Participants_Properties.Property_ID=Properties.Property_ID ";
            $property_sqlsafe = "";
            $new_col = explode('.', $_POST['columns'][$j]);
            include "../include/dbconnopen.php";
            $new_col_sqlsafe=mysqli_real_escape_string($cnnSWOP, $new_col[1]);
           // $select_start_sqlsafe.='Properties.' . $new_col[1] ;
            $props_start_sqlsafe.='Properties.' . $new_col_sqlsafe . ", ";
           // echo "property string: " . $props_start_sqlsafe . "<br>";
           /* if ( $zipcode==1){
            $property_start .= ", Properties.Zipcode";
            }*/
          //  echo $select_start_sqlsafe . "<br>";
        }
      /*  elseif($_POST['columns'][$j] == 'Properties.Address_Street_Name'
                || $_POST['columns'][$j] == 'Properties.Address_Street_Num'
                || $_POST['columns'][$j] == 'Properties.Address_Street_Direction'
                || $_POST['columns'][$j] == 'Properties.Address_Street_Type'){
            $property_join_sqlsafe = " LEFT JOIN Properties ON Participants_Properties.Property_ID=Properties.Property_ID ";
            $property = "";
             $select_start_sqlsafe .= $_POST['columns'][$j];
        }*/
       else {
            //if Participants.ITIN is selected
            if ($_POST['columns'][$j] == 'Participants.ITIN') {
                $select_start_sqlsafe .= "Reports__ITIN.Value AS Participants_ITIN";
                $join_itin_sqlsafe = " JOIN Reports__ITIN ON Participants.ITIN = Reports__ITIN.ID ";
            //if member_type.Active is selected
            } elseif ($_POST['columns'][$j] == 'member_type.Active') {
                $select_start_sqlsafe .= "Reports__Active.Value";
                $join_member_type_active_sqlsafe = " JOIN Reports__Active ON member_type.Active = Reports__Active.ID ";
            //if member_type.Member_Type is selected
            } elseif ($_POST['columns'][$j] == 'member_type.Member_Type') {
                $select_start_sqlsafe .= "Pool_Member_Types.Type_Name AS Member_Type";
                $join_member_type_sqlsafe = " JOIN Pool_Member_Types ON member_type.Member_Type = Pool_Member_Types.Type_ID ";
            //if Pool_Progress.More_Info is selected
            } elseif ($_POST['columns'][$j] == 'Pool_Progress.More_Info') {
                $select_start_sqlsafe .= "CONCAT(Pool_Progress_More_Info.Name_First, ' ', Pool_Progress_More_Info.Name_Last) AS More_Info";
                $join_more_info_sqlsafe = " JOIN Participants AS Pool_Progress_More_Info ON Pool_Progress.More_info = Pool_Progress_More_Info.Participant_ID ";
            //if Pool_Progress.Benchmark_Completed is selected
            } elseif ($_POST['columns'][$j] == 'Pool_Progress.Benchmark_Completed') {
                $select_start_sqlsafe .= "Pool_Benchmarks.Benchmark_Name";
                $join_benchmark_completed_sqlsafe = " JOIN Pool_Benchmarks ON Pool_Progress.Benchmark_Completed = Pool_Benchmarks.Pool_Benchmark_ID ";
            //if Participants.Activity_Type is selected
            } elseif ($_POST['columns'][$j] == 'Participants.Activity_Type') {
                $select_start_sqlsafe .= "Reports__Activity_Type0.Value";
                $join_participants_activity_type_sqlsafe = " JOIN Reports__Activity_Type AS Reports__Activity_Type0 ON Participants.Activity_Type = Reports__Activity_Type0.ID ";
            //if member_type.Activity_Type is selected
            } elseif ($_POST['columns'][$j] == 'member_type.Activity_Type') {
                $select_start_sqlsafe .= "Reports__Activity_Type1.Value";
                $join_member_type_activity_type_sqlsafe = " JOIN Reports__Activity_Type AS Reports__Activity_Type1 ON member_type.Activity_Type = Reports__Activity_Type1.ID ";
            //if Pool_Progress.Activity_Type is selected
            } elseif ($_POST['columns'][$j] == 'Pool_Progress.Activity_Type') {
                $select_start_sqlsafe .= "Reports__Activity_Type2.Value";
                $join_pool_progress_activity_type_sqlsafe = " JOIN Reports__Activity_Type AS Reports__Activity_Type2 ON Pool_Progress.Activity_Type = Reports__Activity_Type2.ID ";
             //if the name is chosen, keep it separate
            } elseif($_POST['columns'][$j]== 'Participants.Name_First'){
                $first_name_string_sqlsafe = 'Participants.Name_First, ';
            }elseif($_POST['columns'][$j]== 'Participants.Name_Last'){
                $last_name_string_sqlsafe = 'Participants.Name_Last, ';
            }
            elseif ($_POST['columns'][$j]!='Participants.Primary_Organizer' && $_POST['columns'][$j]!='Institutions_Participants.Institution_ID'
    && $_POST['columns'][$j]!='Institutions_Participants.Individual_Connection') {
                $select_start_sqlsafe .= $_POST['columns'][$j];
              //  echo "in the else <br>";
            }
        }
        
        //if primary_organiser is selected
        if ($_POST['columns'][$j] == 'Participants.Primary_Organizer') {
            $select_start_sqlsafe .= " CONCAT(Organizer_Info_ID_Table.Name_First, ' ', Organizer_Info_ID_Table.Name_Last) AS Primary_Organizer_Name, ";
            $_POST['columns'][$j] = 'Primary_Organizer_Name';
            $organizer_join_sqlsafe = " LEFT JOIN Participants AS Organizer_Info_ID_Table ON Participants.Primary_Organizer = Organizer_Info_ID_Table.Participant_ID ";
        }
    
        //if institution_id is selected
        if ($_POST['columns'][$j] == 'Institutions_Participants.Institution_ID') {
            $select_start_sqlsafe .= " Institutions.Institution_Name, ";
            $_POST['columns'][$j] = 'Institutions.Institution_Name';
            $join_inst_sqlsafe = " LEFT JOIN Institutions ON Institutions_Participants.Institution_ID = Institutions.Institution_ID ";
        }
        
        //if individual_connection is selected
        if ($_POST['columns'][$j] == 'Institutions_Participants.Individual_Connection') {
            $select_start_sqlsafe .= "  CONCAT(Connection_Info.Name_First, ' ', Connection_Info.Name_Last) AS Individual_Connection_Name, ";
            $_POST['columns'][$j] = 'Connection_Info.Individual_Connection_Name';
            $join_connection_sqlsafe = " LEFT JOIN Participants AS Connection_Info ON Individual_Connection=Connection_Info.Participant_ID ";
        }
        
        //if it isn't the last item to be pulled, add a comma
        if ($j != (count($_POST['columns']) - 1)&& ($_POST['columns'][$j] != 'Participants.Address_Street_Name'
                && $_POST['columns'][$j] != 'Participants.Address_Street_Num'
                && $_POST['columns'][$j] != 'Participants.Address_Street_Direction'
                && $_POST['columns'][$j] != 'Participants.Address_Street_Type'
                && $_POST['columns'][$j] != 'Participants.Name_First'
                && $_POST['columns'][$j] != 'Participants.Name_Last'
                && $_POST['columns'][$j] != 'Primary_Organizer_Name'
                && $_POST['columns'][$j] != 'Institutions.Institution_Name'
                && $_POST['columns'][$j] != 'Connection_Info.Individual_Connection_Name'
                )) {
            $select_start_sqlsafe .= ", ";
            //echo "comma";
        } elseif ($j == (count($_POST['columns']) - 1) ) {
              //this is the last item
                if (($_POST['columns'][$j] != 'Participants.Address_Street_Name'
                && $_POST['columns'][$j] != 'Participants.Address_Street_Num'
                && $_POST['columns'][$j] != 'Participants.Address_Street_Direction'
                && $_POST['columns'][$j] != 'Participants.Address_Street_Type'
                && $_POST['columns'][$j] != 'Participants.Name_First'
                && $_POST['columns'][$j] != 'Participants.Name_Last'
                && $_POST['columns'][$j] != 'Primary_Organizer_Name'
                && $_POST['columns'][$j] != 'Institutions.Institution_Name'
                && $_POST['columns'][$j] != 'Connection_Info.Individual_Connection_Name'
                )){
                $select_start_sqlsafe .= ", ";}
                else{
                    $select_start_sqlsafe .=" ";
                }
         }
        
        /* elseif($j == (count($_POST['columns']) - 1) && ($_POST['columns'][$j] == 'Primary_Organizer_Name'
                || $_POST['columns'][$j] == 'Institutions.Institution_Name'
                || $_POST['columns'][$j] == 'Connection_Info.Individual_Connection_Name')){
             $select_start_sqlsafe .= " NULL ";
         }*/
         
        //echo "medium earlier select: " . $select_start_sqlsafe . "<br>";
    }
   // echo "earlier select: " . $select_start_sqlsafe . "<br>";
    /*
    //if primary_organiser is selected
    if ($_POST['organizer'] != '0') {
        $select_start_sqlsafe .= " CONCAT(Organizer_Info.Name_First, ' ', Organizer_Info.Name_Last) AS Primary_Organizer_Name";
    }
    */
    /* now that the columns have been chosen, add the table to the query: */
    $select_start_sqlsafe .= " NULL FROM Participants ";
//echo $select_start_sqlsafe . "<br>";
//I'm going to follow the same partial search mechanism that I've used before.  If a search term
//is chosen, then I'll use it for searching.  One thing I may have to change is allowing them to search for the
//null - that is, find people who /don't have/ a primary institution or something like that.

    include "../include/dbconnopen.php";
    if ($_POST['inst'] != 0) {
        $institution_sqlsafe = " AND Institutions_Participants.Institution_ID = '" . mysqli_real_escape_string($cnnSWOP, $_POST['inst']) . "' AND Is_Primary=1 ";
        $join_inst_sqlsafe = " LEFT JOIN Institutions_Participants ON Participants.Participant_ID = Institutions_Participants.Participant_ID "
                    . $join_inst_sqlsafe;
    } else {
        $institution_sqlsafe = "";
        $join_inst_sqlsafe .= "";
    }
    if ($_POST['type'] != 0) {
        $type_sqlsafe = " AND member_type.Member_Type='" . mysqli_real_escape_string($cnnSWOP, $_POST['type']) . "' ";
        $member_type_join_sqlsafe_sqlsafe = " INNER JOIN 
        (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) lasttypestatus
        ON member_type.Date_Changed = lasttypestatus.lastdate ";
    } else {
        $type_sqlsafe = "";
        $member_type_join_sqlsafe_sqlsafe = "";
    }
    //note that this is a little trickier because we have to get the most recent benchmark completed.  that's where the extra join comes in.
    if ($_POST['step'] != 0) {
        $step_sqlsafe = " AND Pool_Progress.Benchmark_Completed = '" . mysqli_real_escape_string($cnnSWOP, $_POST['step']) . "' AND Pool_Progress.Participant_ID = progress.Participant_ID ";
        $benchmarks_sqlsafe = " INNER JOIN Pool_Progress ON Participants.Participant_ID = Pool_Progress.Participant_ID 
        INNER JOIN (
        SELECT Participant_ID, Benchmark_Completed, MAX(Date_Completed) as LDATE
        FROM Pool_Progress
        GROUP BY Participant_ID) progress
        ON Pool_Progress.Date_Completed = progress.LDATE ";
    } else {
        $step_sqlsafe = "";
        $benchmarks_sqlsafe = "";
    }
    
    //benchmark that has been completed
    if ($_POST['step_done'] != 0) {
        $step_done_sqlsafe = " AND Participants.Participant_ID IN (SELECT Participant_ID FROM Pool_Progress WHERE Benchmark_Completed = '" . mysqli_real_escape_string($cnnSWOP, $_POST['step_done']) . "') ";
    } else {
        $step_done_sqlsafe = "";
    }
    
    if ($_POST['start'] != '') {
        $start_sqlsafe = " AND member_type.Date_Changed >= '" . mysqli_real_escape_string($cnnSWOP, $_POST['start']) . "' AND member_type.Active = 1 ";
        $date_join_sqlsafe = " INNER JOIN 
        (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) laststatus
        ON member_type.Date_Changed = laststatus.lastdate ";
    } else {
        $start_sqlsafe = "";
    }
    if ($_POST['end'] != '') {
        $end_sqlsafe = " AND member_type.Date_Changed <= '" . mysqli_real_escape_string($cnnSWOP, $_POST['end']) . "' AND member_type.Active = 1 ";
        $date_join_sqlsafe = " INNER JOIN 
        (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) laststatus
        ON member_type.Date_Changed = laststatus.lastdate ";
    } else {
        $end_sqlsafe = "";
    }

    if ($_POST['type'] != 0 || $_POST['start'] != '' || $_POST['end'] != '') {
        $status_sqlsafe = " INNER JOIN Pool_Status_Changes as member_type
        ON Participants.Participant_ID = member_type.Participant_ID ";
    } else {
        $status_sqlsafe = "";
    }
    if ($_POST['laggers'] != '') {//first get the date based on the number of days ago
        date_default_timezone_set('America/Chicago');
        $last_date = mktime(0, 0, 0, date("m"), date("d") - ($_POST['laggers']), date("Y"));
        $last_date = date("Y-m-d", $last_date);
        $lag_sqlsafe = " AND Pool_Progress.Date_Completed <= '" . mysqli_real_escape_string($cnnSWOP, $last_date) . "' AND Pool_Progress.Participant_ID 
    = progress.Participant_ID AND still_active.Active = 1 ";
        $benchmarks_sqlsafe = " INNER JOIN Pool_Progress ON Participants.Participant_ID = Pool_Progress.Participant_ID 
        INNER JOIN (
        SELECT Participant_ID, Benchmark_Completed, MAX(Date_Completed) as LDATE
        FROM Pool_Progress
        GROUP BY Participant_ID) progress
    ON Pool_Progress.Date_Completed = progress.LDATE ";
        $date_join_sqlsafe = "INNER JOIN Pool_Status_Changes as still_active ON Participants.Participant_ID = still_active.Participant_ID
 INNER JOIN (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) laststatus
        ON still_active.Date_Changed=laststatus.lastdate ";
    } else {
        $lag_sqlsafe = " ";
    }

    if ($_POST['organizer'] != '0') {
        $organizer_sqlsafe = " AND Participants.Primary_Organizer='" . mysqli_real_escape_string($cnnSWOP, $_POST['organizer']) . "' ";
        $organizer_join_sqlsafe = " LEFT JOIN Participants AS Organizer_Info_Chosen ON Participants.Primary_Organizer = Organizer_Info_Chosen.Participant_ID ";
    } else {
        $organizer_sqlsafe = "";
        if (!isset($organizer_join_sqlsafe)) {
            $organizer_join_sqlsafe = "";
        }
    }

    if ($_POST['first_name'] != '') {
        $first_name_sqlsafe = " AND Participants.Name_First LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['first_name']) . "%' ";
    } else {
        $first_name_sqlsafe = "";
    }

    if ($_POST['middle_name'] != '') {
        $middle_name_sqlsafe = " AND Participants.Name_Middle LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['middle_name']) . "%' ";
    } else {
        $middle_name_sqlsafe = "";
    }

    if ($_POST['last_name'] != '') {
        $last_name_sqlsafe = " AND Participants.Name_Last LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['last_name']) . "%' ";
    } else {
        $last_name_sqlsafe = "";
    }

    if ($_POST['email'] != '') {
        $email_sqlsafe = " AND Participants.Email LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['email']) . "%' ";
    } else {
        $email_sqlsafe = "";
    }
    
    if ($_POST['phone'] != '') {
        $phone_sqlsafe = " AND (Participants.Phone_Day LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['phone']) . "%' 
                    OR Participants.Phone_Evening LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['phone']) . "%') ";
    } else {
        $phone_sqlsafe = "";
    }

    if ($_POST['notes'] != '') {
        $notes_sqlsafe = " AND Participants.Notes LIKE '%" . mysqli_real_escape_string($cnnSWOP, $_POST['notes']) . "%' ";
    } else {
        $notes_sqlsafe = "";
    }
    
    if ($_POST['date_of_birth'] != '') {
        $date_of_birth_sqlsafe = " AND Participants.Date_of_Birth = '" . mysqli_real_escape_string($cnnSWOP, $_POST['date_of_birth']) . "' ";
    } else {
        $date_of_birth_sqlsafe = "";
    }

    if ($_POST['gender'] != '0') {
        $gender_sqlsafe = " AND Participants.Gender = '" . mysqli_real_escape_string($cnnSWOP, $_POST['gender']) . "' ";
    } else {
        $gender_sqlsafe = "";
    }

    if ($_POST['has_itin'] != '') {
        $has_itin_sqlsafe = " AND Participants.ITIN = " . mysqli_real_escape_string($cnnSWOP, $_POST['has_itin']) . " ";
    } else {
        $has_itin_sqlsafe = "";
    }

    if ($_POST['language_spoken'] == 'English') {
        $language_spoken_sqlsafe = " AND Participants.Lang_Eng = 1 ";
    } else if ($_POST['language_spoken'] == 'Spanish') {
        $language_spoken_sqlsafe = " AND Participants.Lang_Span = 1 ";
    } else if ($_POST['language_spoken'] == 'Other') {
        $language_spoken_sqlsafe = " AND Participants.Lang_Other = 1 ";
    } else {
        $language_spoken_sqlsafe = "";
    }

    if ($_POST['ward'] != '0') {
        $ward_sqlsafe = " AND Participants.Ward = '" . mysqli_real_escape_string($cnnSWOP, $_POST['ward']) . "' ";
    } else {
        $ward_sqlsafe = "";
    }
    
    //if Institutions_Participants table is utilized, add it to the query
    if ($_POST['table_institutions_participants'] != '') {
        $temp_join_inst = 'INNER JOIN Institutions_Participants ON Participants.Participant_ID = Institutions_Participants.Participant_ID';
        //if the join string is not in query, add it
        if (strpos($join_inst_sqlsafe, $temp_join_inst) === false) {
            $join_inst_sqlsafe = " INNER JOIN Institutions_Participants ON Participants.Participant_ID = Institutions_Participants.Participant_ID "
                        . $join_inst_sqlsafe;
        }
    }
    
    //if Pool_Progress table is utilized, add it to the query
    if ($_POST['table_pool_progress'] != '') {
        $temp_benchmarks = 'JOIN Pool_Progress ON Participants.Participant_ID = Pool_Progress.Participant_ID';
        //if the join string is not in query, add it
        if (strpos($benchmarks_sqlsafe, $temp_benchmarks) === false) {
            $benchmarks_sqlsafe = " JOIN Pool_Progress ON Participants.Participant_ID = Pool_Progress.Participant_ID "
                        . $benchmarks_sqlsafe;
        }
    }
    
    //if Organizer_Info table is utilized, add it to the query
    if ($_POST['table_organizer_info'] != '') {
        $temp_organizer_join = 'INNER JOIN Participants AS Organizer_Info ON Participants.Primary_Organizer = Organizer_Info.Participant_ID';
        //if the join string is not in query, add it
        if (strpos($organizer_join_sqlsafe, $temp_organizer_join) === false) {
            $organizer_join_sqlsafe = " INNER JOIN Participants AS Organizer_Info ON Participants.Primary_Organizer = Organizer_Info.Participant_ID "
                        . $organizer_join_sqlsafe;
        }
    }
    
    $group_by_sqlsafe = "";
    //if no other tables are selected, group by Participants.Participant_ID
    /*
    if (($_POST['table_institutions_participants'] == '')
            && ($_POST['table_pool_progress'] == '')
            && ($_POST['table_organizer_info'] == ''))
     */
    if ($_POST['group_by'] != '') {
        $group_by_sqlsafe = " GROUP BY Participants.Participant_ID";
    }
   if ($props_start_sqlsafe!=""){ $props_start_sqlsafe.="Properties.Zipcode, ";}
   // echo $very_start_sqlsafe_sqlsafe . "<br>";
  //  echo "properties: ". $props_start_sqlsafe . "<br><p>";
  //  echo "select: " . $select_start_sqlsafe . "<br>";
    /* final query. made up of the columns we put together at the beginning, any additional joins, and the various search terms that were
     * chosen by the user. */
    $search_pool_sqlsafe = $very_start_sqlsafe . $first_name_string_sqlsafe . $last_name_string_sqlsafe_sqlsafe . $props_start_sqlsafe .$select_start_sqlsafe .  " LEFT JOIN Participants_Properties ON Participants.Participant_ID = Participants_Properties.Participant_ID "
            . $join_inst_sqlsafe .$join_connection_sqlsafe. $status_sqlsafe . $benchmarks_sqlsafe . $date_join_sqlsafe . $organizer_join_sqlsafe . $member_type_join_sqlsafe . $property_join_sqlsafe
            . $join_itin_sqlsafe . $join_member_type_sqlsafe . $join_pool_progress . $join_more_info_sqlsafe
            . $join_benchmark_completed_sqlsafe . $join_member_type_active_sqlsafe
            . $join_participants_activity_type_sqlsafe . $join_member_type_activity_type_sqlsafe . $join_pool_progress_activity_type_sqlsafe
            . " WHERE Participants.Participant_ID IS NOT NULL "
            . $institution_sqlsafe . $type_sqlsafe . $step_sqlsafe . $step_done_sqlsafe . $start_sqlsafe . $end_sqlsafe . $lag_sqlsafe . $organizer_sqlsafe . $property_sqlsafe
            . $first_name_sqlsafe . $middle_name_sqlsafe . $last_name_sqlsafe . $email_sqlsafe . $phone_sqlsafe . $notes_sqlsafe
            . $date_of_birth_sqlsafe . $gender_sqlsafe . $has_itin_sqlsafe . $ward_sqlsafe . $language_spoken_sqlsafe
            . $group_by_sqlsafe
            . " ORDER BY Participants.Participant_ID ";
            // . " GROUP BY Participants.Participant_ID";

     // echo $search_pool . "<p>";

    include "../include/dbconnopen.php";
    $search_results = mysqli_query($cnnSWOP, $search_pool_sqlsafe);

    /* put person results into a file: */
    date_default_timezone_set('America/Chicago');
    $infile = "downloads/search_individuals_" . date('M-d-Y') . ".csv";
    $fp = fopen($infile, "w") or die('can\'t open file');
    $columns = $_POST['columns'];
    array_unshift($columns, 'Participants.Participant_ID');
    fputcsv($fp, $columns);

//start export process here
    $infile = "export_holder/participant_search_results_" . date('M') . "_" . date('d') . "_" . date('y') . ".csv";
//echo $infile;
    $fp = fopen($infile, "w") or die('can\'t open file');
    ?>
    <!-- person result table: -->
    <table class="all_projects">
        <tr><th>Participant ID</th>
            <?php
            /* create table heading and the first row of the .csv export: */
            $title_array = array('Participant ID');
            $search_string= $first_name_string_sqlsafe . $last_name_string_sqlsafe .$props_start_sqlsafe . $select_start_sqlsafe;
            $titles_arr=explode(',', $search_string);
            
            foreach ($_POST['columns'] as $col) {
                if ($col!=' NULL  FROM Participants '){
                ?><th><?php
                        echo $col;
                        $title_array[] = $col;
                        ?></th><?php
                //if primary organizer selected, show name
                if (($col == 'Participants.Primary_Organizer') && ($organizer_join_sqlsafe != '')) {
                    ?><th>Primary_Organizer_Name<?php
                        $title_array[] = 'Primary_Organizer_Name';
                        ?></th><?php
                }
                //if institution_id selected, show name
                if (($col == 'Institutions_Participants.Institution_ID') && ($join_inst_sqlsafe != '')) {
                    ?><th>Institutions.Institution_Name<?php
                        $title_array[] = 'Institutions.Institution_Name';
                        ?></th><?php
                }
                }
            }
         /*   if ($zipcode == 1) {
                /* if they asked for any address information, include a zipcode column: */
                ?><!--<th>Properties.Zipcode
                    <?php /*$title_array[] = 'Properties.Zipcode'; */?></th>--><?php
            /*}*/
            fputcsv($fp, $title_array);
            ?></tr>
            <?php
            while ($result = mysqli_fetch_row($search_results)) {
                ?><tr><?php
                    foreach ($result as $cell) {
                        ?><td class="all_projects"><?php echo $cell;
                        ?></td><?php
                }
                fputcsv($fp, $result);
                ?></tr><?php
            }
            fclose($fp);
            ?>
    </table>
    <a href="<?php echo $infile; ?>" style="font-size:.7em;">Download Results</a>

    <?php
    include "../include/dbconnclose.php";
}








/* for property searches, similar process: */ elseif ($_POST['search_type'] == 'properties') {
    /* get columns chosen by user: */
    include "../include/dbconnopen.php";
    $select_start_sqlsafe = 'SELECT Properties.Property_ID, ';
    for ($j = 0; $j < count($_POST['columns']); $j++) {
        if ($j == (count($_POST['columns']) - 1)) {
            $select_start_sqlsafe .= mysqli_real_escape_string($cnnSWOP, $_POST['columns'][$j]);
        } else {
            $select_start_sqlsafe .= mysqli_real_escape_string($cnnSWOP, $_POST['columns'][$j]) . ", ";
        }
    }

    /* create query based on the search terms chosen by the user: */
    if ($_POST['vacant'] != 0) {
        if ($_POST['vacant'] == 1) {
            $vacant_sqlsafe = " AND Property_Progress.Marker=8 AND Addtl_Info_1='Not vacant'";
        } else {
            $vacant_sqlsafe = " AND Property_Progress.Marker=8 AND Addtl_Info_2='" . mysqli_real_escape_string($cnnSWOP, $_POST['vacant']) . "'";
        }
        $vacant_join_sqlsafe = " 
INNER JOIN (
SELECT Property_ID, Marker, MAX(Date_Added) as latest_date
FROM Property_Progress WHERE Marker=8
GROUP BY Property_ID) vacant_progress
ON Property_Progress.Date_Added = vacant_progress.latest_date ";
    } else {
        $vacant_sqlsafe = "";
        $vacant_join_sqlsafe = "";
    }
    if ($_POST['condition'] != 0) {
        $condition_sqlsafe = " AND Property_Progress.Marker=11 AND Addtl_Info_1='" . mysqli_real_escape_string($cnnSWOP, $_POST['condition']) . "' ";
        $condition_join_sqlsafe = " 
INNER JOIN (
SELECT Property_ID, Marker, MAX(Date_Added) as latest_date
FROM Property_Progress WHERE Marker=11
GROUP BY Property_ID) condition_progress
ON Property_Progress.Date_Added = condition_progress.latest_date ";
    } else {
        $condition_sqlsafe = "";
        $condition_join_sqlsafe = "";
    }
    if ($_POST['for_sale'] != 0) {
        $for_sale_sqlsafe = " AND Property_Progress.Marker=4 AND Addtl_Info_1='For Sale'";
        $sale_progress_sqlsafe = " 
INNER JOIN (
SELECT Property_ID, Marker, MAX(Date_Added) as latest_date
FROM Property_Progress WHERE Marker=4
GROUP BY Property_ID) sale_progress
ON Property_Progress.Date_Added = sale_progress.latest_date ";
    } else {
        $for_sale_sqlsafe = "";
        $sale_progress_sqlsafe = "";
    }


    if ($_POST['price_low'] != '') {
        $price_range_low_sqlsafe = " AND Property_Progress.Marker=4 AND Addtl_Info_2>='" . mysqli_real_escape_string($cnnSWOP, $_POST['price_low']) . "' ";
    } else {
        $price_range_low_sqlsafe = "";
    }
    if ($_POST['price_high'] != '') {
        $price_range_high_sqlsafe = " AND Property_Progress.Marker=4 AND Addtl_Info_2<='" . mysqli_real_escape_string($cnnSWOP, $_POST['price_high']) . "' ";
    } else {
        $price_range_high_sqlsafe = "";
    }
    if ($_POST['type'] != 0) {
        $type_sqlsafe = " AND Properties.Construction_Type='" . mysqli_real_escape_string($cnnSWOP, $_POST['type']) . "' ";
    } else {
        $type_sqlsafe = "";
    }
    if ($_POST['size'] != 0) {
        $size_sqlsafe = " AND Properties.Home_Size='" . mysqli_real_escape_string($cnnSWOP, $_POST['size']) . "' ";
    } else {
        $size_sqlsafe = "";
    }
    if ($_POST['interest_start'] != 0) {
        $interest_date_start_sqlsafe = " AND Property_Progress.Marker=7 AND Date_Added>= '" . mysqli_real_escape_string($cnnSWOP, $_POST['interest_start']) . "' ";
    } else {
        $interest_date_start_sqlsafe = "";
    }
    if ($_POST['interest_end'] != 0) {
        $interest_date_end_sqlsafe = " AND Property_Progress.Marker=7 AND Date_Added<='" . mysqli_real_escape_string($cnnSWOP, $_POST['interest_end']) . "' ";
    } else {
        $interest_date_end_sqlsafe = "";
    }
    if ($_POST['interest_reason'] != 0) {
        $interest_reason_sqlsafe = " AND Property_Progress.Marker=7 AND Addtl_Info_1='" . mysqli_real_escape_string($cnnSWOP, $_POST['interest_reason']) . "' ";
    } else {
        $interest_reason_sqlsafe = "";
    }

    if ($_POST['acquisition_start'] != 0) {
        $acquisition_start_sqlsafe = " AND Property_Progress.Marker=1 AND Date_Added>= '" . mysqli_real_escape_string($cnnSWOP, $_POST['acquisition_start']) . "' ";
    } else {
        $acquisition_start_sqlsafe = "";
    }
    if ($_POST['acquisition_end'] != 0) {
        $acquisition_end_sqlsafe = " AND Property_Progress.Marker=1 AND Date_Added<='" . mysqli_real_escape_string($cnnSWOP, $_POST['acquisition_end']) . "' ";
    } else {
        $acquisition_end_sqlsafe = "";
    }
    if ($_POST['ac_cost_low'] != 0) {
        $ac_cost_low_sqlsafe = " AND Property_Progress.Marker=1 AND Addtl_Info_1>='" . mysqli_real_escape_string($cnnSWOP, $_POST['ac_cost_low']) . "' ";
    } else {
        $ac_cost_low_sqlsafe = "";
    }
    if ($_POST['ac_cost_high'] != 0) {
        $ac_cost_high_sqlsafe = " AND Property_Progress.Marker=1 AND Addtl_Info_1<='" . mysqli_real_escape_string($cnnSWOP, $_POST['ac_cost_high']) . "' ";
    } else {
        $ac_cost_high_sqlsafe = "";
    }
    if ($_POST['construction_start'] != 0) {
        $construction_start_sqlsafe = " AND Property_Progress.Marker=2 AND Date_Added>= '" . mysqli_real_escape_string($cnnSWOP, $_POST['construction_start']) . "' ";
    } else {
        $construction_start_sqlsafe = "";
    }
    if ($_POST['construction_end'] != 0) {
        $construction_end_sqlsafe = " AND Property_Progress.Marker=2 AND Date_Added<= '" . mysqli_real_escape_string($cnnSWOP, $_POST['construction_end']) . "' ";
    } else {
        $construction_end_sqlsafe = "";
    }
    if ($_POST['con_cost_low'] != 0) {
        $con_cost_low_sqlsafe = " AND Property_Progress.Marker=2 AND Addtl_Info_1>='" . mysqli_real_escape_string($cnnSWOP, $_POST['con_cost_low']) . "' ";
    } else {
        $con_cost_low_sqlsafe = "";
    }
    if ($_POST['con_cost_high'] != 0) {
        $con_cost_high_sqlsafe = " AND Property_Progress.Marker=2 AND Addtl_Info_1<='" . mysqli_real_escape_string($cnnSWOP, $_POST['con_cost_high']) . "' ";
    } else {
        $con_cost_high_sqlsafe = "";
    }
    if ($_POST['certificate_start'] != 0) {
        $cert_start_sqlsafe = " AND Property_Progress.Marker=3 AND Date_Added>= '" . mysqli_real_escape_string($cnnSWOP, $_POST['certificate_start']) . "' ";
    } else {
        $cert_start_sqlsafe = "";
    }
    if ($_POST['certificate_end'] != 0) {
        $cert_end_sqlsafe = " AND Property_Progress.Marker=3 AND Date_Added<= '" . mysqli_real_escape_string($cnnSWOP, $_POST['certificate_end']) . "' ";
    } else {
        $cert_end_sqlsafe = "";
    }
    if ($_POST['listed_start'] != 0) {
        $listed_start_sqlsafe = " AND Property_Progress.Marker=4 AND Date_Added>= '" . mysqli_real_escape_string($cnnSWOP, $_POST['listed_start']) . "' ";
    } else {
        $listed_start_sqlsafe = "";
    }
    if ($_POST['listed_end'] != 0) {
        $listed_end_sqlsafe = " AND Property_Progress.Marker=4 AND Date_Added>= '" . mysqli_real_escape_string($cnnSWOP, $_POST['listed_end']) . "' ";
    } else {
        $listed_end_sqlsafe = "";
    }
    if ($_POST['contracts_low'] != 0) {
        $contracts_low_sqlsafe = " AND Property_Progress.Marker=4 AND Addtl_Info_1>='" . mysqli_real_escape_string($cnnSWOP, $_POST['contracts_low']) . "' ";
    } else {
        $contracts_low_sqlsafe = "";
    }
    if ($_POST['contracts_high'] != 0) {
        $contracts_high_sqlsafe = " AND Property_Progress.Marker=4 AND Addtl_Info_1<='" . mysqli_real_escape_string($cnnSWOP, $_POST['contracts_high']) . "' ";
    } else {
        $contracts_high_sqlsafe = "";
    }

    if ($_POST['date_sold_start'] != 0) {
        $sold_start_sqlsafe = " AND Property_Progress.Marker=5 AND Date_Added>= '" . mysqli_real_escape_string($cnnSWOP, $_POST['date_sold_start']) . "' ";
    } else {
        $sold_start_sqlsafe = "";
    }
    if ($_POST['date_sold_end'] != 0) {
        $sold_end_sqlsafe = " AND Property_Progress.Marker=5 AND Date_Added<='" . mysqli_real_escape_string($cnnSWOP, $_POST['date_sold_end']) . "' ";
    } else {
        $sold_end_sqlsafe = "";
    }
    if ($_POST['sale_price_low'] != 0) {
        $sale_price_low_sqlsafe = " AND Property_Progress.Marker=5 AND Addtl_Info_1>='" . mysqli_real_escape_string($cnnSWOP, $_POST['sale_price_low']) . "' ";
    } else {
        $sale_price_low_sqlsafe = "";
    }
    if ($_POST['sale_price_high'] != 0) {
        $sale_price_high_sqlsafe = " AND Property_Progress.Marker=5 AND Addtl_Info_1<='" . mysqli_real_escape_string($cnnSWOP, $_POST['sale_price_high']) . "' ";
    } else {
        $sale_price_high_sqlsafe = "";
    }
    if ($_POST['low_days'] != 0) {
        $days_low = " AND Property_Progress.Marker=5 AND Addtl_Info_3>='" . $_POST['low_days'] . "' ";
    } else {
        $days_low = "";
    }
    if ($_POST['high_days'] != 0) {
        $days_high = " AND Property_Progress.Marker=5 AND Addtl_Info_3<='" . $_POST['high_days'] . "' ";
    } else {
        $days_high = "";
    }
    if ($_POST['subsidy_low'] != 0) {
        $subsidy_low_sqlsafe = " AND Property_Progress.Marker=5 AND Addtl_Info_4>='" . mysqli_real_escape_string($cnnSWOP, $_POST['subsidy_low']) . "' ";
    } else {
        $subsidy_low_sqlsafe = "";
    }
    if ($_POST['subsidy_high'] != 0) {
        $subsidy_high_sqlsafe = " AND Property_Progress.Marker=5 AND Addtl_Info_4<='" . mysqli_real_escape_string($cnnSWOP, $_POST['subsidy_high']) . "' ";
    } else {
        $subsidy_high_sqlsafe = "";
    }

    if ($_POST['possession_start'] != 0) {
        $possession_start_sqlsafe = " AND Property_Progress.Marker=6 AND Date_Added>= '" . mysqli_real_escape_string($cnnSWOP, $_POST['possession_start']) . "' ";
    } else {
        $possession_start_sqlsafe = "";
    }
    if ($_POST['possession_end'] != 0) {
        $possession_end_sqlsafe = " AND Property_Progress.Marker=6 AND Date_Added<='" . mysqli_real_escape_string($cnnSWOP, $_POST['possession_end']) . "' ";
    } else {
        $possession_end_sqlsafe = "";
    }
    
    //if 
    //echo $_POST['table_institutions_participants'] . "***************";
    if ($_POST['table_institutions_participants'] != '') {
        if ($join_inst_sqlsafe == '') {
            $join_inst_sqlsafe = " INNER JOIN Institutions_Participants ON Participants.Participant_ID = Institutions_Participants.Participant_ID ";
        }
    }

    /* create final query from the columns, extra table joins, and all the specifications from the user: */
    $search_properties_sqlsafe = $select_start_sqlsafe . " FROM Properties INNER JOIN 
            Property_Progress ON Properties.Property_ID=Property_Progress.Property_ID "
            . $vacant_join_sqlsafe . $condition_join_sqlsafe . $sale_progress_sqlsafe .
            " WHERE Properties.Property_ID IS NOT NULL " . $type_sqlsafe . $size_sqlsafe .
            $interest_date_start_sqlsafe . $interest_date_end_sqlsafe . $interest_reason_sqlsafe . $vacant_sqlsafe . $for_sale_sqlsafe . $price_range_high_sqlsafe . $price_range_low_sqlsafe . $condition_sqlsafe .
            $acquisition_start_sqlsafe . $acquisition_end_sqlsafe . $ac_cost_low_sqlsafe . $ac_cost_high_sqlsafe . $construction_start_sqlsafe . $construction_end_sqlsafe . $con_cost_low_sqlsafe . $con_cost_high_sqlsafe . $cert_start_sqlsafe .
            $cert_end_sqlsafe . $listed_start_sqlsafe . $listed_end_sqlsafe . $contracts_low_sqlsafe . $contracts_high_sqlsafe . $sold_start_sqlsafe . $sold_end_sqlsafe . $sale_price_low_sqlsafe . $sale_price_high_sqlsafe .
            $subsidy_low_sqlsafe . $subsidy_high_sqlsafe . $possession_start_sqlsafe . $possession_end_sqlsafe . " GROUP BY Properties.Property_ID";

   // echo $search_properties;

    include "../include/dbconnopen.php";
    $search_results = mysqli_query($cnnSWOP, $search_properties_sqlsafe);

    date_default_timezone_set('America/Chicago');
    $infile = "downloads/search_individuals_" . date('M-d-Y') . ".csv";
    $fp = fopen($infile, "w") or die('can\'t open file');
    $columns = $_POST['columns'];
    array_unshift($columns, 'Properties.Property_ID');


//start export process here
    $infile = "export_holder/property_search_results_" . date('M') . "_" . date('d') . "_" . date('y') . ".csv";
//echo $infile;
    $fp = fopen($infile, "w") or die('can\'t open file');
    ?>
    <!-- results table: -->
    <table class="all_projects">
        <tr><th>Property ID</th>
            <?php
            $title_array = array('Property ID');
            foreach ($_POST['columns'] as $col) {
                ?><th><?php
                        echo $col;
                        $title_array[] = $col;
                        ?></th><?php
            }
            fputcsv($fp, $title_array);
            ?></tr>
            <?php while ($result = mysqli_fetch_row($search_results)) {
                ?><tr><?php
                    foreach ($result as $cell) {
                        ?><td class="all_projects"><?php echo $cell; ?></td><?php
                }
                fputcsv($fp, $result);
                ?></tr><?php
        }
        fclose($fp);
        ?>
    </table>
    <a href="<?php echo $infile; ?>" style="font-size:.7em;">Download Results</a>

    <?php
    include "../include/dbconnclose.php";
}
?>