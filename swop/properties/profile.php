<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
user_enforce_has_access($SWOP_id);

include "../../header.php";
include "../header.php";
include "../include/datepicker_simple.php";
if ($_GET['history'] == 1) {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            window.location.hash = "activity_history";
        });
    </script>
    <?php
}
?>	

<!-- Shows information about a certain property: -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#properties_selector').addClass('selected');
        $('#add_property').hide();
        $('#prop_profile').show();
        $('#property_search').hide();
        $('.edit_markers').hide();
        $('.edit_property').hide();
        //$('#vacant_options').hide();
        $('#list_price').hide();
        $('#owner_characteristics').hide();
        $('#owner_location').hide();
        $('#add_date').hide();
        $('#link_button').hide();
        $('.extra_prop_history').hide();
        $("a.add_new").hover(function() {
            $(this).addClass("selected");
        }, function() {
            $(this).removeClass("selected");
        });
    });
</script>

<div id="prop_profile">
    <?php
    include "../classes/property.php";
    $prop = new Property();
    $prop->load_with_id($_COOKIE['property']);
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#search_participants_div').hide();
            $('.rehab_edit').hide();
        });
    </script>
    <h3>Property Profile: <?php echo $prop->full_address; ?></h3><hr/>

    <!-- Basic info -->
    <table class="profile_table">
        <tr>
            <td width="55%">
                <h4>Basic Information</h4>
                <table class="inner_table" style="border: 2px solid #696969;">
                    <tr><td><strong>Address:</strong></td><td><span class="display_prop"><?php echo $prop->full_address; ?></span>
                            <input type="text" id="edit_user_address_number" style="width:40px;" class="edit_property" value="<?php echo $prop->street_num ?>"/> 
                            <select id="edit_user_address_direction" class="edit_property">
                                <option value="N" <?php echo ($prop->street_dir == 'N' ? 'selected=="selected"' : null) ?>>N</option>
                                <option value="S" <?php echo ($prop->street_dir == 'S' ? 'selected=="selected"' : null) ?>>S</option>
                                <option value="E" <?php echo ($prop->street_dir == 'E' ? 'selected=="selected"' : null) ?>>E</option>
                                <option value="W" <?php echo ($prop->street_dir == 'W' ? 'selected=="selected"' : null) ?>>W</option>
                            </select>
                            <input type="text" id="edit_user_address_street" style="width:100px;" class="edit_property"  value="<?php echo $prop->street_name ?>"/>
                            <select id="edit_user_address_street_type"  class="edit_property">
                                <option value="ST" <?php echo ($prop->street_type == 'ST' ? 'selected=="selected"' : null) ?>>ST</option>
                                <option value="AVE" <?php echo ($prop->street_type == 'AVE' ? 'selected=="selected"' : null) ?>>AVE</option>
                                <option value="RD" <?php echo ($prop->street_type == 'RD' ? 'selected=="selected"' : null) ?>>RD</option>
                                <option value="PL" <?php echo ($prop->street_type == 'PL' ? 'selected=="selected"' : null) ?>>PL</option>
                                <option value="CT" <?php echo ($prop->street_type == 'CT' ? 'selected=="selected"' : null) ?>>CT</option>
                                <option value="BLVD" <?php echo ($prop->street_type == 'BLVD' ? 'selected=="selected"' : null) ?>>BLVD</option>
                            </select>
                            <input type="text" id="edit_user_zipcode" class="edit_property"  value="<?php echo $prop->zipcode ?>"></td></tr>
                    <tr><td><strong>PIN:</strong></td><td><span class="display_prop"><?php echo $prop->pin; ?></span>
                            <input type="text" id="edit_pin" maxlength="10" class="edit_property" value="<?php echo $prop->pin; ?>"/></td></tr>
                    <tr><td><strong>Sale Price:</strong><br>
                            <!-- Price, vacancy, acquisition and construction costs are changed in the property markers section -->
                        </td><td><span class="display_prop"><?php echo $prop->price; ?></span>
                        </td></tr>
                    <tr><td><strong>Vacant?</strong></td><td><span class="display_prop"><?php if ($prop->vacant == 1) {
        echo 'Yes';
    } else {
        echo 'No';
    } ?></span>

                    <?php
                    $get_acq_cost_sqlsafe = "SELECT Property_Progress_ID, Addtl_Info_1 FROM Property_Progress WHERE Marker=1 AND Property_ID=$prop->property_id ORDER BY Date_Added DESC";
                    include "../include/dbconnopen.php";
                    $acq_cost = mysqli_query($cnnSWOP, $get_acq_cost_sqlsafe);
                    $accost = mysqli_fetch_row($acq_cost);
                    ?>
                    <tr><td><strong>Acquisition Cost:</strong></td><td><span class="display_prop"><?php echo $accost[1]; ?></span>
                            <input type="text" id="edit_acq_cost" class="edit_property" value="<?php echo $accost[1]; ?>"></td></tr>
