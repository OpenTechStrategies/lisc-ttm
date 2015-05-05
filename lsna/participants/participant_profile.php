<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($LSNA_id, $DataEntryAccess);

include "../../header.php";
include "../header.php";
include "../include/datepicker.php";
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.edit_basic_info').hide();
        $('.edit_adult_ed').hide();
        $('.edit_attendance').hide();
        $('.add_adult_ed').hide();
        $('#participants_selector').addClass('selected');
        $("a.add_new").hover(function() {
            $(this).addClass("selected");
        }, function() {
            $(this).removeClass("selected");
        });
        $('#participant_search_div').hide();
        $('#new_participant_div').hide();
        $('#participant_profile_div').show();
        $('#add_buttons').hide();
        $('.program_dates').hide();
        $('#all_schools').hide();
        $('.edit_pm_affiliation').hide();
    });
    $(document).ready(function() {
        $('#ajax_loader').hide();
    });

    $(document).ajaxStart(function() {
        $('#ajax_loader').fadeIn('slow');
    });

    $(document).ajaxStop(function() {
        $('#ajax_loader').fadeOut('slow');
    });
</script>

<div id="participant_profile_div">
    <?php

    include "../classes/participants.php";
    $parti = new Participant();
    $parti->load_with_participant_id($_COOKIE['participant']);

    if ($_GET['inst'] == 1) {
        /* loads the page at the institutional affiliations area. */
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                window.location.hash = "institutional_aff";
            });
        </script>
<?php
    }
    ?>



    <h3>Participant Profile: <?php echo $parti->participant_first_name . " " . $parti->participant_last_name; ?></h3><hr/><br/>
    <table class="profile_table">
        <tr>
            <td width="45%" style="padding-right:25px;"><!--Basic Information: everyone will have this-->

                <table class="inner_table" style="border: 2px solid #696969;">
                    <tr>
                        <td width="34%"><strong>Name:</strong></td>
                        <td><span class="show_basic_info"><?php echo $parti->full_name; ?></span>
                            <input type="text" class="edit_basic_info" id="first_name_edit" value="<?php echo $parti->participant_first_name; ?>"/>
                            <input type="text" class="edit_basic_info" id="last_name_edit" value="<?php echo $parti->participant_last_name; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Database ID:</strong></td>
                        <td><?php echo $_COOKIE['participant']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Address:</strong></td>
                        <td><span class="show_basic_info"><?php
if ($parti->address_num != '0') {
    echo $parti->address_full;
}
?></span>
                            <input type="text"  class="edit_basic_info" id="street_address_num_edit" style="width:40px" value="<?php echo $parti->address_num; ?>" />
                            <select class="edit_basic_info" id="street_address_dir_edit" >
                                <option value="">---</option>
                                <option value="N" <?php echo($parti->address_direction == 'N' ? 'selected="selected"' : null); ?>>N</option>
                                <option value="S" <?php echo($parti->address_direction == 'S' ? 'selected="selected"' : null); ?>>S</option>
                                <option value="E" <?php echo($parti->address_direction == 'E' ? 'selected="selected"' : null); ?>>E</option>
                                <option value="W" <?php echo($parti->address_direction == 'W' ? 'selected="selected"' : null); ?>>W</option>
                            </select>
                            <input type="text" class="edit_basic_info" id="street_address_name_edit"  style="width:100px" value="<?php echo $parti->address_street; ?>"/>
                            <input type="text" class="edit_basic_info" id="street_address_type_edit"  style="width:40px" value="<?php echo $parti->address_street_type; ?>"/>
                            <input type="text" class="edit_basic_info" id="city_edit"  style="width:100px" value="<?php echo $parti->city; ?>" />
                            <input type="text" class="edit_basic_info" id="state_edit"  style="width:25px" value="<?php echo $parti->state; ?>"/>
                            <input type="text" class="edit_basic_info" id="zip_edit"  style="width:40px" value="<?php echo $parti->zip; ?>"/><br/>
                            <span class="helptext edit_basic_info">e.g. 2840 N Milwaukee Ave<br/>Chicago, IL 60618</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Ward:</strong></td>
                        <td><span class="show_basic_info"><?php echo $parti->ward; ?></span>
                            <input type="text" class="edit_basic_info" id="ward_edit" value="<?php echo $parti->ward; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Daytime Phone:</strong>
                        </td>
                        <td><span class="show_basic_info"><?php echo $parti->phone_day; ?></span>
                            <input type="text" class="edit_basic_info" id="phone_day_edit" value="<?php echo $parti->phone_day; ?>" />
                        </td>

                    </tr>
                    <tr>
                        <td><strong>Evening Phone:</strong></td>
                        <td><span class="show_basic_info"><?php echo $parti->phone_evening; ?></span>
                            <input type="text" class="edit_basic_info" id="phone_evening_edit" value="<?php echo $parti->phone_evening; ?>"/><br/>
                            <span class="helptext edit_basic_info">Phone numbers must be in the format<br> (xxx) xxx-xxxx</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Role(s): </strong></td>
                        <td><span class="show_basic_info"><?php
                                if ($roles = $parti->get_roles()) {
                                    while ($role = mysqli_fetch_array($roles)) {
                                        echo $role['Role_Title'] . "<br>";
                                        ${$role['Role_ID']} = '1';
                                    }
                                }
                                ?></span>
                            <div class="edit_basic_info">
                                <?php
                                $get_roles = "SELECT * FROM Roles";
                                include "../include/dbconnopen.php";
                                $roles = mysqli_query($cnnLSNA, $get_roles);
                                while ($role = mysqli_fetch_array($roles)) {
                                    ?>
                                    <input type="checkbox" id="role_edit_<?php echo $role['Role_ID']; ?>" 
                                           value="<?php echo $role['Role_ID']; ?>" <?php
                                           if (${$role['Role_ID']} == '1') {
                                               echo "checked";
                                           }
                                           ?>
                                           onchange="handleRole(this)"/><?php echo $role['Role_Title']; ?><br/>
<?php
}
include "../include/dbconnclose.php";
?>
                                <script text="javascript">
                                    /* adds and removes roles onchange of checkboxes. */
                                    function handleRole(cb) {
                                        if (cb.checked == true) {
                                            $.post(
                                                    '../ajax/add_role.php',
                                                    {
                                                        action: 'add',
                                                        role: cb.value,
                                                        user_id: '<?php echo $parti->participant_id; ?>'
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                //window.location = "participants.php";
                                            }
                                            ).fail(failAlert);
                                        }
                                        else if (cb.checked == false) {
                                            $.post(
                                                    '../ajax/add_role.php',
                                                    {
                                                        action: 'remove',
                                                        role: cb.value,
                                                        user_id: '<?php echo $parti->participant_id; ?>'
                                                    },
                                            function(response) {
                                                //document.write(response);
                                                //window.location = "participants.php";
                                            }
                                            ).fail(failAlert);
                                        }
                                    }
                                </script></div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Education Level:</strong></td><td><span class="show_basic_info"><?php
if ($parti->education == 'hs') {
    echo 'High School';
} elseif ($parti->education == 'ged') {
    echo 'GED';
} elseif ($parti->education == 'some_college') {
    echo 'Some college';
} elseif ($parti->education == 'college') {
    echo 'College graduate';
}
?></span>
                            <select id="education_level_edit" class="edit_basic_info" />
                    <option value="">----------</option>
                    <option value="hs">High School</option>
                    <option value="ged">GED</option>
                    <option value="some_college">Some college</option>
                    <option value="college">College graduate</option>
                    </select>
            </td>
        </tr>
        <tr>
            <td><strong>Languages Spoken:</strong></td>
            <td><span class="show_basic_info"><?php
