        <link href="/styles/styles.css" rel="stylesheet" type="text/css" />
        <link href="/include/jquery/1.9.1/css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css" />
        <script src="/include/jquery/1.9.1/js/jquery-1.8.2.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.core.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.datepicker.js" type="text/javascript"></script>
        
        <!--
        Shows a calendar with the indicated classes and IDs
        -->
        <span id="add_date">Add Date: <input type="text" id="first_program_date"></span> <script>
            //on search events
	$(function() {
                $("#first_program_date").datepicker();
		$( "#date_start" ).datepicker();
                $( "#date_end" ).datepicker();
                $( "#start" ).datepicker();
                $( "#end" ).datepicker();
                $('.addDP').datepicker({changeYear: true,
                yearRange: "1920:2016"});
	});
        </script>