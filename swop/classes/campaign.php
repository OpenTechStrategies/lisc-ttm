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
        $this->campaign_id = $campaign_id;
        $camp_query = "SELECT * FROM Campaigns WHERE Campaign_ID='$campaign_id'";
        include "../include/dbconnopen.php";
        $campaign_info = mysqli_query($cnnSWOP, $camp_query);
        
        //set public variables
        $campaign_info_temp = mysqli_fetch_array($campaign_info);
        
        $this->name = $campaign_info_temp['Campaign_Name'];
    }
}
?>
