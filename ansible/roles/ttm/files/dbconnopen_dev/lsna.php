<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/core/tools/db.php";

$cnnLSNA = get_or_setup_db_conn(
    "LSNA",
    new ConnectionMaker("localhost", "ttmlsnarw", "TESTPASS", "ttm-lsna"));

?>
