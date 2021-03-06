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

user_enforce_has_access($LSNA_id);

class Program
{
    
    public $program_id; //contact id.
    
    
    /**
     * LSNA program empty constructor.
     *
     * @return Empty program object.
     */
    public function __construct()
    {
        
    }

    /**
     * Load program by program id.
     *
     * @param int program_id The program_id of the program that is being loaded.
     * @return array Loaded program object array.
     */
    public function load_with_program_id($program_id)
    {
        //open DB
        include "../include/dbconnopen.php";
        //set program_id
        $program_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $program_id);
        $this->program_id = $program_id_sqlsafe;

        //echo "Call Program__Load_With_ID('" . $this->program_id . "')";
        $program_info = mysqli_query($cnnLSNA, "SELECT * FROM Subcategories WHERE Subcategory_ID='" . $this->program_id . "'");
        //echo "SELECT * FROM Subcategories WHERE Subcategory_ID='" . $this->program_id . "'";
        //set public variables
        $program_info_temp = mysqli_fetch_array($program_info);

        $this->issue_type = $program_info_temp['Campaign_or_Program']; 
        $this->program_name = $program_info_temp['Subcategory_Name'];
        $this->is_organizing = $program_info_temp['Is_Organizing'];
        $this->notes = $program_info_temp['Notes'];
        
        //close DB
        include '../include/dbconnclose.php';
        
        //return program info
        return $program_info;
    }
    
    /*
     * @param program_id
     * @return array of dates
     */
    public function get_dates(){
        include "../include/dbconnopen.php";
        $program_dates_query = "SELECT * FROM Subcategory_Dates LEFT JOIN (Subcategories) ON (Subcategories.Subcategory_ID=Subcategory_Dates.Subcategory_ID) LEFT JOIN Institutions ON Funder_ID = Institution_ID WHERE Subcategory_Dates.Subcategory_ID='" . $this->program_id . "' ORDER BY Date";
        //echo $program_dates_query;
        $dates = mysqli_query($cnnLSNA, $program_dates_query);
        include "../include/dbconnclose.php";
        
        return $dates;
    }
    
    /*
     * @param program id
     * @return array of users linked to this program
     */
    public function get_users(){
        include "../include/dbconnopen.php";
        $program_users_query = "SELECT * FROM Participants
                                LEFT JOIN (Participants_Subcategories)
                                    ON (Participants.Participant_ID=Participants_Subcategories.Participant_ID)
                                WHERE Participants_Subcategories.Subcategory_ID='" . $this->program_id . "' 
                                ORDER BY Name_Last, Name_First";
        //echo $program_users_query;
        $users = mysqli_query($cnnLSNA, $program_users_query);
        include "../include/dbconnclose.php";
        
        return $users;
    }
    
        /*
     * @param program id
     * @return array of clc(s)
         * obsolete, since CLCs aren't actually used this way in the final DB
     */
    public function get_clc(){
        include "../include/dbconnopen.php";
        $program_clc_query = "SELECT * FROM CLCs LEFT JOIN (CLC_Subcategory)
                                ON (CLCs.CLC_ID=CLC_Subcategory.CLC_ID)
                                WHERE CLC_Subcategory.Subcategory_ID='" . $this->program_id . "'";
        //echo $program_users_query;
        $clc = mysqli_query($cnnLSNA, $program_clc_query);
        include "../include/dbconnclose.php";
        
        return $clc;
    }
	
	//return array of institutions related to this program.
	
	public function get_institutions(){
		include "../include/dbconnopen.php";
		$program_inst_query = "SELECT * FROM Institutions LEFT JOIN (Institutions_Subcategories)
								ON (Institutions.Institution_ID=Institutions_Subcategories.Institution_ID)
								WHERE Institutions_Subcategories.Subcategory_ID='" . $this->program_id . "' ORDER BY Institution_Name";
                //echo $program_inst_query;
		$institutions = mysqli_query($cnnLSNA, $program_inst_query);
		include "../include/dbconnclose.php";
		
		return $institutions;
	}
    
}


?>