<?php
$get_const_cost_sqlsafe = "SELECT Property_Progress_ID, Addtl_Info_1 FROM Property_Progress WHERE Marker=2 AND Property_ID=$prop->property_id ORDER BY Date_Added DESC";
include "../include/dbconnopen.php";
$const_cost = mysqli_query($cnnSWOP, $get_const_cost_sqlsafe);
$concost = mysqli_fetch_row($const_cost);
include "../include/dbconnclose.php";
?>
                    <tr><td><strong>Construction Cost:</strong></td><td><span class="display_prop"><?php echo $concost[1]; ?></span>
                            <input type="text" id="edit_const_cost" class="edit_property" value="<?php echo $concost[1]; ?>"></td></tr>
                    <tr><td><strong>Disposition:</strong></td><td><span class="display_prop"><?php echo $prop->disposition; ?></span>
                            <select id="edit_disposition" class="edit_property">
                                <option value="">---------</option>
                                        <?php
                                        $get_disps_sqlsafe = "SELECT * FROM Property_Dispositions";
                                        include "../include/dbconnopen.php";
                                        $disps = mysqli_query($cnnSWOP, $get_disps_sqlsafe);
                                        while ($disp = mysqli_fetch_row($disps)) {
                                            ?>
                                    <option value="<?php echo $disp[0] ?>" 
    <?php echo ($prop->disposition_id == $disp[0] ? 'selected="selected"' : null) ?>><?php echo $disp[1]; ?></option>
<?php }
include "../include/dbconnclose.php";
?>
                            </select></td></tr>
                    <tr><td><strong>Construction Type:</strong></td><td><span class="display_prop"><?php
if ($prop->construction_type == 4) {
    echo 'Brick/masonry';
} elseif ($prop->construction_type == 5) {
    echo 'Frame';
} else {
    echo '';
}
?></span>
                            <select id="edit_construction" class="edit_property">
                                <option value="">-----</option>
                                <option value="4" <?php echo ($prop->construction_type == 4 ? 'selected="selected"' : null); ?>>Brick/masonry</option>
                                <option value="5" <?php echo ($prop->construction_type == 5 ? 'selected="selected"' : null); ?>>Frame</option>
                            </select></td></tr>
                    <tr><td><strong>Home Size:</strong></td><td><span class="display_prop"><?php
if ($prop->home_size == 1) {
    echo 'Single-family';
} elseif ($prop->home_size == 2) {
    echo '2/3 flat';
} elseif ($prop->home_size == 3) {
    echo 'Multi-unit';
}
?></span>
                            <select id="edit_size" class="edit_property">
                                <option value="">-----</option>
                                <option value="1" <?php echo ($prop->home_size == 1 ? 'selected="selected"' : null); ?>>Single-family</option>
                                <option value="2" <?php echo ($prop->home_size == 2 ? 'selected="selected"' : null); ?>>2/3 flat</option>
                                <option value="3" <?php echo ($prop->home_size == 3 ? 'selected="selected"' : null); ?>>Multi-unit</option>
                            </select></td></tr>
                    <tr><td><strong>Property Type:</strong></td><td><span class="display_prop"><?php
                            if ($prop->prop_type == 1) {
                                echo 'Residential';
                            } elseif ($prop->prop_type == 2) {
                                echo 'Commercial';
                            } elseif ($prop->prop_type == 3) {
                                echo 'Mixed Use';
                            }
                            ?></span>
                            <select id="edit_prop_type" class="edit_property">
                                <option value="">-----</option>
                                <option value="1" <?php echo ($prop->prop_type == 1 ? 'selected="selected"' : null); ?>>Residential</option>
                                <option value="2" <?php echo ($prop->prop_type == 2 ? 'selected="selected"' : null); ?>>Commercial</option>
                                <option value="3" <?php echo ($prop->prop_type == 3 ? 'selected="selected"' : null); ?>>Mixed Use</option>
                            </select></td></tr>
                    <tr><td>
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>                <input type="button" value="Edit" class="display_prop" onclick="$('.edit_property').toggle();
                            $('.display_prop').toggle();
                            $('#edit_address').show();"></td>
                        <td>
<input type="button" value="Save Changes" class="edit_property" onclick="
                                $.post(
                                        '../ajax/edit_property.php',
                                        {
                                            id: '<?php echo $prop->property_id; ?>',
                                            num: document.getElementById('edit_user_address_number').value,
                                            dir: document.getElementById('edit_user_address_direction').value,
                                            name: document.getElementById('edit_user_address_street').value,
                                            type: document.getElementById('edit_user_address_street_type').value,
                                            zipcode: document.getElementById('edit_user_zipcode').value,
                                            pin: document.getElementById('edit_pin').value,
                                            acquisition: document.getElementById('edit_acq_cost').value,
                                            acquisition_alter_id: '<?php echo $accost[0]; ?>',
                                            con_cost: document.getElementById('edit_const_cost').value,
                                            const_alter_id: '<?php echo $concost[0] ?>',
                                            disposition: document.getElementById('edit_disposition').value,
                                            construction: document.getElementById('edit_construction').value,
                                            size: document.getElementById('edit_size').value,
                                            prop_type: document.getElementById('edit_prop_type').value
                                        },
                                function(response) {
                                    // document.write(response);
                                    window.location = 'profile.php';
                                }
                                ).fail(failAlert);"
<?php
 } //end access check
?></td></tr>
                    <tr>

                        <!-- Add notes or photos here: -->
                        <td><strong>Files:</strong></td>
                        <td>
<?php
include "../include/dbconnopen.php";
$query_sqlsafe = "SELECT File_ID, File_Name 
                                FROM Property_Files
                                WHERE Property_ID=$prop->property_id
                                ORDER BY File_Name;";