if ($langues = $parti->get_languages()) {
    //print_r($langues);
    while ($lang = mysqli_fetch_array($langues)) {
        echo $lang['Language'] . "<br>";
    }
}
?></span>
                <select id="language_edit" class="edit_basic_info">
                    <option value="">-----</option>
                    <option value="2">Only Spanish</option>
                    <option value="1">Only English</option>
                    <option value="both">Bilingual</option>
                    <option value="other">Other</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><strong>Email Address:</strong></td>
            <td><span class="show_basic_info"><?php echo $parti->email; ?></span>
                <input type="text" id="email_edit" class="edit_basic_info" value="<?php echo $parti->email; ?>" />
            </td>
        </tr>
        <tr>
            <td><strong>Age:</strong></td>
            <td><span class="show_basic_info"><?php echo $parti->age; ?></span>
                <input type="text" id="age_edit" class="edit_basic_info" value="<?php echo $parti->age; ?>" />
            </td>
        </tr>
        <tr>
            <td><strong>Gender:</strong></td>
            <td><span class="show_basic_info"><?php if ($parti->gender == 'm') {
    echo 'Male';
} else if ($parti->gender == 'f') {
    echo 'Female';
} ?></span>
                <select id="gender_edit" class="edit_basic_info" />
        <option value="">--------</option>
        <option value="m" <?php echo($parti->gender == 'm' ? 'selected="selected"' : null); ?>>Male</option>
        <option value="f" <?php echo($parti->gender == 'f' ? 'selected="selected"' : null); ?>>Female</option>
        </select>
        </td>
        </tr>
        <tr>
            <td><strong>Date of Birth:</strong></td>
            <td><span class="show_basic_info"><?php
                    //display date in a different format.
                    date_default_timezone_set('America/Chicago');
                    $date_reformat = explode('-', $parti->dob);
                    $use_date = $date_reformat[2] . '-' . $date_reformat[0] . '-' . $date_reformat[1];
                    if ($use_date != '--' && $use_date != '0000-00-00') {
                        $datetime = new DateTime($use_date);
                        echo date_format($datetime, 'M d, Y');
                    }
                    elseif($use_date == '0000-00-00'){
                        echo $use_date;
                    }
                  //  echo $use_date;
                    ?></span>
                <input type="text" id="dob_edit" class="edit_basic_info hadDatepicker" value="<?php echo $parti->dob; ?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;"><strong>CPS Consent on file?</strong></td>
        </tr>
        <tr>
            <td><strong>School Year 2013-14:</strong></td>
            <td><span class="show_basic_info"><?php
                       if ($parti->consent_2013_14 == "1") {
                           echo "Yes";
                       } else {
                           echo "No";
                       }
                       ?></span>
                <input type="checkbox" id="consent_2013_14_edit" class="edit_basic_info" value="1"
                       <?php
                       if ($parti->consent_2013_14 == "1") {
                           echo "checked=\"checked\"";
                       }
                       ?> />
            </td>
        </tr>
        <tr>
            <td><strong>School Year 2014-15:</strong></td>
            <td><span class="show_basic_info"><?php
                       if ($parti->consent_2014_15 == "1") {
                           echo "Yes";
                       } else {
                           echo "No";
                       }
                       ?></span>
                <input type="checkbox" id="consent_2014_15_edit" class="edit_basic_info" value="1"
                       <?php
                       if ($parti->consent_2014_15 == "1") {
                           echo "checked=\"checked\"";
                       }
                       ?> />
            </td>
        </tr>
        <tr>
            <td><strong>School Year 2015-16:</strong></td>
            <td><span class="show_basic_info"><?php
                       if ($parti->consent_2015_16 == "1") {
                           echo "Yes";
                       } else {
                           echo "No";
                       }
                       ?></span>
                <input type="checkbox" id="consent_2015_16_edit" class="edit_basic_info" value="1"
                       <?php
                       if ($parti->consent_2015_16 == "1") {
                           echo "checked=\"checked\"";
                       }
                       ?> />
            </td>
        </tr>
        <tr>
            <td><strong>Grade Level: </strong></td>
            <td><span class="show_basic_info"><?php
                    if ($parti->grade == 'k') {
                        echo 'Kindergarden';
                    } elseif ($parti->grade == '1') {
                        echo '1st Grade';
                    } elseif ($parti->grade == '2') {
                        echo '2nd Grade';
                    } elseif ($parti->grade == '3') {
                        echo '3rd Grade';
                    } elseif ($parti->grade == '4') {
                        echo '4th Grade';
                    } elseif ($parti->grade == '5') {
                        echo '5th Grade';
                    } elseif ($parti->grade == '6') {
                        echo '6th Grade';
                    } elseif ($parti->grade == '7') {
                        echo '7th Grade';
                    } elseif ($parti->grade == '8') {
                        echo '8th Grade';
                    } elseif ($parti->grade == '9') {
                        echo '9th Grade';
                    } elseif ($parti->grade == '10') {
                        echo '10th Grade';
                    } elseif ($parti->grade == '11') {
                        echo '11th Grade';
                    } elseif ($parti->grade == '12') {
                        echo '12th Grade';
                    } else {
                        echo 'N/A';
                    }
                    ?></span>
                <select id="grade_level_edit" class="edit_basic_info">
                    <option value="">--------</option>
                    <option value="k">Kindergarten</option>
                    <option value="1">1st Grade</option>
                    <option value="2">2nd Grade</option>
                    <option value="3">3rd Grade</option>
                    <option value="4">4th Grade</option>
                    <option value="5">5th Grade</option>
                    <option value="6">6th Grade</option>
                    <option value="7">7th Grade</option>
                    <option value="8">8th Grade</option>
                    <option value="9">9th Grade</option>
                    <option value="10">10th Grade</option>
                    <option value="11">11th Grade</option>
                    <option value="12">12th Grade</option>
			</select>
                </select>
            </td>
        </tr>
        <!--<tr><td><strong>Parent Mentor:</strong></td>
            <td><span class="show_basic_info"><?php
            /*if ($parti->pm ==1){
                echo 'Yes';
                            }
            else{
                echo 'No';
            }?></span>
                <select id="pm_select_edit" class="edit_basic_info">
                    <option value="">--------</option>
                    <option value="1" <?php echo($parti->pm == 1 ? 'selected="selected"' : null) ?>>Yes</option>
                    <option value="0" <?php echo($parti->pm==0 ? 'selected="selected"' :null) */ ?>>No</option>
                </select>
                </td></tr>-->
        <tr><td><strong>Child/Youth:</strong></td>
            <td><span class="show_basic_info"><?php
                if ($parti->child == 1) {
                    echo 'Child';
                }if ($parti->child == 2) {
                    echo 'Youth';
                }if ($parti->child == 3) {
                    echo 'Adult';
                } else {
                    echo '';
                }
                    ?></span>
                <select id="child_select_edit" class="edit_basic_info">
                    <option value="">--------</option>
                    <option value="1" <?php echo($parti->child == 1 ? 'selected="selected"' : null) ?>>Child</option>
                    <option value="2" <?php echo($parti->child == 2 ? 'selected="selected"' : null) ?>>Youth</option>
                    <option value="3" <?php echo($parti->child == 3 ? 'selected="selected"' : null) ?>>Adult</option>
                </select>
            </td>
        </tr>

        <tr><td><strong>Notes:</strong></td>
            <!--Notes save onchange, not based on clicking the save button (just as a reminder).-->
            <td>
<?php
                     if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<textarea id="participant_notes"  onchange="
                                $.post(
                                        '../ajax/save_notes.php',
                                        {
                                            type: 'participant',
                                            id: '<?php echo $parti->participant_id; ?>',
                                            note: this.value
                                        },
                                function(response) {
                                    // document.write(response);
                                    //window.location = 'participant_profile.php';
                                }
                                ).fail(failAlert);"><?php echo $parti->notes; ?></textarea>
<?php
                     }
?>
<br/><p class="helptext">(only 400 characters will be saved in the database)</p></td>
        </tr>

        <tr>
            <td colspan="2">
<?php
                     if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<input type="button" value="Edit"  onclick="
                        $('.edit_basic_info').toggle();
                        $('.show_basic_info').toggle();
                                   " /> <input type="button" value="Save Changes" class="edit_basic_info" onclick="
                $.post(
                        '../ajax/edit_participant.php',
                        {
                            id: '<?php echo $parti->participant_id; ?>',
                            first_name: document.getElementById('first_name_edit').value,
                            last_name: document.getElementById('last_name_edit').value,
                            dob: document.getElementById('dob_edit').value,
                            gender: document.getElementById('gender_edit').value,
                            age: document.getElementById('age_edit').value,
                            consent_2013_14: ($('#consent_2013_14_edit').prop('checked')) ? '1' : '0',
                            consent_2014_15: ($('#consent_2014_15_edit').prop('checked')) ? '1' : '0',
                            consent_2015_16: ($('#consent_2015_16_edit').prop('checked')) ? '1' : '0',
                            grade_level: document.getElementById('grade_level_edit').value,
                            address_num: document.getElementById('street_address_num_edit').value,
                            address_dir: document.getElementById('street_address_dir_edit').options[document.getElementById('street_address_dir_edit').selectedIndex].value,
                            address_name: document.getElementById('street_address_name_edit').value,
                            address_type: document.getElementById('street_address_type_edit').value,
                            education_level: document.getElementById('education_level_edit').options[document.getElementById('education_level_edit').selectedIndex].value,
                            city: document.getElementById('city_edit').value,
                            state: document.getElementById('state_edit').value,
                            zip: document.getElementById('zip_edit').value,
                            ward: document.getElementById('ward_edit').value,
                            email: document.getElementById('email_edit').value,
                            day_phone: document.getElementById('phone_day_edit').value,
                            evening_phone: document.getElementById('phone_evening_edit').value,
                            lang: document.getElementById('language_edit').options[document.getElementById('language_edit').selectedIndex].value,
                            child: document.getElementById('child_select_edit').options[document.getElementById('child_select_edit').selectedIndex].value
                        },
                function(response) {
                    document.getElementById('show_edits').innerHTML = response;
                    window.location = 'participant_profile.php';
                }
                ).fail(failAlert);" />
<?php
                     }
?>
</td>
        </tr>
    </table><br/><br/>
    <div id="show_edits"></div>

    <!--Children and Parents - not everyone will have them, but everyone has the option.-->
    <table class="inner_table">
        <caption><h4>Family Members</h4></caption>
        <tr><th>Relation</th><th>Name</th><th></th></tr>
                <?php
                if ($parents = $parti->get_parents()) {
                    while ($parent = mysqli_fetch_array($parents)) {
                        ?>
                <tr><td>Parent</td>
                    <!--Link to parent's profile: -->
                    <td><a href="javascript:;" onclick="
                               $.post(
                                       '../ajax/set_participant_id.php',
                                       {
                                           page: 'profile',
                                           participant_id: '<?php echo $parent['Participant_ID']; ?>'
                                       },
                               function(response) {
                                   if (response != '1') {
                                       document.getElementById('show_error').innerHTML = response;
                                   }
                                   window.location = 'participant_profile.php';
                               }
                               ).fail(failAlert);
                           "><?php echo $parent['Name_First'] . " " . $parent['Name_Last']; ?></a></td>
                    <!--Button to delete parent.-->
<td>                    
<?php
if ($USER->has_site_access($LSNA_id, $AdminAccess)){
?>
<input type="button" value="Delete" onclick="
                                      $.post(
                                              '../ajax/delete_elements.php',
                                              {
                                                  action: 'family',
                                                  id: '<?php echo $parent['Parent_Mentor_Children_Link_ID']; ?>'
                                              },
                                      function(response) {
                                          window.location = 'participant_profile.php';
                                      }
                                      ).fail(failAlert);">
<?php
}
?>
</td></tr><?php
                    }
                }
                if ($children = $parti->get_children()) {
                    while ($child = mysqli_fetch_array($children)) {
                        ?>
                <tr><td>Child</td>
                    <!--Link to child's profile: -->
                    <td><a href="javascript:;" onclick="
                               $.post(
                                       '../ajax/set_participant_id.php',
                                       {
                                           page: 'profile',
                                           participant_id: '<?php echo $child['Participant_ID']; ?>'
                                       },
                               function(response) {
                                   if (response != '1') {
                                       document.getElementById('show_error').innerHTML = response;
                                   }
                                   window.location = 'participant_profile.php';
                               }
                               ).fail(failAlert);
                           "><?php echo $child['Name_First'] . " " . $child['Name_Last']; ?></a></td>
                    <!--Button to delete child.  Won't delete him/her from db, just deletes the relationship.-->
<td >                    
<?php
if ($USER->has_site_access($LSNA_id, $AdminAccess)){
?>
<input type="button" value="Delete" onclick="
                                $.post(
                                        '../ajax/delete_elements.php',
                                        {
                                            action: 'family',
                                            id: '<?php echo $child['Parent_Mentor_Children_Link_ID']; ?>'
                                        },
                                function(response) {
                                    window.location = 'participant_profile.php';
                                }
                                ).fail(failAlert);">
<?php
}
?>
</td></tr><?php
                            }
                        }
                        
                        if ($spousearr = $parti->get_spouse_of_person()) {
                    while ($spouse = mysqli_fetch_array($spousearr)) {
                        ?>
                <tr><td>Spouse</td>
                    <!--Link to spouse's profile: -->
                    <td><a href="javascript:;" onclick="
                               $.post(
                                       '../ajax/set_participant_id.php',
                                       {
                                           page: 'profile',
                                           participant_id: '<?php echo $spouse['Spouse_ID']; ?>'
                                       },
                               function(response) {
                                   if (response != '1') {
                                       document.getElementById('show_error').innerHTML = response;
                                   }
                                   window.location = 'participant_profile.php';
                               }
                               ).fail(failAlert);
                           "><?php echo $spouse['Name_First'] . " " . $spouse['Name_Last']; ?></a></td>
                    <!--Button to delete child.  Won't delete him/her from db, just deletes the relationship.-->
                  </tr><?php
                            }
                        }
                        if ($spousearr = $parti->get_spouse_of_spouse()) {
                    while ($spouse = mysqli_fetch_array($spousearr)) {
                        ?>
                <tr><td>Spouse</td>
                    <!--Link to spouse's profile: -->
                    <td><a href="javascript:;" onclick="
                               $.post(
                                       '../ajax/set_participant_id.php',
                                       {
                                           page: 'profile',
                                           participant_id: '<?php echo $spouse['Parent_ID']; ?>'
                                       },
                               function(response) {
                                   if (response != '1') {
                                       document.getElementById('show_error').innerHTML = response;
                                   }
                                   window.location = 'participant_profile.php';
                               }
                               ).fail(failAlert);
                           "><?php echo $spouse['Name_First'] . " " . $spouse['Name_Last']; ?></a></td>
                    <!--Button to delete child.  Won't delete him/her from db, just deletes the relationship.-->
</tr><?php
                            }
                        }
                ?>
        <!--search for family member: -->
