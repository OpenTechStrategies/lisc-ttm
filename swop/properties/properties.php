<?php
include "../../header.php";
include "../header.php";
?>
<!-- Property homepage.  Search properties in the system and a link to add a new one. -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#properties_selector').addClass('selected');
<?php
/* show the add new property page: */
if ($_GET['new'] == 1) {
    ?>
            $('#add_property').show();
            $('#property_search').hide();
    <?php
} else {
    ?>
            $('#add_property').hide();
            $('#property_search').show();
    <?php
}
?>
        $("a.add_new").hover(function() {
            $(this).addClass("selected");
        }, function() {
            $(this).removeClass("selected");
        });
    });
</script>


<div class="content_block">
    <div id="property_search" class="content_block">
        <h3>Properties</h3><hr/><br/>        

        <!-- Show the add new div. -->
        <div style="text-align:center;font-size:.9em;"><a class="add_new" onclick="
                $('#property_search').hide();
                $('#add_property').show();
                                                          "><span class="add_new_button no_view">Add New Property</span></a></div><br/>

        <?php
        /* this was a list of all properties, but I've hidden it now.  There are too many on the live site
         * to make such a list practical. */
        $get_properties_sqlsafe = "SELECT * FROM Properties";
        include "../include/dbconnopen.php";
        $properties = mysqli_query($cnnSWOP, $get_properties_sqlsafe);
        while ($property = mysqli_fetch_array($properties)) {
            ?>
            <!--<a href="javascript:;" onclick="
        $.post(
        '../ajax/set_property_id.php',
        {
            page: 'profile',
            property_id: '<?php echo $property['Property_ID']; ?>'
        },
        function (response){
            if (response!='1'){
                document.getElementById('show_error').innerHTML = response;
            }
        window.location='/swop/properties/properties.php';
            });"><?php echo $property['Name_First'] . " " . $property['Name_Last']; ?></a><br/>-->
            <?php
        }
        include "../include/dbconnclose.php";
        ?>

        <!-- search properties with any or all of these pieces of info: -->
        <h4>Search Properties</h4>
        <table class="search_table">
            <tr>
                <td><strong>Street Name:</strong></td>
                <td><input type="text" id="name_search" /></td>
                <td><strong>PIN:</strong></td>
                <td><input type="text" id="pin_search" /></td>
            </tr>
            <tr>
                <td><strong>Vacant?</strong></td>
                <td><select id="vacant_search">
                        <option value="">---------</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select></td>
                <td><strong>Disposition:</strong></td>
                <td><select id="disposition_search">
                        <option value="">---------</option>
                        <?php
                        $get_disps_sqlsafe = "SELECT * FROM Property_Dispositions";
                        include "../include/dbconnopen.php";
                        $disps = mysqli_query($cnnSWOP, $get_disps_sqlsafe);
                        while ($disp = mysqli_fetch_row($disps)) {
                            ?>
                            <option value="<?php echo $disp[0] ?>"><?php echo $disp[1]; ?></option>
                        <?php
                        }
                        include "../include/dbconnclose.php";
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="4"><input type="button" value="Search" onclick="
                        $.post(
                                '../ajax/search_props.php',
                                {
                                    name: document.getElementById('name_search').value,
                                    pin: document.getElementById('pin_search').value,
                                    vacant: document.getElementById('vacant_search').value,
                                    disposition: document.getElementById('disposition_search').value
                                },
                        function(response) {
                            //document.write(response);
                            document.getElementById('show_swop_results').innerHTML = response;
                        }
                        )"/></td>
            </tr>
        </table>
        <div id="show_swop_results"></div>
    </div>
</div>
<?php
include "add_property.php";
//include "profile.php";
include "../../footer.php";
?>
	