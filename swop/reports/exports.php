<?php
include "../../header.php";
include "../header.php";
include "reports_menu.php";
//include ($_SERVER['DOCUMENT_ROOT']."/include/block_group_finder.php");
?>

<!-- export information from the database.  Will change once Taryn gets back to me with the compound exports she needs: -->

<h2>Export All</h2>

<table class="all_projects">
    <tr>
        <td>
            <h4>Export Everything </h4>
            <table class="inner_table">
                <tr><th>Deidentified</th><th>With identification</th></tr>
                <tr><td>         
                        <?php
                        $infile = "export_holder/deid_db_campaigns.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Campaign Id", "Campaign Name");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT * FROM Campaigns";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Campaigns
                        <a href="<?php echo $infile ?>">Download the CSV file of all campaigns.</a><br>
                        <br>
                    </td>
                    <td><a href="<?php echo $infile ?>">Download.</a><br></td></tr>

                <tr><td>         
                        <?php
                        $infile = "export_holder/deid_db_campaign_events.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Event Id", "Event Name", "Event Date", "Campaign ID", "Subcampaign", "Location", "Campaign Name");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Campaigns_Events.*, Campaigns.Campaign_Name FROM Campaigns_Events INNER JOIN Campaigns ON Campaigns_Events.Campaign_ID=Campaigns.Campaign_ID";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Campaign Events
                        <a href="<?php echo $infile ?>">Download the CSV file of all events (includes locations - is that a problem?).</a><br>
                        <br>
                    </td>
                    <td>
                        <a href="<?php echo $infile ?>">Download.</a>  
                    </td></tr>

                <tr><td>         
                        <?php
                        $infile = "export_holder/db_campaigns_insts.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Campaign/Institution Id", "Institution ID", "Campaign ID", "Campaign Name", "Institution Name");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Campaigns_Institutions.*, Campaign_Name, Institution_Name
                                        FROM
                                            Campaigns_Institutions
                                        INNER JOIN Campaigns ON Campaigns_Institutions.Campaign_Id = Campaigns.Campaign_ID
                                        INNER JOIN Institutions ON Campaigns_Institutions.Institution_Id = Institutions.Institution_ID";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Campaign-Institution Relationships
                        <a href="<?php echo $infile ?>">Download the CSV file of all campaign-institution relationships.</a><br>
                        <br>
                    </td>
                    <td><a href="<?php echo $infile ?>">Download.</a></td></tr>

                <tr><td>Impossible to deidentify household names.</td><td>         
                        <?php
                        $infile = "export_holder/db_households.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Household Id", "Household Name");
                        fputcsv($fp, $title_array);
                        $get_houses = "SELECT * FROM Households";
                        include "../include/dbconnopen.php";
                        $house_info = mysqli_query($cnnSWOP, $get_houses);
                        while ($house_array = mysqli_fetch_row($house_info)) {
                            fputcsv($fp, $house_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Households
                        <a href="<?php echo $infile ?>">Download the CSV file of all households.</a><br>
                        <br>
                    </td></tr>

                <tr><td>         
                        <?php
                        $infile = "export_holder/deid_db_households_people.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Link Id", "Household ID", "Participant ID", "Head of Household (1=Y, 2=No)");
                        fputcsv($fp, $title_array);
                        $get_houses = "SELECT * FROM Households_Participants";
                        include "../include/dbconnopen.php";
                        $house_info = mysqli_query($cnnSWOP, $get_houses);
                        while ($house_array = mysqli_fetch_row($house_info)) {
                            fputcsv($fp, $house_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Household/Participant Relationships (deidentified -- for a file with names, see the right hand column)
                        <a href="<?php echo $infile ?>">Download the CSV file of all links between people and households.</a><br>
                        <br>
                    </td>
                    <td>         
                        <?php
                        $infile = "export_holder/formatted_households.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Household Name", "First Name", "Last Name");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Household_Name, Name_First, Name_Last FROM Households INNER JOIN Households_Participants 
                                        ON New_Household_ID=Household_ID
                                        INNER JOIN Participants ON
                                        Households_Participants.Participant_ID=Participants.Participant_ID;";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        Participants by Household
                        <a href="<?php echo $infile ?>">Download the CSV file of households, formatted with their members.</a><br>
                        <br>
                    </td>
                </tr>

                <tr><td>         
                        <?php
                        $infile = "export_holder/deid_db_institutions.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Institution Id", "Institution Name", "Block Group", "Institution Type",
                            "Contact Person (Database ID)", "Date Added");
                        fputcsv($fp, $title_array);
                        $get_insts = "SELECT Institution_ID, Institution_Name, Block_Group, Type_Name,
                                    Contact_Person, Date_Added
                                    FROM
                                        Institutions
                                    LEFT JOIN Institution_Types ON Institution_Type = Type_ID";
                        //echo $get_insts;
                        include "../include/dbconnopen.php";
                        $inst_info = mysqli_query($cnnSWOP, $get_insts);
                        while ($inst_array = mysqli_fetch_row($inst_info)) {
                            /* $this_address= $inst_array[2] ." ". $inst_array[3] . " " . $inst_array[4] . " " . $inst_array[5];
                              $block_group=do_it_all($this_address, $map);
                              $output_array=array($inst_array[0], $inst_array[1], $block_group, $inst_array[10], $inst_array[7],  $inst_array[8], $inst_array[9]); */
                            fputcsv($fp, $inst_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Institutions
                        <a href="<?php echo $infile ?>">Download the CSV file of all institutions.</a><br>
                        <br>
                    </td>
                    <td>         
                        <?php
                        $infile = "export_holder/institutions.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Institution Id", "Institution Name", "Street Number", "Street Direction", "Street Name", "Street Type", "Block Group", "Institution Type",
                            "Phone", "Contact Person (Database ID)", "Date Added", "Institution Type Name", "Contact Person (First Name)", "Contact Person (Last Name)");
                        fputcsv($fp, $title_array);
                        $get_insts = "SELECT Institutions.*, (Institution_Types.Type_Name) AS Institution_Type_Name, Name_First, Name_Last
                                    FROM
                                        Institutions
                                    LEFT JOIN Participants ON Contact_Person = Participant_ID
                                    LEFT JOIN Institution_Types ON Institution_Types.Type_ID = Institutions.Institution_Type";
                        include "../include/dbconnopen.php";
                        $inst_info = mysqli_query($cnnSWOP, $get_insts);
                        while ($inst_array = mysqli_fetch_row($inst_info)) {
                            fputcsv($fp, $inst_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Institutions with point person details.
                        <a href="<?php echo $infile ?>">Download the CSV file of all institutions.</a><br>
                        <br>
                    </td>
                </tr>

                <tr><td>         
                        <?php
                        $infile = "export_holder/deid_db_people_insts.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Link ID", "Institution ID", "Participant ID", "Is Primary? (1=Yes, 0=No)",
                            "Individual Connection (Participant ID)", "Connection Reason", "Date Added", "Activity Type");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT * FROM Institutions_Participants";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Institution/Participant Relationships (this is all ID-based.  To see names, look at the right column)
                        <a href="<?php echo $infile ?>">Download the CSV file of all institutions/participants.</a><br>
                        <br>
                    </td>
                    <td>
                        <?php
                        $infile = "export_holder/db_people_insts.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Link ID", "Institution ID", "Institution Name", "Connected Participant ID",
                            "Connected Person First Name", "Connected Person Last Name", "Is Primary? (1=Yes, 0=No)", "Individual Connection (Participant ID)",
                            "Individual Connection First Name", "Individual Connection Last Name",
                            "Connection Reason");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Institutions_Participants_ID, Institutions.Institution_ID, Institutions.Institution_Name,
    person.Participant_ID, person.Name_First, person.Name_Last,
    Is_Primary, connection.Participant_ID, connection.Name_First, connection.Name_Last, Connection_Reason
    FROM Institutions_Participants
    INNER JOIN Institutions ON Institutions.Institution_ID=Institutions_Participants.Institution_ID
    INNER JOIN Participants AS person ON person.Participant_ID=Institutions_Participants.Participant_ID
    LEFT JOIN Participants AS connection ON connection.Participant_ID=Individual_Connection";
//echo $get_peoples;
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Institution/Participant Relationships
                        <a href="<?php echo $infile ?>">Download the CSV file of all institutions/participants.</a><br>
                        <br>
                    </td>
                </tr>

                <tr><td>         
                        <?php
                        //breaking my rule on this one, but it hardly made sense to split up these two tables.  There is no situation in which they'd want one without the
                        //other, I don't think.
                        $infile = "export_holder/deid_db_people_leader_details.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Leadership Development ID", "Participant ID", "Date", "Leadership Detail Achieved");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Leadership_Development_ID, Participant_ID, Date, Leadership_Detail_Name
                        FROM Leadership_Development
                        INNER JOIN Leadership_Development_Details
                        ON Detail_ID= Leadership_Development_Detail_ID;";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Detailed Leadership Development Steps
                        <a href="<?php echo $infile ?>">Download the CSV file of the detailed leadership development of all participants.</a><br>
                        <br>
                    </td>
                    <td>         
                        <?php
                        //breaking my rule on this one, but it hardly made sense to split up these two tables.  There is no situation in which they'd want one without the
                        //other, I don't think.
                        $infile = "export_holder/db_people_leader_details.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Leadership Development ID", "Participant ID", "First Name", "Last Name", "Date", "Leadership Detail Achieved");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Leadership_Development_ID, Leadership_Development.Participant_ID, Name_First, Name_Last, Date, Leadership_Detail_Name
                        FROM Leadership_Development
                        INNER JOIN Leadership_Development_Details
                        ON Detail_ID= Leadership_Development_Detail_ID
                        INNER JOIN Participants ON Leadership_Development.Participant_ID=Participants.Participant_ID;";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Detailed Leadership Development Steps
                        <a href="<?php echo $infile ?>">Download the CSV file of the detailed leadership development of all participants.</a><br>
                        <br>
                    </td>
                </tr>

                <tr><td>
                        <?php
                        $infile = "export_holder/deid_db_people.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Participant ID", "Education_Level", " Gender", "Speaks English? (1=Yes 0=No)", "Speaks Spanish? (1=Yes 0=No)",
                            "Speaks Other? (1=Yes 0=No)", "Ward", "Other_Lang_Specify",
                            "Primary_Organizer ID", " First_Interaction_Date", "ITIN Yes/No", "Date_Added", "Property ID", "Block Group");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Participants.Participant_ID, Education_Level, Gender, Lang_Eng, Lang_Span, Lang_Other, 
    Ward, Other_Lang_Specify, Primary_Organizer, First_Interaction_Date, ITIN, Date_Added, Properties.Property_ID,
   Properties.Block_Group
    
        FROM Participants LEFT JOIN Participants_Properties ON (Participants.Participant_ID=
        Participants_Properties.Participant_ID AND Primary_Residence=1)
        LEFT JOIN Properties ON Properties.Property_Id=Participants_Properties.Property_ID
            GROUP BY Participants.Participant_ID ORDER BY Name_Last;";
