<?
	class TaxonomyType extends Translatable{
		
		function getTerms() {
			$list = array();
			$sql = "SELECT taxonomy_terms.* FROM taxonomy_terms WHERE taxonomy_terms.taxonomytype_id = ".$this->id." ORDER BY value";	
			$result = mysql_query_door($sql);
			while($taxonomy_type = mysql_fetch_object($result, "TaxonomyTerm")) {
				$list[] = $taxonomy_type;
			}
			return $list;
		}
	}
