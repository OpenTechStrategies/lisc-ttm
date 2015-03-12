<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

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