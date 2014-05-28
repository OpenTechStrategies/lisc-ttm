<?php
/* queries for people and properties.  Each is first sent to an ajax file (individual_search or property_search) to 
 * choose result columns, then comes here for actual results. */
// print_r($_POST['columns']);
if ($_POST['search_type'] == 'pool') {
    /* first get all the columns that the user has specified: */
    $very_start = 'SELECT Participants.Participant_ID, ';
    $select_start="";
    $props_start="";
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
            $property_join = " LEFT JOIN Properties ON Participants_Properties.Property_ID=Properties.Property_ID ";
            $property = "";
            $new_col = explode('.', $_POST['columns'][$j]);
           // $select_start.='Properties.' . $new_col[1] ;
            $props_start.='Properties.' . $new_col[1] . ", ";
           // echo "property string: " . $props_start . "<br>";
           /* if ( $zipcode==1){
            $property_start .= ", Properties.Zipcode";
            }*/
          //  echo $select_start . "<br>";
        }
      /*  elseif($_POST['columns'][$j] == 'Properties.Address_Street_Name'
                || $_POST['columns'][$j] == 'Properties.Address_Street_Num'
                || $_POST['columns'][$j] == 'Properties.Address_Street_Direction'
                || $_POST['columns'][$j] == 'Properties.Address_Street_Type'){
            $property_join = " LEFT JOIN Properties ON Participants_Properties.Property_ID=Properties.Property_ID ";
            $property = "";
             $select_start .= $_POST['columns'][$j];
        }*/
       else {
            //if Participants.ITIN is selected
            if ($_POST['columns'][$j] == 'Participants.ITIN') {
                $select_start .= "Reports__ITIN.Value AS Participants_ITIN";
                $join_itin = " JOIN Reports__ITIN ON Participants.ITIN = Reports__ITIN.ID ";
            //if member_type.Active is selected
            } elseif ($_POST['columns'][$j] == 'member_type.Active') {
                $select_start .= "Reports__Active.Value";
                $join_member_type_active = " JOIN Reports__Active ON member_type.Active = Reports__Active.ID ";
            //if member_type.Member_Type is selected
            } elseif ($_POST['columns'][$j] == 'member_type.Member_Type') {
                $select_start .= "Pool_Member_Types.Type_Name AS Member_Type";
                $join_member_type = " JOIN Pool_Member_Types ON member_type.Member_Type = Pool_Member_Types.Type_ID ";
            //if Pool_Progress.More_Info is selected
            } elseif ($_POST['columns'][$j] == 'Pool_Progress.More_Info') {
                $select_start .= "CONCAT(Pool_Progress_More_Info.Name_First, ' ', Pool_Progress_More_Info.Name_Last) AS More_Info";
                $join_more_info = " JOIN Participants AS Pool_Progress_More_Info ON Pool_Progress.More_info = Pool_Progress_More_Info.Participant_ID ";
            //if Pool_Progress.Benchmark_Completed is selected
            } elseif ($_POST['columns'][$j] == 'Pool_Progress.Benchmark_Completed') {
                $select_start .= "Pool_Benchmarks.Benchmark_Name";
                $join_benchmark_completed = " JOIN Pool_Benchmarks ON Pool_Progress.Benchmark_Completed = Pool_Benchmarks.Pool_Benchmark_ID ";
            //if Participants.Activity_Type is selected
            } elseif ($_POST['columns'][$j] == 'Participants.Activity_Type') {
                $select_start .= "Reports__Activity_Type0.Value";
                $join_participants_activity_type = " JOIN Reports__Activity_Type AS Reports__Activity_Type0 ON Participants.Activity_Type = Reports__Activity_Type0.ID ";
            //if member_type.Activity_Type is selected
            } elseif ($_POST['columns'][$j] == 'member_type.Activity_Type') {
                $select_start .= "Reports__Activity_Type1.Value";
                $join_member_type_activity_type = " JOIN Reports__Activity_Type AS Reports__Activity_Type1 ON member_type.Activity_Type = Reports__Activity_Type1.ID ";
            //if Pool_Progress.Activity_Type is selected
            } elseif ($_POST['columns'][$j] == 'Pool_Progress.Activity_Type') {
                $select_start .= "Reports__Activity_Type2.Value";
                $join_pool_progress_activity_type = " JOIN Reports__Activity_Type AS Reports__Activity_Type2 ON Pool_Progress.Activity_Type = Reports__Activity_Type2.ID ";
             //if the name is chosen, keep it separate
            } elseif($_POST['columns'][$j]== 'Participants.Name_First'){
                $first_name_string= 'Participants.Name_First, ';
            }elseif($_POST['columns'][$j]== 'Participants.Name_Last'){
                $last_name_string= 'Participants.Name_Last, ';
            }
            elseif ($_POST['columns'][$j]!='Participants.Primary_Organizer' && $_POST['columns'][$j]!='Institutions_Participants.Institution_ID'
    && $_POST['columns'][$j]!='Institutions_Participants.Individual_Connection') {
                $select_start .= $_POST['columns'][$j];
              //  echo "in the else <br>";
            }
        }
        
        //if primary_organiser is selected
        if ($_POST['columns'][$j] == 'Participants.Primary_Organizer') {
            $select_start .= " CONCAT(Organizer_Info_ID_Table.Name_First, ' ', Organizer_Info_ID_Table.Name_Last) AS Primary_Organizer_Name, ";
            $_POST['columns'][$j] = 'Primary_Organizer_Name';
            $organizer_join = " LEFT JOIN Participants AS Organizer_Info_ID_Table ON Participants.Primary_Organizer = Organizer_Info_ID_Table.Participant_ID ";
        }
    
        //if institution_id is selected
        if ($_POST['columns'][$j] == 'Institutions_Participants.Institution_ID') {
            $select_start .= " Institutions.Institution_Name, ";
            $_POST['columns'][$j] = 'Institutions.Institution_Name';
            $join_inst = " LEFT JOIN Institutions ON Institutions_Participants.Institution_ID = Institutions.Institution_ID ";
        }
        
        //if individual_connection is selected
        if ($_POST['columns'][$j] == 'Institutions_Participants.Individual_Connection') {
            $select_start .= "  CONCAT(Connection_Info.Name_First, ' ', Connection_Info.Name_Last) AS Individual_Connection_Name, ";
            $_POST['columns'][$j] = 'Connection_Info.Individual_Connection_Name';
            $join_connection = " LEFT JOIN Participants AS Connection_Info ON Individual_Connection=Connection_Info.Participant_ID ";
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
            $select_start .= ", ";
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
                $select_start .= ", ";}
                else{
                    $select_start .=" ";
                }
         }
        
        /* elseif($j == (count($_POST['columns']) - 1) && ($_POST['columns'][$j] == 'Primary_Organizer_Name'
                || $_POST['columns'][$j] == 'Institutions.Institution_Name'
                || $_POST['columns'][$j] == 'Connection_Info.Individual_Connection_Name')){
             $select_start .= " NULL ";
         }*/
         
        //echo "medium earlier select: " . $select_start . "<br>";
    }
   // echo "earlier select: " . $select_start . "<br>";
    /*
    //if primary_organiser is selected
    if ($_POST['organizer'] != '0') {
        $select_start .= " CONCAT(Organizer_Info.Name_First, ' ', Organizer_Info.Name_Last) AS Primary_Organizer_Name";
    }
    */
    /* now that the columns have been chosen, add the table to the query: */
    $select_start .= " NULL FROM Participants ";
