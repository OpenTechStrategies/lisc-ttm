<?php
$LSNA_id = 2;
$Bickerdike_id = 3;
$TRP_id = 4;
$SWOP_id = 5;
$Enlace_id = 6;

// Can add and delete users, as well as write and delete data
$AdminAccess = 1;
// Can add/modify data, but not delete it (??) <- cdonnelly: verify
$DataEntryAccess = 2;
// Only able to read data on the site.
$ReadOnlyAccess = 3;


// Death to the unauthorized!
//
//   o
//   |__
//   \ o)
//    ||--C   >>>>   >>>>
//   /  \
//  _L___L_
// (O_O_O_O)
//
// Give a 401 error and die with $message, if any
function die_unauthorized($message = "") {
    header("HTTP/1.0 401 Unauthorized");
    die($message);
}

function startSession() {
    // startSession
    // ------------
    //
    // Start the session if it hasn't been yet.
    // If it has been, do nothing.

    if (! isset($_SESSION)) {
        session_start();
    }
}


function enforceUserHasAccess($user, $site_id,
                              $access_level = NULL, $program_access = NULL) {
    if (!$user->has_site_access($site_id)) {
        die_unauthorized("User does not have permissions to access this site.");
    }

    // Make sure that the user has the access level if required
    if (!is_null($access_level) &&
        !$user->has_site_access_level($site_id, $access_level)) {
        die_unauthorized("User does not have the appropriate access level for this site.");
    }

    // If program access check is requested, and this program doesn't show up
    // in the user's list of known programs... error out!
    if (!is_null($program_access) &&
        !in_array($program_access, $this->program_access())) {
        // An exception is made for admin users
        if (!($this->site_access_level($site_id) === $AdminAccess)) {
            die_unauthorized("Don't have permission to access this program!");
        }
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

    // Get an array of all programs this user currently has access to
    //
    // Args:
    //  - site: The site ID we are checking this user's program access for
    //
    // Returns:
    //  An array of all program ids that user has access to.
    //  These correspond to... (Fill in here)
    //
    // NOTES:
    //  - "n" is None, a special case.  The reason for this rather than
    //    an empty array is that there are some duplicate rows (:\) in
    //    the db, and "none" takes precedence in case of duplication there.
    //  - In the future, this code, and the database needs to be updated
    //    for a many to many relationship.  As it stands, a user can really
    //    only have one program access per section.
    public function program_access($site) {
        $program_access_array[] = $this->site_permissions[$site][1];

        // note that if 'n' is in array, then the logged-in user has access
        // to no programs, and we delete the rest of the array.  The 'n'
        // takes precedence over any other entries.
        if (in_array('n', $program_access_array)){
            $program_access_array = array('n');
        }

        return $program_access_array;
    }

    // Get the site permission/access level for $SITE
    //
    // Returns:
    //  An integer representing the permission level (see the $FooAccess
    //    variables defined above to see what these are)
    //
    //    Note that the lower the integer, the stronger permissions,
    //    with 1 being full admin access.
    public function site_access_level($site) {
        $site_permissions = $this->site_permissions['site_access'];
        if (array_key_exists($site, $site_permissions)) {
            return $site_permissions['site_access'][$site][0];
        } else {
            return NULL;
        }
    }

    // Return true or false whether the user has minimum $ACCESS_LEVEL
    //   for $SITE.
    //
    // The check here is "does the user have at least as much access_level as
    //   the requirement."  But since lower access levels are more powerful,
    //   we're actually making sure the user's value is <= the requirement.
    public function has_site_access_level($site, $access_level) {
        $user_access_level = $this->site_access_level($site);

        // NULL means no access level at all for this site
        if (is_null($user_access_level)) {
            return false;
        }

        if ($user_access_level <= $access_level) {
            return true;
        } else {
            return false;
        }
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


// TODO: Needs a friendlier array fetch if not set,
//   something like python's .get("foo", False)
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

// TODO: Delete this after the user object stuff works, and refactor
//   all code that presently uses it

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

// TODO: Delete this after the user object stuff works, and refactor
//   all code that presently uses it

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
