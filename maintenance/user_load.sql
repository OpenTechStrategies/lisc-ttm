
    /* To load this sql file and save these hashed passwords in the Users table:
      mysql> use ttm-core;
      Database changed
      mysql> source 'user_load.sql';
*/
    TRUNCATE ttm-core.Users;  
    INSERT INTO ttm-core.Users (User_ID, User_Password) VALUES ('user', '$2a$08$G6W7amYrMKiVFzZUeFvW3uztQ7LhADD/rBKgsznxOIL99ly2SnK/W'), ('cecilia', '$2a$08$2VFvOTNvaKuQ1CW02QIKPuaos3EKtu7Gwy5yZBliluPknkeLN3GUq');