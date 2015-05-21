<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
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
