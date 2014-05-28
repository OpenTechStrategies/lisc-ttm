<div id="swop_header">
	<script>
		$(document).ready(function(){
		<?
	if (!isset($_COOKIE['user'])) {
            /* if the user isn't logged in, take them to the login page: */
	?>
		window.location = '/index.php';
	<?
	}
	?>
			$("td.menu_item").hover(function(){
				$(this).addClass("select");
			}, function() {
				$(this).removeClass("select");
			});
		});
	</script>
        <!-- menu of options: -->
	<table width="100%">
		<tr>
			<td rowspan="2" id="logo" width="23%"><a href="/swop/index.php"><img width="250px;" src="/swop/images/logo-swop.jpg" /></a></td>
			<td colspan="6"><h2>Chicago Lawn: Southwest Organizing Project</h2></td>
		</tr>
		<tr>
			<td class="menu_item"><a href="/swop/participants/participants.php" id="participants_selector">Participants</a></td>
			<td class="menu_item"><a href="/swop/properties/properties.php" id="properties_selector">Properties</a></td>
			<td class="menu_item"><a href="/swop/campaigns/campaigns.php" id="programs_selector">Campaigns</a></td>
			<td class="menu_item"><a href="/swop/institutions/institutions.php" id="institutions_selector">Institutions</a></td>
			<td class="menu_item"><a href="/swop/reports/reports.php" id="reports_selector">Reports</a></td>
			<td class="menu_item"><a href="/swop/index.php?action=logout">Log Out</a>
		</tr>
		<tr>
			<td colspan="7"><hr/></td>
		</tr>
	</table>	
        <?
if ($_COOKIE['sites']){
    /* if any sites are set... */
    if (in_array('5', $_COOKIE['sites'])){
       /* if this person has SWOP permission: */
        if (isset($_COOKIE['view_restricted'])){
            //this is what needs to be hidden from data entry and finance-only people?>
            <script type="text/javascript">
                $(document).ready(function() {
                  //  alert('view restricted is set');
                    $('.hide_on_view').hide();
                    $('.hide_exception').hide();
                });
                </script>
        <?}
        if (isset($_COOKIE['view_only'])){
            //this is for finance-only users
           ?> <script type="text/javascript">
                $(document).ready(function() {
                    $('.hide_on_view').hide();
                    $('.hide_exception').show();
                });
                </script><?
        }
    }
    else{
        /* don't have SWOP permission, send them to the start page: */
        ?>
                
            <script type="text/javascript">
                	$(document).ready(function() {
                    //$('#main_wrapper').hide();
					window.location='/index.php';
                });
                </script>
            <?
    }
  //  include "include/datepicker.php";
}
else{
    /* don't have permission for any site, take them to the start page.*/
    ?>
            <script type="text/javascript">
                	$(document).ready(function() {
                    $('#main_wrapper').hide();
                    window.location = '/index.php';
                });
                </script>
            <?
}
?>
</div>