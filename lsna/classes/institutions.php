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

class Institution {

	public $institution_id;
	
	public function __construct() {
	
	}
	
        
        /*
         * @param the institution id
         * @return array of basic institutional info
         */
	public function load_with_institution_id($institution_id) {
		include "../include/dbconnopen.php";
                $institution_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $institution_id);
		$this->institution_id = $institution_id_sqlsafe;
		
                //$inst_query = "Call Institution__Load_With_ID('" . $this->institution_id . "')";
                $inst_query = "SELECT * FROM Institutions WHERE Institution_ID='" . $this->institution_id . "'";
		$institution_info = mysqli_query($cnnLSNA, $inst_query);
		$institution_info_temp = mysqli_fetch_array($institution_info);
		
		$this->institution_name = $institution_info_temp['Institution_Name'];
		$this->institution_type = $institution_info_temp['Institution_Type'];
		$this->address_num = $institution_info_temp['Street_Num'];
		$this->address_dir = $institution_info_temp['Street_Direction'];
		$this->address_street = $institution_info_temp['Street_Name'];
		$this->address_street_type = $institution_info_temp['Street_Type'];
                $this->address_full = $institution_info_temp['Street_Num'] . " " . $institution_info_temp['Street_Direction'] . " ".
                       $institution_info_temp['Street_Name'] . " " .  $institution_info_temp['Street_Type'];
		
		include "../include/dbconnclose.php";
		return $institution_info;
	}

       
            /*
            * @param the institution id
            * @return array of programs that take place at this inst.
            */
            public function get_related_programs(){
                include "../include/dbconnopen.php";
                $get_programs = "SELECT * FROM Subcategories INNER JOIN Institutions_Subcategories
                    ON Subcategories.Subcategory_ID=Institutions_Subcategories.Subcategory_ID
                    WHERE Institutions_Subcategories.Institution_ID='" . $this->institution_id . "'";
                //echo $user_roles_query;
                $programs = mysqli_query($cnnLSNA, $get_programs);

                include "../include/dbconnclose.php";

                return $programs;
            }
            
            /*
            * @param the institution id
            * @return array of participants that are involved with this inst.
            */
            public function get_related_participants(){
                include "../include/dbconnopen.php";
                $get_participants = "SELECT * FROM Participants INNER JOIN Institutions_Participants
                    ON Participants.Participant_ID=Institutions_Participants.Participant_ID
                    WHERE Institutions_Participants.Institution_ID='" . $this->institution_id . "'";
                //echo $user_roles_query;
                $participants = mysqli_query($cnnLSNA, $get_participants);

                include "../include/dbconnclose.php";

                return $participants;
            }
}
?>