//echo $get_peoples;
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            /* $this_address= $people_array[13] ." ". $people_array[14] . " " . $people_array[15] . " " . $people_array[16];
                              //echo $this_address;
                              $block_group=do_it_all($this_address, $map);
                              // echo $block_group . "<br>";
                              $test_splicing=array_splice($people_array, -4);
                              //print_r($test_splicing);
                              array_push($people_array, $block_group); */
                            fputcsv($fp, $people_array);
                            // fputcsv($fp, $test_splicing);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Participants
                        <a href="<?php echo $infile ?>">Download the CSV file of all participants, without their names.</a><br>
                        <br>    
                    </td><td>         
                        <?php
                        $infile = "export_holder/db_people.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Participant ID", "First Name", "Last Name", "Phone - Home", "Phone - Cell", "Education Level", "Email", "Gender",
                            "Date of Birth", "Speaks English? (1=Yes 0=No)", "Speaks Spanish? (1=Yes 0=No)", "Speaks Other? (1=Yes 0=No)", "Ward",
                            "Other Language Spoken", "Notes", "Primary Organizer ID", "First Interaction Date", "ITIN yes/no", "Date Added", "Primary Organizer First Name",
                            "Primary Organizer Last Name", "Property ID", "Street Number", "Street Direction", "Street Name",
                            "Street Type");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Participants.Participant_ID, Participants.Name_First, 
    Participants.Name_Last, Participants.Phone_Day, Participants.Phone_Evening, Participants.Education_Level, Participants.Email, Participants.Gender, Participants.Date_of_Birth,
    Participants.Lang_Eng, Participants.Lang_Span, Participants.Lang_Other, 
    Participants.Ward, Participants.Other_Lang_Specify, Participants.Notes, Participants.Primary_Organizer, Participants.First_Interaction_Date, Participants.ITIN, 
    Participants.Date_Added, organizer.Name_First, organizer.Name_Last, 
    Properties.Property_ID, Properties.Address_Street_Num, Properties.Address_Street_Direction, Properties.Address_Street_Name, Properties.Address_Street_Type
    FROM Participants
    LEFT JOIN Participants AS organizer ON Participants.Primary_Organizer=organizer.Participant_ID
    LEFT JOIN Participants_Properties ON (Participants.Participant_ID=
        Participants_Properties.Participant_ID AND Primary_Residence=1)
        LEFT JOIN Properties ON Properties.Property_Id=Participants_Properties.Property_ID
            GROUP BY Participants.Participant_ID ORDER BY Participants.Name_Last;";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Participants
                        <a href="<?php echo $infile ?>">Download the CSV file of all participants, period.</a><br>
                        <br>
                    </td></tr>

                
                
                
                
                
                
                
                
                
                <tr><td>
                        <?php
                        $infile = "export_holder/deid_all_pool_status_changes.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        
                        
                        $title_array = array("Pool Status Change ID", "Active", "Participant ID", "Date Changed",
                                    "Activity Type", "Member Type", "Expected Date");
                        fputcsv($fp, $title_array);
                        $get_pool_status_changes = "SELECT Pool_Status_Changes.Pool_Status_Change_ID,
                                                        Reports__Active.Value AS Active,
                                                        Pool_Status_Changes.Participant_ID,
                                                        Pool_Status_Changes.Date_Changed,
                                                        Reports__Activity_Type.Value AS Activity_Type,
                                                        Pool_Member_Types.Type_Name AS Member_Type,
                                                        Pool_Status_Changes.Expected_Date
                                        FROM
                                                Pool_Status_Changes
                                        LEFT JOIN Participants ON Pool_Status_Changes.Participant_ID = Participants.Participant_ID
                                        LEFT JOIN Reports__Activity_Type ON Pool_Status_Changes.Activity_Type = Reports__Activity_Type.ID
                                        LEFT JOIN Pool_Member_Types ON Pool_Status_Changes.Member_Type = Pool_Member_Types.Type_ID
                                        LEFT JOIN Reports__Active ON Pool_Status_Changes.Active = Reports__Active.ID";
                        //echo $get_peoples;
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_pool_status_changes);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            /* $this_address= $people_array[13] ." ". $people_array[14] . " " . $people_array[15] . " " . $people_array[16];
                              //echo $this_address;
                              $block_group=do_it_all($this_address, $map);
                              // echo $block_group . "<br>";
                              $test_splicing=array_splice($people_array, -4);
                              //print_r($test_splicing);
                              array_push($people_array, $block_group); */
                            fputcsv($fp, $people_array);
                            // fputcsv($fp, $test_splicing);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Participant Pool Status Changes
                        <a href="<?php echo $infile ?>">Download the CSV file of all participant pool status changes, without names.</a><br>
                        <br>    
                    </td><td>         
                        <?php
                        $infile = "export_holder/all_pool_status_changes.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Pool Status Change ID", "Active", "Participant ID", "First Name",
                                    "Last Name", "Date Changed", "Activity Type", "Member Type", "Expected Date");
                        fputcsv($fp, $title_array);
                        $get_pool_status_changes = "SELECT Pool_Status_Changes.Pool_Status_Change_ID,
                                                        Reports__Active.Value AS Active,
                                                        Pool_Status_Changes.Participant_ID,
                                                        Participants.Name_First,
                                                        Participants.Name_Last,
                                                        Pool_Status_Changes.Date_Changed,
                                                        Reports__Activity_Type.Value AS Activity_Type,
                                                        Pool_Member_Types.Type_Name AS Member_Type,
                                                        Pool_Status_Changes.Expected_Date
                                        FROM
                                                Pool_Status_Changes
                                        LEFT JOIN Participants ON Pool_Status_Changes.Participant_ID = Participants.Participant_ID
                                        LEFT JOIN Reports__Activity_Type ON Pool_Status_Changes.Activity_Type = Reports__Activity_Type.ID
                                        LEFT JOIN Pool_Member_Types ON Pool_Status_Changes.Member_Type = Pool_Member_Types.Type_ID
                                        LEFT JOIN Reports__Active ON Pool_Status_Changes.Active = Reports__Active.ID";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_pool_status_changes);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Participant Pool Status Changes
                        <a href="<?php echo $infile ?>">Download the CSV file of all participant pool status changes.</a><br>
                        <br>
                    </td></tr>
                
                
                
                
                
                
                
                
                
                
                
                
                <tr><td>
                        <?php
                        $infile = "export_holder/deid_all_movement_through_pool.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        
                        $title_array = array("Pool Progress ID", "Participant ID", "Benchmark Name",
                                    "Benchmark Info", "Date Completed", "Activity Type", "Expected Date",
                                    "More Info");
                        fputcsv($fp, $title_array);
                        $get_pool_movement = "SELECT Pool_Progress.Pool_Progress_ID,
                                                            Pool_Progress.Participant_ID,
                                                            Pool_Benchmarks.Benchmark_Name,
                                                            Pool_Benchmarks.Benchmark_Info,
                                                            Pool_Progress.Date_Completed,
                                                            Reports__Activity_Type.Value AS Activity_Type,
                                                            Pool_Progress.Expected_Date,
                                                            Pool_Progress.More_Info
                                            FROM
                                                    Pool_Progress
                                            LEFT JOIN Participants ON Pool_Progress.Participant_ID = Participants.Participant_ID
                                            LEFT JOIN Participants AS Participants_More_Info ON Pool_Progress.More_Info = Participants_More_Info.Participant_ID
                                            LEFT JOIN Reports__Activity_Type ON Pool_Progress.Activity_Type = Reports__Activity_Type.ID
                                            LEFT JOIN Pool_Benchmarks ON Pool_Progress.Benchmark_Completed = Pool_Benchmarks.Pool_Benchmark_ID";
                        //echo $get_peoples;
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_pool_movement);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            /* $this_address= $people_array[13] ." ". $people_array[14] . " " . $people_array[15] . " " . $people_array[16];
                              //echo $this_address;
                              $block_group=do_it_all($this_address, $map);
                              // echo $block_group . "<br>";
                              $test_splicing=array_splice($people_array, -4);
                              //print_r($test_splicing);
                              array_push($people_array, $block_group); */
                            fputcsv($fp, $people_array);
                            // fputcsv($fp, $test_splicing);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Participant Pool Movement / Benchmarks
                        <a href="<?php echo $infile ?>">Download the CSV file of all participant pool movement / benchmarks, without names.</a><br>
                        <br>    
                    </td><td>         
                        <?php
                        $infile = "export_holder/all_movement_through_pool.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Pool Progress ID", "Participant ID", "First Name", "Last Name",
                                    "Benchmark Name", "Benchmark Info", "Date Completed", "Activity Type",
                                    "Expected Date", "More Info");
                        fputcsv($fp, $title_array);
                        $get_pool_movement = "SELECT Pool_Progress.Pool_Progress_ID,
                                                            Pool_Progress.Participant_ID,
                                                            Participants.Name_First,
                                                            Participants.Name_Last,
                                                            Pool_Benchmarks.Benchmark_Name,
                                                            Pool_Benchmarks.Benchmark_Info,
                                                            Pool_Progress.Date_Completed,
                                                            Reports__Activity_Type.Value AS Activity_Type,
                                                            Pool_Progress.Expected_Date,
                                                            CONCAT(Participants_More_Info.Name_First, ' ', Participants_More_Info.Name_Last) AS More_Info
                                            FROM
                                                    Pool_Progress
                                            LEFT JOIN Participants ON Pool_Progress.Participant_ID = Participants.Participant_ID
                                            LEFT JOIN Participants AS Participants_More_Info ON Pool_Progress.More_Info = Participants_More_Info.Participant_ID
                                            LEFT JOIN Reports__Activity_Type ON Pool_Progress.Activity_Type = Reports__Activity_Type.ID
                                            LEFT JOIN Pool_Benchmarks ON Pool_Progress.Benchmark_Completed = Pool_Benchmarks.Pool_Benchmark_ID";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_pool_movement);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Participant Pool Movement / Benchmarks
                        <a href="<?php echo $infile ?>">Download the CSV file of all participant pool movement / benchmarks.</a><br>
                        <br>
                    </td></tr>
                
                
                
                
                
                
                
                
                <tr><td>         
                        <?php
                        $infile = "export_holder/deid_db_people_events.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Link ID", "Event ID", "Participant ID",
                                "Role Type (1=Attendee; 2=Speaker; 3=Chairperson; 4=Prep work; 5=Staff)", "Exceptional");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT * FROM Participants_Events";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Event Attendance
                        <a href="<?php echo $infile ?>">Download the CSV file of all event attendance.</a><br>
                        <br>
                    </td>
                    <td>         
                        <?php
                        $infile = "export_holder/db_people_events.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Link ID", "Event ID", "Participant ID", "Role Type (1=Attendee; 2=Speaker; 3=Chairperson; 4=Prep work; 5=Staff)",
                            "Attendee First Name", "Attendee Last Name");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Participants_Events.*, Name_First, Name_Last
                                        FROM
                                            Participants_Events
                                        INNER JOIN Participants ON Participants_Events.Participant_ID = Participants.Participant_ID";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Event Attendance
                        <a href="<?php echo $infile ?>">Download the CSV file of all event attendance.</a><br>
                        <br>
                    </td>
                </tr>

                <tr><td>         
                        <?php
                        $infile = "export_holder/deid_db_people_leaders.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Link ID", "Participant ID", "Leader Type", "Date Logged", "Activity Type");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT * FROM Participants_Leaders";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Leader Classifications
                        <a href="<?php echo $infile ?>">Download the CSV file of all primary, secondary, and tertiary leaders.</a>
                        <br>
                        <br>
                    </td>
                    <td>         
                        <?php
                        $infile = "export_holder/db_people_leaders.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Link ID", "Participant ID", "Leader Type", "Date Logged", "Activity Type", "First Name", "Last Name");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Participants_Leaders.*, Name_First, Name_Last FROM Participants_Leaders INNER JOIN Participants ON Participants_Leaders.Participant_Id=Participants.Participant_ID";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Leader Classifications
                        <a href="<?php echo $infile ?>">Download the CSV file of all primary, secondary, and tertiary leaders.</a>
                        <br>
                        <br>
                    </td>
                </tr>

                <tr><td>         
                        <?php
                        //again, bending the idea, but they'll want to know the pool member types.  I'm not sure we're using date entered and exited
                        //anymore, given the activity table
                        $infile = "export_holder/deid_db_people_pool.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Pool ID", "Participant ID", "Date Logged", "Pool Member Type", "Block Group");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Participant_Pool_ID, Participants_Pool.Participant_ID, Date_Logged, Type_Name, 
                        Properties.Block_Group
                        FROM Participants_Pool LEFT JOIN Pool_Member_Types ON Type=Type_ID
                        LEFT JOIN Participants_Properties ON (Participants_Pool.Participant_ID=
                        Participants_Properties.Participant_ID AND Primary_Residence=1)
                        LEFT JOIN Properties ON Properties.Property_Id=Participants_Properties.Property_ID
                        GROUP BY Participants_Pool.Participant_ID;";
                        //echo $get_peoples;
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            /* $this_address= $people_array[4] ." ". $people_array[5] . " " . $people_array[6] . " " . $people_array[7];
                              $block_group=do_it_all($this_address, $map);
                              array_splice($people_array, -4);
                              array_push($people_array, $block_group); */
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Pool Members<br>
                        <a href="<?php echo $infile ?>">Download the CSV file of all pool members, with type.</a><br>
                        <br>
                    </td>
                    <td>
                        <?php
                        //again, bending the idea, but they'll want to know the pool member types.  I'm not sure we're using date entered and exited
                        //anymore, given the activity table
                        $infile = "export_holder/db_people_pool.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Pool ID", "Participant ID", "Date Logged", "Pool Member Type", "Date Logged", "Type Name");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Participant_Pool_ID, Participants_Pool.Participant_ID, Name_First, Name_Last, Date_Logged, Type_Name
                        FROM Participants_Pool INNER JOIN Pool_Member_Types
                        ON Type=Type_ID
                        INNER JOIN Participants ON Participants_Pool.Participant_Id=Participants.Participant_ID;";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Pool Members
                        <a href="<?php echo $infile ?>">Download the CSV file of all pool members, with type.</a><br>
                        <br>
                    </td>
                </tr>

                <tr><td>         
                        <?php
                        $infile = "export_holder/deid_db_people_properties.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Link ID", "Participant ID", "Property ID", "Date Linked", "Unit Number", "Rent or Own", "Start Date",
                            "End Date", "Primary Residence", "Start as Primary", "End as Primary", "Reason Ended", "Block Group");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Participants_Properties.*,  Properties.Block_Group FROM Participants_Properties 
        LEFT JOIN Properties ON Properties.Property_Id=Participants_Properties.Property_ID";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            /*  $this_address= $people_array[12] ." ". $people_array[13] . " " . $people_array[14] . " " . $people_array[15];
                              $block_group=do_it_all($this_address, $map);
                              $test_splicing=array_splice($people_array, -4);
                              array_push($people_array, $block_group); */
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Participant-Property Relationships
                        <a href="<?php echo $infile ?>">Download the CSV file of all properties linked to a participant.</a><br>
                        <br>
                    </td>
                    <td>         
                        <?php
                        $infile = "export_holder/db_people_properties.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Link ID", "Participant ID", "Property ID", "Date Linked", "Unit Number", "Rent or Own", "Start Date",
                            "End Date", "Primary Residence", "Start as Primary", "End as Primary", "Reason Ended", "First Name", "Last Name",
                            "Address Number", "Address Direction", "Address Street", "Address STreet Type");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Participants_Properties.*, Name_First, Name_Last, Properties.Address_Street_Num, Properties.Address_Street_Direction,
    Properties.Address_Street_Name, Properties.Address_Street_Type FROM Participants_Properties 
    INNER JOIN Participants on Participants_Properties.Participant_Id=Participants.PARTICIPANT_ID
    INNER JOIN Properties on Properties.Property_Id=Participants_Properties.Property_ID";
