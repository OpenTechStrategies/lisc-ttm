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

if (!function_exists("invalid_attendance_date")) {
    date_default_timezone_set('America/Chicago');
    $now = new DateTime();
    if($now->format("j") > 15) {
        $earliest_acceptable_attendance_date = strtotime("midnight first day of this month");
    } else {
        $earliest_acceptable_attendance_date = strtotime("midnight first day of last month");
    }
    
    function invalid_attendance_date ( $date ) {
        global $earliest_acceptable_attendance_date, $USER, $Enlace_id, $AdminAccess;
        return (!$USER->has_site_access($Enlace_id, $AdminAccess) && ($date < $earliest_acceptable_attendance_date));
    }
}
?>    
