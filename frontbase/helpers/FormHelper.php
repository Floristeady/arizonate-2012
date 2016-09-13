<?
class FormHelper {

	static function select_helper($list, $name_column = "value", $name = "" , $selected_value = null , $blank = null){
		/*
		DEPRECATE
		Alias para compatibilidad en proyecto AC?
		*/
		echo self::select($name, $list, $name_column = "value", $selected_value, $blank);
	}
	static function select($name, $collection = array(), $name_column = "value", $selected_key = null , $options = array())	{
		$str = "<select name=\"".$name."\" ";
		
		if (is_array($options)) {
			foreach($options as $key => $value) {
				if ($key != "prompt") {
					$str .= " $key=\"".$value."\"";
				}
			}
		}
		
		$str .= ">";
		
		if (isset($options["prompt"])) {
			$str .= "<option value=''>".$options["prompt"]."</option>";
		}
		foreach ($collection as $key => $item)  {
			if (!is_null($selected_key)) {
				$selected = ($selected_key == $item->id)?"selected":"";
			}
			if (is_object($item)) {
				$str .= "<option ".$selected." value='".$item->id."'>".$item->$name_column."</option>";
			}
			else {
				$text = $item;
				if (is_array($item)) {
					$text = $item[$name_column];
				}
				$selected = ($selected_key == $key)?"selected":"";

				$str .= "<option ".$selected." value='".$key."'>".$text."</option>";
			}
		}
		$str .= "</select>";
		return $str;
	}
	static function select_year_helper($name = "", $init_year = 1900, $end_year = null , $selected_value = null , $blank = null) {
		/*
		DEPRECATE
		Alias para compatibilidad en proyecto AC?
		*/
		$str = "<select name=\"".$name."\">";
		if (isset($blank)) {
			$str .= "<option>".$blank."</option>";
		}
		if(!isset($end_year))
			$end_year = date('Y');
		for ($year = $init_year; $year <= $end_year ;$year++)  {
			$selected = ($selected_value == $year)?"selected":"";
			$str .= "<option ".$selected." value='".$year."'>".$year."</option>";
		}
		$str .= "</select>";
		echo $str;
	}
	static function check($name, $current_value = null, $checked_value = 1, $options = array()) {
		/* 
			Experimental
			TODO: Implementar checked value 
		*/
		$checked_attribute = "";
		if ($current_value == $checked_value) {
			$checked_attribute = "checked";
		}
		
		foreach($options as $key => $value) {
			$extra_attributes .= " $key=\"".$value."\"";
		}
		
		$str .= "<input $checked_attribute 
				type=\"checkbox\" 
				name=\"".$name."\" 
				value=\"".$checked_value."\"
				$extra_attributes
				>";
		return $str;
	}
	static function submit($text = "OK", $options = array()) {
		$options["type"] = "submit";
		$options["value"] = $text;
		$th = new TagHelper("input", $options);
		return $th->output();
	}
	
	static function checklist($name, $collection, $name_property = "name", $selected_items = array(), $options = array()) {

		$str = "";
		
		$selected_ids = array();
		if (is_array($selected_items)) {
			foreach ($selected_items as $checked_item)  {
				$selected_ids[] = $checked_item->id;
			}
		}
		
		foreach($collection as $item) {
			$checked = false;
			if (in_array($item->id, $selected_ids)) {
				$checked = true;
			}
			$checked_attribute = ($checked )?"checked":"";

			$str .= "<div class='checkitem'><input $checked_attribute type=\"checkbox\" name=\"".$name."\" value=\"".$item->id."\">".$item->$name_property."</div>";
		}
		return $str;
	}
	static function text($name, $value = "", $options = array()) {
		$options["value"] = $value;
		$options["name"] = $name;
		$th = new TagHelper("input", $options);
		return $th->output();
	
	} 
	static function textarea($name, $value = "", $options = array()) {
		$options["name"] = $name;
		$th = new TagHelper("textarea", $options);
		$th->setContent($value);
		return $th->output();
	
	} 
	static function password($name, $value = "", $options = array()) {
		$options["name"] = $name;
		$options["type"] = "password";
		$th = new TagHelper("input", $options);
		return $th->output();
	
	}
	static function radio($name, $collection, $name_property = "name", $selected = null) {
		
		foreach ($collection as $key => $option) {
			$value = $key;
			$selected_attribute = "";
			if ($value ==  $selected) {
				$selected_attribute = "checked='true'";
			}
			$str .= "<div class='radiooption'><input type='radio' $selected_attribute name='$name' value='$value'>".$option."</div>";
		}
		
		return $str;
	}
	function date_select($name, $value = null, $options = null ) {
		/*
			DateSelectHelper para liberarse de javascript
			TODO: Llevar a FormHelper
		*/
		if ($value != null) 
			$date = $value;
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
		$str .= FormHelper::select($name."[d]",$days,null,date('j',$date),$options);
		$str .= FormHelper::select($name."[m]",DateHelper::getMonths(),"es",date('n',$date), $options);

		$years = array();
		foreach (range($from_year,$to_year) as $year) {
			$years[$year] = $year;
		} 
		$str .= FormHelper::select($name."[y]",$years,null,date('Y',$date), $options);
		return $str;
		
	}
	function datetime_select($name, $current_value = null, $options = null ) {
		if (!is_null($current_value)) {
			$date = $current_value;
		}
		else {
			$date = mktime();
		}

		$str = self::date_select($name, $date, $date, $options);
		$hours = range(0,23);
		$str .= FormHelper::select($name."[H]", $hours,null,date('H',$date), $options);
		
		$hours = range(0,59);
		$str .= FormHelper::select($name."[i]", $hours,null,date('i',$date), $options);

		return $str;
	}
	function time_select() {}
}