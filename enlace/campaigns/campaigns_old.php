<?
	include "../../header.php";
	include "../header.php";
?>

<!--
Obsolete file.
-->

<script type="text/javascript">
	$(document).ready(function() {
		$('#campaigns_selector').addClass('selected');
		$('#ajax_loader').hide();
		$('#add_new').hide();
	});
	
	$(document).ajaxStart(function() {
        $('#ajax_loader').fadeIn('slow');
    });
            
    $(document).ajaxStop(function() {
        $('#ajax_loader').fadeOut('slow');
    });
</script>

<img src="/images/ajax-loader.gif" width="40" height="40" alt="Loading..." id="ajax_loader" style="position: fixed; top: 0; left: 0;" />
<div class="content_block">
<h3>Campaigns</h3><hr/><br/>


</div>

<?
	include "../../footer.php";
?>