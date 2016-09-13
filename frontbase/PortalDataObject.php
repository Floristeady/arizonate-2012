<?
/*
	IMPORTANTE:
	- _table_data: Son la columnas de los datos desde la BDD, se actualiza con __set
	- _data: Son SOLO las columnas con datos modificados para el UPDATE y INSERT
	
	TODO:
	- _updated debe ser eliminado, y is_changed debe funcionar basándose en la comparacion entre _data y _table_data
	- renombrar _data a _update_data
	BUGS: 
	- find(null) devuelve el primer elemento

	NOTA IMPORTANTE PARA LA IMPLEMENTACION DE LANGUAGES U OTROS:
	
	$model->body["en"] deberia pasar a través de __get y __set, como el resto de las propiedades!
	
	Esto se puede implekemtar con ArrayObject
	
	class smarty {
	  public $p;
	  function __construct() {
	    $this->p = new ArrayObject;
	  }
	  function __get($p) {
	  	echo "hole";
	    return $this->p;
	  }
	  function __set($p,$v) {
	  	echo "hole";
	    return $this->p[$p] = $v;
	  }
	}
	$o = new smarty;
	$o->prop["key"] = 1;
	
	echo $o->prop["key"];

	PARA MIGRAR LOS TEXTOS DESDE IDIOMA A NO IDIOMA:
	- INSERT INTO contents_lang (content_id, FIELD,TEXT, LANGUAGE) SELECT id, 'title',title, 'es' FROM contents

	BUGS:
	- find(8888888) will return the first row
	FIXED with is_bool() - on tinyint $process->deposition_only = is_required() no guarda 1 si is_required=>true
	
*/

function implode_keys($array, $glue = ",") {
	if (is_array($array)) 
		return implode($glue, array_keys($array));
}


class PortalDataObject extends Translatable{

	/*
		Metodo solo compatible con php 5.3
	*/
	function __construct() {
 		$this->_validation_errors = array();
	
	}
	static function find_all() {
		$tool_name = get_called_class()."Tool";
		$tool = new $tool_name();
		return $tool->find_all();
	}
	public function getZid($zerofill = 4){
		return str_pad($this->id, $zerofill, "0", STR_PAD_LEFT);
	}
	public function getData() {
		return $this->_table_data;	
	}
	public function is_new() {
		if (isset($this->id) && $this->id > 0) {
			return false;	
		}
		return true;
	}	
	public function update_attributes($list) {
		Logger::info("update_attributes() for ".get_class($this),$list);
		if (is_array($list)) {
			$this->schema_info();
			
			foreach ($list as $key => $value) {
				// Transformar fechas si no estan en formato timestamp
				if (!is_numeric($value)) {
					if (count($dynamic_properties = $this->getDinamicProperties())>0)  {
						if($dynamic_properties[$key]["type"] == "datetime") {
							$this->$key = strtotime($value);
						}
						else {
							$this->$key = $value;
						}
					}
					else {
						$this->$key = $value;
					}
				}
				else {
					$this->$key = $value;
				}
			}
		}
		else {
			Logger::warn("Argument not an array in <update_attributes()>");	
		}
		// FIXED BUG: Antes "!is_array($child
		if (is_array($child = $this->getChildModels())) {
			foreach ($child as $key => $def) {
				Logger::info("update_attributes() will check for related child models fields ");
				//TODO: Soporte para booleans checkbox
				if (isset($list[$key])) { 
					$this->update_related_attributes($list,$key);
				}
			}
		}
		else {
			Logger::warn("update_attributes() no child model's fields to be updated in ".get_class($this));
		}
	}
	public function update_related_attributes($list, $plural) {
		if (!is_array($this->_data_related)) {
			$this->_data_related = array();
		}
		$this->getChildModels();
		if ($this->isManyToMany($plural)) {
			$this->_data_related[$plural] = array();
			if (is_array($list[$plural])) {
				$tool_name = ucwords($this->_child_models_by_plural[$plural]["model"])."Tool";
				$tool = new $tool_name();
				foreach ($list[$plural] as $v) {
					$c = $tool->find($v);
					array_push($this->_data_related[$plural], $c);
				}
				$this->$plural = $this->_data_related[$plural];
			}
		}
		else {
			$this->_data_related[$plural] = array();
			if (is_array($list[$plural])) {
				$tool_name = ucwords($this->_child_models_by_plural[$plural]["model"])."Tool";
				$tool = new $tool_name();
				foreach ($list[$plural] as $id => $value_set) {
					$c = $tool->find($id);
					foreach ($value_set as $key => $value) {
						$c->$key = $value;
					}
					$this->_data_related[$plural][$id] = $c;
				}
				$this->$plural = $this->_data_related[$plural];
			}
	
		} 
	}
	public function update_check_attribute($value, $attribute_name) {
 		if ($value[$attribute_name] == "1" || $value[$attribute_name] == "true") {
			$this->$attribute_name = 1;
 		}
 		else {
 			$this->$attribute_name = 0;
 		}
	}	
	public function validate_helpers() {
		$this->_validation_errors = array();	

		$types = array("validate_required", "validate_email", "validate_number", "validate_unique");
		foreach ($types as $type) {
			if (is_array($this->$type)) {
				foreach($this->$type as $key => $value){
					$message = null;
					if (is_array($value)) {
						$required_property = $key;
						$message = $value["message"];
					}
					else {
						$required_property = $value;
					}

					$validates = true;
					if (is_array($this->_data)) {
						if (array_key_exists($required_property, $this->_data)) {
							if ($type == "validate_required") {
	
								if(!(strlen($this->_data[$required_property]) > 0)) {
									if (empty($message)) {
										$message = $required_property." is required";
									}
									$validates = false;
								}
							}
							elseif ($type == "validate_email") {
	
								if (!ValidationTool::is_email($this->_data[$required_property])){
									if (empty($message)) {
										$message = $required_property." has to be an email";
									}
									$validates = false;
								} 
							}
							elseif ($type == "validate_number")  {
								if (!ValidationTool::is_number($this->_data[$required_property])){
									if (empty($message)) {
										$message = $required_property." has to be a number";
									}
									$validates = false;
								} 
							}
							elseif ($type == "validate_unique") {
								Logger::warn("validate_unique");
								$tool_name = get_class($this)."Tool";
								$tool = new $tool_name();
								if ($tool->find($required_property." = '".$this->_data[$required_property]."' AND id <> ".$this->id)) {
									Logger::warn("found 1");
									if (empty($message)) {
										$message = $required_property." is already taken";
									}
									$validates = false;
								}
							}
						}
						if(!$validates) {
							$this->_validation_errors[$required_property] = $message;
						}
					}
				}
			}
		}

		if (count($this->_validation_errors)>0) {
			Logger::warn("Validation failed for <".get_class($this).">", $this->_validation_errors);
			return false;	
		}
		return true;	
	}
	private function isManyToMany($plural) {
		return !($this->_child_models_by_plural[$plural]["relational_table"] == $this->_child_models_by_plural[$plural]["table"]); 
	}

