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

user_enforce_has_access($Enlace_id);

/*
 * Campaign class.  didn't end up using this for much (just getting the campaign name...)
 * but it's here in case more functions are needed.
 */
class Campaign
{
    public function  __construct()
    {
        
    }
    
     public function load_with_id($campaign_id)
    {
        include "../include/dbconnopen.php";
        $this->campaign_id = mysqli_real_escape_string($cnnEnlace, $campaign_id);
        $camp_query = "SELECT * FROM Campaigns WHERE Campaign_ID= '" . $this->campaign_id . "'";
        $campaign_info = mysqli_query($cnnEnlace, $camp_query);
        
        //set public variables
        $campaign_info_temp = mysqli_fetch_array($campaign_info);
        
        $this->name = $campaign_info_temp['Campaign_Name'];
    }
}
?>
