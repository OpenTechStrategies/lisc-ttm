<?php

//takes as arguments the query, database connection and database connection
//file, column headers, and file name.

//code drawn from tutorial at:
// http://code.stephenmorley.org/php/creating-downloadable-csv-files/

function generalized_download($download_name){
    $download_list_array=array('aldermans_records'=>array('db'=>'bickerdike', 'query'=> 'SELECT * FROM Aldermanic_Records'));
    if (array_key_exists($download_name, $download_list_array)){
    if (isset($_COOKIE['user'])){
        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$download_name . '.csv');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // output the column headings
        //fputcsv($output, $column_headers);

        // fetch the data
        $conn_file='../'.$download_list_array[$download_name]['db'].'/include/dbconnopen.php';
        include $conn_file;
        $db_name= 'cnn' .ucfirst($download_list_array[$download_name]['db']);
        $database_conn=$$db_name;
        $query_sqlsafe=$download_list_array[$download_name]['query'];
        $rows = mysqli_query($database_conn, $query_sqlsafe);
        
        // loop over the rows, outputting them
        while ($row = mysqli_fetch_row($rows)) {
            fputcsv($output, $row);}
        

        exit;
    }
    else{
        include "error.html";
        exit;
    }
    }
    {
        echo "This key does not exist.";
        //create a new error page?  This should only happen when someone has
        //done something nefarious.
    }
}
generalized_download($_POST['download_name']);
generalized_download('aldermans_records');
?>