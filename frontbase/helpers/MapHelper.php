<?

class MapHelper {

	function MapHelper(&$page = null) {
		if (is_object($page)) {
			$page->head->addscript("http://maps.google.com/maps?file=api&amp;v=2&amp;key=".get_configuration_param("gmapskey")."&amp;hl=".get_current_lang());
		}
		else {
			// Ya ha sido añadido manualmente (bbbac)	
		}
	}
	
	function output($map, $width = 300, $height = 300, $options = null){
		if (is_null($options)) {
			$options = array("MapControl" => true, "TypeControl" => true);
		}
		
		$str = "<div id='map_".$map->unique_id."' style='overflow: hidden; width: ".$width."px; height: ".$height."px;'>";
		$str .= "</div>";
		$str .= "
		<script>
	  function createMarker(point,html) {
	    var marker = new GMarker(point);
	    GEvent.addListener(marker, 'click', function() {
	      marker.openInfoWindowHtml(html,{maxWidth:180});
	    });
	    return marker;
	  }
		window.onload=function(){
		  if (GBrowserIsCompatible()) {
		    var map_".$map->unique_id." = new GMap2(document.getElementById('map_".$map->unique_id."'), {size: new GSize($width, $height)});
		    map_".$map->unique_id.".setCenter(new GLatLng(".$map->center_latitude.", ".$map->center_longitude."), ".$map->zoom.");
		";
		
		foreach ($map->points as $point) {
			  $str .= "var point = new GLatLng(".$point->latitude.",".$point->longitude.");


        map_".$map->unique_id.".addOverlay(createMarker(point,'".$point->info->label."'));";

		}



    if ($options["MapControl"]) {
    	$str .= "map_".$map->unique_id.".addControl(new GSmallMapControl());";
    }
    if ($options["TypeControl"]) {
    	$str .= "map_".$map->unique_id.".addControl(new GMapTypeControl());";
		}
				

		$str .= "}
		// implementacion de checkResize();
		}
		</script>
		";
		return $str;
		
	}

}

