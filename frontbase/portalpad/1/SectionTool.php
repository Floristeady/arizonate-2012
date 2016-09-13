<?
	class SectionTool {
		function fetch($section_id) {
			
			$sql = "SELECT * FROM sections WHERE id = ".mysql_real_escape_string($section_id);
			$result = mysql_query_door($sql);
			//echo $sql;
			if ($section = mysql_fetch_object($result, "Section")) {
				mysql_free_result($result);
				return $section;
			}
		}
	}