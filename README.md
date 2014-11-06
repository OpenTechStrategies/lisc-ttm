"Test The Model" (TTM)
======================

TTM (“Test The Model”) is a collaboration between five neighborhood
organizations in Chicago and the Local Initiatives Support Corporation
(LISC.org).  Since in 2012, the organizations have been working on
local issues using a data-informed approach designed to test the model
of focusing multiple community-based partners around tightly-defined
interventions.  The code here is for the web site and database where
the organizations enter collected data and generate reports.  The TTM
code is open source software licensed under the **TBD** license.  See
the file LICENSE.md for details.

See
[lisc-chicago.org/news/2559](http://www.lisc-chicago.org/news/2559)
and
[mdrc.org/project/chicago-s-new-communities-program#featured_content](http://www.mdrc.org/project/chicago-s-new-communities-program#featured_content)
for more information about the TTM program in general.

The five Chicago organizations are:

  * [LSNA](http://lsna.net/) (Logan Square Neighborhood Association)
  * [Bickerdike](http://www.bickerdike.org/) (Humboldt Park)
  * [The Resurrection Project](http://resurrectionproject.org/) (Pilsen)
  * [Southwest Organizing Project](http://www.swopchicago.org) (Chicago Lawn)
  * [Enlace](http://enlacechicago.org/) (Little Village)

Installing TTM
--------------

Please see the file INSTALL.md for details.

TTM runs on a standard LAMP stack: Apache HTTPD, PHP, MySQL.

Questions?  Feedback?  Looking for the users or for the code?
-------------------------------------------------------------

The TTM discussion forum is:

        https://groups.google.com/forum/#!forum/ttmdiscuss
        <ttmdiscuss@googlegroups.com>

The TTM code is available from GitHub:

        https://github.com/OpenTechStrategies/lisc-ttm.git

You can use the usual ways to interact with the project there: submit
pull requests, file tickets in the issue tracker, etc.

The best way to interact with the project is just to post to the
discussion group.  It's also always okay to file a ticket in the issue
tracker, though you'll need a GitHub account to do so.



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
