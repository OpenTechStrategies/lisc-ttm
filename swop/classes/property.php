<?php

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
        $this->property_id = $property_id;
        $prop_query = "SELECT * FROM Properties LEFT JOIN Property_Dispositions ON Properties.Disposition=Property_Dispositions.Disposition_ID
            WHERE Property_ID='$property_id'";
        include "../include/dbconnopen.php";
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
