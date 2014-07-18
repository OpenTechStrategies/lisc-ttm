<?php

//takes as arguments the query, database connection and database connection
//file, column headers, and file name.

//code drawn from tutorial at:
// http://code.stephenmorley.org/php/creating-downloadable-csv-files/

function generalized_download($dbconn_file, $database_conn, $query, $filename,
        $column_headers){
    if (isset($_COOKIE['user'])){
        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // output the column headings
        fputcsv($output, $column_headers);

        // fetch the data
        include $dbconn_file;
        echo "included file: " . $dbconn_file , "<br>"; //testing output
        $query_sqlsafe=mysqli_real_escape_string($database_conn, 
                $query);
        echo $query_sqlsafe; //testing output
        echo "<br>" . "Connection variable: " . $database_conn;  //testing output
        $rows = mysql_query($database_conn, $query_sqlsafe);

        // loop over the rows, outputting them
        while ($row = mysql_fetch_row($rows)) {
            print_r($row); //testing output
            fputcsv($output, $row);}


        exit;
    }
    else{
        include "error.html";
        exit;
    }
}

generalized_download('dbconnopen.php', $cnnLISC, "SELECT * FROM Privileges", 
        "privilege_list_7-18-14.csv", array("Privilege_ID", "Privilege_Name"));
?>