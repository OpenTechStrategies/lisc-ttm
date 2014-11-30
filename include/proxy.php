<?php
$api_result="";
$get_url='http://data.fcc.gov/api/block/find?format=json&latitude='.$_GET['lat'].'&longitude='.$_GET['lon'].'&showall=true';
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

$result_array=json_decode($api_result, true);
echo $result_array[Block][FIPS];
?>