//echo $select_start . "<br>";
//I'm going to follow the same partial search mechanism that I've used before.  If a search term
//is chosen, then I'll use it for searching.  One thing I may have to change is allowing them to search for the
//null - that is, find people who /don't have/ a primary institution or something like that.

    if ($_POST['inst'] != 0) {
        $institution = " AND Institutions_Participants.Institution_ID = '" . $_POST['inst'] . "' AND Is_Primary=1 ";
        $join_inst = " LEFT JOIN Institutions_Participants ON Participants.Participant_ID = Institutions_Participants.Participant_ID "
                    . $join_inst;
    } else {
        $institution = "";
        $join_inst .= "";
    }
    if ($_POST['type'] != 0) {
        $type = " AND member_type.Member_Type='" . $_POST['type'] . "' ";
        $member_type_join = " INNER JOIN 
        (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) lasttypestatus
        ON member_type.Date_Changed = lasttypestatus.lastdate ";
    } else {
        $type = "";
        $member_type_join = "";
    }
    //note that this is a little trickier because we have to get the most recent benchmark completed.  that's where the extra join comes in.
    if ($_POST['step'] != 0) {
        $step = " AND Pool_Progress.Benchmark_Completed = '" . $_POST['step'] . "' AND Pool_Progress.Participant_ID = progress.Participant_ID ";
        $benchmarks = " INNER JOIN Pool_Progress ON Participants.Participant_ID = Pool_Progress.Participant_ID 
        INNER JOIN (
        SELECT Participant_ID, Benchmark_Completed, MAX(Date_Completed) as LDATE
        FROM Pool_Progress
        GROUP BY Participant_ID) progress
        ON Pool_Progress.Date_Completed = progress.LDATE ";
    } else {
        $step = "";
        $benchmarks = "";
    }
    
    //benchmark that has been completed
    if ($_POST['step_done'] != 0) {
        $step_done = " AND Participants.Participant_ID IN (SELECT Participant_ID FROM Pool_Progress WHERE Benchmark_Completed = '" . $_POST['step_done'] . "') ";
    } else {
        $step_done = "";
    }
    
    if ($_POST['start'] != '') {
        $start = " AND member_type.Date_Changed >= '" . $_POST['start'] . "' AND member_type.Active = 1 ";
        $date_join = " INNER JOIN 
        (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) laststatus
        ON member_type.Date_Changed = laststatus.lastdate ";
    } else {
        $start = "";
    }
    if ($_POST['end'] != '') {
        $end = " AND member_type.Date_Changed <= '" . $_POST['end'] . "' AND member_type.Active = 1 ";
        $date_join = " INNER JOIN 
        (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) laststatus
        ON member_type.Date_Changed = laststatus.lastdate ";
    } else {
        $end = "";
    }

    if ($_POST['type'] != 0 || $_POST['start'] != '' || $_POST['end'] != '') {
        $status = " INNER JOIN Pool_Status_Changes as member_type
        ON Participants.Participant_ID = member_type.Participant_ID ";
    } else {
        $status = "";
    }
    if ($_POST['laggers'] != '') {//first get the date based on the number of days ago
        date_default_timezone_set('America/Chicago');
        $last_date = mktime(0, 0, 0, date("m"), date("d") - ($_POST['laggers']), date("Y"));
        $last_date = date("Y-m-d", $last_date);
        $lag = " AND Pool_Progress.Date_Completed <= '" . $last_date . "' AND Pool_Progress.Participant_ID 
    = progress.Participant_ID AND still_active.Active = 1 ";
        $benchmarks = " INNER JOIN Pool_Progress ON Participants.Participant_ID = Pool_Progress.Participant_ID 
        INNER JOIN (
        SELECT Participant_ID, Benchmark_Completed, MAX(Date_Completed) as LDATE
        FROM Pool_Progress
        GROUP BY Participant_ID) progress
    ON Pool_Progress.Date_Completed = progress.LDATE ";
        $date_join = "INNER JOIN Pool_Status_Changes as still_active ON Participants.Participant_ID = still_active.Participant_ID
 INNER JOIN (SELECT Active, Participant_ID, max(Date_Changed) as lastdate FROM Pool_Status_Changes
        GROUP BY Participant_ID) laststatus
        ON still_active.Date_Changed=laststatus.lastdate ";
    } else {
        $lag = " ";
    }

    if ($_POST['organizer'] != '0') {
        $organizer = " AND Participants.Primary_Organizer='" . $_POST['organizer'] . "' ";
        $organizer_join = " LEFT JOIN Participants AS Organizer_Info_Chosen ON Participants.Primary_Organizer = Organizer_Info_Chosen.Participant_ID ";
    } else {
        $organizer = "";
        if (!isset($organizer_join)) {
            $organizer_join = "";
        }
    }

    if ($_POST['first_name'] != '') {
        $first_name = " AND Participants.Name_First LIKE '%" . $_POST['first_name'] . "%' ";
    } else {
        $first_name = "";
    }

    if ($_POST['middle_name'] != '') {
        $middle_name = " AND Participants.Name_Middle LIKE '%" . $_POST['middle_name'] . "%' ";
    } else {
        $middle_name = "";
    }

    if ($_POST['last_name'] != '') {
        $last_name = " AND Participants.Name_Last LIKE '%" . $_POST['last_name'] . "%' ";
    } else {
        $last_name = "";
    }

    if ($_POST['email'] != '') {
        $email = " AND Participants.Email LIKE '%" . $_POST['email'] . "%' ";
    } else {
        $email = "";
    }
    
    if ($_POST['phone'] != '') {
        $phone = " AND (Participants.Phone_Day LIKE '%" . $_POST['phone'] . "%' 
                    OR Participants.Phone_Evening LIKE '%" . $_POST['phone'] . "%') ";
    } else {
        $phone = "";
    }

    if ($_POST['notes'] != '') {
        $notes = " AND Participants.Notes LIKE '%" . $_POST['notes'] . "%' ";
    } else {
        $notes = "";
    }
    
    if ($_POST['date_of_birth'] != '') {
        $date_of_birth = " AND Participants.Date_of_Birth = '" . $_POST['date_of_birth'] . "' ";
    } else {
        $date_of_birth = "";
    }

    if ($_POST['gender'] != '0') {
        $gender = " AND Participants.Gender = '" . $_POST['gender'] . "' ";
    } else {
        $gender = "";
    }

    if ($_POST['has_itin'] != '') {
        $has_itin = " AND Participants.ITIN = " . $_POST['has_itin'] . " ";
    } else {
        $has_itin = "";
    }

    if ($_POST['language_spoken'] == 'English') {
        $language_spoken = " AND Participants.Lang_Eng = 1 ";
    } else if ($_POST['language_spoken'] == 'Spanish') {
        $language_spoken = " AND Participants.Lang_Span = 1 ";
    } else if ($_POST['language_spoken'] == 'Other') {
        $language_spoken = " AND Participants.Lang_Other = 1 ";
    } else {
        $language_spoken = "";
    }

    if ($_POST['ward'] != '0') {
        $ward = " AND Participants.Ward = '" . $_POST['ward'] . "' ";
    } else {
        $ward = "";
    }
    
    //if Institutions_Participants table is utilized, add it to the query
    if ($_POST['table_institutions_participants'] != '') {
        $temp_join_inst = 'INNER JOIN Institutions_Participants ON Participants.Participant_ID = Institutions_Participants.Participant_ID';
        //if the join string is not in query, add it
        if (strpos($join_inst, $temp_join_inst) === false) {
            $join_inst = " INNER JOIN Institutions_Participants ON Participants.Participant_ID = Institutions_Participants.Participant_ID "
                        . $join_inst;
        }
    }
    
    //if Pool_Progress table is utilized, add it to the query
    if ($_POST['table_pool_progress'] != '') {
        $temp_benchmarks = 'JOIN Pool_Progress ON Participants.Participant_ID = Pool_Progress.Participant_ID';
        //if the join string is not in query, add it
        if (strpos($benchmarks, $temp_benchmarks) === false) {
            $benchmarks = " JOIN Pool_Progress ON Participants.Participant_ID = Pool_Progress.Participant_ID "
                        . $benchmarks;
        }
    }
    
    //if Organizer_Info table is utilized, add it to the query
    if ($_POST['table_organizer_info'] != '') {
        $temp_organizer_join = 'INNER JOIN Participants AS Organizer_Info ON Participants.Primary_Organizer = Organizer_Info.Participant_ID';
        //if the join string is not in query, add it
        if (strpos($organizer_join, $temp_organizer_join) === false) {
            $organizer_join = " INNER JOIN Participants AS Organizer_Info ON Participants.Primary_Organizer = Organizer_Info.Participant_ID "
                        . $organizer_join;
        }
    }
    
    $group_by = "";
    //if no other tables are selected, group by Participants.Participant_ID
    /*
    if (($_POST['table_institutions_participants'] == '')
            && ($_POST['table_pool_progress'] == '')
            && ($_POST['table_organizer_info'] == ''))
     */
    if ($_POST['group_by'] != '') {
        $group_by = " GROUP BY Participants.Participant_ID";
    }
   if ($props_start!=""){ $props_start.="Properties.Zipcode, ";}
   // echo $very_start . "<br>";
  //  echo "properties: ". $props_start . "<br><p>";
  //  echo "select: " . $select_start . "<br>";
    /* final query. made up of the columns we put together at the beginning, any additional joins, and the various search terms that were
     * chosen by the user. */
    $search_pool = $very_start . $first_name_string . $last_name_string . $props_start .$select_start .  " LEFT JOIN Participants_Properties ON Participants.Participant_ID = Participants_Properties.Participant_ID "
            . $join_inst .$join_connection. $status . $benchmarks . $date_join . $organizer_join . $member_type_join . $property_join
            . $join_itin . $join_member_type . $join_pool_progress . $join_more_info
            . $join_benchmark_completed . $join_member_type_active
            . $join_participants_activity_type . $join_member_type_activity_type . $join_pool_progress_activity_type
            . " WHERE Participants.Participant_ID IS NOT NULL "
            . $institution . $type . $step . $step_done . $start . $end . $lag . $organizer . $property
            . $first_name . $middle_name . $last_name . $email . $phone . $notes
            . $date_of_birth . $gender . $has_itin . $ward . $language_spoken
            . $group_by
            . " ORDER BY Participants.Participant_ID ";
            // . " GROUP BY Participants.Participant_ID";

     // echo $search_pool . "<p>";

    include "../include/dbconnopen.php";
    $search_results = mysqli_query($cnnSWOP, $search_pool);

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
            $search_string= $first_name_string . $last_name_string .$props_start . $select_start;
            $titles_arr=explode(',', $search_string);
            
            foreach ($_POST['columns'] as $col) {
                if ($col!=' NULL  FROM Participants '){
                ?><th><?php
                        echo $col;
                        $title_array[] = $col;
                        ?></th><?php
                //if primary organizer selected, show name
                if (($col == 'Participants.Primary_Organizer') && ($organizer_join != '')) {
                    ?><th>Primary_Organizer_Name<?php
                        $title_array[] = 'Primary_Organizer_Name';
                        ?></th><?php
                }
                //if institution_id selected, show name
                if (($col == 'Institutions_Participants.Institution_ID') && ($join_inst != '')) {
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
    $select_start = 'SELECT Properties.Property_ID, ';
    for ($j = 0; $j < count($_POST['columns']); $j++) {
        if ($j == (count($_POST['columns']) - 1)) {
            $select_start .= $_POST['columns'][$j];
        } else {
            $select_start .= $_POST['columns'][$j] . ", ";
        }
    }

    /* create query based on the search terms chosen by the user: */
    if ($_POST['vacant'] != 0) {
        if ($_POST['vacant'] == 1) {
            $vacant = " AND Property_Progress.Marker=8 AND Addtl_Info_1='Not vacant'";
        } else {
            $vacant = " AND Property_Progress.Marker=8 AND Addtl_Info_2='" . $_POST['vacant'] . "'";
        }
        $vacant_join = " 
INNER JOIN (
SELECT Property_ID, Marker, MAX(Date_Added) as latest_date
FROM Property_Progress WHERE Marker=8
GROUP BY Property_ID) vacant_progress
ON Property_Progress.Date_Added = vacant_progress.latest_date ";
    } else {
        $vacant = "";
        $vacant_join = "";
    }
    if ($_POST['condition'] != 0) {
        $condition = " AND Property_Progress.Marker=11 AND Addtl_Info_1='" . $_POST['condition'] . "' ";
        $condition_join = " 
INNER JOIN (
SELECT Property_ID, Marker, MAX(Date_Added) as latest_date
FROM Property_Progress WHERE Marker=11
GROUP BY Property_ID) condition_progress
ON Property_Progress.Date_Added = condition_progress.latest_date ";
    } else {
        $condition = "";
        $condition_join = "";
    }
    if ($_POST['for_sale'] != 0) {
        $for_sale = " AND Property_Progress.Marker=4 AND Addtl_Info_1='For Sale'";
        $sale_progress = " 
INNER JOIN (
SELECT Property_ID, Marker, MAX(Date_Added) as latest_date
FROM Property_Progress WHERE Marker=4
GROUP BY Property_ID) sale_progress
ON Property_Progress.Date_Added = sale_progress.latest_date ";
    } else {
        $for_sale = "";
        $sale_progress = "";
    }


    if ($_POST['price_low'] != '') {
        $price_range_low = " AND Property_Progress.Marker=4 AND Addtl_Info_2>='" . $_POST['price_low'] . "' ";
    } else {
        $price_range_low = "";
    }
    if ($_POST['price_high'] != '') {
        $price_range_high = " AND Property_Progress.Marker=4 AND Addtl_Info_2<='" . $_POST['price_high'] . "' ";
    } else {
        $price_range_high = "";
    }
    if ($_POST['type'] != 0) {
        $type = " AND Properties.Construction_Type='" . $_POST['type'] . "' ";
    } else {
        $type = "";
    }
    if ($_POST['size'] != 0) {
        $size = " AND Properties.Home_Size='" . $_POST['size'] . "' ";
    } else {
        $size = "";
    }
    if ($_POST['interest_start'] != 0) {
        $interest_date_start = " AND Property_Progress.Marker=7 AND Date_Added>= '" . $_POST['interest_start'] . "' ";
    } else {
        $interest_date_start = "";
    }
    if ($_POST['interest_end'] != 0) {
        $interest_date_end = " AND Property_Progress.Marker=7 AND Date_Added<='" . $_POST['interest_end'] . "' ";
    } else {
        $interest_date_end = "";
    }
    if ($_POST['interest_reason'] != 0) {
        $interest_reason = " AND Property_Progress.Marker=7 AND Addtl_Info_1='" . $_POST['interest_reason'] . "' ";
    } else {
        $interest_reason = "";
    }

    if ($_POST['acquisition_start'] != 0) {
        $acquisition_start = " AND Property_Progress.Marker=1 AND Date_Added>= '" . $_POST['acquisition_start'] . "' ";
    } else {
        $acquisition_start = "";
    }
    if ($_POST['acquisition_end'] != 0) {
        $acquisition_end = " AND Property_Progress.Marker=1 AND Date_Added<='" . $_POST['acquisition_end'] . "' ";
    } else {
        $acquisition_end = "";
    }
    if ($_POST['ac_cost_low'] != 0) {
        $ac_cost_low = " AND Property_Progress.Marker=1 AND Addtl_Info_1>='" . $_POST['ac_cost_low'] . "' ";
    } else {
        $ac_cost_low = "";
    }
    if ($_POST['ac_cost_high'] != 0) {
        $ac_cost_high = " AND Property_Progress.Marker=1 AND Addtl_Info_1<='" . $_POST['ac_cost_high'] . "' ";
    } else {
        $ac_cost_high = "";
    }
    if ($_POST['construction_start'] != 0) {
        $construction_start = " AND Property_Progress.Marker=2 AND Date_Added>= '" . $_POST['construction_start'] . "' ";
    } else {
        $construction_start = "";
    }
    if ($_POST['construction_end'] != 0) {
        $construction_end = " AND Property_Progress.Marker=2 AND Date_Added<= '" . $_POST['construction_end'] . "' ";
    } else {
        $construction_end = "";
    }
    if ($_POST['con_cost_low'] != 0) {
        $con_cost_low = " AND Property_Progress.Marker=2 AND Addtl_Info_1>='" . $_POST['con_cost_low'] . "' ";
    } else {
        $con_cost_low = "";
    }
    if ($_POST['con_cost_high'] != 0) {
        $con_cost_high = " AND Property_Progress.Marker=2 AND Addtl_Info_1<='" . $_POST['con_cost_high'] . "' ";
    } else {
        $con_cost_high = "";
    }
    if ($_POST['certificate_start'] != 0) {
        $cert_start = " AND Property_Progress.Marker=3 AND Date_Added>= '" . $_POST['certificate_start'] . "' ";
    } else {
        $cert_start = "";
    }
    if ($_POST['certificate_end'] != 0) {
        $cert_end = " AND Property_Progress.Marker=3 AND Date_Added<= '" . $_POST['certificate_end'] . "' ";
    } else {
        $cert_end = "";
    }
    if ($_POST['listed_start'] != 0) {
        $listed_start = " AND Property_Progress.Marker=4 AND Date_Added>= '" . $_POST['listed_start'] . "' ";
    } else {
        $listed_start = "";
    }
    if ($_POST['listed_end'] != 0) {
        $listed_end = " AND Property_Progress.Marker=4 AND Date_Added>= '" . $_POST['listed_end'] . "' ";
    } else {
        $listed_end = "";
    }
    if ($_POST['contracts_low'] != 0) {
        $contracts_low = " AND Property_Progress.Marker=4 AND Addtl_Info_1>='" . $_POST['contracts_low'] . "' ";
    } else {
        $contracts_low = "";
    }
    if ($_POST['contracts_high'] != 0) {
        $contracts_high = " AND Property_Progress.Marker=4 AND Addtl_Info_1<='" . $_POST['contracts_high'] . "' ";
    } else {
        $contracts_high = "";
    }

    if ($_POST['date_sold_start'] != 0) {
        $sold_start = " AND Property_Progress.Marker=5 AND Date_Added>= '" . $_POST['date_sold_start'] . "' ";
    } else {
        $sold_start = "";
    }
    if ($_POST['date_sold_end'] != 0) {
        $sold_end = " AND Property_Progress.Marker=5 AND Date_Added<='" . $_POST['date_sold_end'] . "' ";
    } else {
        $sold_end = "";
    }
    if ($_POST['sale_price_low'] != 0) {
        $sale_price_low = " AND Property_Progress.Marker=5 AND Addtl_Info_1>='" . $_POST['sale_price_low'] . "' ";
    } else {
        $sale_price_low = "";
    }
    if ($_POST['sale_price_high'] != 0) {
        $sale_price_high = " AND Property_Progress.Marker=5 AND Addtl_Info_1<='" . $_POST['sale_price_high'] . "' ";
    } else {
        $sale_price_high = "";
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
        $subsidy_low = " AND Property_Progress.Marker=5 AND Addtl_Info_4>='" . $_POST['subsidy_low'] . "' ";
    } else {
        $subsidy_low = "";
    }
    if ($_POST['subsidy_high'] != 0) {
        $subsidy_high = " AND Property_Progress.Marker=5 AND Addtl_Info_4<='" . $_POST['subsidy_high'] . "' ";
    } else {
        $subsidy_high = "";
    }

    if ($_POST['possession_start'] != 0) {
        $possession_start = " AND Property_Progress.Marker=6 AND Date_Added>= '" . $_POST['possession_start'] . "' ";
    } else {
        $possession_start = "";
    }
    if ($_POST['possession_end'] != 0) {
        $possession_end = " AND Property_Progress.Marker=6 AND Date_Added<='" . $_POST['possession_end'] . "' ";
    } else {
        $possession_end = "";
    }
    
    //if 
    //echo $_POST['table_institutions_participants'] . "***************";
    if ($_POST['table_institutions_participants'] != '') {
        if ($join_inst == '') {
            $join_inst = " INNER JOIN Institutions_Participants ON Participants.Participant_ID = Institutions_Participants.Participant_ID ";
        }
    }

    /* create final query from the columns, extra table joins, and all the specifications from the user: */
    $search_properties = $select_start . " FROM Properties INNER JOIN 
            Property_Progress ON Properties.Property_ID=Property_Progress.Property_ID "
            . $vacant_join . $condition_join . $sale_progress .
            " WHERE Properties.Property_ID IS NOT NULL " . $type . $size .
            $interest_date_start . $interest_date_end . $interest_reason . $vacant . $for_sale . $price_range_high . $price_range_low . $condition .
            $acquisition_start . $acquisition_end . $ac_cost_low . $ac_cost_high . $construction_start . $construction_end . $con_cost_low . $con_cost_high . $cert_start .
            $cert_end . $listed_start . $list_end . $contracts_low . $contracts_high . $sold_start . $sold_end . $sale_price_low . $sale_price_high .
            $subsidy_low . $subsidy_high . $possession_start . $possession_end . " GROUP BY Properties.Property_ID";

   // echo $search_properties;

    include "../include/dbconnopen.php";
    $search_results = mysqli_query($cnnSWOP, $search_properties);

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