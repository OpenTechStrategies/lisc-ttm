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

user_enforce_has_access($LSNA_id);

/*set cookies for participant profiles, search, and new pages: */
if ($_POST['page']=='profile'){
    setcookie('program', '', time() - 3600, '/');
    setcookie('institution', '', time() - 3600, '/');
    setcookie('participant', '', time() - 3600, '/');
    setcookie('category', '', time() - 3600, '/');
    $_COOKIE['participant']=setcookie("participant", $_POST['participant_id'], time() + 7200, '/');
    $_COOKIE['page']=setcookie("page", 'profile', time() + 3600, '/');
    echo "1";
    return;
}
elseif ($_POST['page']=='search'){
    
    setcookie('participant', '', time() - 3600, '/');
    setcookie('page', '', time() - 3600, '/');
    $_COOKIE['page']=setcookie("page", 'search', time() + 3600, '/');
    echo "1";
    return;
}
elseif ($_POST['page']=='new'){
    
    setcookie('participant', '', time() - 3600, '/');
    setcookie('page', '', time() - 3600, '/');
    $_COOKIE['page']=setcookie("page", 'new', time() + 3600, '/');
    echo "1";
    return;
}
else{
    echo "Something went wrong!";
    return;
}

?>
