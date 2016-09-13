<?
  function get_current_lang() {
    global $lang;
    if (isset($lang) && strlen($lang) == 2)
      return $lang;
    else
      return get_default_lang();
  }
  function get_default_lang() {
    global $default_lang;
    if (isset($default_lang)) {
    	return $default_lang;
    }
    else {
    	return "en";
    }
  }
  function get_url_base($force_lang = null){
    global $auto_multi_lang;
    if (isset($force_lang)) {
    	
      if ($force_lang != get_default_lang())
        return "/".$force_lang;
      else
        return "";
    }
    elseif (get_current_lang() != get_default_lang() && $auto_multi_lang)
      return "/".get_current_lang();
    else
      return "";
  }
	function set_lang($set_lang) {
		//heredada de AC
		global $lang;
		$lang = $set_lang;
	}

  function get_url_homepage(){
    return get_url_base()."/";
  }
  function get_translation($namespace, $name, $vars = array(), $lang = null) {
    eval("global \$lang_".$namespace.";");
    if (!isset($lang))
      $lang = get_current_lang();
  
    eval("\$val = parse_vars(\$lang_".$namespace."['".$name."']['".$lang."'], \$vars);");
    eval("\$val_default_lang = parse_vars(\$lang_".$namespace."['".$name."']['".get_default_lang()."'], \$vars);");
    if (strlen($val)>0) {
      return $val;
    }
    elseif(strlen($val_default_lang)>0) {
      return $val_default_lang;
    }
    elseif (get_env() != "production") {
      return $namespace.":".$name;
    }
    
  }
  function is_translated() {
  	global $langs;
  	return (count($langs) > 1);
  }
 
  function parse_vars($txt, $vars) {
    if ($vars != null)
    foreach ($vars as $name => $value) {
			$txt = str_replace("{".$name."}",$value,$txt);
			$txt = str_replace("{\$".$name."}",$value,$txt);
			$txt = str_replace("%".$name."%",$value,$txt);
    }
    return $txt;
  }
	function parse_tag($txt, $a1, $value = null) {
		if (!is_array($a1)) {
			return parse_vars($txt,array($a1 => $value)); 
		}
		else {
			return parse_vars($txt,$a1); 
		}
	}