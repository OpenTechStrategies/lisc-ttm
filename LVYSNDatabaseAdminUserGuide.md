# Little Village Youth Safety Network 
# Database Administrator User Guide


Notes: 


This admin user guide is a complement to the (data entry user guide)[LVYSNDatabaseUserGuide.md]. Administering the database requires understanding how the database functions from the perspectives of both the data entry side and the administrative side. 


When reading this guide, it is useful to have the database open to see what is being described. Also if you want to explore without altering youths’ information, please feel free to edit the “geek squad testing” program. 


## Sections: 


1. Users - Different Levels, Administering Privileges
2. Programs Tab
3. Participants Tab & Participant Records
4. Reports Tab
5. Other Database Features
6. Working with Data Entry Users
7. Routine Maintenance
8. Back-End Maintenance & Development





## Section 1: Users - Different Levels, Administering Privileges


When first logging into the TTM/LVYSN database, you should come to a window that has 3 links at the top: Homepage, Alter Privileges, and Log Out. Below that should be a link to the Enlace site information. 


Homepage is this landing page. It can always be accessed by clicking on “Testing the Model Data Center” at the top of the screen. 


Alter Privileges takes you to a screen where you can add new users and edit current users’ access to viewing and editing information. 


Log out does just that. 


Clicking on the Enlace link takes you to the actual database. 


### Different User Levels


There are 3 user levels: Administrator, Data Entry, and Viewer. 


Administrator users are LVYSN staff members (i.e., Enlace’s Director of Violence Prevention, Data Specialist, etc.) who work across the network. They are able to view and edit nearly every piece of information in the database. Therefore, there should really only be a few of these users. 


Data Entry is the privilege level for most users. Typically, they are program staff at partner organizations delivering LVYSN services. Their accounts must be linked to specific programs. They can create new participants, add surveys, edit program information like attendance, and create reports on the programs linked with their profile. But, they cannot view or edit most information in other programs. 


Viewer profiles can only look at the program page and reports associated with their profile. They have no ability to edit information beyond their own password. 


### Administering Privileges


After clicking on “Alter Privileges,” you will land on a page with 3 sections: Add User, Edit Privileges, and Reset Password. 


