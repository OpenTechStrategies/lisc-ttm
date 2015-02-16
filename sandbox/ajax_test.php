<?php
/* shows associated institutions and events; provides space to add a new event: */
include $_SERVER['DOCUMENT_ROOT'] . "/include/dbconnopen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/include/setup_user.php";

user_enforce_has_access($TRP_id);

include $_SERVER['DOCUMENT_ROOT'] . "/header.php";
?>

<h1>TRP Ajax funhouse!</h1>

<p>
  Looks like you've got TRP Access... great!
  Otherwise you wouldn't be seeing this message.
</p>

<p>The button below should be passable...</p>

<!-- onclick is bad form, but trying to demo with something familiar ;p -->

<input type="button" class="no_view" value="Press me" onclick="
       $.post('./ajax_submit.php',
              {passable: 'yes'},
              function() {alert('heck yeah');})
             .fail(function() {alert('Oh no');});">

<p>But this next one... you shall not pass!</p>

<input type="button" class="no_view" value="Press me" onclick="
       $.post('./ajax_submit.php',
              /* nyah nyah nyah */
              {passable: 'no'},
              function() {alert('heck yeah');})
             .fail(function() {alert('Oh no');});">


<?php
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>
