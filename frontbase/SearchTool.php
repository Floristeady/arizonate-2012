<?
class SearchTool {
	# TODO: ordenar resultados por relevancia
	# TODO: tomar la parte del body que tiene el resultado y hacer el hightlight
	
	function highlight($text, $keywords) {
		$search = $_GET['search'];
		$replace = "$search";
		foreach ($keywords as $keyword) {
			$text = preg_replace("|($keyword)|Ui" , "<span class='hightlight'>$1</span>" , $text );
		}
		return $text;
	}
	
	
	function SearchTool() {
		$this->search_str = null;
	}
	function run($search_str) {
		$keywords = explode(" ",$search_str);
		
		$this->list = array();
		$sql = "SELECT contents.* FROM contents";
		
		if (has_sitespaces()) {
			$sql .= " LEFT JOIN contents_sitespaces ON contents_sitespaces.content_id = contents.id
							LEFT JOIN sitespaces ON contents_sitespaces.sitespace_id = sitespaces.id";
		}
		$sql .= " LEFT JOIN types ON types.id = contents.type_id 
			WHERE 1=1 AND types.show_in_search = 1 ";
		foreach ($keywords as $keyword) {
			$sql .= " AND (title LIKE '%".mysql_real_escape_string($keyword)."%'";
			$sql .= " OR brief LIKE '%".mysql_real_escape_string($keyword)."%'";
			$sql .= " OR body LIKE '%".mysql_real_escape_string($keyword)."%')";
		}
		if (has_sitespaces()) {
			$sql .= " AND sitespaces.name = '".get_current_site_space()."'";
		}
		
		//echo $sql;
		$result = mysql_query_door($sql);
		//echo mysql_error();
		
		while ($content = mysql_fetch_object($result, "Content")) {
			$content->name = $this->highlight($content->name,$keywords);
			$content->brief = $this->highlight(strip_tags($content->brief),$keywords);
			$this->list[] = $content;
		}
		
		
		$sql = "SELECT * FROM sections WHERE 1=1 ";
		foreach ($keywords as $keyword) {
			$sql .= " AND (name LIKE '%".mysql_real_escape_string($keyword)."%'";
			$sql .= " OR brief LIKE '%".mysql_real_escape_string($keyword)."%'";
			$sql .= " OR description LIKE '%".mysql_real_escape_string($keyword)."%')";
		}
		$result = mysql_query_door($sql);
		while ($section = mysql_fetch_object($result, "Section")) {
			$section->name = $this->highlight($section->name,$keywords);
			$section->brief = $this->highlight(strip_tags($section->brief),$keywords);
			if ($section->getSiteSpace() == get_current_site_space())
			$this->list[] = $section;
		}		
		
		
	}
	function getResults() {
		if (count($this->list)>0)
			return $this->list;
		else
			return false;
	}
	
}