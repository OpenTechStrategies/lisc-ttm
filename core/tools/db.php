<?php

// Hashmap of currently open database connections.
// This is a hashmap of database identifier -> opendatabase connection
$DBCONNS = array();

// Set up the database connection, if needed, and return it.
//
// Args:
//  - $db_id: symbolic identifier (a string) for this database connection
//  - $setup_func: function which sets up the database conection
//    assuming one is not already set up
//
// Returns:
//  Set up database connection.

function get_or_setup_db_conn($db_id, $setup_func) {
    global $DBCONNS;
    if (array_key_exists($db_id, $DBCONNS)) {
        return $DBCONNS[$db_id];
    } else {
        $conn = $setup_func();
        $DBCONNS[$db_id] = $conn;
        return $conn;
    }
}


// Maybe close the database connection, assuming it's open.
//
// Args:
//  - $db_id: symbolic identifier (a string) for this database connection
//
// Returns:
//   A boolean saying whether it did close anything.
//   (Who knows if you'll ever need this info, but there it is!)

function maybe_close_dbconn($db_id) {
    global $DBCONNS;
    if (array_key_exists($db_id, $DBCONNS)) {
        $conn = $DBCONNS[$db_id];
        unset($DBCONNS[$db_id]);
        mysqli_close($conn);
        return true;
    } else {
        return false;
    }
}


// Close all open database connections

function close_all_dbconn() {
    global $DBCONNS;
    while (count($DBCONNS) > 0) {
        $conn = array_pop($DBCONNS);
        mysqli_close($conn);
    }
}


// Convenience class for making database connection init thunk for
//   get_or_setup_db_con()
// 
// With want to generate a database-initizing thunk, and absence of
// proper closures in PHP, we'll make do with using an invokable
// class instead.
//
// Args:
//  - $server: server name, eg "localhost"
//  - $user: user name, eg "ttmcorerw"
//  - $pass: password, eg "SUPER_SECURE"
//  - $db_name: name of the database we're connecting to, eg "ttm-core"

class ConnectionMaker {
    public $server;
    public $user;
    public $pass;
    public $db_name;

    public function __construct($server, $user, $pass, $db_name) {
        $this->server = $server;
        $this->user = $user;
        $this->pass = $pass;
        $this->db_name = $db_name;
    }

    public function __invoke() {
        $connection = mysqli_connect(
            $this->server,
            $this->user,
            $this->pass,
            $this->db_name)
	    or die ("Error Connecting To The Database Because: " . mysqli_connect_error());
        return $connection;
    }
}

?>
