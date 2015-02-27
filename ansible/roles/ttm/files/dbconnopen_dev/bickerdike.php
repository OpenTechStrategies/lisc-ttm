<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/core/tools/db.php";

$cnnBickerdike = get_or_setup_db_conn(
    "bickerdike",  // maybe cnnBickerdike?
    new ConnectionMaker("localhost", "ttmbickerdikerw", "TESTPASS", "ttm-bickerdike"));

?>
