      <link href="/styles/styles.css" rel="stylesheet" type="text/css" />
        <link href="/include/jquery/1.9.1/css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css" />
        <script src="/include/jquery/1.9.1/js/jquery-1.8.2.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.core.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.datepicker.js" type="text/javascript"></script>
        
        <!--
        this is just like datepicker_simple, but includes its own input box (with datepicker).  Useful when this 
        item needs to appear (with calendar).
        -->
        
        <span id="add_date">Add Date: <input type="text" id="first_program_date"></span> 
		<script>
            //on search events
	$(function() {
                $("#first_program_date").datepicker({changeYear: true});
		$( "#date_start" ).datepicker({changeYear: true});
                $( "#date_end" ).datepicker({changeYear: true});
                $( "#start" ).datepicker({changeYear: true});
                $( "#end" ).datepicker({changeYear: true});
		$(".hasDatepickers").datepicker({changeYear: true});
	});
        </script>