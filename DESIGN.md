Design Notes for LISC TTM software project.
===========================================

These notes are somewhat randomly accumulated right now.  As the file
grows, we can organize it more.

Always Sanitize User Input When Constructing SQL Queries
--------------------------------------------------------

Any input passed to mysqli\_query() must be SQL-safe, to avoid SQL
injection attacks.  This means that input coming in from users must be
run through mysqli\_real\_escape\_string().  To help us keep track of
which input has been thus sanitized, we use the suffix "\_sqlsafe" on
variables whose values are known to be already safe.  Naturally, such
variables can be combined with or interpolated into other safe values
and the result will itself be safe; such chains of combinations should
retain "\_sqlsafe" suffixes all the way down, cascading to the
variable that actually gets passed into mysqli\_query().

In other words, the "\_sqlsafe" suffix is introduced on variables that
are the lvalue (assignee) of calls to mysqli\_real\_escape\_string(),
and is preserved through any intermediate variables all the way to the
query variable variable.  For example:

        $user = $_POST['user'];
        $user_sqlsafe = mysqli_real_escape_string($cnnFoo, $user);
        $query_sqlsafe = "SELECT blah blah '" . $user_sqlsafe . "' blah blah";
        mysqli_query($cnnFoo, $query_sqlsafe);

There is one exception to this:

Some SQL queries are constructed from class members, such as
$this->user\_id (where $this is a User instance) or $this->program\_id
(where $this is a Program instance).  Those class members are made
SQL-safe at the time of the instance's initialization, but it would be
awkward to include the "\_sqlsafe" suffix on the member's name.  So
for commonly used classes, the class documentation should indicate
which members are SQL-safe, and then they can be treated as such
wherever they are used even though they don't have the "\_sqlsafe"
suffix.  See `bickerdike/classes/user.php` (`$this->user_id`) and
`bickerdike/classes/program.php` (`$this->program_id`) for examples.

Login Pages and Processes
-------------------------

Users log in to the system via /loginpage.php.  From this page, credentials  
are authenticated via /ajax/loginsubmit.php.  

* If their credentials fail, loginsubmit.php tells loginpage.php that login has  
  failed by the line  
  echo '0'; (see line 77)  
  The "echo '0';" line is not equivalent to "return '0';", but rather is  
  related specifically to the POST, which includes a _response_ function  
  that takes the response as an argument.  If the response is equal to '0',  
  then the page deletes the password and shows an error so that the user  
  can try again.
* On receiving '0' as a response, login_page.php shows the error message  
  "Invalid username/password."



Downloading Files Desired Behavior
--------------

I. For authenticated user:

1. Click on "Download" link on exports page and the file begins downloading   
seamlessly.  This is how downloads work for users currently.
     
     ### What does the URL of that link look like?  
     ### CD: example: enlace/reports/  
     ###              export_folder/name.csv  

     a. Will the script know that the user is authenticated simply by virtue of   
        the user navigating to the script from the exports page?

         i. The script can check the user's cookie before starting for auth
            purposes.

        ### Wouldn't the script do authentication the same way the
        ### rest of the system does -- that is, by checking the cookie?


2. What will happen is that the link will trigger some script to retrieve the
file from a directory that is not visible to users.
     
     a. As currently coded, that directory will need to be writeable.  Is there
        anything we can do to change that?
     
     b. Put another way, what are the options for creating these files?  
        At the moment they are created with "fopen."  Is that the best/most
        secure mechanism?

     ### But aren't we creating those files on-the-fly each time  
     ### anyway?  That is, it's not a cron job that runs in batch mode  
     ### each night or something like that.  Right now, when the user  
     ### clicks on the Download or Exports link, the files are  
     ### (re)created right then and there.  So, if we're going through  
     ### a script now anyway, maybe we don't need to ever have files  
     ### on disk?  Can we just send the data to the user directly?  

     ###CD: This sounds great, but I'm not sure how to do it.  
     ###    Should we pass more arguments to the download script so that it  
     ###    knows how to create the lines of the file?  Is that even possible?  
     ###    So.  What I want to happen is to read lines of mysql results  
     ###    and have those lines read into a file which is downloaded by the   
     ###    user.  I imagine that file has to be saved somewhere, but   
     ###    you're suggesting that it doesn't, which would be awesome.  
     

