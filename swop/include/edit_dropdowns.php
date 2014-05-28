<?php
include "../../header.php";
include "../header.php";
?>

<!--
page that allows users to edit table contents in order to edit the select menus throughout
the system.
see /ajax/dropdown_changes for the way this works.
-->

<h3>Edit All <em>(Most)</em> Dropdown Menus</h3><hr/><br/>

<table class="inner_table" id="edit_dropdowns">
    <!-- set of elements that are to be altered by users. -->
    <tr><th>Dropdown</th><th>Add element</th><th>Delete element</th><th>Edit element</th></tr>
    <tr><th colspan="4" class="subheader">All Participants</th></tr>

    <tr><td class="dropdown_name">Roles</td><td><span class="helptext">Existing dropdown: </span><br/><select><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Participants_Roles";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New option: </span><br/><input type="text" id="new_role"><br>
            <input type="button" value="Save" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'role',
                                                            action: 'add',
                                                            variable: document.getElementById('new_role').value
                                                        },
                                                function(response) {
                                                    document.getElementById('role_response').innerHTML = response;
                                                }
                                                )"></td>
        <td><span class="helptext">Delete from dropdown: </span><br/><select id="delete_select"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Participants_Roles";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>

            <input type="button" value="Delete" onclick="$.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'role',
                                                            action: 'delete',
                                                            variable: document.getElementById('delete_select').value
                                                        },
                                                function(response) {
                                                    document.getElementById('role_response').innerHTML = response;
                                                }
                                                )">
            <div id="role_response"></div></td>
        <td><span class="helptext">Edit element: </span><br/><select id="element_edited"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Participants_Roles";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New text: </span><br/><input type="text" id="new_role_text"><br>
            <input type="button" value="Save New Text" onclick="$.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'role',
                                                            action: 'edit',
                                                            edited: document.getElementById('element_edited').value,
                                                            variable: document.getElementById('new_role_text').value
                                                        },
                                                function(response) {
                                                    document.getElementById('role_response').innerHTML = response;
                                                }
                                                )"></td>
    <tr><td class="dropdown_name">Leader Levels</td><td><span class="helptext">Existing dropdown: </span><br/><select><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Leadership_Levels";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New option: </span><br/><input type="text" id="new_leader"><br>
            <input type="button" value="Save" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'leader',
                                                            action: 'add',
                                                            variable: document.getElementById('new_leader').value
                                                        },
                                                function(response) {
                                                    document.getElementById('leader_response').innerHTML = response;
                                                }
                                                )"></td>
        <td><span class="helptext">Delete from dropdown: </span><br/><select id="leader_delete"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Leadership_Levels";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <input type="button" value="Delete" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'leader',
                                                            action: 'delete',
                                                            variable: document.getElementById('leader_delete').value
                                                        },
                                                function(response) {
                                                    document.getElementById('leader_response').innerHTML = response;
                                                }
                                                )">
            <div id="leader_response"></div></td>
        <td><span class="helptext">Edit element </span></br><select id="leader_edited"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Leadership_Levels";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New option:</span></br> <input type="text" id="new_leader_edit"><br>
            <input type="button" value="Save" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'leader',
                                                            action: 'edit',
                                                            variable: document.getElementById('new_leader_edit').value,
                                                            edited: document.getElementById('leader_edited').value
                                                        },
                                                function(response) {
                                                    document.getElementById('leader_response').innerHTML = response;
                                                }
                                                )"></td>


    </tr> 


    <tr><th colspan="4" class="subheader">Pool Participants</th></tr>
    <tr><td class="dropdown_name">Pool Member Types</td>
        <td><span class="helptext">Existing dropdown: </span><br/><select  style="width:150px"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Pool_Member_Types";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext"> New option: </span><br/><input type="text" id="new_pool_type">
            <br><span class="helptext">Related to:</span><br/>
            <select id="pipeline_edited">
                <option value="1">Buying a property</option>
                <option value="3">Renting.</option>
                <option value="2">Loan modification.</option>
            </select>
            <input type="button" value="Save" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'pool_type',
                                                            action: 'add',
                                                            variable: document.getElementById('new_pool_type').value,
                                                            edited: document.getElementById('pipeline').value
                                                        },
                                                function(response) {
                                                    document.getElementById('pool_type_response').innerHTML = response;
                                                }
                                                )"></td>
        <td><span class="helptext">Delete from dropdown: </span><br/><select id="pool_types_delete"  style="width:150px"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Pool_Member_Types";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <br>
            <input type="button" value="Delete" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'pool_type',
                                                            action: 'delete',
                                                            variable: document.getElementById('pool_types_delete').value
                                                        },
                                                function(response) {
                                                    document.getElementById('pool_type_response').innerHTML = response;
                                                }
                                                )">
            <div id="pool_type_response"></div></td>
        <td><span class="helptext">Existing dropdown: </span></br><select id="pool_types_edited" style="width:150px"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Pool_Member_Types";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New option: </span></br><input type="text" id="edited_pool_type">
            <br><span class="helptext">Related to:</span><br/>
            <select id="pipeline_edited">
                <option value="1">Buying a property</option>
                <option value="3">Renting.</option>
                <option value="2">Loan modification.</option>
            </select>
            <input type="button" value="Save" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'pool_type',
                                                            action: 'edit',
                                                            variable: document.getElementById('edited_pool_type').value,
                                                            edited: document.getElementById('pool_types_edited').value,
                                                            more: document.getElementById('pipeline_edited').value
                                                        },
                                                function(response) {
                                                    document.getElementById('pool_type_response').innerHTML = response;
                                                }
                                                )"></td>
    </tr>

