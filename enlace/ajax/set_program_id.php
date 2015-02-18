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