$result = mysqli_query($cnnSWOP, $query_sqlsafe);
if (mysqli_num_rows($result) == 0) {
    echo "No notes have been uploaded <br>";
} else {
    while (list($id, $name) = mysqli_fetch_array($result)) {
        ?>

                                    <a href="/swop/ajax/download.php?id=<?php echo $id; ?>" style="font-size:.8em;"><?php echo $name; ?></a> <br>
        <?php
    }
}
include "../include/dbconnclose.php";
?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Upload a file:</strong>
                        </td>
                        <td>
                            <form id="file_upload_form" action="/swop/ajax/upload_file.php" method="post" enctype="multipart/form-data">
                                <input type="file" name="file" id="file" style="font-size:.7em; padding-top:4px;"/> 
                                <input type="hidden" name="event_id" value="<?php echo $prop->property_id; ?>">
                                <br />
                                <input type="submit" name="submit" value="Upload" style="font-size:.7em; padding-top:4px;"/>
                                <iframe id="upload_target" name="upload_target" src="" style="width:0;height:0;border:0px solid #fff;"></iframe>
                            </form>
                        </td>
                    </tr>
                </table>
            </td>
            <td>

                <!-- Add information to the property activity history here: -->
                <h4>Property Markers</h4>
                <span class="helptext">Changes made here will be recorded in the Property Activity History below.</span>
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>                <table class="inner_table">

                    <!-- Yes or no to vacant.  Usually comes from the vacant property survey.  If no, save.  If yes, then choose
                    a type of vacancy and save. -->
                    <tr><td><strong>Vacant?</strong></td>
                        <td>
                            <input type="checkbox" onchange="if (this.checked == true) {
                                                $('#vacant_options').show();
                                            }
                                            else if (this.checked == false) {
                                                $('#vacant_options').hide();
                                            }" <?php //if($vacant==1) {echo "checked='checked'";} ?>>Yes<br>
                            <input type="checkbox" onchange="if (this.checked == true) {
                                            $.post(
                                                    '../ajax/save_more_markers.php',
                                                    {
                                                        marker: 8,
                                                        value: 'Not vacant',
                                                        property: '<?php echo $prop->property_id; ?>'
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                window.location = 'profile.php';
                                            }
                                            ).fail(failAlert);
                                        }" > No
                            <div id="vacant_options" <?php if ($vacant == 0) {
                                    echo "style='display:none;'";
                                } ?>>
                                <select id="options_vacant" onchange="
                                                        var vacant_type = this.value;
                                                        alert(vacant_type);
                                                        $.post(
                                                                '../ajax/save_more_markers.php',
                                                                {
                                                                    marker: 8,
                                                                    value: 'Vacant',
                                                                    add_2: vacant_type,
                                                                    property: '<?php echo $prop->property_id; ?>'
                                                                },
                                                        function(response) {
                                                            //document.write(response);
                                                            window.location = 'profile.php';
                                                        }
                                                        ).fail(failAlert);">
                                    <option value="">-----------</option>
                                    <option value="2" <?php echo ($secured == 1 ? "selected='selected'" : null); ?>>Secured/Boarded</option>
                                    <option value="3" <?php echo ($unsecured == 1 ? "selected='selected'" : null); ?>>Unsecured</option>
                                    <option value="4" <?php echo ($open == 1 ? "selected='selected'" : null); ?>>Open</option>
                                </select></div>
                        </td>

                    </tr>

                    <!-- Again, yes or no for sale.  If no, save.  If yes, enter the listing price and save.  -->
                    <tr><td><strong>For Sale?</strong></td>
                        <td><input type="checkbox" onchange="handleRole(this)" <?php if ($for_sale == 1) {
                                echo "checked='checked'";
                            } ?>>Yes<br>
                            <input type="checkbox" onchange="if (this.checked === true) {
                                            $.post(
                                                    '../ajax/save_more_markers.php',
                                                    {
                                                        marker: 9,
                                                        value: 'Not for sale',
                                                        property: '<?php echo $prop->property_id; ?>'
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                window.location = 'profile.php';
                                            }
                                            ).fail(failAlert);
                                        }" <?php //if($for_sale==0) {echo "checked='checked'";} ?>> No</td>

                    </tr>
                    <tr id="list_price"><td><strong>Listing Price</strong></td>
                        <td><input type="text" id="price_marker" onchange="
                                        $.post(
                                                '../ajax/save_more_markers.php',
                                                {
                                                    marker: 9,
                                                    value: 'For Sale',
                                                    add_2: this.value,
                                                    property: '<?php echo $prop->property_id; ?>'
                                                },
                                        function(response) {
                                            //document.write(response);
                                            window.location = 'profile.php';
                                        }
                                        ).fail(failAlert);
                                   "></td>
                    </tr>

                    <!-- Generally only recording institutional owners (banks).  If institution or unknown chosen,
                    then choose whether owner occupied or owned by an investor.  If owner occupied, then save.  If 
                    investor, choose whether absentee or living there and save. -->
                    <tr><td><strong>Owner:</strong></td>
                        <td>
                            <strong>Institution:</strong> <select id="inst_owner" onchange="$('#owner_characteristics').show()">
                                <option value="">-----</option>
                            <?php
                            $get_institutions_sqlsafe = "SELECT * FROM Institutions ORDER BY Institution_Name";
                            include "../include/dbconnopen.php";
                            $institutions = mysqli_query($cnnSWOP, $get_institutions_sqlsafe);
                            while ($institution = mysqli_fetch_array($institutions)) {
                                ?>
                                    <option value="<?php echo $institution['Institution_ID']; ?>"><?php echo $institution['Institution_Name']; ?></option>
                            <?php
                            }
                            include "../include/dbconnclose.php";
                            ?>
                            </select>
                            <br>
                            <input type="checkbox" id="owner_unknown" onchange="$('#owner_characteristics').show()">Unknown</td>

                    </tr>
                    <tr id="owner_characteristics"><td></td>
                        <td><input type="radio" name="ownership"  onchange="$('#owner_location').hide();
                                        if (this.checked === true) {
                                            //alert(this.checked);
                                            var owner = 'Test';
                                            if (document.getElementById('inst_owner').value != '') {
                                                owner = document.getElementById('inst_owner').value;
                                            }
                                            else {
                                                owner = 'Unknown';
                                            }
                                            $.post(
                                                    '../ajax/save_more_markers.php',
                                                    {
                                                        marker: 10,
                                                        value: owner,
                                                        add_2: 'Owner Occupied Non-Landlord',
                                                        add_3: 'N/A',
                                                        property: '<?php echo $prop->property_id; ?>'
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                window.location = 'profile.php';
                                            }
                                            ).fail(failAlert);
                                        }"
                                   id="nonlandlord">Owner Occupied Non-Landlord<br>
                            <input type="radio" name="ownership" onchange="$('#owner_location').show();" id="investor">Investor</td>

                    </tr>
                    <tr id="owner_location"><td></td><td><input type="radio" name="locale" onchange="if (this.checked === true) {
                                        // alert(this.checked);
                                        var owner = 'Test';
                                        if (document.getElementById('inst_owner').value != '') {
                                            owner = document.getElementById('inst_owner').value;
                                        }
                                        else {
                                            owner = 'Unknown';
                                        }
                                        var owner_type = 'Test 2';
                                        if (document.getElementById('investor').checked === true) {
                                            owner_type = 'Investor';
                                        }
                                        else if (document.getElementById('nonlandlord').checked === true) {
                                            owner_type = 'Owner Occupied Non-Landlord';
                                        }
                                        $.post(
                                                '../ajax/save_more_markers.php',
                                                {
                                                    marker: 10,
                                                    value: owner,
                                                    add_2: owner_type,
                                                    add_3: 'Absentee',
                                                    property: '<?php echo $prop->property_id; ?>'
                                                },
                                        function(response) {
                                            //document.write(response);
                                            window.location = 'profile.php';
                                        }
                                        ).fail(failAlert);
                                    }">Absentee<br>
                                                                <input type="radio" name="locale" onchange="if (this.checked === true) {
                                            //alert(this.checked);
                                            var owner = 'Test';
                                            if (document.getElementById('inst_owner').value != '') {
                                                owner = document.getElementById('inst_owner').value;
                                            }
                                            else {
                                                owner = 'Unknown';
                                            }
                                            var owner_type = 'Test 2';
                                            if (document.getElementById('investor').checked === true) {
                                                owner_type = 'Investor';
                                            }
                                            else if (document.getElementById('nonlandlord').checked === true) {
                                                owner_type = 'Owner Occupied Non-Landlord';
                                            }
                                            $.post(
                                                    '../ajax/save_more_markers.php',
                                                    {
                                                        marker: 10,
                                                        value: owner,
                                                        add_2: owner_type,
                                                        add_3: 'Living on premises',
                                                        property: '<?php echo $prop->property_id; ?>'
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                window.location = 'profile.php';
                                            }
                                            ).fail(failAlert);
                                        }"">Living on premises</td></tr>

                    <!-- Rubric for condition hasn't been determined yet.  Choose level and save. -->
                    <tr><td><strong>Property condition:</strong></td>
                        <td><select id="condition_marker" onchange="
                                        var condition = this.value;
                                        $.post(
                                                '../ajax/save_more_markers.php',
                                                {
                                                    marker: 11,
                                                    value: condition,
                                                    property: '<?php echo $prop->property_id; ?>'
                                                },
                                        function(response) {
                                            //document.write(response);
                                            window.location = 'profile.php';
                                        }
                                        ).fail(failAlert);
                                    ">
                                <option value="">-----</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select></td>

                    </tr>


                </table>
