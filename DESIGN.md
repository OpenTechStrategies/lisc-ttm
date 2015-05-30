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

Access Controls in TTM
----------------------

This may need to be in a separate document eventually, but for now I'm
including it here.  

All groups in TTM (were intended to) have three access levels:
Administrator, Data Entry, 
and Viewer.  The administrator can do all available tasks, including
deletions, adding new users, changing user passwords, and so on.
Data Entry users can do everything except those things listed 
above - their role is to enter the data the system was built to hold,
which is mostly about participants and attendance.  Viewers are (in
practice) rarely added, but when added they are  able to look at the
system but not make changes.

As of the original import, access was governed by the
"view_restricted" cookie, which, if set, hid elements of the class
"hide_on_view."  These elements 

Specific group permissions:

_Bickerdike:_

Bickerdike only has administrative and view-only users.  For view-only
users, the "hide_on_view" class is applied to all editable fields.
This will need to be changed, since classes are applied on the client
side (yes?).

Hide on view appears in:
./header.php
./index.php
./ajax/search_programs.php
./data/bickerdike_programs.php
./include/data.php
./users/all_users.php
./users/user_profile.php
./activities/view_all_programs.php
./activities/program_profile.php



_Enlace:_

Enlace only has administrative users, but they organize their
permissions around programs, because their partners use the system.
That is, everyone can edit and delete information in their specific
program, but shouldn't have access to any information about
students/participants in other programs.

The access check is done in:
reports/num_programs.php
./reports/assessments.php
./reports/all_exports.php
./reports/production_exports.php
./reports/quality_surveys.php
./participants/participant_profile.php
./participants/permission_check_page.php
./ajax/delete_program.php
./ajax/search_participants.php
./programs/programs.php
./programs/profile.php

So any changes to the check will need to happen in all of those places
as well.

_LSNA:_

LSNA has administrators, data entry people, and view-only users.  The
elements that need to be hidden from view-only users have the class
"no_view" and the elements that are hidden from data entry users have
class "hide_on_view."  Elements with neither of these classes are
visible to everyone.  The classes are set in lsna/header.php.  

Hide on view appears in:
./header.php
./ajax/search_institutions.php
./ajax/search_participants.php
./ajax/search_programs.php
./programs/program_profile.php

No_view appears in:
./header.php
./reports/reports.php
./institutions/institution_profile.php
./institutions/institutions.php
./index.php
./participants/participants.php
./participants/participant_profile.php
./programs/programs.php
./programs/program_profile.php

The classes appear multiple times in each of these files.


_SWOP:_

SWOP has administrators, data entry users, and users who only have
access to the financial information saved in the system.  The data
entry users are not permitted to view elements with the classes
"hide_on_view" and "hide_exception," while financial users are
permitted to view elements with class "hide_exception" but not
elements with class "hide_on_view."  Currently these classes are
hidden or shown in swop/header.php depending on the presence of
certain cookies.

Hide on view appears in:
./header.php
./index.php
./participants/participant_profile.php
./participants/pool_profile.php
./ajax/search_props.php
./properties/profile.php

Hide exception appears in:
./header.php (where it is set)
./participants/pool_profile.php

_TRP:_
TRP uses hide_on_view and no_view just like LSNA does.  

Hide on view appears in:
./participants/profile.php (DONE) check

No view appears in:
./reports/report_menu.php (DONE)  check
./index.php (DONE)  check
./participants/participants.php (DONE)  check  
./participants/profile.php (DONE) check  
./programs/profile.php  (DONE) check
./engagement/engagement.php (DONE)  (change end of access check in Line 299?)

It also shows program participation on the participant profile based
on an access query, like Enlace.  This query sets an "access" variable
that determines which program information is displayed.  I will need
to change that.

_Places where program access is queried:_

./enlace/reports/num_programs.php
./enlace/reports/assessments.php
./enlace/reports/all_exports.php
./enlace/reports/production_exports.php
./enlace/reports/quality_surveys.php
./enlace/participants/participant_profile.php
./enlace/participants/permission_check_page.php
./enlace/ajax/delete_program.php
./enlace/ajax/search_participants.php
./enlace/programs/programs.php
./enlace/programs/profile.php
./ajax/edit_privileges.php
./ajax/extend_staff_privilege.php
./trp/participants/profile.php
./trp/ajax/search_users.php
./include/generalized_download_script.php

_Next Steps:_

The new regimen will need to test access against the database tables,
and I believe we'll need to set a global variable (in siteconfig.php?)
that determines level of access, and use conditional statements to
either show or hide these elements instead of classes that can be
manipulated by end users.

Enlace is a special case.  Since their permission level authorization
doesn't use cookies, it isn't as urgent to change the authorization
system for that site as for the others, but ideally we'll have one
unified/consistent system for access checking.
