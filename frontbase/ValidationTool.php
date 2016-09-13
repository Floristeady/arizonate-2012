<?
	class ValidationTool {
		function Validation() {
			$this->errors = array();
		}
		function is_email($str) {
			if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $str)) {
				return false;
			}
			return true;
		}
		function is_number($str) {
			return is_numeric($str);
		}
		function is_iso_date($str) {
			// valida que la fecha sea una fecha válida desde 1-jan-1970 y 31-dec-2037
			if (0 < strtotime($str) && strtotime($str) <  2145852000) {
				return strtotime($str);
			}
			else {
				return false;	
			}
		}
		function run_on_post($rules, $namespace = null) {
			$this->rules = $rules;

			if (!is_null($namespace)) {
				$values = $_POST[$namespace];
			}
			else {
				$values = $_POST;
			}

 			return $this->run($values);
		}
		function setRules($rules) {
			$this->rules = $rules;
		}
		function run($values) {
	 		foreach ($this->rules as $key => $arg) {
	 			$msg = "";
	 			if (is_array($arg)) {
	 				$rule_type = $arg["type"];
	 				$msg = $arg["message"];
	 			}
	 			else {
	 				$rule_type = $arg;
	 			}

	 			if ($rule_type == "required") {
	 				if (!(strlen($values[$key]) > 0)) {

	 					if (not_empty($msg)) {
	 						$this->errors[$key] = $msg;
	 					}
	 					else {
	 						$this->errors[$key] = $key." tiene que ser rellenado";
	 					}
	 				}
	 			}
	 			elseif ($rule_type == "email") {
	 				if (!$this->is_email($values[$key])) {
	 					if (not_empty($msg)) {
	 						$this->errors[$key] = $msg;
	 					}
	 					else {
		 					$msg = $key." tiene que ser un email válido";
		 					if (get_configuration_param("charset") == "UTF-8") {
		 						$msg = utf8_encode($msg);
		 					}
	 						$this->errors[$key] = $msg;
	 					}
	 				}
	 			}
	 		}
	 		if (count($this->errors)>0) {

	 			return false;
	 		}
	 		else {
	 			return true;
	 		}
		}
		function display_errors() {
			if(not_empty($this->errors)) { 
				echo "<div class='errors'>";
				echo "<ul>";
				foreach ($this->errors as $error) {
					echo "<li>".$error."</li>";
				}	
				echo "</ul>";
				echo "</div>";
			}
		}
		function is_chronological($dates, $mode = "NORMAL") {

			// checks that a set of dates are in order
			$last_date = 0;
			foreach ($dates as $date) {
				if (!($date > $last_date)) {
					return false;
				}
				$last_date = $date;
			}
			return true;	
		}

	}