<?php
} //end access check
?><p></p>

                <!-- These markers have to do with those properties that have been acquired by SWOP or partners.  They will be rehabbed and sold.
                These markers are the steps to that eventual sale.
                
                Some steps have additional information related.  If there are any additional details, then spaces for them
                will appear onselect.  All of this information is saved with the click of "Add Marker."  
                -->

                <table class="inner_table">
                    <tr><th style="font-size:.9em;">Add Rehab/Acquisition Marker</th></tr>
                    <tr><td><select id="add_marker" onchange="
                                                var marker = this.value;
                                                $.post(
                                                        '../ajax/add_property_marker.php',
                                                        {
                                                            action: 'get_addtl_info',
                                                            marker: marker
                                                        },
                                                function(response) {
                                                    document.getElementById('addtl_info').innerHTML = response;
                                                }
                                                ).fail(failAlert);">
                                <option value="">----------</option>
                                   <?php
                                   //get marker names, but of course, some of them aren't applicable...
                                   $select_names_sqlsafe = "SELECT * FROM Property_Marker_Names WHERE Property_Marker_Name_ID<8
                                                                    OR Property_Marker_Name_ID=12";
                                   include "../include/dbconnopen.php";
                                   $names = mysqli_query($cnnSWOP, $select_names_sqlsafe);
                                   while ($name = mysqli_fetch_row($names)) {
                                       ?>
                                    <option value="<?php echo $name[0] ?>"><?php echo $name[1]; ?></option>
    <?php
}
include "../include/dbconnclose.php";
?>
                            </select>
                            <div id="addtl_info"></div>
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>                            <input type="button" value="Add Marker" onclick="
                                                                $.post(
                                                                        '../ajax/add_property_marker.php',
                                                                        {
                                                                            action: 'save',
                                                                            marker: document.getElementById('add_marker').value,
                                                                            addtl_info_1: document.getElementById('addtl_info_1').value,
                                                                            addtl_info_2: document.getElementById('addtl_info_2').value,
                                                                            addtl_info_3: document.getElementById('addtl_info_3').value,
                                                                            addtl_info_4: document.getElementById('addtl_info_4').value,
                                                                            property: <?php echo $prop->property_id; ?>
                                                                        },
                                                                function(response) {
                                                                    //document.write(response);
                                                                    window.location = 'profile.php?history=1';
                                                                }
                                                                ).fail(failAlert);"/>
