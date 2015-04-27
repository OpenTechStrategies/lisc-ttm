<?php

function find_db($subsite){
    // determine which db to use, connect to it
}

function find_duplicates($subsite) {
    // return sets of people that match on some specific parameter(s),
    // e.g. same last name.  Advanced options here may allow users to
    // choose the parameters to search on (phone number, address, dob)
    if ($subsite == 'lsna'){
        $name = 'Name_First';
        $surname = 'Name_Last';
    }
    else{
        $name = 'First_Name';
        $surname = 'Last_Name';
    }
    $duplicate_last_names_query_sqlsafe = "SELECT Participants.Participant_ID, Participants.$name, Participants.$surname, Joiners.Participant_ID, Joiners.$name, Joiners.$surname FROM Participants LEFT JOIN Participants AS Joiners ON Participants.$surname = Joiners.$surname WHERE Participants.Participant_ID != Joiners.Participant_ID ORDER BY Participants.Participant_ID;";
    $path =  $_SERVER['DOCUMENT_ROOT'] . "/$subsite/include/dbconnopen.php";
    include $path;
    $cnnvar = 'cnn' . ucfirst($subsite);

    $duplicate_last_names = mysqli_query($cnnEnlace, $duplicate_last_names_query_sqlsafe);
    print_r($duplicate_last_names); //testing output
    // only show the matched name once
    $matched_id = 0;
    ?>
    <table>
    <?php
    while ($duplicate = mysqli_fetch_row($duplicate_last_names)){
        print_r($duplicate); //testing output;
        ?>
        <tr>
        <?php
        if ($duplicate[0] != $matched_id){
            ?>
            <td><?php echo $duplicate[1] . " " . $duplicate[2]; ?> </td>
            <?php
            $matched_id = $duplicate[0];
        }
        ?>
        <td>
        <?php 
        echo $duplicate[3] . ": " . $duplicate[4] . " " . $duplicate[5];
        ?>
        </td>
        </tr>
        <?php
    }
    ?>
    </table>
    <?php
}

function find_individual_duplicates($person_id){
    // if one participant supplied, then return a much looser set of
    // matches for that specific person
    
    // takes participant id and returns all other people with same
    // first and/or last name, address, phone number, and date of
    // birth.  Very broad!
    $example_query = "SELECT Joiners.Participant_ID, Joiners.Name_First, Joiners.Name_Last FROM Participants LEFT JOIN Participants AS Joiners ON (Participants.Name_First = Joiners.Name_First OR Participants.Name_Last = Joiners.Name_Last OR Participants.Phone_Day = Joiners.Phone_Day OR Participants.Address_Street_Name = Joiners.Address_Street_Name OR Participants.Date_of_Birth = Joiners.Date_of_Birth) WHERE Participants.Participant_ID != Joiners.Participant_ID  AND (Participants.Participant_ID = " . $person_id . ") ORDER BY Participants.Participant_ID;";
    

}

function merge_people($person_one, $person_two, $subsite){
    // associate person_one with all person_two connections that don't
    // already exist for person_one
    // that is, conclude duplicate detection by merging duplicate
    // records
    
    // find the tables in this subsite with participant IDs -- i.e.,
    // that need to be updated as part of this merge
    $table_query = "SELECT DISTINCT TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE
    COLUMN_NAME IN ('Participant_ID') AND TABLE_SCHEMA = '" . $subsite . "';";
    
    // then update them
}

function ignore_result($person){
    // hide some row in the duplicate results
    
}



?>