<tr >        
<?php
if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<td colspan="2"><a class="search_toggle" onclick="
                $('#find_relative').toggle();
                                               "><em>Search to add a parent or child:</em></a></td></tr>
<?php
}
?>
        <tr><td colspan="2"><table class="search_table" id="find_relative" style="display:none;">
                    <tr>
                        <td class="all_projects"><strong>First Name: </strong></td>
                        <td class="all_projects"><input type="text" id="first_name_relative" /></td>
                        <td class="all_projects"><strong>Role: </strong></td>
                        <td class="all_projects"><select id="role_relative">
                                <option value="">--------</option>
<?php
$get_roles = "SELECT * FROM Roles";
include "../include/dbconnopen.php";
$roles = mysqli_query($cnnLSNA, $get_roles);
while ($role = mysqli_fetch_array($roles)) {
    ?>
                                    <option value="<?php echo $role['Role_ID']; ?>"><?php echo $role['Role_Title']; ?></option>
    <?php
}
include "../include/dbconnclose.php";
?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="all_projects"><strong>Last Name: </strong></td>
                        <td class="all_projects"><input type="text" id="last_name_relative" /></td>
                        <td class="all_projects"><strong>Gender: </strong></td>
                        <td class="all_projects">
                            <select id="gender_relative">
                                <option value="">--------</option>
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="all_projects"><strong>Date of Birth: </strong></td>
                        <td class="all_projects"><input type="text" id="dob_relative" class="hasDatepicker" /></td>
                        <td class="all_projects"><strong>Grade Level: </strong></td>
                        <td class="all_projects"><select id="grade_relative">
                                <option value="">--------</option>
                                <option value="k">Kindergarten</option>
                                <option value="1">1st Grade</option>
                                <option value="2">2nd Grade</option>
                                <option value="3">3rd Grade</option>
                                <option value="4">4th Grade</option>
                                <option value="5">5th Grade</option>
                                <option value="6">6th Grade</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="all_projects" colspan="3">
                            <input type="button" value="Search" onclick="
                                $.post(
                                        '../ajax/search_participants.php',
                                        {
                                            result: 'dropdown',
                                            first: document.getElementById('first_name_relative').value,
                                            last: document.getElementById('last_name_relative').value,
                                            dob: document.getElementById('dob_relative').value,
                                            grade: document.getElementById('grade_relative').value,
                                            gender: document.getElementById('gender_relative').options[document.getElementById('gender_relative').selectedIndex].value,
                                            role: document.getElementById('role_relative').options[document.getElementById('role_relative').selectedIndex].value
                                        },
                                function(response) {
                                    document.getElementById('show_results_profile').innerHTML = response;
                                    $('#show_results_profile').show();
                                    $('#add_buttons').show();
                                }
                                ).fail(failAlert);
                                   "/>
                        </td>
                        <td>
                            <!--Quick add is an option if the person sought doesn't show up in the search results: -->
                            <a href="javascript:;" onclick="$('#family_quick_add').toggle();
                                $('#show_results_profile').hide();
                                $('#add_buttons').hide();" class="helptext">
                                Can't find who you're looking for?</a>
                            <div id="family_quick_add" style="display:none;">
                                <table>
                                    <tr><th colspan="2"><strong>Quick Add New Participant</strong></th></tr>
                                    <tr><td><strong>First Name:</strong></td><td><input type="text" id="add_family_first_name" /></td></tr>
                                    <tr><td><strong>Last Name:</strong></td><td><input type="text" id="add_family_last_name" /></td></tr>
                                    <tr><td colspan="2">
                                            <!--This adds the person to the database and links them as a child all in one.-->
                                            <input type="button" value="Add As Child" onclick="
                                                        $.post(
                                                                '../ajax/add_participant.php',
                                                                {
                                                                    parent: '<?php echo $parti->participant_id ?>',
                                                                    first_name: document.getElementById('add_family_first_name').value,
                                                                    last_name: document.getElementById('add_family_last_name').value,
                                                                    add_to_parent: '1'
                                                                },
                                                        function(response) {
                                                            //document.write(response);
                                                            window.location = 'participant_profile.php';
                                                        }
                                                        ).fail(failAlert);">&nbsp;&nbsp;
                                            <!--This adds the person to the database and links them as a parent all in one.-->
                                            <input type="button" value="Add As Parent" onclick="$.post(
                                '../ajax/add_participant.php',
                                {
                                    child: '<?php echo $parti->participant_id ?>',
                                    first_name: document.getElementById('add_family_first_name').value,
                                    last_name: document.getElementById('add_family_last_name').value,
                                    add_to_child: '1'
                                },
                        function(response) {
                            //document.write(response);
                            window.location = 'participant_profile.php';
                        }
                                            ).fail(failAlert);">
                                        <input type="button" value="Add As Spouse" onclick="$.post(
                                '../ajax/add_participant.php',
                                {
                                    person: '<?php echo $parti->participant_id ?>',
                                    first_name: document.getElementById('add_family_first_name').value,
                                    last_name: document.getElementById('add_family_last_name').value,
                                    add_to_spouse: '1'
                                },
                        function(response) {
                            //document.write(response);
                            window.location = 'participant_profile.php';
                        }
                                        ).fail(failAlert);">
                                </table>
                            </div>
                        </td>
                    </tr>
                    <!--shows results from search: -->
                    <tr><td colspan="4"><div id="show_results_profile"></div></td></tr>
                    <tr><td colspan="4" id="add_buttons"><input type="button" value="Add As Child" onclick="
                $.post(
                        '../ajax/add_relative.php',
                        {
                            parent: '<?php echo $parti->participant_id ?>',
                            child: document.getElementById('relative_search').options[document.getElementById('relative_search').selectedIndex].value
                        },
                function(response) {
                    window.location = 'participant_profile.php';
                }
                ).fail(failAlert);">&nbsp;&nbsp;
                            <input type="button" value="Add As Parent" onclick="$.post(
                                '../ajax/add_relative.php',
                                {
                                    child: '<?php echo $parti->participant_id ?>',
                                    parent: document.getElementById('relative_search').value
                                },
                        function(response) {
                            //document.write(response);
                            window.location = 'participant_profile.php';
                        }
                            ).fail(failAlert);">
<input type="button" value="Add As Spouse" onclick="$.post(
                                '../ajax/add_relative.php',
                                {
                                    person: '<?php echo $parti->participant_id ?>',
                                    spouse: document.getElementById('relative_search').value
                                },
                        function(response) {
                            //document.write(response);
                            window.location = 'participant_profile.php';
                        }
).fail(failAlert);">

                        </td></tr>
                </table>
                <br/><br/>
                <h4 id="institutional_aff">Institutional Affiliations</h4>
                <table>
                    <tr>
                        <td><strong>Institution Name</strong></td>
                    </tr>
                            <?php
                            $get_institutions = "SELECT * FROM Institutions INNER JOIN Institutions_Participants ON Institutions.Institution_ID=Institutions_Participants.Institution_ID WHERE Institutions_Participants.Participant_ID='" . $parti->participant_id . "'";
                            include "../include/dbconnopen.php";
                            $institutions = mysqli_query($cnnLSNA, $get_institutions);
                            while ($institution = mysqli_fetch_array($institutions)) {
                                ?>
                        <tr>
                            <td>
                                <a href="javascript:;" onclick="
                                    $.post(
                                            '../ajax/set_institution_id.php',
                                            {
                                                page: 'profile',
                                                id: '<?php echo $institution['Institution_ID']; ?>'
                                            },
                                    function(response) {
                                        //alert(response);
                                        if (response != '1') {
                                            document.getElementById('show_error').innerHTML = response;
                                        }
                                        window.location = '/lsna/institutions/institution_profile.php';
                                    }
                                    ).fail(failAlert);"><?php echo $institution['Institution_Name']; ?></a>
                            </td>
                            <td>
                            </td>
                            <!--delete institutional connection: -->
                            
<?php
if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<td ><input type="button" value="Remove" onclick="
                            $.post(
                                    '../ajax/delete_elements.php',
                                    {
                                        action: 'institution_affiliation',
                                        id: '<?php echo $institution['Institutions_Participants_ID']; ?>'
                                    },
                            function(response) {
                                window.location = 'participant_profile.php';
                            }
                            ).fail(failAlert);"></td>
<?php
}
?>
                        </tr>

    <?php
}
include "../include/dbconnclose.php";
?></table><br/>
                <!--Add a link to a new institution: -->
                <strong>Add institutional affiliation: </strong>
                
