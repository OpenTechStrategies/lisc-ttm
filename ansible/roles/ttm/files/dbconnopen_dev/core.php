<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/core/tools/db.php";

$cnnLISC = get_or_setup_db_conn(
    "core",  // maybe cnnLISC?
    new ConnectionMaker("localhost", "ttmcorerw", "TESTPASS", "ttm-core"));

?>
