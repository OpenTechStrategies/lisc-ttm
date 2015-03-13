<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php");

user_enforce_has_access($LSNA_id);

?>
<div id="participant_roles">
    <!--Records how many people had each role for each campaign.  Parent mentors are broken out at the bottom.
    -->
    <h4>Participant Roles</h4>
    <?php include "../classes/program.php";?>
    <table class="all_projects">
        <tr><th></th><th>Attendee</th>
            <th>Speaker</th>
            <th>Chairperson</th>
            <th>Prep Work</th>
			<th>Staff</th>
        </tr>
        <?php
        $get_programs_with_participation="SELECT DISTINCT(Subcategory_ID) FROM Subcategory_Attendance INNER JOIN Subcategory_Dates
            ON Subcategory_Attendance.Subcategory_Date=Subcategory_Dates.Wright_College_Program_Date_Id
            WHERE Type_of_Participation IS NOT NULL;";
        //loop through programs that have event participation/role (i.e. attendees without role don't count)
        include "../include/dbconnopen.php";
        $programs_count=mysqli_query($cnnLSNA, $get_programs_with_participation);
        while ($prog=mysqli_fetch_row($programs_count)){
            ?>
        <tr>
            <td class="all_projects" style="text-align:left;padding-left:20px;"><?php $subcategory=new Program();
            $subcategory->load_with_program_id($prog[0]);
            echo $subcategory->program_name;?></td>
        <?php
        /*count the number of people in each role for the given campaign: */
        $get_types_count = "SELECT Type_of_Participation, COUNT(*) FROM Subcategory_Attendance INNER JOIN Subcategory_Dates
            ON Subcategory_Attendance.Subcategory_Date=Subcategory_Dates.Wright_College_Program_Date_Id
            WHERE Type_of_Participation IS NOT NULL
            AND Subcategory_ID='" . $prog[0] . "'
            GROUP BY Type_of_Participation;";
        
        $types_count=mysqli_query($cnnLSNA, $get_types_count);
        $td_count=1;
        /*count through the role types, and make the numbers show up in the correct td.
         * the td_count is exactly what it sounds like.  The types of participation will be returned in order in the
         * results, but not all of them will necessarily be represented.  When one is missing, then the $types[0] won't
         * equal the td_count.  Then extra tds need to be added (for example if a program had attendees with roles and those were all staff, 
         * then all the preceding roles would need blank tds).  The td_count is adjusted according to how many extra (blank) tds were added.
         */
        while ($types=mysqli_fetch_row($types_count)){
            if ($types[0]==$td_count){
               ?> <td class="all_projects"><?php echo $types[1];?></td><?php
            }
            elseif ($types[0]==$td_count+1){
                $td_count++;
               ?> <td class="all_projects"></td><td class="all_projects"><?php echo $types[1];?></td><?php
            }
            elseif($types[0]==$td_count+2){
                $td_count=$td_count+2;
               ?> <td class="all_projects"></td><td class="all_projects"></td><td class="all_projects"><?php echo $types[1];?></td><?php
            }
            elseif($types[0]==$td_count+3){
                $td_count=$td_count+3;
               ?> <td class="all_projects"></td><td class="all_projects"></td><td class="all_projects"></td><td class="all_projects"><?php echo $types[1];?><?php
            }
            elseif($types[0]==$td_count+4){
                $td_count=$td_count+4;
               ?> <td class="all_projects"></td><td class="all_projects"></td><td class="all_projects"></td><td class="all_projects"></td><td class="all_projects"><?php echo $types[1];?>
                   <?php
            }
            $td_count++;
        }
        if ($td_count<6){
            //add cells to the end of the row if not all the roles are already accounted for. (for formatting)
            $i=7-$td_count;
            for ($j=1; $j<$i; $j++){
                ?><td class="all_projects"></td><?php
            }
        }
        ?>
            
        </tr>
                    <?php
        }
        include "../include/dbconnclose.php";
        ?>
        
        <!--Total rows: -->
        <tr>
            <td class="all_projects" style="text-align:right;"><strong>All projects:</strong></td>
        <?php
        /*probably foolish, but this assumes that some program will have someone in each type of role, so doesn't bother
         * with adding blank tds.
         */
        $get_types_count = "SELECT Type_of_Participation, COUNT(*) FROM Subcategory_Attendance INNER JOIN Subcategory_Dates
            ON Subcategory_Attendance.Subcategory_Date=Subcategory_Dates.Wright_College_Program_Date_Id
            WHERE Type_of_Participation IS NOT NULL
            GROUP BY Type_of_Participation;";
        //echo $get_types_count;
        include "../include/dbconnopen.php";
        $types_count=mysqli_query($cnnLSNA, $get_types_count);
        while ($types=mysqli_fetch_row($types_count)){
            if ($types[0]!=0){
       
            ?>
                <td class="all_projects"><?php echo $types[1];?></td>
                    <?php
                     }
        }
        include "../include/dbconnclose.php";
        ?>
            
        </tr>
        <tr>
            <td class="all_projects" style="text-align:right;"><strong>Parent mentors in each role:</strong></td>
            <?php 
        /*probably foolish, but this assumes that some program will have a parent mentor in each type of role, so doesn't bother
         * with adding blank tds.
         */
        $get_types_count = "SELECT Type_of_Participation, COUNT(*) FROM Subcategory_Attendance 
INNER JOIN (Subcategory_Dates, Participants ) ON (Subcategory_Attendance.Subcategory_Date=Subcategory_Dates.Wright_College_Program_Date_Id 
	AND Subcategory_Attendance.Participant_ID=Participants.Participant_ID) 
INNER JOIN Participants_Subcategories ON Participants.Participant_ID=Participants_Subcategories.Participant_ID
WHERE Type_of_Participation IS NOT NULL AND Participants_Subcategories.Subcategory_ID=19 GROUP BY Type_of_Participation;";
       // echo $get_types_count;
        include "../include/dbconnopen.php";
        $types_count=mysqli_query($cnnLSNA, $get_types_count);
        while ($types=mysqli_fetch_row($types_count)){
            if ($types[0]!=0){
            ?>
                <td class="all_projects"><?php echo $types[1];?></td>
                    <?php
            }
        }
        include "../include/dbconnclose.php";
        ?>
        </tr>
    </table>
</div>
