<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($LSNA_id);

/* sets cookies for institution profiles and search page: */
if ($_POST['id']){
    setcookie('participant', '', time() - 3600, '/');
    setcookie('program', '', time() - 3600, '/');
    setcookie('institution', '', time() - 3600, '/');
    setcookie('category', '', time() - 3600, '/');
    $_COOKIE['institution']=setcookie("institution", $_POST['id'], time() + 7200, '/');
    $_COOKIE['inst_page']=setcookie("inst_page", 'profile', time() + 3600, '/');
    echo "1";
    return;
}
elseif ($_POST['page']=='search'){
    setcookie('institution', '', time() - 3600, '/');
    setcookie("inst_page", '', time() - 3600, '/');
    $_COOKIE['inst_page']=setcookie("inst_page", 'search', time() + 3600, '/');
    echo "1";
    return;
}
else{
    echo "Something went wrong!";
    return;
}
?>