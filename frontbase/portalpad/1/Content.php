<?
	class Content extends MenuItem{
		function Content() {
			$this->name = $this->title;
			/*
				TODO: Quitar estos filtros de aqui por rendimiento al hacer listas largas de contents?
			*/
			$this->brief = filter_field($this->brief);
			$this->body = filter_field($this->body);

		}
    function getFileExtension() {
    		return strtolower(substr(strrchr($this->file_name, '.'), 1));
    }
		function getItemLink() {
			if (strlen($this->type->action) > 0) {
				$parts = explode("/",$this->type->action);
				$url = url_for($parts[0], $parts[1], $this->id);
			}
			else {
				if ($section = $this->getPrimarySection()) {
					if (strlen($section->action_contents)>0) {
						$parts = explode("/",$section->action_contents);
						$url = url_for($parts[0], $parts[1], $this->id);
					}
					else {
						$url = url_for("main", "get", $this->id);
					}
					
				}
				else {
					$url = url_for("main", "get", $this->id);
				}
			}
			return $url;
		}
		function getPublicName() {
			return $this->getT('title');
		}
		function getFile() {
			//TODO: Ver si existe el archivo en el store (store por defecto pero configurable)
			if (strlen($this->file_name)>0) {
				$attached_file = new AttachedFile();
				$attached_file->file_name = $this->file_name;
				return $attached_file;
			}
			else {
				return false;
			}
		}
		function getRelated($type_id = null, $promoted_only = false) {
			$sql = "SELECT DISTINCT contents.id, contents.* FROM cross_references 
				LEFT JOIN contents ON contents.id = cross_references.content_id_refered 
				LEFT JOIN types ON types.id = contents.type_id
				WHERE (status > 0 OR has_status <> 1) AND cross_references.content_id = ".$this->id;
				
			if ($promoted_only)
				$sql .= " AND contents.status = 2";
			//echo $sql;
			$result = mysql_query_door($sql);
			$list = array();
			while ($content = mysql_fetch_object($result, "Content")) {
				if ($content->type_id == $type_id || (is_null($type_id) || $type_id == 0)) {
					$list[] = $content;
				}
			}
			return $list;
		}
		function getComments() {
			$sql = "SELECT comments.* FROM comments 
				WHERE comments.content_id = ".$this->id."
				ORDER BY created DESC
				";
			$result = mysql_query_door($sql);
			$list = array();
			while ($Comment = mysql_fetch_object($result, "Comment")) {
					$list[] = $Comment;
			}
			return $list;
		}
		function hasRelated($type_id = null) {
			if (count($this->getRelated($type_id))>0)
				return true;
			else
				return false;
		}
		function getImage($force = true) {
			if ($this->id > 0) {
				if (strlen($this->file_name)>0) {
					#la imagen está ingresada como attacment (is_file)
					$img = new PImage();
					$img->file_name = $this->file_name;
					return $img; 
				} 
				elseif ($force) {
					#no hay imagen como attachment, asi que toma la primera de la galeria
					$sql = "SELECT * FROM images WHERE images.content_id = ".$this->id. " ORDER BY weight ";
					$result = mysql_query_door($sql);
					$list = array();
					if ($img = mysql_fetch_object($result, "PImage")) {
						return $img;
					}
					else {
						return false;	
					}
				}
				return false;	
			} 
			else
				return false;	
			
		}
		function getParentContent() {
			$sql = "SELECT contents.* FROM cross_references 
				LEFT JOIN contents ON cross_references.content_id = contents.id
				WHERE cross_references.content_id_refered = ".$this->id." AND contents.type_id = ".$this->type->parent_type_id;
			$result = mysql_query_door($sql);
			if ($content = mysql_fetch_object($result, "Content")) {
				return $content;
			}
			else {
				return false;
			}

		}
		function getChildren() {
			$sql = "SELECT contents.* FROM cross_references 
				LEFT JOIN contents ON cross_references.content_id_refered = contents.id
				LEFT JOIN types ON contents.type_id = types.id
				WHERE (status > 0 OR types.has_status = 0)
				AND cross_references.content_id = ".$this->id." 
				AND types.parent_type_id = ".$this->type_id." 
				ORDER BY contents.weight";
			//echo $sql;
			$result = mysql_query_door($sql);
			$list = array();
			while ($content = mysql_fetch_object($result, "Content")) {
				$list[] = $content;
			}
			return $list;
		}
		function getImages($args = array()) {
			$sql = "SELECT * FROM images WHERE images.content_id = ".$this->id." ORDER BY weight";
			if (isset($args["limit"])) {
				if (!isset($args["offset"])) {
					$sql .= " LIMIT 0,".$args["limit"];
				}
				else {
					$sql .= " LIMIT ".$args["offset"].",".$args["limit"];
				}
			}
			//echo $sql;
			$result = mysql_query_door($sql);
			$list = array();
			while ($img = mysql_fetch_object($result, "PImage")) {
				$list[] = $img;
			}
			if (count($list) > 0)
				return $list;
			else
				return false;
		}
		function getFiles($args = array()) {
			$sql = "SELECT * FROM files WHERE files.content_id = ".$this->id."";
			
			if (isset($args["format"])) {
				if (!is_array($args["format"])) {
					$formats = explode(",", $args["format"]);
				}
				else {
					$formats = $args["format"];	
				}
				
				if (count($formats)>1) {
					$sql .= " AND (";
					
					foreach ($formats as $key => $format) {
						$sql .= "files.extension = '".trim($format)."'";
						if (isset($formats[$key + 1])) {
							$sql .= " OR ";
						}
					} 
					$sql = rtrim($sql,",").")";
				}
				else {
					$sql .= " AND files.extension = '".$args["format"]."'";
				}
			}
			
			$sql .= " ORDER BY weight";
			if (isset($args["limit"]))
				$sql .= " LIMIT 0,".$args["limit"];

			$result = mysql_query_door($sql);
			$list = array();
			while ($file = mysql_fetch_object($result, "AttachedFile")) {
				$list[] = $file;
			}
			if (count($list) > 0)
				return $list;
			else
				return false;
		}
		function getRelatedByTaxonomy($taxonomytype_id, $type_id = null) {
			$related_contents_by_taxonomy = array();
			foreach ($this->getRelated($type_id) as $content_related) { 
			$categoria = $content_related->getTaxonomyValue($taxonomytype_id);
			if (!isset($related_contents_by_taxonomy[$categoria]))
				$related_contents_by_taxonomy[$categoria] = array();
			$related_contents_by_taxonomy[$categoria][] = $content_related;
			}
			return $related_contents_by_taxonomy;
		}

		function getFileLink() {
			if (strlen($this->file_name)>0)
				return "/portalpad/uploads/".$this->file_name;
			else
				return null;
		}
		function getFileSize($readable = false) {
			$fl = $this->getFileLink();
			if (isset($fl)) {
				if (file_exists($_SERVER["DOCUMENT_ROOT"].$fl)) {
					$filesize = filesize($_SERVER["DOCUMENT_ROOT"].$fl);
					if ($readable)
						return round($filesize/1024)."kb";
					else
						return $filesize;
				} else {
					return "";
				}
			}
			else {
				return "";
			}
		}
		function getPrimarySection() {
			if ($this->id > 0) {
				$sql = "SELECT * FROM contents_sections WHERE content_id = ".$this->id;
				$result = mysql_query_door($sql);
				if ($row = mysql_fetch_object($result)) {
					$section_id = $row->section_id;
					return SectionTool::fetch($section_id);
				}
			}
			else
				return false;

		}
		function getSections() {
			//TODO: give a full list of section not only the first one!
			return array($this->getPrimarySection());
		}
		function isTranslated($lang = "en") {
			
			if (strlen($this->getT("body",$lang, false))>0)
				return true;
			else
				return false;
		}
		function getAttribute($keyword, $force_lang = null) {
			$sql = "SELECT * FROM contents_attributes WHERE keyword = '".mysql_real_escape_string($keyword)."'";
			$result = mysql_query_door($sql);
			
			if ($row = mysql_fetch_object($result)) {
				$table = "contents_".$row->type;
				$type = $row->type;
				$attribute_id = $row->id;
				$multilang = $row->multilang;

				$result = mysql_query_door("SELECT * FROM $table WHERE content_id = ".$this->id." AND attribute_id = ".$attribute_id);
				if ($row = mysql_fetch_object($result)) {
					if ($type  == "datetime")
						return strtotime($row->value);
					elseif (($type  == "string" || $type  == "text") && $multilang) {
						/*
							Devolver valor con la traduccion si corresponde
						*/
						if (!isset($force_lang))
							$output_lang = get_current_lang();
						else
							$output_lang = $force_lang;
						
						$value_atibute_name = "value_".$output_lang;
							
						$attribute_value = $row->$value_atibute_name;

						if ($type  == "text")
							$attribute_value = filter_field($attribute_value);

						return $attribute_value;
							
					}
					else
						return $row->value;
				}
			}
			else
				return false;
		}
		function getTaxonomyValue($taxonomytype_id, $force_lang = null) {
			if (isset($this->id)) {
				$sql = "SELECT taxonomy_terms.* FROM contents_taxonomy
				LEFT JOIN taxonomy_terms ON contents_taxonomy.taxonomyterm_id = taxonomy_terms.id
				WHERE content_id = ".$this->id." AND contents_taxonomy.taxonomytype_id = ".$taxonomytype_id;
				$result = mysql_query_door($sql);
				if ($row = mysql_fetch_assoc($result)) {
					
					if (!is_null($force_lang)) {
						$attribute_name = "value_".$force_lang;
					}
					elseif (get_current_lang() != get_default_lang()) {
						$attribute_name = "value_".get_current_lang();
					}	
					else {
						$attribute_name = "value";
					}				
					if (strlen($row[$attribute_name])>0)
						return $row[$attribute_name];
					else
						return $row["value"];
				}
			}
		}
		function getTaxonomyTerms($taxonomytype_id) {
			$sql = "SELECT taxonomy_terms.value FROM contents_taxonomy 
			LEFT JOIN taxonomy_terms ON contents_taxonomy.taxonomyterm_id = taxonomy_terms.id
			WHERE content_id = ".$this->id." AND contents_taxonomy.taxonomytype_id = ".$taxonomytype_id;
			$result = mysql_query_door($sql);
			$list = array();
			while ($row = mysql_fetch_assoc($result)) {
				$list[] = $row;
			}
			
			if (count($list) > 0)
				return $list;
			else
				return false;
		}
		function isChildrenOf($content_parent) {
			if (isset($content_parent)) {
				$this_parent_content = $this->getParentContent();
				if ($this_parent_content->id == $content_parent->id) {
					return true;
				}
			}
			return false;
		}
		function existsAttribute($keyword) {
			return $this->type->existsAttribute($keyword);
		}
		function __get($keyword) 
		{
			if ($keyword == "type") {
				$this->type = TypeTool::fetch($this->type_id);
				return $this->type;
			}
			elseif ($keyword == "image"){
				if (in_array($this->getFileExtension(),array("png","gif","jpg"))) {
					$this->image = $this->getImage();
					return $this->image;
				}	
			}
			elseif ($keyword == "file") {
				$this->file = $this->getFile();
				return $this->file;
			}
			elseif ($this->existsAttribute($keyword)) {
				$attribute_value = $this->getAttribute($keyword);
				if (!(strlen($attribute_value) > 0)) {
					$attribute_value = $this->getAttribute($keyword, get_current_lang());
				}
				// Definir el atributo para que no vuelva a executar __get()
				$this->$keyword = $attribute_value;
				return $attribute_value;
			}
			elseif ($TaxonomyType = TaxonomyTypeTool::fetch_by_keyword($keyword)) {
				if ($TaxonomyType->multiple) {
					$attribute_value = $this->getTaxonomyTerms($TaxonomyType->id);
				}
				else {
					$attribute_value = $this->getTaxonomyValue($TaxonomyType->id);
				}
				// Definir el atributo para que no vuelva a executar __get() VALIDAR SI FUNCIONA!
				$this->$keyword = $attribute_value;
				return $attribute_value;

			}
			else {
				return false;
			}

			
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
				
				$sql = "SELECT text FROM contents_lang WHERE content_id = ".$this->id." AND field = '".$keyword."' AND language = '".$lang."'";
				
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
		function __toString() {
			$str .= "<table>";
			$str .= "<tr>";
			$str .= "<td>Title</td>";
			$str .= "<td>".$this->title."</td>";
			$str .= "</tr>";
			$str .= "<tr>";
			$str .= "<td>Brief</td>";
			$str .= "<td>".$this->brief."</td>";
			$str .= "</tr>";
			$str .= "<tr>";
			$str .= "<td>Body</td>";
			$str .= "<td>".$this->body."</td>";
			$str .= "</tr>";
			
			$attributes = AttributeTool::find_by_type_id($this->type_id);
			foreach ($attributes as $attribute){
					$str .= "<tr>";
					$str .= "<td>".$attribute->name."</td>";
					$str .= "<td>".$this->getAttribute($attribute->keyword)."</td>";
					$str .= "</tr>";
			}
			$str .= "</table>";
			return $str;
		}
	}