//echo $get_peoples;
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Participant-Property Relationships
                        <a href="<?php echo $infile ?>">Download the CSV file of all properties linked to a participant.</a><br>
                        <br>
                    </td></tr>

                <tr><td>         
                        <?php
                        $infile = "export_holder/deid_db_pool_employment.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Link ID", "Participant ID", "Employer Name", "Work Time", "Date Logged");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT * FROM Pool_Employers";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Pool Member Employment
                        <a href="<?php echo $infile ?>">Download the CSV file of all pool members' employment.</a><br>
                        <br>
                    </td>
                    <td>         
                        <?php
                        $infile = "export_holder/db_pool_employment.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("First Name", "Last Name", "Link ID (Pool Employer ID)",
                                    "Participant ID", "Employer Name", "Work Time", "Date Logged");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Name_First, Name_Last, Pool_Employers.*
                                        FROM
                                            Pool_Employers
                                        INNER JOIN Participants ON Participants.Participant_ID = Pool_Employers.Participant_ID";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Pool Member Employment
                        <a href="<?php echo $infile ?>">Download the CSV file of all pool members' employment.</a><br>
                        <br>
                    </td>
                </tr>

                <tr><td>         
                        <?php
                        $infile = "export_holder/deid_db_people_finances.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Finance ID", "Participant ID", "Credit Score", "Income", "Current Housing (add meaning here)",
                            "Household Location (1=In TTM Area; 2=Outside TTM but in SWOP; 3=Outside TTM and SWOP; 4=N/A)", "Housing Cost", "Employment", "Assets",
                            "Date Logged");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT * FROM Pool_Finances";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Pool Member Finances
                        <a href="<?php echo $infile ?>">Download the CSV file of all pool member finances.</a><br>
                        <br>
                    </td>
                    <td>         
                        <?php
                        $infile = "export_holder/db_people_finances.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Finance ID", "Participant ID", "Credit Score", "Income", "Current Housing (add meaning here)",
                            "Household Location (1=In TTM Area; 2=Outside TTM but in SWOP; 3=Outside TTM and SWOP; 4=N/A)", "Housing Cost", "Employment", "Assets",
                            "Date Logged", "First Name", "Last Name");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Pool_Finances.*, Name_First, Name_Last FROM Pool_Finances
    INNER JOIN Participants ON Participants.Participant_ID=Pool_Finances.Participant_ID";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Pool Member Finances
                        <a href="<?php echo $infile ?>">Download the CSV file of all pool member finances.</a><br>
                        <br>
                    </td>
                </tr>

                <tr><td>         
                        <?php
                        $infile = "export_holder/deid_db_people_outcomes.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Participant ID", "Outcome Name", "Date Exited", "Outcome Location");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Participant_ID, Outcome_Name, Date_Exited,  Outcome_Location_Name
