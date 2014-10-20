<?php
class User
{
    
    public $user_id; //contact id.
    public $user_first_name; 
    public $user_last_name;
    public $user_zipcode;
    
    
    /**
     * Bickerdike User empty constructor.
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
    public function load_with_user_id($user_id)
    {
        //open DB
        include "../include/dbconnopen.php";
        $user_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $user_id);
        //set user_id
        $this->user_id = $user_id_sqlsafe;

        $str_sqlsafe = "Call User__Load_With_ID('" . $this->user_id . "')";

        //echo $str_sqlsafe;
        $user_info = mysqli_query($cnnBickerdike, $str_sqlsafe);
        
        //set public variables
        $user_info_temp = mysqli_fetch_array($user_info);

        //$this->user_id = $user_info_temp['user_ID']; 
        $this->user_first_name = $user_info_temp['First_Name'];
        $this->user_last_name = $user_info_temp['Last_Name'];
        $this->full_name = $user_info_temp['First_Name'] . " " . $user_info_temp['Last_Name'];
        $this->user_zipcode = $user_info_temp['Zipcode'];
        $this->gender = $user_info_temp['Gender'];
        $this->age = $user_info_temp['Age'];
        $this->race = $user_info_temp['Race'];
        $this->address_street = $user_info_temp['Address_Street_Name'];
		$this->address_number = $user_info_temp['Address_Number'];
		$this->address_direction = $user_info_temp['Address_Street_Direction'];
		$this->address_street_type = $user_info_temp['Address_Street_Type'];
		$this->email = $user_info_temp['email_address'];
        $this->notes = $user_info_temp['Notes'];
        $this->phone = $user_info_temp['Phone'];

        
        //close DB
        include '../include/dbconnclose.php';
        
        //return user info
        return $user_info;
    }
    
    /*
     * @param the user id
     * @return array of health data over time.
     */
    public function get_health_data(){
        include "../include/dbconnopen.php";
        $user_health_data_query_sqlsafe = "SELECT * FROM User_Health_Data WHERE User_ID='" . $this->user_id . "'";
        $health_data = mysqli_query($cnnBickerdike, $user_health_data_query_sqlsafe);
        
        include "../include/dbconnclose.php";
        
        return $health_data;
    }
    
    /*
     * @param the user id
     * @return array of activities that the user participated in.
     */
    public function get_activities(){
        include "../include/dbconnopen.php";
        $user_activities_query_sqlsafe = "SELECT DISTINCT User_Established_Activity_ID FROM Activities_Users WHERE User_ID='" . $this->user_id . "'";
        //echo $user_activities_query_sqlsafe;
        $activities = mysqli_query($cnnBickerdike, $user_activities_query_sqlsafe);
        include "../include/dbconnclose.php";
        
        return $activities;
    }
    
    /*
     * @param the user id
     * @return array of programs that the user participated in.
     */
    public function get_programs(){
        include "../include/dbconnopen.php";
        $user_programs_query_sqlsafe = "SELECT * FROM Programs LEFT JOIN (Programs_Users)
                                ON (Programs_Users.Program_ID=Programs.Program_ID) WHERE Programs_Users.User_ID='" . $this->user_id . "'";
        //echo $user_activities_query_sqlsafe;
        $programs = mysqli_query($cnnBickerdike, $user_programs_query_sqlsafe);
        include "../include/dbconnclose.php";
        
        return $programs;
    }
    
    /*
     * @param the user id
     * @return array of surveys that the user completed.
     */
    public function get_surveys(){
        include "../include/dbconnopen.php";
        $user_surveys_query_sqlsafe = "SELECT * FROM Participant_Survey_Responses 
    INNER JOIN Programs
    ON Programs.Program_ID=Participant_Survey_Responses.Program_ID
WHERE User_ID='" . $this->user_id . "'";
        //echo $user_activities_query_sqlsafe;
        $surveys = mysqli_query($cnnBickerdike, $user_surveys_query_sqlsafe);
        include "../include/dbconnclose.php";
        
        return $surveys;
    }
    
}


?>