<?php

class Participant
{
    
    public $participant_id; 
    public $participant_first_name; 
    public $participant_last_name;
    
    /**
     * SWOP User empty constructor.
     *
     * @return Empty User object.
     */
    public function __construct()
    {
        
    }
    
    /**
     * Load User by user id.
     *
     * @param string user_id The user_id of the user that is being loaded.
     * @return array Loaded user object array.
     */
    public function load_with_participant_id($participant_id)
    {
        $this->participant_id = $participant_id;

        //open DB
        include "../include/dbconnopen.php";
        $load_query="SELECT * FROM Participants WHERE Participant_ID='" . $this->participant_id . "'";
        $participant_info = mysqli_query($cnnSWOP, $load_query);
        
        //set public variables
        $participant_info_temp = mysqli_fetch_array($participant_info);

        //$this->participant_id = $participant_info_temp['participant_ID']; 
        $this->participant_first_name = $participant_info_temp['Name_First'];
        $this->participant_last_name = $participant_info_temp['Name_Last'];
        $this->gender = $participant_info_temp['Gender'];
            $address_info="SELECT Address_Street_Num, Address_Street_Direction, Address_Street_Name, Address_Street_Type 
                    FROM Participants_Properties INNER JOIN Properties ON Participants_Properties.Property_ID=
                    Properties.Property_ID WHERE Primary_Residence=1 AND Participant_ID='" . $this->participant_id . "' AND (End_Primary IS NULL
                    OR End_Primary='0000-00-00 00:00:00')";
            $address=mysqli_query($cnnSWOP, $address_info);
            $address_info_temp=mysqli_fetch_array($address);
            $this->address_full = $address_info_temp['Address_Street_Num'] . " " .$address_info_temp['Address_Street_Direction'] . " ".
                    $address_info_temp['Address_Street_Name']  . " ".$address_info_temp['Address_Street_Type'];
//        $this->address_street = $participant_info_temp['Address_Street_Name'];
//        $this->address_num = $participant_info_temp['Address_Street_Num'];
//        $this->address_direction = $participant_info_temp['Address_Street_Direction'];
//        $this->address_street_type = $participant_info_temp['Address_Street_Type'];
//        $this->city = $participant_info_temp['Address_City'];
//        $this->state = $participant_info_temp['Address_State'];
//        $this->zip = $participant_info_temp['Address_Zip'];
	$this->email = $participant_info_temp['Email'];
        $this->full_name = $participant_info_temp['Name_First'] . " " . $participant_info_temp['Name_Middle'] . " " . $participant_info_temp['Name_Last'];
        $this->phone_day = $participant_info_temp['Phone_Day'];
        $this->phone_evening = $participant_info_temp['Phone_Evening'];
        $primary_organizer_name="SELECT Name_First, Name_Last FROM Participants WHERE Participant_ID='" . $participant_info_temp['Primary_Organizer'] . "'";
        $organizer_name=mysqli_query($cnnSWOP, $primary_organizer_name);
        $organizer=mysqli_fetch_row($organizer_name);
        $this->organizer=$organizer[0] . " " . $organizer[1];
        $this->organizer_id= $participant_info_temp['Primary_Organizer'];
        $this->first_interacted=$participant_info_temp['First_Interaction_Date'];
        
        include "../include/dbconnclose.php";
    }
    
    /**
     *Get finances for participants that are in the pool
     *
     * @param string user_id The user_id of the user that is being loaded.
     * @return array Loaded user object array.
     */
    public function get_finances()
    {
        $finance_query = "SELECT * FROM Pool_Finances INNER JOIN Current_Housing
            ON Pool_Finances.Current_Housing=Current_Housing.Current_Housing_ID WHERE Participant_ID='" . $this->participant_id . "'";
       // echo $finance_query;
        include "../include/dbconnopen.php";
        $finances = mysqli_query($cnnSWOP, $finance_query);
        include "../include/dbconnclose.php";
        $credit_array=array();
        $income_array=array();
        $current_hous_array = array();
        $house_loc_array=array();
        $house_cost_array=array();
        $employment_array=array();
        $assets_array=array();
        $dates_array=array();
        while ($fin = mysqli_fetch_array($finances)){
            $credit_array[]=$fin['Credit_Score'];
            $income_array[]=$fin['Income'];
            $current_hous_array[]= $fin['Current_Housing_Name'];
            $house_loc_array[]=$fin['Household_Location'];
            $house_cost_array[]=$fin['Housing_Cost'];
            $employment_array[]=$fin['Employment'];
            $assets_array[]=$fin['Assets'];
            $dates_array[]=$fin['Date_Logged'];
        }
        $all_array=array($credit_array, $income_array, $current_hous_array, $house_loc_array, $house_cost_array, $employment_array, $assets_array, $dates_array);
        return $all_array;
    }
    
