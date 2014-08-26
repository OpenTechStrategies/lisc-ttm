<?php


class Campaign
{
    /*
     * empty constructor for a Campaign object
     */
    public function  __construct()
    {
        
    }
    
    /*
     * @param campaign id
     * @return campaign name
     */
    
     public function load_with_id($campaign_id)
    {
        include "../include/dbconnopen.php";
        $campaign_id_sqlsafe=mysqli_real_escape_string($cnnSWOP, $campaign_id);
        $this->campaign_id = $campaign_id_sqlsafe;
        $camp_query_sqlsafe = "SELECT * FROM Campaigns WHERE Campaign_ID='$campaign_id_sqlsafe'";
        $campaign_info = mysqli_query($cnnSWOP, $camp_query_sqlsafe);
        
        //set public variables
        $campaign_info_temp = mysqli_fetch_array($campaign_info);
        
        $this->name = $campaign_info_temp['Campaign_Name'];
    }
}
?>