When adding a new user, create a username for them. Often this is their first initial and last name. Then, create a password. If the user is with you, ask them to fill in their desired password. If not, create a password for them and inform them they can change it later. Though there are no strict requirements for special characters or length, passwords should be easily remembered but hard to guess. Bad choices would be “password,” repeating the username, [12345](https://www.youtube.com/watch?v=a6iW-8xPw3k), etc. Then, select the programs the user should have access to. Only administrators should have access to all programs. Be sure to click “Save” to complete the process. 


Edit privileges is useful if another program is added, and you need to add access to a program to a user profile. One example would be that Beyond the Ball recently added NSLV League to their existing programs 28.5, 29.5, and Summer League, so their data entry person needed to be granted access to the new program. Simply select the user from the drop-down menu, re-enter their user level (typically Data Entry), and check the box for EVERY program they should be able to access, not just the new program. Occasionally, administrators may need to do this procedure for themselves. In that case, simply select your own username, Administrator level, and click on the box next to Select All before hitting Save. 


Reset Password is for when users cannot remember their password. Simply select their username from the drop-down menu and pick a new password for them. Remind them they can change their password as well. 



## Section 2: Programs Tab


Back on the homepage / landing page after logging in, click on the “Enlace” link to go to the main database. This will have several links at the top of the page: Participants, Programs, Institutions, Campaigns, Events, Reports, and Log Out. These tabs guide the organization of this user guide. 


After clicking on the Programs tab, you will come to a list of all the programs that are now or have been a part of the network. The Host Organization is also listed; this is the institution associated with each program. It is possible to delete a program by clicking on the red X to the right. However, there is unlikely to be a need to delete programs, and that data would be lost, so use extreme caution before deleting. 


Clicking on a program will take you to that program’s page. There are several different features to note here: the general information box at the top right, the program quality surveys below that, the add/edit session section, the participants section, the program dates section, and the mentorship hours section. 


### General Information Box


At the top right is a box that lists general information for that program. This includes the name, host organization (which must already exist in the Institutions tab), the activities in a checkbox format, the days per week the program is offered, the daily start and end times, and the maximum total hours. 


The name and institution generally will not need to change. Instead, just create a new program if it is significantly different from what already exists, so that past service records are preserved. 


The activities generally will not need to change. One point to note is that if a program wants to track individual mentorship hours, the mentorship box must be checked. Otherwise, the dialogue boxes for mentorship hours will not appear for that program. 


The days of the week and start/end times are tricky because some programs have different start/end times on different days. However, having something here is important because the database uses these values when calculating percentage. Therefore, it would be a good idea to enter start/end times that occur most frequently, or that reflect the average number of hours of service. For example: if a program provides 2 hours of services on Tuesday afternoons and 4 hours of services on Friday afternoons, click on the boxes for Tuesday and Friday, and enter start/end times of 3 PM and 6 PM, to give an average of 3 hours per day. 


Do not enter anything into maximum total hours. Entering information there throws off the attendance calculation. 


Be sure to click “Save Changes” to make sure the information gets updated. 


### Program Quality Surveys


Below the general information box is a section called “Surveys.” This actually refers to the program quality surveys, which are like customer feedback forms the youth fill out to communicate how they felt about the program. 


These surveys are given at the end of each session, typically before the last day because attendance seems to be lower on the last day. Someone who does not deliver the program should administer these surveys. This can either be an Enlace staff person (the Data Specialist often does this), or someone at the partner organization who does not deliver the actual program. For example, the YMCA has interns working on other projects administer these surveys. The surveys can be done in a group, so long as the staff who deliver the program cannot see individual responses. 


Each session of the program will have a row on the program profile page. The fraction will show the number of completed surveys in the numerator and the total number of enrolled participants for that session in the denominator. The percentage is just calculated from that fraction. 


To enter a new survey, click on “Add a new Program Quality Survey.” Simply select the appropriate session and record the youth’s responses, making sure to click “Save” so the information gets stored. To add more surveys, refresh the page so that you are taken to a blank survey form; this reduces the chance of errors in transferring the information. 


### Add/Edit Sessions 


Back at the top of the screen are two sections: “Add New Session” and “Edit Session Name.” The mechanics for these are fairly straightforward. The one point to note is that start and end dates cannot be changed once the session has been created. Therefore it is a good idea to overestimate the amount of time needed for the session: have an earlier start date and later end date than is necessary. Also it’s a best practice to provide as much information as needed. For example, “Spring 2015 Girls Volleyball” is much more descriptive and useful than “Spring Session.” 


As for when a new session should be created, that depends largely on the type of program and the schedule it follows. Workshop-type programs or sports leagues with definite start and end dates are fairly straightforward. Other programs are ongoing without clear start and end dates. A discussion should take place with the partner to determine the best time frame for sessions. When to do intake an impact surveys can provide a guide: they should be long enough to allow the surveys to show change in youth responses, but regular enough so that data are available for reporting. Some programs have followed the school calendar with a school year session and a summer session, others have new sessions every 6 months. 


### Participants


This section shows which participants are enrolled in each session. Note that sessions will not show up here unless a participant has been added to them. 


Session names will be listed (if it has participants enrolled in it), and a red X will be to the right of each name. Use this to delete a session. This is sometimes necessary if a session was mistakenly added. Data entry users do not have the ability to do this; they must contact a system administrator to do that. 


Following each session name will be the participants in that session. To the right of each name will be dosage percentage (number of sessions attended that session divided by the total number of sessions), total hours in this program, total hours across funded programs (all LVYSN programs), intake survey completed (yes/no, usually indicates whether they have a recent intake recorded in the system, but this does not always work right), and a red X to remove them from the program. 


Editing participant records will be addressed in the next large section. 


Please note that data entry users cannot remove a participant from a program. If a youth attends for a few sessions and then drops, data entry users can click on the “Drop from program” option, which is preferable because it maintains the record of their attendance in the program, even if they did not complete it. If a youth was mistakenly entered (such as a misspelling of a name or double entry), they should contact an administrator to remove the participant from the program. 


At the end of the list of participants, you will find a link to “Add a participant.” This is how participants should be added to sessions. Users should search for participants in the system first, using the name and date of birth in YYYY-MM-DD format (or click on the date in the pop-up calendar). When searching for the name, they should not include any spaces after the name because the system treats the space as a character. For example, if “Maria ” is put into the search box for the first name, not every Maria in the system will show up. They should type in “Maria” without the quotation marks. 


If there is a match, they should select the participant record from the drop-down menu highlighted in yellow, select the appropriate session in the next drop-down menu, and click “Add participant.” If there is not a match, the drop-down menu highlighted in yellow will have “---” as the only choice. In that case, they should select the session from the next drop-down menu, fill out the information in the following box (Name, Date of Birth from the pop-up window, phone numbers, grade level, gender, school, and role), and click “Save;” they should not click on “Add participant.” 


### Program Dates


Below the “Add a participant” link is the Program Dates section. This is where attendance is recorded. All sessions should be listed here. To add an attendance date, data entry users should click on the box next to “Add Date” and select the date from the pop-up menu or enter using YYYY-MM-DD format, use the following drop-down menu to select the appropriate session, and click “Submit.” They can add several dates at one time if they wish. 


To record attendance for a date that has already be added to the system, they should click on the appropriate session. The dates will appear below the session name. The system assumes every participant was present. Users should simply uncheck the tick box next to the name of the participant who were absent; there is no need to save or submit. Note that participants who are added later (for example, 3 weeks after programming starts & attendance has been entered) are assumed present at every date previously entered, so users should go back and mark them absent for any dates they missed. 


### Mentorship Hours


The last section only appears on programs which have mentorship checked as an activity in the general information box. This is simply a record of all participants with mentorship hours. Again, this is broken down by hours in the program being viewed, and across all LVYSN programs. 



## Section 3: Participants Tab & Participant Records 


The participants tab itself is one that is not used very often. Here you can search for participants. You can search by name, date of birth, etc., or any combination you want. If you need to get a list of all participants, leave every field blank and click on “Search.” You can sort the results by clicking on “ID,” “Name,” or “DOB.” 


### Participant Records


On an individual participant’s page, there are several things to note. 


### General Information Box


Like programs, there is a box on the left side of the main screen that gives a lot of general information, this time about the participant. Her/his name, address, phone number, etc. are there. Additionally, there is space to record what early warning indicators (failing a core course, missing 20+ days of school, and/or having a recorded disciplinary incident) qualify the youth for participation in LVYSN programming. However, this has not been very well kept. 


Near the bottom of this box is a record of any intakes (pre surveys) and impact (post surveys) that have been done. You can click on the date to edit the survey. If somehow the survey was double-entered, you can click on “Delete Survey” to remove it from the system. However, use caution because that action cannot be undone. 


Below the record of surveys already entered are the links for adding new intake assessments and program impact surveys. Users should simply click on the link, be sure to select the appropriate session and date for when the survey was done, fill out the responses, and click “Save” to ensure the information is recorded. 


Data entry users, when adding participants and doing intake assessments, should first check the database to ensure participants are not already enrolled in another session. There are two likely scenarios that would mean a program would not need to do an intake with a participant. The first is if the youth is enrolled in another program at the same time. For example, they may have started the school year and enrolled in the youth program at Universidad Popular and CYBC. If users see that the participant is enrolled in another program, they should contact the other program to coordinate who should do the intake/impact surveys. Generally, the program where the youth first enrolled should do the surveys. The other situation is if the youth has an impact survey from the last 6 months. If that is the case, the database will copy their information directly into a new “intake” that can be used as their baseline for the current program (the idea being to reduce the number of surveys youth have to do). If neither of these conditions are met (either the youth has not been enrolled in other sessions, or her/his surveys are more than 6 months old), then the program should do an intake with her/him. 


### Other information on left side of the screen


On the left side of the screen, there are also sections for adding a parent to the youth’s record, indicating that a consent form has been completed, and a box for follow-up notes. However, these have not been used. 


### Program Involvement 


This shows all the programs the participant has been involved in. The program names are links that take you to the programs’ pages. It is also possible to add the participant to a program from here. However, that does not add them to a session, so adding them this way is not recommended. 


### Event Attendance


If a youth has attended an event, that will be recorded here. But, as events have not been used much, it is unlikely there will be anything here. 


### Mentorship Hours


If a youth is in a program with mentoring, this is where mentorship hours are recorded and displayed. First is the display of each mentorship dates: the date, number of hours, program involvement, and buttons to edit or delete the date. At the bottom of the list is the space for adding mentorship dates. 


### Referrals


This was a feature that was intended to record referrals. However, this was an extra step that did not aid in making referrals, so it has not been used. 



## Section 4: Reports Tab


The Reports tab has 4 different sections: Programs (gives enrollment figures), Assessments, Program Quality, and Exports. 


### Programs Section


The Programs section of the reports tab shows the enrollment for every session in the database. Total enrollment is the number of youth who were put into that session, total dropped is the subset of that number who started the program but were dropped, and current enrollment is just total enrollment minus drops. 


At the bottom of the page there are two totals. Total number of students per category gives the total, unduplicated enrollment figures. Total for all programs counts the number of times youth were enrolled in a session, meaning youth may be counted more than once. 


The results can be filtered by month and year (both a month and year must be selected). This shows enrollment for any session that was active during that month. A future improvement would be the ability to select a range of months, but that is not possible at the moment. 


### Assessments


The Assessments section is where you can see quick results from the pre/post surveys. Simply click on the box next to the session(s) you want to view, and click “Show results” at the bottom. You can filter by specific questions, but it’s typically easier just to get all the results and scroll to the information you want. 


Getting information this way is useful when communicating to partners how they can look at their outcomes information. The trouble with the way it is arranged is that it just describes the aggregate for all youth in that session, whether or not they completed both the pre and the post. One typical problem is that there are often more youth who complete the pre survey than the post. Therefore any change is not necessarily reflecting an actual change in youth, but may just be coming from the sample changing. Still, it’s useful for a quick glance. 


### Program Quality


The Program Quality section displays the results of the program quality surveys. You can look at results from all sessions, or look at individual ones. A possible improvement would be to be able to select multiple but not all sessions. Like with the pre/post surveys, it is possible to filter by a specific question, but it is typically easier just to get the results for all questions and scroll to the information you want. These are typically very positive results and useful for partners to be able to share about their programs. 


### Exports


This is where the raw data can be extracted from the database into CSV files to be analyzed in Excel, SPSS, or another software package. 


There are many different exports. The most useful have been: 


- All participants: This gives a listing of all participants in the database, and their basic information (not their survey results). 
- All intake assessments: This shows all intakes that have ever been done. It is useful for looking at the data in the neighborhood, school, and exposure to violence sections. 
- Program participation: This tells which participants have attended which sessions. 
- Program attendance: For each session, it gives attendance for each date. Be aware this is a massive file. 
- Participant dosages: This tells how many hours of service each participant has received (their attendance plus mentorship hours). 
- New survey exports: This is the most useful export. This displays only matched pre/post surveys, making it relatively easy to analyze. 
Once downloaded, there may be further cleaning required. For example, some surveys will have been entered with significant portions missing. These have not been deleted because they have other information that may be useful (say, they have outcomes data but not the exposure to violence questions), but it does necessitate going through the file before performing any analysis. 


________________


Section 5: Other Database Features


There are a few other database features available. They are not used nearly as much, but awareness is helpful. 


Institutions


Institutions are organizations that deliver services, schools youth attend, or similar entities. Every program in the database should be associated with an institution. Therefore whenever a new partner joins the network, their institution profile should be made first. Creating the profile should include a point person who already exists in the database. Therefore the process is create a participant profile for the point person, create the institution profile, then create the program. 


Campaigns


Campaigns are ways to group events together, and record which institutions are involved in the campaign. There might be a use for this in the future, but to this point, this feature has not really been used. 


Events


The events tab is a way to record who attends individual events. Participants who attend the events must already have a profile in the database. As with campaigns, this may be useful in the future but has not yet been utilized much. 


________________


Section 6: Working with Data Entry Users


Data entry users are key to the functioning of the database. If they know how to use the database and keep up with entering information, the Youth Safety Network has the data it needs to support and improve its work. If they are ill-informed or not timely with their entry, it takes a lot of effort to get the necessary information. 


Every organization should have one person with responsibility for the database, though more people can be trained (it’s helpful if more than one person is familiar with the database, so that they can support each other). 


Before any user can receive a login, they must fill out a confidentiality statement. Additionally, there is an agreement (titled TTM Non-Disclosure Agreement) that an organizational representative should sign. 


As previously mentioned, user names are often first initial followed by last name. Passwords should, ideally, be created by the user themselves. Alternatively, provide them with a password that is easy for them to remember but hard to guess, and ask them to change it. 


Whenever someone starts working on the database, an administrator should do a training with them. Typically, this is the Data Specialist. The person delivering the training should give an overview of the Youth Safety Network and how the database fits into the Network’s efforts, then demonstrate how to log in, create new sessions, add participants, add surveys, mark attendance, etc. Therefore having computer and Internet access is critical, though typically just huddling around a laptop is fine; a projector is not normally needed. 


Clearly communicate that data entry users should reach out to admin users if they encounter any problems or challenges. The data entry user guide is a good resource to share, though it may not answer every challenge that comes up. Check in with them periodically, especially if that can be incorporated into other meetings. 



## Section 7: Routine Maintenance


There are several things that should be done periodically to keep the database in good shape. 


Biweekly - Do a quick check of each partner’s page to see if they are adding new participants, adding intake/impact surveys, entering attendance (whatever is appropriate for where they are in their session cycle). If they are lagging behind or if you see an issue, follow up with them. 


Monthly - Go through the list of participants and delete any double entries. Also go more deeply into each partner’s page to see if there are issues with intakes, etc. 


Periodically - Before reports to funders, grant applications, and quarterly partner meetings, download the data, clean it, and explore any findings that can be shared. 


Yearly - Update the non-disclosure agreement and individual consent forms. Also be sure to pay the company doing the back end maintenance (currently Open Tech Strategies) for their services. 



## Section 8: Back-End Maintenance & Development


Many problems and situations network administrators can address themselves. However, some things are beyond their ability to fix. Additionally, there may be things about the database you would like to change, such as altering the structure of surveys or the things that data entry users should have access to. At this point, you should contact the back end maintenance support (currently Open Tech Strategies). 


As of this writing, there are 3 levels of support. 


- The first is fixing bugs that come up in the database (existing features are not working properly). A recent example was that the red X for deleting participants from the system was not working. This is included in the cost of hosting the database. Send an email describing the situation in detail, including a screenshot if possible. 
- The next level is a change that would be relatively simple to implement. One example would likely be creating a new survey that would be incorporated into the database. This would cost money (charged at an hourly rate) but less than the next level. 
- The last level includes changes that would be more intensive. An example would be making the database into a customer relationship management system as well as a participant database. This would cost the most money per hour. 
You can view the code and discussions about it at https://github.com/OpenTechStrategies/lisc-ttm. If you have trouble viewing the documents, contact Open Tech Strategies.
