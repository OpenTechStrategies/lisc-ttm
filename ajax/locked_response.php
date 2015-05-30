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

function lock_response($lock_val){
    if ($lock_val == 1){
        $locked = true;
    }
// the only values should be 1 or NULL, but just in case, we unlock all users
// that have not been explicitly locked
    else{ 
        $locked = false;
    }
    $response = "This account has been temporarily locked due to a security upgrade on the TTM server.  However, we can unlock it right away if you email us at ttmhelp {at} opentechstrategies {dot} com or call us at (312) 857-6361.  We're sorry for the inconvenience and can explain in detail when you contact us.";
    $lock_array = array($locked, $response);
    return $lock_array;
}
?>