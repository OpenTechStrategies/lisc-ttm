<?php
$LSNA_id = 2;
$Bickerdike_id = 3;
$TRP_id = 4;
$SWOP_id = 5;
$Enlace_id = 6;

$AdminAccess = 1;
$DataEntryAccess = 2;
$ReadOnlyAccess = 3;


function startSession() {
    // startSession
    // ------------
    //
    // Start the session if it hasn't been yet.
    // If it has been, do nothing.

    if (! defined("_SESSION")) {
        session_start();
    }
}


class User {
    // User class
    //
    // This should be started up and inserted into the session very
    // early on in the page.

    public $id;
    public $username;

    // @@: could be private, but not really needed,
    //   useful to have public for debugging

    // A hashmap of site id to permission level
    public $site_permissions;

    public function __construct($user_id) {
        startSession();
        $this->id = $user_id;
        $this->username = getUsernameFromId($user_id);
        $this->site_permissions = getAllSiteAccess($user_id);
    }

    public function has_site_access($site) {
        return siteAccessInPermissions($site, $this->site_permissions);
    }
}



function getUsernameFromId($user_id) {
    global $cnnLISC;

    $userid_sqlsafe = mysqli_real_escape_string($cnnLISC, $user_id);
    $user_query = "SELECT User_Email FROM Users WHERE User_ID = '$userid_sqlsafe'";
    $query_result = mysqli_query($cnnLISC, $user_query);

    $user_exists = mysqli_num_rows($query_result);
    if (! $user_exists = mysqli_num_rows($query_result)) {
        $log_call = "INSERT INTO Log (Log_Event) VALUES (CONCAT('" . $userid_sqlsafe . "', ' - Unknown userid'))";
        mysqli_query($cnnLISC, $log_call);
        // maybe something else could be done?
        die("ERROR: user with id " . htmlspecialchars($user_id) . " not found");
    }
    $user_row = mysqli_fetch_row($query_result);
    $username=$user_row[0];
    return $username;
}


function isLoggedIn($session_id){
    return $_SESSION['is_logged_in'];
}

function pleaseLogOut($session_id){
    session_unset();
    session_destroy();
    setcookie('PHPSESSID', '', time() - 3600, '/');
    foreach ($_SESSION as $key => $value){
        setcookie($key, '', time() - 3600, '/');
    }
    return true;
}


function siteAccessInPermissions($site, $permissions) {
    // Check for site access for $site in $permissions
    //
    // $permissions should come from getAllSiteAccess()
    $access_return = false;
    if (array_key_exists($site, $permissions)){
        $access_return = true;
    }
    return $access_return;
}


// Old function, for backwards compatibility

function getSiteAccess($session_id, $site){
    return siteAccessInPermissions($site, $_SESSION['site_access']);
}

function getAllSiteAccess($user_id){
    $path =  $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
    include $path; //connection to core db
    $user_id_sqlsafe = mysqli_real_escape_string($cnnLISC, $user_id);
    $find_site_access_sqlsafe = "SELECT Privilege_ID, Site_Privilege_ID, Program_Access FROM Users_Privileges WHERE User_ID =" . $user_id;
    $access_result = mysqli_query($cnnLISC, $find_site_access_sqlsafe);
    $access_return = array();
    while ($access = mysqli_fetch_row($access_result)){
        $access_return[$access[0]] = array($access[1], $access[2]);
    }
    return $access_return;
}

function getPermissionLevel($session_id, $site){
    session_start();
    if (session_id() == $session_id){
        if (array_key_exists($site, $_SESSION['site_access'])){
            return $_SESSION['site_access'][$site][0];
        }
    }
    else{
        return false;
    }
}

function getProgramAccess($session_id, $site){
    $program_access_array = array();
    session_start();
    if (session_id() == $session_id){
        //this needs to be updated to include the possibility of
        //access to multiple programs.
        $program_access_array[] = $_SESSION['site_access'][$site][1];
    }    
    //note that if 'n' is in array, then the logged-in user has access
    //to no programs, and we delete the rest of the array.  The 'n'
    //takes precedence over any other entries.

    if (in_array('n', $program_access_array)){
        $program_access_array = array('n');
    }

    return $program_access_array;
}

?>
