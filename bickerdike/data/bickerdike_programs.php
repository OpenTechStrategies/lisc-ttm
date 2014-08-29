<?php
include "../../header.php";
include "../header.php";
include "../include/datepicker.php";

?>
<!--
This page shows a few of the miscellaneous categories of information that Bickerdike is collecting: miles of bike lanes, 
aldermanic funds for environmental improvements, and healthy item sales data.
-->
<script type="text/javascript">
	$(document).ready(function() {
		$('#data_selector').addClass('selected');
                //$('.hide_on_view').hide();
	});
</script>

<div class="content_wide">
        <h3>Contextual Data</h3><hr/>

        <!--Counts the institutions that have been entered in the database:-->
<div id="bickerdike_stats"><ul>
    <li>Number of participating organizations: <strong><?
        $count_partners_sqlsafe = "SELECT * FROM Org_Partners;";
        include "../include/dbconnopen.php";
        $partners = mysqli_query($cnnBickerdike, $count_partners_sqlsafe);
        $count = mysqli_num_rows($partners);
        include "../include/dbconnclose.php";
        echo $count;
    ?></strong></li>
<!--    <li>Number of advertisements (etc.) for media messages</li>-->
</ul></div>
<!--    <table>
        <tr><th>Organization Name |</th>
            <th>Partners |</th>
            <th>Location(s)</th>
        </tr>
    </table>-->
    
    <p></p>

    <p></p>
	
    <!--Shows the miles of bike lanes in HumboldtPark over time.  Pulls directly from the Bike_Trails
    table.-->
    
<table id="contextual_stats_table">
	<tr>
		<td width="50%"><h4>Miles of bike lanes in Humboldt Park</h4>
<table class="all_projects" style="width:300px;">
    <tr>
        <th></th>
        <th>Date</th>
    </tr>
    <? date_default_timezone_set('America/Chicago');
    $get_trail_info_sqlsafe = "SELECT * FROM Bike_Trails";
    include "../include/dbconnopen.php";
    $trails = mysqli_query($cnnBickerdike, $get_trail_info_sqlsafe);
        while ($trail = mysqli_fetch_array($trails)){
            ?>
                <tr>
        <td class="all_projects"><? echo $trail['Miles_Bike_Lanes']?></td>
        <td class="all_projects"><?
        $datetime = new DateTime($trail['Date']);
                                    echo date_format($datetime, 'M d, Y'). "<br>";?></td>
    </tr>
                <?
        }
    include "../include/dbconnclose.php";
    ?>
    
    <!--Add new bike lane information here.  -->
    
    <tr class="hide_on_view">
        <td class="all_projects"><input type="text" id="bike_miles"></td>
        <td class="all_projects"><input type="text" id="bike_date"></td>
    </tr>
    <tr class="hide_on_view">
        <td class="all_projects" colspan="2"><input type="button" value="Save New" onclick="
                                                    $.post(
                                                        '../ajax/add_bike_info.php',
                                                        {
                                                            miles: document.getElementById('bike_miles').value,
                                                            date: document.getElementById('bike_date').value
                                                        },
                                                        function (response){
                                                           // document.write(response);
                                                           window.location = 'bickerdike_programs.php';
                                                        }
                                                )"></td>
    </tr>
</table><br/><br/></td>
                
                <!--Pulls information on Aldermanic funding over time from the Aldermanic_Records table.
                -->
                
		<td><h4>Aldermanic Funds for Environmental Improvements</h4>
<table class="all_projects" style="width:300px;">
    <tr>
        <th> </th>
        <th>Fiscal Year</th>
    </tr>
    <? date_default_timezone_set('America/Chicago');
<<<<<<< HEAD
    $get_trail_info = "SELECT * FROM Aldermanic_Records";
=======
    $get_trail_info_sqlsafe = "SELECT * FROM `lisc-bickerdike.chapinhall.org`.Aldermanic_Records";
