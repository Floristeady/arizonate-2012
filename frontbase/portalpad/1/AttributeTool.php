<?


	class AttributeTool {
		function find_by_keyword($keyword) {
			$sql = "SELECT contents_attributes.* FROM contents_attributes WHERE keyword = '".$keyword."'";
			$result = mysql_query_door($sql);
			if ($attribute = mysql_fetch_object($result, "Attribute")) {
				return $attribute;
			}
		}	
		function find($id) {
			$sql = "SELECT contents_attributes.* FROM contents_attributes WHERE id = '".$id."'";
			$result = mysql_query_door($sql);
			if ($attribute = mysql_fetch_object($result, "Attribute")) {
				return $attribute;
			}
		}

		function find_by_type_id($type_id) {
			$sql = "SELECT attributes.* FROM attributes_types
			 LEFT JOIN attributes ON attributes.id = attributes_types.attribute_id
			 WHERE type_id = ".$type_id;
			$result = mysql_query_door($sql);
			$attributes = array();
			while ($attribute = mysql_fetch_object($result, "Attribute")) {
				$attributes[] = $attribute;
			}
			return $attributes;
		}	
	}