<?php
} //end access check
?>
                        </td></tr>
                </table>

                <script text="javascript">
                    function handleRole(cb) {
                        if (cb.checked == true) {
                            $('#list_price').show();
                        }
                        else if (cb.checked == false) {
                            $('#list_price').hide();
                        }
                    }
                </script>
            </td></tr>
        <tr>

            <!-- Shows all participants related to this property.  Might be those who live there or owners or former residents. -->

            <td colspan="2">
                <h4>Linked Participants</h4>
                <table id="linked_properties_table" class="inner_table" style="width:100%;">
                    <tr>
                        <th>Street Address</th>
                        <th>Unit #</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>End Reason</th>
                        <th>Primary Residence?</th>
                        <th>Rent or Own?</th>
                        <th></th>
                    </tr>
<?php
$get_linked_props_sqlsafe = "SELECT * FROM Participants_Properties INNER JOIN Participants ON 
                            Participants_Properties.Participant_ID=Participants.Participant_ID WHERE Property_ID='" . $prop->property_id . "'";
// echo $get_linked_props;
include "../include/dbconnopen.php";
$linked_props = mysqli_query($cnnSWOP, $get_linked_props_sqlsafe);
while ($linked = mysqli_fetch_array($linked_props)) {
    ?>
                        <tr>
                            <td><a href="javascript:;" onclick="
                                                                            $.post(
                                                                                    '../ajax/set_participant_id.php',
                                                                                    {
                                                                                        page: 'profile',
                                                                                        participant_id: '<?php echo $linked['Participant_ID']; ?>'
                                                                                    },
                                                                            function(response) {
                                   var url = response;
                                   var url_array = url.split('script>');
                                   window.location = url_array[1];
                                                                            }).fail(failAlert);"><?php echo $linked['Name_First'] . " " . $linked['Name_Last']; ?></a>
                            </td>
                            <td><input type="text" style="width:25px;" value="<?php echo $linked['Unit_Number']; ?>" id="<?php echo $linked['Participant_ID']; ?>_unit" /></td>
                            <td><input type="text" style="width:68px;" value="<?php echo $linked['Start_Date']; ?>" id="<?php echo $linked['Participant_ID']; ?>_start" class="hasDatepickers"/></td>
                            <td><input type="text" style="width:68px;" value="<?php echo $linked['End_Date']; ?>" id="<?php echo $linked['Participant_ID']; ?>_end"  class="hasDatepickers"/></td>
                            <td><select id="<?php echo $linked['Participant_ID']; ?>_end_reason">
                                    <option value="">------</option>
                                    <option value="sold" <?php echo($linked['Reason_End'] == "sold" ? "selected='selected'" : null); ?>>Sold</option>
                                    <option value="moved" <?php echo($linked['Reason_End'] == "moved" ? "selected='selected'" : null); ?>>Moved</option>
                                    <option value="foreclosed" <?php echo($linked['Reason_End'] == "foreclosed" ? "selected='selected'" : null); ?>>Foreclosed</option>
                                    <option value="short_sale" <?php echo($linked['Reason_End'] == "short_sale" ? "selected='selected'" : null); ?>>Short Sale</option>
                                </select>
                            </td>
                            <td><input type="checkbox" id="<?php echo $linked['Participant_ID']; ?>_primary" <?php echo($linked['Primary_Residence'] == 1 ? "checked" : null); ?>/>
                                <input type="text" style="width:68px;" value="<?php echo $linked['Start_Primary']; ?>" id="<?php echo $linked['Participant_ID']; ?>_start_primary"  class="hasDatepickers"/><br/>
                                <span class="helptext" style="margin-left:10px;">to </span><input type="text" style="width:68px;" value="<?php echo $linked['End_Primary']; ?>" id="<?php echo $linked['Participant_ID']; ?>_end_primary"  class="hasDatepickers"/>
                            </td>
                            <td><select id="<?php echo $linked['Participant_ID']; ?>_rent_own">
                                    <option value="">----</option>
                                    <option value="rent" <?php echo($linked['Rent_Own'] == "rent" ? "selected='selected'" : null); ?>>Renter</option>
                                    <option value="own" <?php echo($linked['Rent_Own'] == "own" ? "selected='selected'" : null); ?>>Owner</option>
                                </select>
                            </td>
                            <td>
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?><a class="helptext" href="javascript:;" onclick="
                                                                            if (document.getElementById('<?php echo $linked['Participant_ID']; ?>_primary').checked == true) {
                                                                                var primary = 1;
                                                                            }
                                                                            else {
                                                                                var primary = 0;
                                                                            }
                                                                            $.post(
                                                                                    '../ajax/update_linked_property.php',
                                                                                    {
                                                                                        link_id: '<?php echo $linked['Participant_Property_ID']; ?>',
                                                                                        unit: document.getElementById('<?php echo $linked['Participant_ID']; ?>_unit').value,
                                                                                        start: document.getElementById('<?php echo $linked['Participant_ID']; ?>_start').value,
                                                                                        end: document.getElementById('<?php echo $linked['Participant_ID']; ?>_end').value,
                                                                                        reason_end: document.getElementById('<?php echo $linked['Participant_ID']; ?>_end_reason').value,
                                                                                        primary: primary,
                                                                                        start_primary: document.getElementById('<?php echo $linked['Participant_ID']; ?>_start_primary').value,
                                                                                        end_primary: document.getElementById('<?php echo $linked['Participant_ID']; ?>_end_primary').value,
                                                                                        rent_own: document.getElementById('<?php echo $linked['Participant_ID']; ?>_rent_own').value
                                                                                    },
                                                                            function(response) {
                                                                                //document.write(response);
                                                                                window.location = 'profile.php';
                                                                            }
                                                                            ).fail(failAlert);">Save changes...</a>
<?php
} //end access check
?></td>
                        </tr>
                        <!----------------
                        <a href="javascript:;" onclick="
    $.post(
    '../ajax/set_participant_id.php',
    {
    page: 'profile',
    participant_id: '<?php /* echo $participant['Participant_ID'];?>'
                      },
                      function (response){
                      if (response!='1'){
                      document.getElementById('show_error').innerHTML = response;
                      }
                      window.location='/swop/participants/participants.php';
                      }).fail(failAlert);"><?php echo $participant['Name_First'] . " " . $participant['Name_Last']; */ ?></a><br>-->
                                    <?php
                                }
                                include "../include/dbconnclose.php";
                                ?>
                </table>          

                <!-- search to link to a new participant: -->
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>                <a href="javascript:;" onclick="$('#search_participants_div').toggle();" >Search for a participant</a>
                <div id="search_participants_div">
                    <table class="search_table" style="margin-left:20px;">
                        <tr>
                            <td><strong>First Name:</strong></td>
                            <td><input type="text" id="prop_name_search" /></td>
                            <td><strong>Last Name:</strong></td>
                            <td><input type="text" id="prop_surname_search" /></td>
                        </tr>
                        <tr>
                            <td><strong>Primary Institution:</strong></td>
                            <td><select id="prop_inst_search" />
                        <option value="">-----</option>
                    <?php
                    $get_institutions_sqlsafe = "SELECT * FROM Institutions ORDER BY Institution_Name";
                    include "../include/dbconnopen.php";
                    $institutions = mysqli_query($cnnSWOP, $get_institutions_sqlsafe);
                    while ($institution = mysqli_fetch_array($institutions)) {
                        ?>
                            <option value="<?php echo $institution['Institution_ID']; ?>"><?php echo $institution['Institution_Name']; ?></option>
                    <?php
                           }
                           //include "../include/dbconnclose.php";
                           ?></select></td>
                        </tr>

                        <tr>
                            <td colspan="4"><input type="button" value="Search" onclick="
                                        $('#link_button').show();
                                        $.post(
                                                '../ajax/search_users.php',
                                                {
                                                    first: document.getElementById('prop_name_search').value,
                                                    last: document.getElementById('prop_surname_search').value,
                                                    inst: document.getElementById('prop_inst_search').value,
                                                    dropdown: 1
                                                },
                                        function(response) {
                                            //document.write(response);
                                            document.getElementById('show_trp_results').innerHTML = response;
                                        }
                                        ).fail(failAlert);"/></td>
                        </tr>
                    </table>
                    <div id="show_trp_results"></div>
                    <input type="button" value="Link This Participant" id="link_button" onclick="
                        $.post(
                                '../ajax/link_property.php',
                                {
                                    property: '<?php echo $prop->property_id; ?>',
                                    person: document.getElementById('choose_participant').value
                                },
                        function(response) {
                            window.location = 'profile.php';
                        }
                        ).fail(failAlert);">
                </div>
