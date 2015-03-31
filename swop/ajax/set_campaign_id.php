<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
user_enforce_has_access($SWOP_id);

/* set cookies so that the correct campaign pages show up. */

if ($_POST['id']){
    
    setcookie('campaign', '', time() - 3600, '/');
    $_COOKIE['campaign']=setcookie("campaign", $_POST['id'], time() + 7200, '/');
    $_COOKIE['prog_page']=setcookie("prog_page", 'profile', time() + 3600, '/');
    echo "1";
    return;
}
elseif ($_POST['page']=='search'){
    setcookie('campaign', '', time() - 3600, '/');
    setcookie("prog_page", '', time() - 3600, '/');
    $_COOKIE['prog_page']=setcookie("prog_page", 'search', time() + 3600, '/');
    echo "1";
    return;
}
else{
    echo "Something went wrong!";
    return;
}
?>