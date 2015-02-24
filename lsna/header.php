<div id="lsna_header">
	<script>
		$(document).ready(function(){
		<?php
	if (!isset($_COOKIE['user'])) {
            /*if not logged in (or if cookie expires), go to the login screen: */
	?>
		window.location = '/index.php';
	<?php
	}
	?>
			$("td.menu_item").hover(function(){
				$(this).addClass("select");
			}, function() {
				$(this).removeClass("select");
			});
		});
	</script>
	<table width="100%">
		<tr>
			<td id="logo"><!--- Link to LSNA home page --><a href="/lsna/index.php"><img src="/lsna/images/logo.gif" /></a></td>
                        <td class="menu_item"><!-- Link to participants page.  Sets search page cookie, unsets the profile and new cookies. -->
                            <a href="javascript:;" onclick="
                            $.post(
                            '/lsna/ajax/set_participant_id.php',
                            {
                                page: 'search'
                            },
                            function (response){
                            if (response!='1'){
                                document.getElementById('show_error').innerHTML = response;
                            }
                            window.location='/lsna/participants/participants.php';
                       });" id="participants_selector">Participants</a></td>
			<td class="menu_item"><!-- Link to programs/campaigns page.  Sets search page cookie, unsets the profile and new cookies. -->
                            <a href="javascript:;" onclick="
                                                  $.post(
                                                    '/lsna/ajax/set_program_id.php',
                                                    {
                                                        page: 'search'
                                                    },
                                                    function (response){
                                                        if (response!='1'){
                                                            document.getElementById('show_error').innerHTML = response;
                                                        }
                                                        window.location='/lsna/programs/programs.php';
                                                    }
                                              )" id="programs_selector">Issue Areas</a></td>
			<td class="menu_item"><!-- Link to institutions page.  Sets search page cookie, unsets the profile and new cookies. -->
                            <a href="javascript:;" onclick="
                                            $.post(
                                            '/lsna/ajax/set_institution_id.php',
                                            {
                                                    page: 'search'
                                            },
                                            function (response){
                                                    if (response !='1'){
                                                            document.getElementById('show_error').innerHTML = response;
                                                    }
                                                    window.location='/lsna/institutions/institutions.php';
                                            }
                                                                    )" id="institutions_selector">Institutions</a></td>
			<td class="menu_item"><a href="/lsna/reports/reports.php" id="reports_selector">Reports</a></td>
			<td class="menu_item"><a href="/lsna/index.php?action=logout">Log Out</a>
		</tr>
		<tr>
			<td colspan="6"><hr/></td>
		</tr>
	</table>	
</div>
<?php
if ($_COOKIE['sites']){
    if (in_array('2', $_COOKIE['sites'])){
       /* then the user has access to LSNA */
        if ($_COOKIE['view_restricted']){
            //this is what needs to be hidden from both data entry and view-only people?>
<style type="text/css">.hide_on_view {display:none}</style>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('.hide_on_view').hide();
                });
                </script>
        <?php }
        if ($_COOKIE['view_only']){
            /*hide these things from view-only users.*/
            ?>
<style type="text/css">.no_view {display:none}</style><?php
        }
    }
    else{
        /*user doesn't have access to LSNA, is returned to the homepage.*/
        ?>
                
            <script type="text/javascript">
                	$(document).ready(function() {
                    //$('#main_wrapper').hide();
					window.location='/index.php';
                });
                </script>
            <?php
    }
    include "include/datepicker.php";
}
else{
    /* user has access to no sites, is returned to the homepage.*/
    ?>
            <script type="text/javascript">
                	$(document).ready(function() {
                    $('#main_wrapper').hide();
                    window.location = '/index.php';
                });
                </script>
            <?php
}
?>