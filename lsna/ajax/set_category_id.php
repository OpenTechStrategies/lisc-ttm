<?php
/* doesn't seem to be used anywhere: */
if ($_POST['id']){
    setcookie('participant', '', time() - 3600, '/');
    setcookie('program', '', time() - 3600, '/');
    setcookie('institution', '', time() - 3600, '/');
    setcookie('category', '', time() - 3600, '/');
    $_COOKIE['category']=setcookie("category", $_POST['id'], time() + 7200, '/');
    echo "1";
    return;
}
else{
    echo "Something went wrong!";
    return;
}

?>
