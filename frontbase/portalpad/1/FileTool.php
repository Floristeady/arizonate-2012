<?

	class FileTool {
		function fetch($file_id) {
			$result = mysql_query_door("SELECT * FROM files WHERE id = ".$file_id);
			if ($img = mysql_fetch_object($result, "AttachedFile")) {
				return $img;
			}
		}

	}