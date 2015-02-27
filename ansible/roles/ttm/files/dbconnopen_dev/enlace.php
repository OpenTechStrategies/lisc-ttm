<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/core/tools/db.php";

$cnnEnlace = get_or_setup_db_conn(
    "enlace",
    new ConnectionMaker("localhost", "ttmenlacerw", "TESTPASS", "ttm-enlace"));

?>
