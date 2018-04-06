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

class Program {
    public $program_id; //contact id.

    /**
     * Enlace program empty constructor.
     *
     * @return Empty program object.
     */
    public function __construct() {
        
    }

    /**
     * Load program by program id.
     *
     * @param int program_id The program_id of the program that is being loaded.
     * @return array Loaded program object array.
     */
    public function load_with_program_id($program_id) {
        include "../include/dbconnopen.php";
        $program_id_sqlsafe=mysqli_real_escape_string($cnnEnlace, $program_id);
        $this->program_id = $program_id_sqlsafe;
        $get_program_info = "SELECT * FROM Programs LEFT JOIN Institutions ON Host=Inst_ID WHERE Program_ID='$program_id_sqlsafe'";
        include "../include/dbconnopen.php";
        $program_info = mysqli_query($cnnEnlace, $get_program_info);
        $temp_program = mysqli_fetch_array($program_info);
        include "../include/dbconnclose.php";

        $this->name = $temp_program['Name'];
        $this->instid = $temp_program['Inst_ID'];
        $this->host = $temp_program['Institution_Name'];
        $this->start = $temp_program['Start_Date'];
        $this->end = $temp_program['End_Date'];
        /* the beginning and ending times are used to calculate the max hours, so we have the ->begin and ->begin_calc
         * variables.
         */
        if ($temp_program['Start_Suffix'] == 'am') {
            if ($temp_program['Start_Hour'] != 12) {
                $this->begin = $temp_program['Start_Hour'] . " AM";
            } else {
                $this->begin = '12 Noon';
            }
            $this->begin_calc = $temp_program['Start_Hour'];
        } elseif ($temp_program['Start_Suffix'] == 'pm') {
            $this->begin = $temp_program['Start_Hour'] . " PM";
            $this->begin_calc = $temp_program['Start_Hour'] + 12;
        } else {
            $this->begin = 0;
        }
        if ($temp_program['End_Suffix'] == 'am') {
            if ($temp_program['End_Hour'] != 12) {
                $this->finish = $temp_program['End_Hour'] . " AM";
            } else {
                $this->finish = '12 Noon';
            }
            $this->finish_calc = $temp_program['End_Hour'];
        } elseif ($temp_program['End_Suffix'] == 'pm') {
            $this->finish = $temp_program['End_Hour'] . " PM";
            $this->finish_calc = $temp_program['End_Hour'] + 12;
        } else {
            $this->finish = 0;
        }
        $this->daily_hrs = (($this->finish_calc) - ($this->begin_calc));
        if ($temp_program['Max_Hours'] != '') {
            $this->max_hrs = $temp_program['Max_Hours'];
        } else {
            $this->max_hrs = ($this->daily_hrs) * $this->get_num_days();
        }
        $this->class_act = $temp_program['Activity_Class'];
        $this->clinic = $temp_program['Activity_Clinic'];
        $this->referrals = $temp_program['Activity_Referrals'];
        $this->community = $temp_program['Activity_Community'];
        $this->counseling = $temp_program['Activity_Counseling'];
        $this->sport = $temp_program['Activity_Sports'];
        $this->mentor = $temp_program['Activity_Mentor'];
        $this->service = $temp_program['Activity_Service'];
        $this->monday = $temp_program['Monday'];
        $this->tuesday = $temp_program['Tuesday'];
        $this->wednesday = $temp_program['Wednesday'];
        $this->thursday = $temp_program['Thursday'];
        $this->friday = $temp_program['Friday'];
        $this->saturday = $temp_program['Saturday'];
        $this->sunday = $temp_program['Sunday'];
    }

    /*
     * Whether or not the program is on any days of the week
     */

    public function on_at_least_one_day()  {
        return
            $this->monday == 1 ||
            $this->tuesday == 1 ||
            $this->wednesday == 1 ||
            $this->thursday == 1 ||
            $this->friday == 1 ||
            $this->saturday == 1 ||
            $this->sunday == 1;
    }

    /*
     * Get total number of days per program
     * 
     *  
     */

    public function get_num_days() {
        $count_days = "SELECT COUNT(*) FROM Program_Dates WHERE Program_ID='$this->program_id'";
        include "../include/dbconnopen.php";
        $days = mysqli_query($cnnEnlace, $count_days);
        $num_days = mysqli_fetch_row($days);
        include "../include/dbconnclose.php";
        return $num_days[0];
    }
}
?>
