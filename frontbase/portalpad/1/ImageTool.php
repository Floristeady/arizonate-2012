<?
	class ImageTool {
		function fetch($image_id) {
			$result = mysql_query_door("SELECT * FROM images WHERE id = ".$image_id);
			if ($img = mysql_fetch_object($result, "PImage")) {
				return $img;
			}
		}


	}