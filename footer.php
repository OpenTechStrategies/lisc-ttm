<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>

</div>

<!--
Footer, including a link to the helpdesk email.
-->

<hr class="divider">
<div id="footer">
<span><a href="http://opentechstrategies.com"
      ><img src="/images/ots-logo-name.png" id="ots_logo" /></a></span>
<?php if ( isLoggedIn()){ ?>
       <span id="helplink" class="helptext" ><a href="<?php echo '/include/contact.php';?>">Questions? Comments? Click here.</a></span>
      <?php } ?>
<span><a href="http://chapinhall.org/"
      ><img src="/images/chapin-hall-logo.png" id="ch_logo" /></a></span>
</div>
<hr class="divider">
</body>
</html>