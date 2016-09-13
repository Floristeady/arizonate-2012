<?
/*
TODO: Cambiar argumento item_as_key experimental usado solo por C:\webapps\ac\sites\public\templates\pages\confirm_reservation.php
*/
class ModelFormHelper {
	function text($model_object, $property,  $arg1 = null ) {
		$str = "<input type=\"text\"";
		$class_added = false;
		
		if (is_array($model_object->_validation_errors)) {
			if (array_key_exists($property, $model_object->_validation_errors)) {
				$class_error = "error";
			}
		}
		
		$str .= " name = \"".strtolower(get_class($model_object))."[".$property."]\"";
		$str .= " value = \"".$model_object->$property ."\"";
		if (is_array($arg1)) {
			foreach ($arg1 as $key => $value) {
				if ($key != "class") {
					$str .= " $key = \"".$value."\"";
				}
				else {
					$class_added = true;
					$str .= " class = \"".$value." $class_error\"";
				}
			}
		}
		elseif (is_string($arg1)) {
			$class_added = true;
			$str .= " class = \"".$arg1." $class_error\"";
		}
		if (!$class_added)
			$str .= " class = \"$class_error\" ";
		
		$str .= ">";
		
		return $str;
			
	}
	function date($model_object, $property, $default_date = null, $arg1 = null ) {
		
		$str .= "<input type=\"text\"";
		$class_added = false;
		
		if (is_array($model_object->_validation_errors)) {
			if (array_key_exists($property, $model_object->_validation_errors)) {
				$class_error = "error";
			}
		}
		
		if ($model_object->$property>0)
			$value = date("Y-m-d",$model_object->$property);
		elseif ($default_date != null) 
			$value = date("Y-m-d",$default_date);
		else	
			$value = date("Y-m-d");
		
		if (is_array($arg1)) {
			foreach ($arg1 as $key => $value) {
					$str .= " $key = \"".$value."\"";
			}
		}
		
		$str .= " class='date' name = \"".strtolower(get_class($model_object))."[".$property."]\"";
		$str .= " value = \"".$value."\"";
			
		$str .= ">";
		
		return $str;
			
	}
	function date_select($model_object, $property, $default_date = null, $options = null ) {
		/*
			DateSelectHelper para liberarse de javascript
			TODO: Llevar a FormHelper
		*/
		if ($model_object->$property>0) {
			$date = $model_object->$property;
		}
		elseif ($default_date != null) 
			$date = $default_date;
		else	
			$date = mktime();
		
		if (!isset($options["from_year"])) {
			$from_year = 1900;
		}
		else {
			$from_year = $options["from_year"];
		}
		if(!isset($options["to_year"])) {
			$to_year = 2030;
		}
		else {
			$to_year = $options["to_year"];
		}
		$days = array();
		foreach (range(1,31) as $day) {
			$days[$day] = $day;
		} 
		$str .= FormHelper::select(strtolower(get_class($model_object))."[$property][d]", $days,null,date('j',$date),$options);
		$str .= FormHelper::select(strtolower(get_class($model_object))."[$property][m]", DateHelper::getMonths(),"es",date('n',$date), $options);

		$years = array();
		foreach (range($from_year,$to_year) as $year) {
			$years[$year] = $year;
		} 
		$str .= FormHelper::select(strtolower(get_class($model_object))."[$property][y]", $years,null,date('Y',$date), $options);
		return $str;
		
	}
	function datetime_select($model_object, $property, $default_date = null, $options = null ) {
		if ($model_object->$property>0) {
			$date = $model_object->$property;
		}
		elseif ($default_date != null) 
			$date = $default_date;
		else	
			$date = mktime();

		$str = self::date_select($model_object, $property, $date, $options);
		$hours = range(0,23);
		$str .= FormHelper::select(strtolower(get_class($model_object))."[$property][H]", $hours,null,date('H',$date), $options);
		
		$hours = range(0,59);
		$str .= FormHelper::select(strtolower(get_class($model_object))."[$property][i]", $hours,null,date('i',$date), $options);

		return $str;
	}
	
