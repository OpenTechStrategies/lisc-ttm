/*
* Add a "locked" flag to the users table.  If true, then the user will not be
* allowed to log in but will instead receive a message asking them to call OTS.
*/


USE ttm-core;

ALTER TABLE `Users` DROP COLUMN `Locked`;

ALTER TABLE `Users` ADD COLUMN `Locked` tinyint(1);

