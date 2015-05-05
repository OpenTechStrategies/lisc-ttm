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

/* set cookies so that the correct participant pages show up */

if ($_POST['page']=='profile'){
    /* if the person is active in the pool, then redirects to the pool profile.  otherwise,
     * goes to the regular participant profile. */
    setcookie('participant', '', time() - 3600, '/');
    setcookie('new_pool', '', time()-3600, '/');
    $_COOKIE['participant']=setcookie("participant", $_POST['participant_id'], time() + 7200, '/');
    include "../include/dbconnopen.php";
    $is_in_pool_sqlsafe = "SELECT Active FROM Pool_Status_Changes WHERE Participant_ID='".mysqli_real_escape_string($cnnSWOP, $_POST['participant_id'])."' 
            ORDER BY Date_Changed DESC LIMIT 0,1;";
    
    $in_pool = mysqli_query($cnnSWOP, $is_in_pool_sqlsafe);
    include "../include/dbconnclose.php";
    $pool=  mysqli_fetch_row($in_pool);
    if ($pool[0]==1){
        $_COOKIE['page']=setcookie("page", 'pool_profile', time() + 3600, '/');
        echo '/swop/participants/pool_profile.php';
    }
    else{
        $_COOKIE['page']=setcookie("page", 'profile', time() + 3600, '/');
        echo '/swop/participants/participant_profile.php';
    }
    //echo "1";
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
