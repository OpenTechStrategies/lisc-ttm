
    /* To load this sql file and save these hashed passwords in the Users table:
      mysql> use ttm-core;
      Database changed
      mysql> source 'user_load.sql';
*/
UPDATE ttm-core.Users SET User_Password='$2a$08$U0BvMOrT1zP31SUvM1Q6SedMqNtUpdVo49DjuJjG3Ff1WzCsALQma' WHERE User_ID='user';
UPDATE ttm-core.Users SET User_Password='$2a$08$OwnnUpCXwdzFJQx0QwT/T.xWZdrWUzsBbZrNnfGh3ioOxdZrApzU.' WHERE User_ID='cecilia';
