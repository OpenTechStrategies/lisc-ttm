<?php
//echo 'test <br>';
//header('Content-type: application/xml');
//print_r($_GET);
$api_result="";
$get_url='http://data.fcc.gov/api/block/find?format=json&latitude='.$_GET['lat'].'&longitude='.$_GET['lon'].'&showall=true';
//echo $get_url ."<br>";
//echo file_get_contents($get_url);
//echo "<br>";
$handle=fopen($get_url, "r");
//print_r($handle);
//echo "<br>";
if ($handle){
   // echo "Handle opened <br>";
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
//print_r($result_array);
echo $result_array[Block][FIPS];
//$_COOKIE['block']=setcookie('block', 0, time()-3600, '/');
//$_COOKIE['block']=setcookie('block', $result_array[Block][FIPS], time()+3600, '/');
        
        ?>
