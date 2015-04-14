<?php
ob_start();
include ($_SERVER['DOCUMENT_ROOT'] . "/core/tools/auth.php");
setupUserGlobal();
ob_end_clean();
?>
