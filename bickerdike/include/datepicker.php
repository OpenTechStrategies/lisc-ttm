<!--
Makes calendars show up on the indicated ID fields.
-->   

<link href="/styles/styles.css" rel="stylesheet" type="text/css" />
        <link href="/include/jquery/1.9.1/css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css" />
        <script src="/include/jquery/1.9.1/js/jquery-1.8.2.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.core.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.datepicker.js" type="text/javascript"></script>

	<script>
            //on search events
	$(function() {
                $("#first_program_date").datepicker();
		$( "#date_start" ).datepicker();
                $( "#date_end" ).datepicker();
                $( "#start" ).datepicker();
                $( "#end" ).datepicker();
	});
        
        //on activity profile and add cws
        $(function() {
		$("#date_0" ).datepicker();
                $("#date" ).datepicker();
                $('#new_activity_date').datepicker();
	});
	
	//on program profile and enter survey
	$(function() {
		$('#new_date').datepicker();
                $("#first_program_date").datepicker();
                $('#survey_date').datepicker();
	});
	
	//on add event
	$(function() {
		$("#new_activity_date").datepicker();
	});
	
	//on Bickerdike contextual data
	$(function() {
		$('#bike_date').datepicker();
		$('#sales_date').datepicker();
                $('#env_date').datepicker();
	});
	
	//on aggregate survey results
	/*$(function() {
		$("#start").datepicker();
		$("#end").datepicker();
	});*/

        
        //on sort participant surveys
//         $(function() {
//	});
        
        //on subrecipients

	</script>

