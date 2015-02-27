<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/core/tools/db.php";

$cnnTRP = get_or_setup_db_conn(
    "TRP",
    new ConnectionMaker("localhost", "ttmtrprw", "TESTPASS", "ttm-trp"));

?>
