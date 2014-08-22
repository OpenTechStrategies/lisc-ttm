/* 
 * In order to remove programs from TRP, we need to: 
 * Delete rows from Academic Info, Participants_Programs, 
 *       Participants_Program_Sessions,
 *       Program_Attendance, Program_Dates, Program_Sessions, Programs_Uploads.
 * After removing those child rows, we can delete the programs from the Programs
 *       table.
 * Delete entirely Elev8_data, Elev8_Elements, Gads_Hill_Parent_Survey,
 *       New_Horizons_Participants, NMMA_Participants, NMMA_Traditions_Survey.
 *       
*/

USE ttm-trp;

DELETE FROM Academic_Info WHERE Program_ID=3 OR Program_ID=4 OR Program_ID=5;

DELETE FROM Participants_Programs WHERE Program_ID=3 OR Program_ID=4 OR 
    Program_ID=5;

DELETE Participants_Program_Sessions FROM Participants_Program_Sessions 
    INNER JOIN Program_Sessions 
    ON Participants_Program_Sessions.Session_ID = Program_Sessions.Session_ID
    WHERE Program_Sessions.Program_ID=3 OR Program_Sessions.Program_ID=4 
    OR Program_Sessions.Program_ID=5;

DELETE FROM Program_Attendance WHERE Program_ID=3 OR Program_ID=4 OR
    Program_ID=5;

DELETE FROM Program_Dates WHERE Program_ID=3 OR Program_ID=4 OR Program_ID=5;

DELETE FROM Program_Sessions WHERE Program_ID=3 OR Program_ID=4 OR Program_ID=5;

DELETE FROM Programs_Uploads WHERE Program_ID=3 OR Program_ID=4 OR Program_ID=5;

DELETE FROM Programs WHERE Program_ID>2 AND Program_ID<6;


DROP TABLE IF EXISTS Elev8_Data;

DROP TABLE IF EXISTS Elev8_Elements;

DROP TABLE IF EXISTS Gads_Hill_Parent_Survey;

DROP TABLE IF EXISTS New_Horizons_Participants;

DROP TABLE IF EXISTS NMMA_Participants;

DROP TABLE IF EXISTS NMMA_Traditions_Survey;

DROP TABLE IF EXISTS NMMA_Identity_Survey;