    /*
     *Get the member type name for pool members (ex: needs loan extension)
     */
    public function get_type(){
        $get_this_type="SELECT Type_Name FROM Pool_Status_Changes INNER JOIN Pool_Member_Types ON Pool_Status_Changes.Member_Type=
            Pool_Member_Types.Type_ID 
            INNER JOIN (SELECT max(Date_Changed) as lastdate FROM Pool_Status_Changes
        WHERE Participant_ID='" . $this->participant_id . "' AND Pool_Status_Changes.Active=1) laststatus
        ON Pool_Status_Changes.Date_Changed=laststatus.lastdate 
            WHERE Participant_ID='" . $this->participant_id . "' AND Pool_Status_Changes.Active=1";
        //echo $get_this_type;
        include "../include/dbconnopen.php";
        $this_type = mysqli_query($cnnSWOP, $get_this_type);
        $type=mysqli_fetch_row($this_type);
        include "../include/dbconnclose.php";
        
        return $type[0];
    }
    
    /*
     *Get the member type id for pool members 
     */
    public function get_type_id(){
        $get_this_type="SELECT Member_Type FROM Pool_Status_Changes 
            INNER JOIN (SELECT max(Date_Changed) as lastdate FROM Pool_Status_Changes
        WHERE Participant_ID='" . $this->participant_id . "' AND Pool_Status_Changes.Active=1) laststatus
        ON Pool_Status_Changes.Date_Changed=laststatus.lastdate
        WHERE Participant_ID='" . $this->participant_id . "'";
        //echo $get_this_type;
        include "../include/dbconnopen.php";
        $this_type = mysqli_query($cnnSWOP, $get_this_type);
        $type=mysqli_fetch_row($this_type);
        include "../include/dbconnclose.php";
        
        return $type[0];
    }
    
    /*
     * Find the most current address listed for the given participant (property with Primary_Residence=1 and most recently logged)
     */
    public function get_address(){
        $get_addresses = "SELECT * FROM Participants_Addresses WHERE Participant_ID='" . $this->participant_id . "' ORDER BY Date_Logged DESC";
       // echo $get_addresses;
        include "../include/dbconnopen.php";
        $this_type = mysqli_query($cnnSWOP, $get_addresses);
        $address=mysqli_fetch_array($this_type);
        include "../include/dbconnclose.php";
        $this->address_full = $address['Address_Num'] . " " .$address['Address_Dir'] . " ".
                $address['Address_Street']  . " ".$address['Street_Type'] .
                "<br> " .$address['Address_City'] . ", " . 
                        $address['Address_State'] ." " .$address['Address_Zip'];
        $this->address_street = $address['Address_Street'];
        $this->address_num = $address['Address_Num'];
        $this->address_direction = $address['Address_Dir'];
        $this->address_street_type = $address['Street_Type'];
        $this->city = $address['Address_City'];
        $this->state = $address['Address_State'];
        $this->zip = $address['Address_Zip'];
    }
    
    /*
     * Find the progress over time of the participant's leadership development.  This refers to the "details" - these show up
     * on the site as checkboxes, and in the database in the "Leadership_Development" and "Leadership_Development_Details" tables.
     */
    public function get_leadership_development(){
        $get_leadership = "SELECT Detail_ID, Date FROM Leadership_Development WHERE Participant_ID='" . $this->participant_id . "' ORDER BY Detail_ID;";
        include "../include/dbconnopen.php";
        $leader_details = mysqli_query($cnnSWOP, $get_leadership);
        while ($leader=mysqli_fetch_row($leader_details)){
            $name='detail_'.$leader[0];
            $this->$name=$leader[1];
        }
        //print_r(get_defined_vars());
        include "../include/dbconnclose.php";
    }
    
    /*
     * Since we'll want to track potentially multiple employers
     * returns the set of employers that have been entered for this person.
     */
    public function get_employers(){
        $get_employment="SELECT * FROM Pool_Employers WHERE Participant_ID='" . $this->participant_id . "'";
        include "../include/dbconnopen.php";
        $employ_details = mysqli_query($cnnSWOP, $get_employment);
           //print_r(get_defined_vars());
        include "../include/dbconnclose.php";
        return $employ_details;
    }
}
?>
