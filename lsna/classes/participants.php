<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($LSNA_id);

class Participant {
    public $participant_id;
    public $participant_first_name;
    public $participant_last_name;

    /**
     * LSNA Participant empty constructor.
     *
     * @return Empty Participant object.
     */
    public function __construct() {
        
    }

    /**
     * Load Participant by participant id.
     *
     * @param string participant_id The participant_id of the participant that is being loaded.
     * @return array Loaded participant object array.
     */
    public function load_with_participant_id($participant_id) {
        
        //open DB
        include "../include/dbconnopen.php";
        $participant_id_sqlsafe=mysqli_real_escape_string($cnnLSNA, $participant_id);
        //set participant_id
        $this->participant_id = $participant_id_sqlsafe;

        //echo "Call participant__Load_With_ID('" . $this->participant_id . "')";
        $participant_info = mysqli_query($cnnLSNA, "Call Participant__Load_With_ID('" . $this->participant_id . "')");

        //set public variables
        $participant_info_temp = mysqli_fetch_array($participant_info);

        //$this->participant_id = $participant_info_temp['participant_ID']; 
        $this->participant_first_name = $participant_info_temp['Name_First'];
        $this->participant_last_name = $participant_info_temp['Name_Last'];
        $this->gender = $participant_info_temp['Gender'];
        $this->address_full = $participant_info_temp['Address_Street_Num'] . " " . $participant_info_temp['Address_Street_Direction'] . " " .
                $participant_info_temp['Address_Street_Name'] . " " . $participant_info_temp['Address_Street_Type'] .
                "<br> " . $participant_info_temp['Address_City'] . ", " .
                $participant_info_temp['Address_State'] . " " . $participant_info_temp['Address_Zip'];
        $this->address_street = $participant_info_temp['Address_Street_Name'];
        $this->address_num = $participant_info_temp['Address_Street_Num'];
        $this->address_direction = $participant_info_temp['Address_Street_Direction'];
        $this->address_street_type = $participant_info_temp['Address_Street_Type'];
        $this->city = $participant_info_temp['Address_City'];
        $this->state = $participant_info_temp['Address_State'];
        $this->zip = $participant_info_temp['Address_Zip'];
        $this->ward = $participant_info_temp['Ward'];
        $this->email = $participant_info_temp['Email'];
        $this->full_name = $participant_info_temp['Name_First'] . " " . $participant_info_temp['Name_Middle'] . " " . $participant_info_temp['Name_Last'];
        $this->phone_day = $participant_info_temp['Phone_Day'];
        $this->phone_evening = $participant_info_temp['Phone_Evening'];
        $this->education = $participant_info_temp['Education_Level'];
        $this->age = $participant_info_temp['Age'];
        $this->consent_2013_14 = $participant_info_temp['Consent_2013_14'];
        $this->consent_2014_15 = $participant_info_temp['Consent_2014_15'];
        $this->consent_2015_16 = $participant_info_temp['Consent_2015_16'];
        $date_reformat = explode('-', $participant_info_temp['Date_of_Birth']);
        $save_date = $date_reformat[1] . '-' . $date_reformat[2] . '-' . $date_reformat[0];
        $this->dob = $save_date;
        $this->grade = $participant_info_temp['Grade_Level'];
        $this->pm = $participant_info_temp['Is_PM'];
        $this->child = $participant_info_temp['Is_Child'];
        $this->notes = $participant_info_temp['Notes'];

        //close DB
        include '../include/dbconnclose.php';

        return $participant_info;
    }

    /*
     * @param the participant id
     * @return array of roles.
     */

    public function get_roles() {
        include "../include/dbconnopen.php";
        $user_roles_query = "SELECT * FROM Participants_Roles INNER JOIN Roles ON Participants_Roles.Role_ID=Roles.Role_ID
            WHERE Participant_ID='" . $this->participant_id . "'";
        //echo $user_roles_query;
        $roles = mysqli_query($cnnLSNA, $user_roles_query);

        include "../include/dbconnclose.php";

        return $roles;
    }

    /*
     * @param the participant id
     * @return array of languages spoken.
     */

    public function get_languages() {
        include "../include/dbconnopen.php";
        $user_roles_query = "SELECT * FROM Participants_Languages INNER JOIN Languages ON Participants_Languages.Language_ID=Languages.Language_ID
            WHERE Participant_ID='" . $this->participant_id . "' GROUP BY Languages.Language_ID";
        // echo $user_roles_query;
        $langs = mysqli_query($cnnLSNA, $user_roles_query);

        include "../include/dbconnclose.php";

        return $langs;
    }

    /*
     * @param the participant id
     * @return the array of participants' children.
     */

    public function get_children() {
        include "../include/dbconnopen.php";
        $find_children = "SELECT * FROM Parent_Mentor_Children INNER JOIN Participants ON Parent_Mentor_Children.Child_ID=Participants.Participant_ID
            WHERE Parent_ID='" . $this->participant_id . "'";
        $children = mysqli_query($cnnLSNA, $find_children);
        include "../include/dbconnclose.php";

        return $children;
    }

    /*
     * @param the participant id
     * @return the array of participants' parents.
     */

    public function get_parents() {
        include "../include/dbconnopen.php";
        $find_parents = "SELECT * FROM Parent_Mentor_Children INNER JOIN Participants ON Parent_Mentor_Children.Parent_ID=Participants.Participant_ID
            WHERE Child_ID='" . $this->participant_id . "'";
        $parents = mysqli_query($cnnLSNA, $find_parents);
        include "../include/dbconnclose.php";

        return $parents;
    }
    
    /*
     * @param the participant id
     * @return the array of participants' spouse(s).
     */

    public function get_spouse_of_person() {
        include "../include/dbconnopen.php";
        $find_spouses = "SELECT * FROM Parent_Mentor_Children INNER JOIN Participants ON Parent_Mentor_Children.Spouse_ID=Participants.Participant_ID
            WHERE Parent_ID='" . $this->participant_id . "'";
       // echo $find_spouses;
        $spouses = mysqli_query($cnnLSNA, $find_spouses);
        include "../include/dbconnclose.php";

        return $spouses;
    }
    
      /*
     * @param the participant id
     * @return the array of participants' spouse(s).
     */

    public function get_spouse_of_spouse() {
        include "../include/dbconnopen.php";
        $find_spouses = "SELECT * FROM Parent_Mentor_Children INNER JOIN Participants ON Parent_Mentor_Children.Parent_ID=Participants.Participant_ID
            WHERE Spouse_ID='" . $this->participant_id . "'";
       // echo $find_spouses;
        $spouses = mysqli_query($cnnLSNA, $find_spouses);
        include "../include/dbconnclose.php";

        return $spouses;
    }

    /*
     * @param the participant id
     * @return the array of growth (obsolete, because this has to do with adult ed, which 
     * is not being recorded in the DB right now).
     */

    public function get_growth() {
        include "../include/dbconnopen.php";
        $find_growth = "SELECT * FROM Participants_Growth 
            WHERE Participant_ID='" . $this->participant_id . "'";
        $growth = mysqli_query($cnnLSNA, $find_growth);
        include "../include/dbconnclose.php";
        return $growth;
    }

    /*
     * @param the participant id
     * @return the array of institutions.
     */

    public function get_institutions() {
        include "../include/dbconnopen.php";
        $find_institutions = "SELECT * FROM Institutions_Participants 
            WHERE Participant_ID='" . $this->participant_id . "'";
        $institutions = mysqli_query($cnnLSNA, $find_institutions);
        include "../include/dbconnclose.php";
        return $institutions;
    }
}
?>