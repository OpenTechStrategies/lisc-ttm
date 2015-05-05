<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
if (!isLoggedIn()) {
    $die_unauthorized("Sorry, you must be logged in to access this page!");
}

    include 'GoogleMap.php';
    $map = new GoogleMapAPI('map');

function myGetGeocode($address, $map){
    $geocode = $map->geoGetCoords($address);
    return $geocode;
}
/*reference: http://jquery-howto.blogspot.com/2009/04/cross-domain-ajax-querying-with-jquery.html
 * http://www.json.org/js.html
 */

/*
 * 1. Read address
 * 2. Get lat/lon from Google Maps
 * 3. Use lat/lon to get block group
 * 4. Return block group into file.
 */
function do_it_all($address, $map){
    /*Don't want to add Chicago to the address if it doesn't exist or if it already has Chicago
     * in it.
     */
    if ($address!="0 0" && $address!="" && $address!=" " && $address!="0" && $address!==0){
        $check_chi=explode('Chicago', $address);
        if (!isset($check_chi[1])){
            $address.=" Chicago+IL";
        }
        /*format address for the geocoding call: */
        $new_address=str_replace(" ", "+", $address);
        
        $geo_url="http://maps.googleapis.com/maps/api/geocode/json?&address=$new_address&sensor=false";
        
        $geo_handle=fopen($geo_url, "r");
        /*if there was a response from the geocoding url, read the response into a string: */
       if ($geo_handle){
            while (!feof($geo_handle)){
                $buffer=fgets($geo_handle, 4096);
                $geo_result.=$buffer;
            }
            fclose($geo_handle);
        }
        else{
            echo "Nothing to open";
        }
       /*decode the results: */
        $geo_array=json_decode($geo_result, true);
        
        /*assign variables to results*/
        $lat= $geo_array[results][0][geometry][location][lat];
       
        $lon=$geo_array[results][0][geometry][location][lng];
        
        
    //if ($geocode['lat']!=""){
        
        /*if a latitude was returned: */
    if ($lat!=""){
        $api_result="";
        /*Use the latitude and longitude returned to get the block group: */
        //$get_url='http://data.fcc.gov/api/block/find?format=json&latitude='.$geocode['lat'].'&longitude='.$geocode['lon'].'&showall=true';
         $get_url='http://data.fcc.gov/api/block/find?format=json&latitude='.$lat.'&longitude='.$lon.'&showall=true';
        //echo $get_url;
       $handle=fopen($get_url, "r");
        
       if ($handle){
            while (!feof($handle)){
                $buffer=fgets($handle, 4096);
                $api_result.=$buffer;
            }
            fclose($handle);
        }
        else{
            echo "Nothing to open";
        }
        /*decode results from this API now: */
        $result_array=json_decode($api_result, true);
        /*return block group*/
        return $result_array[Block][FIPS];
       
    }
    else{
        return false;
    }
    }else{
        return false;
    }
}

//test call
echo do_it_all("0", $map);





?>
    



