<?php

/* changes to dropdowns throughout the system, as changed on the Alter System Dropdowns page. */

//alter the roles dropdown
if ($_POST['element'] == 'role') {
    if ($_POST['action'] == 'add') {
        $new_element = "INSERT INTO Participants_Roles (Role_Name) VALUES ('" . $_POST['variable'] . "')";
    } elseif ($_POST['action'] == 'delete') {
        $delete_element = "DELETE FROM Participants_Roles WHERE Role_ID=" . $_POST['variable'];
    } elseif ($_POST['action'] == 'edit') {
        $update_element = "UPDATE Participants_Roles SET Role_Name='" . $_POST['variable'] . "' WHERE Role_ID=" . $_POST['edited'];
    }
}
if ($_POST['element'] == 'leader') {
    /* change the leadership level options: */
    if ($_POST['action'] == 'add') {
        $new_element = "INSERT INTO Leadership_Levels (Leader_Level) VALUES ('" . $_POST['variable'] . "')";
    } elseif ($_POST['action'] == 'delete') {
        $delete_element = "DELETE FROM Leadership_Levels WHERE Leader_Level_ID=" . $_POST['variable'];
    } elseif ($_POST['action'] == 'edit') {
        $update_element = "UPDATE Leadership_Levels SET Leader_Level='" . $_POST['variable'] . "' WHERE Leader_Level_ID=" . $_POST['edited'];
    }
}
if ($_POST['element'] == 'pool_type') {
    /* change types of pool members: */
    if ($_POST['action'] == 'add') {
        $new_element = "INSERT INTO Pool_Member_Types (Type_Name, Pipeline) VALUES ('" . $_POST['variable'] . "', '" . $_POST['edited'] . "')";
    } elseif ($_POST['action'] == 'delete') {
        $delete_element = "DELETE FROM Pool_Member_Types WHERE Type_ID=" . $_POST['variable'];
    } elseif ($_POST['action'] == 'edit') {
        $update_element = "UPDATE Pool_Member_Types SET Type_Name='" . $_POST['variable'] . "', Pipeline='" . $_POST['more'] . "' 
            WHERE Type_ID=" . $_POST['edited'];
    }
}
if ($_POST['element'] == 'pool_benchmark') {
    /* change pool benchmark options: */
    if ($_POST['action'] == 'add') {
        $new_element = "INSERT INTO Pool_Benchmarks (Benchmark_Name, Pipeline_Type, Benchmark_Type) VALUES ('" . $_POST['variable'] . "', '" . $_POST['pipeline'] . "', '" . $_POST['benchmark_type'] . "')";
    } elseif ($_POST['action'] == 'delete') {
        $delete_element = "DELETE FROM Pool_Benchmarks WHERE Pool_Benchmark_ID=" . $_POST['variable'];
    } elseif ($_POST['action'] == 'edit') {
        $update_element = "UPDATE Pool_Benchmarks SET
                            Benchmark_Name='" . $_POST['variable'] . "',
                            Pipeline_Type='" . $_POST['pipeline'] . "',
                            Benchmark_Type='" . $_POST['benchmark_type'] . "'
            WHERE Pool_Benchmark_ID=" . $_POST['edited'];
    }
}
if ($_POST['element'] == 'outcome') {
    /* change pool outcomes. */
    if ($_POST['action'] == 'add') {
        $new_element = "INSERT INTO Outcomes_for_Pool (Outcome_Name) VALUES ('" . $_POST['variable'] . "')";
    } elseif ($_POST['action'] == 'delete') {
        $delete_element = "DELETE FROM Outcomes_for_Pool WHERE Outcome_ID=" . $_POST['variable'];
    } elseif ($_POST['action'] == 'edit') {
        $update_element = "UPDATE Outcomes_for_Pool SET Outcome_Name='" . $_POST['variable'] . "' WHERE Outcome_ID=" . $_POST['edited'];
    }
}
if ($_POST['element'] == 'location') {
    /* change locations for outcomes (and housing?) */
    if ($_POST['action'] == 'add') {
        $new_element = "INSERT INTO Outcome_Locations (Outcome_Location_Name) VALUES ('" . $_POST['variable'] . "')";
    } elseif ($_POST['action'] == 'delete') {
        $delete_element = "DELETE FROM Outcome_Locations WHERE Outcome_Location_ID=" . $_POST['variable'];
    } elseif ($_POST['action'] == 'edit') {
        $update_element = "UPDATE Outcome_Locations SET Outcome_Location_Name='" . $_POST['variable'] . "' WHERE Outcome_Location_ID=" . $_POST['edited'];
    }
}
if ($_POST['element'] == 'disposition') {
    /* change property disposition options: */
    if ($_POST['action'] == 'add') {
        $new_element = "INSERT INTO Property_Dispositions (Disposition_Name) VALUES ('" . $_POST['variable'] . "')";
    } elseif ($_POST['action'] == 'delete') {
        $delete_element = "DELETE FROM Property_Dispositions WHERE Disposition_ID=" . $_POST['variable'];
    } elseif ($_POST['action'] == 'edit') {
        $update_element = "UPDATE Property_Dispositions SET Disposition_Name='" . $_POST['variable'] . "' WHERE Disposition_ID=" . $_POST['edited'];
    }
}
if ($_POST['element'] == 'marker') {
    /* change property markers: */
    if ($_POST['action'] == 'add') {
        $new_element = "INSERT INTO Property_Marker_Names (Property_Marker_Name) VALUES ('" . $_POST['variable'] . "')";
    } elseif ($_POST['action'] == 'delete') {
        $delete_element = "DELETE FROM Property_Marker_Names WHERE Property_Marker_Name_ID=" . $_POST['variable'];
    } elseif ($_POST['action'] == 'edit') {
        $update_element = "UPDATE Property_Marker_Names SET Property_Marker_Name='" . $_POST['variable'] . "' WHERE 
            Property_Marker_Name_ID=" . $_POST['edited'];
    }
}
if ($_POST['element'] == 'event_location') {
    /* change event location list (add a new one by adding it to an event) */
    if ($_POST['action'] == 'delete') {
        $delete_element = "UPDATE Campaigns_Events SET Location='' WHERE Location='" . $_POST['variable'] . "'";
    } elseif ($_POST['action'] == 'edit') {
        $update_element = "UPDATE Campaigns_Events SET Location='" . $_POST['new_location'] . "' WHERE Location='" . $_POST['variable'] . "'";
    }
}
if ($_POST['element'] == 'event_subcampaign') {
    /* change event subcampaigns list: */
    if ($_POST['action'] == 'delete') {
        $delete_element = "UPDATE Campaigns_Events SET Subcampaign='' WHERE Subcampaign='" . $_POST['variable'] . "'";
    } elseif ($_POST['action'] == 'edit') {
        $update_element = "UPDATE Campaigns_Events SET Subcampaign='" . $_POST['new_subcampaign'] . "' WHERE Subcampaign='" . $_POST['variable'] . "'";
    }
}

//now execute whatever the query was
include "../include/dbconnopen.php";
if ($_POST['action'] == 'add') {
    $query = $new_element;
} elseif ($_POST['action'] == 'delete') {
    $query = $delete_element;
} elseif ($_POST['action'] == 'edit') {
    $query = $update_element;
} else {
    $query = "";
}
//echo $query;
mysqli_query($cnnSWOP, $query);
echo "Thank you for saving this dropdown. Refresh to see your changes.";
include "../include/dbconnclose.php";
?>