	public function is_deleted() {
		return ($this->is_deleted == 1);
	}

	private function implode_values_for_insert($array) {
		$this->schema_info();
		if (count($array) > 0 ) { 
			foreach ($array as $key => $value) {
				Logger::debug("$this->_schema_info[$key]=".$this->_schema_info[$key]);
				if ($this->_schema_info[$key] == "datetime") {
					
					$array[$key] = mysql_real_escape_string(date("Y-m-d H:i:s",$value));
				}
				elseif ($this->_schema_info[$key] == "date") {
					
					$array[$key] = mysql_real_escape_string(date("Y-m-d",$value));
				}
				elseif (substr($this->_schema_info[$key],0,3) == "int" || substr($this->_schema_info[$key],0,7) == "tinyint" ||	$this->_schema_info[$key] == "float") {
					if (is_bool($value)) {
						$value = ($value)?1:0;
					}
					if (!is_numeric($value)) {
						$array[$key] = 0;
					}
					else {
						$array[$key] = $value;
					}
				}
				else {
					$array[$key] = mysql_real_escape_string($value);
					
				}
			}
			return "'".implode("','", $array)."'";
		}
		else {
			//INSERT INTO orders () VALUES ()
			return "";
		}	
	}
	public function validate_attachment($key) {
		/*
			Busca los siguientes campos para el attachment:
			name="modelname_filekey"
			name="filekey"
			
			NOTE: name="modelname[filekey]" will not work
		*/
		if ($file = $this->get_form_file($key)) {
			$fileext = strtolower(substr(strrchr($file["name"], '.'), 1));
			if (!is_array($this->has_attachments[$key]["allowed_types"]) || in_array($fileext,$this->has_attachments[$key]["allowed_types"])) {
				Logger::info("Attachment <$key> validated");
				return true;
			}
			else {
				Logger::warn("The file attachment <$key> could not be validated. Name: $file_field_name / ".$_FILES[$file_field_name]["name"]." fileext: ".$fileext);
				return false;	
			}
		}else{
			Logger::warn("The file attachment for <$key> was not found in \$_FILES");

		}
	}
	private function get_form_file($key) {
		$file_field_name = strtolower(get_class($this))."_".$key;
		if (!isset($_FILES[$file_field_name])) {
			$file_field_name = $key;
		}
		if (isset($_FILES[$file_field_name])) {
			return $_FILES[$file_field_name];
		}
		else {
			return false;
		}
	}
	public function save_attachment($key) {
				Logger::info("save_attachment() Wil try to validate ".$key);
				if (isset($this->has_attachments[$key])) {
					$validate = true;
					$attachment_definition = $this->has_attachments[$key];
				}
				else {
					// TODO en dynamic attachments fields: implementar validacion
					$validate = false;
					if (isset($this->dynamic_properties["path"])) {
						$attachment_definition["path"] = $this->dynamic_properties["path"];
					}else {
						$attachment_definition["path"] = "/site/store/";
					}
					$attachment_definition["original_field"] = $key."_original";
				}
				if (!$validate || $this->validate_attachment($key)) {
					Logger::info("Checkin if there are attachments for ".$key);
					
					if ($form_file = $this->get_form_file($key)) {
						Logger::info("save_attachment() Found FILE field for ".$key);
						$fileext = strtolower(substr(strrchr($form_file["name"], '.'), 1));
						$filename = md5(uniqid(rand(),true)).$this->file_ext; 
						$save_to = $_SERVER["DOCUMENT_ROOT"].$attachment_definition["path"].$filename.".".$fileext;
						if ($attachment_definition["path"]) {
							if (move_uploaded_file($form_file['tmp_name'], $save_to)) {
								Logger::info("Attachment for <".$key."> successfully saved on disk");
								/*
									DEPRECATED:
									Usar $this->_data[$key] en vez de $this->$key ya que o si no no se 
									actualiza $this->$key no llama a __set ya que esta predefinido como 
									PortalDataFile
									
									if (array_key_exists($key, $this->getDinamicProperties()) ) { 
									$this->_dynamic_data[$key] = $filename.".".$fileext; } else { 
									$this->_data[$key] = $filename.".".$fileext; } */

								unset($this->$key);
								$this->$key = $filename.".".$fileext;
								if (isset($attachment_definition["original_field"])) {
									unset($this->$attachment_definition["original_field"]);
									$this->$attachment_definition["original_field"] = $form_file['name'];
								}
								if (isset($attachment_definition["extension_field"])) {
									unset($this->$attachment_definition["extension_field"]);
									$this->$attachment_definition["extension_field"] = $fileext;
								}
								return true;
							}
							Logger::warn("Could not save attachment in ".$_SERVER["DOCUMENT_ROOT"].$attachment_definition["path"]." error code: ".$_FILES[$file_field_name]['error']);
							return false;
						}
						else {
							Logger::error($save_to." is not writable");
						}
					}
					Logger::warn("No file has been found in \$_FILES for $file_field_name");
					return false;
				}
				Logger::warn("Attachment could not be validated");
				return false;
	}
	public function run_validation() {
		$this->validate_helpers();
		
		if (method_exists($this, "validate")) {
			Logger::info("Will call this->validate on <".get_class($this).">");
			call_user_method("validate",$this);
		}
		if (count($this->_validation_errors)>0)
			return false;
		else
			return true;
	}
	private function save_translated() {
		//debug($this->_data_translated);
		if (is_array($this->_data_translated)) {
			foreach ($this->_data_translated as $field => $translations) {
				foreach ($translations as $language => $value) {
					$sql = "DELETE FROM ".$this->getTableName()."_lang WHERE ".get_class($this)."_id = '".$this->id."' AND field = '".$field."' AND language = '".$language."'";
					mysql_query_door($sql);
					echo mysql_error();
					$sql = "INSERT INTO ".$this->getTableName()."_lang (".get_class($this)."_id, field, language, text) 
						VALUES
						('".$this->id."','".$field."', '".$language."', '".mysql_real_escape_string($value)."')
					";
					mysql_query_door($sql);
					echo mysql_error();
				}
			}
		}
	}
	private function save_related() {
		if (is_array($this->_data_related)) {
			Logger::info("save_related(): Will save related data");
			foreach ($this->_data_related as $plural => $elements) {
				if ($this->isManyToMany($plural)) {
					$sql = "DELETE
							FROM ".$this->_child_models_by_plural[$plural]["relational_table"]."
							WHERE ".strtolower(get_class($this))."_id = ".$this->id."";
					if (mysql_query_door($sql)) {
						Logger::info("OK query in <save_related()>", $sql);
					}
					else {
						Logger::error("SQL ERROR in <save_related()>", $sql);	
					}
					if (is_array($elements)) {
						foreach ($elements as $element) {
							/*
								EN REVISION
								Este codigo ha causado problemas. 
								Los elements pueden ser instancias de los Modelos relacionados o sus ids?
							*/
							if (is_object($element)) {
								$id = $element->id;
							}
							else {
								$id = $element;
							}
							$sql = "INSERT INTO ".$this->_child_models_by_plural[$plural]["relational_table"]."
								(".strtolower(get_class($this))."_id,".$this->_child_models_by_plural[$plural]["foreign_key"].")
								VALUES
								(".$this->id.",".$id.")
							";
							if (mysql_query_door($sql)) {
								Logger::info("OK query in <save_related()>", $sql);
							}
							else {
								Logger::error("Error on query in <save_related()>", $sql);	
							}
						}
					}
				}
				else {
					if (is_array($elements)) {
						foreach ($elements as $element) {
							$fk = strtolower(get_class($this))."_id";
							$element->$fk = $this->id;
							
							if (!$element->save()) {
								Logger::error("save_related() Could not save a ".get_class($element)." in <".get_class($this). ">");	
								return false;
							}
						}
					}
					else {
						Logger::warn(" save_related() $plural has no elements to be saved ");	
					}
				}
			}
		}
	}
	public function save_dynamic() {


		if (is_array($this->_dynamic_data)) {
			Logger::info("save_dynamic(): Will save some properties here this->_dynamic_data:",$this->_dynamic_data);

			// Subir los attachments antes de guardar la información
			foreach ($this->getDinamicProperties() as $dynamic_property) {
				if ($dynamic_property["type"] == "file") {
					$this->save_attachment($dynamic_property["keyword"]);
				}
			}

			foreach ($this->_dynamic_data as $key => $value) {
				if (!isset($this->dynamic_properties["table_prefix"])) {
					$table_name = $this->getTableName()."_".$this->_dynamic_properties[$key]["type"];
				}
				elseif (not_empty($this->dynamic_properties["table_prefix"]))  {
					$table_name = $this->getTableName()."_".$this->dynamic_properties["table_prefix"]."_".$this->_dynamic_properties[$key]["type"];
				}
				else {
					$table_name = $this->getTableName()."_".$this->_dynamic_properties[$key]["type"];
				}
			
				$sql = "
					DELETE FROM ".$table_name."
					WHERE attribute_id = ".$this->_dynamic_properties[$key]["id"]."
					AND ".get_class($this)."_id = ".$this->id;
				if (mysql_query_door($sql)) {
					Logger::info("OK query in <save_dynamic()>", $sql);
				}
				else {
					Logger::error("Error on query in <save_dynamic()>", $sql);	
					return false;
				}
				/*
				 Soporte para datetime
				*/
				if ($this->_dynamic_properties[$key]["type"] == "datetime") {
					$value = date("Y-m-d H:i:s", $value);
				}

				if ($this->_dynamic_properties[$key]["type"] == "float") {
					/*
					EXPERIMENTAL, implementado en portalpad
					*/
					$value = str_replace(",",".",$value);
				}
				$fields = array();
				$values = array();
				if (!is_array($value)) {
					$fields[] = "value";
					$values[] = "'".mysql_real_escape_string($value)."'";
				}
				else {
					/* 
					TODO: 
					Implementar sin dependencia de creacion de fields en la tabla para nuevos idiomas??
					*/
					foreach ($value as $lang => $lang_value) {
						$fields[] = "value_".$lang;
						$values[] = "'".mysql_real_escape_string($lang_value)."'";
					}

				}
				$sql = "INSERT INTO ".$table_name."
					(".strtolower(get_class($this))."_id,attribute_id, ".implode(",", $fields).")
					VALUES
					(".$this->id.",".$this->_dynamic_properties[$key]["id"].", ".implode(",", $values).")
				";
				
				//echo $sql;
				if (mysql_query_door($sql)) {
					//exit($sql);
					Logger::info("OK query in <save_dynamic()> ", $sql);
				}
				else {
					//exit(mysql_error());
					Logger::error("Error on query in <save_dynamic()>".mysql_error(), $sql);	
					return false;
				}			
			}
			return true;

		}
	
	}
	public function save($validate = true, $call_hooks = true) {
		if ($this->run_validation()) {
			if (isset($this->has_attachments)) {
				if (!is_array($this->has_attachments)) {
					$this->has_attachments = array($this->has_attachments);
				}
				foreach ($this->has_attachments as $key => $attachment_definition) {
					if (!$this->save_attachment($key)) {
						if ($attachment_definition["required"])	{
							return false;	
						}
					}
				}
			}
			
			if ($this->is_new()) {
				if (!is_array($this->_data)) {
					Logger::warn("No data to be inserted, but will try to create row anyways");
				}
				if ($call_hooks && method_exists($this, "before_create")) {
					Logger::info("Will call this->before_create on <".get_class($this).">");
					call_user_method("before_create",$this);
				}
				$sql = "INSERT INTO ".$this->getTableName()." (".implode_keys($this->_data).") VALUES (".$this->implode_values_for_insert($this->_data).")";
				$this->last_sql = $sql;
				//echo $sql;
				if (mysql_query_door($sql)){
					//exit("INSERT");
					Logger::info("OK INSERT query in <save()>, will reload", $sql);
					$this->id = mysql_insert_id();
					$this->save_dynamic();
					$this->save_related();
					$this->save_translated();
					$this->reload();

					if ($call_hooks && method_exists($this, "after_create")) {
						Logger::info("Will call this->after_create");
						if (call_user_method("after_create",$this) === false) {
							/* 
								return false desde after_action expresamente si si quiere hacer fallar la operacion. 
								Poner delete en after_create y antes de return false 
							*/
							return false;
						}
					}
					

					return true;
				}
				else {
					Logger::error("Error on query in <save()> ".mysql_error(), $sql);
					return false;
				}
			}
			else {
				/*
					Is not new, so please update existing row
				*/
				$this->schema_info();
				if ($call_hooks && method_exists($this, "before_update")) {
					Logger::info("Will call this->before_update on <".get_class($this).">");
					call_user_method("before_update",$this);
				}
				if (is_array($this->_data)) {
					foreach ($this->_data as $key => $value) {
						if ($this->_schema_info[$key] == "datetime") {
							$sql_setters[] = $key." = '".mysql_real_escape_string(date("Y-m-d H:i:s",$value))."'";
						}
						elseif ($this->_schema_info[$key] == "date") {
							$sql_setters[] = $key." = '".mysql_real_escape_string(date("Y-m-d",$value))."'";
						}
						elseif (substr($this->_schema_info[$key],0,3) == "int" || substr($this->_schema_info[$key],0,7) == "tinyint" ||	$this->_schema_info[$key] == "float" || substr($this->_schema_info[$key],0,7) == "decimal" ) {
							if (is_bool($value)) {
								$value = ($value)?1:0;
							}
							if (is_numeric($value)) {
								$sql_setters[] = $key." = '".mysql_real_escape_string($value)."'";
							}
						}
						else {
							$sql_setters[] = $key." = '".mysql_real_escape_string($value)."'";
						}
					}

					$sql = "UPDATE ".$this->getTableName()." SET ".implode(", ",$sql_setters);	
					$sql .= " WHERE id = ".$this->id;

					if (mysql_query_door($sql)){
						Logger::info("OK query in <save()>", $sql);
					}
					else {
						Logger::error("Error on query in <save()>:".mysql_error(), $sql);
						return false;
					}
				}
				else {
					Logger::warn("nothing to update on table: ".$this->getTableName());	
				}
				
				$this->save_related();
				$this->save_dynamic();
				$this->save_translated();

				if ($call_hooks && method_exists($this, "after_update")) {
					Logger::info("Will call this->after_update on <".get_class($this).">");
					call_user_method("after_update",$this);
				}
				
				return true;
			}

		}
		else {
			Logger::warn("Could not save <".get_class($this).">, there are ".count($this->_validation_errors)." validation errors" );
			//exit("val erro");
		}
	}
	public function delete() {
		
		// TODO: decir de alguna forma si debe o no ser eliminado (los hijos)
		foreach ($this->getChildModels() as $plural => $child_model_table) {
			/*
			HA HABIDO PROBLEMAS EN ESTA FUNCION EN ENVIRO Y APP
			Tuve que poner este is_array() por que daba warining al eliminar un producto
			*/

			if (is_array($this->$plural)) {
				foreach ($this->$plural as $child) {
					if (!$this->isManyToMany($plural)) {
						if (!$child->delete()) {
							return false;	
						}
					}
					else {
						// Eliminar elementos de la tabla related de ManyToMany
						$sql = " DELETE FROM ".$this->_child_models_by_plural[$plural]["relational_table"]." WHERE ".strtolower(get_class($this))."_id = ".$this->id;
						if (!mysql_query_door($sql)) {
							Logger::error("ERROR while trying to clean many-to-many relational table", $sql);
							return false;
						}
					}
	
				}
			}
			else {
				Logger::error("ERROR while trying to clean children of deleteted instance this->$plural not a child model");
			}
		}

		
		if ($this->is_soft_deletion()) {
			$sql = "UPDATE ".$this->getTableName()." SET is_deleted = 1 WHERE id = ".$this->id;
			
			if (!mysql_query_door($sql)) {
					Logger::error("Could not soft delete with: ", $sql);
					return false;
			}
			else {
				$this->is_deleted = 1;
				if (method_exists($this, "after_delete")) {
					Logger::info("Will call this->after_delete");
					call_user_method("after_delete",$this);
				}
				return true;
			}
		}
		else {
			// TODO: borrar attachments
					
			$sql = "DELETE FROM ".$this->getTableName()." WHERE id = ".$this->id;
			if (mysql_query_door($sql)){
				$this->is_deleted = 1;
				Logger::info("OK DELETE ".get_class($this), $sql);				
				if (method_exists($this, "after_delete")) {
					Logger::info("Will call this->after_delete");
					call_user_method("after_delete",$this);
				}
				return true;
			}
			else {
				Logger::error("ERROR on DELETE <".get_class($this).">", $this);				
	
			}
			return false;
		}
	}
	private function schema_info() {
		if (!is_array($this->_schema_info)) {
			$this->_schema_info = array();
			$sql = "SHOW COLUMNS FROM `".$this->getTableName()."`";
			if ($res = mysql_query_door($sql)) {
				$i = 0;
				while ($row = mysql_fetch_array($res)){
					$this->_schema_info[$row["Field"]] = $row["Type"];
					$i++;
				}
				Logger::info("_schema_info loaded for <".get_class($this).">: ", $this->_schema_info);
			}
			else {
				Logger::error("Could not load _schema_info SQL failed", $sql);
			}
		}
		return $this->_schema_info;
	
	}
	private function getChildModels() {
		if (!isset($this->_child_models_by_plural)) {
			//$this->_child_models = array();
			$this->_child_models_by_plural = array();

			if (isset($this->has_many)) {
				foreach ($this->has_many as $a1 => $a2) {
						global $models;

						if (is_array($a2) && isset($a2["model"])) {
							$foreign_model = $a2["model"];
							$plural_alias = $a1;
						}
						elseif (is_array($a2)) {
							$foreign_model = $models["by_plural"][$a1]["model"];
							$plural_alias = $a1;
						}
						else {
							// TODO: Obener el foreign model para el plural (a partir de $a2="instalaciones"
							$foreign_model = $models["by_plural"][$a2]["model"];
							$plural_alias = $a2;
						}
					
						$tool_name = $foreign_model."Tool";
						if (class_exists($tool_name)) {
							$tool = new $tool_name();

							if (is_array($a2) && strlen($a2["relational"]) > 0) {
								$relational_table = $a2["relational"];
								$foreign_key = strtolower($foreign_model)."_id";
							}
							else {
								$relational_table = $tool->table;
								$foreign_key = strtolower(get_class($this))."_id";
							}
							
							if (is_array($a2) && strlen($a2["foreign_key"]) > 0) {
								$foreign_key = $a2["foreign_key"];
							}
							if (is_array($a2) && strlen($a2["as"]) > 0) {
								$as = $a2["as"];
							}
							else {
								$as = $foreign_model;
							}
							$condition = null;
							if (is_array($a2) && strlen($a2["condition"]) > 0) {
								$condition = $a2["condition"];
							}
							$order = null;
							if (is_array($a2) && strlen($a2["order"]) > 0) {
								$order = $a2["order"];
							}
							//$this->_child_models[] = $plural_alias;
							
							$this->_child_models_by_plural[$plural_alias] = array(
								"model" => $foreign_model, 
								"table" => $tool->table,
								"relational_table" => $relational_table,
								"foreign_key" => $foreign_key,
								"as" => $as,
								"order" => $order,
								"condition" => $condition
							);

							
						}
						else {
							Logger::warn("Cannot find a related model for '$foreign_model' in <".get_class($this).">::has_many ")	;
						}
				}
			}
			Logger::info("Loaded child models for <".get_class($this).">",$this->_child_models_by_plural)	;
		}
		else {
			//Logger::info("Child models for <".get_class($this)."> taken from cache")	;
		}
		
		return $this->_child_models_by_plural;
	}
	private function getParentModels() {
		
		if (!isset($this->_parent_models)) {
			$this->_parent_models = array();
			if (isset($this->belongs_to)) {
				foreach ($this->belongs_to as $a1 => $a2) {
			
					if (is_array($a2)) {
						if (strlen($a2["foreign_key"])>0) {
							$this->_parent_models[strtolower($a1)]["foreign_key"] = $a2["foreign_key"];
						}
						else {
							$this->_parent_models[strtolower($a1)]["foreign_key"] = strtolower($a1)."_id";
						}
						if (strlen($a2["model"])>0) {
							$this->_parent_models[strtolower($a1)]["model"] = ucwords($a2["model"]);
						}
						else {
							$this->_parent_models[strtolower($a1)]["model"] = ucwords($a1);
						}
					}
					else {
						$this->_parent_models[strtolower($a2)]["foreign_key"] = strtolower($a2)."_id";
						$this->_parent_models[strtolower($a2)]["model"] = ucwords($a2);
					}

				}
			}
			Logger::info("Loaded parent models for <".get_class($this).">",$this->_parent_models);
		}
		
		return $this->_parent_models;
	}
	private function getTableName() {
		if (!isset($this->_table_name)) {
			$tool_name = get_class($this)."Tool";
			$tool = new $tool_name();
			$this->_table_name = $tool->table;
		}
		return $this->_table_name;
	}
	private function is_soft_deletion() {
		$tool_name = get_class($this)."Tool";
		$tool = new $tool_name();
		return $tool->soft_deletion;
	}
	private function has_dynamic_properties() {
		if (isset($this->dynamic_properties)) {
			return true;
		}
		return false;
	}
	private function getChildList($plural) {
		// GOTCHA: si no hay nada return array();
		// TODO: Si modelo no existe return FALSE;
		// TODO: Internal caching??
		if (!is_array($this->_data_related)) {
			$this->_data_related = array();
		}
		if (!isset($this->_data_related[$plural])) {
			
			//Logger::debug("getChildList", $plural);
			$tool_name = ucwords($this->_child_models_by_plural[$plural]["model"])."Tool";
			$tool = new $tool_name();
			
			if ($this->_child_models_by_plural[$plural]["relational_table"] == $this->_child_models_by_plural[$plural]["table"]) {
				$sql = "SELECT * FROM ".$this->_child_models_by_plural[$plural]["relational_table"]." 
					WHERE ".$this->_child_models_by_plural[$plural]["foreign_key"]." = ".$this->id;
				
				if (strlen($this->_child_models_by_plural[$plural]["condition"])>0) {
					$sql .= " AND (".$this->_child_models_by_plural[$plural]["condition"].")";
				}
			}
			else {
				$sql = "
					SELECT ".$this->_child_models_by_plural[$plural]["table"].".* 
					FROM ".$this->_child_models_by_plural[$plural]["relational_table"]."
					LEFT JOIN ".$this->_child_models_by_plural[$plural]["table"]." ON ".$this->_child_models_by_plural[$plural]["table"].".id = ".$this->_child_models_by_plural[$plural]["relational_table"].".".$this->_child_models_by_plural[$plural]["foreign_key"]."
					WHERE ".$this->_child_models_by_plural[$plural]["relational_table"].".".strtolower(get_class($this))."_id = ".$this->id;
					
					if (strlen($this->_child_models_by_plural[$plural]["condition"])>0) {
						$sql .= " AND (".$this->_child_models_by_plural[$plural]["condition"].")";
					}
					
			}
			if (not_empty($this->_child_models_by_plural[$plural]["order"])) {
				$sql .= " ORDER BY ".$this->_child_models_by_plural[$plural]["order"];
			}
			
			$this->_data_related[$plural] = $tool->find_by_sql($sql, $this->_child_models_by_plural[$plural]["as"]);
		}
		
		return $this->_data_related[$plural];
		
	}
	public function getParentInstance($key) {
		if (!isset($this->_parent_models)) {
			$this->getParentModels();
		}
		if (!isset($this->$key)) {
			
			$tool_name = $this->_parent_models[$key]["model"]."Tool";
			Logger::info("Loading parent item for $key with model <".$this->_parent_models[$key]["model"].">");

			$tool = new $tool_name();
			$foreign_key = $this->_parent_models[strtolower($key)]["foreign_key"];
			Logger::debug("FK NAME is ".$foreign_key);
			if ($this->$foreign_key > 0) {
				$this->$key = $tool->find($this->$foreign_key);
			}
			else {
				Logger::warn("Foreign key '$foreign_key' not valid in <".get_class($this)."> for parent model <$model_name>");	
			}
		}
		else {
			Logger::info("Loading parent item for <$model_name> (from cache)");
		}
		return $this->$key;

	}
	public function reload() {
		// TODO: UNSET children & parents?

		// NUEVO CODIGO EN BETA
		$tool_name = get_class($this)."Tool";
		$tool = new $tool_name();
		if ($new = $tool->find($this->id)) {
			foreach (get_object_vars($new) as $key => $value) {
				/* 
					Atributos del modelo pasados a través de _table_data. 
					Do not expect a foreach for every property in the model
				*/
			  $this->$key = $value;
			}
			unset($this->_dynamic_data);
			if (is_array($this->_child_models_by_plural)) 
			foreach ($this->_child_models_by_plural as $key => $info) {
				unset($this->$key);
			}
			if (is_array($this->_parent_models)) 
			foreach ($this->_parent_models as $key => $info) {
				unset($this->$key);
			}
			Logger::info("Model <".get_class($this)."> reloaded", $sql);
			return true;
		}
		else {
			Logger::error("Could not reload <".get_class($this).">", $sql);
			return false;
		}
		// FIN NUEVO CODIGO EN BETA

		// CODIGO NORMAL

		$sql = "SELECT * FROM ".$this->getTableName()." WHERE id = ".$this->id;
		$result = mysql_query_door($sql);
		$this->_table_data = array();
		
		if ($array = mysql_fetch_array($result, MYSQL_ASSOC) ) {
			$i = 0;
			foreach ($array as $column_name => $value) {
				if (mysql_field_type($result,$i) == "datetime")
					$this->_table_data[$column_name] = strtotime($value);
				else
					$this->_table_data[$column_name] = $value;
				$i++;
			}
			Logger::info("OK query for <reload()>", $sql);
			return true;
		}
		else {
			Logger::warn("Error could not reload object <reload()>", $sql);
			return false;
		}
		
	}
	function is_changed($name) {
		if (isset($this->_updated[$name])) {
			return true;	
		}
		else {
			return false;
		}
	}
	public function getDinamicProperties() {

		if (!isset($this->_dynamic_properties)) {
			if (!$this->has_dynamic_properties()) {
				$this->_dynamic_properties = array();
			}
			else {
				if (!is_array($this->_dynamic_data)) {
					$this->_dynamic_data = array();
				}
				if (!is_array($this->_dynamic_properties)) {
					$this->_dynamic_properties = array();
					$sql = "SELECT * FROM ".$this->getTableName()."_attributes ORDER BY weight";
					// todo: aplicar las condiciones segun "type"	
					if (!($result = mysql_query_door($sql))) {
						Logger::error("getDinamicProperties() ".mysql_error(), $sql);
					}
					else {
						while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
							$this->_dynamic_properties[$row["keyword"]] = $row;
						}
						Logger::info("Loaded dynamic properties", $this->_dynamic_properties);
					}
				} 
			}
		}
		return $this->_dynamic_properties;
	}
	public function getProperty($keyword) {
		// this fx sould be called getDynamicProperty?
		$dinamic_properties = $this->getDinamicProperties();
		if (!isset($this->_dynamic_data[$keyword])) {
			$sql = "
				SELECT value FROM ".$this->getTableName()."_values_".$dinamic_properties[$keyword]["type"]."
				WHERE attribute_id = ".$dinamic_properties[$keyword]["id"]."
				AND ".get_class($this)."_id = ".$this->id."
			";
			if (!($result = mysql_query_door($sql))) {
				Logger::error("getProperty() ".mysql_error(), $sql);
			}
			else {
				if ($row = mysql_fetch_array($result) ) {
					if ($dinamic_properties[$keyword]["type"] == "datetime") { 
						$value = strtotime($row["value"]);
					}
					elseif ($dinamic_properties[$keyword]["type"] == "file") {
						$original_property =  $keyword."_original";
						if (isset($this->dynamic_properties["path"])) {
							$path = $this->dynamic_properties["path"];
							
						}
						else {
							$path = "/site/store/";
						}
						$value = new PortalDataFile($row["value"],
							array(
								"path" => $path,
								"model" => get_class($this),
								"model_id" => $this->id,
								"field" => $keyword
							),
							$this->$original_property
						);
					}
					else {
						$value = $row["value"];
					}
					$this->_dynamic_data[$name] = $value;
					return $value;
				}
			}
		}
		else {
			return $this->_dynamic_data[$keyword];
		}
	}
	public function getTranslated($keyword, $lang) {
		/* 
			TODO: 
			Implementar caching a traves de _table_data_translated (no _data_translated para evitar save?)
		*/
		if (is_array($this->translate)) {
			$sql = "SELECT text FROM ".$this->getTableName()."_lang WHERE ".get_class($this)."_id = ".$this->id." AND field = '".$keyword."' AND language = '".$lang."'";
			$res = mysql_query_door($sql);
			if ($row = mysql_fetch_array($res)) {
				return $row["text"];
			}
		}
		else {
			return $this->$keyword;
		}
	}

	public function __get($name) {
		if (substr($name,0,1) != "_" && $name != "has_attachments") {
			Logger::debug("__get(".$name.") on <".get_class($this).">");

			if (isset($this->_table_data[$name])) {
				//Logger::debug("FOUND $name");
				if (is_array($this->has_attachments) && isset($this->has_attachments[$name])) {
					/*
					 Implementacion de PortalDataFile en el campo
					*/
					$this->has_attachments[$name]["model"] = get_class($this);
					$this->has_attachments[$name]["model_id"] = $this->id;
					$this->has_attachments[$name]["field"] = $name;
					if (isset($this->has_attachments[$name]["class"])) {
						$class_name = $this->has_attachments[$name]["class"];
					}
					else {
						$class_name = "PortalDataFile";

					}
					return new $class_name($this->_table_data[$name],
						$this->has_attachments[$name],
						$this->_table_data[$this->has_attachments[$name]["original_field"]]);
				}
	
				return $this->_table_data[$name];
			}
			elseif (substr($name,strlen($name)-2) == "()" && method_exists($this,substr($name,0,strlen($name)-2))) {
				return call_user_func(array($this, substr($name,0,strlen($name)-2)));
			}
			// Chequear por Hijos
			elseif (array_key_exists($name, $this->getChildModels())) {
				return $this->getChildList($name);
			}
			elseif (array_key_exists($name, $this->getDinamicProperties())) {
				return $this->getProperty($name);
			}
			else {
				Logger::debug("__get(".$name.") on <".get_class($this)."> will look in parent models");

				$p = $this->getParentModels();
				// Chequear por Padre

				if (isset($p[$name]) ) {
					Logger::debug("FOUND $name",$this->getParentModels());
					$this->$name = $this->getParentInstance($name);
					return $this->$name;
				}
				else {
					return false;	
				} 
			}
		}
		return null;
	}
	public function __set($name, $value) {
		if (substr($name, 0, 1) != "_") {
			// Interceptar las propiedades que sean parte del modelo
			if ($name == "id") {
				$this->id = $value;
			}
			elseif (is_array($this->translate) && in_array($name, $this->translate) && (!method_exists($this, "has_translations") || $this->has_translations() )) {
				if (!is_array($this->_data_translated)) {
					$this->_data_translated = array();
				}
				if (is_array($value)) {
					foreach ($value as $lang_iso => $lang_value) {
						if (!is_array($this->_data_translated[$name])) {
							$this->_data_translated[$name] = array();
						}
						if(get_magic_quotes_gpc() == 1) {
							$lang_value = stripslashes($lang_value);
						}
						$this->_data_translated[$name][$lang_iso] = $lang_value;
					}	
				}
				//debug($this->_data_translated);
				//exit("handle __set lang". $name);
			}
			elseif (array_key_exists($name, $this->schema_info()) || (is_array($this->_table_data) && array_key_exists($name, $this->_table_data))) {
				//Logger::debug("new modelo(".$name.")", $value);
				//Logger::debug("_table_data",$this->_table_data);
				//Logger::debug("modelo(".$name.")", $value);
				if (!isset($this->_data)) {
					$this->_data = array();
				}
				if (!isset($this->_table_data)) {
					$this->_table_data = array();
				}
				if ($this->_schema_info[$name] == "datetime" || $this->_schema_info[$name] == "date") {
					if (is_array($value)) {
						$str_for_datetime = $value["y"]."-".$value["m"]."-".$value["d"];
						if (not_empty($value["H"]) && not_empty($value["i"])) {
							$str_for_datetime .= " ".$value["H"].":".$value["i"];	
						}
						$value = strtotime($str_for_datetime);
					}
					elseif (!is_numeric($value)) {
						$value = strtotime($value);
					}
				}
				if ($this->$name != $value) {
					if (!is_array($this->_updated)) {
						$this->_updated = array();	
					}
					$this->_updated[$name] = $this->$name;
				}
				if(get_magic_quotes_gpc() == 1) {
					$value = stripslashes($value);
				}
				if (!is_array($value)) {
					// evitar errores si un array se mete en el intert
					$this->_data[$name] = $value;
				}
				$this->_table_data[$name] = $value;
			}
			elseif (array_key_exists($name, $this->getDinamicProperties())) {
				$this->_dynamic_data[$name] = $value;
			}
			elseif (array_key_exists($name, $this->getChildModels()) ) {
				//http://bytes.com/groups/php/170844-array-property-object-__get-__set-bug
				if (!is_array($this->_data_related)) {
					$this->_data_related = array();
				}
				if (!is_array($this->_data_related[$name])) {
					$this->_data_related[$name] = array();
				}
				$this->_data_related[$name] = $value;
			}
			else {
				$this->$name = $value;
			}
		}
		else {
			$this->$name = $value;
		}
	}
}



?>