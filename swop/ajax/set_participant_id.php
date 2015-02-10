<?php
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
