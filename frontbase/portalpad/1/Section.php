<?

	class Section extends MenuItem {
		function Section() {
			if ($this->parent_id == 0)	{
				$this->depth = 1;	
			}
			else {
				$this->parent = $this->getParent();
				$this->depth = $this->parent->depth + 1;
			}
			$this->body = filter_field($this->body);
			$this->brief = filter_field($this->brief);
			
			$this->image = $this->getImage();
		}
		function getImage() {
			if ($this->id > 0) {
				if (strlen($this->file_name)>0) {
					$img = new PImage();
					$img->file_name = $this->file_name;
					return $img;
				} else {
						return false;	
				}
			} 
			else
				return false;	
		}
		
		function getChildren($only_nodes = false) {
			if (!isset($this->children)) {
				$sql = "SELECT * FROM sections WHERE parent_id = ".$this->id;
				
				if ($only_nodes)
					$sql .= " AND is_node = 1 ";
				
				$result = mysql_query_door($sql);
				
				
				$list = array();
				while ($section = mysql_fetch_object($result, "Section")) {
					$list[] = $section;
				}
				$this->children = $list;
			}
			return $this->children;
		}

		function hasChildren() {
			if (count($this->getChildren())>0)
				return true;
			else
				return false;
		}

		function getParent() {
			if (!isset($this->parent)) { 
				$result = mysql_query_door("SELECT * FROM sections WHERE id = ".$this->parent_id);
				if ($parent = mysql_fetch_object($result, "Section")) {
					$this->parent = $parent;
					return $parent;
				}
				else {
					return false;	
				}
			}
			else {
				return $this->parent;
			}
		}
		function getActionChildren() {
			if (strlen($this->action_children) > 0) {
				return $this->action_children;
			}
			elseif ($parent = $this->getParent()) 	{
				if ($action= $parent->getActionChildren())
					return $action;
				else
					return false;	
			}
			else {
				return false;	
			}
		}
		function parentByDepth($depth) {
			if ($this->depth > $depth) {
				if ($this->parent->depth == $depth) {
					return $this->parent;
				}
				else {
					return $this->parent->parentByDepth($depth);
				}
			}
			elseif ($this->depth < $depth) {
				return false;
			}
			else
				return $this;
		}
		function getItemLink() {
			//echo "getItemLink()";
			if ($this->is_node == 1) {
				if (strlen($this->menu_action_call)>0) {
					/*DEPRECATED in favour of 'action'*/
					$parts = explode("/",$this->menu_action_call);
					return url_for($parts[0], $parts[1], $this->id);
				}
				elseif (strlen($this->action)>0) {
					$parts = explode("/",$this->action);
					return url_for($parts[0], $parts[1], $this->id);
				}
				elseif (strlen($this->getActionChildren())>0) {
					$parts = explode("/",$this->getActionChildren());
					return url_for($parts[0], $parts[1], $this->id);
				}
				else {
					return url_for("main", "home_section", $this->id);
				}
			}
			else {
				if ($first_child = $this->getFirstChild()) {
					return $first_child->getItemLink();
				}
			}
		}
		function isChildrenOf($section) {
			if (isset($section)) {
				for ($depth = $this->depth + 1;  $depth > 0 ;$depth = $depth - 1) {
					$parent = $this->parentByDepth($depth);
					if ($parent->id == $section->id) {
						return true;
					}
				}
			}
			return false;
		}
		function getFirstContent() {
			$sql = "SELECT DISTINCT contents.id, contents.* FROM contents 
				LEFT JOIN contents_sections ON contents_sections.content_id = contents.id
				LEFT JOIN types ON contents.type_id = types.id
				WHERE section_id = ".$this->id."
				AND (contents.status > 0 OR types.has_status = 0)
				ORDER BY contents.weight, contents.title";
			$result = mysql_query_door($sql);
			if ($content = mysql_fetch_object($result, "Content")) {
				return $content;
			}
			return false;
		}
		function getContentsList($type_id = null) {
			return $this->getContents($type_id);
		}
		function getContents($type_id = null, $as = "Content") {
			if (!isset($this->contents) || !is_null($type_id)) {
				
				$ct = new ContentTool();
				$ct->setContentClass($as);
				$ct->addCondition(array("type" => "section", "value" => $this->id));
				if (isset($type_id)) {
					
					$ct->addCondition(array("type" => "type", "value" => $type_id));
				}
				if(is_null($type_id)) {
					$this->contents = $ct->fetch_list();
				}
				else {
					return $ct->fetch_list();
				}
				//echo $ct->sql;
			}
			return $this->contents;
		}
		function hasContents() {
			if (count($this->getContentsList())>0)
				return true;
			else
				return false;
		}
		function getFirstChild() {
			$children = $this->getChildren();
			if (count($children) > 0)
				return $children[0];
			else
				return false;
		}
		function getSiteSpace() {
			/*
			TODO: calcular a que sitespace pertenece a través de los parents
			
			*/
			return "default";	
		}
		
		function getPublicName(){
			if (strlen($this->getT("public_name")) > 0)
				return $this->getT("public_name");
			else 
				return $this->name;
		}
		function getUsedTaxonomyTypes() {
			/*
			MOVER A ExTENSION
			*/
			
			$sql = "SELECT DISTINCT taxonomy_types.* FROM taxonomy_types
				LEFT JOIN contents_taxonomy ON taxonomy_types.id = contents_taxonomy.taxonomytype_id
				LEFT JOIN contents ON contents.id = contents_taxonomy.content_id
				LEFT JOIN contents_sections ON contents.id = contents_sections.content_id
				WHERE (contents_sections.section_id IN (".implode(",",$this->getAllChildrenForSQL()).") OR contents_sections.section_id = ".$this->id.")";
			$list = array();
			$result = mysql_query_door($sql);
			echo mysql_error();
			while($taxonomy_type = mysql_fetch_object($result, "TaxonomyType")) {
				$list[] = $taxonomy_type;
			}
			return $list;
		}
		function getUsedTaxonomyTerms($type_id = null) {
			/*
			MOVER A ExTENSION
			*/
			$sql = "SELECT DISTINCT taxonomy_terms.* FROM contents
				LEFT JOIN contents_sections ON contents.id = contents_sections.content_id
				LEFT JOIN contents_taxonomy ON contents.id = contents_taxonomy.content_id
				LEFT JOIN taxonomy_terms ON taxonomy_terms.id = contents_taxonomy.taxonomyterm_id
				WHERE (contents_sections.section_id IN (".implode(",",$this->getAllChildrenForSQL()).") OR contents_sections.section_id = ".$this->id.")";
				
			if (!is_null($type_id)) {
				$sql .= " AND taxonomy_terms.taxonomytype_id = ".$type_id;
			}
			$list = array();
			$result = mysql_query_door($sql);
			while($taxonomy_term = mysql_fetch_object($result, "TaxonomyTerm")) {
				$list[] = $taxonomy_term;
			}
			return $list;
		}
		function getAllChildrenForSQL() {
			$children_list = array();
			$children_list[] = $this->id;
			$result = mysql_query_door("SELECT * FROM sections WHERE parent_id = ".$this->id);
			while ($section = mysql_fetch_object($result, "Section")) {
				$children_list[] = $section->id;
				$children_list = array_merge($children_list, $section->getAllChildrenForSQL());

			}
			return $children_list;
		}
		function existsAttribute($keyword) {
			$this->_section_attributes = array();
				$sql = "SELECT * FROM sections_attributes
					WHERE keyword = '".mysql_real_escape_string($keyword)."'";			
				//echo $sql;
				$result = mysql_query_door($sql);
				echo mysql_error();
				if (mysql_num_rows($result)>0) {
					return true;
				}
				else {
					return false;
				}

		}
		function getInheritedText($keyword) {
			if (not_empty($this->$keyword)) {
				return $this->$keyword;
			} 
			elseif ($parent = $this->getParent()) {
				return $parent->getInheritedText($keyword);
			}
			else {
				return $this->$keyword;
			}
			
		}
		function getAttribute($keyword, $force_lang = null) {
			$sql = "SELECT * FROM sections_attributes WHERE keyword = '".mysql_real_escape_string($keyword)."'";
			$result = mysql_query_door($sql);
			
			if ($row = mysql_fetch_object($result)) {
				$table = "sections_values_".$row->type;
				$type = $row->type;
		
				$sql = "SELECT * FROM $table WHERE section_id = ".$this->id." AND attribute_id = ".$row->id;
				$result = mysql_query_door($sql);
				//echo $sql;
				if ($row = mysql_fetch_object($result)) {
					if ($type  == "datetime") {
						return strtotime($row->value);
					}
					elseif ($type  == "string" || $type  == "text") {
						$attribute_value = $row->value;
						if ($type  == "text") {
							$attribute_value = filter_field($attribute_value);
						}
						return $attribute_value;
					}
					else {
						return $row->value;
					}
				}
			}
			else
				return false;
		}
		public function getT($keyword, $force_lang = null) {
			if (!is_translated()) {
				return parent::getT($keyword);
			}
			/*
				Implementacion temporal, debe usarse la anterior en Translatable::getT()
			*/
			/* 
				TODO: 
				Implementar caching
			*/
				if (is_null($force_lang)) {
					$lang = get_current_lang();
				}
				else {
					$lang = $force_lang;	
				}
				
				$sql = "SELECT text FROM sections_lang WHERE section_id = ".$this->id." AND field = '".$keyword."' AND language = '".$lang."'";
				//echo $sql;
				//exit($sql);
				$res = mysql_query_door($sql);
				if ($row = mysql_fetch_array($res)) {
					if (not_empty($row["text"])) {
						return $row["text"];
					}
					elseif (is_null($force_lang)) {
						return $this->getT($keyword, get_default_lang());
					}
				}
				elseif (is_null($force_lang))  {
					return $this->getT($keyword, get_default_lang());
				}
		}
		function __get($keyword) 
		{
			if (substr($keyword, 0, 1) != "_") { 
				if ($this->existsAttribute($keyword)) {
					$this->$keyword = $this->getAttribute($keyword);
					return $this->$keyword;
				}
				else {
					return false;
				}
			}	
		}
	}