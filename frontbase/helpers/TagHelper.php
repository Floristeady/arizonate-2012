<?
	class TagHelper {
		function TagHelper($str, $attributes = array()) {
			$this->name = $str;	
			$this->attributes = $attributes;
		}
		function addAt($name, $value = null){
			if (!is_null($value) && strlen($value) > 0)
				$this->attributes[$name] = $value;
		}
		function get() {
			return $this->output();
		}
		function setContent($content) {
			$this->content = $content;
		}
		function output() {
			$str = "<".$this->name;
			foreach ($this->attributes as $key => $value) {
				$str .= " ".$key."='".$value."'";
			}
			$str .= ">";

			if (isset($this->content)) {
				$str .= $this->content."</".$this->name.">";	
			}
			elseif ($this->name == "textarea")  {
				$str .= "</textarea>";	
			}
			
			return $str;
		}
	}