	function select($model_object, $property, $collection, $name_property = "name", $prompt_blank = true, $options = array()) {
		$str .= "<select name=\"".strtolower(get_class($model_object))."[".$property."]\"";
		
		if (is_array($model_object->_validation_errors)) {
			if (array_key_exists($property, $model_object->_validation_errors)) {
				$class_error = "error";
			}
		}
		if (!isset($options["id"])) {
			$sql .= " id=\"field_".strtolower(get_class($model_object))."_".$property."\"";
		}
		foreach ($options as $key => $value) { 
			if ($key != "class" && $key != "item_as_key") { 
				$str .= " $key=\"$value\"";
			}
		}
		$str .= " class=\"".$class_error." ".$options["class"]."\"";

		$str .= ">";

		if (is_array($collection)) {
			if (!($model_object->$property > 0) && $prompt_blank) {
				if (is_string($prompt_blank)) {
					$prompt_blank_text = $prompt_blank;
				}
				else {
					$prompt_blank_text = "";
				}
				if ($prompt_blank) {
					$str .= "<option value=''>".$prompt_blank_text."</option>";
				}
			}
			
			foreach($collection as $key => $item) {
				if (is_object($item)) {
					if ($model_object->$property == $item->id)
						$str .= "<option selected value='".$item->id."'>".$item->$name_property."</option>";
					else
						$str .= "<option value='".$item->id."'>".$item->$name_property."</option>";
				}
				else {
					// GOTCHA: ("" == 0) returns TRUE
					if ($options["item_as_key"]) {
						$key = $item;
					}
					if (strlen($model_object->$property)>0 && $model_object->$property == $key) {
						$str .= "<option selected value='".$key."'>".$item."</option>";
					}
					else
						$str .= "<option value='".$key."'>".$item."</option>";
				}
			}
		}
		else {
			Logger::warn("No collection given for ModelFormHelper::select for <".$property.">");
		}
		$str .= "</select>";
		return $str;
	}
	function validation_errors($model_object, $property = null) {
		if (
			is_array($model_object->_validation_errors) 
			&& 
			count($model_object->_validation_errors) > 0 
			&&
			(array_key_exists($property, $model_object->_validation_errors) || is_null($property)) 
		){
			$str = "<ul>";
			foreach ($model_object->_validation_errors as $property_name => $validation_error){
				$str .= "<li>".$validation_error."</li>";
			}
			$str .= "</ul>";
		}
		return $str;
	}
	function textarea($model_object, $property, $html_options = array()) {
		$str = "<textarea ";
		foreach ($html_options as $key => $value) { 
			if ($key != "class") { 
				$str .= " $key=\"$value\"";
			}
		}
		if (is_array($model_object->_validation_errors)) {
			if (array_key_exists($property, $model_object->_validation_errors)) {
				$class_error = "error";
			}
		}
		$str .= " id=\"field_".strtolower(get_class($model_object))."_".$property."\" name=\"".strtolower(get_class($model_object))."[".$property."]\"";
		$str .= " class = \"$class_error ".$html_options["class"]."\" ";
		
		$str .= ">";
		$str .= $model_object->$property;
		$str .= "</textarea>";

		return $str;
			
	}
	function selectlist($model_object, $property, $collection, $name_property = "name") {
		if (is_array($collection)) {
			foreach($collection as $key => $item) {
				$str .= "<p class='selectlist-item'>";
				if (is_object($item)) {
					if ($model_object->$property == $item->id)
						$str .= "<input id=\"field_".strtolower(get_class($model_object))."_".$property."_".$item->id."\" type='radio' checked name = \"".strtolower(get_class($model_object))."[".$property."]\" value='".$item->id."'><label>".$item->$name_property."</label>";
					else
						$str .= "<input id=\"field_".strtolower(get_class($model_object))."_".$property."_".$item->id."\" type='radio' name = \"".strtolower(get_class($model_object))."[".$property."]\" value='".$item->id."'><label>".$item->$name_property."</label>";
				}
				else {
					if ($model_object->$property == $key)
						$str .= "<input id=\"field_".strtolower(get_class($model_object))."_".$property."_".$key."\" type='radio' checked name = \"".strtolower(get_class($model_object))."[".$property."]\" value='".$key."'><label>".$item."</label>";
					else
						$str .= "<input id=\"field_".strtolower(get_class($model_object))."_".$property."_".$key."\" type='radio' name = \"".strtolower(get_class($model_object))."[".$property."]\" value='".$key."'><label>".$item."</label>";
				}
				$str .= "</p>";
			}
		}
		else {
			Logger::warn("No collection given for ModelFormHelper::selectlist for <".$property.">");
		}
		return $str;
		
	}

