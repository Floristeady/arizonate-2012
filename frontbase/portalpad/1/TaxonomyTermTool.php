<?
		
	class TaxonomyTermTool {
		static function fetch_list($taxonomytype_id) {
			$sql = "SELECT * FROM taxonomy_terms WHERE taxonomytype_id = ".$taxonomytype_id." ORDER BY value";
			$result = mysql_query_door($sql);
			$list = array();
			while ($row = mysql_fetch_object($result, "TaxonomyTerm")) {
				$list[] = $row;
			}
			mysql_free_result($result);
			return $list;
		}
		static function find($taxonomyterm_id) {
			$sql = "SELECT * FROM taxonomy_terms WHERE id = ".$taxonomyterm_id;
			$result = mysql_query_door($sql);
			$list = array();
			if ($row = mysql_fetch_object($result, "TaxonomyTerm")) {
				return  $row;
			}
			return false;
		}

	}