FROM Pool_Outcomes INNER JOIN Outcomes_for_Pool
ON Pool_Outcomes.Outcome_ID=Outcomes_for_Pool.Outcome_ID
INNER JOIN Outcome_Locations 
ON Outcome_Location=Outcome_Location_ID;";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Pool Member Outcomes
                        <a href="<?php echo $infile ?>">Download the CSV file of all pool member outcomes.</a><br>
                        <br>
                    </td>
                    <td>         
                        <?php
                        $infile = "export_holder/db_people_outcomes.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Participant ID", "First Name", "Last Name", "Outcome Name", "Date Exited", "Outcome Location");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Pool_Outcomes.Participant_ID, Name_First, Name_Last, Outcome_Name, Date_Exited, Outcome_Location_Name
FROM Pool_Outcomes 
INNER JOIN Outcomes_for_Pool ON Pool_Outcomes.Outcome_ID=Outcomes_for_Pool.Outcome_ID
INNER JOIN Outcome_Locations ON Outcome_Location=Outcome_Location_ID
INNER JOIN Participants ON Participants.Participant_Id=Pool_Outcomes.Participant_ID;";
//echo $get_peoples;
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Pool Member Outcomes
                        <a href="<?php echo $infile ?>">Download the CSV file of all pool member outcomes.</a><br>
                        <br>
                    </td>
                </tr>

                <tr><td>         
                        <?php
                        $infile = "export_holder/deid_db_people_progress.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Participant ID", "Date Completed", "Activity Type", "Benchmark Name");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Participant_ID, Date_Completed, Activity_Type,
