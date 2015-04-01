<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
user_enforce_has_access($SWOP_id);

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
    
    
 <!-- Choose terms to search on from the properties table  -->

    <h4>Generate Properties Report</h4>

    <table class="inner_table" id="properties_report" style="font-size:.9em;width:90%;margin-left:auto;margin-right:auto;border:2px solid #696969;">
        <tr>
            <td><strong>Construction Type:</strong></td>
            <td><select id="type_search">
                    <option value="">-----</option>
                    <option value="4">Brick/masonry</option>
                    <option value="5">Frame</option>
                </select></td>
            <td><strong>Home Size:</strong></td><td><select id="size_search">
                    <option value="">-----</option>
                    <option value="1">Single-family</option>
                    <option value="2">2/3 flat</option>
                    <option value="3">Multi-unit</option>
                </select></td>
        </tr>
        <tr>
            <td><strong>Vacant</strong></td><td><select id="vacant_search">
                    <option value="0">-----</option>
                    <option value="1">No</option>
                    <option value="2">Yes</option>
                    <!--
                    <option value="1">No, not vacant</option>
                    <option value="2">Yes, secured/boarded</option>
                    <option value="3">Yes, unsecured</option>
                    <option value="4">Yes, open</option>
                    -->
                </select></td>
            <td><strong>Price Range</strong></td><td><input type="text" id="low_price_search" style="width:60px;"> to <input type="text" id="high_price_range" style="width:60px;">
            </td>
        </tr>
        <tr>
            <td><strong>Property condition</strong></td><td><select id="condition_search">
                    <option value="">-----</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select></td><td></td><td></td>
        </tr>
        <tr>
            <th colspan="2" style="background-color:#eeeeee;border-bottom:1px solid black;">Property Benchmarks (Date Ranges)</th><td colspan="2"></td>
        </tr>
        <tr>
            <td><strong>Property listed for sale</strong></td>
            <td>
                <input type="text" id="listed_start" class="hasDatepickers">
                to <input type="text" id="listed_end" class="hasDatepickers"></td>
            <td><strong>For sale:</strong></td><td><select id="for_sale_search">
                    <option value="">---------</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select></td>
        </tr>
<!--			<tr>
                        <td></td><td></td>
    <td>Owner-occupied:</td><td><select id="owner_occ_search">
                                <option value="">---------</option>
                                <option value="1">Yes</option>
                                <option value="0" >No</option>
                        </select></td>
</tr>-->
        <tr>
            <td><strong>Interest in acquisition</strong></td><td><input type="text" id="interest_start" class="hasDatepickers"> to 
                <input type="text" id="interest_end" class="hasDatepickers"></td>
            <td><strong>Reason for interest</strong></td><td><select id="interest_search"><option value="n/a">-----</option>
                    <option>Vacant</option>
                    <option>Foreclosure</option>
                    <option>For sale</option>
                    <option>REO</option>
                </select></td></tr>
        <tr><td><strong>Acquisition</strong></td><td><input type="text" id="acquisition_start" class="hasDatepickers"> to <input type="text" id="acquisition_end" class="hasDatepickers"></td>
            <td><strong>Acquisition cost range</strong></td><td><input type="text" id="acquisition_low" style="width:60px;"> to 
                <input type="text" id="acquisition_high" style="width:60px;"></td>
        </tr>
        <tr><td><strong>Construction commences</strong></td><td>
                <input type="text" id="construction_start" class="hasDatepickers"> to <input type="text" id="construction_end" class="hasDatepickers"></td>
            <td><strong>Construction cost range</strong></td><td>
                <input type="text" id="construction_low" style="width:60px;"> to 
                <input type="text" id="construction_high" style="width:60px;"></td></tr>

        <tr><td><strong>Certificate of occupancy issued</strong></td><td>
                <input type="text" id="certificate_start" class="hasDatepickers"> to <input type="text" id="certificate_end" class="hasDatepickers"></td>
            <td><strong>Number of contracts (range)</strong></td><td>
                <input type="text" id="low_num_contracts" style="width:60px;"> to <input type="text" id="high_num_contracts" style="width:60px;"></td></tr>

        <tr><td><strong>Property is sold</strong></td><td>
                <input type="text" id="start_sold_date" class="hasDatepickers"> to <input type="text" id="end_sold_date" class="hasDatepickers"></td>
            <td><strong>Sale price range</strong></td><td>
                <input type="text" id="low_sale_price" style="width:60px;"> to <input type="text" id="high_sale_price" style="width:60px;"></td></tr>

        <tr>
            <td><strong>Possession or Occupancy</strong></td><td>
                <input type="text" id="possession_start" class="hasDatepickers"> to <input type="text" id="possession_end" class="hasDatepickers"></td>
            <td>  <strong>Days on Market (range)</strong></td><td>
                <input type="text" id="low_num_days" style="width:60px;"> to <input type="text" id="high_num_days" style="width:60px;"></td></tr>
        <tr><td colspan="2"></td>
            <td>
                <strong>Amount of subsidy/2nd mortgage range</strong></td><td>
                <input type="text" id="min_subsidy" style="width:60px;"> to <input type="text" id="max_subsidy" style="width:60px;"></td>

        </tr>
        <tr><td colspan="4"><input type="button" value="Click here to choose columns for this query" onclick="
                $.post(
                        '../ajax/property_search.php',
                        {
                            vacant: document.getElementById('vacant_search').value,
                            for_sale: document.getElementById('for_sale_search').value,
                            price_low: document.getElementById('low_price_search').value,
                            price_high: document.getElementById('high_price_range').value,
                            // owner_occ: document.getElementById('owner_occ_search').value,
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
                            possession_end: document.getElementById('possession_end').value
                        },
                function(response) {
                    document.getElementById('property_results').innerHTML = response;
                }
                ).fail(failAlert);">
            </td></tr>
    </table>
    <div id="property_results"></div>
    <p></p>
    
    </div>
<p></p>
<?php include "../../footer.php"; 
close_all_dbconn();
?>