<!--    <tr><td>Employment Time</td></tr>-->
    <tr><td class="dropdown_name">Pool Progress Benchmarks / Activities</td>
        <td><span class="helptext">Existing dropdown: </span><br/><select  style="width:150px"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Pool_Benchmarks";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New option: </span><br/><input type="text" id="new_benchmark">
            <br><span class="helptext">Related to:</span><br/>
            <select id="pool_types_all" style="width:150px"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Pool_Member_Types";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[2]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select>
            <br><span class="helptext">Benchmark / Activity:</span><br/>
            <select id="benchmark_type_new" style="width:150px">
                    <option value="Benchmark">Benchmark</option>
                    <option value="Activity">Activity</option>
            </select>
            <input type="button" value="Save" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'pool_benchmark',
                                                            action: 'add',
                                                            variable: document.getElementById('new_benchmark').value,
                                                            pipeline: document.getElementById('pool_types_all').value,
                                                            benchmark_type: document.getElementById('benchmark_type_new').value
                                                        },
                                                function(response) {
                                                    document.getElementById('benchmark_response').innerHTML = response;
                                                }
                                                )"></td>
        <td><span class="helptext">Delete from dropdown: </span><br/><select id="all_benchmarks" style="width:150px"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Pool_Benchmarks";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>

            <input type="button" value="Delete" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'pool_benchmark',
                                                            action: 'delete',
                                                            variable: document.getElementById('all_benchmarks').value
                                                        },
                                                function(response) {
                                                    document.getElementById('benchmark_response').innerHTML = response;
                                                }
                                                )"></td>
        <td><span class="helptext">Edit dropdown: </span><br/><select id="benchmarks_edit" style="width:150px"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Pool_Benchmarks";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New benchmark text: </span><br/><input type="text" id="new_benchmark_edit">
            <br><span class="helptext">Related to:</span><br/>
            <select id="pool_types_all_edit" style="width:150px"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Pool_Member_Types";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[2]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select>
            <br><span class="helptext">Benchmark / Activity:</span><br/>
            <select id="benchmark_type_edit" style="width:150px">
                    <option value="Benchmark">Benchmark</option>
                    <option value="Activity">Activity</option>
            </select>
            <input type="button" value="Save" onclick="
                alert(1);
                alert(document.getElementById('new_benchmark_edit').value);
                alert(document.getElementById('benchmarks_edit').value);
                alert(document.getElementById('pool_types_all_edit').value);
                alert(document.getElementById('benchmark_type_edit').value);
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'pool_benchmark',
                                                            action: 'edit',
                                                            variable: document.getElementById('new_benchmark_edit').value,
                                                            edited: document.getElementById('benchmarks_edit').value,
                                                            pipeline: document.getElementById('pool_types_all_edit').value,
                                                            benchmark_type: document.getElementById('benchmark_type_edit').value
                                                        },
                                                function(response) {
                                                    alert(2);
                                                    document.getElementById('benchmark_response').innerHTML = response;
                                                    alert(3);
                                                    
                                                }
                                                )"></td>
    </tr>
    <tr><td colspan="4" style="text-align: center; color: #f00; border-bottom: 0px;"><div id="benchmark_response"></div></td></tr>
    <tr><td class="dropdown_name">Pool Outcomes</td>
        <td><span class="helptext">Existing dropdown: </span><br/><select><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Outcomes_for_Pool";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New option: </span><br/><input type="text" id="new_outcome"><br>
            <input type="button" value="Save" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'outcome',
                                                            action: 'add',
                                                            variable: document.getElementById('new_outcome').value
                                                        },
                                                function(response) {
                                                    document.getElementById('outcome_response').innerHTML = response;
                                                }
                                                )"></td>
        <td><span class="helptext">Delete from dropdown: </span><br/><select id="all_outcomes"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Outcomes_for_Pool";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <input type="button" value="Delete" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'outcome',
                                                            action: 'delete',
                                                            variable: document.getElementById('all_outcomes').value
                                                        },
                                                function(response) {
                                                    document.getElementById('outcome_response').innerHTML = response;
                                                }
                                                )">
            <div id="outcome_response"></div></td>
        <td><span class="helptext">Edit: </span><br/><select id="edited_outcome"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Outcomes_for_Pool";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New option: </span><br/><input type="text" id="new_outcome_edit"><br>
            <input type="button" value="Save" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'outcome',
                                                            action: 'edit',
                                                            variable: document.getElementById('new_outcome_edit').value,
                                                            edited: document.getElementById('edited_outcome').value
                                                        },
                                                function(response) {
                                                    document.getElementById('outcome_response').innerHTML = response;
                                                }
                                                )"></td>
    </tr>
    <tr><td class="dropdown_name">Pool Outcome Location Options</td>
        <td><span class="helptext">Existing dropdown: </span><br/><select><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Outcome_Locations";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New option: </span><br/><input type="text" id="new_location"><br>
            <input type="button" value="Save" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'location',
                                                            action: 'add',
                                                            variable: document.getElementById('new_location').value
                                                        },
                                                function(response) {
                                                    document.getElementById('location_response').innerHTML = response;
                                                }
                                                )"></td>
        <td><span class="helptext">Delete from dropdown: </span><br/><select id="all_locations"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Outcome_Locations";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <input type="button" value="Delete" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'location',
                                                            action: 'delete',
                                                            variable: document.getElementById('all_locations').value
                                                        },
                                                function(response) {
                                                    document.getElementById('location_response').innerHTML = response;
                                                }
                                                )">
            <div id="location_response"></div></td>
        <td><span class="helptext">Edit: </span><br/><select id="edited_location"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Outcome_Locations";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New option: </span><br/><input type="text" id="new_location_edit"><br>
            <input type="button" value="Save" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'location',
                                                            action: 'edit',
                                                            variable: document.getElementById('new_location_edit').value,
                                                            edited: document.getElementById('edited_location').value
                                                        },
                                                function(response) {
                                                    document.getElementById('location_response').innerHTML = response;
                                                }
                                                )"></td></tr>


    <tr><th colspan="4" class="subheader">Properties</th></tr>
    <tr><td class="dropdown_name">Property Dispositions</td>
        <td><span class="helptext">Existing dropdown: </span><br/><select><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Property_Dispositions";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New option: </span><br/><input type="text" id="new_disposition"><br>
            <input type="button" value="Save" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'disposition',
                                                            action: 'add',
                                                            variable: document.getElementById('new_disposition').value
                                                        },
                                                function(response) {
                                                    document.getElementById('disposition_response').innerHTML = response;
                                                }
                                                )"></td>
        <td><span class="helptext">Delete from dropdown: </span><br/><select id="all_dispositions"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Property_Dispositions";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <input type="button" value="Delete" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'disposition',
                                                            action: 'delete',
                                                            variable: document.getElementById('all_dispositions').value
                                                        },
                                                function(response) {
                                                    document.getElementById('disposition_response').innerHTML = response;
                                                }
                                                )">
            <div id="disposition_response"></div></td>
        <td><span class="helptext">Edit: </span><br/><select id="edited_disposition"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Property_Dispositions";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New option: </span><br/><input type="text" id="new_disposition_edit"><br>
            <input type="button" value="Save" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'disposition',
                                                            action: 'edit',
                                                            variable: document.getElementById('new_disposition_edit').value,
                                                            edited: document.getElementById('edited_disposition').value
                                                        },
                                                function(response) {
                                                    document.getElementById('disposition_response').innerHTML = response;
                                                }
                                                )"></td>

    </tr>
    <tr><td class="dropdown_name">Rehab/Acquisition Markers</td>
        <td><span class="helptext">Existing dropdown: </span><br/><select><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Property_Marker_Names";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New option: </span><br/><input type="text" id="new_marker"><br>
            <input type="button" value="Save" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'marker',
                                                            action: 'add',
                                                            variable: document.getElementById('new_marker').value
                                                        },
                                                function(response) {
                                                    document.getElementById('marker_response').innerHTML = response;
                                                }
                                                )"></td>
        <td><span class="helptext">Delete from dropdown: </span><br/><select id="all_markers"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Property_Marker_Names";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <input type="button" value="Delete" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'marker',
                                                            action: 'delete',
                                                            variable: document.getElementById('all_markers').value
                                                        },
                                                function(response) {
                                                    document.getElementById('marker_response').innerHTML = response;
                                                }
                                                )">
            <div id="marker_response"></div></td>
        <td><span class="helptext">Edit: </span><br/><select id="edited_marker"><?php
                //get roles
                include "../include/dbconnopen.php";
                $select_roles = "SELECT * FROM Property_Marker_Names";
                $roles = mysqli_query($cnnSWOP, $select_roles);
                while ($role = mysqli_fetch_row($roles)) {
                    ?>
                    <option value="<?php echo $role[0]; ?>"><?php echo $role[1]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?></select><br>
            <span class="helptext">New option: </span><br/><input type="text" id="new_marker_edit"><br>
            <input type="button" value="Save" onclick="
                                                $.post(
                                                        '../ajax/dropdown_changes.php',
                                                        {
                                                            element: 'marker',
                                                            action: 'edit',
                                                            variable: document.getElementById('new_marker_edit').value,
                                                            edited: document.getElementById('edited_marker').value
                                                        },
                                                function(response) {
                                                    document.getElementById('marker_response').innerHTML = response;
                                                }
                                                )"></td>
    </tr>



    <!-- To Do:
    <tr><td>Current housing situation</td></tr>
    <tr><td>Household Location</td></tr>
    <tr><td>Reason for interest in Acquisition</td></tr>
    <tr><td>Vacant Property Types</td></tr>
    <tr><td>Property Condition</td></tr>
    <tr><td>End Reasons (Property Links)</td></tr>
    -->
    <tr><th colspan="4"><hr></th></tr>
    <tr><th colspan="4" class="subheader">Dropdowns that cannot be altered on this page:</th></tr>
    <tr><th>Dropdown</th><th>Add element</th><th>Delete element</th><th>Edit element</th></tr>
    <tr><td class="dropdown_name" style="padding:10px">Campaigns</td><td style="padding:10px">To add a new campaign, navigate to "Campaigns" (see top menu)
            and add a new campaign there.  The campaign will show up in all campaign dropdowns.</td>
        <td style="padding:10px">There is currently no way to delete campaigns.</td>
        <td  style="padding:10px">There is currently no way to edit campaign names.</td></tr>
    <tr><td class="dropdown_name">Campaign Event Locations</td><td>To add a new campaign event location, enter it as text when you add an event that took place at
            that location.</td><td><span class="helptext">Delete location: </span><br/><select id="event_location">
                <option value="0">-------</option>
                <?php
                $get_subcampaigns = "SELECT DISTINCT Location FROM Campaigns_Events WHERE Location!='0' AND Location IS NOT NULL  ORDER BY Location";
                include "../include/dbconnopen.php";
                $subcampaigns = mysqli_query($cnnSWOP, $get_subcampaigns);
                while ($subcam = mysqli_fetch_row($subcampaigns)) {
                    ?>
                    <option><?php echo $subcam[0]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?>
            </select><input type="button" value="Delete" onclick="$.post(
                '../ajax/dropdown_changes.php',
                {
                    element: 'event_location',
                    action: 'delete',
                    variable: document.getElementById('event_location').value
                },
        function(response) {
            document.getElementById('event_locale_response').innerHTML = response;
        }
        )">
            <div id="event_locale_response"></div></td>
        <td><span class="helptext">Edit location: </span><br/><select id="event_location_edit">
                <option value="0">-------</option>
                <?php
                $get_subcampaigns = "SELECT DISTINCT Location FROM Campaigns_Events WHERE Location!='0' AND Location IS NOT NULL  ORDER BY Location";
                include "../include/dbconnopen.php";
                $subcampaigns = mysqli_query($cnnSWOP, $get_subcampaigns);
                while ($subcam = mysqli_fetch_row($subcampaigns)) {
                    ?>
                    <option><?php echo $subcam[0]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?>
            </select><br>
            <span class="helptext">New text: </span><br/><input type="text" id="new_event_location"><br>
            <input type="button" value="Update" onclick="$.post(
                '../ajax/dropdown_changes.php',
                {
                    element: 'event_location',
                    action: 'edit',
                    new_location: document.getElementById('new_event_location').value,
                    variable: document.getElementById('event_location_edit').value
                },
        function(response) {
            document.getElementById('event_locale_response').innerHTML = response;
        }
        )">
        </td>
    </tr>
    <tr><td class="dropdown_name">Subcampaigns</td>
        <td>To add a new campaign event subcampaign, enter it as text when you add an event that was related to that subcampaign.</td>
        <td><span class="helptext">Delete subcampaign: </span><br/><select id="subcampaign">
                <option value="0">-------</option>
                <?php
                $get_subcampaigns = "SELECT DISTINCT Subcampaign FROM Campaigns_Events WHERE Subcampaign!='0' AND Subcampaign IS NOT NULL 
        AND Campaign_ID='" . $_COOKIE['campaign'] . "' ORDER BY Subcampaign";
                include "../include/dbconnopen.php";
                $subcampaigns = mysqli_query($cnnSWOP, $get_subcampaigns);
                while ($subcam = mysqli_fetch_row($subcampaigns)) {
                    ?>
                    <option><?php echo $subcam[0]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?>
            </select><input type="button" value="Delete" onclick="$.post(
                '../ajax/dropdown_changes.php',
                {
                    element: 'event_subcampaign',
                    action: 'delete',
                    variable: document.getElementById('subcampaign').value
                },
        function(response) {
            document.getElementById('subcampaign_response').innerHTML = response;
        }
        )">
            <div id="subcampaign_response"></div></td>
        <td><span class="helptext">Edit subcampaign: </span><br/><select id="edit_subcampaign">
                <option value="0">-------</option>
                <?php
                $get_subcampaigns = "SELECT DISTINCT Subcampaign FROM Campaigns_Events WHERE Subcampaign!='0' AND Subcampaign IS NOT NULL 
        AND Campaign_ID='" . $_COOKIE['campaign'] . "' ORDER BY Subcampaign";
                include "../include/dbconnopen.php";
                $subcampaigns = mysqli_query($cnnSWOP, $get_subcampaigns);
                while ($subcam = mysqli_fetch_row($subcampaigns)) {
                    ?>
                    <option><?php echo $subcam[0]; ?></option>
                    <?php
                }
                include "../include/dbconnclose.php";
                ?>
            </select><br>
            <span class="helptext">New text: </span><br/><input type="text" id="new_subcampaign"><br>
            <input type="button" value="Update" onclick="$.post(
                '../ajax/dropdown_changes.php',
                {
                    element: 'event_subcampaign',
                    action: 'edit',
                    new_subcampaign: document.getElementById('new_subcampaign').value,
                    variable: document.getElementById('edit_subcampaign').value
                },
        function(response) {
            document.getElementById('subcampaign_response').innerHTML = response;
        }
        )">
        </td>
    </tr>
    <tr><td class="dropdown_name">Events</td><td style="padding:10px">To add a new event, navigate to a campaign profile and add a new event there.
            The event will show up in all event dropdowns.</td>
        <td style="padding:10px">There is currently no way to delete events.</td>
        <td  style="padding:10px">There is currently no way to edit event names.</td></tr>
    <tr><td class="dropdown_name">Households</td><td style="padding:10px">To add a new household, navigate to the profile of a participant who is 
            a member of that household.  Under "add this participant to a household", choose to create a new household.
            Type the household name in the textbox labeled "Household Name."  </td>
        <td style="padding:10px">There is currently no way to delete households.</td>
        <td  style="padding:10px">There is currently no way to edit household names.</td></tr>
    <tr><td class="dropdown_name">Primary Organizers</td><td style="padding:10px">To add someone as a primary organizer, name them as a participant's primary organizer.
            This can be done in the Basic Info box of any participant profile, or when adding a new participant.  The putative primary organizer
            will then show up in all primary organizer dropdowns (notably on the search function).</td>
        <td style="padding:10px">To delete a primary organizer, simply remove him or her from the profiles of the people for whom he or she is a primary 
            organizer.</td>
        <td  style="padding:10px">To edit the name or other information about a primary organizer, navigate to his or her profile.</td></tr>
    <tr><td class="dropdown_name blank">Property Owner Institutions</td><td style="padding:10px" class="blank">To add a new financial institution, navigate to "Institutions" and add
            a new institution with type "Financial Institution," or alter an existing institution to type "Financial Institution."</td>
        <td style="padding:10px" class="blank">There is currently no way to delete institutions.</td>
        <td  style="padding:10px" class="blank">To edit an institution's name, navigate to that institution's profile and edit it in the Basic Info box.</td></tr>


</table>

<?php include "../../footer.php" ?>