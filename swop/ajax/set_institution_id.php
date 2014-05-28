<?php
/* set cookies so that the correct institution pages show up. */

if ($_POST['id']){
    
    setcookie('institution', '', time() - 3600, '/');
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