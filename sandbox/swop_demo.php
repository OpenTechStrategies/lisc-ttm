<?php
/* shows associated institutions and events; provides space to add a new event: */
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";
?>

<?php
user_enforce_has_access($SWOP_id);
?>

<html>
<head>
  <title>Fun demo time!</title>
</head>

<body>
  <h1>Welcome to this fun demo, <?php echo($USER->username); ?>!</h1>
  <p>If you got this far, you have access to SWOP.</p>
</body>
</html>
<?php
include ($_SERVER['DOCUMENT_ROOT'] . "/include/dbconnclose.php");
?>
