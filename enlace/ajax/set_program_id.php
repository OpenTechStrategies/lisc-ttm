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
/*set program id so that the links work properly*/

/*set program ID*/
if ($_POST['page']=='profile'){
    
    setcookie('program', '', time() - 3600, '/');
    $_COOKIE['program']=setcookie("program", $_POST['id'], time() + 7200, '/');
    
    echo "1";
    return;
}
/*return to program search page.*/
elseif ($_POST['page']=='search'){
    setcookie('program', '', time() - 3600, '/');
    setcookie("prog_page", '', time() - 3600, '/');
    $_COOKIE['prog_page']=setcookie("prog_page", 'search', time() + 3600, '/');
    echo "1";
    return;
}
/*go to create program page.*/
elseif ($_POST['page']=='new'){
    setcookie('program', '', time() - 3600, '/');
    setcookie("prog_page", '', time() - 3600, '/');
    $_COOKIE['prog_page']=setcookie("prog_page", 'new', time() + 3600, '/');
    echo "1";
    return;
}

else{
    echo "Something went wrong!";
    return;
}
?>