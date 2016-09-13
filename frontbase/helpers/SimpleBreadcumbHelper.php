<?

	class SimpleBreadcumbHelper {
		
		function printit($items) {
			if (is_array($items)) {
				$separator = " > ";
				foreach ($items as $key => $item) {
					if (isset($item["url"]) && !($key == count($items)-1 )) {
				    echo "<a href='".$item["url"]."'>".$item["title"]."</a> > ";
					}
					else {
						echo "<span class='item depth".$key."'>".$item["title"]."</span>";
					}
				} 
			}
		}
	}