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
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");
user_enforce_has_access($SWOP_id);

class Property
{
    /* returns empty Property object */
    public function  __construct()
    {
        
    }
    
    /*
     * @param: the property ID
     * @return: array of basic information about a property from the Properties table.
     */
    
     public function load_with_id($property_id)
    {
        
        include "../include/dbconnopen.php";
        $property_id_sqlsafe=mysqli_real_escape_string($cnnSWOP, $property_id);
        $this->property_id = $property_id_sqlsafe;
        $prop_query = "SELECT * FROM Properties LEFT JOIN Property_Dispositions ON Properties.Disposition=Property_Dispositions.Disposition_ID
            WHERE Property_ID='$property_id_sqlsafe'";
        $property_info = mysqli_query($cnnSWOP, $prop_query);
        
        //set public variables
        $property_info_temp = mysqli_fetch_array($property_info);
        
        $this->full_address = $property_info_temp['Address_Street_Num'] . " " . $property_info_temp['Address_Street_Direction'] . " ".
                         $property_info_temp['Address_Street_Name'] . " ".$property_info_temp['Address_Street_Type'] . " " . $property_info_temp['Zipcode'];
        $this->street_num = $property_info_temp['Address_Street_Num'];
        $this->street_dir=$property_info_temp['Address_Street_Direction'];
        $this->street_name=$property_info_temp['Address_Street_Name'];
        $this->street_type=$property_info_temp['Address_Street_Type'];
        $this->zipcode=$property_info_temp['Zipcode'];
        $this->pin=$property_info_temp['PIN'];
        $this->price=$property_info_temp['Sale_Price'];
        $this->vacant=$property_info_temp['Is_Vacant'];
        $this->acquired=$property_info_temp['Is_Acquired'];
        $this->rehabbed=$property_info_temp['Is_Rehabbed'];
        $this->investment=$property_info_temp['Rehabbed_Investment'];
        $this->disposition=$property_info_temp['Disposition_Name'];
        $this->disposition_id=$property_info_temp['Disposition_ID'];
        $this->construction_type=$property_info_temp['Construction_Type'];
        $this->home_size=$property_info_temp['Home_Size'];
        $this->prop_type=$property_info_temp['Property_Type'];
    }
    
}
?>
