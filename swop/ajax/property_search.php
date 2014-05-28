<?php
/* search properties.  query search, so includes those search terms that are filled in. */

//these require us to find the most recent status (vacant, condition) and match the search term to that - that is, not 
//"was this property ever vacant" but "was this property vacant last we looked"
if ($_POST['vacant'] != 0) {
    if ($_POST['vacant'] == 1) {
        $vacant = " AND Property_Progress.Marker=8 AND Addtl_Info_1='Not vacant'";
    } else {
        $vacant = " AND Property_Progress.Marker=8 AND ("
                . "Addtl_Info_2='2' OR "
                . "Addtl_Info_2='3' OR "
                . "Addtl_Info_2='4')";
    }
    $vacant_join = " 
        INNER JOIN (
        SELECT Property_ID, Marker, MAX(Date_Added) as latest_date
        FROM Property_Progress WHERE Marker=8
        GROUP BY Property_ID) vacant_progress
        ON Property_Progress.Date_Added = vacant_progress.latest_date AND
            Property_Progress.Property_ID = vacant_progress.Property_ID ";
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

//the following don't require such checks, either because they stay the same (type, size) or because they refer to a range of times
//or prices, and we are interested in whether the property ever fell into these ranges
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
    $ac_cost_low = " AND Property_Progress.Marker=1 AND Addtl_Info_1>=" . $_POST['ac_cost_low'] . " ";
} else {
    $ac_cost_low = "";
}
if ($_POST['ac_cost_high'] != 0) {
    $ac_cost_high = " AND Property_Progress.Marker=1 AND Addtl_Info_1<=" . $_POST['ac_cost_high'] . " ";
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
    $con_cost_low = " AND Property_Progress.Marker=2 AND Addtl_Info_1>=" . $_POST['con_cost_low'] . " ";
} else {
    $con_cost_low = "";
}
if ($_POST['con_cost_high'] != 0) {
    $con_cost_high = " AND Property_Progress.Marker=2 AND Addtl_Info_1<=" . $_POST['con_cost_high'] . " ";
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
    $contracts_low = " AND Property_Progress.Marker=4 AND Addtl_Info_1>=" . $_POST['contracts_low'] . " ";
} else {
    $contracts_low = "";
}
if ($_POST['contracts_high'] != 0) {
    $contracts_high = " AND Property_Progress.Marker=4 AND Addtl_Info_1<=" . $_POST['contracts_high'] . " ";
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
    $sale_price_low = " AND Property_Progress.Marker=5 AND Addtl_Info_1>=" . $_POST['sale_price_low'] . " ";
} else {
    $sale_price_low = "";
}
if ($_POST['sale_price_high'] != 0) {
    $sale_price_high = " AND Property_Progress.Marker=5 AND Addtl_Info_1<=" . $_POST['sale_price_high'] . " ";
} else {
    $sale_price_high = "";
}
if ($_POST['low_days'] != 0) {
    $days_low = " AND Property_Progress.Marker=5 AND Addtl_Info_3>=" . $_POST['low_days'] . " ";
} else {
    $days_low = "";
}
if ($_POST['high_days'] != 0) {
    $days_high = " AND Property_Progress.Marker=5 AND Addtl_Info_3<=" . $_POST['high_days'] . " ";
} else {
    $days_high = "";
}
if ($_POST['subsidy_low'] != 0) {
    $subsidy_low = " AND Property_Progress.Marker=5 AND Addtl_Info_4>=" . $_POST['subsidy_low'] . " ";
} else {
    $subsidy_low = "";
}
if ($_POST['subsidy_high'] != 0) {
    $subsidy_high = " AND Property_Progress.Marker=5 AND Addtl_Info_4<=" . $_POST['subsidy_high'] . " ";
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

$search_properties = "SELECT * FROM Properties INNER JOIN 
    Property_Progress ON Properties.Property_ID=Property_Progress.Property_ID " . $vacant_join . $condition_join . $sale_progress .
        " WHERE Properties.Property_ID IS NOT NULL  " . $type . $size .
        $interest_date_start . $interest_date_end . $interest_reason . $vacant . $for_sale . $price_range_high . $price_range_low . $condition .
        $acquisition_start . $acquisition_end . $ac_cost_low . $ac_cost_high . $construction_start . $construction_end . $con_cost_low . $con_cost_high . $cert_start .
        $cert_end . $listed_start . $list_end . $contracts_low . $contracts_high . $sold_start . $sold_end . $sale_price_low . $sale_price_high .
        $subsidy_low . $subsidy_high . $possession_start . $possession_end;

//echo $search_properties;

include "../include/dbconnopen.php";
$search_results = mysqli_query($cnnSWOP, $search_properties);
?>

<table class="all_projects">
    <caption>Choose the columns you would like to view and export for this query:</caption>
    <?php
    $num_columns = mysqli_field_count($cnnSWOP);
    //echo $num_columns;
    //this is brought over from PAWS.  I'm trying to give Sarah what she wants in terms of checkboxes to determine which search fields will be 
    //returned.
    $table = '';
    for ($k = 0; $k < $num_columns; $k++) {
        $get_column_names = mysqli_fetch_field_direct($search_results, $k);
        if ($get_column_names->table != 'progress' && $get_column_names->table != 'laststatus') {
            if ($get_column_names->table != $table) {
                $table = $get_column_names->table;
                ?><tr class="note"><th colspan="4"><a href="javascript:;" onclick="
                                    $('.<?php echo $table; ?>_row').toggle();
                                                    "><?php echo $table; ?></a></th></tr><?php
                    if (($k + 1) % 4 != 1) {
                        echo "<tr class='" . $table . "_row addfields'>";
                    }
                }
                if (($k + 1) % 4 == 1) {
                    echo "<tr class='" . $table . "_row addfields'>";
                }
                ?><td class="all_projects" style="text-align: left;"><input type="checkbox" value="<?php echo $get_column_names->table . "." . $get_column_names->name; ?>"
                                                                      name="column_name[]" id="column_name_<?php echo $get_column_names->table . "_" . $get_column_names->name; ?>" <?php
                                                                      echo
                                                                      (($get_column_names->table . "." . $get_column_names->name == 'Project_Information.Project_PI') ||
                                                                      ($get_column_names->table . "." . $get_column_names->name == 'Project_Information.Short_Title') ||
                                                                      ($get_column_names->table . "." . $get_column_names->name == 'Project_Information.Project_Status') ||
                                                                      ($get_column_names->table . "." . $get_column_names->name == 'Project_Information.Funding_Source') ||
                                                                      ($get_column_names->table . "." . $get_column_names->name == 'Project_Information.Project_Number') ? 'checked=="checked"' : null);
                                                                      ?>>
                <label for="column_name_<?php echo $get_column_names->table . "_" . $get_column_names->name; ?>"><?php echo $get_column_names->name; ?></label></td>

            <?php
            if (($k + 1) % 4 == 0) {
                echo "</tr>";
            }
        }
    }
    ?>
</table>

<input type="button" value="View and Export these Results" onclick="
        var columns = document.getElementsByName('column_name[]');
        var col_array = new Array();
        var j = 0;
        for (var k = 0; k < columns.length; k++) {
            if (columns[k].checked == true) {
                col_array[j] = columns[k].value;
                j++;
            }
        }
        $.post(
                '../reports/indiv_results_table.php',
                {
                    vacant: document.getElementById('vacant_search').value,
                    for_sale: document.getElementById('for_sale_search').value,
                    price_low: document.getElementById('low_price_search').value,
                    price_high: document.getElementById('high_price_range').value,
                    //owner_occ: document.getElementById('owner_occ_search').value,
                    condition: document.getElementById('condition_search').value,
                    type: document.getElementById('type_search').value,
                    size: document.getElementById('size_search').value,
                    interest_start: document.getElementById('interest_start').value,
                    interest_end: document.getElementById('interest_end').value,
                    interest_reason: document.getElementById('interest_search').value,
                    acquisition_start: document.getElementById('acquisition_start').value,
                    acquisition_end: document.getElementById('acquisition_end').value,
                    ac_cost_low: document.getElementById('acquisition_low').value,
                    ac_cost_high: document.getElementById('acquisition_high').value,
                    construction_start: document.getElementById('construction_start').value,
                    construction_end: document.getElementById('construction_end').value,
                    con_cost_low: document.getElementById('construction_low').value,
                    con_cost_high: document.getElementById('construction_high').value,
                    certificate_start: document.getElementById('certificate_start').value,
                    certificate_end: document.getElementById('certificate_end').value,
                    listed_start: document.getElementById('listed_start').value,
                    listed_end: document.getElementById('listed_end').value,
                    contracts_low: document.getElementById('low_num_contracts').value,
                    contracts_high: document.getElementById('high_num_contracts').value,
                    date_sold_start: document.getElementById('start_sold_date').value,
                    date_sold_end: document.getElementById('end_sold_date').value,
                    sale_price_low: document.getElementById('low_sale_price').value,
                    sale_price_high: document.getElementById('high_sale_price').value,
                    low_days: document.getElementById('low_num_days').value,
                    high_days: document.getElementById('high_num_days').value,
                    subsidy_low: document.getElementById('min_subsidy').value,
                    subsidy_high: document.getElementById('max_subsidy').value,
                    possession_start: document.getElementById('possession_start').value,
                    possession_end: document.getElementById('possession_end').value,
                    search_type: 'properties',
                    columns: col_array
                },
        function(response) {
            document.getElementById('show_results_table').innerHTML = response;
        }
        )
       ">

<?php
include "../include/dbconnclose.php";
?>
<p></p>
<div id="show_results_table"></div>

