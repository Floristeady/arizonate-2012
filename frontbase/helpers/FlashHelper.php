<?
	class FlashHelper {
		
		function as_script($arg, $width = 100, $height = 100) {
			if (is_object($arg)) {
				$path = $arg->getItemLink();
			}
			elseif (strlen($arg)) {
				$path = $arg;
			}
			else {
				return false;
			}
			$div_name = "swfbanner".md5($path);
			// Only works with SWFOBject v1.5!
			$str .= "<div id=\"".$div_name."\"></div>\n";
			$str .= "<script>\n";
			$str .= "var so = new SWFObject('".$path."', 'mymovie', '".$width."', '".$height."', '8', '#336699');\n";
			$str .= "so.addParam('wmode', 'transparent');\n";
			$str .= "so.addParam('menu', 'false');\n";
			$str .= "so.write('".$div_name."');\n";
			$str .= "</script>\n"; 
			return $str;
		
		}
		
	}