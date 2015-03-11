<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id);

/* set cookies for program profiles, search, and new pages. */
if ($_POST['id']){
    
    setcookie('institution', '', time() - 3600, '/');
    setcookie('participant', '', time() - 3600, '/');
    setcookie('program', '', time() - 3600, '/');
    setcookie('category', '', time() - 3600, '/');
    $_COOKIE['program']=setcookie("program", $_POST['id'], time() + 7200, '/');
    $_COOKIE['prog_page']=setcookie("prog_page", 'profile', time() + 3600, '/');
    echo "1";
    return;
}
elseif ($_POST['page']=='search'){
    setcookie('program', '', time() - 3600, '/');
    setcookie("prog_page", '', time() - 3600, '/');
    $_COOKIE['prog_page']=setcookie("prog_page", 'search', time() + 3600, '/');
    echo "1";
    return;
}
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
