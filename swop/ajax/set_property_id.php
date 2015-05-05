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
user_enforce_has_access($SWOP_id);

/* set cookies so that the correct property pages show up. */

if ($_POST['page']=='profile'){
    
    setcookie('property', '', time() - 3600, '/');
    setcookie('prop_page', '', time() - 3600, '/');
    $_COOKIE['property']=setcookie("property", $_POST['id'], time() + 7200, '/');
    $_COOKIE['prop_page']=setcookie("prop_page", 'profile', time() + 3600, '/');
    echo "1";
    return;
   
}
elseif ($_POST['page']=='search'){
    
    setcookie('property', '', time() - 3600, '/');
    setcookie('prop_page', '', time() - 3600, '/');
    $_COOKIE['prop_page']=setcookie("prop_page", 'search', time() + 3600, '/');
    echo "1";
    return;
}
elseif ($_POST['page']=='new'){
    
    setcookie('property', '', time() - 3600, '/');
    setcookie('prop_page', '', time() - 3600, '/');
    $_COOKIE['prop_page']=setcookie("prop_page", 'new', time() + 3600, '/');
    echo "1";
    return;
}
else{
    echo "Something went wrong!";
    return;
}

?>
