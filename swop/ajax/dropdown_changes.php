<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($SWOP_id, $DataEntryAccess);


/* changes to dropdowns throughout the system, as changed on the Alter System Dropdowns page. */

//alter the roles dropdown
include "../include/dbconnopen.php";
if ($_POST['element'] == 'role') {
    if ($_POST['action'] == 'add') {
        $new_element_sqlsafe = "INSERT INTO Participants_Roles (Role_Name) VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "')";
    } elseif ($_POST['action'] == 'delete') {
        user_enforce_has_access($SWOP_id, $AdminAccess);
        $delete_element_sqlsafe = "DELETE FROM Participants_Roles WHERE Role_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']);
    } elseif ($_POST['action'] == 'edit') {
        $update_element_sqlsafe = "UPDATE Participants_Roles SET Role_Name='" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "' WHERE Role_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['edited']);
    }
}
if ($_POST['element'] == 'leader') {
    /* change the leadership level options: */
    if ($_POST['action'] == 'add') {
        $new_element_sqlsafe = "INSERT INTO Leadership_Levels (Leader_Level) VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "')";
    } elseif ($_POST['action'] == 'delete') {
        user_enforce_has_access($SWOP_id, $AdminAccess);
        $delete_element_sqlsafe = "DELETE FROM Leadership_Levels WHERE Leader_Level_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']);
    } elseif ($_POST['action'] == 'edit') {
        $update_element_sqlsafe = "UPDATE Leadership_Levels SET Leader_Level='" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "' WHERE Leader_Level_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['edited']);
    }
}
if ($_POST['element'] == 'pool_type') {
    /* change types of pool members: */
    if ($_POST['action'] == 'add') {
        $new_element_sqlsafe = "INSERT INTO Pool_Member_Types (Type_Name, Pipeline) VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['edited']) . "')";
    } elseif ($_POST['action'] == 'delete') {
        user_enforce_has_access($SWOP_id, $AdminAccess);
        $delete_element_sqlsafe = "DELETE FROM Pool_Member_Types WHERE Type_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']);
    } elseif ($_POST['action'] == 'edit') {
        $update_element_sqlsafe = "UPDATE Pool_Member_Types SET Type_Name='" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "', Pipeline='" . mysqli_real_escape_string($cnnSWOP, $_POST['more']) . "' 
            WHERE Type_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['edited']);
    }
}
if ($_POST['element'] == 'pool_benchmark') {
    /* change pool benchmark options: */
    if ($_POST['action'] == 'add') {
        $new_element_sqlsafe = "INSERT INTO Pool_Benchmarks (Benchmark_Name, Pipeline_Type, Benchmark_Type) VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['pipeline']) . "', '" . mysqli_real_escape_string($cnnSWOP, $_POST['benchmark_type']) . "')";
    } elseif ($_POST['action'] == 'delete') {
        user_enforce_has_access($SWOP_id, $AdminAccess);
        $delete_element_sqlsafe = "DELETE FROM Pool_Benchmarks WHERE Pool_Benchmark_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']);
    } elseif ($_POST['action'] == 'edit') {
        $update_element_sqlsafe = "UPDATE Pool_Benchmarks SET
                            Benchmark_Name='" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "',
                            Pipeline_Type='" . mysqli_real_escape_string($cnnSWOP, $_POST['pipeline']) . "',
                            Benchmark_Type='" . mysqli_real_escape_string($cnnSWOP, $_POST['benchmark_type']) . "'
            WHERE Pool_Benchmark_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['edited']);
    }
}
if ($_POST['element'] == 'outcome') {
    /* change pool outcomes. */
    if ($_POST['action'] == 'add') {
        $new_element_sqlsafe = "INSERT INTO Outcomes_for_Pool (Outcome_Name) VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "')";
    } elseif ($_POST['action'] == 'delete') {
        user_enforce_has_access($SWOP_id, $AdminAccess);
        $delete_element_sqlsafe = "DELETE FROM Outcomes_for_Pool WHERE Outcome_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']);
    } elseif ($_POST['action'] == 'edit') {
        $update_element_sqlsafe = "UPDATE Outcomes_for_Pool SET Outcome_Name='" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "' WHERE Outcome_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['edited']);
    }
}
if ($_POST['element'] == 'location') {
    /* change locations for outcomes (and housing?) */
    if ($_POST['action'] == 'add') {
        $new_element_sqlsafe = "INSERT INTO Outcome_Locations (Outcome_Location_Name) VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "')";
    } elseif ($_POST['action'] == 'delete') {
        user_enforce_has_access($SWOP_id, $AdminAccess);
        $delete_element_sqlsafe = "DELETE FROM Outcome_Locations WHERE Outcome_Location_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']);
    } elseif ($_POST['action'] == 'edit') {
        $update_element_sqlsafe = "UPDATE Outcome_Locations SET Outcome_Location_Name='" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "' WHERE Outcome_Location_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['edited']);
    }
}
if ($_POST['element'] == 'disposition') {
    /* change property disposition options: */
    if ($_POST['action'] == 'add') {
        $new_element_sqlsafe = "INSERT INTO Property_Dispositions (Disposition_Name) VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "')";
    } elseif ($_POST['action'] == 'delete') {
        user_enforce_has_access($SWOP_id, $AdminAccess);
        $delete_element_sqlsafe = "DELETE FROM Property_Dispositions WHERE Disposition_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']);
    } elseif ($_POST['action'] == 'edit') {
        $update_element_sqlsafe = "UPDATE Property_Dispositions SET Disposition_Name='" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "' WHERE Disposition_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['edited']);
    }
}
if ($_POST['element'] == 'marker') {
    /* change property markers: */
    if ($_POST['action'] == 'add') {
        $new_element_sqlsafe = "INSERT INTO Property_Marker_Names (Property_Marker_Name) VALUES ('" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "')";
    } elseif ($_POST['action'] == 'delete') {
        user_enforce_has_access($SWOP_id, $AdminAccess);
        $delete_element_sqlsafe = "DELETE FROM Property_Marker_Names WHERE Property_Marker_Name_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']);
    } elseif ($_POST['action'] == 'edit') {
        $update_element_sqlsafe = "UPDATE Property_Marker_Names SET Property_Marker_Name='" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "' WHERE 
            Property_Marker_Name_ID=" . mysqli_real_escape_string($cnnSWOP, $_POST['edited']);
    }
}
if ($_POST['element'] == 'event_location') {
    /* change event location list (add a new one by adding it to an event) */
    if ($_POST['action'] == 'delete') {
        user_enforce_has_access($SWOP_id, $AdminAccess);
        $delete_element_sqlsafe = "UPDATE Campaigns_Events SET Location='' WHERE Location='" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "'";
    } elseif ($_POST['action'] == 'edit') {
        $update_element_sqlsafe = "UPDATE Campaigns_Events SET Location='" . mysqli_real_escape_string($cnnSWOP, $_POST['new_location']) . "' WHERE Location='" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "'";
    }
}
if ($_POST['element'] == 'event_subcampaign') {
    /* change event subcampaigns list: */
    if ($_POST['action'] == 'delete') {
        user_enforce_has_access($SWOP_id, $AdminAccess);
        $delete_element_sqlsafe = "UPDATE Campaigns_Events SET Subcampaign='' WHERE Subcampaign='" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "'";
    } elseif ($_POST['action'] == 'edit') {
        $update_element_sqlsafe = "UPDATE Campaigns_Events SET Subcampaign='" . mysqli_real_escape_string($cnnSWOP, $_POST['new_subcampaign']) . "' WHERE Subcampaign='" . mysqli_real_escape_string($cnnSWOP, $_POST['variable']) . "'";
    }
}

//now execute whatever the query was
if ($_POST['action'] == 'add') {
    $query_sqlsafe = $new_element_sqlsafe;
} elseif ($_POST['action'] == 'delete') {
    user_enforce_has_access($SWOP_id, $AdminAccess);
    $query_sqlsafe = $delete_element_sqlsafe;
} elseif ($_POST['action'] == 'edit') {
    $query_sqlsafe = $update_element_sqlsafe;
} else {
    $query_sqlsafe = "";
}
//echo $query_sqlsafe;
mysqli_query($cnnSWOP, $query_sqlsafe);
echo "Thank you for saving this dropdown. Refresh to see your changes.";
include "../include/dbconnclose.php";
?>
