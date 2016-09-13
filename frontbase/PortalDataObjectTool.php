<?

class PortalDataObjectTool {
	function find($arg = null, $arg2 = null) {
		$colection = $this->find_all($arg, $arg2);
		if ($colection && count($colection)>0)
			return current($colection);
		else
			return false;
	}
	function find_all($arg1 = null, $arg2 = null, $arg3 = null, $arg4 = null) {
		/*
		TODO: SQL injection
		find_all(2): por primary key
		find_all(array("nombre LIKE %guille%", "apellido LIKE '%gonz%'"))
		find_all(array("nombre LIKE %guille%", pais => "chile"))
		find_all("apellido LIKE 'g%' AND id = 1")

		find_all(arg1, string order, int start index, int end index)
		find_all(arg1, string order, string limit)
		*/
		
		if (is_numeric($arg1)) {
			$sql = "SELECT * FROM ".$this->table." WHERE id = ".$arg1;	
		}
		elseif (is_array($arg1)) {
			$sql = "SELECT * FROM ".$this->table." WHERE 1=1 ";	
			foreach ($arg1 as $key => $value) {
				if (!is_numeric($key))
					$sql .= " AND $key = '$value'";
				else
					$sql .= " AND $value ";
			}
		}
		elseif (is_string($arg1) && strlen($arg1) > 0) {
			$sql = "SELECT * FROM ".$this->table." WHERE ".$arg1;	

		}
		else {
			$sql = "SELECT * FROM ".$this->table;	
		}
				
		if (!is_null($arg2) && strlen($arg2) > 0 ) {
			$sql .= " ORDER BY ".$arg2;
		}
		elseif (strlen($this->order_by) > 0)  {
			$sql .= " ORDER BY ".$this->order_by;
		}
		if (!is_null($arg3) && is_numeric($arg3)) {
			$sql .= " LIMIT ".$arg3;
			if (is_numeric($arg4)) {
				$sql .= ",".$arg4;
			}
		}		
		//echo $sql;
	
		return $this->find_by_sql($sql);	
	}
	function fetch_object($result, $as = null){

		
		if (!is_null($as) && strlen($as)>0) {
			$object_name = $as;
		}else {
			$object_name = $this->object_name;	
		}
		if ($array = mysql_fetch_array($result, MYSQL_ASSOC) ) {
			/*
				GOTCHA:
				El constructor se llama antes de tener un ID (no sirve para nada)
				after_load es un "constructor virtual"
				
				KNOWN ISSUE:
				El reconocimiento de tipo de campo falla en resultset con columnas repetidas.
				ej: select products.id, product.* from product
			*/
			$object = new $object_name;
			$i = 0;
			/*
				SOPORTE PARA ID en mayuscula?
			*/
			if (!empty($array["id"])) {
				$object->id = $array["id"];
			}
			elseif (!empty($array["ID"]))  {
				$object->id = $array["ID"];
			}
			$object->_table_data = array();

			foreach ($array as $column_name => $value) {
				// GOTCHA: no poner la definicion de fields aqui?? porque puede venir de otra DB que no sea MySQL
				if (mysql_field_type($result,$i) == "datetime" || mysql_field_type($result,$i) == "date") {
					// TODO: Mover este codigo a PDO::__get()?
					$value = strtotime($value);
				}
				$object->_table_data[$column_name] = $value;
				$i++;
			}
			if (method_exists($object, "after_load")) {
				call_user_method("after_load",$object);
			}
			return $object;
		}	
		else 
			return false;
	}
	function find_by_parent($model) {
		/*
			TODO: Compatibilidad con foreign keys especiales (realaciones especiales)
		*/
		$sql = "SELECT * FROM ".$this->table;	
		$sql .= " WHERE ".strtolower(get_class($model))."_id = ".$model->id;	

		return $this->find_by_sql($sql);
		
	}
	function find_by_sql($sql, $as = null) {
		// GOTCHA: return false ONLY on error, other foreach will fail if empty!
		if ($this->soft_deletion) {
			$sql = "SELECT * FROM (".$sql.") AS temp_table WHERE is_deleted = 0 OR is_deleted IS NULL";
		}
		$this->sql = $sql;

		if ($result = mysql_query_door($sql)) {
			Logger::info("OK query in <find_by_sql()> ", $sql);
		}else {
			Logger::error("ERROR on query in <find_by_sql()>", "SQL:".$sql." => ".mysql_error());
			return false;
		}
		$list = array();
		while ($row = $this->fetch_object($result, $as) ) {
			$list[] = $row;
		}	
		return $list;	
	}
	function __call($method, $args) {
		if (substr($method, 0, 12) == "find_one_by_") {
			$attribute_name = substr($method, 12);	
			return $this->find(array($attribute_name => $args[0]));
		}
		elseif (substr($method, 0, 8) == "find_by_") {
			$attribute_name = substr($method, 8);	
			return $this->find_all(array($attribute_name => $args[0]));
		}
	}

}