<?php
if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<select id="choose_from_all_institutions" >
                    <option value="">-------------</option>
        <?php
        $get_all_institutions = "SELECT * FROM Institutions ORDER BY Institution_Name";
        include "../include/dbconnopen.php";
        $all_institutions = mysqli_query($cnnLSNA, $get_all_institutions);
        while ($institution = mysqli_fetch_array($all_institutions)) {
            ?>
                        <option value="<?php echo $institution['Institution_ID']; ?>"><?php echo $institution['Institution_Name']; ?></option>
            <?php
            include "../include/dbconnclose.php";
        }
        ?>
                </select>

<input type="button" value="Add"  onclick="
        $.post(
                '../ajax/add_participant_to_institution.php',
                {
                    inst: document.getElementById('choose_from_all_institutions').options[document.getElementById('choose_from_all_institutions').selectedIndex].value,
                    parti: '<?php echo $parti->participant_id; ?>'
                },
        function(response) {
            window.location = 'participant_profile.php?inst=1';
        }
        ).fail(failAlert);
                                 ">
<?php
}
?>
</td></tr>
    </table>            
</td>
<!--Program Attendance and involvement.  Pay attention to the parent mentor program especially. -->
<td><h4>Program and Campaign Involvement</h4>
    <table class="inner_table">
                <?php
                $get_program_list = "SELECT * FROM Categories INNER JOIN (Category_Subcategory_Links, Subcategories, Participants_Subcategories) ON
    Categories.Category_ID=Category_Subcategory_Links.Category_ID AND 
    Category_Subcategory_Links.Subcategory_ID=Subcategories.Subcategory_ID
    AND Subcategories.Subcategory_ID=Participants_Subcategories.Subcategory_ID
    WHERE Participant_ID='" . $parti->participant_id . "' ORDER BY Category_Subcategory_Links.Category_ID, Subcategories.Subcategory_Name";
                include "../include/dbconnopen.php";
                $programs = mysqli_query($cnnLSNA, $get_program_list);
                $category = 0;
                while ($program = mysqli_fetch_array($programs)) {
                    if ($category != $program['Category_ID']) {
                        $category = $program['Category_ID'];
                        ?>

                    <?php
                    }
                    //check if this is an adult ed program through Wright college:
                    //note that this category isn't being used at the moment.  We're leaving it here in case they want to return it at some point.
                    //this ends around line 1010
                    if ($program['Category_ID'] == 7) {
                        ?>
                <tr><th colspan="3"><h5><?php echo $program['Category_Name']; ?> - Adult Education</h5></th></tr>
                <tr>
                    <!--Links to adult ed program: -->
                    <th colspan="2"><a style="font-size:1.05em;" href="javascript:;" onclick="
                        $.post(
                                '../ajax/set_program_id.php',
                                {
                                    id: '<?php echo $program['Subcategory_ID']; ?>'
                                },
                        function(response) {
                            //alert(response);
                            if (response != '1') {
                                document.getElementById('show_error').innerHTML = response;
                            }
                            window.location = '/lsna/programs/program_profile.php';
                        }
                        ).fail(failAlert);"><?php echo $program['Subcategory_Name']; ?></a>
                        &nbsp;&nbsp;&nbsp;<a onclick="
                                                                                                          $('.prog_<?php echo $program['Subcategory_ID']; ?>').slideToggle();
                                             " class="helptext">Show/hide program dates</a>
                    </th>
<?php
if ($USER->has_site_access($LSNA_id, $AdminAccess)){
?>
<th >
                        <!--Delete connection to this program: -->
                        <input type="button" value="Delete" onclick="
                           $.post(
                                   '../ajax/delete_elements.php',
                                   {
                                       action: 'program',
                                       id: '<?php echo $program['Participant_Subcategory_ID']; ?>'
                                   },
                           function(response) {
                               window.location = 'participant_profile.php';
                           }
                           ).fail(failAlert);">
                    </th>
<?php
}
?>
</tr>
                <tr  class="program_dates prog_<?php echo $program['Subcategory_ID']; ?>">
                    <td><strong>Date</strong></td>
                    <td><strong>Attended?</strong></td>
                    <td><strong>Type of participation</strong></td>
                </tr>
        <?php
        /* get program dates in order to show attendance: */
        $get_all_dates = "SELECT * FROM Subcategory_Dates WHERE Subcategory_ID='" . $program['Subcategory_ID'] . "'";
        //echo $get_all_dates;
        include "../include/dbconnopen.php";
        $dates = mysqli_query($cnnLSNA, $get_all_dates);
        $i = 0;
        while ($date = mysqli_fetch_array($dates)) {
            ?>
                    <tr class="program_dates prog_<?php echo $program['Subcategory_ID']; ?>">
                        <td><?php
            date_default_timezone_set('America/Chicago');
            $datetime = new DateTime($date['Date']);
            //echo $date . "<br>";
            echo date_format($datetime, 'M d, Y');
            ?></td>
            <?php
            /* show and edit attendance: */
            $did_attend = "SELECT * FROM Subcategory_Attendance WHERE Subcategory_Date='" . $date['Wright_College_Program_Date_ID'] . "' AND Participant_ID='" . $parti->participant_id . "'";
            //   echo $did_attend;
            ?>
                        <td>
<?php
if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<input type="checkbox" id="program_date_<?php echo $program['WC_Program_ID'] ?>_<?php echo $i ?>"  
            <?php
            $attended = mysqli_query($cnnLSNA, $did_attend);
            $did_attend = mysqli_fetch_array($attended);
            if (mysqli_num_rows($attended) > 0) {
                echo 'checked';
            }
            ?> onchange="handleChange(this, '<?php echo $date['Wright_College_Program_Date_ID']; ?>')">
<?php
}
?>
</td>

                    </tr>
                    <!--Add or remove attendance by checking and unchecking the checkboxes next to dates.-->
                    <script text="javascript">

                        function handleChange(cb, date) {
                            // alert("Changed, new value = " + cb.checked);
                            if (cb.checked == true) {
                                //document.write('true/false works');
                                $.post(
                                        '../ajax/add_attendee.php',
                                        {
                                            user_id: '<?php echo $parti->participant_id; ?>',
                                            program_date_id: date
                                        },
                                function(response) {
                                    //document.write(response);
                                    window.location = "participant_profile.php";
                                }
                                ).fail(failAlert);
                            }
                            else if (cb.checked == false) {
                                $.post(
                                        '../ajax/remove_attendee.php',
                                        {
                                            user_id: '<?php echo $parti->participant_id; ?>',
                                            program_date_id: date
                                        },
                                function(response) {
                                    //document.write(response);
                                    window.location = "participant_profile.php";
                                }
                                ).fail(failAlert);
                            }
                //                else{
                //                    document.write('who knows what cb.checked is?? oh, it\'s this: '+cb.checked);
                //                }
                        }
                    </script>
        <?php } ?>
                <!--Asks whether or not this person had an ILP at this program: -->
                <tr>
                    <td><strong>Individual Learning Plan?</strong></td>
                    <td><span class="display_adult_ed"><?php if ($program['ILP_yes_no'] == 1) {
            echo 'Yes';
        } else {
            echo 'No';
        } ?></span>
                        <select id="ilp_switch" class="edit_adult_ed">
                            <option value="">-----</option>
                            <option value="1" <?php echo($program['ILP_yes_no'] == 1 ? 'selected="selected"' : null) ?>>Yes</option>
                            <option value="0" <?php echo($program['ILP_yes_no'] != 1 ? 'selected="selected"' : null) ?>>No</option>
                        </select>
                    </td>
                </tr>
                                        <?php
                                        $growth_rows = $parti->get_growth();
                                        $years = array();
                                        $starts = array();
                                        $ends = array();
                                        $ged = array();
                                        $count = 0;
                                        while ($row = mysqli_fetch_array($growth_rows)) {
                                            $ids[$count] = $row['Participant_Growth_ID'];
                                            $years[$count] = $row['Year'];
                                            $starts[$count] = $row['Start_Level'];
                                            $ends[$count] = $row['End_Level'];
                                            $ged[$count] = $row['GED_Completed'];

                                            $count = $count + 1;
                                        }
                                        ?>
                <!--This table is meant to show this person's progress in the program over time.  Did s/he 
                make progress (complete level or GED) in each year?
                -->
                <tr>
                    <td colspan="2">
                        <table class="inner_table" style="border: 2px solid #696969;font-size: .8em;">
                            <tr>
                                <th>Year</th>
                                <th>Level - <br/>beginning of year</th>
                                <th>Level - <br/>end of year</th>
                                <th>Completed GED?</th>
                                <th></th>
                            </tr>
        <?php for ($i = 0; $i < $count; $i++) { ?>
                                <tr>
                                    <td>
                                        <span class="display_adult_ed"><?php echo $years[$i] . "<br>"; ?></span>

                                        <select id="adult_ed_year_<?php echo $i ?>" class="edit_adult_ed">
                                            <option value="">-----</option>
                                            <?php
                                            date_default_timezone_set('America/Chicago');
                                            $today = time();
                                            ?><option <?php echo ($years[$i] == date('Y', $today) ? 'selected="selected"' : null); ?>><?php echo date('Y', $today); ?></option>
                                            <option <?php echo ($years[$i] == date('Y', strtotime('-1 year')) ? 'selected="selected"' : null); ?>><?php echo date('Y', strtotime('-1 year')) ?></option>
                                            <option <?php echo ($years[$i] == date('Y', strtotime('-2 year')) ? 'selected="selected"' : null); ?>><?php echo date('Y', strtotime('-2 year')); ?></option>
                                            <option <?php echo ($years[$i] == date('Y', strtotime('-3 year')) ? 'selected="selected"' : null); ?>><?php echo date('Y', strtotime('-3 year')) ?></option>
                                            <option <?php echo ($years[$i] == date('Y', strtotime('-4 year')) ? 'selected="selected"' : null); ?>><?php echo date('Y', strtotime('-4 year')); ?></option>
                                        </select>

                                    </td><td>
                                        <span class="display_adult_ed">
            <?php
            if ($starts[$i] == '1') {
                echo "Beginner<br/>";
            } else if ($starts[$i] == '2') {
                echo "Intermediate<br/>";
            } else if ($starts[$i] == '3') {
                echo "Advanced<br/>";
            } else {
                echo "<br/>";
            }
            ?>
                                        </span>
                                        <select id="year_begin_level_<?php echo $i ?>" class="edit_adult_ed">
                                            <option>-----</option>
                                            <option value="1" <?php echo ($starts[$i] == "1" ? 'selected="selected"' : null); ?>>Beginner</option>
                                            <option value="2" <?php echo ($starts[$i] == "2" ? 'selected="selected"' : null); ?>>Intermediate</option>
                                            <option value="3" <?php echo ($starts[$i] == "3" ? 'selected="selected"' : null); ?>>Advanced</option>
                                        </select>


                                    </td>
                                    <td>
                                        <span class="display_adult_ed">
                                        <?php
                                        if ($ends[$i] == '1') {
                                            echo "Beginner<br/>";
                                        } else if ($ends[$i] == '2') {
                                            echo "Intermediate<br/>";
                                        } else if ($ends[$i] == '3') {
                                            echo "Advanced<br/>";
                                        } else {
                                            echo "<br/>";
                                        }
                                        ?></span>
                                        <select id="year_end_level_<?php echo $i ?>" class="edit_adult_ed">
                                            <option>-----</option>
                                            <option value="1" <?php echo ($ends[$i] == "1" ? 'selected="selected"' : null); ?>>Beginner</option>
                                            <option value="2" <?php echo ($ends[$i] == "2" ? 'selected="selected"' : null); ?>>Intermediate</option>
                                            <option value="3" <?php echo ($ends[$i] == "3" ? 'selected="selected"' : null); ?>>Advanced</option>
                                        </select>

                                    </td>
                                    <td>
                                        <span class="display_adult_ed">
            <?php if ($ged[$i] == 1) {
                echo "Yes<br>";
            } else {
                echo 'No<br>';
            }
            ?>
                                        </span>
                                        <select id="completed_ged_<?php echo $i ?>" class="edit_adult_ed">
                                            <option>-----</option>
                                            <option value="1" <?php echo ($ged[$i] == 1 ? 'selected="selected"' : null); ?>>Yes</option>
                                            <option value="2" <?php echo ($ged[$i] !== 1 ? 'selected="selected"' : null); ?>>No</option>
                                        </select>
                                    </td>
                                    <td><input type="button" class="edit_adult_ed" value="Save" onclick="
                                                    $.post(
                                                            '../ajax/edit_growth.php',
                                                            {
                                                                id: '<?php echo $ids[$i]; ?>',
                                                                adult_ed_year: document.getElementById('adult_ed_year_<?php echo $i ?>').options[document.getElementById('adult_ed_year_<?php echo $i ?>').selectedIndex].value,
                                                                start_level: document.getElementById('year_begin_level_<?php echo $i ?>').options[document.getElementById('year_begin_level_<?php echo $i ?>').selectedIndex].value,
                                                                end_level: document.getElementById('year_end_level_<?php echo $i ?>').options[document.getElementById('year_end_level_<?php echo $i ?>').selectedIndex].value,
                                                                ged_completion: document.getElementById('completed_ged_<?php echo $i ?>').options[document.getElementById('completed_ged_<?php echo $i ?>').selectedIndex].value
                                                            },
                                                    function(response) {
                                                        //document.write(response);
                                                        window.location = '/lsna/participants/participant_profile.php';
                                                    }
                                                    ).fail(failAlert);"></td>
                                </tr>
                                        <?php
                                    }
                                    ?>
                            <!--Add past adult ed classes: -->
                            <tr class="add_adult_ed">
                                <td class="add_adult_ed"><select id="adult_ed_year_new">
                                        <option value="">-----</option>
        <?php
        date_default_timezone_set('America/Chicago');
        $today = time();
        ?><option><?php echo date('Y', $today); ?></option>
                                        <option><?php echo date('Y', strtotime('-1 year')) ?></option>
                                        <option><?php echo date('Y', strtotime('-2 year')); ?></option>
                                        <option><?php echo date('Y', strtotime('-3 year')) ?></option>
                                        <option><?php echo date('Y', strtotime('-4 year')); ?></option>
                                    </select></td>
                                <td class="add_adult_ed"><select id="year_begin_level_new">
                                        <option>-----</option>
                                        <option value="1">Beginner</option>
                                        <option value="2">Intermediate</option>
                                        <option value="3">Advanced</option>
                                    </select></td>
                                <td class="add_adult_ed"><select id="year_end_level_new">
                                        <option>-----</option>
                                        <option value="1">Beginner</option>
                                        <option value="2">Intermediate</option>
                                        <option value="3">Advanced</option>
                                    </select></td>
                                <td class="add_adult_ed"><select id="completed_ged_new">
                                        <option>-----</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select></td>
                                <td><input type="button" class="add_adult_ed" value="Save New Year" onclick="
                                $.post(
                                        '../ajax/new_growth.php',
                                        {
                                            id: '<?php echo $parti->participant_id; ?>',
                                            adult_ed_year: document.getElementById('adult_ed_year_new').options[document.getElementById('adult_ed_year_new').selectedIndex].value,
                                            start_level: document.getElementById('year_begin_level_new').options[document.getElementById('year_begin_level_new').selectedIndex].value,
                                            end_level: document.getElementById('year_end_level_new').options[document.getElementById('year_end_level_new').selectedIndex].value,
                                            ged_completion: document.getElementById('completed_ged_new').options[document.getElementById('completed_ged_new').selectedIndex].value,
                                        },
                                        function(response) {
                                            //document.write(response);
                                            window.location = '/lsna/participants/participant_profile.php';
                                        }
                                ).fail(failAlert);"></td>
                            </tr>
                            <tr class="add_adult_ed">
                                <td colspan="5" class="add_adult_ed"><span class="helptext">You must choose a year for this information to save correctly.</span></td>
                            </tr>
                        </table>
                        
<?php
                        if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<input type="button" value="Edit"  onclick="
                                                $('.edit_adult_ed').toggle();
                                                $('.display_adult_ed').toggle();
                               "/>
                        &nbsp;&nbsp;
                        <input type="button" value="Add New Year"   onclick="
                                                $('.add_adult_ed').toggle();
                               " />
<?php
                        }
