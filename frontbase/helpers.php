<?
	function is_frontpage() {
			global $ur;
			return ($ur->controller == "main" && $ur->action== "index");
	}
	function table_exists ($table) { 
		$tables = mysql_query_door("SHOW TABLES"); 
		while ($row = mysql_fetch_array ($tables)) {
			if ($row[0] == $table) {
				return TRUE;
			}
		}
		return FALSE;
	}
	function not_empty($v) {
		if (is_array($v)) {
			if (count($v)>0) {
				return true;
			}
			else {
				return false;
			}
		}
		if (is_object($v)) {
			return true;
		}
		if (strlen($v)>0) {
			return true;
		}
		else {
			return false;
		}
	}
	function is_empty($v) {
		return !not_empty($v);
	}
	function cycle($arg1, $arg2, $arg3 = null) {
		//CASO 1:  cycle ($key, $step, $value_on) 
		if (is_numeric($arg1) && is_numeric($arg2)) {
			$key = $arg1;
			$step = $arg2;
			if (is_null($arg3)) {
				$value = true;
			} 
			else {
				$value = $arg3;
			}
			
			if ($key % $step == 0) {
				return $value;
			}
			else {
				return false;
			}
			
		}
		//CASO 2:  cycle ($key, $array_values) 
		// step = count($array_values);
		if (is_numeric($arg1) && is_array($arg2)) {
			
			$step = count($arg2);
			$key = $arg1;
			
			$value = $arg2[($key % $step)];
			
			return $value;
			
		}

		

	}
	function is_plural($collection) {
		if (count($collection) > 1) {
			return true;
		}
		else {
			return false;	
		}
		
	}
	function bstart() {
		global $btimestart ;
		$btimestart = 0;
		$btimestart = microtime(true);
	}
	function bstop() {
		global $btimestart ;
	
		$btimestop = microtime(true);
		return ($btimestop - $btimestart);
		
		
	}
	
	class HTMLHelper {
	/*
		Evualuar si corresponde deprecar esta clase? Buscar reemplazo
	*/
		static function getIMG($image, $class = null, $width = null, $height = null) {
		
			if (is_object($image)) {	
				$tag = new TagHelper("img");
				$tag->addAt("class",$class );
				$tag->addAt("width", $width);
				$tag->addAt("height", $height);
				$tag->addAt("src",$image->getItemLink($width));
				return $tag->get();
			}
			elseif(strlen($image)>0) {
				$tag = new TagHelper("img");
				$tag->addAt("class",$class );
				$tag->addAt("width", $width);
				$tag->addAt("height", $height);
				$tag->addAt("src",$image);
				return $tag->get();
			}
		}
		static function getLink($item, $class = "") {
			if (is_object($item)) {
				return "<a href='".$item->getItemLink($width)."' class='$class'> ".$item->getPublicName()."</a>";
			}
			else
				return "";
		}
	
	}
	



	class Metatag {
	
			function Metatag($arg1 = array(), $arg2 = null) {
					if (is_array($arg1)) {
						$this->attributes = $arg1;
					}else{
						$this->attributes["http-equiv"] = $arg1;	
						$this->attributes["content"] = $arg2;	
					}
			}
	
			function output() {
					$str = "";
					$str .= "<meta";
					foreach ($this->attributes as $name => $value) {
						$str .= " ".$name."=\"".$value."\"";
					}
					$str .= ">";
					return $str;
				
			}
		
	}
	
	function generate_columns_from_lists($list, $cols = 3) {
		
		$total = count($list);
		if($total % $cols == 0) {
			$items_per_col = $total / $cols;
		}
		else {
			$items_per_col = ((int) ($total/$cols)) + 1;
		}
		$column_index = 0;
		$columns = array();
		while ($element = array_shift($list)) {
			
			if (count($columns[$column_index]) == $items_per_col) {
				$column_index++;
			}
			if (!isset($columns[$column_index])) {
				$columns[$column_index] = array();
				}
			$columns[$column_index][] = $element;
	
		}
		return $columns;
	}
	


	function redirect_to($url){
		header("location: ".$url);
		// GOTCHA: El script continuará su ejecucion
		die();
	}
	function redirect($url) {
		redirect_to($url);
	}
	function link_to($url, $name = null, $options = array()) {
		if (is_null($name)) {
			$name = $url;
		}
		
		foreach ($options as $key => $value) {
			$str .= $key."='".$value."' ";
		}
		
		return "<a href='".$url."' $str>".$name."</a>";
	}
		
/* PORTALPAD P-YADRAN - MOVER A MODULOS?? */
	function link_to_section($section, $class = "", $class_on = "", $current_section = null) {
		if (!is_object($section)) {
			$section = SectionTool::fetch($section);
		}
		if ($section->id == $current_section->id)
			$class = $class_on;
		echo "<a class='$class' href='".$section->getItemLink()."'>".$section->getPublicName()."</a>";
	}
	function title_section($section, $tag = null, $class = "", $class_on = "", $current_section = null) {
		if (!is_object($section)) {
			$section = SectionTool::fetch($section);
		}
		if (isset($current_section)) {
			$p = $current_section->parentByDepth(2);
			if ($p->id == $section->id) {
				$class = $class_on;
			}
		}
		if (isset($tag))
			echo "<$tag class='$class'>";
		echo $section->getPublicName();
		if (isset($tag))
			echo "</$tag>";
					
	
	}
	function link_to_content($content, $class = "", $class_on = "", $current_content = null) {
		if (!is_object($content)) {
			$content = ContentTool::fetch($section);
		}
		if ($content->id == $current_content->id)
			$class = $class_on;
		echo "<a class='$class' href='".$content->getItemLink()."'>".$content->getPublicName()."</a>";
	}