3. The script should read the file in the directory and send headers that cause
the file to be downloaded onto the user's computer.

II. For logged-in user without download permission (does this exist?):

III. For non-logged-in person who accesses URL directly:

1. The files will be placed in a directory that is not visible to the web/not
   user-facing, so this will not happen.
2. If the download script is accessed directly, it should redirect 
   to the login screen.

     a. This means that it needs to have a system for finding out where a user
      was directed from.

         i. No, if the user cookie is not set (see I.1.a.i.) then the script will
            redirect to the login screen.


Possible resources:

1. http://stackoverflow.com/questions/3903729/how-to-authenticate-users-before-downloading-files

2. http://www.jasny.net/articles/how-i-php-x-sendfile/

How to Handle Inclusion of Common Code
--------------------------------------

See `enlace/include/dosage_percentage.php` and the files that include
it for an example of how to handle shared code.  The main thing is to
remember to include redeclaration-protection wrappers, either a
wrapper around the entire file like this

        if(!defined("TTM_INCLUDE_DOSAGE_PERCENTAGE_PHP"))
        {
        define("TTM_INCLUDE_DOSAGE_PERCENTAGE_PHP", TRUE);
        ...
        }

or around the individual functions/variables in the file:

        if(!function_exists("calculate_dosage")) 
        {
        function calculate_dosage...
        }

The former way is usually better.


How to Add a New User
-----------------------

In most cases the subsite users will add new users themselves, but in
the case where a new user needs access to more than one subsite or
there is no active user at a subsite then the development team will
need to add a user.
To do so:

1. Log in.
2. On the landing page, you'll see an "Alter Privileges" menu item
between "Homepage" and "Log Out."  This menu item is only visible to
logged-in users with Administrative privileges. Click on "Alter
Privileges."
3. That brings you to "/include/add_staff.php."  Here you'll see a
section for "Add User."
4. Fill out the add user section.  Note that there is (currently, as
of 2014-12-15) no way to grant a new user access to one or more
specific subsites in the UI.  By default, the user will have access to the
subsite that the creating user has access to.  If the creating user
(the logged-in user who fills out the "Add User" form) has access to
multiple subsites, then the new user will, by default, have access to
the subsite linked to the logged-in user first in the Users Privileges
table. See Issue #99 for discussion on this design flaw.
5. At this point, the user has been created and has access to one
subsite.  If the user needs access to more than one subsite, or to a
different subsite than they were granted access to by default, then
the creating user needs to SSH into the server and make changes to a
DB table.
6. Look in the Users table to find the User ID of the newly created
user (the username will be stored in the User Email column of that
table, see issue #14).  Subsite access is stored in the
Users Privileges table, using that User ID as a foreign key.   
About the Users Privileges table:  
The Privilege ID column refers to the Privileges table, which is a list of
subsites.  The Site Privilege ID column refers to the Site Privileges
table, which refers to the levels of access (administrator, data
entry, and read-only).  The Site Privilege ID column can be
manipulated from the UI, but for the moment the Privilege ID column
must be altered directly in the server (again, see issue #99).
If the subsite has been inaccurately assigned, the
Privilege ID column is the one that needs to be changed.  Consult the
Privileges table to find the correct Privilege ID for the desired
subsite, and update the row to point to that ID instead.
If the new user needs access to multiple subsites, then insert a row
for each subsite into the Users Privileges table with the appropriate
subsite ID in the Privilege ID column and the correct level of access ID
in the Site Privilege ID column.
7. Log in using the newly created user's credentials to ensure that
everything has been correctly configured, and that's all!