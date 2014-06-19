"Test The Model" (TTM): Neighborhood Organizations Gathering Data in Chicago
============================================================================


Downloading Files Desired Behavior
--------------

For authenticated user:

1. Click on "Download" link on exports page and the file begins downloading 
seamlessly.  This is how downloads work for users currently.
     
     a. Will the script know that the user is authenticated simply by virtue of 
        the user navigating to the script from the exports page?

2. What will happen is that the link will trigger some script to retrieve the
file from a directory that is not visible to users.
     
     a. As currently coded, that directory will need to be writeable.  Is there
        anything we can do to change that?
     
     b. Put another way, what are the options for creating these files?  
        At the moment they are created with "fopen."  Is that the best/most
        secure mechanism?

3. The script should read the file in the directory and send headers that cause
the file to be downloaded onto the user's computer.

For logged-in user without download permission (does this exist?):

For non-logged-in person who accesses URL directly:

1. The files will be placed in a directory that is not visible to the web/not
   user-facing, so this will not happen.
2. If the download script is accessed directly, it should redirect 
   to the login screen.
   a. This means that it needs to have a system for finding out where a user
      was directed from.


Possible resources:

1. http://stackoverflow.com/questions/3903729/how-to-authenticate-users-before-downloading-files

2. http://www.jasny.net/articles/how-i-php-x-sendfile/

--------------------------------------------