>>>>>>> Issue-19-sqlsafe
    include "../include/dbconnopen.php";
    $trails = mysqli_query($cnnBickerdike, $get_trail_info_sqlsafe);
        while ($trail = mysqli_fetch_array($trails)){
            ?>
                <tr>
                    <td class="all_projects"><? echo "$" . number_format($trail['Environmental_Improvement_Money'])?></td>
        <td class="all_projects"><?
        $datetime = new DateTime($trail['Date']);
                                    echo date_format($datetime, 'M d, Y'). "<br>";?></td>
    </tr>
                <?
        }
    include "../include/dbconnclose.php";
    ?>
    <tr class="hide_on_view">
        <td class="all_projects"><input type="text" id="env_money"></td>
        <td class="all_projects"><input type="text" id="env_date"></td>
    </tr>
    
    <!--Add new aldermanic info here.-->
    
    <tr class="hide_on_view">
        <td class="all_projects" colspan="2"><input type="button" value="Save New" onclick="
                                                    $.post(
                                                        '../ajax/add_alderman_info.php',
                                                        {
                                                            money: document.getElementById('env_money').value,
                                                            date: document.getElementById('env_date').value
                                                        },
                                                        function (response){
                                                           // document.write(response);
                                                           window.location = 'bickerdike_programs.php';
                                                        }
                                                )"></td>
    </tr>
</table><br/><br/></td></tr>
        
        <!--Shows all information about sales of healthy items. -->
        
	<tr>
		<td colspan="2"><h4>Sales Data of Healthy Items</h4>
<table class="all_projects">
    <tr>
        <th></th>
        <th>Store</th>
        <th>Date</th>
    </tr>
      <?  $get_trail_info_sqlsafe = "SELECT * FROM Funded_Organization_Records_Stores INNER JOIN Corner_Stores
                        ON Funded_Organization_Records_Stores.Store_ID=Corner_Stores.Corner_Store_ID;";
    include "../include/dbconnopen.php";
    $trails = mysqli_query($cnnBickerdike, $get_trail_info_sqlsafe);
        while ($trail = mysqli_fetch_array($trails)){
            ?>
                <tr>
                    <td class="all_projects"><? echo "$" . number_format($trail['Sales_Data'])?></td>
                    <td class="all_projects"><?echo $trail['Corner_Store_Name'];?></td>
        <td class="all_projects"><?
        $datetime = new DateTime($trail['Date']);
                                    echo date_format($datetime, 'M d, Y'). "<br>";
                                    ?></td>
    </tr>
    <?}?>
    
    <!-- Add new sales data.  Stores must already exist in the database.  They can be added on the corner
    store assessment page. -->
    
    
    <tr class="hide_on_view">
        <td class="all_projects"><input type="text" id="sales_money"></td>
        <td>
            <select id="store">
                <option value="">-----</option>
            <?
        $store_select_sqlsafe = "SELECT * FROM Corner_Stores";
        include "../include/dbconnopen.php";
        $stores = mysqli_query($cnnBickerdike, $store_select_sqlsafe);
        while ($store = mysqli_fetch_array($stores)){
            ?>
                <option value="<?echo $store['Corner_Store_ID']?>"><?echo $store['Corner_Store_Name'];?></option>
                <?
        }
        include "../include/dbconnclose.php";
        ?></select></td>
        <td class="all_projects"><input type="text" id="sales_date"></td>
    </tr>
    <tr class="hide_on_view">
        <td class="all_projects" colspan="3"><input type="button" value="Save New" onclick="
                                                    $.post(
                                                        '../ajax/add_sales_info.php',
                                                        {
                                                            money: document.getElementById('sales_money').value,
                                                            store: document.getElementById('store').options[document.getElementById('store').selectedIndex].value,
                                                            date: document.getElementById('sales_date').value
                                                        },
                                                        function (response){
                                                           // document.write(response);
                                                           window.location = 'bickerdike_programs.php';
                                                        }
                                                )"></td>
    </tr>
    
</table></td>
	</tr>
</table>
	


    
    
</div>

<? include "../../footer.php"; ?>