	function checklist($model_object, $property, $collection, $name_property = "name") {
		//TODO: limitar a many to many?
		$str = "";
		
		$selected_ids = array();
		if (is_array($model_object->$property)) {
			foreach ($model_object->$property as $checked_item)  {
				$selected_ids[] = $checked_item->id;
			}
		}
		
		foreach($collection as $item) {
			$checked = false;
			if (in_array($item->id, $selected_ids)) {
				$checked = true;
			}
			$checked_attribute = ($checked )?"checked":"";

			$str .= "<div class='checkitem'><input $checked_attribute type=\"checkbox\" name=\"".strtolower(get_class($model_object))."[".$property."][]\" value=\"".$item->id."\">".$item->$name_property."</div>";
		}
		return $str;
	}
	function check($model_object, $property) {
		$checked_attribute = "";
		if ($model_object->$property == 1) {
			$checked_attribute = "checked";
		}
		$str .= "<input $checked_attribute type=\"checkbox\" name=\"".strtolower(get_class($model_object))."[".$property."]\" value=\"1\">";
		return $str;
	}
	function attachment($model_object, $property) {
		$str .= "<input type=\"file\" name=\"".strtolower(get_class($model_object))."_".$property."\">";
		return $str;
	}
	function hidden($model_object, $property, $value = null) {
		$str = "<input type=\"hidden\"";
		$str .= " name = \"".strtolower(get_class($model_object))."[".$property."]\"";
		if (is_null($value)) {
			$str .= " value=\"".$model_object->$property."\"";
		}
		else {
			$str .= " value=\"".$value."\"";
		}
		$str .= ">";
		return $str;
	}
	function checktree($model_object, $property, $collection, $parent_key = "parent_id", $seed_id = 0, $name_property = "name", $deepness = 0) {
		$selected_ids = array();
		if (is_array($model_object->$property)) {
			foreach ($model_object->$property as $checked_item)  {
				$selected_ids[] = $checked_item->id;
			}
		}
		
		if (is_array($collection)) {
			$str .= "<ul class='checktree-container' id='children_".$seed_id."'>";
			foreach($collection as $key => $item) {
				if ($item->$parent_key == $seed_id) {
						$checked = false;
						if (in_array($item->id, $selected_ids)) {
							$checked = true;
						}
						$checked_attribute = ($checked )?"checked":"";
						$str .= "<li class='checktree-item-deep-".$deepness."'><input ' $checked_attribute  type='checkbox' name = \"".strtolower(get_class($model_object))."[".$property."][]\" value='".$item->id."'><label>".$item->$name_property."</label></li>";
						$str .= self::checktree($model_object, $property, $collection, $parent_key, $item->id, $name_property, $deepness+1);
				}
			}
			$str .= "</ul>";
		}
		else {
			Logger::warn("No collection given for ModelFormHelper::checktree for <".$property.">");
		}
		return $str;
	}
	function cascade($model_object, 
		$property, 
		$models, 
		$name_property,
		$prompts) {
		
		
		for ($i=0; $i < (count($models)); $i++) { 
			$model[$i]["tool_name"] = $models[$i]."Tool";
			$model_tool = new $model[$i]["tool_name"];
			
			if (!isset($models[$i-1])) {
				// es el primero en generarse
				$selected_item = $model_tool->find($model_object->$property);
			}
			else {
				// no es el primero en generarse
				if ($selected_item->$model[$i-1]["parent_foreign_key_name"] > 0)
					$selected_item = $model_tool->find($selected_item->$model[$i-1]["parent_foreign_key_name"]);
				else
					$selected_item = null;
			}

			
			if (isset($models[$i+1])) {
				if (isset($selected_item))  {
				// Hay un padre-ancestro
					$model[$i]["parent_foreign_key_name"] = strtolower($models[$i+1])."_id";
					$model[$i]["selected_foreign_key"] = $selected_item->$model[$i]["parent_foreign_key_name"];
					$model[$i]["collection"] = $model_tool->find_all(array($model[$i]["parent_foreign_key_name"] => $model[$i]["selected_foreign_key"]));
				}
				else {
					$model[$i]["collection"] = array();
				}
			}
			else {
				// Ya no hay mas padres-ancestros
				$model[$i]["collection"] = $model_tool->find_all();
			}
			
			if (!isset($models[$i-1])) {
				//es el origen
				if (!($model_object->$property > 0)) {
					$prompts[$i] = null;
				}
				// Es el attributo final
				$items[] = self::select(
						$model_object, 
						$property, 
						$model[$i]["collection"], 
						$name_property[$i],
						$prompts[$i],
						array("id" => "cascade_".$i)
					);
			}
			else {
				if (!($selected_item->id > 0) && isset($models[$i+1])) {
					$prompts[$i] = null;
				}
				// Es un atributo ancestro
				$items[] = FormHelper::select(
					$selected_item->$model[$i]["parent_foreign_key_name"], 
					$model[$i]["collection"], 
					$name_property[$i],
					$selected_item->id,
					array("prompt" => $prompts[$i], "id" => "cascade_".$i, "onchange" => "ModelFormHelper_cascading_populate(this.value,'/json/select_options_for_level/".$i."',".$i.")")
				);
			}
		}
		return $items;
		
	}
	function radio($model_object, $property, $collection, $name_property = "name") {
		return FormHelper::radio(strtolower(get_class($model_object))."[".$property."]", $collection, $name_property, $model_object->$property);
	}
	function radio_option($model_object, $property, $value, $label = "") {
		$options["type"] = "radio";
		$options["value"] = $value;
		$options["name"] = strtolower(get_class($model_object))."[".$property."]";
		if ($model_object->$property == $value) {
			$options["checked"] = "true";
		}
		
		$th = new TagHelper("input", $options);
		return $th->output();
		
		
		return $str;
	}
	function submit($text = "OK", $options = array()) {
		return FormHelper::submit($text, $options);
	}
}

