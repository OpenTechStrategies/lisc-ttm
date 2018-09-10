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
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($Enlace_id, $AdminAccess);

include "../../header.php";
include "../header.php";

include "../include/settings.php";

if (isset($_POST["num_days_hidden"])) {
    update_setting($NumDaysHiddenSetting, intval($_POST["num_days_hidden"]));
}

?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#settings_selector').addClass('selected');
    });
</script>

<div class="content_block">
    <h3>System Settings</h3><hr/><br/>
    <form method="post">
        <table class="settings_table">
            <tr>
                <td class="all_projects">
                    <strong>Number of Days for Hiding</strong>
                    <p>
                    This setting affects what programs/sessions are visible in different pages.  If a program has no sessions more recent than &lt;numberOfDays&gt; ago, it will be hidden from lists.  Must be a number.
                    </p>
                </td>
                <td class="all_projects">
                    <input type="text" name="num_days_hidden" value="<?php echo get_setting($NumDaysHiddenSetting); ?>"/>
                </td>
            </tr>
            <tr>
                <td class="all_projects" colspan="2" style="text-align:right;">
                    <input type="submit" value="Save"/>
                </td>
            </tr>
        </table>
    </form>
</div>

<?php
include "../../footer.php";
?>
