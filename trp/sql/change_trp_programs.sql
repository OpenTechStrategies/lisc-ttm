/*
 * This file will add a "La Casa" program to TRP's program table in accordance 
 * with Issue #5.  This file should be run before deleting any programs,
 * such that the La Casa program will have program ID equal to 6.
*/


USE ttm-trp;

INSERT INTO Programs (Program_Name) VALUES ('La Casa');

/*Connect sample participants to the La Casa program.  Again, we will 
want to change the way we do this later but I need to finish it for now.*/

INSERT INTO Participants_Programs (Participant_ID, Program_ID) 
    VALUES ('69', '6'), ('70', '6'), ('71', '6');
