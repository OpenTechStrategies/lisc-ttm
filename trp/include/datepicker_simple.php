<?php
//require_once("../siteconfig.php");
?>
      <link href="/styles/styles.css" rel="stylesheet" type="text/css" />
        <link href="/include/jquery/1.9.1/css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css" />
        <script src="/include/jquery/1.9.1/js/jquery-1.8.2.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.core.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.datepicker.js" type="text/javascript"></script>
       
        
        <!-- adds to a calendar to text boxes for consistent date format -->
		<script>
            //on search events
	$(function() {
                $(".hasDatepickers").datepicker({dateFormat: "mm/dd/yy",
                changeYear: true,
                yearRange: "1920:2016"});
                
                $(".hasDatepick").datepicker({dateFormat: "yy-mm-dd",
                    changeYear: true,
                yearRange: "1920:2016"});
	});
        </script>
        