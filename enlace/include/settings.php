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

if (!function_exists("get_setting")) {
    /*
     * For the following, we exception out with improper settings because we shouldn't be adding code that
     * uses settings if the settings aren't specifically in the database, and we should use the global names
     * rather than passing in ad hoc strings.
     */

    $NumDaysHiddenSetting = "num_days_hidden";
    $SurveyEntryPointSalt = "survey_entry_point_salt";

    function get_setting_tuple ( $setting_name ) {
        include $_SERVER['DOCUMENT_ROOT'] . "/enlace/include/dbconnopen.php";

        $setting_name_safe = mysqli_real_escape_string($cnnEnlace, $setting_name);
        $setting_query = "SELECT * FROM System_Settings WHERE Setting_Name = '$setting_name_safe';";
        $setting_result = mysqli_query($cnnEnlace, $setting_query);

        if (mysqli_num_rows($setting_result) == 0) {
            throw new Exception("No setting named $setting_name found");
        }

        return mysqli_fetch_array($setting_result);
    }

    function get_setting ( $setting_name ) {
        $setting = get_setting_tuple($setting_name);
        if ($setting["Setting_Type"] == "integer") {
            return intval($setting["Setting_Value"]);
        } else {
            return $setting["Setting_Value"];
        }
    }

    function update_setting ( $setting_name, $setting_value ) {
        $setting = get_setting_tuple($setting_name);
        if ($setting["Setting_Type"] == "integer" && !is_int($setting_value)) {
            throw new Exception("Attempting to save setting to non int value: $setting_name / $setting_value");
        }

        include $_SERVER['DOCUMENT_ROOT'] . "/enlace/include/dbconnopen.php";
        $setting_value_safe = mysqli_real_escape_string($cnnEnlace, $setting_value);
        $setting_update_query = "UPDATE System_Settings SET Setting_Value = '$setting_value' WHERE Setting_Name = '$setting_name';";
        mysqli_query($cnnEnlace, $setting_update_query);
    }
}
