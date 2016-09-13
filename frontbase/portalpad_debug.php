<script>
	function toggle_debug() {
		if (document.getElementById('debug_window').style.display != 'block')
			document.getElementById('debug_window').style.display = 'block'
		else
			document.getElementById('debug_window').style.display = 'none'
	}

</script>


<div id='debug_window'>
	<h1>Info</h2>
	
	<h2>Templates</h2>
	<div class="modulo">
		<div class="fieldname">Page</div>
		<div class="fieldvalue">/sites/<?=get_current_site_space()?>/templates/pages/<?=$page_file?>.php</div>
	</div>
	<? if (!is_null($instance->sublayout_file)) {?>
	<div class="modulo">
		<div class="fieldname">Sublayout</div>
		<div class="fieldvalue">/sites/<?=get_current_site_space()?>/templates/sublayouts/<?=$instance->sublayout_file?>.php</div>
	</div>	
	<? } ?>
	<div class="modulo">
		<div class="fieldname">Layout</div>
		<div class="fieldvalue">/sites/<?=get_current_site_space()?>/templates/layouts/<?=$instance->layout_file?>.php</div>
	</div>
	<h2>Controller</h2>
	<div class="modulo">
		<div class="fieldname">Action</div>
		<div class="fieldvalue"><?=$action?></div>
	</div>
	<div class="modulo">
		<div class="fieldname">Controller</div>
		<div class="fieldvalue"><?=$controller?></div>
	</div>	
		
	<h2>Loaded Models</h2>
	<div class="modulo">
	<?=implode(",",$models)?>
	</div>	
	
	<? if (isset($instance->page_object->plugins)) {?>
	<h2>Page Object</h2>

	<div class="modulo">
		<div class="fieldname">Plugins</div>
		<div class="fieldvalue"><?=implode(",",$instance->page_object->plugins)?> </div>
	</div>
	<? } ?>

	<h2>Performance</h2>
	<div class="modulo">
		<div class="fieldname">Memory peak</div>
		<div class="fieldvalue"><?=memory_get_peak_usage()?></div>
	</div>	
	<div class="modulo">
		<div class="fieldname">Exec Time</div>
		<div class="fieldvalue"><?=$benchmark_total ?> seconds</div>
	</div>
	<div class="modulo">
		<div class="fieldname">PHP version</div>
		<div class="fieldvalue"><?=phpversion()?></div>
	</div>
</div>
<div id='debug_launch'>
	<a href="javascript:toggle_debug()" >info</a>
</div>

