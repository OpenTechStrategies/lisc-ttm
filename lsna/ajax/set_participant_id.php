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