Benchmark_Name FROM Pool_Progress INNER JOIN Pool_Benchmarks ON Benchmark_Completed=Pool_Benchmark_ID;";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Pool Member Progress
                        <a href="<?php echo $infile ?>">Download the CSV file of all pool member progress.</a><br>
                        <br>
                    </td>

                    <td>
                        <?php
                        $infile = "export_holder/progress_identified.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Month", "Day", "Year", "First Name", "Last Name", "Benchmark Completed", "Organizer First Name", "Organizer Last Name");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT MONTH(Pool_Progress.Date_Completed), DAY(Pool_Progress.Date_Completed), YEAR(Pool_Progress.Date_Completed),
Participants.Name_First, Participants.Name_Last, Pool_Benchmarks.Benchmark_Name,
organizer.Name_First, organizer.Name_Last
FROM Pool_Progress INNER JOIN Participants ON Pool_Progress.Participant_ID=Participants.Participant_ID
INNER JOIN Pool_Benchmarks ON Pool_Benchmark_ID=Benchmark_Completed
INNER JOIN Participants AS organizer ON Participants.Primary_Organizer=organizer.Participant_ID;";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        Participant Progress (for pool members, with primary organizers)
                        <a href="<?php echo $infile ?>">Download the CSV file of people progressing through various pool pipelines, shown with their primary organizer.</a><br>
                        <br>


                    </td>
                </tr>

                <tr><td>         
                        <?php
                        $infile = "export_holder/deid_db_pool_status.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Change ID", "1=Active; 0=Inactive", "Participant ID",
                                "Date Changed", "Activity Type", "Member Type", "Expected Date");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT * FROM Pool_Status_Changes;";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Pool Status Active/Inactive
                        <a href="<?php echo $infile ?>">Download the CSV file of all pool status changes.</a><br>
                        <br>
                    </td>
                    <td>         
                        <?php
                        $infile = "export_holder/db_pool_status.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Change ID", "1=Active; 0=Inactive", "Participant ID", "Date Changed", "Activity Type",
                                        "Member_Type", "Expected_Date", "Participant_ID", "Name_First", "Name_Middle", "Name_Last",
                                        "Address_Street_Name", "Address_Street_Num", "Address_Street_Direction", "Address_Street_Type",
                                        "Phone_Day", "Phone_Evening", "Education_Level", "Email", "Gender", "Date_of_Birth",
                                        "Lang_Eng", "Lang_Span", "Lang_Other", "Ward", "Other_Lang_Specify", "Notes", "Primary_Organizer",
                                        "First_Interaction_Date", "ITIN", "Date_Added", "Activity_Type");
                        
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT * FROM Pool_Status_Changes
                            INNER JOIN Participants ON Participants.Participant_Id = Pool_Status_Changes.Participant_ID;";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Pool Status Active/Inactive
                        <a href="<?php echo $infile ?>">Download the CSV file of all pool status changes.</a><br>
                        <br>
                    </td>
                </tr>

                <tr><td>
                        <?php
                        $infile = "export_holder/deid_db_properties.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Property ID", "Disposition ID", "Disposition Name", "Construction Type (4=Brick/Masonry; 5=Frame)",
                            "Home Size (1=Single-family; 2=2/3 flat; 3=Multi-unit)", "Date Entered", "Property Type (1=Residential; 2=Commercial; 3=Mixed-use)", "Block Group");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Property_ID,
    Disposition, Disposition_Name, Construction_Type, Home_Size, Date_Entered, Property_Type, Block_Group
    
    FROM Properties LEFT JOIN Property_Dispositions ON Disposition=Disposition_ID;";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            /* $this_address= $people_array[1] ." ". $people_array[2] . " " . $people_array[3] . " " . $people_array[4];
                              $block_group=do_it_all($this_address, $map);
                              $test_splicing=array_splice($people_array, -4);
                              array_push($people_array, $block_group); */
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Properties
                        <a href="<?php echo $infile ?>">Download the CSV file of all properties.</a><br>
                        <br>
                    </td>
                    <td>         
                        <?php
                        $infile = "export_holder/db_properties.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Property ID", "Street Number", "Street Direction", "Street Name", "Street Type", "PIN",
                            "Construction Type (4=Brick/Masonry; 5=Frame)",
                            "Home Size (1=Single-family; 2=2/3 flat; 3=Multi-unit)", "Date Entered", "Property Type  (1=Residential; 2=Commercial; 3=Mixed-use)",
                            "Disposition Name");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Property_ID, Address_Street_Num,  Address_Street_Direction, Address_Street_Name,