?>
                    </td>
                </tr>
                        <?php
                    }
                    //if it's not, no need for IEP and credits:
                    //all categories that aren't adult ed:
                    else {
                        // echo "after adult ed: ";
                        // print_r($program);
                        // echo "<br>";
                        ?>
                <!--Show category name and program/campaign name (with link) : -->
                <tr>
                    <th colspan="2"><strong><?php echo $program['Category_Name']; ?> - </strong><a style="font-size:1.05em;" href="javascript:;" onclick="
                        $.post(
                                '../ajax/set_program_id.php',
                                {
                                    id: '<?php echo $program['Subcategory_ID']; ?>'
                                },
                        function(response) {
                            //alert(response);
                            if (response != '1') {
                                document.getElementById('show_error').innerHTML = response;
                            }
                            window.location = '/lsna/programs/program_profile.php';
                        }
                        ).fail(failAlert);"><?php echo $program['Subcategory_Name']; ?></a>
                    <?php
                    /* if this is the parent mentor program, show the schools and years for which this person has been involved: */
                    if ($program['Subcategory_ID'] == 19) {
                        ?><br>

                        <?php
                        $get_years_schools = "SELECT Institution_Name, Year, PM_Year_ID, School FROM PM_Years
                    INNER JOIN Institutions ON School=Institution_ID WHERE Participant=$parti->participant_id ORDER BY Year;";
                        include "../include/dbconnopen.php";
                        $years_schools = mysqli_query($cnnLSNA, $get_years_schools);
                        while ($yr = mysqli_fetch_row($years_schools)) {
                            $show_year = str_split($yr[1], 2);
                            /* school  |  school year */
                            echo $yr[0] . ' &nbsp;&nbsp;|&nbsp;&nbsp; 20', $show_year[0] . '-20' . $show_year[1];
                            ?>
                                <!--Edit school and year right here!-->
                                <a href="javascript:;" onclick="$('#edit_pm_year_<?php echo $yr[2] ?>').toggle();">Edit</a>
<?php
                        if ($USER->has_site_access($LSNA_id, $AdminAccess)){
?>
<a href="javascript:;" onclick="                           $.post(
                                   '../ajax/delete_elements.php',
                                   {
                                       action: 'pm_year',
                                       id: '<?php echo $yr[2]; ?>'
                                   },
                           function(response) {
                               window.location='participant_profile.php';
                           }
                           )">Delete School and Year</a>
<?php
                        } //end access check
?>
                        <div id="edit_pm_year_<?php echo $yr[2] ?>" class="edit_pm_affiliation" style="font-weight: normal;">
                            <select id="edit_school_<?php echo $yr[2] ?>"><option value="">------</option>
                        <?php
                        $get_schools = "SELECT * FROM Institutions WHERE Institution_Type='1' ORDER BY Institution_Name";
                        include "../include/dbconnopen.php";
                        $schools = mysqli_query($cnnLSNA, $get_schools);
                        while ($school = mysqli_fetch_array($schools)) {
                            ?>
                                    <option value="<?php echo $school['Institution_ID']; ?>" <?php echo ($yr[3] == $school['Institution_ID'] ? 'selected=="selected"' : null) ?>><?php echo $school['Institution_Name']; ?></option>
                                <?php
                            }
                            include "../include/dbconnclose.php";
                            ?>

                            </select>&nbsp;&nbsp;|&nbsp;&nbsp;
                            <?php
                            ?>
                            <select id="edit_year_<?php echo $yr[2] ?>"><option value="">------</option>

                                <option value="1011" <?php echo ($yr[1] == 1011 ? 'selected=="selected"' : null) ?>>2010-11</option>
                                <option value="1112" <?php echo ($yr[1] == 1112 ? 'selected=="selected"' : null) ?>>2011-12</option>
                                <option value="1213" <?php echo ($yr[1] == 1213 ? 'selected=="selected"' : null) ?>>2012-13</option>
                                <option value="1314" <?php echo ($yr[1] == 1314 ? 'selected=="selected"' : null) ?>>2013-14</option>
                                <option value="1415" <?php echo ($yr[1] == 1415 ? 'selected=="selected"' : null) ?>>2014-15</option>
                                <option value="1516" <?php echo ($yr[1] == 1516 ? 'selected=="selected"' : null) ?>>2015-16</option>
                                <option value="1617" <?php echo ($yr[1] == 1617 ? 'selected=="selected"' : null) ?>>2016-17</option>
                            </select>
                            <a href="javascript:;" onclick="
                        $.post(
                                '../ajax/alter_pm_affiliation.php',
                                {
                                    school: document.getElementById('edit_school_<?php echo $yr[2] ?>').value,
                                    year: document.getElementById('edit_year_<?php echo $yr[2] ?>').value,
                                    id: '<?php echo $yr[2]; ?>'
                                },
                        function(response) {
                            //document.write(response);
                            window.location = 'participant_profile.php';
                        }
                        ).fail(failAlert);">Save Changes</a>
                            <!--end edit school and year-->
                        </div>
                                    <?php
                                    echo "<br>";
                                    //  echo "before delete: ";
                                    //  print_r($program);
                                }
                                //  include "../include/dbconnclose.php";
                            }/* end parent mentor program special case. */
                            ?>

                <!--show/hide program dates and attendance: -->
                &nbsp;&nbsp;&nbsp;<a onclick="
                                $('.prog_<?php echo $program['Subcategory_ID']; ?>').slideToggle();
                                     " class="helptext">Show/hide program dates</a></th>
