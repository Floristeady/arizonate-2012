<? 
class AjaxHelper {
	function search_button($action_url, $form_id = null, $display_id = "List", $search_html = "Searching...") {
	?>
<a id="search_button" href="#" onclick="update_search_form(); return false;">Buscar</a>
<script>
			function update_search_form() {
					$('#<?=$display_id?>').html('<?=addslashes($search_html)?>');
					$.ajax({
						type: "GET",
						url: "<?=$action_url?>",
						data: $('#<?=$form_id?>').serialize(),
						success: function(msg){
							$('#<?=$display_id?>').html(msg);
						}
					});
			}
</script>
<?	
	}
	function search($action_url, $form_id = null, $display_id = "List", $search_html = "Searching...") {
		//echo "warning: AjaxHelper::search deprecated" ;
		self::search_button($action_url, $form_id, $display_id, $search_html);
	}
	function search_auto($action_url, $form_id = null, $display_id = "List", $search_html = "Searching...") {
	?>
<script>
				timeout_search = false;
				$("#<?=$form_id?> input[type='text']").keydown(update_search_form);
				$("#<?=$form_id?> input[type='checkbox']").click(update_search_form);
				$("#<?=$form_id?> input[type='radio']").click(update_search_form);
				$("#<?=$form_id?> select").change(update_search_form);

				function update_search_form() {
					$('#<?=$display_id?>').html('<?=addslashes($search_html)?>');
					if (timeout_search) clearTimeout(timeout_search);
						timeout_search = setTimeout(function(){
							$('#<?=$display_id?>').html('<?=addslashes($search_html)?>');
							$.ajax({
								type: "GET",
								url: "<?=$action_url?>",
								data: $('#<?=$form_id?>').serialize(),
								success: function(msg){
									$('#<?=$display_id?>').html(msg);
								}
							});
						}, 300);
					
					
				}
</script>
<?	
	}
		
}
	

?>