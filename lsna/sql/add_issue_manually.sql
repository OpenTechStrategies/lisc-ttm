/*
 * Add an Issue_Service table for counting people who are served but
 * aren't participants in the TTM system.
*/

DROP TABLE IF EXISTS `Issue_Service`;

CREATE TABLE `Issue_Service`
(
 `Issue_Served_ID` int(11) NOT NULL AUTO_INCREMENT,
 PRIMARY KEY (`Issue_Served_ID`),
 `Number_Served` int(11),
 `Issue_ID` int(11),
 FOREIGN KEY (`Issue_ID`) REFERENCES `Issue_Areas`
         (`Issue_ID`)
         ON DELETE CASCADE
         ON UPDATE CASCADE,
 `Month` int(11),
 `Year` int(11)
) ENGINE=InnoDB;