<?php
} //end access check
?>
                <br/><br/>


                <!-- shows information for this property over time.  For those properties being rehabbed, shows the progress being
                made.  For others, shows periods of vacancy vs. occupation.
                -->

                <h4 id="activity_history">Property Activity History</h4>
                <table class="inner_table activity_history" width="100%">
                                <?php
                                $get_events = "SELECT Date_Added, Marker, Addtl_Info_1, Addtl_Info_2, Addtl_Info_3, Addtl_Info_4, Property_Progress_ID, Notes FROM Property_Progress
									WHERE Property_ID='" . $prop->property_id . "'
									UNION ALL
									SELECT Date_Entered, '', '', '', '', '', Property_ID, '' FROM Properties
									WHERE Property_ID='" . $prop->property_id . "'
									ORDER BY Date_Added DESC";

                                /* retrieve general info about property plus all progress steps: */
                                $get_events_sqlsafe = "SELECT Date_Added, Marker, Property_Marker_Name, Addtl_Info_1, 
                                                Addtl_Info_2, Addtl_Info_3, Addtl_Info_4, 
                                                Property_Progress_ID, Notes FROM Property_Progress  INNER JOIN Property_Marker_Names
                                                ON Marker=Property_Marker_Name_ID WHERE Property_ID='" . $prop->property_id . "'
                                                UNION ALL SELECT Date_Entered, '', '', '', '', '', '', Property_ID, '' 
                                                FROM Properties
                                                WHERE Property_ID='" . $prop->property_id . "' ORDER BY Date_Added DESC";
                                // echo $get_events;
                                include "../include/dbconnopen.php";
                                $events = mysqli_query($cnnSWOP, $get_events_sqlsafe);
                                $event_counter = 0;
                                while ($event = mysqli_fetch_array($events)) {
                                    $event_counter++;
                                    ?>
                        <tr <?php
                            /* show only the 5 most recent events: */
                            if ($event_counter > 5) {
                                echo "class='extra_prop_history'";
                            }
                            ?>>
                            <td><?php
                            $this_date = explode('-', $event['Date_Added']);
                            date_default_timezone_set('America/Chicago');
                            $show_date = mktime(0, 0, 0, $this_date[1], $this_date[2], $this_date[0]);
                            $display_date = date('n/j/Y', $show_date);
                            echo $display_date;
                            //echo " (" . $event['Activity_Type'] . ")";
                            ?></td>
                            <td><strong><?php
                            /* show what happened: */
                            echo $event['Property_Marker_Name'];
                            if ($event['Marker'] == '') {

                                echo "Property added to the database";
                            }
                            ?></strong></td>
                            <?php
                            /* show additional information for different steps: */
                            if ($event['Marker'] == 7) {
                                /* then SWOP is interested.  add why: */
                                ?>
                                <td>
                                    &nbsp;&nbsp;&nbsp;<em>Reason for interest: </em>
                                <?php
                                if ($event['Addtl_Info_1'] == 'vacant') {
                                    echo "Vacant";
                                } else if ($event['Addtl_Info_1'] == 'foreclosure') {
                                    echo "Foreclosure";
                                } else if ($event['Addtl_Info_1'] == 'sale') {
                                    echo "For Sale";
                                } else if ($event['Addtl_Info_1'] == 'reo') {
                                    echo "REO";
                                }
                                ?>
                                </td>
                                    <?php
                                } else if ($event['Marker'] == 1) {
                                    /* then property was acquired.  how much did it cost? */
                                    ?>
                                <td>
                                    &nbsp;&nbsp;&nbsp;<em>Acquisition Cost: </em><?php echo $event['Addtl_Info_1']; ?>
                                </td>
                                        <?php
                                    } else if ($event['Marker'] == 2) {
                                        /* then construction started.  add the cost later: */
                                        ?>
                                <td>
                                    &nbsp;&nbsp;&nbsp;<em>Construction Cost: </em><?php echo $event['Addtl_Info_1']; ?>
                                </td>
                                <?php
                            } else if ($event['Marker'] == 4) {
                                /* property listed for sale.  The number of contracts records how many
                                 * times the property was supposed to have been sold but the contract fell
                                 * through. */
                                ?>
                                <td>
                                    &nbsp;&nbsp;&nbsp;<em>Number of contracts: </em><?php echo $event['Addtl_Info_1']; ?></td>
                                        <?php
                                    } else if ($event['Marker'] == 5) {
                                        /* Property sold.  Save extra information: */
                                        ?>
                                <td>&nbsp;&nbsp;&nbsp;<em>Sale price: </em><?php echo $event['Addtl_Info_1']; ?><br/>
                                    &nbsp;&nbsp;&nbsp;<em>Purchaser: </em><?php echo $event['Addtl_Info_2']; ?><br/>
                                    &nbsp;&nbsp;&nbsp;<em>Days on the market: </em><?php echo $event['Addtl_Info_3']; ?><br/>
                                    &nbsp;&nbsp;&nbsp;<em>Amount of subsidy/second mortgage: </em><?php echo $event['Addtl_Info_4']; ?></td>
                                    <?php
                                } elseif ($event['Marker'] == '8') {
                                    /* property is vacant, or not.  If vacant, show the type of vacancy: */
                                    ?><td>&nbsp;&nbsp;&nbsp;<?php echo $event['Addtl_Info_1']; ?><br/>
                                    <em>Type: </em>&nbsp;&nbsp;&nbsp;<?php
                            if ($event['Addtl_Info_2'] == 2) {
                                echo 'Secured/Boarded';
                            } elseif ($event['Addtl_Info_2'] == 3) {
                                echo 'Unsecured';
                            } elseif ($event['Addtl_Info_2'] == 4) {
                                echo 'Open';
                            }
                                    ?></td><?php
                                    } elseif ($event['Marker'] == '9') {
                                        /* property is for sale/sold: */
                                        ?><td>&nbsp;&nbsp;&nbsp;<em>Value: </em><?php echo $event['Addtl_Info_1']; ?><br/>
                                    &nbsp;&nbsp;&nbsp;<em>List Price: </em><?php
                                           if (gettype($event['Addtl_Info_2']) == 'double') {
                                               echo "$" . number_format($event['Addtl_Info_2']);
                                           } else {
                                               echo $event['Addtl_Info_2'];
                                           }
                                           ?><br/></td><?php
                                       } elseif ($event['Marker'] == '10') {
                                           /* owner was recorded */
                                           ?><td>&nbsp;&nbsp;&nbsp;<em>Name: </em><?php
                                           /* if the owner was an investing institution, then show the name here: */
                                           $get_inst_name_sqlsafe = "SELECT Institution_Name FROM Institutions WHERE Institution_ID='" . $event['Addtl_Info_1'] . "'";
                                           $inst = mysqli_query($cnnSWOP, $get_inst_name_sqlsafe);
                                           $inst_name = mysqli_fetch_row($inst);
                                           echo $inst_name[0];
                                           ?><br/>
                                    &nbsp;&nbsp;&nbsp;<em>Investor? </em><?php echo $event['Addtl_Info_2']; ?><br/>
                                    &nbsp;&nbsp;&nbsp;<em>Absentee? </em><?php echo $event['Addtl_Info_3']; ?><br/></td>
                                           <?php
                                       } elseif ($event['Marker'] == '11') {
                                           /* condition recorded. */
                                           ?><td>&nbsp;&nbsp;&nbsp;<em>Condition: </em><?php echo $event['Addtl_Info_1']; ?><br/></td><?php
                        } elseif ($event['Marker'] == 13) {
                            /* disposition changed. */
                            ?><td>&nbsp;&nbsp;&nbsp;<em>Disposition: </em><?php
                            $get_disp_sqlsafe = "SELECT Disposition_Name FROM
                                                            Property_Dispositions WHERE Disposition_ID='" . $event['Addtl_Info_1'] . "'";
                            $name_disp = mysqli_query($cnnSWOP, $get_disp_sqlsafe);
                            $dispos = mysqli_fetch_row($name_disp);
                            echo $dispos[0];
                            ?><br/></td><?php
                        } else {
                            /* for any other marker, leave the additional info blank. */
                            ?><td></td><?php
                        }
                        ?>
                            <td width="30%">
                                <!--- Saving notes here: -->
    <?php if ($event['Marker'] != '') { ?>
<?php
if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?><a class="helptext" href="javascript:;" onclick="$('#show_notes_<?php echo $event['Property_Progress_ID']; ?>').slideToggle();">Add/edit notes</a><?php } //end access check
} 

