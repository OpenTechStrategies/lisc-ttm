<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/core/tools/db.php";

$cnnSWOP = get_or_setup_db_conn(
    "SWOP",
    new ConnectionMaker("localhost", "ttmswoprw", "TESTPASS", "ttm-swop"));

?>
