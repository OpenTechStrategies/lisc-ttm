        <link href="/styles/styles.css" rel="stylesheet" type="text/css" />
        <link href="/include/jquery/1.9.1/css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css" />
        <script src="/include/jquery/1.9.1/js/jquery-1.8.2.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.core.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.datepicker.js" type="text/javascript"></script>

        <!-- adds calendar to text boxes with this class.
        Uses format as specified and allows for a year dropdown.
        -->
	<script>
            //on program profile
	$(function() {
                $(".hadDatepicker").datepicker({dateFormat: "mm-dd-yy"},
            { changeYear: true });
                //$("#first_program_date").datepicker();
	});
        

	</script>

