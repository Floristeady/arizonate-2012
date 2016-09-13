<?
  class Type extends Translatable{
		function existsAttribute($keyword) {
			$sql = "SELECT * FROM contents_attributes
				LEFT JOIN attributes_types ON contents_attributes.id = attributes_types.attribute_id
				WHERE keyword = '".mysql_real_escape_string($keyword)."'
				AND attributes_types.type_id = ".$this->id;
			//echo $sql;
			$result = mysql_query_door($sql);
			echo mysql_error();
			if (mysql_num_rows($result)>0)
				return true;
			else
				return false;
		}
  }