<?php
                if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<th >
                    <input type="button" value="Delete Program" onclick="
                           $.post(
                                   '../ajax/delete_elements.php',
                                   {
                                       action: 'subcategory',
                                       id: '<?php echo $program['Participant_Subcategory_ID']; ?>'
                                   },
                           function(response) {
                               window.location='participant_profile.php';
                           }
                           ).fail(failAlert);">
                </th>
<?php
                }
?>
                </tr>
                                    <?php
                                    //PM program attendance
                                    /* again, the parent mentor program is a special case.  Their attendance is number of days attended 
                                     * versus number of possible days in that month.  It doesn't reference specific dates.
                                     */
                                    if ($program['Subcategory_ID'] == 19) {
                                        $show_surveys = 1;
                                        ?>
                    <tr><td colspan="4" style="border:0;">
                            <!--Show possible and actual number of days attended for parent mentors: -->
                            <table class="inner_table prog_<?php echo $program['Subcategory_ID']; ?> program_dates" 
                                   id="attendance_table" style="font-size:.9em;">
                                <tr><th width="20%">Month</th><th width="20%">Year</th><th width="20%"># Days Attended</th><th width="20%"># Days Possible</th><th></th></tr>
            <?php
            date_default_timezone_set('America/Chicago');
            $month_array = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            $get_this_year_months = "SELECT * FROM PM_Possible_Attendance WHERE Year='" . date('Y') . "'";
            include "../include/dbconnopen.php";
            $this_year_months = mysqli_query($cnnLSNA, $get_this_year_months);
            // echo $this_year_months;
            /* this might be a problem.  I think PM_Possible_Attendance may only include possible days for 
             * 2013.  Definitely trouble spot to look for.
             */
            while ($month_loop = mysqli_fetch_array($this_year_months)) {
                ?><tr>
                                        <td><?php echo $month_array[$month_loop['Month'] - 1]; ?></td>
                                        <td><?php echo $month_loop['Year']; ?></td>
                                        <td><?php
                                $get_attendance = "SELECT Num_Days_Attended FROM PM_Actual_Attendance WHERE Parent_Mentor_ID='" . $parti->participant_id . "' 
                                                    AND Possible_Attendance_ID='" . $month_loop['PM_Possible_Attendance_ID'] . "'";
                                $attendance = mysqli_query($cnnLSNA, $get_attendance);
                                $att = mysqli_fetch_row($attendance);
                                ?><span class="display_attendance"><?php echo $att[0]; ?></span>
                                            <input type="text" id="attended_days_<?php echo $month_loop['PM_Possible_Attendance_ID']; ?>" class="edit_attendance" style="width:30px;" value="<?php echo $att[0]; ?>"></td>
                                        <td><?php echo $month_loop['Max_Days_Possible']; ?></td>
                                        <td>
                                            
<?php
 if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<input type="button" value="Edit"   onclick="$('.edit_attendance').toggle();
 $('.display_attendance').toggle();">
                                            <input type="button" value="Save" class="edit_attendance" onclick="
                                                                                    $.post(
                                                                                            '../ajax/save_pm_attendance.php',
                                                                                            {
                                                                                                pm_id: '<?php echo $parti->participant_id ?>',
                                                                                                days: document.getElementById('attended_days_<?php echo $month_loop['PM_Possible_Attendance_ID']; ?>').value,
                                                                                                possible_id: <?php echo $month_loop['PM_Possible_Attendance_ID']; ?>
                                                                                            },
                                                                                    function(response) {
                                                                                        window.location = 'participant_profile.php';
                                                                                    }
                                                                                    ).fail(failAlert);">
<?php
 }
?>
                                        </td>
                                    </tr><?php
                                    }
                                    ?>
                            </table></td></tr>
                                <?php
                                }
                                /* end parent mentor program special case */ else {
                                    ?>
                    <!--show the dates of this program or campaign.  the checkbox indicates the person's attendance or absence: -->
                    <tr class="prog_<?php echo $program['Subcategory_ID']; ?> program_dates">
                        <td><strong>Date</strong></td>
                        <td><strong>Attended?</strong></td>
            <?php if ($program['Campaign_or_Program'] == 'Campaign') { ?><td><strong>Type of participation</strong></td><?php } ?>
                    </tr>
            <?php
            $get_all_dates = "SELECT * FROM Subcategory_Dates WHERE Subcategory_ID='" . $program['Subcategory_ID'] . "'";
            //echo $get_all_dates;
            include "../include/dbconnopen.php";
            $dates = mysqli_query($cnnLSNA, $get_all_dates);
            $i = 0;
            while ($date = mysqli_fetch_array($dates)) {
                ?>
                        <tr class="prog_<?php echo $program['Subcategory_ID']; ?> program_dates">
                            <td><?php
                date_default_timezone_set('America/Chicago');
                $datetime = new DateTime($date['Date']);
                //echo $date . "<br>";
                echo date_format($datetime, 'M d, Y');
                ?></td>
                <?php
                $did_attend = "SELECT * FROM Subcategory_Attendance WHERE Subcategory_Date='" . $date['Wright_College_Program_Date_ID'] . "' AND Participant_ID='" . $parti->participant_id . "'";
                $attended = mysqli_query($cnnLSNA, $did_attend);
                $attend = mysqli_fetch_array($attended);
                ?>
                            <td>
<?php
if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<input type="checkbox"   id="program_date_<?php echo $program['WC_Program_ID'] ?>_<?php echo $i ?>" 
                <?php
                if (mysqli_num_rows($attended) > 0) {
                    echo 'checked';
                }
                ?> onchange="handleChange(this, '<?php echo $date['Wright_College_Program_Date_ID']; ?>')">
<?php
}
?>
</td>
                <?php if ($program['Campaign_or_Program'] == 'Campaign') { ?><td>
                                    <!--Can edit the event role here: -->
<?php
if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
                                    <select id="participation_type_<?php echo $date['Wright_College_Program_Date_ID']; ?>" onchange="
                                                        var role = this.value;
                                                        $.post(
                                                                '../ajax/save_attendee_role.php',
                                                                {
                                                                    role: role,
                                                                    attendee_date: '<?php echo $attend['Subcategory_Attendance_ID']; ?>'
                                                                },
                                                        function(response) {
                                                            //document.write(response);
                                                            window.location = 'participant_profile.php';
                                                        }
                                                        ).fail(failAlert);
                                            ">
                                        <option value="">----------</option>
                                        <option value="1" <?php echo ($attend['Type_of_Participation'] == '1' ? 'selected="selected"' : null); ?>>Attendee</option>
                                        <option value="2" <?php echo ($attend['Type_of_Participation'] == '2' ? 'selected="selected"' : null); ?>>Speaker</option>
                                        <option value="3" <?php echo ($attend['Type_of_Participation'] == '3' ? 'selected="selected"' : null); ?>>Chairperson</option>
                                        <option value="4" <?php echo ($attend['Type_of_Participation'] == '4' ? 'selected="selected"' : null); ?>>Prep work</option>
                                    </select>
<?php
} //end access check
?>
                                </td><?php } ?>
                        </tr>
                        <!--Add or remove attendance function: -->
                        <script text="javascript">

                            function handleChange(cb, date) {
                                if (cb.checked == true) {
                                    //document.write('true/false works');
                                    $.post(
                                            '../ajax/add_attendee.php',
                                            {
                                                user_id: '<?php echo $parti->participant_id; ?>',
                                                program_date_id: date
                                            },
                                    function(response) {
                                        //document.write(response);
                                        window.location = "participant_profile.php";
                                    }
                                    ).fail(failAlert);
                                }
                                else if (cb.checked == false) {
                                    $.post(
                                            '../ajax/remove_attendee.php',
                                            {
                                                user_id: '<?php echo $parti->participant_id; ?>',
                                                program_date_id: date
                                            },
                                    function(response) {
                                        //document.write(response);
                                        window.location = "participant_profile.php";
                                    }
                                    ).fail(failAlert);
                                }
                            }
                        </script>
                        <?php }
                    }/* ends non-parent-mentor programs */
                    ?>

                <?php //ends the non-adult-ed case
            }
            ?>
            <tr><td colspan="2" class="blank"><br/></td></tr>

            <?php
            //ends "while" that looped through all programs and campaigns:
        }
        ?>
    </table>
    <!--Add person to new program or campaign -->
    
<?php
if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<strong  >Add to Program:</strong>
    <select id="choose_from_all_programs"  onchange="
        var prog = this.value;
        /*special case for the parent mentor program (see below)*/
        if (prog == 19) {
            $('#all_schools').show();
        }
            " >
        <option value="">------</option>
    <?php
    $get_all_programs = "SELECT * FROM Subcategories ORDER BY Subcategory_Name";
    include "../include/dbconnopen.php";
    $programs = mysqli_query($cnnLSNA, $get_all_programs);
    while ($program = mysqli_fetch_array($programs)) {
        ?>
            <option value="<?php echo $program['Subcategory_ID']; ?>"><?php echo $program['Subcategory_Name']; ?></option>
        <?php
    }
    include "../include/dbconnclose.php";
    ?>
    </select>
<?php
}
?>
<br/>
    <!--special parent mentor program case.  Users must assign PMs to a school and year by using these dropdowns: -->
    <div id="all_schools">
        <span class="helptext">You must choose a school when adding someone to the parent mentor program.</span><br>
        <select id="school_chosen"><option value="">------</option>
    <?php
    $get_schools = "SELECT * FROM Institutions WHERE Institution_Type='1' ORDER BY Institution_Name";
    include "../include/dbconnopen.php";
    $programs = mysqli_query($cnnLSNA, $get_schools);
    while ($program = mysqli_fetch_array($programs)) {
        ?>
                <option value="<?php echo $program['Institution_ID']; ?>"><?php echo $program['Institution_Name']; ?></option>
    <?php
}
include "../include/dbconnclose.php";
?>

        </select><br/>
        <?php
