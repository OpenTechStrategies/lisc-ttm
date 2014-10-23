/*
 * Create table to store user sessions (i.e., determine whether users are logged in).
*/

USE ttm-core;

DROP TABLE IF EXISTS `User_Sessions`;

CREATE TABLE `User_Sessions`
(
`Session_ID` INT (10) NOT NULL AUTO_INCREMENT,
`PHP_Session` VARCHAR (100),
`User_ID` INT (10),
`Time_Logged_On` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
`Expire_Time` TIMESTAMP,
PRIMARY KEY (Session_ID)
)
ENGINE=InnoDB;