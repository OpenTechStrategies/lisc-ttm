
</div>

<!--
Footer, including a link to the helpdesk email.
-->

<hr class="divider">
<div id="footer">
<span><a href="http://opentechstrategies.com"
      ><img src="/images/ots-logo-name.png" id="ots_logo" /></a></span>
      <?php if (isset($_COOKIE['user'])){ ?>
       <span id="helplink" class="helptext" ><a href="<?php echo '/include/contact.php';?>">Questions? Comments? Click here.</a></span>
      <?php } ?>
<span><a href="http://chapinhall.org/"
      ><img src="/images/chapin-hall-logo.png" id="ch_logo" /></a></span>
</div>
<hr class="divider">
</body>
</html>