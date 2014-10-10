/* The load_la_casa_sample_participants.sql file must be run before this file.
 * 
 * Data from La Casa will be entered into the Participants table, the new
 * La_Casa_Residents table, and the new La_Casa_Students table.
 *
 * This is sample data for three people to be entered into those three tables.
 * 
 * Note that the Residents and Students tables will need to use the Participant
 * ID generated from the insertion into the Participants table.
*/


INSERT INTO Colleges (College_Name)
VALUES ('University of Chicago'), ('Southern Illinois University'),
('Howard Washington College');


INSERT INTO La_Casa_Basics (Participant_ID_Students, College_ID,
Credits)
VALUES ('69', '1', '3.5'), ('70', '2', '18');


