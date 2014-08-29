<?php
include "../../header.php";
include "../header.php";
include "../include/datepicker_simple.php";
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#reports_selector').addClass('selected');

    });

    $(document).ajaxStart(function() {
        $('#ajax_loader').fadeIn('slow');
    });

    $(document).ajaxComplete(function() {
        $('#ajax_loader').fadeOut('slow');
    });
</script>

<!-- Reports home and set of options for both the individual and property query reports. -->

<div class="content_block">
    <?php include "reports_menu.php"; ?>

    <!-- search on these options to find people: -->
    <h4>Generate Individual Report</h4>
    <table class="inner_table" style="font-size:.9em;width:90%;margin-left:auto;margin-right:auto;border:2px solid #696969;">
        <tr><td><strong>First Name:</strong></td><td><input type="text" id="first_name">
            </td>
                <td><strong>Last Name:</strong></td><td><input type="text" id="last_name">
                    <!-- <strong>Middle Name:</strong></td><td><input type="text" id="middle_name"> -->
            </td>
        </tr>
        <tr><td><strong>Email Address:</strong></td><td><input type="text" id="email">
            </td>
                <td><strong>Phone:</strong></td><td><input type="text" id="phone">
            </td>
        </tr>
        <tr><td><strong>Notes:</strong></td><td><input type="text" id="notes">
            </td>
                <td><strong>Date Of Birth:</strong></td><td><input type="text" id="date_of_birth">
            <script>
            $(function() {
                $("#date_of_birth").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "-100:+0"
                });
            });
            </script>
            </td>
        </tr>
        <tr><td><strong>Gender:</strong></td><td><select id="gender">
                    <option value="0">-----</option>
                    <option value="m">Male</option>
                    <option value="f">Female</option>
                </select></td>
            <td><strong>Has ITIN?:</strong></td><td><select id="has_itin">
                    <option value="">-----</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </td>
        </tr>
        <tr><td><strong>Language Spoken:</strong></td><td><select id="language_spoken">
                    <option value="0">-----</option>
                    <option value="English">English</option>
                    <option value="Spanish">Spanish</option>
                    <option value="Other">Other</option>
                </select></td>
            <td><strong>Ward:</strong></td><td><select id="ward">
                    <option value="0">-----</option>
                    <?php
                    $get_wards_sqlsafe = "SELECT DISTINCT Ward FROM Participants
                                    WHERE Ward != ''
                                    ORDER BY CAST(Ward AS UNSIGNED)";
                    include "../include/dbconnopen.php";
                    $wards = mysqli_query($cnnSWOP, $get_wards_sqlsafe);
                    while ($ward = mysqli_fetch_array($wards)) {
                        ?>
                        <option value="<?php echo $ward['Ward']; ?>"><?php echo $ward['Ward']; ?></option>
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?>
                </select>
            </td>
        </tr>
        <tr><td><strong>Primary Organizer:</strong></td><td><select id="leader">
                    <option value="0">-----</option>
                    <?php
                    $get_primarys_sqlsafe = "SELECT 
                                Organizer_Info.Participant_ID, Organizer_Info.Name_First, Organizer_Info.Name_Last
                                FROM Participants INNER JOIN 
                                Participants AS Organizer_Info ON Participants.Primary_Organizer = Organizer_Info.Participant_ID
                                GROUP BY Organizer_Info.Participant_ID ORDER BY Organizer_Info.Name_Last;";
                    include "../include/dbconnopen.php";
                    $primarys = mysqli_query($cnnSWOP, $get_primarys_sqlsafe);
                    while ($primary = mysqli_fetch_array($primarys)) {
                        ?>
                        <option value="<?php echo $primary['Participant_ID']; ?>"><?php echo $primary['Name_First'] . " " . $primary['Name_Last']; ?></option>
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?>

                </select></td>
            <td><strong>Pool Type:</strong></td><td><select id="member_type">
                    <option value="0">-----</option>
                    <?php
                    $get_institutions_sqlsafe = "SELECT * FROM Pool_Member_Types";
                    include "../include/dbconnopen.php";
                    $institutions = mysqli_query($cnnSWOP, $get_institutions_sqlsafe);
                    while ($institution = mysqli_fetch_array($institutions)) {
                        ?>
                        <option value="<?php echo $institution['Type_ID']; ?>"><?php echo $institution['Type_Name']; ?></option>
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?>
                </select>
            </td>
        </tr>
        <tr><td><strong>Primary Institution:</strong></td><td><select id="institution">
                    <option value="0">-----</option>
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
                </select></td>
            <td><strong>Current Progress Step:</strong></td><td><select id="benchmark">
                    <option value="0">-----</option>
                    <?php
                    /* some of these steps may show up more than once because they are repeated across the tracks. */
                    $get_institutions_sqlsafe = "SELECT * FROM Pool_Benchmarks ORDER BY Pipeline_Type, Step_Number;";
                    include "../include/dbconnopen.php";
                    $institutions = mysqli_query($cnnSWOP, $get_institutions_sqlsafe);
                    while ($institution = mysqli_fetch_assoc($institutions)) {
                        ?>
                        <option value="<?php echo $institution['Pool_Benchmark_ID']; ?>"><?php
                            if ($institution['Pipeline_Type'] == 1) {
                                echo 'Buyer: ';
                            } elseif ($institution['Pipeline_Type'] == 2) {
                                echo 'Loan Mod: ';
                            } elseif ($institution['Pipeline_Type'] == 3) {
                                echo "Renter: ";
                            }
                            echo $institution['Benchmark_Name'];
                            ?></option>
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?>
                </select></td></tr>
        <tr><td></td>
            <td></td>
            <td><strong>Has Completed Step:</strong></td><td><select id="benchmark_done">
                    <option value="0">-----</option>
                    <?php
                    /* some of these steps may show up more than once because they are repeated across the tracks. */
                    $get_institutions_sqlsafe = "SELECT * FROM Pool_Benchmarks ORDER BY Pipeline_Type, Step_Number;";
                    include "../include/dbconnopen.php";
                    $institutions = mysqli_query($cnnSWOP, $get_institutions_sqlsafe);
                    while ($institution = mysqli_fetch_assoc($institutions)) {
                        ?>
                        <option value="<?php echo $institution['Pool_Benchmark_ID']; ?>"><?php
                            if ($institution['Pipeline_Type'] == 1) {
                                echo 'Buyer: ';
                            } elseif ($institution['Pipeline_Type'] == 2) {
                                echo 'Loan Mod: ';
                            } elseif ($institution['Pipeline_Type'] == 3) {
                                echo "Renter: ";
                            }
                            echo $institution['Benchmark_Name'];
                            ?></option>
                        <?php
                    }
                    include "../include/dbconnclose.php";
                    ?>
                </select></td></tr>
        <tr><!-- finds people who were active in the pool in this date range: -->
            <td><strong>Start Active Date:</strong></td><td><input type="text" id="start" class="hasDatepickers"></td>
            <td><strong>End Active Date:</strong></td><td><input type="text" id="end" class="hasDatepickers"></td>
        </tr>
        <tr>
            <td><strong>Days since a completed benchmark:</strong></td><td colspan="3"><input type="text" style="width:40px;" id="lag_days">
                <span class="helptext">Ex: 30 (shows people who have not completed a benchmark in the last 30 days)
                </span></td></tr>
        <tr>
            <td colspan="4"><input type="button" value="Click here to choose columns for this query" onclick="
                    // alert('working');
                    $.post(
                            '../ajax/individual_search.php',
                            {
                                first_name: $('#first_name').val(),
                                //middle_name: $('#middle_name').val(),
                                last_name: $('#last_name').val(),
                                email: $('#email').val(),
                                phone: $('#phone').val(),
                                notes: $('#notes').val(),
                                date_of_birth: $('#date_of_birth').val(),
                                gender: $('#gender').val(),
                                has_itin: $('#has_itin').val(),
                                language_spoken: $('#language_spoken').val(),
                                ward: $('#ward').val(),
                                organizer: document.getElementById('leader').value,
                                inst: document.getElementById('institution').value,
                                type: document.getElementById('member_type').value,
                                step: document.getElementById('benchmark').value,
                                step_done: document.getElementById('benchmark_done').value,
                                start: document.getElementById('start').value,
                                end: document.getElementById('end').value,
                                laggers: document.getElementById('lag_days').value
                            },
                    function(response) {
                        document.getElementById('indiv_response').innerHTML = response;
                    }
                    )"></td>
        </tr>
    </table> 
    <div id="indiv_response" style="text-align:center;"></div>  
    <br/><br/>

   
    <p></p>
</div>
<p></p>
<?php include "../../footer.php"; ?>
