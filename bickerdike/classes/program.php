<?php
class Program
{
    
    public $program_id; //contact id.
    public $program_first_name; 
    public $program_last_name;
    public $program_zipcode;
    
    
    /**
     * Bickerdike program empty constructor.
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
        $program_id_sqlsafe=mysqli_real_escape_string($cnnBickerdike, $program_id);
        //set program_id
        $this->program_id = $program_id_sqlsafe;

        $query_sqlsafe = "SELECT * FROM Programs WHERE Program_ID='" . $this->program_id . "'";
        //echo $query_sqlsafe;
        $program_info = mysqli_query($cnnBickerdike, $query_sqlsafe);
        
        //set public variables
        $program_info_temp = mysqli_fetch_array($program_info);

        //$this->program_id = $program_info_temp['program_ID']; 
        $this->program_name = $program_info_temp['Program_Name'];
        $this->organization = $program_info_temp['Program_Organization'];
        $this->type = $program_info_temp['Program_Type'];
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
        $program_dates_query_sqlsafe = "SELECT * FROM Program_Dates LEFT JOIN (Programs)
                                ON (Programs.Program_ID=Program_Dates.Program_ID) WHERE Program_Dates.Program_ID='" . $this->program_id . "'
                                    ORDER BY Program_Date";
        $dates = mysqli_query($cnnBickerdike, $program_dates_query_sqlsafe);
        include "../include/dbconnclose.php";
        
        return $dates;
    }
    
    /*
     * @param program id
     * @return array of users
     */
    public function get_users(){
        include "../include/dbconnopen.php";
        $program_users_query_sqlsafe = "SELECT * FROM Users LEFT JOIN (Programs_Users, Programs)
                                ON (Programs.Program_ID=Programs_Users.Program_ID AND Users.User_ID=Programs_Users.User_ID)
                                WHERE Programs_Users.Program_ID='" . $this->program_id . "'";
        $users = mysqli_query($cnnBickerdike, $program_users_query_sqlsafe);
        include "../include/dbconnclose.php";
        
        return $users;
    }
    
}


?>