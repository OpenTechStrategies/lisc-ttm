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