<?
if(get_configuration_param("logging_level") > 0) {
	require_once('lib/FirePHP/FirePHP.class.php');
	require_once('lib/FirePHP/fb.php');

	$options = array('maxObjectDepth' => 10,
	                 'maxArrayDepth' => 20,
	                 'useNativeJsonEncode' => true,
	                 'includeLineNumbers' => true);
	FB::setOptions($options);
	ob_start(); 
}
function log_file($msg, $data = null) {
	$log_file = $_SERVER["DOCUMENT_ROOT"]."/log.txt";
	$fh = fopen($log_file, 'a');
	
	$stringData = $msg."\n";
	if (!is_null($data))
		$stringData .="\tdata:".var_export($data,true)."\n";
	fwrite($fh, $stringData);
	
	fclose($fh);

}



class Logger {
	static function benchmark($action, $time) {
		
		if(get_configuration_param("logging_level") >= 4 && is_found()) {
			if (get_configuration_param("logging_type") == "FB") {
				FB::log($action, "t: ".$time);
			}
			else {
					
			}
				
		}
	}
	static function debug($msg, $data = null, $class = null) {
		if(get_configuration_param("logging_level") >= 4 && is_found()) {
			FB::log($data, $msg);
		}
	}
	static function info($msg, $data = null, $class = null) {
		if(get_configuration_param("logging_level") >= 3 && is_found()) {
			if (get_configuration_param("logging_type") == "FB") {
				if (!is_null($data))
					FB::info( $data, $msg);
				else
					FB::info($msg);
			}
			else {
				log_file("[INFO] ".$msg,$data);
			}
		}
	}
	static function warn($msg, $data = null, $class = null) {
		$new = debug_backtrace();
		//echo $new[1]["function"];
		if(get_configuration_param("logging_level") >= 2 && is_found()) {
			if (get_configuration_param("logging_type") == "FB") {
				if (!is_null($data))
					FB::warn($data, $msg);
				else
					FB::warn($msg);
			}
			else {
				log_file("[WARN] ".$msg,$data);
			}
		}
	}
	static function error($msg, $data = null, $class = null){
		if(get_configuration_param("logging_level") >= 1 && is_found()) {
			if (get_configuration_param("logging_type") == "FB") {
				FB::error($msg);
				if (!is_null($data))
					FB::log($data, "with");
				FB::trace('Trace Label');
			}
			else {
				log_file("[ERROR] ". $msg,$data);
			}
		}
	}
	static function fatal($msg, $data = null, $class = null) {
		if(get_configuration_param("logging_level") >= 1 && is_found()) {

			FB::error($msg);
			if (!is_null($data))
				FB::log($data, "with");
		}
	}


}