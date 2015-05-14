<?php
include "../../header.php";
include "../header.php";

include $_SERVER['DOCUMENT_ROOT'] . "/core/tools/merge.php";
include "../include/dbconnopen.php";

echo find_duplicates('enlace');

include "../../footer.php"
?>