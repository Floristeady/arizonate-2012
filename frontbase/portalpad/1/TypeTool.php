<?

	class TypeTool {
		static function fetch($type_id) {
			if(isset($type_id)) {
				$result = mysql_query_door("SELECT * FROM types WHERE id = ".$type_id);
				if ($type = mysql_fetch_object($result, "Type")) {
					mysql_free_result($result);

					return $type;
				}
			}
		}
		static function fetch_all() {
			$list = array();
			$result = mysql_query_door("SELECT * FROM types");
			while ($type = mysql_fetch_object($result, "Type")) {
				$list[] =  $type;
			}
			return $list;		
		}
	}
