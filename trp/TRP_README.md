TTM: The Resurrection Project
======================

The Resurrection Project is a TTM member organization that focuses on  
education, particularly improving access to early childhood education  
in the Pilsen neighborhood of Chicago.  More information about them  
can be found on their website, at <a href="http://resurrectionproject.org/">  
http://resurrectionproject.org/</a>.  



19 August 2014
----------------

I am currently adding the La Casa section to the TRP implementation of TTM.  
The following describes how to add these tables and sample data, though  
we will include the La Casa tables and data in the global sample data to be   
loaded for any new implementation of TTM.  In the root directory of your  
TTM implementation, load these files to first create the new La Casa specific  
tables, then load the sample participants as participants, load their  
sample data into the new tables, and finally add them as participants in the   
La Casa program.
  
    $ mysql -u root -p  
    Enter password:  
    mysql> source trp/sql/la_casa_create_tables.sql  
    mysql> source trp/sql/load_la_casa_sample_participants.sql  
    mysql> source trp/sql/load_la_casa_sample_data.sql  
    mysql> source trp/sql/change_trp_programs.sql  