Address_Street_Type, PIN, Construction_Type, Home_Size, Date_Entered, Property_Type, Disposition_Name
FROM Properties LEFT JOIN Property_Dispositions ON Disposition=Disposition_ID;";

                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        All Properties
                        <a href="<?php echo $infile ?>">Download the CSV file of all properties.</a><br>
                        <br>
                    </td></tr>

<!--                   <tr><td>         
                <?php /* $infile="export_holder/db_property_markers.csv";
                  $fp=fopen($infile, "w") or die('can\'t open file');
                  $title_array = array("Marker ID", "Vacant?", "Secured?", "Unsecured?", "Open?",
                  "Code Violations?", "For Sale?", "List Price", "Owner Occupied?", "Absentee Landlord?", "Property Condition (add info)",
                  "Financial Institution", "Second Mortgage", "Owner", "Construction Type (4=Brick/Masonry; 5=Frame)", "Property ID",
                  "Date Logged", "Home Size (1=Single-family; 2=2/3 flat; 3=Multi-unit)");
                  fputcsv($fp, $title_array);
                  $get_peoples = "SELECT * FROM Property_Markers;";
                  include "../include/dbconnopen.php";
                  $people_info = mysqli_query($cnnSWOP, $get_peoples);
                  while ($people_array = mysqli_fetch_row($people_info)){
                  fputcsv ($fp, $people_array);
                  }
                  include "../include/dbconnclose.php";
                  fclose($fp);
                 */ ?>