//get the date so that you can find the school year (automatically sets year to the current school year)
        $this_month = date('m');
        $this_year = date('Y');
        if ($this_month > 7) {
            $school_year = $this_year + 1;
        } else {
            $school_year = $this_year;
        }
//$school_year=2011;
        ?>
        <select id="year_chosen"><option value="">------</option>

            <option value="1011" <?php echo ($school_year == 2011 ? 'selected=="selected"' : null) ?>>2010-11</option>
            <option value="1112" <?php echo ($school_year == 2012 ? 'selected=="selected"' : null) ?>>2011-12</option>
            <option value="1213" <?php echo ($school_year == 2013 ? 'selected=="selected"' : null) ?>>2012-13</option>
            <option value="1314" <?php echo ($school_year == 2014 ? 'selected=="selected"' : null) ?>>2013-14</option>
            <option value="1415" <?php echo ($school_year == 2015 ? 'selected=="selected"' : null) ?>>2014-15</option>
            <option value="1516" <?php echo ($school_year == 2016 ? 'selected=="selected"' : null) ?>>2015-16</option>
            <option value="1617" <?php echo ($school_year == 2017 ? 'selected=="selected"' : null) ?>>2016-17</option>
        </select><br/>

    </div>

    <!--Add to program here.  -->
    
<?php
if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<input type="button" value="Add to Program"   onclick="
        var program = document.getElementById('choose_from_all_programs').options[document.getElementById('choose_from_all_programs').selectedIndex].value;
        if (program == 19) {
            var school = document.getElementById('school_chosen').value;
            var year = document.getElementById('year_chosen').value;
        }
        else {
            var school = null;
            var year = null;
        }
        $.post(
                '../ajax/add_participant_to_program.php',
                {
                    subcategory: document.getElementById('choose_from_all_programs').options[document.getElementById('choose_from_all_programs').selectedIndex].value,
                    participant: '<?php echo $parti->participant_id; ?>',
                    school: school,
                    year: year
                },
        function(response) {
            window.location = 'participant_profile.php';
        }
        ).fail(failAlert);">

    <!--Quick link to add a new program to the DB: -->
    <p class="helptext">Can't find the program you're looking for?  <a href="../programs/new_program.php" >Create a new one!</a></p>
<?php
}
?>
    <br/>
<?php
//if this participant is a child, show this table (shows academic records)

if ($parti->child == '1') {
    ?>
        <h4>School Records</h4>
        <table class="inner_table" id="school_records">
            <tr style="font-size:.8em;"><th>School Year</th><th>Quarter</th><th>Reading Grade</th><th>Math Grade</th><th>Number of Suspensions</th>
                <th>Number of Office Referrals</th><th>Days Absent</th><th></th></tr>
    <?php
    /* shows all school records: */
    $find_if_child = "SELECT * FROM PM_Children_Info WHERE Child_ID='" . $parti->participant_id . "'";
    include "../include/dbconnopen.php";
    $if_child = mysqli_query($cnnLSNA, $find_if_child);
    while ($child = mysqli_fetch_array($if_child)) {
        ?>
                <tr>
                    <td><?php echo $child['School_Year']; ?>
                    <td><?php echo $child['Quarter']; ?></td>
                    <td><?php echo $child['Reading_Grade']; ?></td>
                    <td><?php echo $child['Math_Grade']; ?></td>
                    <td><?php echo $child['Num_Suspensions']; ?></td>
                    <td><?php echo $child['Num_Office_Referrals']; ?></td>
                    <td><?php echo $child['Days_Absent']; ?></td>
                    <td></td>
                </tr>
                        <?php
                    }
                    ?>
            <!--Add new school records: -->
            <tr>
                <td><select id="school_year_new">
                        <option value="">----------</option>
                        <option value="2012-2013">2012-2013</option>
                        <option value="2013-2014">2013-2014</option>
                        <option value="2014-2015">2014-2015</option>
                        <option value="2015-2016">2015-2016</option>
                    </select>
                </td>
                <td><select id="quarter_new">
                        <option value="">---</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </td>
                <td><select id="reading_new"><option value="n/a">-----</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="F">F</option>
                    </select></td>
                <td><select id="math_new"><option value="n/a">-----</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="F">F</option>
                    </select></td>
                <td><input type="text" style="width:20px;" id="suspensions_new"/></td>
                <td><input type="text" style="width:20px;" id="referrals_new"/></td>
                <td><input type="text" style="width:20px;" id="absent_new"/></td>
                <td><a href="javascript:;" class="helptext" onclick="
                            $.post(
                                    '../ajax/add_school_records.php',
                                    {
                                        participant: <?php echo $parti->participant_id; ?>,
                                        school_year: document.getElementById('school_year_new').value,
                                        quarter: document.getElementById('quarter_new').value,
                                        reading: document.getElementById('reading_new').value,
                                        math: document.getElementById('math_new').value,
                                        suspensions: document.getElementById('suspensions_new').value,
                                        referrals: document.getElementById('referrals_new').value,
                                        days_absent: document.getElementById('absent_new').value
                                    },
                            function(response) {
                                window.location = 'participant_profile.php';
                            }
                            ).fail(failAlert);">Add...</a></td>
            </tr>

        </table><br/><br/>
            <?php
            include "../include/dbconnclose.php";
        }

        /* this was the module that showed parent mentor attendance, but that was evidently moved up to the program and campaign
         * involvement section.  Ignore this. */
        if ($parti->pm == 1) {
            ?>

        <!--<h4>Parent-Mentor Attendance</h4>
        <table class="inner_table">
            <tr><th>Month</th><th>Year</th><th># Days Attended</th><th># Days Possible</th></tr>
            <?
            $month_array=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $get_this_year_months = "SELECT * FROM PM_Possible_Attendance WHERE Year='" . date('Y') . "'";
        
        include "../include/dbconnopen.php";
        $this_year_months = mysqli_query($cnnLSNA, $get_this_year_months);
        while ($month_loop=mysqli_fetch_array($this_year_months)){
        
                ?><tr>
                    <td><?php echo $month_array[$month_loop['Month'] - 1]; ?></td>
                    <td><?php echo $month_loop['Year']; ?></td>
                    <td><?php
            $get_attendance = "SELECT Num_Days_Attended FROM PM_Actual_Attendance WHERE Parent_Mentor_ID='" . $parti->participant_id . "' 
                AND Possible_Attendance_ID='" . $month_loop['PM_Possible_Attendance_ID'] . "'";
            $attendance = mysqli_query($cnnLSNA, $get_attendance);
            $att = mysqli_fetch_row($attendance);
            ?><span class="display_attendance"><?php echo $att[0]; ?></span>
                        <input type="text" id="attended_days_<?php echo $month_loop['PM_Possible_Attendance_ID']; ?>" class="edit_attendance"></td>
                    <td><?php echo $month_loop['Max_Days_Possible']; ?></td>
                    <td>
                        <input type="button" value="Edit" onclick="$('.edit_attendance').toggle();
                               $('.display_attendance').toggle();">
                        <input type="button" value="Save" class="edit_attendance" onclick="
                               $.post(
                                '../ajax/save_pm_attendance.php',
                                {
                                    pm_id: '<?php echo $parti->participant_id ?>',
                                    days: document.getElementById('attended_days_<?php echo $month_loop['PM_Possible_Attendance_ID']; ?>').value,
                                    possible_id: <?php echo $month_loop['PM_Possible_Attendance_ID']; ?>
                                },
                                function (response){
                                    window.location = 'participants.php';
                                }
                               ).fail(failAlert);"></td>
                </tr><?
            }
            include "../include/dbconnclose.php";
        ?>
        
        </table>
        <br/><br/>-->    <?php } ?>

    <!--Shows all linked surveys.  Mostly relevant for parent mentors, but satisfaction surveys are for everyone: -->
    <table class="inner_table"><tr><th colspan="2"><h4>Linked Surveys</h4></th></tr>
        <?php
        //if ($show_surveys==1) {
        ?>
        <tr><th colspan="2">Parent Mentor Surveys:</th></tr>
        <?php
        /* show all existing parent mentor surveys, with links to view/edit. */
        $get_pm_surveys = "SELECT * FROM Parent_Mentor_Survey INNER JOIN Institutions ON Parent_Mentor_Survey.School=Institutions.Institution_ID WHERE Participant_ID=$parti->participant_id";
        //echo $get_pm_surveys;
        include "../include/dbconnopen.php";
        $pm_surveys = mysqli_query($cnnLSNA, $get_pm_surveys);
        while ($surveys = mysqli_fetch_array($pm_surveys)) {
            $date_reformat = explode('-', $surveys['Date']);
            $use_date = $date_reformat[1] . '-' . $date_reformat[2] . '-' . $date_reformat[0];
            ?>
            <tr><td><?php echo $surveys['Institution_Name'] . ": " . $use_date; ?></td><td>
<?php
                if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<a href="new_parent_mentor_survey.php?survey=<?php echo $surveys['Parent_Mentor_Survey_ID']; ?>"  >Edit</a></td></tr>
            <?php
} //end of access check
        }
        include "../include/dbconnopen.php";
        ?>
        <!--Add a new parent mentor survey: -->
        <tr><td colspan="2">
<?php
                if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<a href="new_parent_mentor_survey.php">Add New Parent Mentor Survey</a>
