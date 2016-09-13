<?
	class TaxonomyTypeTool{
		function fetch($id) {
			$sql = "SELECT * FROM taxonomy_types WHERE id = ".$id;
			$result = mysql_query_door($sql);
			$list = array();
			if ($TaxonomyType = mysql_fetch_object($result, "TaxonomyType")) {
				mysql_free_result($result);
				return $TaxonomyType;
			}
			else
				return false;
		}
		function fetch_by_keyword($keyword) {
			$sql = "SELECT * FROM taxonomy_types WHERE keyword = '".$keyword."'";
			//echo $sql;
			$result = mysql_query_door($sql);
			// Importante: no quitar la @
			if ($TaxonomyType = @mysql_fetch_object($result, "TaxonomyType")) {
				mysql_free_result($result);
				return $TaxonomyType;
			}
			else
				return false;
		}
	}