<br>
All Property Markers Over Time
<a href="<?php echo $infile ?>">Download the CSV file of property markers.</a><br>
<br>
 </td></tr>-->

                <tr><td>         
                        <?php
                        $infile = "export_holder/deid_db_property_rehab.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Progress ID", "Date Added", "Marker ID", "Additional 1", "Additional 2", "Additional 3",
                            "Additional 4", "Property ID", "Notes", "Property Marker Name", "Block Group");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Property_Progress.*, Property_Marker_Name, Block_Group
    FROM Property_Progress
    LEFT JOIN Property_Marker_Names ON Marker=Property_Marker_Name_ID
    LEFT JOIN Properties ON Property_Progress.Property_Id=Properties.Property_ID;";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            /* $this_address= $people_array[10] ." ". $people_array[11] . " " . $people_array[12] . " " . $people_array[13];
                              $block_group=do_it_all($this_address, $map);
                              $test_splicing=array_splice($people_array, -4);
                              array_push($people_array, $block_group); */
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        Property Progress Over Time
                        <a href="<?php echo $infile ?>">Download the CSV file of property rehab progress.</a><br>
                        <br>
                    </td>
                    <td>         
                        <?php
                        $infile = "export_holder/db_property_rehab.csv";
                        $fp = fopen($infile, "w") or die('can\'t open file');
                        $title_array = array("Progress ID", "Date Added", "Marker ID", "Additional 1", "Additional 2", "Additional 3",
                            "Additional 4", "Property ID", "Notes", "Property Marker Name", "Street Number", "Street Direction", "Street Name",
                            "Street Type");
                        fputcsv($fp, $title_array);
                        $get_peoples = "SELECT Property_Progress.*, Property_Marker_Name, Properties.Address_Street_Num, Properties.Address_Street_Direction,
    Properties.Address_Street_Name, Properties.Address_Street_Type
FROM Property_Progress  LEFT JOIN Property_Marker_Names ON Marker=Property_Marker_Name_ID
INNER JOIN Properties ON Property_Progress.Property_ID=Properties.Property_ID;";
                        include "../include/dbconnopen.php";
                        $people_info = mysqli_query($cnnSWOP, $get_peoples);
                        while ($people_array = mysqli_fetch_row($people_info)) {
                            fputcsv($fp, $people_array);
                        }
                        include "../include/dbconnclose.php";
                        fclose($fp);
                        ?>
                        <br>
                        Property Progress Over Time
                        <a href="<?php echo $infile ?>">Download the CSV file of property rehab progress (with property address).</a><br>
                        <br>
                    </td></tr>

            </table>
        </td>

    </tr>
</table>
<br/>

<?php include "../../footer.php"; ?>