if ($USER->site_access_level($SWOP_id) <= $DataEntryAccess){
?>
                                <div id="show_notes_<?php echo $event['Property_Progress_ID']; ?>" style="display:none;"><textarea id="notes_<?php echo $event['Property_Progress_ID']; ?>" cols="30" rows="5"><?php echo $event['Notes']; ?></textarea>
                                    <a class="helptext" href="javascript:;" onclick="
                                                                            $.post(
                                                                                    '../ajax/add_property_marker.php',
                                                                                    {
                                                                                        action: 'save_notes',
                                                                                        event: '<?php echo $event['Property_Progress_ID']; ?>',
                                                                                        note: document.getElementById('notes_<?php echo $event['Property_Progress_ID']; ?>').value
                                                                                    },
                                                                            function(response) {
                                                                                window.location = 'profile.php?history=1';
                                                                                //document.write(response);
                                                                            }
                                                                            ).fail(failAlert);">Save...</a>
                                </div>
<?php
} //end access check
?>
                            </td>
                            <td>
                                <!-- delete a progress step: -->
<?php
if ($USER->site_access_level($SWOP_id) <= $AdminAccess){
?>                                <input type="button" value="Delete" onclick="var check =
                                                                        confirm('This action cannot be undone. Are you sure you want to delete this activity?');
                                                                if (check == true) {
                                                                    $.post(
                                                                            '../ajax/add_property_marker.php',
                                                                            {
                                                                                action: 'delete',
                                                                                id: '<?php echo $event['Property_Progress_ID']; ?>'
                                                                            },
                                                                    function(response) {
                                                                        //document.write(response);
                                                                        window.location = 'profile.php?history=1';
                                                                    }
                                                                    ).fail(failAlert);
                                                                }">
<?php
} //end access check
?></td>
                        </tr>
    <?php
}
include "../include/dbconnclose.php";
?>
                </table>
                <!-- show the hidden rows above (those that are further back than the 5 most recent) -->
                <a href="javascript:;" onclick="$('.extra_prop_history').toggle();">Show more history</a><br>
                <br/><br/>

            </td>
        </tr>

    </table>
</div>
<br/><br/>
<?php
include "../../footer.php"; 
close_all_dbconn();
?>