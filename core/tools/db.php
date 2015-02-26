<?php

$DBCONNS = array();

function get_or_setup_cb_conn($db_id, $setup_func) {
    global $DBCONNS;
    if (array_key_exists($DBCONNS, $db_id)) {
        return $DBCONNS[$db_id];
    } else {
        $conn = $setup_func();
        $DBCONNS[$db_id] = $conn;
        return $conn;
    }
}

function maybe_close_dbconn($db_id) {
    global $DBCONNS;
    if (array_key_exists($DBCONNS, $db_id)) {
        mysqli_close($DBCONNS[$db_id]);
        return true;
    } else {
        return false;
    }
}

function close_all_dbconn() {
    global $DBCONNS;
    while (count($DBCONNS) > 0) {
        $conn = array_pop($DBCONNS);
        mysqli_close($conn);
    }
}

?>