<?php
}
?>
<br/><br/></td></tr>
        <tr><th colspan="2">Teacher Surveys (About This Parent Mentor):</th></tr>
        <?php
        /* show all existing teacher surveys: */
        $get_pm_surveys = "SELECT * FROM PM_Teacher_Survey INNER JOIN Institutions ON PM_Teacher_Survey.School_Name=Institutions.Institution_ID WHERE Parent_Mentor_ID=$parti->participant_id";
        include "../include/dbconnopen.php";
        $pm_surveys = mysqli_query($cnnLSNA, $get_pm_surveys);
        while ($surveys = mysqli_fetch_array($pm_surveys)) {
            $this_date = explode('-', $surveys['Date_Entered']);
            $show_date = mktime(0, 0, 0, $this_date[1], $this_date[2], $this_date[0]);
            $display_date = date('n-j-Y', $show_date);
            ?>
            <tr><td><?php echo $surveys['Institution_Name'] . ": " . $display_date; ?></td>
<?php
                if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
                <td>
<a href="new_pm_teacher_survey.php?survey=<?php echo $surveys['PM_Teacher_Survey_ID']; ?>"  >Edit</a></td>
<?php
}
?>
</tr>
            <?php
        }
        include "../include/dbconnopen.php";
        ?>

                <?php
                /* show all existing POST teacher surveys.  these are pulled from a different table since they include
                 * different questions.
                 */
                $get_pm_surveys = "SELECT * FROM PM_Teacher_Survey_Post INNER JOIN Institutions ON PM_Teacher_Survey_Post.School_Name=Institutions.Institution_ID WHERE Parent_Mentor_ID=$parti->participant_id";
                include "../include/dbconnopen.php";
                $pm_surveys = mysqli_query($cnnLSNA, $get_pm_surveys);
                while ($surveys = mysqli_fetch_array($pm_surveys)) {
                    $this_date = explode('-', $surveys['Date_Entered']);
                    $show_date = mktime(0, 0, 0, $this_date[1], $this_date[2], $this_date[0]);
                    $display_date = date('n-j-Y', $show_date);
                    ?>
            <tr><td><?php echo $surveys['Institution_Name'] . ": " . $display_date; ?></td>
<?php
                if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<td><a href="pm_teacher_survey_post.php?survey=<?php echo $surveys['Post_Teacher_Survey_ID']; ?>"  >Edit</a></td>
<?php
}
?>
</tr>
            <?php
        }
        include "../include/dbconnopen.php";
        ?>
        <!--Add new teacher surveys about this person.-->
        <tr>
<?php
if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<td colspan="2" >Add New Teacher Survey: <a href="new_pm_teacher_survey.php">Pre</a>
                or <a href="pm_teacher_survey_post.php">Post</a></td>
<?php
}
?>
</tr>
        <tr><th colspan="2">Satisfaction Surveys:</th></tr>
                <?php
                /* view and edit all satisfaction surveys: */
                $get_pm_surveys = "SELECT * FROM Satisfaction_Surveys INNER JOIN Subcategories ON Satisfaction_Surveys.Program_ID =Subcategories.Subcategory_ID 
             WHERE Participant_ID=$parti->participant_id";

                include "../include/dbconnopen.php";
                $pm_surveys = mysqli_query($cnnLSNA, $get_pm_surveys);
                while ($surveys = mysqli_fetch_array($pm_surveys)) {
                    $date_reformat = explode('-', $surveys['Date']);
                    $use_date = $date_reformat[1] . '-' . $date_reformat[2] . '-' . $date_reformat[0];
                    ?>
            <tr><td><?php echo $surveys['Subcategory_Name'] . ": " . $use_date; ?></td><td>
<?php
if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<a   href="/lsna/programs/new_satisfaction_survey.php?survey=<?php echo $surveys['Satisfaction_Survey_ID']; ?>">View/Edit</a>
<?php
}
?></td></tr>
    <?php
}
include "../include/dbconnopen.php";
?>
        <!--Add new satisfaction survey: -->
        <tr>
<?php
if ($USER->has_site_access($LSNA_id, $DataEntryAccess)){
?>
<td colspan="2" ><a href="/lsna/programs/new_satisfaction_survey.php">Add New Satisfaction Survey</a></td>
<?php
}
?></tr>
    </table>
    <br/><br/>
    <!--These are short notes that can be entered over time to show participant progress: -->
    <h4>Goals and Development Sessions</h4>
    <table class="profile_table">
        <tr><th>Date</th><th>Notes</th><th></th></tr>
<?php
//get all dates/notes entered for this participant
$get_goals = "SELECT MONTH(Development_Date), DAY(Development_Date), YEAR(Development_Date), Notes, Goals_Development_ID
                        FROM Goals_Development WHERE Participant_ID='$parti->participant_id' ORDER BY Development_Date";
include "../include/dbconnopen.php";
$goals = mysqli_query($cnnLSNA, $get_goals);
while ($go = mysqli_fetch_row($goals)) {
    ?>
            <tr><td><?php echo $go[0] ?>-<?php echo $go[1] ?>-<?php echo $go[2] ?></td><td><?php echo $go[3]; ?></td>
                <td>
<?php
if ($USER->has_site_access($LSNA_id, $AdminAccess)){
?>
<input type="button"  value="Delete Session" onclick="
                                    $.post(
                                            '../ajax/save_goal_dev.php',
                                            {
                                                action: 'delete',
                                                id: '<?php echo $go[4] ?>'
                                            },
                                    function(response) {
                                        window.location = 'participant_profile.php';
                                    }
                                    ).fail(failAlert);">
<?php
}
?>
                </td></tr>
            <?php
        }
        include "../include/dbconnclose.php";
        ?>
        <!--Add a new date/note: -->
        <tr><td colspan="4" style="margin:0;padding:0;"><em><b>Add new development meeting:</b></em></td></tr>
        <tr><td>Date:<input type="text" id="new_dev_date" class="hadDatepicker"></td><td>Notes:&nbsp<span class="helptext">Notes 
                    may not exceed 600 characters.</span><br>
                <textarea id="new_dev_notes" rows="5" cols="40"></textarea><br>
                <input type="button" value="Save Meeting Details" onclick="$.post(
                                        '../ajax/save_goal_dev.php',
                                        {
                                            action: 'new',
                                            person: '<?php echo $parti->participant_id; ?>',
                                            date: document.getElementById('new_dev_date').value,
                                            notes: document.getElementById('new_dev_notes').value
                                        },
                                function(response) {
                                    window.location = 'participant_profile.php';
                                    //document.getElementById('dev_date_resp').innerHTML=response;
                                }
                ).fail(failAlert);">
                <br><span id="dev_date_resp"></span></td><td></td>
        </tr>
    </table>
</td>
</tr>

    <?php
/* if this person is a parent mentor, create a graph that shows change over time in the surveys they have completed: */

$find_if_pm = "SELECT * FROM Participants_Subcategories WHERE Participant_ID='" . $parti->participant_id . "' AND Subcategory_ID='19'";
include "../include/dbconnopen.php";
$if_pm = mysqli_query($cnnLSNA, $find_if_pm);
$is_pm = mysqli_num_rows($if_pm);
if ($is_pm > 0) {
    ?> <tr><td colspan="2"><h4>Parent Mentor Survey - Changes over Time</h4>
    <?php
    /* get the survey questions that users want to display in this chart: */
    $get_surveys = "SELECT Student_Involvement_B, Student_Involvement_H, School_Network_I,
               School_Network_J, School_Involvement_M, School_Involvement_P, School_Involvement_Q, Self_Efficacy_Q, Pre_Post
               FROM Parent_Mentor_Survey WHERE Participant_ID=$parti->participant_id";
    //echo $get_surveys . "<br>";
    include "../include/dbconnopen.php";
    $all_survey = mysqli_query($cnnLSNA, $get_surveys);
    /* set these to empty brackets initially so that the chart will still work even if one or more of them
     * isn't filled in.
     */
    $pre_survey = '[]';
    $mid_survey = '[]';
    $post_survey = '[]';
    while ($survey = mysqli_fetch_row($all_survey)) {
        $script_str = '';
        $script_str.='[';
        foreach ($survey as $key => $value) {
            //make sure that the correct number of values is entered in the array by
            //adding a zero for the last value (if necessary)
            if ($key == 7) {
                if ($value === null) {
                    $script_str.='0';
                } else {
                    $script_str .= $value;
                }
            } elseif ($key < 7) {
                $script_str .= $value . ', ';
            }
        }
        $script_str.=']';

        //separate by pre, mid, post
        if ($survey[8] == 1) {
            $pre_survey = $script_str;
        }
        if ($survey[8] == 2) {
            $mid_survey = $script_str;
        }
        if ($survey[8] == 3) {
            $post_survey = $script_str;
        }
    }
    ?>
            <!-- Create chart.  See jqplot for full documentation. -->
            <script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.min.js"></script>
            <link rel="stylesheet" type="text/css" href="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.css" />
            <script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.barRenderer.min.js"></script>
            <script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.categoryAxisRenderer.min.js"></script>
            <script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.pointLabels.min.js"></script>
            <script type="text/javascript">
                         //alert(pmanswers1);
                         $(document).ready(function() {
                             var pmanswers1 = <?php echo $pre_survey; ?>;
                             var pmanswers3 =<?php echo $post_survey; ?>;
                             var pmanswers2 =<?php echo $mid_survey; ?>;
                             var plot2 = $.jqplot('pm_survey_chart', [pmanswers1, pmanswers2, pmanswers3],
                                     //var plot2 = $.jqplot('pm_survey_chart', [pmanswers1],
                                             {
                                                 //title: 'How many days a week do you ask your child about school?',
                                                 seriesDefaults: {
                                                     renderer: $.jqplot.BarRenderer,
                                                     rendererOptions: {
                                                         barDirection: 'vertical',
                                                         barMargin: 10,
                                                         barWidth: 10
                                                     }
                                                 },
                                                 series: [
                                                     {label: 'Pre-Survey Responses', pointLabels: {show: true, edgeTolerance: -15}},
                                                     {label: 'Mid-Survey Responses', pointLabels: {show: true, edgeTolerance: -15}},
                                                     {label: 'Post-Survey Responses', pointLabels: {show: true, edgeTolerance: -15}}
                                                 ],
                                                 legend: {
                                                     show: true,
                                                     placement: 'outsideGrid'
                                                 },
                                                 axes: {
                                                     yaxis: {
                                                         min: 0,
                                                         max: 20
                                                     },
                                                     xaxis: {
                                                         renderer: $.jqplot.CategoryAxisRenderer,
                                                         ticks: ["Days :talk <br>to child\'s teacher", "Days: <br>read at home", "Number:<br> parents greeted", "Number:<br> teachers greeted",
                                                             "Parent committee<br>meetings attended", "Days in month:<br> meeting/activity", "Days in month:<br>sharing <br>school information",
                                                             "Self-efficacy:<br> I will be able to<br>achieve my goals"]
                                                     }
                                                 }
                                             });

                                 });

            </script>
            <div id="pm_survey_chart" ></div><hr>

    <?php include "../include/dbconnclose.php";
    ?>
        </td></tr><?php } ?>
<tr>
    <td colspan="2">
    </td>
</tr>
</table>

<br/><br/>
</div>

<?php include "../../footer.php"; ?>