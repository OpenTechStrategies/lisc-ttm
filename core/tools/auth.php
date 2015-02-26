<?php
$LSNA_id = 2;
$Bickerdike_id = 3;
$TRP_id = 4;
$SWOP_id = 5;
$Enlace_id = 6;

// Can add and delete users, as well as write and delete data
$AdminAccess = 1;
// Can add/modify data, but not delete it
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
$die_unauthorized = function($message = "") {
    header("HTTP/1.0 401 Unauthorized");
    die($message);
};




function maybeStartSession() {
    // startSession
    // ------------
    //
    // Start the session if it hasn't been yet.
    // If it has been, do nothing.

    if (! isset($_SESSION)) {
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
        maybeStartSession();
        $this->id = $user_id;
        $this->username = getUsernameFromId($user_id);
        $this->site_permissions = getAllSiteAccess($user_id);
    }

    // Enforce that the user has access to this site.
    //
    // Args are exactly the same as for site_access_check, with one
    // addition:
    //  - failure_func: (optional) Provide a function that will handle how the
    //    unauthorized access is taken care of.  By default, $die_unauthorized
    //    is used.
    public function enforce_has_access($site_id,
                                       $access_level = NULL, $program_access = NULL,
                                       $failure_func = NULL) {
        if (is_null($failure_func)) {
            global $die_unauthorized;
            $failure_func = $die_unauthorized;
        }

        list ($has_access, $error_msg) = $this->site_access_check(
            $site_id, $access_level, $program_access);
        
        if (!$has_access) {
            return $failure_func($error_msg);
        }
    }

    // Performs a check of whether this user has site access.
    //
    // Args:
    //  - site_id: The site ID we're checking if the user has access to
    //  - access_level: (optional) Minimum "access level" this user must have
    //    to continue (a lower integer means more access; see above
    //    definitions for details)
    //  - program_access: (optional) Verify that the user has access to this
    //    program to continue.
    //
    // This returns an array with two bits of information:
    //   array(has_access, "error message")
    // where `has_access' is a boolean.  If `has_access` is true then
    // the error message is NULL.  Otherwise the error message is a
    // string explaining the problem in detail.
    public function site_access_check($site_id,
                                      $access_level = NULL, $program_access = NULL) {
        if (!siteAccessInPermissions($site_id, $this->site_permissions)) {
            return array(
                false,
                "Sorry!  You do not have permission to access this site.");
        }

        // Make sure that the user has the access level if required
        if (!is_null($access_level) &&
            !$this->has_site_access_level($site_id, $access_level)) {
            return array(
                false,
                "User does not have the appropriate access level for this site.");
        }

        // If program access check is requested, do it.
        global $AdminAccess;
        if (!is_null($program_access)) {
            $our_program_access = $this->program_access($site_id);
            if (!in_array($program_access, $our_program_access) &&
                // 'a' in program access means "has all program access for this site"
                !in_array('a', $our_program_access)) {
                return array(
                    false,
                    "Sorry!  You don't have permission to access this page.  Please contact your site administrator for more information.");
            }
        }
        return array(true, NULL);
    }

    // Like site_access_check but just returns the boolean on whether or not
    // the user has site access or not.
    public function has_site_access(
        $site_id, $access_level = NULL, $program_access = NULL) {
        return $this->site_access_check($site_id, $access_level, $program_access)[0];
    }

    // Get an array of all programs this user currently has access to
    //
    // Args:
    //  - site: The site ID we are checking this user's program access for
    //
    // Returns:
    //  An array of all program ids that user has access to.
    //  These correspond to programs within each subsite.
    //
    // NOTES:
    //  - "n" is None, a special case.  The reason for this rather than
    //    an empty array is that there are some duplicate rows (:\) in
    //    the db, and "none" takes precedence in case of duplication there.
    //  - Another special case is 'a', which really means "all access for
    //    programs on this site".  If we see 'a' we thusly return "just a".
    //    So if you see 'a' returned from this function, you know the
    //    user has access to whatever program to some degree.
    //  - In the future, this code, and the database needs to be updated
    //    for a many to many relationship.  As it stands, a user can really
    //    only have one program access per section.
    public function program_access($site) {
        $program_access_array[] = $this->site_permissions[$site][1];

        // note that if 'n' is in array, then the logged-in user has access
        // to no programs, and we delete the rest of the array.  The 'n'
        // takes precedence over any other entries.
        if (in_array('n', $program_access_array)) {
            $program_access_array = array();
        } else if (in_array('a', $program_access_array)) {
            $program_access_array = array('a');
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
        $site_permissions = $this->site_permissions;
        if (array_key_exists($site, $site_permissions)) {
            return $site_permissions[$site][0];
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


// Like User->site_access_check() but uses logged in $USER
// (Also checks if the user is logged in!)
function user_site_access_check($site_id,
                                $access_level = NULL, $program_access = NULL) {
    global $USER;
    if (is_null($USER)) {
        return array(false, "Not logged in!");
    }

    return $USER->site_access_check($site_id, $access_level, $program_access);
}

// Like User->enforce_access_check() but uses logged in $USER
// (Also checks if the user is logged in!)
function user_enforce_has_access($site_id,
                                 $access_level = NULL, $program_access = NULL,
                                 $failure_func = NULL) {
    if (is_null($failure_func)) {
        global $die_unauthorized;
        $failure_func = $die_unauthorized;
    }

    list ($has_access, $error_msg) = user_site_access_check(
        $site_id, $access_level, $program_access);
    
    if (!$has_access) {
        return $failure_func($error_msg);
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


// Return a new User() object based on the current logged-in user.
// 
// If no user is set in the session, return NULL.
function getCurrentUser() {
    maybeStartSession();
    $user_id = NULL;
    if (array_key_exists('user_id', $_SESSION)) {
        $user_id = $_SESSION['user_id'];
    }

    if (is_null($user_id)) {
        return NULL;
    }

    return new User($user_id);
}


$USER = NULL;

// Setup the $USER global variable
function setupUserGlobal() {
    global $USER;
    $USER = getCurrentUser();
}


// TODO: Needs a friendlier array fetch if not set,
//   something like python's .get("foo", False)
function isLoggedIn($session_id = NULL) {
    maybeStartSession();
    if (array_key_exists('user_id', $_SESSION)) {
        return !is_null($_SESSION['user_id']);
    } else {
        return false;
    }
}


function pleaseLogOut($session_id = NULL) {
    session_unset();
    session_destroy();
    setcookie('PHPSESSID', '', time() - 3600, '/');
    foreach ($_SESSION as $key => $value) {
        setcookie($key, '', time() - 3600, '/');
    }
    return true;
}


function siteAccessInPermissions($site, $permissions) {
    // Check for site access for $site in $permissions
    //
    // $permissions should come from getAllSiteAccess()
    $access_return = false;
    if (array_key_exists($site, $permissions)) {
        $access_return = true;
    }
    return $access_return;
}


// Old function, for backwards compatibility

function getSiteAccess($session_id, $site) {
    return siteAccessInPermissions($site, $_SESSION['site_access']);
}

function getAllSiteAccess($user_id) {
    $path =  $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
    include $path; //connection to core db
    $user_id_sqlsafe = mysqli_real_escape_string($cnnLISC, $user_id);
    $find_site_access_sqlsafe = "SELECT Privilege_ID, Site_Privilege_ID, Program_Access FROM Users_Privileges WHERE User_ID =" . $user_id;
    $access_result = mysqli_query($cnnLISC, $find_site_access_sqlsafe);
    $access_return = array();
    while ($access = mysqli_fetch_row($access_result)) {
        $access_return[$access[0]] = array($access[1], $access[2]);
    }
    return $access_return;
}

// TODO: Delete this after the user object stuff works, and refactor
//   all code that presently uses it

function getPermissionLevel($session_id, $site) {
    session_start();
    if (session_id() == $session_id) {
        if (array_key_exists($site, $_SESSION['site_access'])) {
            return $_SESSION['site_access'][$site][0];
        }
    }
    else{
        return false;
    }
}

// TODO: Delete this after the user object stuff works, and refactor
//   all code that presently uses it

function getProgramAccess($session_id, $site) {
    $program_access_array = array();
    session_start();
    if (session_id() == $session_id) {
        //this needs to be updated to include the possibility of
        //access to multiple programs.
        $program_access_array[] = $_SESSION['site_access'][$site][1];
    }    
    //note that if 'n' is in array, then the logged-in user has access
    //to no programs, and we delete the rest of the array.  The 'n'
    //takes precedence over any other entries.

    if (in_array('n', $program_access_array)) {
        $program_access_array = array('n');
    }

    return $program_access_array;
}

// =================================================================
// Cleanup tools
//
// The purpose of this section is to have a way to clean up whenever
// a request ends.  Database connections must be closed, and...
// well maybe just database connections need to be closed.
// Still, the code here is general enough where if you set up
// anything else that needs to be shut down, you can here.
// =================================================================

// The $CLEANUP_TASKS array stores all the tasks that are currently
// registered as being needed to be cleaned up / run

$CLEANUP_TASKS = array();

function append_cleanup_task($task) {
    global $CLEANUP_TASKS;
    $CLEANUP_TASKS[] = $task;
}

function run_cleanup_tasks() {
    global $CLEANUP_TASKS;
    while (count($CLEANUP_TASKS) > 0) {
        $task = array_pop($CLEANUP_TASKS);
        $task();
    }
}

// Reset $CLEANUP_TASKS, maybe on a new connection?
// This could be useful in case run_cleanup_tasks is never hit.
// It's not clear yet whether that will result in extra tasks
// happening on the next connection.
//
// Not sure where to use this, but seems helpful.
// Can you think of one? :)
function clear_cleanup_tasks() {
    global $CLEANUP_TASKS;
    $CLEANUP_TASKS = array();
}

?>
<script text="javascript">
    function failAlert(){
        alert('You do not have permission to perform this action.');
    }
</script>