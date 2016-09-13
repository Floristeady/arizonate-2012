<?

	class ContentTool {
		function ContentTool() {
			$this->conditions = array();
			$this->order_by = array();
			$this->section_id = null;
			$this->exclude_archived = true;
			$this->promoted = false;
			$this->usort_desc = false;
			$this->class = "Content";
		}

		function fetch($content_id) {
			/*
				Todo: Hacer function que añada el filtro de sitespace en instrucciones SQL automaticamente para:
				- fetch
				- fetch_list
				- fetch_sql
			*/
			$sql = "SELECT contents.* FROM contents LEFT JOIN types ON contents.type_id = types.id ";
			if (has_sitespaces()) {
				$sql .= " LEFT JOIN contents_sitespaces ON contents_sitespaces.content_id = contents.id";
				$sql .= " LEFT JOIN sitespaces ON sitespaces.id = contents_sitespaces.sitespace_id";
			}
			$sql .= "	WHERE (status > 0 OR has_status = 0) AND contents.id = ".mysql_real_escape_string($content_id)."";
			if (has_sitespaces()) {
				$sql .= " AND sitespaces.name = '".get_current_site_space()."'";
			}
			
			$result = mysql_query_door($sql);

				
			if ($content = mysql_fetch_object($result, "Content")) {
				mysql_free_result($result);
				if ($content->id > 0)
					return $content;
				else
					return false;
			}
			else {
				return false;
			}
		}
	
		function addCondition($condition) {
			$this->conditions[] = $condition;
		}
		function addFilter($condition) {
			$this->conditions[] = $condition;
		}
		
		function fetch_sql($sql) {
			$result = mysql_query_door($sql);
			//echo $sql;
			$list = array();
			while ($row = mysql_fetch_object($result, $this->class)) {
				if ($row->id > 0)
					$list[] = $row;
			}
			mysql_free_result($result);
			if (isset($this->usort_compare_attribute))
				usort($list , array($this, "usort_callback"));
			return $list;
		}
		
		function fetch_list($offset = 0, $limit = null) {
			$sql = "SELECT DISTINCT contents.id, contents.* FROM contents";
			$sql .= " LEFT JOIN types ON contents.type_id = types.id";

			$sql_where = " WHERE 1=1 ";
			
			if (has_sitespaces()) {
				$sql .= " LEFT JOIN contents_sitespaces ON contents_sitespaces.content_id = contents.id";
				$sql .= " LEFT JOIN sitespaces ON sitespaces.id = contents_sitespaces.sitespace_id";
			}
			
			$joins = array();
			foreach ($this->conditions as $condition) {
				$value = $condition["value"];
				$condition_sql = $condition["condition_sql"];

				$identifier = $condition["identifier"];
				
				$type = $condition["type"];
				if ($type) {
					if ($type == "attribute") {
						$keyword = $condition["keyword"];
						if (isset($keyword)) {
							$attribute = AttributeTool::find_by_keyword($keyword);
							$attribute_id = $attribute->id;
							$attribute_type = $attribute->type;
						}
						if (isset($identifier)) {
							$attribute = AttributeTool::find($id);
							$attribute_id = $attribute->id;
							$attribute_type = 	$attribute->type;
						}
						$join_name = "attribute_".$attribute_id;
						// TODO: soporte para booleans ahora se debe hacer con condition_sql = IS NULL
						if (!(in_array($join_name, $joins))) {
							$sql .= " LEFT JOIN contents_$attribute_type AS $join_name ON $join_name.content_id = contents.id AND $join_name.attribute_id = ".$attribute_id;
							$joins[] = "attribute_".$attribute_id;
						}
						if (is_numeric($value)) {
							$sql_where .= " AND $join_name.value = ".$value;
						}
						if (strlen($condition_sql) > 0){
							$sql_where .= " AND $join_name.value ".$condition_sql;
						}
					}
					if ($type == "taxonomy") {
						$join_name = "taxonomy_terms_".$identifier;
						$sql .= " LEFT JOIN contents_taxonomy AS $join_name ON $join_name.content_id = contents.id ";
						if ($value > 0) {
							$sql_where .= " AND $join_name.taxonomyterm_id = ".$value;
						}
						if (strlen($condition_sql) > 0){
							$sql_where .= " AND $join_name.taxonomyterm_id ".$condition_sql;
						}
					}
					if ($type == "country") {
						$join_name = "contents_countries";
						$sql .= " LEFT JOIN contents_countries ON contents_countries.content_id = contents.id ";
						if ($value > 0) {
							$sql_where .= " AND contents_countries.country_id = ".$value;
						}
						if (strlen($condition_sql) > 0){
							$sql_where .= " AND contents_countries.country_id ".$condition_sql;
						}
					}
					if ($type == "section") {
						if ($value > 0) {
							$sql .= " LEFT JOIN contents_sections  ON contents_sections.content_id = contents.id";
							$sql_where .= " AND contents_sections.section_id = ".$value;
						}
					}
					if ($type == "type") {
						if ($value > 0) {
							$sql_where .= " AND contents.type_id = ".$value;
						}
						if (strlen($condition_sql) > 0){
							$sql_where .= " AND contents.type_id ".$condition_sql;
						}
					}
					if ($type == "status") {
						if ($value > 0) {
							$sql_where .= " AND contents.status = ".$value;
						}
						if (strlen($condition_sql) > 0){
							$sql_where .= " AND contents.status ".$condition_sql;
						}
					}
					if ($type == "keyword") {
						$sql_where .= " AND (title LIKE '%".$value."%' OR brief LIKE '%".$value."%' OR body LIKE '%".$value."%')";
					}
				}
			}
			if ($this->exclude_archived) {
				$sql_where .= " AND (contents.status > 0 OR types.has_status = 0)";
			}
			if ($this->promoted) {
				$sql_where .= " AND contents.status >= 2";
			}
			$sql_order = "";
			
			if (has_sitespaces()) {
				$sql_where .= " AND sitespaces.name = '".get_current_site_space()."'";
			}
			
			foreach ($this->order_by as $order) {
				$type = $order[2];
				if ($order[0] == "attribute") {
					$join_name = "attribute_".$order[1]."_order";
					$sql .= " LEFT JOIN contents_$type AS $join_name ON $join_name.content_id = contents.id";
					if (strlen($sql_order)>0)
						$sql_order.= ",";
					$sql_order .= $join_name.".value";
				}
			}
			


			$sql .= $sql_where;
			if (strlen($sql_order)>0)
				$sql .= " ORDER BY ".$sql_order." ,contents.weight, contents.title";
			else
				$sql .= " ORDER BY contents.weight, contents.title";
				
			//echo "<br>".$sql;
			$this->sql = $sql;
			$result = mysql_query_door($sql);
			echo mysql_error();
			$list = array();
			if (isset($this->content_class))
				$content_class = $this->content_class;
			else
				$content_class = "Content";
				
			while ($row = mysql_fetch_object($result, $content_class)) {
						$list[] = $row;
			}
			mysql_free_result($result);
			$i = 0;
			$j = 0;
			$list_limited = array();
			if (isset($this->usort_compare_attribute))
				usort($list , array($this, "usort_callback"));
			
			foreach ($list as $item) {
				if (($i >= $offset|| !isset($offset)) && ($j < $limit || !isset($limit))) {
					$list_limited[] = $item;
					$j++;
				}
				$i++;
			}
			
			if (count($list_limited)>0) { 
				$list_limited[0]->is_first = true;
				$list_limited[count($list_limited)-1]->is_last = true;
			}

			return $list_limited;

		}
		function fetch_one() {
			$list = $this->fetch_list();
			if (count($list)>0)
				return $list[0];
			else
				return false;
		}
		
		function fetch_grouped_list($group_by, $callback = null) {
			$list = array();
			foreach ($this->fetch_list() as $content) {
				
				if (is_null($callback ))
					$value = $content->$group_by;
				else
					$value = call_user_func($callback, $content->$group_by);
				
				if (!isset($list[$value]))
					$list[$value] = array();
				$list[$value][] = $content;
			}
			
			ksort($list);
			return $list;
		}
		function fetch_grouped_list_by_taxonomy($taxonomytype_id) {
			$list = array();
			foreach ($this->fetch_list() as $content) {
				if (!isset($list[$content->getTaxonomyValue($taxonomytype_id)]))
					$list[$content->getTaxonomyValue($taxonomytype_id)] = array();
				$list[$content->getTaxonomyValue($taxonomytype_id)][] = $content;
			}
			
			return $list;
		}

		function setSimpleOrder($attribute_name, $desc = false) {
			/*
			TODO: Funcion altamente ineficiente
			GOTCHA: Funcion altamente ineficiente
			*/
			$this->usort_compare_attribute = $attribute_name;
			$this->usort_desc = $desc;
		}
		
		function setContentClass($content_class) {
			$this->content_class = $content_class;
		}
		private function usort_callback ($a, $b){
				$attribute_name = $this->usort_compare_attribute;
        $al = strtolower($a->$attribute_name);
        $bl = strtolower($b->$attribute_name);
        if ($al == $bl) {
            return 0;
        }
        if (!$this->usort_desc)
        	return ($al > $bl) ? +1 : -1;
        else
        	return ($al < $bl) ? +1 : -1;
		}

	}