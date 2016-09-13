<?

class FlashMessageHelper {
	function show($dissapear = true, $show_container = true, $jquery_prefix = "\$", $effect_method = "fadeOut(1500)") {
		if($message = FlashMessage::get()) { 
		if ($show_container) {
	?>
<div id="FlashMessageContainer">
	<?
}
	?>
	<div id="FlashMessage">
		<?=$message?>
	</div>
<?
		if ($show_container) {
?>
</div>
	<?
}
			if ($dissapear) {
	?>
<script>
		var t= setTimeout(function(){<?=$jquery_prefix?>('#FlashMessage').<?=$effect_method?>}, 2000);
</script>
<?
			}
		} 
	}

}