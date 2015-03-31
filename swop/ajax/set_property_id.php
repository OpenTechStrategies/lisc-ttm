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
